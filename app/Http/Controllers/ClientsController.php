<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Clients;
use App\Models\ClientsPhotos;
use App\Models\ClientsDocuments;
use App\Models\Locations;
use App\Models\Appointment;
use App\Models\AppointmentForms;
use App\Models\Category;
use App\Models\Services;
use App\Models\User;
use App\Models\Permissions;
use DB;
use Carbon\Carbon;
use Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check permissions for accessing the index page
        $permission = \Auth::user()->checkPermission('clients');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $clients = Clients::all();
            if ($request->ajax()) {
                $currentDateTime = now()->timezone('Asia/Kolkata')->format('Y-m-d H:i:s');
                
                $data = Clients::leftJoin('appointment', function($join) use ($currentDateTime) {
                        $join->on('clients.id', '=', 'appointment.client_id')
                            ->where('appointment.start_date', '>=', $currentDateTime);
                    })
                    ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
                    ->leftJoin('users', 'appointment.staff_id', '=', 'users.id')
                    ->leftJoin('locations', 'users.staff_member_location', '=', 'locations.id')
                    ->leftJoin('appointments_notes', 'appointments_notes.appointment_id', '=', 'appointment.id')
                    ->select('clients.id', 
                            'clients.firstname', 
                            'clients.lastname', 
                            'clients.email', 
                            'clients.mobile_number', 
                            'clients.status', 
                            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(appointment.start_date, "%d-%m-%Y %h:%i %p"), "", services.service_name, " with ", CONCAT(users.first_name, " ", users.last_name))) as appointment_dates'),
                            DB::raw('GROUP_CONCAT(CASE appointment.status 
                                WHEN 1 THEN "Booked" 
                                WHEN 2 THEN "Confirmed"
                                WHEN 3 THEN "Started" 
                                WHEN 4 THEN "Completed"
                                WHEN 5 THEN "No answer" 
                                WHEN 6 THEN "Left message"
                                WHEN 7 THEN "Pencilied in" 
                                WHEN 8 THEN "Turned up"
                                WHEN 9 THEN "No show" 
                                WHEN 10 THEN "Cancelled"
                            END) as app_status'),
                            DB::raw('GROUP_CONCAT(users.staff_member_location) as staff_member_location'),
                            DB::raw('GROUP_CONCAT(DISTINCT appointments_notes.common_notes SEPARATOR ",") as common_notes'),
                            DB::raw('GROUP_CONCAT(DISTINCT appointments_notes.treatment_notes SEPARATOR ",") as treatment_notes')
                    )
                    ->groupBy('clients.id', 
                            'clients.firstname', 
                            'clients.lastname', 
                            'clients.email', 
                            'clients.mobile_number', 
                            'clients.status'
                    )
                    ->get();
                foreach($data as $datas){
                    $loc= explode(',',$datas->staff_member_location);
                    $locationsArray = [];
                    foreach($loc as $locs){
                        $locations = Locations::where('id', $locs)->pluck('location_name')->toArray();
                        $locationsArray[] = implode(", ", $locations);
                    }
                    $datas->staff_location = implode(", ", $locationsArray);
                }
                return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('autoId', function ($row) {
                        $lastuserId = $row->id;
                        $lastIncreament = substr($lastuserId, -3);
                        $newUserId = str_pad($lastIncreament, 3, 0, STR_PAD_LEFT);
                        $row->autoId = $newUserId;
                        return $row->autoId;
                    })
                    ->addColumn('username', function ($row) {
                        return $row->firstname.' '.$row->lastname;
                    })
                    ->addColumn('date_and_time', function ($row) {
                        return date('d/m/Y  H:i:s', strtotime($row->created_at));
                    })
                    ->addColumn('addresses', function ($row) {
                        return $row->street_address.', '.$row->suburb. ', '.$row->city.', '.$row->postcode;
                    })
                    // ->addColumn('staff_location', function ($row) {
                    //     $loc_id = explode(',', $row->staff_member_location);
                    //     $locations = Locations::whereIn('id', $loc_id)->pluck('location_name')->toArray();
                    //     return implode(',', $locations);
                    // })
                    
                    ->addColumn('status_bar', function($row){
                        if($row->status == 'active')
                        {
                            $row->status_bar = 'checked';
                        }
                        return $row->status_bar;
                    })
                    ->make(true);

            }
            $today = Carbon::today()->toDateString(); // Get today's date in 'Y-m-d' format

            //count today appointment 
            $count_today_appointments = Appointment::whereDate('start_date', $today)
            ->join('clients', 'clients.id', '=', 'appointment.client_id')
            ->select('clients.id', 'clients.firstname', 'clients.lastname', 'appointment.start_date', 'appointment.end_date')
            ->get();

            $categories = Category::get();

            $services   = Services::with(['appearoncalender'])
                        ->where('appear_on_calendar',1)
                        ->get();
            $users = User::all();
            return view('clients.index', compact('clients','count_today_appointments','categories','services','users','permission'));
        } else {
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = \Auth::user()->checkPermission('clients');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            //locations
            $location = Locations::get();
            return view('clients.create',compact('location'));
        } else {
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newUser = Clients::create([
            'location_id'=>isset($request['location_name'])?$request['location_name']:$request['appointmentlocationId'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'date_of_birth' => $request['date_of_birth'],
            'gender' => $request['gender'],
            'mobile_number' => $request->phone_type == 'Mobile' ? $request->phone : $request['mobile_number'],
            'home_phone' => $request->phone_type == 'Home' ? $request->phone : $request['home_phone'],
            'work_phone' => $request->phone_type == 'Work' ? $request->phone : $request['work_phone'],
            'contact_method' => $request['contact_method'],
            'send_promotions' => $request['send_promotions'],
            'street_address' => $request['street_address'],
            'suburb' => $request['suburb'],
            'city' => $request['city'],
            'postcode' => $request['postcode']
        ]);
        
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                $folderPath = storage_path('app/public/images/clients_photos/');
                $image_parts = explode(";base64,", $pics);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $photo = ClientsPhotos::create([
                    'client_id' => $newUser->id,
                    'client_photos' => $uniqid . '.' . $image_type
                ]);
            }
        }
        if (isset($request->docs)) {
            foreach ($request->docs as $docs) {
                $folderPath = storage_path('app/public/images/clients_documents/');
                $image_parts = explode(";base64,", $docs);
                $image_type_aux = explode("/", $image_parts[0]);
                // Determine file extension based on MIME type
                if ($image_type_aux[0] === "data:image") {
                    $image_type = $image_type_aux[1];
                } else if ($image_type_aux[0] === "data:application" && $image_type_aux[1] === "pdf") {
                    $image_type = "pdf";
                } else if ($image_type_aux[0] === "data:application" && $image_type_aux[1] === "vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                    $image_type = "xlsx";
                } else if ($image_type_aux[0] === "data:application" && $image_type_aux[1] === "msword") {
                    $image_type = "doc";
                } else {
                    // Unsupported file type
                    continue;
                }

                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $photo = ClientsDocuments::create([
                    'client_id' => $newUser->id,
                    'client_documents' => $uniqid . '.' . $image_type
                ]);
            }
        }

        $response = [
            'success' => true,
            'message' => 'Client Created successfully!',
            'type' => 'success',
            'data' => $newUser
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Check permissions for showing a client
        $permission = \Auth::user()->checkPermission('clients');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            $client             = Clients::where('id',$id)->first();
            $client_photos      = $client->photos;
            $client_documents   = ClientsDocuments::where('client_id',$client->id)->get();
            $todayDate          = Carbon::today()->toDateTimeString();

            $futureappointments = $client->allappointments()->where('created_at','>=', $todayDate)->orderby('created_at','desc')->get();
            $pastappointments   = $client->allappointments()->where('created_at','<=', $todayDate)->orderby('created_at','desc')->get();

            $allappointments    = $client->allAppointments()->pluck('id');
            $allformscount      = AppointmentForms::whereIn('appointment_id', $allappointments)->count();
            $allforms           = AppointmentForms::whereIn('appointment_id', $allappointments)->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d M Y');
            });
            // dd($allforms);
            $location = Locations::get();
            return view('clients.edit',compact('client','client_photos','client_documents','futureappointments','pastappointments','location','allformscount','allforms'));
        } else {
            abort(403, 'You are not authorized to access this page.');
        }
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
        $newUser = Clients::updateOrCreate(['id' => $request->id],[
            'location_id'=>$request['location_name'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            // 'email' => $request['email'],
            'date_of_birth' => $request['date_of_birth'],
            'gender' => $request['gender'],
            'mobile_number' => $request['mobile_number'],
            'home_phone' => $request['home_phone'],
            'work_phone' => $request['work_phone'],
            'contact_method' => $request['contact_method'],
            'send_promotions' => $request['send_promotions'],
            'street_address' => $request['street_address'],
            'suburb' => $request['suburb'],
            'city' => $request['city'],
            'postcode' => $request['postcode']
        ]);
        $response = [
            'success' => true,
            'message' => 'Client Updated successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function checkClientEmail(Request $request){
        $email = $request->input('email');
        $isExists = Clients::where('email',$email)->first();
        if($isExists){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }
    public function updateStatus(Request $request){
        $chk = $request->input('chk');
        if($chk == 'checked')
        {
            $status= 'deactive';
        }
        else
        {
            $status='active';
        }
        $id = $request->input('id');
        $isExists = Clients::where('id',$id)->first();
        if($isExists){
            $newUser = Clients::where('id',$id)->update(['status'=>$status]);
        }
        if($newUser){
            $response = [
                'success' => true,
                'message' => 'Client Status Updated successfully!',
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
    public function updatePhotos(Request $request)
    {
        $ids = array();
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                $file = $pics;
                $destinationPath = storage_path('app/public/images/clients_photos');
                $file->move($destinationPath,$file->getClientOriginalName());   
                $photo = ClientsPhotos::create([
                    'client_id' => $request->id,
                    'client_photos' => $file->getClientOriginalName(),
                ]);
                $ids[] = $photo->id;
            }
        }
        $response = [
            'success' => true,
            'message' => 'Client Photos Updated successfully!',
            'type' => 'success',
            'id' => $ids
        ];
        return response()->json($response);
    }
    public function updateDocuments(Request $request)
    {
        $insertedIds = []; // Array to hold the inserted IDs
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                $file = $pics;
                $destinationPath = storage_path('app/public/images/clients_documents');
                $file->move($destinationPath,$file->getClientOriginalName());   
                $photo = ClientsDocuments::create([
                    'client_id' => $request->id,
                    'client_documents' => $file->getClientOriginalName(),
                ]);
                // Add the inserted ID to the array
                $insertedIds[] = $photo->id;
            }
        }
        $response = [
            'success'   => true,
            'message'   => 'Client Documents Updated successfully!',
            'type'      => 'success',
            'client_id' => $insertedIds // Include the client ID in the response
        ];
        return response()->json($response);
    }
    public function removeDocuments(Request $request)
    {
        ClientsDocuments::where('id',$request->doc_id)->where('client_id',$request->id)->delete();

        $response = [
            'success' => true,
            'message' => 'Location deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
        return response()->json($response);
    }
    public function removePhotos(Request $request)
    {
        ClientsPhotos::where('id',$request->photo_id)->where('client_id',$request->id)->delete();

        $response = [
            'success' => true,
            'message' => 'Client deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
        return response()->json($response);
    }
}
