<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Locations;
use App\Models\Services;
use App\Models\ServicesAvailability;
use App\Models\User;
use App\Models\ServicesAppearOnCalendar;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all distinct parent categories
        $categories = Category::with([
            'children'
        ])->whereNull('parent_category')->get();

        // Fetch all categories for display
        $list_cat = Category::get();

        $list_parent_cat = Category::where('parent_category','0')->get();
        //services
        $list_service = Services::get();

        //locations
        $locations = Locations::get();
        return view('services.index', compact('list_cat','list_service','locations','list_parent_cat','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all categories for display
        $list_cat = Category::get();
        $locations = Locations::get();
        $services = Services::get();
        $users = User::get();
        $list_parent_cat = Category::whereNull('parent_category')->get();
        return view('services.create',compact('list_cat','locations','services','users','list_parent_cat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $newService = Services::create([
            'service_name' => $request->service_name,
            'parent_category' => $request->parent_category,
            'gender_specific' => $request->gender_specific,
            'code' => $request->code,
            'appear_on_calendar' => $request->appear_on_calendar,
            'standard_price' => $request->standard_price,
        ]);
        if($newService){
            //store appear on calendar data
            $newCalendar = ServicesAppearOnCalendar::create([
                'service_id' => $newService->id,
                'duration' => $request->duration,
                'processing_time' => $request->processing_time,
                'fast_duration' => $request->fast_duration,
                'slow_duration' => $request->slow_duration,
                'usual_next_service' => $request->usual_next_service,
                'dont_include_reports' => $request->dont_include_reports,
                'technical_service' => $request->technical_service,
                'available_on_online_booking' => $request->available_on_online_booking,
                'require_a_room' => $request->require_a_room,
                'unpaid_time' => $request->unpaid_time,
                'require_a_follow_on_service' => $request->require_a_follow_on_service,
                'follow_on_services' => $request->has('follow_on_services') ? implode(',', $request->follow_on_services) : null,
            ]);

            //store availabilty data
            $locations_data = Locations::get();
            $final_array = [];
            //for check locations in locations table and locations in locations checked values
            foreach ($locations_data as $index => $in) {
                if ($request->has('locations') && is_array($request->locations) && in_array($in->id, $request->locations)) {
                    $final_array[] = ['service_id' => $newService->id,'category_id' => $request->parent_category,'location_name' => $in->id,'availability'=>'Available'];
                } else {
                    $final_array[] = ['service_id' => $newService->id,'category_id' => $request->parent_category,'location_name' => $in->id,'availability'=>'Not available'];
                }
            }
            ServicesAvailability::insert($final_array);
            $response = [
                'success' => true,
                'message' => 'Service Created successfully!',
                'type' => 'success',
                'data_id' => $newService->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $list_cat = Category::get();
        $list_parent_cat = Category::whereNull('parent_category')->get();
        $locations = Locations::get();
        // $services = Services::where('id',$id)->first();
        // $services = Services::join('services_appear_on_calendars', 'services.id', '=', 'services_appear_on_calendars.service_id')
        //     ->where('services.id',$id)
        //     ->first();
        $services = Services::leftJoin('services_appear_on_calendars', 'services.id', '=', 'services_appear_on_calendars.service_id')
        ->select('services.*', 'services_appear_on_calendars.duration','services_appear_on_calendars.processing_time','services_appear_on_calendars.fast_duration',
        'services_appear_on_calendars.slow_duration','services_appear_on_calendars.usual_next_service','services_appear_on_calendars.dont_include_reports',
        'services_appear_on_calendars.technical_service','services_appear_on_calendars.available_on_online_booking','services_appear_on_calendars.require_a_room',
        'services_appear_on_calendars.unpaid_time','services_appear_on_calendars.require_a_follow_on_service','services_appear_on_calendars.follow_on_services',
        'services_appear_on_calendars.deleted_at')
        // ->whereNull('services.deleted_at') // Changed this line
        ->where('services.id',$id)
        ->first();
        // dd($services);
        $service_availability =ServicesAvailability::where('service_id',$id)->get();
        $all_services = Services::get();
        // dd($all_services);
        $users = User::get();
        return view('services.edit',compact('list_cat','locations','services','service_availability','all_services','users','list_parent_cat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $editService = Services::updateOrCreate(['id' => $id],[
            'service_name' => $request->service_name,
            'parent_category' => $request->parent_category,
            'gender_specific' => $request->gender_specific,
            'code' => $request->code,
            'appear_on_calendar' => $request->appear_on_calendar,
            'standard_price' => $request->standard_price,
        ]);
        if($editService){
            //update appear on calendar data
            if($request->appear_on_calendar == '0')
            {
                $cal = ServicesAppearOnCalendar::where('service_id',$id)->first();
                if ($cal) {
                    $cal->delete();
                }
            }
            else{
                $newCalendar = ServicesAppearOnCalendar::updateOrCreate(['service_id' => $id],[
                    // 'service_id' => $newService->id,
                    'duration' => $request->duration,
                    'processing_time' => $request->processing_time,
                    'fast_duration' => $request->fast_duration,
                    'slow_duration' => $request->slow_duration,
                    'usual_next_service' => $request->usual_next_service,
                    'dont_include_reports' => $request->dont_include_reports,
                    'technical_service' => $request->technical_service,
                    'available_on_online_booking' => $request->available_on_online_booking,
                    'require_a_room' => $request->require_a_room,
                    'unpaid_time' => $request->unpaid_time,
                    'require_a_follow_on_service' => $request->require_a_follow_on_service,
                    'follow_on_services' => $request->has('follow_on_services') ? implode(',', $request->follow_on_services) : null,
                ]);
            }
            
            //store availabilty data
            $locations_data = Locations::get();
            $final_array = [];
            //for check locations in locations table and locations in locations checked values
            foreach ($locations_data as $index => $in) {
                if ($request->has('locations') && is_array($request->locations) && in_array($in->id, $request->locations)) {
                    $final_array[] = ['service_id' => $editService->id,'category_id' => $request->parent_category,'location_name' => $in->id,'availability'=>'Available'];
                } else {
                    $final_array[] = ['service_id' => $editService->id,'category_id' => $request->parent_category,'location_name' => $in->id,'availability'=>'Not available'];
                }
            }
            // Prepare data for update
            $updateData = [];

            foreach ($final_array as $item) {
                $updateData[] = [
                    'service_id' => $item['service_id'],
                    'category_id' => $item['category_id'], // You commented this line out
                    'location_name' => $item['location_name'],
                    'availability' => $item['availability'],
                ];
            }
            foreach ($updateData as $data) {
                ServicesAvailability::updateOrCreate(
                    ['service_id' => $id, 'location_name' => $data['location_name'],'category_id' => $data['category_id']],
                    ['availability' => $data['availability']]
                );
            }

            $response = [
                'success' => true,
                'message' => 'Service Updated successfully!',
                'type' => 'success',
                'data_id' => $editService->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function store_category(Request $request)
    {
        // dd($request->all());
        $newCategory = Category::create([
            'category_name' => $request->category_name,
            'parent_category' => $request->parent_category,
            'show_business_summary' => $request->show_business_summary ?? 0,
            'trigger_when_sold' => $request->trigger_when_sold ?? 0
        ]);
        if($newCategory){

            $response = [
                'success' => true,
                'message' => 'Category Created successfully!',
                'type' => 'success',
                'data_id' => $newCategory->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function update_category(Request $request)
    {
        // dd($request->all());
        $updateCategory = Category::updateOrCreate(['id' => $request->cat_hdn_id],[
            'category_name' => $request->category_name,
            'parent_category' => $request->parent_category,
            'show_business_summary' => $request->show_business_summary ?? 0,
            'trigger_when_sold' => $request->trigger_when_sold ?? 0
        ]);
        if($updateCategory){

            $response = [
                'success' => true,
                'message' => 'Category Updated successfully!',
                'type' => 'success',
                'data_id' => $updateCategory->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function get_services(Request $request)
    {
        // dd($request->all());
        if($request->categories == 'All Services & Tasks' && $request->search != '')
        {
            // $list_services = Services::get();
            $list_services = Services::leftJoin('services_appear_on_calendars', 'services.id', '=', 'services_appear_on_calendars.service_id')
            ->select('services.*', 'services_appear_on_calendars.duration')
            ->where('services.service_name', 'like', '%' . $request->search . '%')
            ->get();
        }
        else if($request->categories == 'All Services & Tasks')
        {
            // $list_services = Services::get();
            $list_services = Services::leftJoin('services_appear_on_calendars', 'services.id', '=', 'services_appear_on_calendars.service_id')
            ->select('services.*', 'services_appear_on_calendars.duration')
            ->get();
        }
        else
        {
            // $list_services = Services::where('parent_category',$request->categories)->get();
            $list_services = Services::leftJoin('services_appear_on_calendars', 'services.id', '=', 'services_appear_on_calendars.service_id')
            ->select('services.*', 'services_appear_on_calendars.duration')
            ->where('services.parent_category',$request->categories)
            ->get();
        }
        // dd($list_services);
        if($list_services){

            $response = [
                'success' => true,
                'message' => 'Services List successfully!',
                'type' => 'success',
                'data' => $list_services
                // 'data_id' => $list_services->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function change_services_availability(Request $request)
    {
        // Retrieve the existing availability records
        $availability = ServicesAvailability::where('category_id', $request->hdn_cat_id)->get();
        // Loop through the form data and update the status for each location
        foreach ($request->locs_name as $i => $locName) {
            $selectedStatus = $request->input("availability$i");
            if($selectedStatus !='(no change)')
            {
                // Find the corresponding availability record for the current location
                $availability_data = $availability->Where('location_name', $locName);
                foreach($availability_data as $ava)
                {
                    // Update the status only if the record is found
                    if ($ava) {
                        $ava->update(['availability' => $selectedStatus]);
                    }
                }
            }

        }
        if($availability){

            $response = [
                'success' => true,
                'message' => 'Availibility updated successfully!',
                'type' => 'success',
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function checkCategoryName(Request $request){
        // dd($request->all());
        if($request->page_type=='create')
        {
            $category_name = $request->input('category_name');
                $isExists = Category::where('category_name',$category_name)->first();
                if($isExists){
                    return response()->json(array("exists" => true));
                }else{
                    return response()->json(array("exists" => false));
                }
        }else{
            $category_name = $request->input('category_name');
            $current_id = $request->input('category_id');

            $isExists = Category::where('category_name', $category_name)
                                ->where('id', '!=', $current_id)
                                ->exists();

            if ($isExists) {
                return response()->json(["exists" => true]);
            } else {
                return response()->json(["exists" => false]);
            }

        }
    }
    public function checkServiceName(Request $request){
        if($request->type == 'create'){
            $service_name = $request->input('service_name');
            $isExists = Services::where('service_name',$service_name)->first();
            if($isExists){
                return response()->json(array("exists" => true));
            }else{
                return response()->json(array("exists" => false));
            }
        }else{
            $service_name = $request->input('service_name');
            $current_id = $request->input('service_id');
            $isExists = Services::where('service_name', $service_name)
                                ->where('id', '!=', $current_id)
                                ->exists();

            if ($isExists) {
                return response()->json(["exists" => true]);
            } else {
                return response()->json(["exists" => false]);
            }
        }
    }
    public function import(Request $request) {
        $errors = []; // Track errors
        $dataToInsert = []; // Store data to be inserted
        
        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            // Remove the header row if present
            if (count($data) > 0 && isset($data[0]) && is_array($data[0])) {
                array_shift($data);
            }
            // Check if CSV is empty
            if (empty($data)) {
                return response()->json([
                    'error' => true,
                    'message' => 'The CSV file is empty.',
                    'type' => 'error',
                ]);
            }
            $maxFilesAllowed = 50;
            $uploadedFilesCount = count($data);
            if ($uploadedFilesCount > $maxFilesAllowed) {
                return response()->json([
                    'error' => true,
                    'message' => 'You can upload a maximum of ' . $maxFilesAllowed . ' files.',
                    'type' => 'error',
                ]);
            }
            $service_data = Services::pluck('service_name', 'id')->toArray();
    
            foreach ($data as $rowIndex => $row) {
                $rowErrors = []; // Track errors for this specific row
                
                // Initialize locationsInRow array
                $locationsInRow = [];
                
                // Check if service name is empty
                if (empty($row[0])) {
                    $rowErrors[] = 'Service name is required.';
                } else {
                    // Check if service name already exists
                    if (in_array($row[0], $service_data)) {
                        $rowErrors[] = 'Service with name "' . $row[0] . '" already exists.';
                    }
                }
                
                // If there are errors with this row, add them to the general errors array
                if (!empty($rowErrors)) {
                    $errors[] = [
                        'row' => $rowIndex + 1,
                        'fields' => $rowErrors,
                    ];
                    // Skip processing this row
                    continue;
                }
                
                // Initialize category to null
                $category = null;
                
                // Check if parent category is empty
                if (empty($row[1])) {
                    $rowErrors[] = 'Parent category is required.';
                } else {
                    // Check if parent category exists
                    $category = Category::where('category_name', $row[1])->first();
                    if (!$category) {
                        $rowErrors[] = 'Parent category "' . $row[1] . '" does not exist.';
                    }
                }
                
                // Check if gender specific is empty
                if (empty($row[2])) {
                    $rowErrors[] = 'Gender specific is required.';
                }

                // Check if duration is empty
                if (empty($row[5])) {
                    $rowErrors[] = 'Duration is required.';
                }

                // Check if follow-on services exist and get their IDs
                $follow_on_service_ids = [];
                if (!empty($row[16])) {
                    $follow_on_services = explode(',', $row[16]);
                    foreach ($follow_on_services as $follow_on_service_name) {
                        $service = Services::where('service_name', $follow_on_service_name)->first();
                        if (!$service) {
                            $rowErrors[] = 'Follow-on service "' . $follow_on_service_name . '" does not exist.';
                        } else {
                            $follow_on_service_ids[] = $service->id;
                        }
                    }                    
                }
    
                // Check if usual next service exists
                $usual_next_service = Services::where('service_name', $row[9])->first();
                if (!$usual_next_service && !empty($row[9])) {
                    $rowErrors[] = 'Usual next service "' . $row[9] . '" does not exist.';
                }
                
                // Get all locations
                $locations = Locations::all();
    
                // Initialize availability data array
                $availabilityData = [];
    
                // Iterate over all locations and add availability data
                foreach ($locations as $location) {
                    // Check if the location name exists in row[18]
                    if (!empty($row[18])) {
                        $locationsInRow = explode(',', $row[18]);
                        foreach ($locationsInRow as $locationName) {
                            // Check if the location name exists in the locations table
                            if ($locationName === $location->location_name) {
                                // Location found, set availability to 'Available'
                                $availability = [
                                    'service_name' => $row[0],
                                    'category_id' => $category ? $category->id : null,
                                    'location_id' => $location->id,
                                    'availability' => 'Available',
                                ];
                                // Add availability data to the array
                                $availabilityData[] = $availability;
                            }
                        }
                    } else {
                        // If row[18] is empty, default availability to 'Not available'
                        $availability = [
                            'service_name' => $row[0],
                            'category_id' => $category ? $category->id : null,
                            'location_id' => $location->id,
                            'availability' => 'Not available',
                        ];
                        // Add availability data to the array
                        $availabilityData[] = $availability;
                    }
                }
                
                // Check if any value in row[18] doesn't match any location name
                foreach ($locationsInRow as $locationName) {
                    $locationExists = false;
                    foreach ($locations as $location) {
                        if ($locationName === $location->location_name) {
                            $locationExists = true;
                            break;
                        }
                    }
                    if (!$locationExists) {
                        // Add error message if location doesn't exist
                        $rowErrors[] = 'Location "' . $locationName . '" does not exist.';
                    }
                }                

                if (!empty($rowErrors)) {
                    $errors[] = [
                        'row' => $rowIndex + 1,
                        'fields' => $rowErrors,
                    ];
                } else {
                    // Store data for insertion
                    $dataToInsert[] = [
                        'service_name' => $row[0],
                        'parent_category' => $category->id,
                        'gender_specific' => $row[2],
                        'code' => $row[3],
                        'appear_on_calendar' => $row[4]==""?'1':$row[4],
                        'standard_price' => $row[17],
                        'duration' => $row[5],
                        'processing_time' => $row[6],
                        'fast_duration' => $row[7],
                        'slow_duration' => $row[8],
                        'usual_next_service' => $usual_next_service ? $usual_next_service->id : null,
                        'dont_include_reports' => $row[10] == "" ? 0 : $row[10],
                        'technical_service' => $row[11] == "" ? 0 : $row[11],
                        'available_on_online_booking' => $row[12] == "" ? 1 : $row[12],
                        'require_a_room' => $row[13] == "" ? 0 : $row[13],
                        'unpaid_time' => $row[14] == "" ? 0 : $row[14],
                        'require_a_follow_on_service' => $row[15] == "" ? 0 : $row[15],
                        'follow_on_services' => implode(',', $follow_on_service_ids),
                    ];
                }
            }
    
            // If there are no errors, insert the data
            if (empty($errors)) {
                foreach ($dataToInsert as $rowData) {
                    $service = Services::create([
                        'service_name' => $rowData['service_name'],
                        'parent_category' => $rowData['parent_category'],
                        'gender_specific' => $rowData['gender_specific'],
                        'code' => $rowData['code'],
                        'appear_on_calendar' => $rowData['appear_on_calendar'],
                        'standard_price' => $rowData['standard_price'],
                    ]);
    
                    ServicesAppearOnCalendar::create([
                        'service_id' => $service->id,
                        'duration' => $rowData['duration'],
                        'processing_time' => $rowData['processing_time'],
                        'fast_duration' => $rowData['fast_duration'],
                        'slow_duration' => $rowData['slow_duration'],
                        'usual_next_service' => $rowData['usual_next_service'],
                        'dont_include_reports' => $rowData['dont_include_reports'],
                        'technical_service' => $rowData['technical_service'],
                        'available_on_online_booking' => $rowData['available_on_online_booking'],
                        'require_a_room' => $rowData['require_a_room'],
                        'unpaid_time' => $rowData['unpaid_time'],
                        'require_a_follow_on_service' => $rowData['require_a_follow_on_service'],
                        'follow_on_services' => $rowData['follow_on_services'],
                    ]);

                    // Store availability data
                    foreach ($availabilityData as $availability) {
                        ServicesAvailability::create([
                            'service_id' => $service->id,
                            'category_id' => $availability['category_id'],
                            'location_name' => $availability['location_id'],
                            'availability' => $availability['availability'],
                        ]);
                    }
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'CSV data imported successfully!',
                    'type' => 'success',
                ]);
            }
        } else {
            $errors[] = 'No CSV file selected.';
        }
        
        // Constructing error messages for specific errors
        $errorMsg = '';
        foreach ($errors as $error) {
            foreach ($error['fields'] as $fieldError) {
                $errorMsg .= 'Row ' . $error['row'] . ': ' . $fieldError . ' ';
            }
        }
        
        // If errors were found, return error response with specific error message
        return response()->json([
            'error' => true,
            'message' => 'Errors occurred while importing CSV data. ' . $errorMsg,
            'type' => 'error',
        ]);
    }                 
}
