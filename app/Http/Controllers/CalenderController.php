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
}
