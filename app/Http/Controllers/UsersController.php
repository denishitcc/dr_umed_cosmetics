<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Mail; 
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::where('role_type','!=','admin')->get();

        foreach($users as $user)
        {
            $lastuserId = $user->id;
            $lastIncreament = substr($lastuserId, -3);
            $newUserId = str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
            $user->autoId = $newUserId;
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
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
            $destinationPath = 'images/user_image';
            $file->move($destinationPath,$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
        }
        else
        {
            $img = '';
        }
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
        return view('users.edit', compact('users'));
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
        // dd($file);
        if($file != null)
        {
            $destinationPath = 'images/user_image';
            $file->move($destinationPath,$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
        }
        else
        {
            $img = '';
        }
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
