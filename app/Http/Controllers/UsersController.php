<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Hash;
use Mail; 
use Illuminate\Support\Str;
use DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users=User::where('role_type','!=','admin')->get();

        // foreach($users as $user)
        // {
        //     $lastuserId = $user->id;
        //     $lastIncreament = substr($lastuserId, -3);
        //     $newUserId = str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
        //     $user->autoId = $newUserId;
        // }

        // return view('users.index', compact('users'));
        $users = User::all();
        if ($request->ajax()) {
            // if($request->search != '')
            // {
            //     $data = Locations::where('location_name','LIKE','%'.$request->search.'%')
            //             ->orWhere('phone','LIKE','%'.$request->search.'%')
            //             ->orWhere('email','LIKE','%'.$request->search.'%')
            //             ->orWhere('street_address','LIKE','%'.$request->search.'%')
            //             ->orWhere('suburb','LIKE','%'.$request->search.'%')
            //             ->orWhere('city','LIKE','%'.$request->search.'%')
            //             ->orWhere('state','LIKE','%'.$request->search.'%')
            //             ->orWhere('postcode','LIKE','%'.$request->search.'%')
            //             ->orWhere('latitude','LIKE','%'.$request->search.'%')
            //             ->orWhere('longitude','LIKE','%'.$request->search.'%')
            //     ->get();
            // }
            // else if($request->pagination != '')
            // {
            //     $data = Locations::paginate(10, ['*'], 'page', $request->pagination);
            //     // dd($data);
            // }
            // else
            // {
                $data = User::select('*')->where('role_type','!=','admin');
                // foreach($data as $user)
                // {
                //     $lastuserId = $user->id;
                //     $lastIncreament = substr($lastuserId, -3);
                //     $newUserId = str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
                //     $user->autoId = $newUserId;
                // }
            // }
            
            // dd($data);
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
                        $newUserId = str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
                        $row->autoId = $newUserId;
                        return $row->autoId;
                    })
                    ->addColumn('username', function ($row) { 
                        return $row->first_name.' '.$row->last_name;
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
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userRole = UserRoles::get();
        return view('users.create',compact('userRole'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'first_name' => 'required|string',
        //     'last_name' => 'required|string',
        //     'phone' => 'required|string',
        //     'email' => 'required|string'
        // ]);
        $password = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

        $file = $request->file('image');
        if($file != null)
        {
            $destinationPath = public_path('images/user_image');
            $file->move($destinationPath,$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
            $newUser = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email'=> $request->email,
                'password'=>Hash::make($password),
                'gender'=>$request->gender,
                'role_type'=>$request->role_type,
                'access_level'=>$request->access_level,
                'image'=>$img
            ]);
        }
        else
        {
            if($request->imgremove == '1')
            {
                $newUser = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email'=> $request->email,
                    'password'=>Hash::make($password),
                    'gender'=>$request->gender,
                    'role_type'=>$request->role_type,
                    'access_level'=>$request->access_level,
                    'image'=>''
                ]);
            }
            else
            {
                $newUser = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email'=> $request->email,
                    'password'=>Hash::make($password),
                    'gender'=>$request->gender,
                    'role_type'=>$request->role_type,
                    'access_level'=>$request->access_level,
                    'image'=>''
                ]);
            }
        }
        
        if($newUser){
            Mail::send('email.registration', ['email'=>$request->email,'username' => $request->first_name.' '.$request->last_name,'password'=>$password], function($message) use($request){
                $message->to($request->email);
                $message->subject('User Registration');
            });

            $response = [
                'success' => true,
                'message' => 'User Created successfully!',
                'type' => 'success',
                'data_id' => $newUser->id
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
        $users = User::find($id);
        $userRole = UserRoles::get();
        return view('users.edit', compact('users','userRole'));
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
        // dd($request->all());
        // $request->validate([
        //     'first_name' => 'required|string',
        //     'last_name' => 'required|string',
        //     'phone' => 'required|string',
        //     'email' => 'required|string'
        // ]);
        $password = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

        $file = $request->file('image');
        // dd($request->all());
        if($file != null)
        {
            $destinationPath = public_path('images/user_image');
            $file->move($destinationPath,$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
            $newUser = User::updateOrCreate(['id' => $request->id],[
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email'=> $request->email,
                'password'=>Hash::make($password),
                'gender'=>$request->gender,
                'role_type'=>$request->role_type,
                'access_level'=>$request->access_level,
                'image'=>$img
            ]);
        }
        else
        {
            // $img = '';
            if($request->imgremove == '1')
            {
                $newUser = User::updateOrCreate(['id' => $request->id],[
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email'=> $request->email,
                    'password'=>Hash::make($password),
                    'gender'=>$request->gender,
                    'role_type'=>$request->role_type,
                    'access_level'=>$request->access_level,
                    'image'=>''
                ]);
            }
            else
            {
                $getImg =User::where('id',$request->id)->first();
                // dd($getImg['image']);
                $newUser = User::updateOrCreate(['id' => $request->id],[
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email'=> $request->email,
                    'password'=>Hash::make($password),
                    'gender'=>$request->gender,
                    'role_type'=>$request->role_type,
                    'access_level'=>$request->access_level,
                    'image'=>$getImg['image']
                ]);
            }
        }
        
        if($newUser){
            $response = [
                'success' => true,
                'message' => 'User Updated successfully!',
                'type' => 'success',
                'data_id' => $newUser->id
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
}
