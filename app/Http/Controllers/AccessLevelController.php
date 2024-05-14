<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;

class AccessLevelController extends Controller
{
    public function access_level(){
        $appointment_client = Permissions::get();
        return view('access_level',compact('appointment_client'));
    }
    public function update_appointment_client(Request $request)
    {
        $cnt = 0;
        foreach ($request->name as $i => $app) {
            // Assuming you have a Permission model
            $i = $i+1;
            $permission = Permissions::find($i);
            if ($permission) {
                $permission->update([
                    'targets' => $request->targets[$cnt],
                    'limited' => $request->limited[$cnt],
                    'standard' => $request->standard[$cnt],
                    'standardplus' => $request->standardplus[$cnt],
                    'advance' => $request->advance[$cnt],
                    'advanceplus' => $request->advanceplus[$cnt],
                    'admin' => $request->admin[$cnt],
                    'account' => $request->account[$cnt]
                ]);
            }
            $cnt++;
        }
        return redirect('access-level');   
    }
}
