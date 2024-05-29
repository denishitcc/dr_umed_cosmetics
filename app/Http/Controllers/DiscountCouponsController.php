<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use DataTables;
use App\Models\Locations;

class DiscountCouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('discount-coupons');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $discount_coupons = DiscountCoupon::all();
            if ($request->ajax()) {
                $data = DiscountCoupon::select('*');
                return Datatables::of($data)
                
                ->addColumn('locations_names', function ($row) {
                    $get_location_name = Locations::where('id',$row->location_id)->first();
                    $location_name = $get_location_name->location_name;
                    return $location_name;
                })

                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $permission = \Auth::user()->checkPermission('discount-coupons');
                        // dd($permission);
                        if ($permission === 'View Only')
                        {
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids="'.$row->id.'"  location_id="'.$row->location_id.'"  discount_type="'.$row->discount_type.'" discount_percentage="'.$row->discount_percentage.'" data-bs-toggle="modal" data-bs-target="#edit_discount_coupon" disabled><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.' disabled><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }else{
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids="'.$row->id.'"  location_id="'.$row->location_id.'"  discount_type="'.$row->discount_type.'" discount_percentage="'.$row->discount_percentage.'" data-bs-toggle="modal" data-bs-target="#edit_discount_coupon"><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }
                })
                ->make(true);

            }
            $locations = Locations::all();
            return view('discount-coupons.index', compact('discount_coupons','locations'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newDiscountCoupons = DiscountCoupon::create([
            'location_id' => $request->locations,
            'discount_type' => $request->discount_type,
            'discount_percentage' => $request->discount_percentage
        ]);
        if($newDiscountCoupons){

            $response = [
                'success' => true,
                'message' => 'Discount Coupon Created successfully!',
                'type' => 'success',
                'data_id' => $newDiscountCoupons->id
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $update = DiscountCoupon::updateOrCreate(['id' => $request->hdn_id],[
            'location_id' => $request->edit_locations,
            'discount_type' => $request->edit_discount_type,
            'discount_percentage' => $request->edit_discount_percentage
        ]);
        if($update){
            $response = [
                'success' => true,
                'message' => 'Discount Coupon Updated successfully!',
                'type' => 'success',
                'data_id' => $update->id
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
        DiscountCoupon::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Discount Coupon deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];

        return response()->json($response);
    }
}
