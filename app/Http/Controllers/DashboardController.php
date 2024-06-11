<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Locations;
use App\Models\WalkInRetailSale;
use App\Models\Appointment;
use App\Models\Services;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $locations = Locations::all();

            // Get the start date of the current month and today's date
            $startOfMonth = now()->startOfMonth();
            $today = now()->startOfDay();

            // Get the start date for the second range (tomorrow) and the end of the current month
            $tomorrow = now()->addDay()->startOfDay();
            $endOfMonth = now()->endOfMonth();

            // Total Sales from the start of the month to today
            $made_so_far = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $today])->get();

            // Total Sales from tomorrow to the end of the current month
            $total_sales_second_half = Appointment::whereBetween('start_date', [$tomorrow, $endOfMonth])->get();
            // Initialize the total for the second half
            $expected = 0;

            if ($total_sales_second_half->count() > 0) {
                foreach ($total_sales_second_half as $second) {
                    $service = Services::where('id', $second->service_id)->first();
                    if ($service) {
                        $expected += $service->standard_price;
                    }
                }
            }

            // Sum the 'total' field for both arrays
            $made_so_far = $made_so_far->sum('total');
            

            // dd($expected);
            return view('dashboard', compact('locations', 'made_so_far', 'expected'));
        } else {
            // User is not authenticated, handle accordingly (e.g., redirect to login)
            return redirect()->route('login');
        }
    }
}
