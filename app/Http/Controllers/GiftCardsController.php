<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiftCard;
use App\Models\GiftCardTransaction;
use DataTables;
use Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Models\EmailGiftCardHistory;

class GiftCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('gift-card');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            if ($request->ajax()) {
                $data = GiftCard::select('*');
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('details', function($row) {
                        $createdAt = Carbon::parse($row->created_at)->format('d M Y');
                        $expiryDate = Carbon::parse($row->expiry_date)->format('d M Y');
                        
                        // Initialize the details string
                        $details = '<div class="gift-card-details">
                                        <strong>' . $row->tracking_number . '</strong><br>
                                        Created: ' . $createdAt . ' at ' . $row->purchase_at . '<br>
                                        Promotional Gift Card<br>';
                    
                        // Check if notes are not null and append the notes div if true
                        if ($row->notes !== null) {
                            $details .= '<div class="gift-card-notes p-2" style="color: #000;background-color: #FCF8E3">'
                                        . htmlspecialchars($row->notes) . '</div>';
                        }
                    
                        // Close the outer div
                        $details .= '</div>';
                        
                        return $details;
                    })                    
                    ->addColumn('remaining_value', function($row) {
                        $remainingValue = '$' . number_format($row->remaining_value, 2) . ' remaining';
                        // dd($row->value);
                        //gift card transaction
                        $trans = GiftCardTransaction::where('gift_card_id',$row->id)->where('invoice_number','!=',null)->get();
                        $trans_all = GiftCardTransaction::where('gift_card_id',$row->id)->get();
                        // dd($trans_all);
                        if(count($trans) > 0)
                        {
                            $credited = 0;
                            $redeemed = 0;
                            foreach($trans_all as $trans)
                            {
                                if($trans->redeemed_value_type == 'increase')
                                {
                                    $credited += $trans->redeemed_value;
                                }else{
                                    $redeemed += $trans->redeemed_value;
                                }
                            }
                            $usageStatus = 'Redeemed: $' . number_format($redeemed, 2)  . ', ' . 'Face value: $' . $row->value . ', ' . 'Credited: $' . number_format($credited, 2);
                        }else{
                            $usageStatus = 'Not used yet';
                        }
                    
                        // Check if the expiry date is null or not
                        if ($row->expiry_date == null) {
                            $expiryDate = 'Never Expires';
                        } else {
                            // Parse the expiry date and check if it's expired
                            $expiryDate = Carbon::parse($row->expiry_date)->endOfDay();
                            $currentDate = Carbon::now()->endOfDay();
                    
                            if ($expiryDate->isBefore($currentDate)) {
                                // Gift card has expired
                                $expiryDate = '<span style="color:red;">Expired ' . $expiryDate->format('d M Y') . '</span>';
                            } else if ($row->cancelled == 'yes') {
                                $cancelDate = Carbon::parse($row->cancelled_at);
                                $expiryDate = '<span style="color:red;">Cancelled ' . $cancelDate->format('d M Y') . '</span>';
                            } else {
                                // Gift card is still valid, display the expiry date
                                $expiryDate = 'Expires ' . $expiryDate->format('d M Y');
                            }
                        }
                    
                        return '<div class="remaining-value">' .
                                   '<strong>' . $remainingValue . '</strong><br>' .
                                   $usageStatus . '<br>' .
                                   $expiryDate .
                               '</div>';
                    })                  
                    ->addColumn('action', function($row){
                        $transactions_count = GiftCardTransaction::where('gift_card_id', $row->id)->count();
                        $permission = \Auth::user()->checkPermission('gift-card');
                        $btn = '<div class="action-box vertical-buttons" style="flex-direction: column;">';
                    
                        // Check if the gift card is cancelled
                        if ($row->cancelled === 'yes') {
                            // All buttons hidden if cancelled
                            return $btn . '</div>';
                        }
                    
                        // Add Transactions button
                        $btn .= '<button type="button" class="btn btn-secondary p-2 dt-transaction" ids="'.$row->id.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#edit_transactions">
                                    Transactions <span>('.$transactions_count.')</span>
                                </button>';
                    
                        if ($permission === 'View Only') {
                            $btn .= '<button type="button" class="btn btn-secondary p-2 dt-edit" ids="'.$row->id.'" initial_value="'.$row->value.'" remaining_value="'.$row->remaining_value.'" notes="'.$row->notes.'" expiry_date="'.$row->expiry_date.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#edit_gift_cards" disabled>
                                        Edit Gift Card
                                    </button>';
                    
                            // Check if the expiry date has not passed
                            $expiryDate = Carbon::parse($row->expiry_date)->endOfDay();
                            $currentDate = Carbon::now()->endOfDay();
                            
                            if ($row->expiry_date === null || !$expiryDate->isBefore($currentDate)) {
                                $btn .= '<button type="button" class="btn btn-secondary p-2 dt-email" ids="'.$row->id.'" initial_value="'.$row->value.'" remaining_value="'.$row->remaining_value.'" notes="'.$row->notes.'" expiry_date="'.$row->expiry_date.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#email_gift_card" disabled>
                                            Email Gift Card
                                        </button>
                                        <button type="button" class="btn p-2 btn-danger cancel-gift" ids="'.$row->id.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#cancel_gift_card" disabled>
                                            Cancel Gift Card
                                        </button>';
                            }
                        } else {
                            $btn .= '<button type="button" class="btn btn-secondary p-2 dt-edit" ids="'.$row->id.'" initial_value="'.$row->value.'" remaining_value="'.$row->remaining_value.'" notes="'.$row->notes.'" expiry_date="'.$row->expiry_date.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#edit_gift_cards">
                                        Edit Gift Card
                                    </button>';
                    
                            // Check if the expiry date has not passed
                            $expiryDate = Carbon::parse($row->expiry_date)->endOfDay();
                            $currentDate = Carbon::now()->endOfDay();
                    
                            if (($row->expiry_date === null || !$expiryDate->isBefore($currentDate)) && $row->remaining_value > 0) {
                                $btn .= '<button type="button" class="btn btn-secondary p-2 dt-email" ids="'.$row->id.'" initial_value="'.$row->value.'" remaining_value="'.$row->remaining_value.'" notes="'.$row->notes.'" expiry_date="'.$row->expiry_date.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#email_gift_card">
                                            Email Gift Card
                                        </button>
                                        <button type="button" class="btn p-2 btn-danger cancel-gift" ids="'.$row->id.'" tracking_number="'.$row->tracking_number.'" data-bs-toggle="modal" data-bs-target="#cancel_gift_card">
                                            Cancel Gift Card
                                        </button>';
                            }
                        }
                    
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'details', 'remaining_value'])
                    ->make(true);
            }
            return view('gift-card.index');
        } else {
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
        // Determine the expiry date based on the expiry duration
        $expiry_date = null;
        if ($request->expiry_date == '1 month') {
            $expiry_date = Carbon::now()->addMonth();
        } elseif ($request->expiry_date == '2 months') {
            $expiry_date = Carbon::now()->addMonths(2);
        } elseif ($request->expiry_date == '3 months') {
            $expiry_date = Carbon::now()->addMonths(3);
        } elseif ($request->expiry_date == '6 months') {
            $expiry_date = Carbon::now()->addMonths(6);
        } elseif ($request->expiry_date == '1 year') {
            $expiry_date = Carbon::now()->addYear();
        }

        
        // Initialize an empty array to hold the created gift cards
        $giftCards = [];
        // Loop to create multiple gift card entries based on the quantity
        for ($i = 0; $i < $request->quanitity; $i++) {
            
            $giftCard = GiftCard::create([
                'tracking_number' => $this->generateTrackingNumber(), // Example of adding a tracking number
                'value' => $request->value,
                'notes' => $request->notes,
                'expiry_date' => $expiry_date,
                'remaining_value' => $request->value,
                'purchase_date' => Carbon::now(), // Set purchase_date to today's date
                'last_used' => null,
                // 'expired' => $request->expired ?? 'no',
                // 'cancelled' => $request->cancelled ?? 'no',
                'purchase_at' => 'Dr Umed Enterprise',
                'recipient' => 'Promotional Gift Card'
            ]);
            $giftCards[] = $giftCard;
        }

        // Check if gift cards were created successfully
        if (!empty($giftCards)) {
            $response = [
                'success' => true,
                'message' => 'Gift Cards Created successfully!',
                'type' => 'success',
                'data_ids' => array_map(function ($giftCard) {
                    return $giftCard->id;
                }, $giftCards)
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Error!',
                'type' => 'error',
            ];
        }

        return response()->json($response);
    }

    // Example method to generate a unique tracking number
    protected function generateTrackingNumber()
    {
        return strtoupper(Str::random(10)); // This is a placeholder. Implement your logic here.
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
        $existing_remain_value = GiftCard::where('id',$request->hdn_id)->first();
        // dd($existing_remain_value);
        if($existing_remain_value->remaining_value != $request->remaining_value)
        {
            $difference = $request->remaining_value - $existing_remain_value->remaining_value;
            $redeemed_value_type = $existing_remain_value->remaining_value > $request->remaining_value ? 'decrease' : 'increase';
            
            $addgifttransaction = GiftCardTransaction::create([
                'gift_card_id' => $existing_remain_value->id,
                'date_time' => Carbon::now()->setTimezone('Asia/Kolkata'),
                'location_name' => 'Dr Umed Enterprise',
                'redeemed_value' =>  abs($difference),
                'redeemed_value_type' => $redeemed_value_type,
                'redeemed_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            ]);            
        }
        $update = GiftCard::updateOrCreate(['id' => $request->hdn_id],[
            'remaining_value' => $request->remaining_value,
            'expiry_date' => isset($request->is_expired)?$request->edit_expiry_date:null,
            'notes' => $request->edit_notes,
            'expired' => 'yes'
        ]);

        
        if($update){
            $response = [
                'success' => true,
                'message' => 'Gift Card Updated successfully!',
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
    public function destroy(string $id)
    {
        //
    }
    public function transactions(Request $request)
    {
        $transactions = GiftCardTransaction::where('gift_card_id', $request->id)->get();
        return view('gift-card.transaction-partial', compact('transactions')); // Assuming you have a partial view for rendering transactions
    }
    public function cancel_gift_card(Request $request)
    {
        // dd($request->all());
        $update = GiftCard::updateOrCreate(['id' => $request->id],[
            'cancelled'       => 'yes',
            'cancelled_at'    => Carbon::now()->setTimezone('Asia/Kolkata'),
            'remaining_value' => 0
        ]);
        if($update){
            $response = [
                'success' => true,
                'message' => 'Gift Card Cancelled successfully!',
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
    public function email_gift_card(Request $request)
    {
        $email = $request->email_card;
        $data = [
            'from_email'       => env('MAIL_FROM_ADDRESS'),
            'subject'          => "You've received a gift card",
            'email'            => $email,
            'value'            => $request->value,
            'notes'            => $request->notes,
            'voucher_num'      => $request->voucher_num,
            'expiry_date'      => $request->expiry_date
        ];

        $sub = $data['subject'];
        Mail::send('email.received-gift-card', $data, function ($message) use ($email, $data) {
            $message->to(trim($email)) // Trim whitespace from email address
                ->subject($data['subject']);
            $message->from(env('MAIL_FROM_ADDRESS'), $data['subject']);
        });

        // Get the current user
        $user = Auth::user();

        // Create a new email gift card history entry
        EmailGiftCardHistory::create([
            'tracking_number' => $request->voucher_num,
            'email'           => $email,
            'sent_by'         => $user->first_name . ' ' . $user->last_name,
            'send_date'       => Carbon::now()->setTimezone('Asia/Kolkata'),
        ]);
        return response()->json(['success' => true]);
    }
    public function get_email_history($voucher_num)
    {
        $history = EmailGiftCardHistory::where('tracking_number', $voucher_num)->get();
        return response()->json($history);
    }
}