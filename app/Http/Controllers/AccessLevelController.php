<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;

class AccessLevelController extends Controller
{
    public function access_level(){
        $access = Permissions::where('name','Appointments & Clients')->get();
        // dd($access);
        return view('access_level',compact('access'));
    }
    public function update_access_level(Request $request)
    {
        $targets = [];
        foreach ($request->targets as $tar) {
            $targets[] = isset($tar) ? 1 : 0;
        }
        dd($targets);

        // The rest of your code...
        // $limited = isset($request->limited) ? 1 : 0;
        // dd($limited);
        $limited[] = isset($request->limited) ? 1 : 0;
        $standard = isset($request->standard) ? 1 : 0;
        $standardplus = isset($request->standardplus) ? 1 : 0;
        $advance = isset($request->advance) ? 1 : 0;
        $advanceplus = isset($request->advanceplus) ? 1 : 0;
        $admin = isset($request->admin) ? 1 : 0;
        $accounts = isset($request->accounts) ? 1 : 0;
        dd($targets);
        $newUser = Permissions::where('name','Appointments & Clients')
            ->where('appointments_and_clients','View the Appointment Book')
            ->update(['targets'=>$targets,'limited'=>$limited,'standard'=>$standard,'standardplus'=>$standardplus,'advance'=>$advance,'advanceplus'=>$advanceplus,'admin'=>$admin,'account'=>$accounts]);
        
        return redirect('access-level');   
    }
}
