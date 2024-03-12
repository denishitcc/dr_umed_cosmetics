<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentListResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\StaffListResource;
use App\Models\Appointment;
use App\Models\AppointmentNotes;
use App\Models\Category;
use App\Models\Services;
use App\Models\User;
use App\Repositories\CalendarRepository;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\ClientsPhotos;
use App\Models\ClientsDocuments;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Locations;
use DateTime;

class CalenderController extends Controller
{
    // /** @var \App\Repositories\CalendarRepository $repository */
    // protected $repository;

    // public function __construct(CalendarRepository $repository)
    // {
    //     $this->repository = $repository;
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with([
                            'children'
                        ])->whereNull('parent_category')->get();

        $services   = Services::with(['appearoncalender'])->get();

        return view('calender.index')->with(
            [
                'categories' => $categories,
                'services'   => $services
            ]
        );
    }

    /**
     * Method getStaffList
     *
     * @return mixed
     */
    public function getStaffList()
    {
        $user = User::where('role_type','!=','admin')->get();
        return response()->json(StaffListResource::collection($user));
    }

    /**
     * Method getCategoryServices
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getCategoryServices(Request $request)
    {
        $services   = Services::select();

        if ($request->category_id) {
            $services->where('parent_category', $request->category_id);
        }

        $services = $services->get();
        return response()->json(CategoryListResource::collection($services));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Method getAllClients
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getAllClients(Request $request)
    {
        $clients = Clients::where('firstname', 'like', '%' .$request->name. '%')->get();
        return response()->json(ClientResource::collection($clients));
    }

    /**
     * Method getAllAppointments
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function createAppointments(Request $request)
    {
        DB::beginTransaction();
        $appointmentsData = [
            'client_id'     => $request->client_id,
            'service_id'    => $request->service_id,
            'category_id'   => $request->category_id,
            'staff_id'      => $request->staff_id,
            'start_date'    => $request->start_time,
            'end_date'      => $request->end_time,
            'duration'      => $request->duration,
            'status'        => Appointment::BOOKED,
            'current_date'  => $request->start_date
        ];

        try {
            // $findAppointment = $this->checkAppointment($appointmentsData);

            // if( isset($findAppointment->id) ){
            //     $findAppointment->update($appointmentsData);
            // }
            // else
            // {
            Appointment::create($appointmentsData);
            // }

            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'type'    => 'success',
            ];

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $data = [
                'success' => false,
                'message' => 'something went wrong!',
                'type'    => 'fail',
            ];
        }

        return response()->json($data);
    }

    /**
     * Method checkAppointment
     *
     * @param Array $appointmentsData [explicite description]
     *
     * @return mixed
     */
    public function checkAppointment(Array $appointmentsData)
    {
        $findArr = [
            'client_id'     => $appointmentsData['client_id'],
            'service_id'    => $appointmentsData['service_id'],
            'category_id'   => $appointmentsData['category_id'],
            'status'        => Appointment::BOOKED,
        ];

        return Appointment::where($findArr)->whereRaw("date(start_date) = '{$appointmentsData['current_date']}'")->first();
    }

    /**
     * Method getEvents
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getEvents(Request $request)
    {
        $events   = Appointment::select()
                    ->with([
                        'services',
                        'clients'
                    ]);

        if ($request->start_date) {
            $events->whereBetween(DB::raw('DATE(start_date)'), array($request->start_date, $request->end_date));
        }

        $events = $events->get();
        return response()->json(AppointmentListResource::collection($events));
    }

    /**
     * Method updateAppointment
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function updateAppointments(Request $request)
    {
        DB::beginTransaction();
        $appointmentsData = [
            'client_id'     => $request->client_id,
            'service_id'    => $request->service_id,
            'category_id'   => $request->category_id,
            'staff_id'      => $request->staff_id,
            'start_date'    => $request->start_time,
            'end_date'      => $request->end_time,
            'duration'      => $request->duration,
            'status'        => Appointment::BOOKED,
            'current_date'  => $request->start_date,
        ];

        try {
            $findAppointment = Appointment::find($request->event_id);

            if( isset($findAppointment->id) ){
                $findAppointment->update($appointmentsData);
            }

            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Appointment updated successfully!',
                'type'    => 'success',
            ];

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }

        return response()->json($data);
    }

    /**
     * Method getClientCardData
     *
     * @return mixed
     */
    public function getClientCardData($clientId)
    {
        $appointmentNotes   = [];
        $client             = Clients::findOrFail($clientId);
        $todayDate          = Carbon::today()->toDateTimeString();

        $futureappointments = $client->allappointments()->with(['note'])->where('created_at','>=', $todayDate)->orderby('created_at','desc')->get();
        $pastappointments   = $client->allappointments()->with(['note'])->where('created_at','<=', $todayDate)->orderby('created_at','desc')->get();
        $clientPhotos       = $client->photos;

        if($client->last_appointment)
        {
            $appointmentNotes   = AppointmentNotes::where(['appointment_id' => $client->last_appointment->id])->first();
        }
        $html               = view('calender.partials.client_card', [ 'client' => $client ])->render();
        $appointmenthtml    = view('calender.partials.client-appointment-card', [
                                    'futureappointments'  => $futureappointments,
                                    'pastappointments'    => $pastappointments,
                                    'client' => $client
                            ])->render();

        $clientnoteshtml    = view('calender.partials.client-notes' , [
                                    'appointmentNotes'  => $appointmentNotes,
                                    'clientPhotos'      => $clientPhotos
                            ])->render();

        return response()->json([
            'status'                => true,
            'message'               => 'Details found.',
            'data'                  => $html,
            'appointmenthtml'       => $appointmenthtml,
            'clientnoteshtml'       => $clientnoteshtml,
            'client'                => $client
        ], 200);
    }

    /**
     * Method addAppointmentNotes
     *
     * @return mixed
     */
    public function addAppointmentNotes(Request $request)
    {
        DB::beginTransaction();
        try {
            if(isset($request->commonNotes))
            {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId],['common_notes' => $request->commonNotes]);
            }
            else
            {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId],['treatment_notes' => $request->treatmentNotes]);
            }
            DB::commit();
            $client             = Clients::findOrFail($request->client_id);
            $clientPhotos       = $client->photos;
            $clientnoteshtml    = view('calender.partials.client-notes' , [
                                    'appointmentNotes'  => $appointmentNotes,
                                    'clientPhotos'      => $clientPhotos
                                ])->render();

            return response()->json([
                'status'        => true,
                'message'       => 'Notes found.',
                'client_notes'  => $clientnoteshtml,
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Method viewAppointmentNotes
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function viewAppointmentNotes(Request $request)
    {
        $appointmentNotes   = AppointmentNotes::where(['appointment_id' => $request->appointment_id])->first();
        $client             = Clients::findOrFail($request->client_id);
        $clientPhotos       = $client->photos;

        $clientnoteshtml    = view('calender.partials.client-notes' , [
                                'appointmentNotes'  => $appointmentNotes,
                                'clientPhotos'      => $clientPhotos
                            ])->render();

        return response()->json([
            'status'        => true,
            'message'       => 'Notes found.',
            'client_notes'  => $clientnoteshtml,
        ], 200);
    }

    /**
     * Method getEventById
     *
     * @param int $appointmentId [explicite description]
     *
     * @return void
     */
    public function getEventById(int $appointmentId)
    {
        $appointment   = Appointment::find($appointmentId);

        return response()->json([
            'status'     => true,
            'message'    => 'Details found.',
            'data'       => new AppointmentResource($appointment)
        ], 200);
    }

    /**
     * Method UpdateAppointmentStatus
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function UpdateAppointmentStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $findAppointment            = Appointment::find($request->event_id);

            if( isset($findAppointment->id) ){
                $findAppointment['status']  = $request->status;
                $findAppointment->update();
            }

            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Appointment updated successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }

        return response()->json($data);
    }

    public function UpcomingAppointment(Request $request)
    {
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
                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(appointment.start_date, "%Y-%m-%d %h:%i %p"), " ", services.service_name, " with ", CONCAT(users.first_name, " ", users.last_name))) as appointment_dates'),
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
                    DB::raw('GROUP_CONCAT(locations.location_name) as staff_locations'),
                    DB::raw('GROUP_CONCAT(appointment.duration) as durations'),
                    'services.id as service_id',
                    'services.service_name',
                    'services.parent_category'
            )
            ->groupBy('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status',
                    'services.id',
                    'services.service_name',
                    'services.parent_category'
            )
            ->havingRaw('appointment_dates IS NOT NULL')
            ->where('clients.id',$request->id)
            ->get();
        // Prepare response data
        $app_details = [];
        foreach ($data as $datas) {
            $appointment_dates = explode(',', $datas->appointment_dates);
            $app_status = explode(',', $datas->app_status);
            $staff_locations = explode(',', $datas->staff_locations);
            $durations = explode(',',$datas->durations);
            // Ensure all arrays have the same length
            $count = max(count($appointment_dates), count($app_status), count($staff_locations));
            $appointment_dates = array_pad($appointment_dates, $count, '');
            $app_status = array_pad($app_status, $count, '');
            $staff_locations = array_pad($staff_locations, $count, '');
            $durations = array_pad($durations, $count, '');
            $service_id = $datas->service_id;
            $service_name = $datas->service_name;
            $category_id = $datas->parent_category;
            $client_name = $datas->firstname.' '.$datas->last_name;

            // Iterate through each appointment date and create separate entries
            for ($i = 0; $i < $count; $i++) {
                $app_details[] = [
                    'id' => $datas->id,
                    'firstname' => $datas->firstname,
                    'lastname' => $datas->lastname,
                    'email' => $datas->email,
                    'mobile_number' => $datas->mobile_number,
                    'status' => $datas->status,
                    'appointment_details' => $appointment_dates[$i],
                    'app_status' => $app_status[$i],
                    'staff_locations' => $staff_locations[$i],
                    'durations' => $durations[$i],
                    'service_id' => $service_id,
                    'service_name' => $service_name,
                    'category_id' => $category_id,
                    'client_name' => $client_name
                ];
            }
        }
        // Check if there are any conflicting appointments
        $conflict = $request->conflict == '1';
        if($conflict == true){
            $conflicting_appointments = [];

            // Convert appointment details to datetime objects for easier comparison
            foreach ($app_details as $appointment) {
                // Extract date and time from appointment_details
                preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2} [AP]M)/', $appointment['appointment_details'], $matches);
                if (!empty($matches)) {
                    $start_time = new DateTime($matches[0]);
                    $end_time = (clone $start_time)->modify('+' . $appointment['durations'] . ' minutes');

                    // Check for conflicts with other appointments
                    foreach ($app_details as $comparison_appointment) {
                        if ($appointment !== $comparison_appointment) { // Avoid self-comparison
                            // Extract date and time from comparison appointment details
                            preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2} [AP]M)/', $comparison_appointment['appointment_details'], $comparison_matches);
                            if (!empty($comparison_matches)) {
                                $comparison_start_time = new DateTime($comparison_matches[0]);
                                $comparison_end_time = (clone $comparison_start_time)->modify('+' . $comparison_appointment['durations'] . ' minutes');

                                // Check for overlap
                                if ($start_time < $comparison_end_time && $end_time > $comparison_start_time) {
                                    // Conflicting appointments found
                                    $conflicting_appointments[] = $appointment;
                                    break; // Break the inner loop once a conflict is found
                                }
                            }
                        }
                    }
                }
            }
            // Check if there are any conflicting appointments
            $conflict = $request->conflict == '1';
            if ($conflict == true) {
                $app_details = $conflicting_appointments;
            }
        }
        $response = [
            'success' => true,
            'message' => 'Upcoming appointments fetched successfully!',
            'type' => 'success',
            'appointments' => $app_details,
            'conflict' => $conflict  // Send whether there is a conflict or not
        ];  
        return response()->json($response);
    }
    public function HistoryAppointment(Request $request)
    {
        $currentDateTime = now()->timezone('Asia/Kolkata')->format('Y-m-d H:i:s');

        $data = Clients::leftJoin('appointment', function($join) use ($currentDateTime) {
                $join->on('clients.id', '=', 'appointment.client_id')
                    ->where('appointment.start_date', '<=', $currentDateTime);
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
                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(appointment.start_date, "%Y-%m-%d %h:%i %p"), " ", services.service_name, " with ", CONCAT(users.first_name, " ", users.last_name))) as appointment_dates'),
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
                    DB::raw('GROUP_CONCAT(locations.location_name) as staff_locations'),
                    DB::raw('GROUP_CONCAT(appointment.duration) as durations'),
                    'services.id as service_id',
                    'services.service_name',
                    'services.parent_category'
            )
            ->groupBy('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status',
                    'services.id',
                    'services.service_name',
                    'services.parent_category'
            )
            ->havingRaw('appointment_dates IS NOT NULL')
            ->where('clients.id',$request->id)
            ->get();
        // Prepare response data
        $app_details = [];
        foreach ($data as $datas) {
            $appointment_dates = explode(',', $datas->appointment_dates);
            $app_status = explode(',', $datas->app_status);
            $staff_locations = explode(',', $datas->staff_locations);
            $durations = explode(',',$datas->durations);
            // Ensure all arrays have the same length
            $count = max(count($appointment_dates), count($app_status), count($staff_locations));
            $appointment_dates = array_pad($appointment_dates, $count, '');
            $app_status = array_pad($app_status, $count, '');
            $staff_locations = array_pad($staff_locations, $count, '');
            $durations = array_pad($durations, $count, '');
            $service_id = $datas->service_id;
            $service_name = $datas->service_name;
            $category_id = $datas->parent_category;
            $client_name = $datas->firstname.' '.$datas->last_name;

            // Iterate through each appointment date and create separate entries
            for ($i = 0; $i < $count; $i++) {
                $app_details[] = [
                    'id' => $datas->id,
                    'firstname' => $datas->firstname,
                    'lastname' => $datas->lastname,
                    'email' => $datas->email,
                    'mobile_number' => $datas->mobile_number,
                    'status' => $datas->status,
                    'appointment_details' => $appointment_dates[$i],
                    'app_status' => $app_status[$i],
                    'staff_locations' => $staff_locations[$i],
                    'durations' => $durations[$i],
                    'service_id' => $service_id,
                    'service_name' => $service_name,
                    'category_id' => $category_id,
                    'client_name' => $client_name
                ];
            }
        }
        // Now $app_details is sorted by 'appointment_details' in descending order
        usort($app_details, function($a, $b) {
            // Extract date and time part up to AM/PM indicator
            $dateA = preg_replace('/\s(?:AM|PM).*$/', '', $a['appointment_details']);
            $dateB = preg_replace('/\s(?:AM|PM).*$/', '', $b['appointment_details']);
        
            // Convert to DateTime objects
            $dateTimeA = new DateTime($dateA);
            $dateTimeB = new DateTime($dateB);
        
            // Sort in descending order (latest first)
            if ($dateTimeA == $dateTimeB) {
                return 0;
            }
        
            return ($dateTimeA < $dateTimeB) ? 1 : -1;
        });

        // Check if there are any conflicting appointments
        $conflict = $request->conflict == '1';
        if($conflict == true){
            $conflicting_appointments = [];

            // Convert appointment details to datetime objects for easier comparison
            foreach ($app_details as $appointment) {
                // Extract date and time from appointment_details
                preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2} [AP]M)/', $appointment['appointment_details'], $matches);
                if (!empty($matches)) {
                    $start_time = new DateTime($matches[0]);
                    $end_time = (clone $start_time)->modify('+' . $appointment['durations'] . ' minutes');

                    // Check for conflicts with other appointments
                    foreach ($app_details as $comparison_appointment) {
                        if ($appointment !== $comparison_appointment) { // Avoid self-comparison
                            // Extract date and time from comparison appointment details
                            preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2} [AP]M)/', $comparison_appointment['appointment_details'], $comparison_matches);
                            if (!empty($comparison_matches)) {
                                $comparison_start_time = new DateTime($comparison_matches[0]);
                                $comparison_end_time = (clone $comparison_start_time)->modify('+' . $comparison_appointment['durations'] . ' minutes');

                                // Check for overlap
                                if ($start_time < $comparison_end_time && $end_time > $comparison_start_time) {
                                    // Conflicting appointments found
                                    $conflicting_appointments[] = $appointment;
                                    break; // Break the inner loop once a conflict is found
                                }
                            }
                        }
                    }
                }
            }
            // Check if there are any conflicting appointments
            $conflict = $request->conflict == '1';
            if ($conflict == true) {
                $app_details = $conflicting_appointments;
            }
        }
        $response = [
            'success' => true,
            'message' => 'History appointments fetched successfully!',
            'type' => 'success',
            'appointments' => $app_details,
            'conflict' => $conflict  // Send whether there is a conflict or not
        ];
        return response()->json($response);
    }
}
