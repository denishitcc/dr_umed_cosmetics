<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;

class AccessLevelController extends Controller
{
    public function access_level(){
        $appointment_client = Permissions::where('name','Appointments & Clients')->get();
        $sales = Permissions::where('name','Sales')->get();
        $reporting = Permissions::where('name','Reporting')->get();
        $staffs = Permissions::where('name','Staff')->get();
        $marketing = Permissions::where('name','Marketing')->get();
        $administration = Permissions::where('name','Administration')->get();
        // dd($sales);
        return view('access_level',compact('appointment_client','sales','reporting','staffs','marketing','administration'));
    }
    public function update_appointment_client(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Appointments & Clients')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
    public function update_sales(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Sales')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
    public function update_reporting(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Reporting')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
    public function update_staff(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Staff')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
    public function update_marketing(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Marketing')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
    public function update_administration(Request $request)
    {
        // dd($request->all());
        $cnt=0;
        foreach($request->name as $i => $app)
        {
            $newUser = Permissions::where('name','Administration')
            ->where('sub_name',$app)->first()
            ->update(['targets'=>$request->targets[$cnt],'limited'=>$request->limited[$cnt],'standard'=>$request->standard[$cnt],'standardplus'=>$request->standardplus[$cnt],'advance'=>$request->advance[$cnt],'advanceplus'=>$request->advanceplus[$cnt],'admin'=>$request->admin[$cnt],'account'=>$request->account[$cnt]]);
            $cnt++;
        }
        return redirect('access-level');   
    }
}
