<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationsResource;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Hash;
use Mail; 
use Illuminate\Support\Str;
use DataTables;
use App\Models\EmailTemplates;
use App\Models\FormSummary;
use App\Models\Locations;
use App\Models\Services;
use App\Models\UsersServices;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('users');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $users = User::all();
            $locations = Locations::all();
            if ($request->ajax()) {
                $data = User::select('*')->where('role_type','!=','admin');
                return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                            return $btn;
                    })
                    ->addColumn('image', function ($row) { 
                        return $row->image;
                    })
                    ->addColumn('autoId', function ($row) { 
                        $lastuserId = $row->id;
                        $lastIncreament = substr($lastuserId, -3);
                        $newUserId = str_pad($lastIncreament, 3, 0, STR_PAD_LEFT);
                        $row->autoId = $newUserId;
                        return $row->autoId;
                    })
                    ->addColumn('username', function ($row) { 
                        return $row->first_name.' '.$row->last_name;
                    })
                    ->addColumn('locations', function ($row) {
                        $loc = Locations::where('id',$row->staff_member_location)->first(); 
                        return $loc->location_name??null;
                    })
                    ->addColumn('status_bar', function($row){
                        if($row->status == 'active')
                        {
                            $row->status_bar = 'checked';
                        }
                        return $row->status_bar;
                    })
                    ->rawColumns(['action'])

                    ->make(true);
            }
            return view('users.index', compact('users','locations'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Auth::user()->checkPermission('users');
        if ($permission === 'View & Make Changes' || $permission === 'Both'|| $permission === true) {

            $userRole   = UserRoles::get();
            $locations  = Locations::all();
            $services   = Services::all();
            $alluser    = User::where('id', '!=', Auth::user()->id)->get();

            return view('users.create',compact('userRole','locations','services','alluser'));
        } else {
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $password = $this->generatePassword(8);

        $file = $request->file('image');
        if($file != null)
        {
            $destinationPath = storage_path('app/public/images/user_image');
            $file->move($destinationPath,$file->getClientOriginalName());
            $img    = $file->getClientOriginalName();
        }
        else
        {
            if($request->imgremove == '1')
            {
                $img='';
            }
            else
            {
                $img='';
            }
        }
        $newUser = User::create([
            'first_name'                        => $request->first_name,
            'last_name'                         => $request->last_name,
            'phone'                             => $request->phone,
            'email'                             => $request->email,
            'password'                          => Hash::make($password),
            'gender'                            => $request->gender,
            'role_type'                         => $request->role_type,
            'access_level'                      => $request->access_level,
            'image'                             => $img,
            'is_staff_memeber'                  => $request->is_staff_memeber,
            'staff_member_location'             => $request->staff_member_location,
            'available_in_online_booking'       => $request->available_in_online_booking,
            'calendar_color'                    => $request->calendar_color,
            'all_services'                      => $request->all_services,
            'first_date_appear_on_calnedar'     => $request->first_date,
            'last_date_appear_on_calnedar'      => $request->last_date,
        ]);

        if($newUser){
            $services = $request->services;

            if($services)
            {
                foreach ($services as $value) {
                    $userservices[] = [
                        'services_id' => $value,
                        'user_id'     => $newUser->id,
                    ];
                }

                $user_services   = UsersServices::insert($userservices);
            }

            $emailtemplate = EmailTemplates::where('email_template_type', 'User Register')->first();

            $_data = array('email'=>$request->email,'username'=>$request->first_name.' '.$request->last_name,'password'=>$password,'subject' => $emailtemplate->subject);

            if($emailtemplate)
            {
                $templateContent = $emailtemplate->email_template_description;
                // Replace placeholders in the template with actual values
                $parsedContent = str_replace(
                    ['{{username}}', '{{email}}', '{{url}}', '{{password}}'],
                    [$_data['username'], $_data['email'] ?? '', $_data['url'] ?? '', $_data['password'] ?? ''],
                    $templateContent
                );
                $data = ([
                    'from_email'    => 'support@itcc.net.au',
                    'emailbody'     => $parsedContent,
                    'subject'       => $_data['subject'],
                    'username'=>$_data['username'],
                ]);
                $sub = $data['subject'];

                $to_email = $request->email;
                Mail::send('email.registration', $data, function($message) use ($to_email,$sub) {
                    $message->to($to_email)
                    ->subject($sub);
                    $message->from('support@itcc.net.au',$sub);
                });
            }

            $response = [
                'success'   => true,
                'message'   => 'User Created successfully!',
                'type'      => 'success',
                'data_id'   => $newUser->id
            ];
        }else{
            $response = [
                'error'     => true,
                'message'   => 'Error !',
                'type'      => 'error',
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = \Auth::user()->checkPermission('users');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            $users      = User::find($id);
            $userRole   = UserRoles::get();
            $locations  = Locations::all();
            $services   = Services::all();
            $alluser    = User::where('id', '!=', Auth::user()->id)->get();
            return view('users.edit', compact('users','userRole','locations','services','alluser'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_info(Request $request)
    {
        $password = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

        $file = $request->file('image');
        if($file != null)
        {
            $destinationPath = storage_path('app/public/images/user_image');
            $file->move($destinationPath,$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
        }
        else
        {
            if($request->imgremove == '1')
            {
                $img = '';
            }
            else
            {
                $getImg = User::where('id',$request->id)->first();
                $img    = $getImg['image'];
            }
        }
        $newUser = User::updateOrCreate(['id' => $request->id],[
            'first_name'                        => $request->first_name,
            'last_name'                         => $request->last_name,
            'phone'                             => $request->phone,
            // 'email'                          => $request->email,
            'password'                          => Hash::make($password),
            'gender'                            => $request->gender,
            'role_type'                         => $request->role_type,
            'access_level'                      => $request->access_level,
            'is_staff_memeber'                  => $request->is_staff_memeber,
            'staff_member_location'             => $request->is_staff_memeber!='0'?$request->staff_member_location:null,
            'image'                             => $img,
            'available_in_online_booking'       => $request->available_in_online_booking,
            'calendar_color'                    => $request->calendar_color,
            'all_services'                      => $request->all_services,
            'first_date_appear_on_calnedar'     => $request->first_date,
            'last_date_appear_on_calnedar'      => $request->last_date,
        ]);

        $services = $request->services;
        UsersServices::where('user_id',$request->id)->delete();

        if($services)
        {
            foreach ($services as $value) {
                $userservices[] = [
                    'services_id' => $value,
                    'user_id'     => $newUser->id,
                ];
            }

            $user_services   = UsersServices::insert($userservices);
        }


        if($newUser){
            $response = [
                'success'   => true,
                'message'   => 'User Updated successfully!',
                'type'      => 'success',
                'data_id'   => $newUser->id
            ];
        }else{
            $response = [
                'error'     => true,
                'message'   => 'Error !',
                'type'      => 'error',
            ];
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        User::find($request->id)->delete();

        $response = [
            'success' => true,
            'message' => 'User deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];

        return response()->json($response);
    }
    public function checkEmail(Request $request){
        $email = $request->input('email');
        $isExists = User::where('email',$email)->first();
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
        $isExists = User::where('id',$id)->first();
        if($isExists){
            $newUser = User::where('id',$id)->update(['status'=>$status]);
        }
        if($newUser){
            $response = [
                'success' => true,
                'message' => 'User Status Updated successfully!',
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
    public function get_all_locations()
    {
        $loc = Locations::all();
        return response()->json(LocationsResource::collection($loc));
        // return response()->json($loc);
    }

    /**
     * Method getForms
     *
     * @return void
     */
    public function getForms()
    {
        $forms              = FormSummary::where('status',FormSummary::LIVE)->get();
        $html               = view('calender.partials.addforms',     [ 'forms' => $forms ])->render();
        return response()->json([
            'status'            => true,
            'message'           => 'Details found.',
            'formshtml'         => $html,
        ], 200);
    }
    private function generatePassword($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }

    /**
     * Method copyCapabilities
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function copyCapabilities(Request $request)
    {
        try {

            $userservices = UsersServices::where('user_id',$request->staff_id)->pluck('services_id')->toArray();

            $data = [
                'status'       => true,
                'message'      => 'Details found.',
                'services'     => $userservices,
            ];

        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => false,
                'message' => 'Something went wrong!',
                'type'    => 'fail',
            ];
        }
        return response()->json($data);
    }
}
