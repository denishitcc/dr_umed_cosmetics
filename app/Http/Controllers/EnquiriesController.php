<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiries;
use App\Models\Locations;
use DataTables;
use Illuminate\Support\Facades\Auth;

class EnquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('enquiries');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            
            // dd($enquiries);

            $user = Auth::user();
            if($user->role_type =='admin' || $user->is_staff_memeber == null)
            {
                $enquiries = Enquiries::all();
            }else{
                $enquiries = Enquiries::where('location_name',$user->staff_member_location)->get();
            }

            
            if ($request->ajax()) {
                $user = Auth::user();
                if($user->role_type =='admin' || $user->is_staff_memeber == null)
                {
                    $data = Enquiries::all();
                }else{
                    $data = Enquiries::where('location_name',$user->staff_member_location)->get();
                }
                return Datatables::of($data)
                    
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->addColumn('locations_names', function ($row) {
                    $get_location_name = Locations::where('id',$row->location_name)->first();
                    $location_name = $get_location_name->location_name;
                    return $location_name;
                })
                // ->addColumn('date_created', function ($row) {
                    
                //     return date("Y/m/d  H:i:s", strtotime($row->created_at));
                // })
                ->make(true);

            }
            return view('enquiries.index', compact('enquiries','permission'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = \Auth::user()->checkPermission('enquiries');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            $location = Locations::all();
            return view('enquiries.create',compact('location'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newEnquiry = Enquiries::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'enquiry_date' => $request->enquiry_date,
            'appointment_date' => $request->appointment_date,
            'about_us' => $request->about_us,
            'enquiry_source' => $request->enquiry_source,
            'cosmetic_injectables' => isset($request->cosmetic_injectables)?implode (",", $request->cosmetic_injectables):'',
            'skin' => isset($request->skin)?implode (",", $request->skin):'',
            'surgical' => isset($request->surgical)?implode (",", $request->surgical):'',
            'body' => isset($request->body)?implode (",", $request->body):'',
            'comments'=> $request->comments,
            'enquiry_status'=>$request->enquiry_status,
            'location_name' => $request->location_name
        ]);
        if($newEnquiry){

            $response = [
                'success' => true,
                'message' => 'Enquiry Created successfully!',
                'type' => 'success',
                'data_id' => $newEnquiry->id
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
        $permission = \Auth::user()->checkPermission('enquiries');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            $enquiries = Enquiries::where('id',$id)->first();
            $location = Locations::all();
            return view('enquiries.edit',compact('enquiries','location'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     return view('enquiries.edit');
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $editEnquiry = Enquiries::updateOrCreate(['id' => $request->id],[
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            // 'email' => $request->email,
            'phone_number' => $request->phone_number,
            'enquiry_date' => $request->enquiry_date,
            'appointment_date' => $request->appointment_date,
            'about_us' => $request->about_us,
            'enquiry_source' => $request->enquiry_source,
            'cosmetic_injectables' => isset($request->cosmetic_injectables)?implode (",", $request->cosmetic_injectables):'',
            'skin' => isset($request->skin)?implode (",", $request->skin):'',
            'surgical' => isset($request->surgical)?implode (",", $request->surgical):'',
            'body' => isset($request->body)?implode (",", $request->body):'',
            'comments'=> $request->comments,
            'enquiry_status'=>$request->enquiry_status,
            'location_name' => $request->location_name
        ]);
        if($editEnquiry){
            $response = [
                'success' => true,
                'message' => 'Enquiry Updated successfully!',
                'type' => 'success',
                'data_id' => $editEnquiry->id
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
    public function destroy(string $id)
    {
        //
    }
}
