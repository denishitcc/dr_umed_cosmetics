<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use App\Models\User;
class SettingsController extends Controller
{
    public function settings(){
        $auth = auth();
        $user = User::find($auth->user()->id);
        return view('settings',compact('user'));
    }
    public function changePasswordSave(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|min:8|string',
            'new_password_confirmation' => 'required|min:8|string'
        ]);
        $auth = auth();
        if (!Hash::check($request->get('current_password'), $auth->user()->password)) 
        {
            $response = [
                'error' => true,
                'message' => 'Old Password is Invalid !',
                'type' => 'error',
            ];
            return response()->json($response);
        }
        if($request->new_password!= $request->new_password_confirmation) 
        {
            $response = [
                'error' => true,
                'message' => 'New Password cannot be same as confirm password !',
                'type' => 'error',
            ];
            return response()->json($response);
        }

        $user = User::find($auth->user()->id);
        $user->password = Hash::make($request->new_password_confirmation);
        $user->save();
        if($user){
            $response = [
                'success' => true,
                'message' => 'Password updated successfully!',
                'type' => 'success',
                'data_id' => $user->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Password updated not Updated !',
                'type' => 'error',
            ];
        }

        return response()->json($response);
    }
    public function changeMyAccountSave(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
        $auth = auth();
        $user = User::find($auth->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        if($user){
            $response = [
                'success' => true,
                'message' => 'My Account updated successfully!',
                'type' => 'success',
                'data_id' => $user->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Password updated not Updated !',
                'type' => 'error',
            ];
        }

        return response()->json($response);
    }
}
