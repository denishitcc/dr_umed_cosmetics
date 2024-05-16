<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use DataTables;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('suppliers');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $suppliers = Suppliers::all();
            if ($request->ajax()) {
                $data = Suppliers::select('*');
                return Datatables::of($data)
                    
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $permission = \Auth::user()->checkPermission('suppliers');
                        if ($permission === 'View Only') {
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.' disabled><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.' disabled><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }else{
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }
                        
                })
                ->make(true);

            }
            return view('suppliers.index', compact('suppliers','permission'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = \Auth::user()->checkPermission('suppliers');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            return view('suppliers/create');
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newSupplier = Suppliers::create([
            'business_name' => $request->business_name,
            'contact_first_name' => $request->contact_first_name,
            'contact_last_name' => $request->contact_last_name,
            'home_phone' => $request->home_phone,
            'work_phone' => $request->work_phone,
            'fax_number' => $request->fax_number,
            'mobile_phone' => $request->mobile_phone,
            'email' => $request->email,
            'web_address' => $request->web_address,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'state' => $request->state,
            'post_code'=> $request->post_code,
            'country'=>$request->country
        ]);
        if($newSupplier){

            $response = [
                'success' => true,
                'message' => 'Supplier Created successfully!',
                'type' => 'success',
                'data_id' => $newSupplier->id
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
        $permission = \Auth::user()->checkPermission('suppliers');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === true) {
            $suppliers = Suppliers::find($id);
            return view('suppliers/edit', compact('suppliers'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->id);
        $updateSupplier = Suppliers::updateOrCreate(['id' => $request->id],[
            'business_name' => $request->business_name,
            'contact_first_name' => $request->contact_first_name,
            'contact_last_name' => $request->contact_last_name,
            'home_phone' => $request->home_phone,
            'work_phone' => $request->work_phone,
            'fax_number' => $request->fax_number,
            'mobile_phone' => $request->mobile_phone,
            // 'email' => $request->email,
            'web_address' => $request->web_address,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'state' => $request->state,
            'post_code'=> $request->post_code,
            'country'=>$request->country
        ]);
        if($updateSupplier){
            $response = [
                'success' => true,
                'message' => 'Supplier Updated successfully!',
                'type' => 'success',
                'data_id' => $updateSupplier->id
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
        Suppliers::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Supplier deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];

        return response()->json($response);
    }
    public function checkSupplierEmail(Request $request){
        $email = $request->input('email');
        $isExists = Suppliers::where('email',$email)->first();
        if($isExists){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }
}
