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
use App\Models\ServicesAppearOnCalendar;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Locations;
use App\Models\WaitlistClient;
use App\Models\Products;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\WalkInRetailSale;
use App\Models\WalkInProducts;
use App\Models\WalkInDiscountSurcharge;
use App\Models\Payment;

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
    public function index(Request $request)
    {
        $categories = Category::with([
                            'children'
                        ])->whereNull('parent_category')->get();

        $services   = Services::with(['appearoncalender'])->get();
        $staffs     = User::all();
        $todayDate  = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format
        $waitlist   = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
            ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
            ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
            ->where('preferred_from_date',$todayDate)
            ->get();

        $all_services = Services::select('id','service_name', 'standard_price')->with(['appearoncalender'])->get();
        $all_products = Products::select('id','product_name', 'price','gst_code')->get();

        // Initialize an empty array to store the merged data
        $mergedArray = [];

        // Extract and format services data
        foreach ($all_services as $service) {
            $mergedArray[] = [
                'id'    => $service->id,
                'name'  => $service->service_name,
                'price' => $service->standard_price,
                'gst'   =>'yes',
                'product_type' =>'service'
            ];
        }
        // Extract and format products data
        foreach ($all_products as $product) {
            $gst = $product->gst_code === 'Standard' ? 'yes' : 'no';

            $mergedArray[] = [
                'id'    => $product->id,
                'name'  => $product->product_name,
                'price' => $product->price,
                'gst'   => $gst,
                'product_type' =>'product'
            ];
        }

        // Convert the merged array to JSON format
        $mergedProductService = $mergedArray;


        foreach($waitlist as $wait)
        {
            $ser_id = explode(',',$wait->service_id);
            $service_names = [];
            $service_durations = [];
            $serv_id = [];
            foreach ($ser_id as $ser) {
                $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                $service_appear = ServicesAppearOnCalendar::where('service_id',$ser)->first();
                if ($service) {
                    $service_names[] = $service->service_name;
                    $serv_id[] = $ser;
                }
                if ($service_appear) {
                    $service_durations[] = $service_appear->duration;
                }
            }
            $wait->service_name = $service_names;
            $wait->servid = $serv_id;
            $wait->duration = $service_durations;
        }

        return view('calender.index')->with(
            [
                'categories' => $categories,
                'services'   => $services,
                'waitlist'   => $waitlist,
                'staffs'     => $staffs,
                'productServiceJson'   => $mergedProductService
            ]
        );
    }

    /**
     * Method getStaffList
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function getStaffList(Request $request)
    {
        $location   = isset($request->location_id) ? $request->location_id : Auth::user()->staff_member_location;
        $user       = User::select();

        if($location)
        {
            $user = $user->where('role_type','!=','admin')->where('staff_member_location','=',$location);
        }
        else
        {
            $user = $user->where('role_type','!=','admin');
        }
        $user = $user->get();
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
            $services->where('category_id', $request->category_id);
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
        $clients = Clients::where('firstname', 'like', '%' .$request->name. '%')->where('status','active')->get();
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
        // dd($request->all());
        if(isset($request->app_id)) {
            $service_ex = explode(',',$request->service_id);
            $duration_ex = explode(',',$request->duration);
            $category_ex = explode(',',$request->category_id);
            $data = []; // Initialize an array to store response data
        
            try {
                DB::beginTransaction(); // Begin a transaction
                foreach($service_ex as $key => $ser) {
                    $single_ser = Services::where('id',$ser)->first();
                    $startDateTime = Carbon::parse($request->start_time);
                    $duration = $duration_ex[$key];
                    // Add duration to start_date
                    if($key > 0) {
                        $startDateTime = Carbon::parse($data[$key - 1]['data']['end_date']); // Use previous end_date
                    }

                    $endDateTime = $startDateTime->copy()->addMinutes($duration);
                    $formattedEndDateTime = $endDateTime->format('Y-m-d\TH:i:s');

                    $appointmentsData = [
                        'client_id'     => $request->client_id,
                        'service_id'    => $ser,
                        'category_id'   => $single_ser['category_id'],//$category_ex[$key],
                        'staff_id'      => $request->staff_id,
                        'start_date'    => $startDateTime->format('Y-m-d\TH:i:s'),
                        'end_date'      => $formattedEndDateTime,
                        'duration'      => $duration,
                        'status'        => Appointment::BOOKED,
                        'current_date'  => $request->start_date,
                        'location_id'   => $request->location_id
                    ];
        
                    Appointment::create($appointmentsData);
                    $data[] = [
                        'success' => true,
                        'message' => 'Appointment data prepared!',
                        'type'    => 'info',
                        'data'    => $appointmentsData, // Store prepared data for reference
                    ];
                }
        
                DB::commit();

                // Delete waitlist data corresponding to this appointment
                WaitlistClient::where('id', $request->app_id)
                ->delete();
                
                $data = [
                    'success' => true,
                    'message' => 'Appointment booked successfully!',
                    'type'    => 'success',
                ];
            } catch (\Throwable $th) {
                dd($th);
                DB::rollback(); // Rollback the transaction on exception
                $data[] = [
                    'success' => false,
                    'message' => 'Something went wrong!',
                    'type'    => 'fail',
                ];
            }
        } 
        else
        {
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
                'location_id'   => $request->location_id
            ];
    
            try {
                $findAppointment = Appointment::where('id',$request->app_id)->first();
                
                if( isset($findAppointment->id) ){
                    $findAppointment->update($appointmentsData);
                }
                else
                {
                Appointment::create($appointmentsData);
                }
    
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
        $location = Auth()->user()->staff_member_location;
        $events   = Appointment::select()
                    ->with([
                        'services',
                        'clients'
                    ]);

        if ($request->start_date) {
            $events->whereBetween(DB::raw('DATE(start_date)'), array($request->start_date, $request->end_date));
        }
        // if($location)
        // {
        //     $events->where
        // }
        $events = $events->get();
        // dd($events);
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
     * Method updateAppointmentStatus
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updateAppointmentStatus(Request $request)
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

    /**
     * Method deleteAppointment
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function deleteAppointment(int $id)
    {
        try {
            $appointment   = Appointment::with(['note'])->find($id);

            // Delete appointment notes
            if(isset($appointment->note->id))
            {
                $appointment->note()->delete();
            }

            // Delete Appointment
            $appointment->delete();

            $data = [
                'success' => true,
                'message' => 'Appointment deleted successfully!',
                'type'    => 'success',
            ];

        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }
        return response()->json($data);
    }

    /**
     * Method repeatAppointment
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function repeatAppointment(Request $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $appointmentsData = [
                'client_id'     => $request->client_id,
                'service_id'    => $request->service_id,
                'category_id'   => $request->category_id,
                'staff_id'      => $request->staff_id,
                'duration'      => $request->duration,
                'status'        => Appointment::BOOKED,
            ];

            $repeat_every   = $request->repeat_every;
            $todayDate      = Carbon::now();
            $apptDate       = $request->appointment_date;
            $days           = $request->repeat_every_no;

            switch ($repeat_every) {
                case 'day':
                    $newdata = $this->appointmentDays($days,$todayDate,$request, $appointmentsData);
                    break;

                case 'week':
                    $newdata = $this->appointmentWeeks($days,$apptDate,$request, $appointmentsData);
                    break;

                case 'month':
                    $newdata = $this->appointmentMonths($days,$apptDate,$request, $appointmentsData);
                    break;

                case 'year':
                    $newdata = $this->appointmentYear($days,$apptDate,$request, $appointmentsData);
                    break;

                default:
                    # code...
                    break;
            }

            $data  = Appointment::insert($newdata);
            DB::commit();

            $data = [
                'success' => true,
                'message' => 'Appointment created successfully!',
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

        return $data;

    }

    function appointmentDays($days ,$todayDate,$request, $appointmentsData)
    {
        for ($i = 1 ; $i <= $days; $i++) {

            $latest_date = $todayDate->addDays($days);
            $appointmentsData['start_date']  = $latest_date->toDateString(). ' '.$request->repeat_time.''.':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            $newdata[]  = $appointmentsData;
            if ($i == $request->no_of_appointment) {
                break;
            }

            if($latest_date->gte($request->stop_repeating_date)){
                break;
            }
        }
        return $newdata;
    }

    function appointmentYear($days,$apptDate,$request, $appointmentsData)
    {
        $apptDate = Carbon::parse($apptDate);
        for ($i = 1 ; $i <= $request->no_of_appointment; $i++) {

            $latest_date        = $apptDate->addYear($days);
            $appointmentsData['start_date']  = $latest_date->toDateString(). ' '.$request->repeat_time.''.':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            if($request->repeat_year == 1) // same date
            {
                $latest_date        = $apptDate->addYear($days);
                $firstDayOfMonth    = $latest_date->firstOfMonth();
                $weekday            = 'first '.$request->repeat_day.' of this month';
                $firstFridayOfMonth = $firstDayOfMonth->modify($weekday);

                $appointmentsData['start_date']  = $firstFridayOfMonth->toDateString(). ' '.$request->repeat_time.''.':00';
                $latest                          = Carbon::parse($appointmentsData['start_date']);
                $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            }
            $newdata[]  = $appointmentsData;

            if(!empty($request->stop_repeating_date) && $latest_date->gte($request->stop_repeating_date)){
                break;
            }
        }

        return $newdata;
    }

    function appointmentWeeks($days,$apptDate,$request, $appointmentsData)
    {
        $apptDate = Carbon::parse('2024-04-30');
        $weekdays = $request->weekdays;
        $newDate = $apptDate->addWeek($days);

        $latestweekdays = $newdata =  [];
        // for ($i = 1 ; $i <= $request->no_of_appointment; $i++) {

        for ($w = Carbon::SUNDAY; $w <= Carbon::SATURDAY; $w++) {
            if (in_array($w, $weekdays)) {
                $latestweekdays[] = $newDate->copy()->startOfWeek()->addDays($w)->format('Y-m-d');
            }
        }

        foreach ($latestweekdays as $key => $value) {
            $latestDate = Carbon::parse($value);

            $appointmentsData['start_date']  = $latestDate->toDateString(). ' '.$request->repeat_time.''.':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();
            $newdata[]  = $appointmentsData;
        }
        return $newdata;
        // }
    }

    function appointmentMonths($days,$apptDate,$request, $appointmentsData)
    {
        $apptDate = Carbon::parse($apptDate);
        for ($i = 1 ; $i <= $request->no_of_appointment; $i++) {

            if($request->repeat_month == 0)
            {
                $latest_date                     = $apptDate->addMonths($days);
                $appointmentsData['start_date']  = $latest_date->toDateString(). ' '.$request->repeat_time.''.':00';
                $latest                          = Carbon::parse($appointmentsData['start_date']);
                $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();
            }

            if($request->repeat_month == 1) // same date
            {
                // $latest_date        = $apptDate->addWeeks(5);
                // $latest_date        = $apptDate->nthInMonth(Carbon::FRIDAY, 5);
                $newDate = $this->addNthWeekdayInMonth($apptDate, 5, Carbon::TUESDAY);
                dd($newDate);
                // $firstDayOfMonth    = $latest_date->firstOfMonth();
                // $weekday            = $latest_date->next('Wednesday')->addWeeks(5);
                // dd($latest_date);
                // $firstFridayOfMonth = $latest_date->modify($weekday);
                // $appointmentsData['start_date']  = $firstFridayOfMonth->toDateString(). ' '.$request->repeat_time.''.':00';
                // $latest                          = Carbon::parse($appointmentsData['start_date']);
                // $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            }
            $newdata[]  = $appointmentsData;

            if(!empty($request->stop_repeating_date) && $latest_date->gte($request->stop_repeating_date)){
                break;
            }
        }
        return $newdata;
    }

    // Function to add nth weekday
    function addNthWeekdayInMonth(Carbon $date, $n, $weekday)
    {
        // Calculate the difference between the desired weekday and the current weekday
        $diff = ($weekday - $date->dayOfWeek + 7) % 7;

        // If the difference is zero, then it's the same weekday, so move to the next occurrence
        if ($diff == 0) {
            $diff = 7;
        }

        // Get the last day of the current month
        $lastDayOfMonth = $date->copy()->endOfMonth();

        // Calculate the number of occurrences of the desired weekday in the current month
        $totalOccurrences = $lastDayOfMonth->diffInDaysFiltered(function (Carbon $date) use ($weekday) {
            return $date->dayOfWeek == $weekday;
        });

        // If the desired nth occurrence exists, add it
        if ($n <= $totalOccurrences) {
            return $date->addDays(($n - 1) * 7 + $diff);
        }

        // Otherwise, add the last occurrence of the weekday in the current month
        return $lastDayOfMonth->copy()->previous($weekday);
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
                    'services.category_id'
            )
            ->groupBy('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status',
                    'services.id',
                    'services.service_name',
                    'services.category_id'
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
            $category_id = $datas->category_id;
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
        
            return ($dateTimeA > $dateTimeB) ? 1 : -1;
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
                    'services.category_id'
            )
            ->groupBy('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status',
                    'services.id',
                    'services.service_name',
                    'services.category_id'
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
            $category_id = $datas->category_id;
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
    public function updateCreateAppointments(Request $request){
        DB::beginTransaction();
        try {
            // Extract appointments array from the request
            $appointments = $request->appointments;
    
            // First, delete existing appointments with provided event_ids
            $eventIds = collect($appointments)->pluck('event_id');
            // dd($appointments);
            Appointment::whereIn('id', $eventIds)->delete();
    
            $startDateTime = null; // Initialize startDateTime outside the loop
            $endDateTime = null; // Initialize endDateTime
    
            foreach ($appointments as $key => $appointmentData) {
                $duration = $appointmentData['duration'];
    
                // Calculate start time for first iteration or update start time for subsequent iterations
                if ($key === 0 || $startDateTime === null) {
                    $startDateTime = Carbon::parse($appointmentData['start_time']);
                } else {
                    // Start time for subsequent appointments is the end time of the previous appointment
                    $startDateTime = $endDateTime->copy();
                }
    
                 // Calculate end time based on start time and duration
                $endDateTime = $startDateTime->copy()->addMinutes($duration);
    
                $appointmentsData = [
                    'client_id'     => $appointmentData['client_id'],
                    'service_id'    => $appointmentData['service_id'],
                    'category_id'   => $appointmentData['category_id'],
                    'staff_id'      => $appointmentData['staff_id'],
                    'start_date'    => $startDateTime->toDateTimeString(),
                    'end_date'      => $endDateTime->toDateTimeString(),
                    'duration'      => $duration,
                    'status'        => Appointment::BOOKED,
                    'current_date'  => $startDateTime->toDateString(),
                ];
    
                Appointment::create($appointmentsData);
            }
    
            DB::commit();
            $data = [
                'success' => true,
                'message' => 'Appointments updated successfully!',
            ];
    
        } catch (\Exception $e) {
            DB::rollback();
            $data = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    
        return response()->json($data);
    }    
    public function CreateWaitListClient(Request $request){
        WaitlistClient::create($request->appointments[0]);
        $response = [
            'success' => true,
            'message' => 'Waitlist Client Created successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function FilterCalendarDate(Request $request){
        $todayDate = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format
        $staffs      = User::all();
        if($request->is_checked == '1') {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('preferred_from_date', $todayDate)
                ->get();
        } else {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->get();
        }

        foreach($waitlist as $wait) {
            $ser_id = explode(',',$wait->service_id);
            $service_names = [];
            $service_durations = [];
            
            foreach ($ser_id as $ser) {
                $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                $service_appear = ServicesAppearOnCalendar::where('service_id',$ser)->first();
                if ($service) {
                    $service_names[] = $service->service_name;
                }
                if ($service_appear) {
                    $service_durations[] = $service_appear->duration;
                }
            }

            $wait->service_name = $service_names;
            $wait->duration = $service_durations;
        }

        $response = [
            'success' => true,
            'data'    => $waitlist, // Include data in response
            'staffs'  => $staffs,
            'message' => 'Waitlist Client Created successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function filterCalendarStaff(Request $request)
    {
        $todayDate = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format
        $staffs      = User::all();
        if($request->is_checked == '1') {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('preferred_from_date', $todayDate)
                ->where('users.id', $request->staff_id)
                ->get();
        } else {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('users.id', $request->staff_id)
                ->get();
            // dd($waitlist);
        }

        foreach($waitlist as $wait) {
            $ser_id = explode(',',$wait->service_id);
            $service_names = [];
            $service_durations = [];
            
            foreach ($ser_id as $ser) {
                $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                $service_appear = ServicesAppearOnCalendar::where('service_id',$ser)->first();
                if ($service) {
                    $service_names[] = $service->service_name;
                }
                if ($service_appear) {
                    $service_durations[] = $service_appear->duration;
                }
            }

            $wait->service_name = $service_names;
            $wait->duration = $service_durations;
        }
        $response = [
            'success' => true,
            'data'    => $waitlist, // Include data in response
            'staffs'  => $staffs,
            'message' => 'Waitlist Client Created successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function UpdateWaitListClient(Request $request){
        // dd($request->all());

        //store category id
        $c_id = $request->appointments[0]['service_id'];
        $cs_id =explode(',',$c_id);
        $category_ids = []; // Array to store category IDs
        foreach($cs_id as $cs)
        {
            $sr = Services::where('id',$cs)->select('category_id')->first();
            if ($sr) {
                $category_ids[] = $sr->category_id;
            }
        }
        // Convert the array of category IDs to a comma-separated string
        $category_ids = array_unique($category_ids);
        $category_ids_str = implode(',', $category_ids);
        // Create a new array with the modified data
        $appointmentsData = [
            'waitlist_id' => $request->input('appointments.0.waitlist_id'),
            'client_id' => $request->input('appointments.0.client_id'),
            'user_id' => $request->input('appointments.0.user_id'),
            'preferred_from_date' => $request->input('appointments.0.preferred_from_date'),
            'preferred_to_date' => $request->input('appointments.0.preferred_to_date'),
            'additional_notes' => $request->input('appointments.0.additional_notes'),
            'category_id' => $category_ids_str,
            'service_id' => $request->input('appointments.0.service_id'), // Assuming this is not modified
        ];

        $waitlist_id = $request->appointments[0]['waitlist_id'];
        $waitlistClient = WaitlistClient::find($waitlist_id);
            if ($waitlistClient) {
                $waitlistClient->update($appointmentsData);
                // $waitlistClient->update($request->appointments[0]);
            }
        // WaitlistClient::update($request->appointments[0]);
        $response = [
            'success' => true,
            'message' => 'Waitlist Client Updated successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function deleteWaitlistClient(Request $request,$id)
    {
        try {
            $appointment   = WaitlistClient::find($id);

            // Delete Appointment
            $appointment->delete();

            $data = [
                'success' => true,
                'message' => 'Waitlist client deleted successfully!',
                'type'    => 'success',
            ];

        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }
        return response()->json($data);
    }
    public function getAllProductsServices(Request $request)
    {
        $products = Products::where('product_name', 'like', '%' .$request->name. '%')->get();
        return response()->json($products);
    }
    public function StoreWalkIn(Request $request)
    {
        if($request->hdn_customer_type == 'casual')
        {
            // Storing walk-in sale details
            $walk_in_table = [
                'customer_type' => $request->hdn_customer_type,
                'invoice_date' => $request->casual_invoice_date,
                'subtotal' => $request->hdn_subtotal,
                'discount' => $request->hdn_discount,
                'gst' => $request->hdn_gst,
                'total' => $request->hdn_total,
                'user_id' => $request->casual_staff,
                'note' => $request->notes
            ];  
            // dd($walk_in_table);

            $walkInSale = WalkInRetailSale::create($walk_in_table);

            // Storing walk-in sale products
            foreach ($request->casual_product_id as $index => $productId) {
                $walk_in_product = [
                    'walk_in_id' => $walkInSale->id,
                    'product_id' => $productId,
                    'product_name' => $request->casual_product_name[$index],
                    'product_price' => $request->casual_product_price[$index],
                    'product_quantity' => $request->casual_product_quanitity[$index],
                    'product_type' => $request->product_type[$index],
                    'who_did_work' => ($request->casual_who_did_work[$index] && $request->casual_who_did_work[$index] == 'no one' || $request->casual_who_did_work[$index] == 'Please select') ? null : $request->casual_who_did_work[$index],
                    'product_discount_surcharge' => $request->casual_discount_surcharge[$index],
                    'discount_type' => $request->casual_discount_types[$index],
                    'discount_amount' => $request->casual_discount_amount[$index],
                    // 'edit_amount' => $request->casual_edit_amount[$index],
                    'discount_reason' => $request->casual_reason[$index],
                ];

                WalkInProducts::create($walk_in_product);
            }
            // dd($walk_in_product);

            // Storing walk-in sale discount/surcharge details
            $walk_in_discount_surcharge = [
                'walk_in_id' => $walkInSale->id,
                'discount_surcharge' => $request->hdn_main_discount_surcharge,
                'discount_type' => $request->hdn_main_discount_type,
                'discount_amount' => $request->hdn_main_discount_amount,
                'discount_reason' => $request->hdn_main_discount_reason,
            ];
            // dd($walk_in_discount_surcharge);
            WalkInDiscountSurcharge::create($walk_in_discount_surcharge);

            // Storing walk-in payment details
            foreach($request->payment_types as $index => $paymentType) {
                // Access payment details using the same index
                $paymentAmount = $request->payment_amounts[$index];
                $paymentDate = $request->payment_dates[$index];
            
                // Now you can create your payment record
                $walk_in_payment = [
                    'walk_in_id' => $walkInSale->id,
                    'payment_type' => $paymentType,
                    'amount' => $paymentAmount,
                    'date' => $paymentDate,
                    'total' => $paymentTotal = str_replace('$', '', $request->payment_total),
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                ];
            
                Payment::create($walk_in_payment);
            }
        }
        else if($request->hdn_customer_type == 'existing')
        {
            // Storing walk-in sale details
            $walk_in_table = [
                'client_id' => $request->walk_in_client_id,
                'customer_type' => $request->hdn_customer_type,
                'invoice_date' => $request->existing_invoice_date,
                'subtotal' => $request->hdn_subtotal,
                'discount' => $request->hdn_discount,
                'gst' => $request->hdn_gst,
                'total' => $request->hdn_total,
                'user_id' => $request->existing_staff,
                'note' => $request->notes
            ];  
            // dd($walk_in_table);

            $walkInSale = WalkInRetailSale::create($walk_in_table);

            // Storing walk-in sale products
            foreach ($request->existing_product_id as $index => $productId) {
                $walk_in_product = [
                    'walk_in_id' => $walkInSale->id,
                    'product_id' => $productId,
                    'product_name' => $request->existing_product_name[$index],
                    'product_price' => $request->existing_product_price[$index],
                    'product_quantity' => $request->existing_product_quanitity[$index],
                    'product_type' => $request->product_type[$index],
                    'who_did_work' => ($request->existing_who_did_work[$index] && $request->existing_who_did_work[$index] == 'no one' || $request->existing_who_did_work[$index] == 'Please select') ? null : $request->existing_who_did_work[$index],
                    'product_discount_surcharge' => $request->existing_discount_surcharge[$index],
                    'discount_type' => $request->existing_discount_types[$index],
                    'discount_amount' => $request->existing_discount_amount[$index],
                    // 'edit_amount' => $request->casual_edit_amount[$index],
                    'discount_reason' => $request->existing_reason[$index],
                ];

                WalkInProducts::create($walk_in_product);
            }
            // dd($walk_in_product);

            // Storing walk-in sale discount/surcharge details
            $walk_in_discount_surcharge = [
                'walk_in_id' => $walkInSale->id,
                'discount_surcharge' => $request->hdn_main_discount_surcharge,
                'discount_type' => $request->hdn_main_discount_type,
                'discount_amount' => $request->hdn_main_discount_amount,
                'discount_reason' => $request->hdn_main_discount_reason,
            ];
            // dd($walk_in_discount_surcharge);
            WalkInDiscountSurcharge::create($walk_in_discount_surcharge);

            // Storing walk-in payment details
            foreach($request->payment_types as $index => $paymentType) {
                // Access payment details using the same index
                $paymentAmount = $request->payment_amounts[$index];
                $paymentDate = $request->payment_dates[$index];
            
                // Now you can create your payment record
                $walk_in_payment = [
                    'walk_in_id' => $walkInSale->id,
                    'payment_type' => $paymentType,
                    'amount' => $paymentAmount,
                    'date' => $paymentDate,
                    'total' => $paymentTotal = str_replace('$', '', $request->payment_total),
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                ];
            
                Payment::create($walk_in_payment);
            }
        }
        else{
            //store client details
            $newUser = Clients::create([
                'firstname' => $request->walkin_first_name,
                'lastname' => $request->walkin_last_name,
                'email' => $request->walkin_email,
                'gender' => $request->walkin_gender,
                'mobile_number' => $request->walkin_phone_type == 'Mobile' ? $request->walkin_phone_no : null,
                'home_phone' => $request->walkin_phone_type == 'Home' ? $request->walkin_phone_no : null,
                'work_phone' => $request->walkin_phone_type == 'Work' ? $request->walkin_phone_no : null,
                'contact_method' => $request->walkin_contact_method,
                'send_promotions' => $request->walkin_send_promotions
            ]);
            
            // Storing walk-in sale details
            $walk_in_table = [
                'client_id' => $newUser->id,
                'customer_type' => $request->hdn_customer_type,
                'invoice_date' => $request->new_invoice_date,
                'subtotal' => $request->hdn_subtotal,
                'discount' => $request->hdn_discount,
                'gst' => $request->hdn_gst,
                'total' => $request->hdn_total,
                'user_id' => $request->new_staff,
                'note' => $request->notes
            ];  
            // dd($walk_in_table);

            $walkInSale = WalkInRetailSale::create($walk_in_table);

            // Storing walk-in sale products
            foreach ($request->new_product_id as $index => $productId) {
                $walk_in_product = [
                    'walk_in_id' => $walkInSale->id,
                    'product_id' => $productId,
                    'product_name' => $request->new_product_name[$index],
                    'product_price' => $request->new_product_price[$index],
                    'product_type' => $request->product_type[$index],
                    'product_quantity' => $request->new_product_quanitity[$index],
                    'who_did_work' => ($request->new_who_did_work[$index] && $request->new_who_did_work[$index] == 'no one' || $request->new_who_did_work[$index] == 'Please select') ? null : $request->new_who_did_work[$index],
                    'product_discount_surcharge' => $request->new_discount_surcharge[$index],
                    'discount_type' => $request->new_discount_types[$index],
                    'discount_amount' => $request->new_discount_amount[$index],
                    // 'edit_amount' => $request->casual_edit_amount[$index],
                    'discount_reason' => $request->new_reason[$index],
                ];

                WalkInProducts::create($walk_in_product);
            }
            // dd($walk_in_product);

            // Storing walk-in sale discount/surcharge details
            $walk_in_discount_surcharge = [
                'walk_in_id' => $walkInSale->id,
                'discount_surcharge' => $request->hdn_main_discount_surcharge,
                'discount_type' => $request->hdn_main_discount_type,
                'discount_amount' => $request->hdn_main_discount_amount,
                'discount_reason' => $request->hdn_main_discount_reason,
            ];
            // dd($walk_in_discount_surcharge);
            WalkInDiscountSurcharge::create($walk_in_discount_surcharge);

            // Storing walk-in payment details
            foreach($request->payment_types as $index => $paymentType) {
                // Access payment details using the same index
                $paymentAmount = $request->payment_amounts[$index];
                $paymentDate = $request->payment_dates[$index];
            
                // Now you can create your payment record
                $walk_in_payment = [
                    'walk_in_id' => $walkInSale->id,
                    'payment_type' => $paymentType,
                    'amount' => $paymentAmount,
                    'date' => $paymentDate,
                    'total' => $paymentTotal = str_replace('$', '', $request->payment_total),
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                ];
            
                Payment::create($walk_in_payment);
            }
        }
        

        return response()->json(['success' => true, 'message' => 'Walk-In created successfully']);
    }

}
