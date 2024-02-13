<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use App\Models\User;
use App\Models\Locations;
use App\Models\BusinessSettings;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function settings(){
        $auth = auth();
        $user = User::find($auth->user()->id);
        $locations = Locations::get();
        $locs = Locations::first();
        $users_data = User::join('business_settings', 'business_settings.user_id', '=', 'users.id')
                    ->where('users.id',$auth->user()->id)
                    ->where('business_settings.business_details_for','Dr Umed Enterprise')
              		->first();
        return view('settings',compact('user','locations','users_data','locs'));
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
        // dd($request->all());
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
        $auth = auth();
        $user = User::find($auth->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $file = $request->file('image');
        if($request->imgremove=='1')
        {
            $img='';
        }
        else
        {
            if($file != null)
            {
                $destinationPath = storage_path('app/public/images/user_image');
                $file->move($destinationPath,$file->getClientOriginalName());
                $img = $file->getClientOriginalName();
            }
            else
            {
                $img=$user->image;
            }
        }
        $user->image = $img;
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
    public function UpdateBusinessSettings(Request $request){
        // dd($request->all());
        $request->validate([
            // 'business_name' => 'required|string',
            // 'name_customers_see' => 'required|string',
            // 'business_email' => 'required|string',
            // 'business_phone' => 'required|string',
        ]);
        $auth = auth();
        $user = BusinessSettings::where('user_id', $auth->user()->id)
                ->where('business_details_for',$request->business_details_for)
                ->first();
        if($user== null)
        {
            $user = BusinessSettings::create([
                'user_id'=>$auth->user()->id,
                'business_details_for' => $request->business_details_for,
                'business_name' => $request->business_name,
                'name_customers_see' => $request->name_customers_see,
                'business_email' => $request->business_email,
                'business_phone' => $request->business_phone,
                'street_address' => $request->street_address,
                'suburb' => $request->suburb,
                'city' => $request->city,
                'post_code' => $request->post_code,
            ]);
        }
        else
        {
            $newUser = BusinessSettings::updateOrCreate(['id' => $user->id],[
                'user_id'=>$auth->user()->id,
                'business_details_for' => $request->business_details_for,
                'business_name' => $request->business_name,
                'name_customers_see' => $request->name_customers_see,
                'business_email' => $request->business_email,
                'business_phone' => $request->business_phone,
                'street_address' => $request->street_address,
                'suburb' => $request->suburb,
                'city' => $request->city,
                'post_code' => $request->post_code,
            ]);
        }
        
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
                'message' => 'Password not Updated !',
                'type' => 'error',
            ];
        }

        return response()->json($response);
    }
    public function GetBusinessDetails(Request $request)
    {
        $auth = auth();
        $user = User::find($auth->user()->id);

        $user = BusinessSettings::where('user_id', $auth->user()->id)
                ->where('business_details_for',$request->business_details_for)
                ->first();
                // dd($user);
        if($user== null)
        {
            $locs = Locations::find($request->business_details_for);
            if($request->business_details_for=='Dr Umed Enterprise')
            {
                $loc_name = 'Dr Umed Cosmetic and Injectables';
                $response = array('business_name'=>'Dr Umed Enterprise','name_customers_see'=>'Dr Umed Cosmetic and Injectables','business_email'=>'info@drumedcosmetics.com.au','business_phone'=>'0407194519','post_code'=>'','street_address'=>'','suburb'=>'','city'=>'');
                // dd($loc_name);
            }
            else
            {
                $loc_name = 'Dr Umed Cosmetics, '.$locs->location_name;
                $response=array('business_name'=>$locs->location_name,'name_customers_see'=>$loc_name,'business_email'=>$locs->email,'business_phone'=>$locs->phone,'street_address'=>$locs->street_address,'suburb'=>$locs->suburb,'city'=>$locs->city,'post_code'=>$locs->postcode);
            }
            // $response = array('business_name'=>'Dr Umed Enterprise','name_customers_see'=>'Dr Umed Cosmetic and Injectables','business_email'=>'info@drumedcosmetics.com.au','business_phone'=>'0407194519','post_code'=>'','street_address'=>'','suburb'=>'','city'=>'');
            // $response=array('business_name'=>$locs->location_name,'name_customers_see'=>$loc_name,'business_email'=>$locs->email,'business_phone'=>$locs->phone,'street_address'=>$locs->street_address,'suburb'=>$locs->suburb,'city'=>$locs->city,'post_code'=>$locs->postcode);
            return response()->json($response);
        }      
        else
        {
            $response=array('business_name'=>$user->business_name,'name_customers_see'=>$user->name_customers_see,'business_email'=>$user->business_email,'business_phone'=>$user->business_phone,'street_address'=>$user->street_address,'suburb'=>$user->suburb,'city'=>$user->city,'post_code'=>$user->post_code);
            return response()->json($response);
        }  
    }
    public function UpdateBrandImage(Request $request)
    {
        $file = $request->file('banner_image');
        // dd($file);
        if($file != null)
        {
            $destinationPath = storage_path('app/public/images/banner_image');
            $file->move($destinationPath,$file->getClientOriginalName());

            $auth = auth();
            $user = User::find($auth->user()->id);
            $newUser = User::updateOrCreate(['id' => $auth->user()->id],[
                'banner_image' => $file->getClientOriginalName(),
            ]);
            return redirect('settings');
        }
        else
        {
            $auth = auth();
            $user = User::find($auth->user()->id);
            if($request->bannerremove == '1')
            {
                $newUser = User::updateOrCreate(['id' => $auth->user()->id],[
                    'banner_image' => 'no-image.jpg',
                ]);
            }
            else
            {
                $newUser = User::updateOrCreate(['id' => $auth->user()->id],[
                    'banner_image' => $user->banner_image,
                ]);
            }
            return redirect('settings');   
        }
    }
}
