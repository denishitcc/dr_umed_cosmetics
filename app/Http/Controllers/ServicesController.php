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
        $distinctParentCategories = Category::where('parent_category', '(top-level)')->get();

        // Fetch all categories for display
        $list_cat = Category::get();

        //services
        $list_service = Services::get();
        // dd($list_service);

        //locations
        $locations = Locations::get();
        return view('services.index', compact('list_cat', 'distinctParentCategories','list_service','locations'));
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
        return view('services.create',compact('list_cat','locations','services','users'));
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
                if ($request->has('locations') && is_array($request->locations) && in_array($in->location_name, $request->locations)) {
                    $final_array[] = ['service_id' => $newService->id,'category_id' => $request->parent_category,'location_name' => $in->location_name,'availability'=>'Available'];
                } else {
                    $final_array[] = ['service_id' => $newService->id,'category_id' => $request->parent_category,'location_name' => $in->location_name,'availability'=>'Not available'];
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
        return view('services.edit',compact('list_cat','locations','services','service_availability','all_services','users'));
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
                if ($request->has('locations') && is_array($request->locations) && in_array($in->location_name, $request->locations)) {
                    $final_array[] = ['service_id' => $editService->id,'category_id' => $request->parent_category,'location_name' => $in->location_name,'availability'=>'Available'];
                } else {
                    $final_array[] = ['service_id' => $editService->id,'category_id' => $request->parent_category,'location_name' => $in->location_name,'availability'=>'Not available'];
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
        if($request->categories == 'All Services & Tasks')
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
}
