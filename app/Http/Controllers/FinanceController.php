<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalkInRetailSale;
use App\Models\WalkInProducts;
use App\Models\WalkInDiscountSurcharge;
use App\Models\Payment;
use DataTables;
use App\Models\Clients;
use App\Models\Locations;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $walkin = WalkInRetailSale::query();
        
        if ($request->ajax()) {
            $walkin = WalkInRetailSale::query();
            // dd($request->all());
            // Apply search filter if search term exists
            // if ($request->has('search') && !empty($request->search['value'])) {
            //     dd('4');
            //     $searchTerm = $request->search['value'];
            //     preg_match_all('/\d+/', $searchTerm, $matches);
            //     $searchTerm = implode('', $matches[0]);

            //     $walkin->where(function ($query) use ($searchTerm) {
            //         $query->where('id', $searchTerm)
            //             ->orWhere('customer_type', 'LIKE', "%$searchTerm%");
            //     })->orWhereHas('products', function ($query) use ($searchTerm) {
            //         $query->where('product_name', 'LIKE', "%$searchTerm%");
            //     });
            // }

            $data = $walkin->get();
            return Datatables::of($data)

            ->addIndexColumn()
            ->addColumn('client_name', function ($row) {
                $walkin = WalkInRetailSale::where('id', $row->id)->first(); // Retrieve the WalkInRetailSale record
                if ($walkin) {
                    $client = Clients::find($walkin->client_id); // Retrieve the client record using the client_id from the WalkInRetailSale record
                    if ($client) {
                        // Concatenate the first name and last name to form the full client name
                        $client_name = $client->firstname . ' ' . $client->lastname;
                        return $client_name;
                    }
                }
                return ''; // Return null if no client is found
            })

            ->addIndexColumn()
            ->addColumn('location_name', function ($row) {
                $walkinloc = WalkInRetailSale::where('id', $row->id)->first(); // Retrieve the WalkInRetailSale record
                if ($walkinloc) {
                    $loc = Locations::find($walkinloc->location_id); // Retrieve the location record using the location_id from the WalkInRetailSale record
                    if ($loc) {
                        // Concatenate the location name
                        $location_name = $loc->location_name;
                        return $loc->location_name;
                    }
                }
                return ''; // Return empty string if no location is found
            })

            ->addIndexColumn()
            ->addColumn('product_names', function ($row) {
                $walkin = WalkInRetailSale::where('id', $row->id)->first(); // Retrieve the WalkInRetailSale record
                if ($walkin) {
                    $products = WalkInProducts::where('walk_in_id', $walkin->id)->get(); // Retrieve the products
                    if ($products->isNotEmpty()) {
                        $product_names = $products->pluck('product_name')->implode(', '); // Pluck product names and join them with commas
                        return $product_names;
                    }
                }
                return ''; // Return empty string if no products are found
            })

            ->addIndexColumn()
            ->addColumn('payment', function ($row) {
                $walkin = WalkInRetailSale::where('id', $row->id)->first(); // Retrieve the WalkInRetailSale record
                if ($walkin) {
                    $payments = Payment::where('walk_in_id', $walkin->id)->get(); // Retrieve the payments
                    if ($payments->isNotEmpty()) {
                        $payment = $payments->pluck('payment_type')->implode(', '); // Pluck product names and join them with commas
                        return $payment;
                    }
                }
                return ''; // Return empty string if no products are found
            })
            

            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-print"></i></button></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        

        return view('finance.index', compact('walkin'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
