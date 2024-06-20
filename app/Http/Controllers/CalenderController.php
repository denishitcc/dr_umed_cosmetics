<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentListResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\StaffListResource;
use App\Models\Appointment;
use App\Models\AppointmentForms;
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
use App\Models\DiscountCoupon;
use App\Models\LocationSurcharge;
use App\Models\ServicesAvailability;
use App\Models\ProductAvailabilities;
use App\Models\EmailTemplates;
use App\Models\FormSummary;
use Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\GiftCard;
use App\Models\GiftCardTransaction;

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
        $permission = \Auth::user()->checkPermission('calender');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $permissionValue = ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) ? '1' : '0';

            $categories = Category::get();

            $services   = Services::with(['appearoncalender'])->get();
            $staffs     = User::all();
            $todayDate  = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format
            $waitlist   = WaitlistClient::select('waitlist_client.*', 'clients.firstname', 'clients.lastname', 'clients.mobile_number', 'clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->leftjoin('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('preferred_from_date', $todayDate)
                ->get();

            foreach ($waitlist as $wait) {
                $ser_id = explode(',', $wait->service_id);
                $service_names = [];
                $service_durations = [];
                $serv_id = [];
                foreach ($ser_id as $ser) {
                    $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                    $service_appear = ServicesAppearOnCalendar::where('service_id', $ser)->first();
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
            //discount /surcharge data get
            $loc_dis = DiscountCoupon::all();
            $loc_sur = LocationSurcharge::all();

            $location = Locations::all();

            return view('calender.index')->with(
                [
                    'categories' => $categories,
                    'services'   => $services,
                    'waitlist'   => $waitlist,
                    'staffs'     => $staffs,
                    'productServiceJson'   => '',
                    'loc_dis'    => $loc_dis,
                    'loc_sur'    => $loc_sur,
                    'permissions' => $permissionValue,
                    'location'   => $location
                ]
            );
        } else {
            abort(403, 'You are not authorized to access this page.');
        }
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
        if($location == null)
        {
            $loc = Locations::first();
            $location = $loc->id;
        }
        if ($location) {
            $user = $user->where('role_type', '!=', 'admin')->where('staff_member_location', '=', $location);
        } else {
            $user = $user->where('role_type', '!=', 'admin');
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
        $services   = Services::select()->where('appear_on_calendar', 1);

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
        if(isset($request->name))
        {
            $clients = Clients::where('firstname', 'like', '%' . $request->name . '%')->where('status', 'active')->get();
        }else{
            $clients = Clients::where('id', $request->id)->where('status', 'active')->get();
        }
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
        $location = Locations::find($request->location_id);
        if (!isset($request->app_id) || $request->appt_type != 'move_appt') {
            $service_ex = explode(',', $request->service_id);
            $duration_ex = explode(',', $request->duration);
            $category_ex = explode(',', $request->category_id);
            $data = []; // Initialize an array to store response data

            try {
                DB::beginTransaction(); // Begin a transaction
                foreach ($service_ex as $key => $ser) {
                    $single_ser     = Services::where('id', $ser)->first();
                    $startDateTime  = Carbon::parse($request->start_time);
                    $duration       = $duration_ex[$key];

                    // Add duration to start_date
                    // if($key > 0) {
                    //     $startDateTime = Carbon::parse($data[$key - 1]['data']['end_date']); // Use previous end_date
                    // }
                    // Add duration to start_date
                    if ($key > 0 && isset($data[$key - 1]['data']['end_date'])) {
                        $startDateTime = Carbon::parse($data[$key - 1]['data']['end_date']); // Use previous end_date
                    }

                    $endDateTime            = $startDateTime->copy()->addMinutes($duration);
                    $formattedEndDateTime   = $endDateTime->format('Y-m-d\TH:i:s');

                    $appointmentsData = [
                        'client_id'     => $request->client_id ? $request->client_id : '',
                        'service_id'    => $ser,
                        'category_id'   => $single_ser['category_id'], //$category_ex[$key],
                        'staff_id'      => $request->staff_id,
                        'start_date'    => $startDateTime->format('Y-m-d\TH:i:s'),
                        'end_date'      => $formattedEndDateTime,
                        'duration'      => $duration,
                        'status'        => Appointment::BOOKED,
                        'current_date'  => $request->start_date,
                        'location_id'   => $request->location_id
                    ];
                    // dd($request->appt_type);
                    $appointment = Appointment::create($appointmentsData);
                    if ($appointment) {
                        $formattedDate = Carbon::parse($startDateTime->format('Y-m-d\TH:i:s'))->format('D, d-M h:ia');
                        if ($request->client_id != null && $request->client_id != 0) {
                            $client = Clients::where('id', $request->client_id)->first();
                            $client_email = $client->email;
                            $username = $client->firstname . ' ' . $client->lastname;

                            $user = User::where('id', $request->staff_id)->first();
                            $phone = $user->phone;

                            $location = Locations::where('id', $request->location_id)->first();
                            $location_name = $location->location_name ?? '';

                            $service = Services::where('id', $appointment->service_id)->first();
                            $service_name = $service->service_name;
                            if (isset($request->appt_type) && $request->appt_type == 'rebook') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Rebook Appointment')->first();
                            } else if (isset($request->appt_type) && $request->appt_type == 'move_appt') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Move Appointment')->first();
                            } else if (isset($request->appt_type) && $request->appt_type == 'waitlist') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Waitlist Appointment')->first();
                            } else {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Appointment Create')->first();
                            }

                            $_data = array('date_time' => $formattedDate, 'username' => $username, 'subject' => $emailtemplate->subject, 'location_name' => $location_name, 'phone' => $phone, 'service_name' => $service_name);

                            if ($emailtemplate) {
                                $templateContent = $emailtemplate->email_template_description;
                                // Replace placeholders in the template with actual values
                                $parsedContent = str_replace(
                                    ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                                    [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                                    $templateContent
                                );
                                $data = ([
                                    'from_email'    => 'support@itcc.net.au',
                                    'emailbody'     => $parsedContent,
                                    'subject'       => $_data['subject'],
                                    'username' => $username,
                                    'date_time' => $formattedDate,
                                    'location_name' => $location_name,
                                    'phone' => $phone,
                                    'service_name' => $service_name
                                ]);
                                $sub = $location_name . ', ' . $data['subject'];

                                // Generate the ICS file content
                                $icsContent = $this->generateICS($appointment, $client, $user, $service, $location);
                                $icsFileName = 'appointment-' . $appointment->id . '.ics';
                                Storage::put($icsFileName, $icsContent);

                                $to_email = $client_email;
                                Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub,$icsFileName) {
                                    $message->to($to_email)
                                        ->subject($sub)
                                        ->from('support@itcc.net.au', $sub)
                                    ->attach(storage_path('app/' . $icsFileName), [
                                        'mime' => 'text/calendar'
                                    ]);
                                });
                                // Delete the ICS file after sending the email
                                Storage::delete($icsFileName);
                            }
                        }
                        $response = [
                            'success'   => true,
                            'message'   => 'Appt Confirmation send successfully!',
                            'type'      => 'success',
                        ];
                    }
                    if ($single_ser->forms != null) {
                        $this->attachForms($single_ser, $appointment);
                        $this->sendForms($request, $single_ser, $location, $appointment);
                    }

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
        } else {
            $appointmentsData = [
                'client_id'     => $request->client_id ? $request->client_id : '',
                'service_id'    => $request->service_id,
                'category_id'   => $request->category_id,
                'staff_id'      => $request->staff_id,
                'start_date'    => $request->start_time,
                'end_date'      => $request->end_time,
                'duration'      => $request->duration,
                // 'status'        => Appointment::BOOKED,
                'current_date'  => $request->start_date,
                'location_id'   => $request->location_id
            ];

            try {
                $single_ser                 = Services::where('id', $request->service_id)->first();
                $findAppointment            = Appointment::where('id', $request->app_id)->first();
                if (isset($findAppointment->id)) {
                    $findAppointment->update($appointmentsData);
                    if ($findAppointment) {
                        $formattedDate = Carbon::parse($request->start_time)->format('D, d-M h:ia');
                        if ($request->client_id != null && $request->client_id != 0) {
                            $client = Clients::where('id', $request->client_id)->first();

                            $client_email = $client->email;
                            $username = $client->firstname . ' ' . $client->lastname;

                            $user = User::where('id', $request->staff_id)->first();
                            $phone = $user->phone;

                            $location = Locations::where('id', $request->location_id)->first();
                            $location_name = $location->location_name ?? '';

                            $service = Services::where('id', $request->service_id)->first();
                            $service_name = $service->service_name;

                            if (isset($request->appt_type) && $request->appt_type == 'rebook') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Rebook Appointment')->first();
                            } else if (isset($request->appt_type) && $request->appt_type == 'move_appt') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Move Appointment')->first();
                            } else if (isset($request->appt_type) && $request->appt_type == 'waitlist') {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Waitlist Appointment')->first();
                            } else {
                                $emailtemplate = EmailTemplates::where('email_template_type', 'Appointment Create')->first();
                            }

                            $_data = array('date_time' => $formattedDate, 'username' => $username, 'subject' => $emailtemplate->subject, 'location_name' => $location_name, 'phone' => $phone, 'service_name' => $service_name);

                            if ($emailtemplate) {
                                $templateContent = $emailtemplate->email_template_description;
                                // Replace placeholders in the template with actual values
                                $parsedContent = str_replace(
                                    ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                                    [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                                    $templateContent
                                );
                                $data = ([
                                    'from_email'    => 'support@itcc.net.au',
                                    'emailbody'     => $parsedContent,
                                    'subject'       => $_data['subject'],
                                    'username' => $username,
                                    'date_time' => $formattedDate,
                                    'location_name' => $location_name,
                                    'phone' => $phone,
                                    'service_name' => $service_name
                                ]);
                                $sub = $location_name . ', ' . $data['subject'];

                                // Generate the ICS file content
                                $icsContent = $this->generateICS($findAppointment, $client, $user, $service, $location);
                                $icsFileName = 'appointment-' . $findAppointment->id . '.ics';
                                Storage::put($icsFileName, $icsContent);

                                $to_email = $client_email;
                                Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub,$icsFileName) { //
                                    $message->to($to_email)
                                        ->subject($sub)
                                        ->from('support@itcc.net.au', $sub)
                                    ->attach(storage_path('app/' . $icsFileName), [
                                        'mime' => 'text/calendar'
                                    ]);
                                });
                                // Delete the ICS file after sending the email
                                Storage::delete($icsFileName);
                            }
                        }
                        $response = [
                            'success'   => true,
                            'message'   => 'Appt Confirmation send successfully!',
                            'type'      => 'success',
                        ];
                    }
                    if ($single_ser->forms != null) {
                        $this->attachForms($single_ser, $findAppointment);
                        $this->sendForms($request, $single_ser, $location, $findAppointment);
                    }
                } else {
                    $appointmentsData['status'] = Appointment::BOOKED;
                    $appointment = Appointment::create($appointmentsData);
                    if ($appointment) {
                        // dd($appointment['start_date']);
                        $formattedDate = Carbon::parse($appointment['start_date'])->format('D, d-M h:ia');
                        // dd($formattedDate);
                        $client = Clients::where('id', $appointment['client_id'])->first();
                        $client_email = $client->email;
                        $username = $client->firstname . ' ' . $client->lastname;

                        $user = User::where('id', $appointment['staff_id'])->first();
                        $phone = $user->phone;

                        $location = Locations::where('id', $appointment['location_id'])->first();
                        $location_name = $location->location_name ?? '';

                        $service = Services::where('id', $appointment['service_id'])->first();
                        $service_name = $service->service_name;
                        if (isset($request->appt_type) && $request->appt_type == 'rebook') {
                            $emailtemplate = EmailTemplates::where('email_template_type', 'Rebook Appointment')->first();
                        } else if (isset($request->appt_type) && $request->appt_type == 'move_appt') {
                            $emailtemplate = EmailTemplates::where('email_template_type', 'Move Appointment')->first();
                        } else if (isset($request->appt_type) && $request->appt_type == 'waitlist') {
                            $emailtemplate = EmailTemplates::where('email_template_type', 'Waitlist Appointment')->first();
                        } else {
                            $emailtemplate = EmailTemplates::where('email_template_type', 'Appointment Create')->first();
                        }

                        $_data = array('date_time' => $formattedDate, 'username' => $username, 'subject' => $emailtemplate->subject, 'location_name' => $location_name, 'phone' => $phone, 'service_name' => $service_name);

                        if ($emailtemplate) {
                            $templateContent = $emailtemplate->email_template_description;
                            // Replace placeholders in the template with actual values
                            $parsedContent = str_replace(
                                ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                                [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                                $templateContent
                            );
                            $data = ([
                                'from_email'    => 'support@itcc.net.au',
                                'emailbody'     => $parsedContent,
                                'subject'       => $_data['subject'],
                                'username' => $username,
                                'date_time' => $formattedDate,
                                'location_name' => $location_name,
                                'phone' => $phone,
                                'service_name' => $service_name
                            ]);
                            $sub = $location_name . ', ' . $data['subject'];

                            // Generate the ICS file content
                            $icsContent = $this->generateICS($appointment, $client, $user, $service, $location);
                            $icsFileName = 'appointment-' . $appointment->id . '.ics';
                            Storage::put($icsFileName, $icsContent);

                            $to_email = $client_email;
                            Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub,$icsFileName) { //
                                $message->to($to_email)
                                    ->subject($sub)
                                    ->from('support@itcc.net.au', $sub)
                                ->attach(storage_path('app/' . $icsFileName), [
                                    'mime' => 'text/calendar'
                                ]);
                            });
                            // Delete the ICS file after sending the email
                            Storage::delete($icsFileName);
                        }

                        $response = [
                            'success'   => true,
                            'message'   => 'Appt Confirmation send successfully!',
                            'type'      => 'success',
                        ];
                    }
                    if ($single_ser->forms != null) {
                        $this->attachForms($single_ser, $appointment);
                        $this->sendForms($request, $single_ser, $location, $appointment);
                    }
                }
                WaitlistClient::where('id', $request->app_id)
                    ->delete();

                DB::commit();
                $data = [
                    'success' => true,
                    'message' => 'Appointment booked successfully!',
                    'type'    => 'success',
                ];
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
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
     * Method sendForms
     *
     * @param $request $request [explicite description]
     * @param $single_ser $single_ser [explicite description]
     *
     * @return void
     */
    // public function sendForms($request ,$single_ser,$location,$appointment)
    // {
    //     $clientData     = Clients::where('id',$request->client_id)->first();
    //     $to_email       = $clientData['email'];
    //     // $subject     = 'Before your appointment at '.env('APP_NAME').' '.$location['location_name'];

    //     $forms      = explode(',',$single_ser['forms']);

    //     foreach ($forms as $key => $form) {
    //         $forms      = FormSummary::find($form);
    //         $formData[] = [
    //             'form_url'      => route('serviceforms.formUser',[$appointment->id,$forms['id']]),
    //             'form_title'    => $forms['title']
    //         ];
    //         $subject    = 'Before your appointment at  fill this forms';
    //         $userData   = [
    //             'name'          => $request->client_name,
    //             'company_name'  => env('APP_NAME').', ' .$request->apptlocation,
    //             // 'form_url'      => route('serviceforms.formUser',$appointment->id)
    //             'formslinks'    => $formData
    //         ];

    //     }
    //     Mail::send('email.forms', $userData, function($message) use ($to_email,$subject) {
    //         $message->to($to_email)
    //         ->subject($subject);
    //         $message->from('support@itcc.net.au',$subject);
    //     });

    //     $dat['forms_sent_email'] = carbon::now();
    //     $appointment->update($dat);
    // }
    public function sendForms($request, $single_ser, $location, $appointment)
    {
        $clientData = Clients::where('id', $request->client_id)->first();
        $username = $clientData['firstname'] . ' ' . $clientData['lastname'];
        $to_email = $clientData['email'];

        $forms = explode(',', $single_ser['forms']);
        $formData = [];

        foreach ($forms as $key => $form) {
            $formRecord = FormSummary::find($form);
            $formData[] = [
                'form_url' => route('serviceforms.formUser', [$appointment->id, $formRecord['id']]),
                'form_title' => $formRecord['title']
            ];
        }

        $emailtemplate = EmailTemplates::where('email_template_type', 'Before your appointment at fill this forms')->first();
        $_data = [
            'username' => $username,
            'subject' => $emailtemplate->subject,
            'form_url' => $formData,
            // 'company_name' =>env('APP_NAME') . ', ' . $location['location_name'],
        ];

        // Process the form URLs to be included in the email body
        $formUrlsText = '';
        foreach ($formData as $form) {
            $formUrlsText .= "<a href='{$form['form_url']}'>{$form['form_title']}</a><br>";
        }

        // Replace placeholders in the template with actual values
        $parsedContent = str_replace(
            ['{{username}}', '{{form_url}}'],
            [$_data['username'], $formUrlsText],
            $emailtemplate->email_template_description
        );

        $userData = [
            'name' => $request->client_name,
            // 'company_name' => env('APP_NAME') . ', ' . $location['location_name'],
            'form_url' => $formUrlsText,
            'username' => $clientData['firstname'] . ' ' . $clientData['lastname'],
            'subject' => $emailtemplate->subject,
            'emailbody' => $parsedContent,
        ];

        $subject = $userData['subject'];

        Mail::send('email.forms', $userData, function ($message) use ($to_email, $subject) {
            $message->to($to_email)
                ->subject($subject);
            $message->from('support@itcc.net.au', env('APP_NAME'));
        });

        $dat['forms_sent_email'] = \Carbon\Carbon::now();
        $appointment->update($dat);
    }


    /**
     * Method attachForms
     *
     * @param $single_ser $single_ser [explicite description]
     * @param $appointment $appointment [explicite description]
     *
     * @return void
     */
    public function attachForms($single_ser, $appointment)
    {
        $appointmentFormsData = [];
        $appointmentform      = explode(',', $single_ser['forms']);

        foreach ($appointmentform as $value) {
            $appointmentFormsData[] = [
                'appointment_id'    => $appointment->id,
                'form_id'           => $value,
                'status'            => AppointmentForms::NEW
            ];
        }

        return AppointmentForms::insert($appointmentFormsData);
    }

    /**
     * Method checkAppointment
     *
     * @param Array $appointmentsData [explicite description]
     *
     * @return mixed
     */
    public function checkAppointment(array $appointmentsData)
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
        // ->where('status','!=',Appointment::COMPLETED);

        if ($request->start_date) {
            $events->whereBetween(DB::raw('DATE(start_date)'), array($request->start_date, $request->end_date));
        }
        if ($request->resourceId != 'all') {
            $events->where('staff_id', $request->resourceId);
        }

        $events = $events->get();

        // $permission = \Auth::user()->checkPermission('calender');
        // $permissionValue = ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) ? '1' : '0';

        // // Add permission to each event
        // $events->each(function ($event) use ($permissionValue) {
        //     $event->permission = $permissionValue;
        // });
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

            if (isset($findAppointment->id)) {
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

        $futureappointments = $client->allappointments()->with(['note'])->where('created_at', '>=', $todayDate)->orderby('created_at', 'desc')->get();
        $pastappointments   = $client->allappointments()->with(['note'])->where('created_at', '<=', $todayDate)->orderby('created_at', 'desc')->get();
        // dd($pastappointments->staff);
        $clientPhotos       = $client->photos;

        $allappointments    = $client->allAppointments()->pluck('id');
        $allforms           = AppointmentForms::whereIn('appointment_id', $allappointments)->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('d M Y');
        });
        $allformscount      = AppointmentForms::whereIn('appointment_id', $allappointments)->count();

        if ($client->last_appointment) {
            $appointmentNotes   = AppointmentNotes::where(['appointment_id' => $client->last_appointment->id])->first();
        }
        $html               = view('calender.partials.client_card', ['client' => $client])->render();
        $appointmenthtml    = view('calender.partials.client-appointment-card', [
            'futureappointments'  => $futureappointments,
            'pastappointments'    => $pastappointments,
            'client' => $client
        ])->render();

        $clientnoteshtml    = view('calender.partials.client-notes', [
            'appointmentNotes'  => $appointmentNotes,
            'clientPhotos'      => $clientPhotos
        ])->render();
        $formhistoryhtml    = view('calender.partials.form_history_table', ['allforms' => $allforms])->render();

        return response()->json([
            'status'                => true,
            'message'               => 'Details found.',
            'data'                  => $html,
            'appointmenthtml'       => $appointmenthtml,
            'clientnoteshtml'       => $clientnoteshtml,
            'client'                => $client,
            'allformscount'         => $allformscount,
            'allformshtml'          => $formhistoryhtml
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
            if (isset($request->commonNotes)) {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId], ['common_notes' => $request->commonNotes]);
            } else {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId], ['common_notes' => null]);
            }
            DB::commit();
            $client             = Clients::findOrFail($request->client_id);
            $clientPhotos       = $client->photos;
            $clientnoteshtml    = view('calender.partials.client-notes', [
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
    public function addAppointmentTreatmentNotes(Request $request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->treatmentNotes)) {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId], ['treatment_notes' => $request->treatmentNotes]);
            } else {
                $appointmentNotes = AppointmentNotes::updateOrCreate(['appointment_id' => $request->appointmentId], ['treatment_notes' => null]);
            }
            DB::commit();
            $client             = Clients::findOrFail($request->client_id);
            $clientPhotos       = $client->photos;
            $clientnoteshtml    = view('calender.partials.client-notes', [
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

        $clientnoteshtml    = view('calender.partials.client-notes', [
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
        if ($appointment->status == '1') {
            $appointment = Appointment::leftJoin('appointments_notes', 'appointment.id', '=', 'appointments_notes.appointment_id')
                ->where('appointment.id', $appointmentId)
                ->select('appointment.*', 'appointments_notes.common_notes','appointments_notes.treatment_notes')
                ->first();
        } else {
            $appointment = Appointment::leftjoin('appointments_notes', 'appointment.id', '=', 'appointments_notes.appointment_id')
                ->leftJoin('walk_in_retail_sale', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
                ->select('walk_in_retail_sale.id AS walk_in_id', 'appointment.*', 'appointments_notes.common_notes','appointments_notes.treatment_notes')
                ->where('appointment.id', $appointmentId)
                ->whereNull('walk_in_retail_sale.deleted_at')
                ->whereNull('appointment.deleted_at')
                ->first();
        }

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

            if (isset($findAppointment->id)) {
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
            if (isset($appointment->note->id)) {
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
                'location_id'   => $request->location_id,
            ];

            $repeat_every   = $request->repeat_every;
            $todayDate      = Carbon::now();
            $apptDate       = $request->appointment_date;
            $days           = $request->repeat_every_no;

            switch ($repeat_every) {
                case 'day':
                    $newdata = $this->appointmentDays($days, $todayDate, $request, $appointmentsData);
                    break;

                case 'week':
                    $newdata = $this->appointmentWeeks($days, $apptDate, $request, $appointmentsData);
                    break;

                case 'month':
                    $newdata = $this->appointmentMonths($days, $apptDate, $request, $appointmentsData);
                    break;

                case 'year':
                    $newdata = $this->appointmentYear($days, $apptDate, $request, $appointmentsData);
                    break;

                default:
                    # code...
                    break;
            }
            $data  = Appointment::insert($newdata);

            //mail send
            if ($data) {
                foreach ($newdata as $new) {
                    // dd($data);
                    $newObject = (object) $new;
                    // dd($newObject->start_date);
                    $formattedDate = Carbon::parse($newObject->start_date)->format('D, d-M h:ia');

                    $client = Clients::where('id', $newObject->client_id)->first();
                    $client_email = $client->email;
                    $username = $client->firstname . ' ' . $client->lastname;

                    $user = User::where('id', $newObject->staff_id)->first();
                    $phone = $user->phone;

                    $location = Locations::where('id', $newObject->location_id)->first();
                    $location_name = $location->location_name ?? '';

                    $service = Services::where('id', $newObject->service_id)->first();
                    $service_name = $service->service_name;

                    $emailtemplate = EmailTemplates::where('email_template_type', 'Repeat Appointment')->first();

                    $_data = array('date_time' => $formattedDate, 'username' => $username, 'subject' => $emailtemplate->subject, 'location_name' => $location_name, 'phone' => $phone, 'service_name' => $service_name);

                    if ($emailtemplate) {
                        $templateContent = $emailtemplate->email_template_description;
                        // Replace placeholders in the template with actual values
                        $parsedContent = str_replace(
                            ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                            [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                            $templateContent
                        );
                        $data = ([
                            'from_email'    => 'support@itcc.net.au',
                            'emailbody'     => $parsedContent,
                            'subject'       => $_data['subject'],
                            'username' => $username,
                            'date_time' => $formattedDate,
                            'location_name' => $location_name,
                            'phone' => $phone,
                            'service_name' => $service_name
                        ]);
                        $sub = $location_name . ', ' . $data['subject'];
                        // dd($newObject);
                        // Generate the ICS file content
                        $icsContent = $this->generateICS($newObject, $client, $user, $service, $location);
                        $icsFileName = 'appointment-' . $newObject->client_id . '.ics';
                        Storage::put($icsFileName, $icsContent);

                        $to_email = $client_email;
                        Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub,$icsFileName) { //
                            $message->to($to_email)
                                ->subject($sub)
                                ->from('support@itcc.net.au', $sub)
                            ->attach(storage_path('app/' . $icsFileName), [
                                'mime' => 'text/calendar'
                            ]);
                        });
                        // Delete the ICS file after sending the email
                        Storage::delete($icsFileName);  
                    }

                    $response = [
                        'success'   => true,
                        'message'   => 'Appt Confirmation send successfully!',
                        'type'      => 'success',
                    ];
                }
            }

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

    function appointmentDays($days, $todayDate, $request, $appointmentsData)
    {
        for ($i = 1; $i <= $days; $i++) {

            $latest_date = $todayDate->addDays($days);
            $appointmentsData['start_date']  = $latest_date->toDateString() . ' ' . $request->repeat_time . '' . ':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            $newdata[]  = $appointmentsData;
            if ($i == $request->no_of_appointment) {
                break;
            }

            if ($latest_date->gte($request->stop_repeating_date)) {
                break;
            }
        }
        return $newdata;
    }

    function appointmentYear($days, $apptDate, $request, $appointmentsData)
    {
        $apptDate = Carbon::parse($apptDate);
        for ($i = 1; $i <= $request->no_of_appointment; $i++) {

            $latest_date        = $apptDate->addYear($days);
            $appointmentsData['start_date']  = $latest_date->toDateString() . ' ' . $request->repeat_time . '' . ':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            if ($request->repeat_year == 1) // same date
            {
                $latest_date        = $apptDate->addYear($days);
                $firstDayOfMonth    = $latest_date->firstOfMonth();
                $weekday            = 'first ' . $request->repeat_day . ' of this month';
                $firstFridayOfMonth = $firstDayOfMonth->modify($weekday);

                $appointmentsData['start_date']  = $firstFridayOfMonth->toDateString() . ' ' . $request->repeat_time . '' . ':00';
                $latest                          = Carbon::parse($appointmentsData['start_date']);
                $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();
            }
            $newdata[]  = $appointmentsData;

            if (!empty($request->stop_repeating_date) && $latest_date->gte($request->stop_repeating_date)) {
                break;
            }
        }

        return $newdata;
    }

    function appointmentWeeks($days, $apptDate, $request, $appointmentsData)
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

            $appointmentsData['start_date']  = $latestDate->toDateString() . ' ' . $request->repeat_time . '' . ':00';
            $latest                          = Carbon::parse($appointmentsData['start_date']);
            $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();
            $newdata[]  = $appointmentsData;
        }
        return $newdata;
        // }
    }

    function appointmentMonths($days, $apptDate, $request, $appointmentsData)
    {
        $apptDate = Carbon::parse($apptDate);
        for ($i = 1; $i <= $request->no_of_appointment; $i++) {

            if ($request->repeat_month == 0) {
                $latest_date                     = $apptDate->addMonths($days);
                $appointmentsData['start_date']  = $latest_date->toDateString() . ' ' . $request->repeat_time . '' . ':00';
                $latest                          = Carbon::parse($appointmentsData['start_date']);
                $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();
            }

            if ($request->repeat_month == 1) // same date
            {
                // $latest_date        = $apptDate->addWeeks(5);
                // $latest_date        = $apptDate->nthInMonth(Carbon::FRIDAY, 5);
                $newDate = $this->addNthWeekdayInMonth($apptDate, 5, Carbon::TUESDAY);
                // $firstDayOfMonth    = $latest_date->firstOfMonth();
                // $weekday            = $latest_date->next('Wednesday')->addWeeks(5);
                // dd($latest_date);
                // $firstFridayOfMonth = $latest_date->modify($weekday);
                // $appointmentsData['start_date']  = $firstFridayOfMonth->toDateString(). ' '.$request->repeat_time.''.':00';
                // $latest                          = Carbon::parse($appointmentsData['start_date']);
                // $appointmentsData['end_date']    = $latest->addMinutes($request->duration)->toDateTimeString();

            }
            $newdata[]  = $appointmentsData;

            if (!empty($request->stop_repeating_date) && $latest_date->gte($request->stop_repeating_date)) {
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

        $data = Clients::leftJoin('appointment', function ($join) use ($currentDateTime) {
            $join->on('clients.id', '=', 'appointment.client_id')
                ->where('appointment.start_date', '>=', $currentDateTime);
        })
            ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
            ->leftJoin('users', 'appointment.staff_id', '=', 'users.id')
            ->leftJoin('locations', 'users.staff_member_location', '=', 'locations.id')
            ->leftJoin('appointments_notes', 'appointments_notes.appointment_id', '=', 'appointment.id')
            ->select(
                'clients.id',
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
            ->groupBy(
                'clients.id',
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
            ->where('clients.id', $request->id)
            ->get();
        // Prepare response data
        $app_details = [];
        foreach ($data as $datas) {
            $appointment_dates = explode(',', $datas->appointment_dates);
            $app_status = explode(',', $datas->app_status);
            $staff_locations = explode(',', $datas->staff_locations);
            $durations = explode(',', $datas->durations);
            // Ensure all arrays have the same length
            $count = max(count($appointment_dates), count($app_status), count($staff_locations));
            $appointment_dates = array_pad($appointment_dates, $count, '');
            $app_status = array_pad($app_status, $count, '');
            $staff_locations = array_pad($staff_locations, $count, '');
            $durations = array_pad($durations, $count, '');
            $service_id = $datas->service_id;
            $service_name = $datas->service_name;
            $category_id = $datas->category_id;
            $client_name = $datas->firstname . ' ' . $datas->last_name;

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
        usort($app_details, function ($a, $b) {
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
        if ($conflict == true) {
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

        $data = Clients::leftJoin('appointment', function ($join) use ($currentDateTime) {
            $join->on('clients.id', '=', 'appointment.client_id')
                ->where('appointment.start_date', '<=', $currentDateTime);
        })
            ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
            ->leftJoin('users', 'appointment.staff_id', '=', 'users.id')
            ->leftJoin('locations', 'users.staff_member_location', '=', 'locations.id')
            ->leftJoin('appointments_notes', 'appointments_notes.appointment_id', '=', 'appointment.id')
            ->select(
                'clients.id',
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
            ->groupBy(
                'clients.id',
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
            ->where('clients.id', $request->id)
            ->get();
        // Prepare response data
        $app_details = [];
        foreach ($data as $datas) {
            $appointment_dates = explode(',', $datas->appointment_dates);
            $app_status = explode(',', $datas->app_status);
            $staff_locations = explode(',', $datas->staff_locations);
            $durations = explode(',', $datas->durations);
            // Ensure all arrays have the same length
            $count = max(count($appointment_dates), count($app_status), count($staff_locations));
            $appointment_dates = array_pad($appointment_dates, $count, '');
            $app_status = array_pad($app_status, $count, '');
            $staff_locations = array_pad($staff_locations, $count, '');
            $durations = array_pad($durations, $count, '');
            $service_id = $datas->service_id;
            $service_name = $datas->service_name;
            $category_id = $datas->category_id;
            $client_name = $datas->firstname . ' ' . $datas->last_name;

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
        usort($app_details, function ($a, $b) {
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
        if ($conflict == true) {
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
    public function updateCreateAppointments(Request $request)
    {
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
                    'location_id'   => $appointmentData['location_id'],
                ];

                $appointment = Appointment::create($appointmentsData);
                if ($appointment) {
                    $formattedDate = Carbon::parse($startDateTime->format('Y-m-d\TH:i:s'))->format('D, d-M h:ia');

                    $client = Clients::where('id', $appointmentData['client_id'])->first();
                    $client_email = $client->email;
                    $username = $client->firstname . ' ' . $client->lastname;

                    $user = User::where('id', $appointmentData['staff_id'])->first();
                    $phone = $user->phone;

                    $location = Locations::where('id', $appointmentData['location_id'])->first();
                    $location_name = $location->location_name ?? '';

                    $service = Services::where('id', $appointmentData['service_id'])->first();
                    $service_name = $service->service_name;

                    $emailtemplate = EmailTemplates::where('email_template_type', 'Appointment Update')->first();

                    $_data = array('date_time' => $formattedDate, 'username' => $username, 'subject' => $emailtemplate->subject, 'location_name' => $location_name, 'phone' => $phone, 'service_name' => $service_name);

                    if ($emailtemplate) {
                        $templateContent = $emailtemplate->email_template_description;
                        // Replace placeholders in the template with actual values
                        $parsedContent = str_replace(
                            ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                            [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                            $templateContent
                        );
                        $data = ([
                            'from_email'    => 'support@itcc.net.au',
                            'emailbody'     => $parsedContent,
                            'subject'       => $_data['subject'],
                            'username' => $username,
                            'date_time' => $formattedDate,
                            'location_name' => $location_name,
                            'phone' => $phone,
                            'service_name' => $service_name
                        ]);
                        $sub = $location_name . ', ' . $data['subject'];

                        // Generate the ICS file content
                        $icsContent = $this->generateICS($appointment, $client, $user, $service, $location);
                        $icsFileName = 'appointment-' . $appointment->id . '.ics';
                        Storage::put($icsFileName, $icsContent);

                        $to_email = $client_email;
                        Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub,$icsFileName) { //
                            $message->to($to_email)
                                ->subject($sub)
                                ->from('support@itcc.net.au', $sub)
                            ->attach(storage_path('app/' . $icsFileName), [
                                'mime' => 'text/calendar'
                            ]);
                        });
                        // Delete the ICS file after sending the email
                        Storage::delete($icsFileName);
                    }

                    $response = [
                        'success'   => true,
                        'message'   => 'Appt Confirmation send successfully!',
                        'type'      => 'success',
                    ];
                }
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
    public function CreateWaitListClient(Request $request)
    {
        // dd($request->appointments[0]);
        $waitlistclient = WaitlistClient::create($request->appointments[0]);
        if ($waitlistclient) {
            if ($request->appointments[0]['client_id'] != null) {
                $client = Clients::where('id', $request->appointments[0]['client_id'])->first();
                $client_email = $client->email;
                $username = $client->firstname . ' ' . $client->lastname;

                // dd($request->appointments[0]['user_id']);
                if ($request->appointments[0]['user_id'] != null) {
                    $staff_member = User::where('id', $request->appointments[0]['user_id'])->first();
                    $staff_member = $staff_member['first_name'] . ' ' . $staff_member['last_name'];
                } else {
                    $staff_member = 'Anyone';
                }

                // $phone = $user->phone;
                $ser_ids = explode(',', $request->appointments[0]['service_id']);
                // dd($ser_ids);
                $service_names = [];
                foreach ($ser_ids as $ser) {
                    $service = Services::where('id', $ser)->first();
                    if ($service) {
                        $service_names[] = $service->service_name;
                    }
                }

                // Format service names for email template
                $formatted_service_names = implode('<br> ', array_map(function ($name, $index) {
                    return ($index + 1) . ') ' . $name;
                }, $service_names, array_keys($service_names)));

                $emailtemplate = EmailTemplates::where('email_template_type', 'New Waitlist Client')->first();
                // dd($emailtemplate);
                $_data = array('username' => $username, 'subject' => $emailtemplate->subject, 'service_name' => $formatted_service_names, 'staff_member' => $staff_member);

                if ($emailtemplate) {
                    $templateContent = $emailtemplate->email_template_description;
                    // Replace placeholders in the template with actual values
                    $parsedContent = str_replace(
                        ['{{username}}', '{{staff_member}}', '{{service_name}}'],
                        [$_data['username'], $_data['staff_member'], $_data['service_name']],
                        $templateContent
                    );
                    $data = ([
                        'from_email'    => 'support@itcc.net.au',
                        'emailbody'     => $parsedContent,
                        'subject'       => $_data['subject'],
                        'username' => $username,
                    ]);
                    $sub = $data['subject'];

                    $to_email = $client_email;
                    Mail::send('email.new_waitlist_client', $data, function ($message) use ($to_email, $sub) {
                        $message->to($to_email)
                            ->subject($sub);
                        $message->from('support@itcc.net.au', $sub);
                    });
                }
            }


            // $response = [
            //     'success'   => true,
            //     'message'   => 'Waitlist client mail send successfully!',
            //     'type'      => 'success',
            // ];
        }
        $response = [
            'success' => true,
            'message' => 'Waitlist Client Created successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function FilterCalendarDate(Request $request)
    {
        $todayDate = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format
        $staffs      = User::all();
        if ($request->is_checked == '1') {
            // dd('1');
            // $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
            //     ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
            //     ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
            //     ->where('preferred_from_date', $todayDate)
            //     ->get();
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname', 'clients.lastname', 'clients.mobile_number', 'clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->leftjoin('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('preferred_from_date', $todayDate)
                ->get();
        } else {
            // $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname','clients.lastname','clients.mobile_number','clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
            //     ->join('clients', 'waitlist_client.client_id', '=', 'clients.id')
            //     ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
            //     ->get();
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname', 'clients.lastname', 'clients.mobile_number', 'clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->leftJoin('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftJoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->get();
        }

        foreach ($waitlist as $wait) {
            $ser_id = explode(',', $wait->service_id);
            $service_names = [];
            $service_durations = [];

            foreach ($ser_id as $ser) {
                $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                $service_appear = ServicesAppearOnCalendar::where('service_id', $ser)->first();
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
        if ($request->is_checked == '1') {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname', 'clients.lastname', 'clients.mobile_number', 'clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->leftjoin('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('preferred_from_date', $todayDate)
                ->where('users.id', $request->staff_id)
                ->get();
        } else {
            $waitlist = WaitlistClient::select('waitlist_client.*', 'clients.firstname', 'clients.lastname', 'clients.mobile_number', 'clients.email', 'users.first_name as user_firstname', 'users.last_name as user_lastname')
                ->leftjoin('clients', 'waitlist_client.client_id', '=', 'clients.id')
                ->leftjoin('users', 'waitlist_client.user_id', '=', 'users.id')
                ->where('users.id', $request->staff_id)
                ->get();
            // dd($waitlist);
        }

        foreach ($waitlist as $wait) {
            $ser_id = explode(',', $wait->service_id);
            $service_names = [];
            $service_durations = [];

            foreach ($ser_id as $ser) {
                $service = Services::find($ser); // Assuming Services model has 'id' as primary key
                $service_appear = ServicesAppearOnCalendar::where('service_id', $ser)->first();
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
    public function UpdateWaitListClient(Request $request)
    {
        // dd($request->all());

        //store category id
        $c_id = $request->appointments[0]['service_id'];
        $cs_id = explode(',', $c_id);
        $category_ids = []; // Array to store category IDs
        foreach ($cs_id as $cs) {
            $sr = Services::where('id', $cs)->select('category_id')->first();
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
    public function deleteWaitlistClient(Request $request, $id)
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
        $products = Products::where('product_name', 'like', '%' . $request->name . '%')->get();
        return response()->json($products);
    }
    public function StoreWalkIn(Request $request)
    {
        // dd($request->all());
        $userName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $client_id = $request->walk_in_client_id;
        $client_email = '';

        if (isset($client_id) && $client_id != null) {
            $client = Clients::find($client_id);
            if ($client) {
                $client_email = $client->email;
            }
        }
        // hdn_discount_surcharge_type
        // casual_discount_text
        if ($request->invoice_id != '') {
            if ($request->hdn_customer_type == 'casual') {
                // For casual customers

                // Retrieve the existing walk-in sale record using the invoice_id
                $walkInSale = WalkInRetailSale::find($request->invoice_id);

                if ($walkInSale) {
                    // Update the walk-in sale details
                    $walkInSale->update([
                        'location_id' => $request->walk_in_location_id,
                        'appt_id' => $request->appt_id,
                        'customer_type' => $request->hdn_customer_type,
                        'invoice_date' => $request->casual_invoice_date,
                        'subtotal' => $request->hdn_subtotal,
                        'discount' => $request->hdn_discount,
                        'gst' => $request->hdn_gst,
                        'total' => $request->hdn_total,
                        'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                        'user_id' => $request->casual_staff,
                        'note' => $request->notes,
                        'walk_in_type' => $request->inv_type
                    ]);

                    // Update or create walk-in sale products
                    foreach ($request->casual_product_id as $index => $productId) {
                        WalkInProducts::updateOrCreate(
                            ['walk_in_id' => $request->invoice_id, 'product_id' => $productId],
                            [
                                'product_name' => $request->casual_product_name[$index],
                                'product_price' => $request->casual_product_price[$index],
                                'product_quantity' => $request->casual_product_quanitity[$index],
                                'product_type' => $request->product_type[$index],
                                'who_did_work' => ($request->casual_who_did_work[$index] && $request->casual_who_did_work[$index] == 'no one' || $request->casual_who_did_work[$index] == 'Please select') ? null : $request->casual_who_did_work[$index],
                                'product_discount_surcharge' => $request->casual_discount_surcharge[$index],
                                'discount_type' => $request->casual_discount_types[$index],
                                'discount_amount' => $request->casual_discount_amount[$index],
                                'type' => $request->hdn_discount_surcharge_type[$index],
                                'discount_value' => $request->casual_discount_text[$index],
                                'discount_reason' => $request->casual_reason[$index],
                            ]
                        );

                        if ($request->product_type[$index] == 'product') {
                            // Product quantity minus logic
                            $pAvailability = ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->first();

                            if ($pAvailability) {
                                // Calculate the new quantity by subtracting the requested quantity
                                $newQuantity = $pAvailability->quantity - $request->casual_product_quanitity[$index];
                                // Update the quantity in the database
                                $pAvailability->update(['quantity' => $newQuantity]);
                            } else {
                                // Handle the case where the product availability record doesn't exist
                            }
                        }
                    }

                    // Update walk-in sale discount/surcharge details
                    WalkInDiscountSurcharge::updateOrCreate(
                        ['walk_in_id' => $request->invoice_id],
                        [
                            'discount_surcharge' => $request->hdn_main_discount_surcharge,
                            'discount_type' => $request->hdn_main_discount_type,
                            'discount_amount' => $request->hdn_main_discount_amount,
                            'discount_reason' => $request->hdn_main_discount_reason,
                        ]
                    );

                    // Update walk-in payment details
                    // foreach ($request->payment_types as $index => $paymentType) {

                    //     $paymentAmount = $request->payment_amounts[$index];
                    //     $paymentDate = $request->payment_dates[$index];
                    //     // Update or create payment details
                    //     Payment::updateOrCreate(
                    //         ['walk_in_id' => $request->invoice_id, 'payment_type' => $paymentType],
                    //         ['amount' => $request->payment_amounts[$index], 'date' => $request->payment_dates[$index]]
                    //     );
                    // }
                    $totalPaymentAmount = 0;
                    $existingPaymentIds = []; // Store the IDs of existing payments

                    foreach ($request->payment_types as $index => $paymentType) {
                        $paymentId = $request->payment_ids[$index];
                        $paymentAmount = $request->payment_amounts[$index];
                        $paymentDate = $request->payment_dates[$index];
                        $totalPaymentAmount += $paymentAmount;

                        // Check if there is an existing payment entry for this index
                        $existingPayment = Payment::where('walk_in_id', $request->invoice_id)
                            ->where('id', $paymentId) // Assuming the payment IDs start from 1
                            ->first();

                        if ($existingPayment) {
                            // Update the existing payment entry
                            $existingPayment->update(['amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                            // $existingPaymentIds[] = $existingPayment->id; // Store the ID of updated payment
                        } else {
                            // Create a new payment entry
                            Payment::create(['walk_in_id' => $request->invoice_id, 'amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                        }
                    }
                }
            } elseif ($request->hdn_customer_type == 'existing') {
                // For existing customers

                // For casual customers

                // Retrieve the existing walk-in sale record using the invoice_id
                $walkInSale = WalkInRetailSale::find($request->invoice_id);

                if ($walkInSale) {
                    // Update the walk-in sale details
                    $walkInSale->update([
                        'client_id' => $request->walk_in_client_id,
                        'location_id' => $request->walk_in_location_id,
                        'appt_id' => $request->appt_id,
                        'customer_type' => $request->hdn_customer_type,
                        'invoice_date' => $request->casual_invoice_date,
                        'subtotal' => $request->hdn_subtotal,
                        'discount' => $request->hdn_discount,
                        'gst' => $request->hdn_gst,
                        'total' => $request->hdn_total,
                        'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                        'user_id' => $request->casual_staff,
                        'note' => $request->notes,
                        'walk_in_type' => $request->inv_type
                    ]);

                    // Update or create walk-in sale products
                    foreach ($request->casual_product_id as $index => $productId) {
                        WalkInProducts::updateOrCreate(
                            ['walk_in_id' => $request->invoice_id, 'product_id' => $productId],
                            [
                                'product_name' => $request->casual_product_name[$index],
                                'product_price' => $request->casual_product_price[$index],
                                'product_quantity' => $request->casual_product_quanitity[$index],
                                'product_type' => $request->product_type[$index],
                                'who_did_work' => ($request->casual_who_did_work[$index] && $request->casual_who_did_work[$index] == 'no one' || $request->casual_who_did_work[$index] == 'Please select') ? null : $request->casual_who_did_work[$index],
                                'product_discount_surcharge' => $request->casual_discount_surcharge[$index],
                                'discount_type' => $request->casual_discount_types[$index],
                                'discount_amount' => $request->casual_discount_amount[$index],
                                'type' => $request->hdn_discount_surcharge_type[$index],
                                'discount_value' => $request->casual_discount_text[$index],
                                'discount_reason' => $request->casual_reason[$index],
                            ]
                        );

                        if ($request->product_type[$index] == 'product') {
                            // Product quantity minus logic
                            $pAvailability = ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->first();

                            if ($pAvailability) {
                                // Calculate the new quantity by subtracting the requested quantity
                                $newQuantity = $pAvailability->quantity - $request->casual_product_quanitity[$index];
                                // Update the quantity in the database
                                $pAvailability->update(['quantity' => $newQuantity]);
                            } else {
                                // Handle the case where the product availability record doesn't exist
                            }
                        }
                    }

                    // Update walk-in sale discount/surcharge details
                    WalkInDiscountSurcharge::updateOrCreate(
                        ['walk_in_id' => $request->invoice_id],
                        [
                            'discount_surcharge' => $request->hdn_main_discount_surcharge,
                            'discount_type' => $request->hdn_main_discount_type,
                            'discount_amount' => $request->hdn_main_discount_amount,
                            'discount_reason' => $request->hdn_main_discount_reason,
                        ]
                    );

                    // Update walk-in payment details
                    // foreach ($request->payment_types as $index => $paymentType) {

                    //     $paymentAmount = $request->payment_amounts[$index];
                    //     $paymentDate = $request->payment_dates[$index];
                    //     // Update or create payment details
                    //     Payment::updateOrCreate(
                    //         ['walk_in_id' => $request->invoice_id, 'payment_type' => $paymentType],
                    //         ['amount' => $request->payment_amounts[$index], 'date' => $request->payment_dates[$index]]
                    //     );
                    // }
                    $totalPaymentAmount = 0;
                    foreach ($request->payment_types as $index => $paymentType) {
                        $paymentId = $request->payment_ids[$index];
                        $paymentAmount = $request->payment_amounts[$index];
                        $paymentDate = $request->payment_dates[$index];
                        $totalPaymentAmount += $paymentAmount;
                        // Check if there is an existing payment entry for this index
                        $existingPayment = Payment::where('walk_in_id', $request->invoice_id)
                            ->where('id', $paymentId) // Assuming the payment IDs start from 1
                            ->first();

                        if ($existingPayment) {
                            // Update the existing payment entry
                            $existingPayment->update(['amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                        } else {
                            // Create a new payment entry
                            Payment::create(['walk_in_id' => $request->invoice_id, 'amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                        }
                    }
                }
            } else {
                // For new customers

                // Similar logic as for casual customers
                $walkInSale = WalkInRetailSale::find($request->invoice_id);

                if ($walkInSale) {
                    // Update the walk-in sale details
                    $walkInSale->update([
                        'client_id' => $request->walk_in_client_id,
                        'appt_id' => $request->appt_id,
                        'location_id' => $request->walk_in_location_id,
                        'customer_type' => $request->hdn_customer_type,
                        'invoice_date' => $request->casual_invoice_date,
                        'subtotal' => $request->hdn_subtotal,
                        'discount' => $request->hdn_discount,
                        'gst' => $request->hdn_gst,
                        'total' => $request->hdn_total,
                        'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                        'user_id' => $request->casual_staff,
                        'note' => $request->notes,
                        'walk_in_type' => $request->inv_type
                    ]);

                    // Update or create walk-in sale products
                    foreach ($request->casual_product_id as $index => $productId) {
                        WalkInProducts::updateOrCreate(
                            ['walk_in_id' => $request->invoice_id, 'product_id' => $productId],
                            [
                                'product_name' => $request->casual_product_name[$index],
                                'product_price' => $request->casual_product_price[$index],
                                'product_quantity' => $request->casual_product_quanitity[$index],
                                'product_type' => $request->product_type[$index],
                                'who_did_work' => ($request->casual_who_did_work[$index] && $request->casual_who_did_work[$index] == 'no one' || $request->casual_who_did_work[$index] == 'Please select') ? null : $request->casual_who_did_work[$index],
                                'product_discount_surcharge' => $request->casual_discount_surcharge[$index],
                                'discount_type' => $request->casual_discount_types[$index],
                                'discount_amount' => $request->casual_discount_amount[$index],
                                'type' => $request->hdn_discount_surcharge_type[$index],
                                'discount_value' => $request->casual_discount_text[$index],
                                'discount_reason' => $request->casual_reason[$index],
                            ]
                        );

                        if ($request->product_type[$index] == 'product') {
                            // Product quantity minus logic
                            $pAvailability = ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->first();

                            if ($pAvailability) {
                                // Calculate the new quantity by subtracting the requested quantity
                                $newQuantity = $pAvailability->quantity - $request->casual_product_quanitity[$index];
                                // Update the quantity in the database
                                $pAvailability->update(['quantity' => $newQuantity]);
                            } else {
                                // Handle the case where the product availability record doesn't exist
                            }
                        }
                    }

                    // Update walk-in sale discount/surcharge details
                    WalkInDiscountSurcharge::updateOrCreate(
                        ['walk_in_id' => $request->invoice_id],
                        [
                            'discount_surcharge' => $request->hdn_main_discount_surcharge,
                            'discount_type' => $request->hdn_main_discount_type,
                            'discount_amount' => $request->hdn_main_discount_amount,
                            'discount_reason' => $request->hdn_main_discount_reason,
                        ]
                    );

                    // Update walk-in payment details
                    // foreach ($request->payment_types as $index => $paymentType) {

                    //     $paymentAmount = $request->payment_amounts[$index];
                    //     $paymentDate = $request->payment_dates[$index];
                    //     // Update or create payment details
                    //     Payment::updateOrCreate(
                    //         ['walk_in_id' => $request->invoice_id, 'payment_type' => $paymentType],
                    //         ['amount' => $request->payment_amounts[$index], 'date' => $request->payment_dates[$index]]
                    //     );
                    // }
                    $totalPaymentAmount = 0;
                    foreach ($request->payment_types as $index => $paymentType) {
                        $paymentId = $request->payment_ids[$index];
                        $paymentAmount = $request->payment_amounts[$index];
                        $paymentDate = $request->payment_dates[$index];
                        $totalPaymentAmount += $paymentAmount;
                        // Check if there is an existing payment entry for this index
                        $existingPayment = Payment::where('walk_in_id', $request->invoice_id)
                            ->where('id', $paymentId) // Assuming the payment IDs start from 1
                            ->first();

                        if ($existingPayment) {
                            // Update the existing payment entry
                            $existingPayment->update(['amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                        } else {
                            // Create a new payment entry
                            Payment::create(['walk_in_id' => $request->invoice_id, 'amount' => $paymentAmount, 'date' => $paymentDate, 'payment_type' => $paymentType]);
                        }
                    }
                }
            }
        } else {
            if ($request->hdn_customer_type == 'casual') {
                // Storing walk-in sale details
                $walk_in_table = [
                    'location_id' => $request->walk_in_location_id,
                    'appt_id' => $request->appt_id,
                    'customer_type' => $request->hdn_customer_type,
                    'invoice_date' => $request->casual_invoice_date,
                    'subtotal' => $request->hdn_subtotal,
                    'discount' => $request->hdn_discount,
                    'gst' => $request->hdn_gst,
                    'total' => $request->hdn_total,
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                    'user_id' => $request->casual_staff,
                    'note' => $request->notes,
                    'walk_in_type' => $request->inv_type
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
                        'type' => $request->hdn_discount_surcharge_type[$index],
                        'discount_value' => $request->casual_discount_text[$index],
                        'discount_reason' => $request->casual_reason[$index],
                    ];
                    WalkInProducts::create($walk_in_product);

                    if ($request->product_type[$index] == 'product') {
                        //product quanitity minus logic
                        $p_availbility = ProductAvailabilities::where('product_id', $productId)
                            ->where('location_name', $request->walk_in_location_id)
                            ->first(); // Retrieve product availability record

                        if ($p_availbility) {
                            // Calculate the new quantity by subtracting the requested quantity
                            $newQuantity = $p_availbility->quantity - $request->casual_product_quanitity[$index];

                            // Update the quantity in the database
                            ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->update(['quantity' => $newQuantity]);
                        } else {
                            // dd('Product availability record not found'); // Handle the case where the product availability record doesn't exist
                        }
                    }
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
                $totalPaymentAmount = 0;
                // Storing walk-in payment details
                foreach ($request->payment_types as $index => $paymentType) {
                    // Access payment details using the same index
                    $paymentAmount = $request->payment_amounts[$index];
                    $paymentDate = $request->payment_dates[$index];
                    $totalPaymentAmount += $paymentAmount;
                    // Now you can create your payment record
                    $walk_in_payment = [
                        'walk_in_id' => $walkInSale->id,
                        'payment_type' => $paymentType,
                        'amount' => $paymentAmount,
                        'date' => $paymentDate,
                    ];

                    Payment::create($walk_in_payment);
                }

                //gift card transaction
                $redeem_number = $request->hdn_tracking_number;
                // dd($request->all());
                if(isset($redeem_number))
                {
                    $locs = Locations::where('id',$request->walk_in_location_id)->first();
                    // dd($locs->location_name);
                    foreach($redeem_number as $key => $redeem)
                    {
                        $value = $request->payment_amounts[$key];
                        $gift_card = GiftCard::where('tracking_number',$redeem)->first();
                        if ($gift_card) {
                            $addgifttransaction = GiftCardTransaction::create([
                                'gift_card_id' => $gift_card->id,
                                'date_time' => Carbon::now()->setTimezone('Asia/Kolkata'),
                                'location_name' => $locs->location_name,
                                'redeemed_value' =>  $value,
                                'redeemed_value_type' => 'redeemed by Casual Customer',
                                'invoice_number' => $walkInSale->id,
                            ]);
                            //minus remain amount
                            $gift_card->update(['remaining_value'=> $gift_card->remaining_value - $value]);
                        }        
                    }
                }
            } else if ($request->hdn_customer_type == 'existing') {
                // Storing walk-in sale details
                $walk_in_table = [
                    'client_id' => $request->walk_in_client_id,
                    'location_id' => $request->walk_in_location_id,
                    'appt_id' => $request->appt_id,
                    'customer_type' => $request->hdn_customer_type,
                    'invoice_date' => $request->casual_invoice_date,
                    'subtotal' => $request->hdn_subtotal,
                    'discount' => $request->hdn_discount,
                    'gst' => $request->hdn_gst,
                    'total' => $request->hdn_total,
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                    'user_id' => $request->casual_staff,
                    'note' => $request->notes,
                    'walk_in_type' => $request->inv_type
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
                        'type' => $request->hdn_discount_surcharge_type[$index],
                        'discount_value' => $request->casual_discount_text[$index],
                        // 'edit_amount' => $request->casual_edit_amount[$index],
                        'discount_reason' => $request->casual_reason[$index],
                    ];
                    WalkInProducts::create($walk_in_product);
                    if ($request->product_type[$index] == 'product') {
                        //product quanitity minus logic
                        $p_availbility = ProductAvailabilities::where('product_id', $productId)
                            ->where('location_name', $request->walk_in_location_id)
                            ->first(); // Retrieve product availability record

                        if ($p_availbility) {
                            // Calculate the new quantity by subtracting the requested quantity
                            $newQuantity = $p_availbility->quantity - $request->casual_product_quanitity[$index];

                            // Update the quantity in the database
                            ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->update(['quantity' => $newQuantity]);
                        } else {
                            // dd('Product availability record not found'); // Handle the case where the product availability record doesn't exist
                        }
                    }
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
                $totalPaymentAmount = 0;
                // Storing walk-in payment details
                foreach ($request->payment_types as $index => $paymentType) {
                    // Access payment details using the same index
                    $paymentAmount = $request->payment_amounts[$index];
                    $paymentDate = $request->payment_dates[$index];
                    $totalPaymentAmount += $paymentAmount;
                    // Now you can create your payment record
                    $walk_in_payment = [
                        'walk_in_id' => $walkInSale->id,
                        'payment_type' => $paymentType,
                        'amount' => $paymentAmount,
                        'date' => $paymentDate,
                    ];

                    Payment::create($walk_in_payment);
                }

                //gift card transaction
                //fetch client name by client id
                $client_names = Clients::where('id',$request->walk_in_client_id)->first();
                $redeem_number = $request->hdn_tracking_number;
                // dd($request->all());
                if(isset($redeem_number))
                {
                    $locs = Locations::where('id',$request->walk_in_location_id)->first();
                    // dd($locs->location_name);
                    foreach($redeem_number as $key => $redeem)
                    {
                        $value = $request->payment_amounts[$key];
                        $gift_card = GiftCard::where('tracking_number',$redeem)->first();
                        if ($gift_card) {
                            $addgifttransaction = GiftCardTransaction::create([
                                'gift_card_id' => $gift_card->id,
                                'date_time' => Carbon::now()->setTimezone('Asia/Kolkata'),
                                'location_name' => $locs->location_name,
                                'redeemed_value' =>  $value,
                                'redeemed_value_type' => 'redeemed by ' . $client_names->firstname . ' ' . $client_names->lastname,
                                'invoice_number' => $walkInSale->id,
                            ]);
                            //minus remain amount
                            $gift_card->update(['remaining_value'=> $gift_card->remaining_value - $value]);
                        }        
                    }
                }
            } else {
                // dd($request->all());
                //store client details
                $newUser = Clients::create([
                    'location_id'=>$request->walk_in_location_id,
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
                    'location_id' => $request->walk_in_location_id,
                    'appt_id' => $request->appt_id,
                    'customer_type' => $request->hdn_customer_type,
                    'invoice_date' => $request->casual_invoice_date,
                    'subtotal' => $request->hdn_subtotal,
                    'discount' => $request->hdn_discount,
                    'gst' => $request->hdn_gst,
                    'total' => $request->hdn_total,
                    'remaining_balance' => str_replace('$', '', $request->remaining_balance),
                    'user_id' => $request->casual_staff,
                    'note' => $request->notes,
                    'walk_in_type' => $request->inv_type
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
                        'product_type' => $request->product_type[$index],
                        'product_quantity' => $request->casual_product_quanitity[$index],
                        'who_did_work' => ($request->casual_who_did_work[$index] && $request->casual_who_did_work[$index] == 'no one' || $request->casual_who_did_work[$index] == 'Please select') ? null : $request->casual_who_did_work[$index],
                        'product_discount_surcharge' => $request->casual_discount_surcharge[$index],
                        'discount_type' => $request->casual_discount_types[$index],
                        'discount_amount' => $request->casual_discount_amount[$index],
                        'type' => $request->hdn_discount_surcharge_type[$index],
                        'discount_value' => $request->casual_discount_text[$index],
                        // 'edit_amount' => $request->casual_edit_amount[$index],
                        'discount_reason' => $request->casual_reason[$index],
                    ];

                    WalkInProducts::create($walk_in_product);
                    if ($request->product_type[$index] == 'product') {
                        //product quanitity minus logic
                        $p_availbility = ProductAvailabilities::where('product_id', $productId)
                            ->where('location_name', $request->walk_in_location_id)
                            ->first(); // Retrieve product availability record

                        if ($p_availbility) {
                            // Calculate the new quantity by subtracting the requested quantity
                            $newQuantity = $p_availbility->quantity - $request->casual_product_quanitity[$index];

                            // Update the quantity in the database
                            ProductAvailabilities::where('product_id', $productId)
                                ->where('location_name', $request->walk_in_location_id)
                                ->update(['quantity' => $newQuantity]);
                        } else {
                            // dd('Product availability record not found'); // Handle the case where the product availability record doesn't exist
                        }
                    }
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
                $totalPaymentAmount = 0;
                // Storing walk-in payment details
                foreach ($request->payment_types as $index => $paymentType) {
                    // Access payment details using the same index
                    $paymentAmount = $request->payment_amounts[$index];
                    $paymentDate = $request->payment_dates[$index];
                    $totalPaymentAmount += $paymentAmount;
                    // Now you can create your payment record
                    $walk_in_payment = [
                        'walk_in_id' => $walkInSale->id,
                        'payment_type' => $paymentType,
                        'amount' => $paymentAmount,
                        'date' => $paymentDate,
                    ];

                    Payment::create($walk_in_payment);
                }

                //gift card transaction
                $redeem_number = $request->hdn_tracking_number;
                if(isset($redeem_number))
                {
                    // dd($request->all());
                    $locs = Locations::where('id',$request->walk_in_location_id)->first();
                    // dd($locs->location_name);
                    foreach($redeem_number as $key => $redeem)
                    {
                        $value = $request->payment_amounts[$key];
                        $gift_card = GiftCard::where('tracking_number',$redeem)->first();
                        if ($gift_card) {
                            $addgifttransaction = GiftCardTransaction::create([
                                'gift_card_id' => $gift_card->id,
                                'date_time' => Carbon::now()->setTimezone('Asia/Kolkata'),
                                'location_name' => $locs->location_name,
                                'redeemed_value' =>  $value,
                                'redeemed_value_type' => 'redeemed by ' . $request->walkin_first_name . ' ' . $request->walkin_last_name,
                                'invoice_number' => $walkInSale->id,
                            ]);
                            //minus remain amount
                            $gift_card->update(['remaining_value'=> $gift_card->remaining_value - $value]);
                        }        
                    }
                }
            }
        }
        if ($request->appt_id != '') {
            Appointment::where('id', $request->appt_id)->update(['status' => 4]);
        }

        return response()->json(['success' => true, 'message' => 'Walk-In created successfully', 'amount' => $totalPaymentAmount, 'walk_in_id' => isset($walkInSale->id) ? $walkInSale->id : $request->invoice_id, 'username' => $userName, 'client_email' => $client_email]);
    }
    public function GetLocation(Request $request)
    {
        $location_id = $request->loc_id;

        $all_services = Services::select('services.id', 'services.service_name', 'services.standard_price')
            ->with(['appearoncalender'])
            ->join('services_availabilities', 'services.id', '=', 'services_availabilities.service_id')
            ->where('services_availabilities.availability', 'Available')
            ->where('services_availabilities.location_name', $location_id)
            ->get();

        $all_products = DB::table('products')
            ->select('products.id', 'products.product_name', 'products.price AS p_price', 'products.gst_code', 'product_availabilities.price AS availability_price', 'product_availabilities.*')
            ->join('product_availabilities', 'products.id', '=', 'product_availabilities.product_id')
            ->where('product_availabilities.availability', 'Available')
            ->where('products.type', 'Retail')
            ->where('product_availabilities.location_name', $location_id)
            ->get();

        // Initialize an empty array to store the merged data
        $mergedArray = [];

        // Extract and format services data
        foreach ($all_services as $service) {
            $mergedArray[] = [
                'id'    => $service->id,
                'name'  => $service->service_name,
                'price' => $service->standard_price ?? 0,
                'gst'   => 'yes',
                'product_type' => 'service'
            ];
        }
        // Extract and format products data
        foreach ($all_products as $product) {
            $gst = $product->gst_code === 'Standard' ? 'yes' : 'no';

            $mergedArray[] = [
                'id'    => $product->product_id,
                'name'  => $product->product_name,
                'price' => $product->availability_price != null ? $product->availability_price ?? 0 : $product->p_price ?? 0,
                'gst'   => $gst,
                'product_type' => 'product'
            ];
        }

        // Convert the merged array to JSON format
        $mergedProductService = $mergedArray;
        // dd($mergedProductService);
        $loc_dis = DiscountCoupon::where('location_id',$location_id)->get();
        $loc_sur = LocationSurcharge::where('location_id',$location_id)->get();

        $data = [
            'mergedProductService' => $mergedProductService,
            'loc_dis' => $loc_dis,
            'loc_sur' => $loc_sur
        ];

        return response()->json($data);
    }

    /**
     * Method getCategoriesAndServices
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function getCategoriesAndServices(Request $request)
    {
        $services   = ServicesAvailability::select()->with([
            'service',
            'category',
            // 'service.appearoncalender',
            'appearoncalender'
        ])->join("services", "services.id", "=", "services_availabilities.service_id");

        if ($request->location_id) {
            $services->where('location_name', $request->location_id)->where('availability', 'Available');
        }
        $services               = $services->where('services.appear_on_calendar', 1);
        $services               = $services->get();
        $availablecategories    = $services->pluck('category_id')->unique();

        $categories             = Category::whereIn('id', $availablecategories)->get();

        $categorieshtml    = view('calender.partials.categories', [
            'categories'        => $categories
        ])->render();

        $serviceshtml    = view('calender.partials.services', [
            'services'        => $services
        ])->render();

        return response()->json([
            'status'                => true,
            'message'               => 'Details found.',
            'categorieshtml'        => $categorieshtml,
            'serviceshtml'          => $serviceshtml
        ], 200);
    }
    public function paidInvoice(Request $request)
    {
        $walk_ids = $request->input('walk_ids');

        // Retrieve the main invoice data
        $invoice = DB::table('walk_in_retail_sale')
            ->where('id', $walk_ids)
            ->first();

        $client_name = ''; // Default value is an empty string
        if ($invoice->client_id !== null) {
            $client_details = Clients::where('id', $invoice->client_id)->first();
            $client_name = $client_details->firstname . ' ' . $client_details->lastname;
        }

        $invoice->client_name = $client_name;

        // Check if the invoice exists
        if ($invoice) {
            // Retrieve all products associated with the invoice
            $products = WalkInProducts::where('walk_in_id', $walk_ids)->get();

            // Loop through each product to attach user_full_name
            foreach ($products as $prd) {
                $user_id = $prd->who_did_work;
                if ($user_id == null) {
                    $prd->user_full_name = '';
                } else {
                    $user = User::where('id', $user_id)->first();
                    // Add user_full_name to each product object
                    $prd->user_full_name = "With " . $user->first_name . ' ' . $user->last_name;
                }
            }

            // Attach the products to the invoice
            $invoice->products = $products;

            // Retrieve all discount surcharges associated with the invoice
            $discount_surcharge = WalkInDiscountSurcharge::where('walk_in_id', $walk_ids)->get();

            // Attach the discount surcharges to the invoice
            $invoice->discount_surcharges = $discount_surcharge;

            // Retrieve all payments associated with the invoice
            $payment = Payment::where('walk_in_id', $walk_ids)->get();

            // Attach the payments to the invoice
            $invoice->payments = $payment;
        }
        // dd($invoice);
        // Now $invoice contains the main invoice data along with its associated products
        return response()->json(['success' => true, 'invoice' => $invoice]);
    }
    public function deleteWalkIn(Request $request, $id)
    {
        try {
            //change status to 1
            $walkin = WalkInRetailSale::where('id', $id)->first();
            Appointment::where('id', $walkin->appt_id)->update(['status' => 1]);

            WalkInRetailSale::findOrFail($id)->delete();
            WalkInProducts::where('walk_in_id', $id)->delete();
            WalkInDiscountSurcharge::where('walk_in_id', $id)->delete();
            Payment::where('walk_in_id', $id)->delete();

            $data = [
                'success' => true,
                'message' => 'Walk-in deleted successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            $data = [
                'success' => false,
                'message' => $th->getMessage(),
                'type'    => 'fail',
            ];
        }
        return response()->json($data);
    }
    public function editInvoice(Request $request)
    {
        $walk_ids = $request->input('walk_ids');

        // Retrieve the main invoice data
        $invoice = DB::table('walk_in_retail_sale')
            ->where('id', $walk_ids)
            ->first();

        $client_name = ''; // Default value is an empty string
        if ($invoice->client_id !== null) {
            $client_details = Clients::where('id', $invoice->client_id)->first();
            $client_name = $client_details->firstname . ' ' . $client_details->lastname;
        }

        $invoice->client_name = $client_name;

        // Check if the invoice exists
        if ($invoice) {
            // Retrieve all products associated with the invoice
            $products = WalkInProducts::where('walk_in_id', $walk_ids)->get();

            // Loop through each product to attach user_full_name
            foreach ($products as $prd) {
                $user_id = $prd->who_did_work;
                if ($user_id == null) {
                    $prd->user_full_name = '';
                } else {
                    $user = User::where('id', $user_id)->first();
                    // Add user_full_name to each product object
                    $prd->user_full_name = "With " . $user->first_name . ' ' . $user->last_name;
                }
            }

            // Attach the products to the invoice
            $invoice->products = $products;

            // Retrieve all discount surcharges associated with the invoice
            $discount_surcharge = WalkInDiscountSurcharge::where('walk_in_id', $walk_ids)->get();

            // Attach the discount surcharges to the invoice
            $invoice->discount_surcharges = $discount_surcharge;

            // Retrieve all payments associated with the invoice
            $payment = Payment::where('walk_in_id', $walk_ids)->get();

            // Attach the payments to the invoice
            $invoice->payments = $payment;
        }
        // dd($invoice);
        // Now $invoice contains the main invoice data along with its associated products
        return response()->json(['success' => true, 'invoice' => $invoice]);
    }
    public function sendPaymentMail(Request $request)
    {
        // dd($request->all());
        $emailtemplate = EmailTemplates::where('email_template_type', 'Payment Completed')->first();

        $walk_ids = $request->walk_in_id;

        // Retrieve the main invoice data
        $invoice = DB::table('walk_in_retail_sale')
            ->where('id', $walk_ids)
            ->first();

        $client_name = ''; // Default value is an empty string
        if ($invoice->client_id !== null) {
            $client_details = Clients::where('id', $invoice->client_id)->first();
            $client_name = $client_details->firstname . ' ' . $client_details->lastname;
        }

        $invoice->client_name = $client_name;

        // Check if the invoice exists
        if ($invoice) {
            // Retrieve all products associated with the invoice
            $products = WalkInProducts::where('walk_in_id', $walk_ids)->get();

            // Loop through each product to attach user_full_name
            foreach ($products as $prd) {
                $user_id = $prd->who_did_work;
                if ($user_id == null) {
                    $prd->user_full_name = '';
                } else {
                    $user = User::where('id', $user_id)->first();
                    // Add user_full_name to each product object
                    $prd->user_full_name = "With " . $user->first_name . ' ' . $user->last_name;
                }
            }

            // Attach the products to the invoice
            $invoice->products = $products;

            // Retrieve all discount surcharges associated with the invoice
            $discount_surcharge = WalkInDiscountSurcharge::where('walk_in_id', $walk_ids)->get();

            // Attach the discount surcharges to the invoice
            $invoice->discount_surcharges = $discount_surcharge;

            // Retrieve all payments associated with the invoice
            $payment = Payment::where('walk_in_id', $walk_ids)->get();

            // Attach the payments to the invoice
            $invoice->payments = $payment;
        }

        $_data = [
            'subject' => 'TAX INVOICE / RECEIPT',
        ];

        $totalPaid = $invoice->payments->sum('amount');
        $invoice->total_paid = $totalPaid;
        if($totalPaid > $invoice->total)
        {
            $invoice->change = $totalPaid - $invoice->total;
        }
        // Explode email addresses if comma-separated
        $emails = explode(',', $request->email);

        foreach ($emails as $email) {
            $data = [
                'from_email' => 'support@itcc.net.au',
                'subject' => $_data['subject'],
                'invoice' => $invoice, // Include the invoice data here
            ];

            $sub = $data['subject'];

            Mail::send('email.payment-success', $data, function ($message) use ($email, $sub) {
                $message->to(trim($email)) // Trim whitespace from email address
                    ->subject($sub);
                $message->from('support@itcc.net.au', $sub);
            });
        }

        return response()->json(['success' => true]);
    }
    public function getUserSelectedLocation(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $user = User::where('id', $userId)->first();
            $roleType = $user->role_type;
            if ($roleType === 'admin') {
                // Admin logic here (if needed)
                $staff_loc = $user->staff_member_location;
                return response()->json(['success' => true, 'staff_loc' => $staff_loc, 'type' => 'admin']);
            } else {
                $staff_loc = $user->staff_member_location;
                if($staff_loc == null)
                {
                    $locations = Locations::first();
                    $staff_loc = $locations->id;
                }
                return response()->json(['success' => true, 'staff_loc' => $staff_loc, 'type' => 'user']);
            }
        }
    }
    /**
     * Method getAppointmentForms
     *
     * @return mixed
     */
    public function getAppointmentForms($appointmentId)
    {
        $appointmentForms   = [];
        $forms              = AppointmentForms::where('appointment_id', $appointmentId)->get();
        $appointment        = Appointment::find($appointmentId);
        $clientName         = 'client';
        $clientEmail        = '';
        $clientPhone        = '';

        if($appointment->clients)
        {
            $clientName         = $appointment->clients->firstname ? $appointment->clients->firstname : '';
            $clientEmail        = $appointment->clients->email ? $appointment->clients->email : '';
            $clientPhone        = $appointment->clients->mobile_number ? $appointment->clients->mobile_number : '';
        }

        $apptlocation       = $appointment->location->location_name;
        $apptid             = $appointment->id;
        $email_time         = Carbon::parse($appointment->forms_sent_email)->format('H:i a, D dS M Y');
        $html               = view('calender.partials.attachforms',     ['forms' => $forms , 'clientname'        => $clientName])->render();
        $existingformshtml  = view('calender.partials.copy-form-list',  ['forms' => $forms])->render();

        return response()->json([
            'status'            => true,
            'message'           => 'Details found.',
            'formshtml'         => $html,
            'existingformshtml' => $existingformshtml,
            'clientname'        => $clientName,
            'clientemail'       => $clientEmail,
            'clientphone'       => $clientPhone,
            'apptlocation'      => $apptlocation,
            'apptid'            => $apptid,
            'email_time'        => $email_time
        ], 200);
    }

    public function addAppointmentForms(Request $request)
    {
        try {
            $appointmentFormsData[] = [
                'appointment_id'    => $request->appointment_id,
                'form_id'           => $request->form_id,
                'status'            => AppointmentForms::NEW
            ];

            $appointment        = AppointmentForms::insert($appointmentFormsData);
            $data = [
                'success' => true,
                'message' => 'Appointment form added successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            $data = [
                'success' => false,
                'message' => $th->getMessage(),
                'type'    => 'fail',
            ];
        }
        return $data;
    }

    public function deleteAppointmentForms($id)
    {
        try {

            $deleteappointmentforms = AppointmentForms::find($id);
            $deleteappointmentforms->delete();

            $data = [
                'success' => true,
                'message' => 'Appointment form deleted successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => false,
                'message' => $th->getMessage(),
                'type'    => 'fail',
            ];
        }
        return $data;
    }

    // public function sentForms(Request $request)
    // {
    //     try {
    //         $formsId        = $request['forms_id'];
    //         $appointment    = Appointment::find($request->apptid);
    //         $to_email       = $request->clientemail;
    //         foreach ($formsId as $key => $form) {
    //             $forms      = FormSummary::find($form);
    //             $formData[] = [
    //                 'form_url'      => route('serviceforms.formUser', [$appointment->id, $forms['id']]),
    //                 'form_title'    => $forms['title']
    //             ];
    //             $subject    = 'Before your appointment at  fill this forms';
    //             $userData   = [
    //                 'name'          => $request->client_name,
    //                 'company_name'  => env('APP_NAME') . ', ' . $request->apptlocation,
    //                 // 'form_url'      => route('serviceforms.formUser',$appointment->id)
    //                 'formslinks'    => $formData
    //             ];
    //         }
    //         Mail::send('email.forms', $userData, function ($message) use ($to_email, $subject) {
    //             $message->to($to_email)
    //                 ->subject($subject);
    //             $message->from('support@itcc.net.au', $subject);
    //         });

    //         $dat['forms_sent_email'] = carbon::now();
    //         $appointment->update($dat);

    //         $data = [
    //             'success' => true,
    //             'message' => 'Appointment form sent successfully!',
    //             'type'    => 'success',
    //         ];
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         $data = [
    //             'success' => false,
    //             'message' => $th->getMessage(),
    //             'type'    => 'fail',
    //         ];
    //     }

    //     return $data;
    // }

    public function sentForms(Request $request)
    {
        try {
            $formsId        = $request['forms_id'];
            $appointment    = Appointment::find($request->apptid);
            $to_email       = $request->clientemail;
            foreach ($formsId as $key => $form) {
                $forms      = FormSummary::find($form);
                $formData[] = [
                    'form_url'      => route('serviceforms.formUser', [$appointment->id, $forms['id']]),
                    'form_title'    => $forms['title']
                ];
                $emailtemplate = EmailTemplates::where('email_template_type', 'Before your appointment at fill this forms')->first();
                $subject    = $emailtemplate->subject;
                $userData   = [
                    'username'          => $request->client_name,
                    'company_name'  => env('APP_NAME') . ', ' . $request->apptlocation,
                    // 'form_url'      => route('serviceforms.formUser',$appointment->id)
                    'form_url'    => $formData,
                    'subject' => $emailtemplate->subject,
                ];
            }

            // Process the form URLs to be included in the email body
            $formUrlsText = '';
            foreach ($formData as $form) {
                $formUrlsText .= "<a href='{$form['form_url']}'>{$form['form_title']}</a><br>";
            }

            // Replace placeholders in the template with actual values
            $parsedContent = str_replace(
                ['{{username}}', '{{form_url}}'],
                [$userData['username'], $formUrlsText],
                $emailtemplate->email_template_description
            );

            $userData = [
                'name' => $request->client_name,
                // 'company_name' => env('APP_NAME') . ', ' . $location['location_name'],
                'form_url' => $formUrlsText,
                'username' => $request->client_name,
                'subject' => $emailtemplate->subject,
                'emailbody' => $parsedContent,
            ];
            Mail::send('email.forms', $userData, function ($message) use ($to_email, $subject) {
                $message->to($to_email)
                    ->subject($subject);
                $message->from('support@itcc.net.au', $subject);
            });

            $dat['forms_sent_email'] = carbon::now();
            $appointment->update($dat);

            $data = [
                'success' => true,
                'message' => 'Appointment form sent successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => false,
                'message' => $th->getMessage(),
                'type'    => 'fail',
            ];
        }

        return $data;
    }

    public function apptConfirmation(Request $request)
    {
        $appointment = Appointment::find($request->id);

        if ($appointment) {
            $formattedDate = Carbon::parse($appointment->start_date)->format('D, d-M h:ia');

            $client = Clients::where('id', $appointment->client_id)->first();
            $client_email = $client->email;
            $username = $client->firstname . ' ' . $client->lastname;

            $user = User::where('id', $appointment->staff_id)->first();
            $phone = $user->phone;

            $service = Services::where('id', $appointment->service_id)->first();
            $service_name = $service->service_name;

            $location = Locations::where('id', $appointment->location_id)->first();
            $location_name = $location->location_name ?? '';

            $emailtemplate = EmailTemplates::where('email_template_type', 'Appointment Confirmation')->first();

            $_data = [
                'date_time' => $formattedDate,
                'username' => $username,
                'subject' => $emailtemplate->subject,
                'location_name' => $location_name,
                'phone' => $phone,
                'service_name' => $service_name
            ];

            if ($emailtemplate) {
                $templateContent = $emailtemplate->email_template_description;
                $parsedContent = str_replace(
                    ['{{username}}', '{{location_name}}', '{{date_time}}', '{{phone}}', '{{service_name}}'],
                    [$_data['username'], $_data['location_name'], $_data['date_time'], $_data['phone'], $_data['service_name']],
                    $templateContent
                );
                $data = [
                    'from_email' => 'support@itcc.net.au',
                    'emailbody' => $parsedContent,
                    'subject' => $_data['subject'],
                    'username' => $username,
                    'date_time' => $formattedDate,
                    'location_name' => $location_name,
                    'phone' => $phone,
                    'service_name' => $service_name
                ];
                $sub = $location_name . ', ' . $data['subject'];

                // Generate the ICS file content
                $icsContent = $this->generateICS($appointment, $client, $user, $service, $location);
                $icsFileName = 'appointment-' . $appointment->id . '.ics';
                Storage::put($icsFileName, $icsContent);

                $to_email = $client_email;
                Mail::send('email.appt_confirmation', $data, function ($message) use ($to_email, $sub, $icsFileName) {
                    $message->to($to_email)
                        ->subject($sub)
                        ->from('support@itcc.net.au', $sub)
                        ->attach(storage_path('app/' . $icsFileName), [
                            'mime' => 'text/calendar'
                        ]);
                });

                // Delete the ICS file after sending the email
                Storage::delete($icsFileName);
            }

            $response = [
                'success' => true,
                'message' => 'Appt Confirmation sent successfully!',
                'type' => 'success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function generateICS($appointment, $client, $user, $service, $location)
    {
        $startDateTime = Carbon::parse($appointment->start_date)->format('Ymd\THis');
        $endDateTime = Carbon::parse($appointment->end_date)->format('Ymd\THis'); // Assuming you have an end_date

        $icsContent = "BEGIN:VCALENDAR\r\n";
        $icsContent .= "VERSION:2.0\r\n";
        $icsContent .= "PRODID:-//Your Organization//NONSGML v1.0//EN\r\n";
        $icsContent .= "CALSCALE:GREGORIAN\r\n";
        $icsContent .= "BEGIN:VEVENT\r\n";
        $icsContent .= "UID:" . uniqid() . "@yourdomain.com\r\n";
        $icsContent .= "DTSTAMP:" . now()->format('Ymd\THis') . "\r\n";
        $icsContent .= "DTSTART:$startDateTime\r\n";
        $icsContent .= "DTEND:$endDateTime\r\n";
        $icsContent .= "SUMMARY:" . $service->service_name . "\r\n";
        $icsContent .= "DESCRIPTION:Appointment with " . $user->first_name . ' ' . $user->last_name . "\r\n";
        $icsContent .= "LOCATION:" . $location->location_name . "\r\n";
        $icsContent .= "END:VEVENT\r\n";
        $icsContent .= "END:VCALENDAR\r\n";

        return $icsContent;
    }

    /**
     * Method getClientFormsData
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function getClientFormsData($id)
    {
        $clientforms     = AppointmentForms::findOrFail($id);

        $formdatahtml    = view('calender.partials.client-services-forms-data', ['clientforms' => $clientforms])->render();
        return response()->json([
            'status'                => true,
            'message'               => 'Details found.',
            'data'                  => $formdatahtml,
            'formjson'              => $clientforms->form_user_data,
            'original_form'         => $clientforms->forms->form_json
        ], 200);
    }

    public function updateClientStatusForm(Request $request)
    {
        try {
            $appointmentforms = AppointmentForms::find($request->appointment_form_id);
            if($appointmentforms->id)
            {
                $data['status'] = AppointmentForms::COMPLETED;
                $appointmentforms->update($data);
            }
            $response = [
                'success' => true,
                'message' => 'Forms status updated!',
                'type' => 'success',
            ];
        } catch (\Throwable $th) {
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
}
