<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiries;
use DataTables;

class EnquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $enquiries = Enquiries::all();
        if ($request->ajax()) {
            $data = Enquiries::select('*');
            return Datatables::of($data)
                
            ->addIndexColumn()
            ->addColumn('username', function ($row) {
                return $row->firstname.' '.$row->lastname;
            })
            ->addColumn('date_created', function ($row) {
                
                return date("Y/m/d  H:i:s", strtotime($row->created_at));
            })
            ->make(true);

        }
        return view('enquiries.index', compact('enquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('enquiries.create');
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
            'cosmetic_injectables' => implode (",", $request->cosmetic_injectables),
            'skin' => implode (",", $request->skin),
            'surgical' => implode (",", $request->surgical),
            'body' => implode (",", $request->body),
            'comments'=> $request->comments,
            'enquiry_status'=>$request->enquiry_status
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
        $enquiries = Enquiries::where('id',$id)->first();
        return view('enquiries.edit',compact('enquiries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('enquiries.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $editEnquiry = Enquiries::updateOrCreate(['id' => $request->id],[
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'enquiry_date' => $request->enquiry_date,
            'appointment_date' => $request->appointment_date,
            'about_us' => $request->about_us,
            'enquiry_source' => $request->enquiry_source,
            'cosmetic_injectables' => implode (",", $request->cosmetic_injectables),
            'skin' => implode (",", $request->skin),
            'surgical' => implode (",", $request->surgical),
            'body' => implode (",", $request->body),
            'comments'=> $request->comments,
            'enquiry_status'=>$request->enquiry_status
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
