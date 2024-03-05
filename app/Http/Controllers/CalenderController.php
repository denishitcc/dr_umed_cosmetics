<?php

namespace App\Http\Controllers;

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

        $services   = Services::get();

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
        $data = [];
        foreach ($user as $value) {
            $data[] = [
                'id'                => $value['id'],
                'title'             => $value['first_name'].' '.$value['last_name'],
                'backgroundColor'   => $value['calendar_color']
            ];
        }
        return response()->json($data);
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

        $data       = [];
        if($services)
        {
            foreach ($services as $value) {
                $data[] = [
                    'id'                => $value['id'],
                    'service_name'      => $value['service_name'],
                    'parent_category'   => $value['parent_category']
                ];
            }
        }

        return response()->json($data);
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
        $data = [];

        foreach ($clients as $client) {
            $clientData = [
                'id'                    => $client->id,
                'first_name'            => $client->firstname,
                'last_name'             => $client->lastname,
                'email'                 => $client->email,
                'mobile_no'             => $client->mobile_number,
                'date_of_birth'         => $client->date_of_birth,
                'gender'                => $client->gender,
                'home_phone'            => $client->home_phone,
                'work_phone'            => $client->work_phone,
                'contact_method'        => $client->contact_method,
                'send_promotions'       => $client->send_promotions,
                'street_address'        => $client->street_address,
                'suburb'                => $client->suburb,
                'city'                  => $client->city,
                'postcode'              => $client->postcode,
                'client_photos'         => [],
                'client_documents'      => []
            ];

            $clientData['last_appointment'] = [];
            if(isset($client->last_appointment))
            {
                $clientData['last_appointment'] = [
                    'service_name'      => isset($client->last_appointment) ? $client->last_appointment->services->service_name : '',
                    'start_date'        => isset($client->last_appointment) ? $client->last_appointment->start_date : '',
                    'staff_name'        => isset($client->last_appointment) ? $client->last_appointment->staff->name : '',
                    'location_name'     => isset($client->last_appointment) ? $client->last_appointment->staff->staff_location->location_name : '',
                    'status'            => isset($client->last_appointment) ? $client->last_appointment->appointment_status : '',
                ];
            }

            // Fetch client photos for the current client
            $clientPhotos = ClientsPhotos::where('client_id', $client->id)->get();
            foreach ($clientPhotos as $photo) {
                $clientData['client_photos'][] = 
                [
                    'id'     => $photo->id,
                    'photo_name'   => $photo->client_photos,  // Assuming the field name is 'doc_name'
                ];
                //$photo->client_photos;
            }
            // Fetch client documents for the current client
            $clientDocuments = ClientsDocuments::where('client_id', $client->id)->get();
            foreach ($clientDocuments as $doc) {
                $clientData['client_documents'][] = [
                    'doc_id'     => $doc->id,
                    'doc_name'   => $doc->client_documents,  // Assuming the field name is 'doc_name'
                    'created_at' => $doc->created_at  // Assuming the field name is 'created_at'
                ];
            }
            $data[] = $clientData;
        }

        return response()->json($data);
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
        $data   = [];
        if($events)
        {
            foreach ($events as $value) {
                $extedendprop = [
                    'client_name'   => $value['clients']['firstname'].' '.$value['clients']['lastname'],
                    'client_id'     => $value['client_id'],
                    'service_id'    => $value['service_id'],
                    'category_id'   => $value['category_id']
                ];
                $data[] = [
                    'id'            => $value['id'],
                    'resourceId'    => $value['staff_id'],
                    'title'         => $value['services']['service_name'],
                    'start'         => $value['start_date'],
                    'end'           => $value['end_date'],
                    'extendedProps' => $extedendprop
                ];
            }
        }
        return response()->json($data);
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
                'message' => 'something went wrong!',
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
        // dd($pastappointments->note);

        if($client->last_appointment->id)
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
}
