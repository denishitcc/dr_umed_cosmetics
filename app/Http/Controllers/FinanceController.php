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
use App\Models\User;
use Carbon\Carbon;
use App\Models\GiftCard;
use App\Models\GiftCardTransaction;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('finance');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $walkin = WalkInRetailSale::query();
            
            if ($request->ajax()) {
                $walkin = WalkInRetailSale::query();
                if ($request->has('daterange')) {
                    // Split the date range string into start and end dates
                    $dates = explode(' - ', $request->daterange);
                    if($dates[0] != '' && $dates[1] != '')
                    {
                        // Extract start and end dates
                        $startDate = Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
                        $endDate = Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');
                        
                        // Filter data based on the date range
                        $walkin->whereBetween('invoice_date', [$startDate, $endDate]);
                    }
                }            
                $data = $walkin->where('location_id', $request->location_id)->get();
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
                    $permission = \Auth::user()->checkPermission('finance');
                    // if ($permission === 'View Only')
                    // {
                    //     $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 print_invoice" ids='.$row->id.' disabled><i class="ico-print"></i></button></div>';
                    //     return $btn;
                    // }else{
                        $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 print_invoice" ids='.$row->id.'><i class="ico-print"></i></button></div>';
                        return $btn;
                    // }
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            $user = Auth::user();
            if($user->role_type =='admin' || $user->is_staff_memeber == null)
            {
                $locations = Locations::all();
            }else{
                $locations = Locations::where('id',$user->staff_member_location)->get();
            }
            $staffs     = User::all();

            return view('finance.index', compact('walkin','locations','staffs','permission'));
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
    public function search_gift_card(Request $request)
    {
        $query = $request->get('query', '');
        $results = GiftCard::where('tracking_number',$query)
            ->get();
        // dd($results);
        return response()->json($results);
    }
    public function get_gift_card_history(Request $request)
    {
        // Retrieve gift card details
        $giftCard = GiftCard::findOrFail($request->id);

        // Create an array for the initial transaction data (Created)
        $initialTransaction = [
            'redeemed_value_type' => 'Created',
            'date_time' => $giftCard->created_at
        ];        

        // Retrieve gift card transactions
        $transactions = GiftCardTransaction::where('gift_card_id', $request->id)
            ->get();

        // Add the initial transaction data to the beginning of the transactions array
        $transactions->prepend($initialTransaction);

        // Add transaction data for Expiry and Cancellation if available
        if ($giftCard->cancelled_at) {
            $expiryTransaction = [
                'redeemed_value_type' => 'Cancelled',
                'date_time' => $giftCard->cancelled_at
            ];
            $transactions->push($expiryTransaction);
        }

        if ($giftCard->expiry_date && now()->greaterThan($giftCard->expiry_date)) {
            $expiryTransaction = [
                'redeemed_value_type' => 'Expired',
                'date_time' => $giftCard->expiry_date
            ];
            $transactions->push($expiryTransaction);
        }

        // Return the transactions as JSON response
        return response()->json($transactions);
    }


}
