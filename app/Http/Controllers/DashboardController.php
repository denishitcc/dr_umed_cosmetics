<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Locations;
use App\Models\WalkInRetailSale;
use App\Models\Appointment;
use App\Models\Services;
use App\Models\Clients;
use App\Models\Enquiries;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $locations = Locations::all();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Total sales start
            $startOfMonth = now()->startOfMonth();
            $today = now()->startOfDay();
            $tomorrow = now()->addDay()->startOfDay();
            $endOfMonth = now()->endOfMonth();

            $made_so_far = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $today])->sum('total');
            
            $total_sales_second_half = Appointment::whereBetween('start_date', [$tomorrow, $endOfMonth])->get();
            $expected = 0;
            foreach ($total_sales_second_half as $second) {
                $service = Services::where('id', $second->service_id)->first();
                if ($service) {
                    $expected += $service->standard_price;
                }
            }

            // Total appointments
            $scheduled_app = Appointment::where('status', '1')
                ->whereMonth('start_date', $endOfMonth)
                ->whereYear('start_date', $currentYear)
                ->count();
            // dd($scheduled_app);
            $completed_app = Appointment::where('status', '4')
                ->whereMonth('start_date', $endOfMonth)
                ->whereYear('start_date', $currentYear)
                ->count();

            $cancelled_app = Appointment::where('status', '10')
                ->whereMonth('start_date', $endOfMonth)
                ->whereYear('start_date', $currentYear)
                ->count();

            $total_app = Appointment::whereMonth('start_date', $endOfMonth)
                ->whereYear('start_date', $currentYear)
                ->count();

            // Total month clients
            $total_month_clients = Clients::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();

            // Get clients count grouped by day for the current month
            $client_graph = Clients::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

            // Total month enquiries
            $total_month_enquiries = Enquiries::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();

            // Fetching daily enquiries data
            $enquiry_graph = [];
            for ($day = 1; $day <= $endOfMonth->day; $day++) {
                $date = Carbon::createFromDate($currentYear, $currentMonth, $day)->toDateString();
                $count = Enquiries::whereDate('created_at', $date)->count();
                if ($count > 0) { // Only add to array if count is greater than 0
                    $enquiry_graph[] = [
                        'date' => $date,
                        'count' => $count
                    ];
                }
            }
            return view('dashboard', compact('locations', 'made_so_far', 'expected', 'scheduled_app', 'completed_app', 'cancelled_app', 'total_app', 'total_month_clients', 'total_month_enquiries','client_graph','enquiry_graph'));
        } else {
            return redirect()->route('login');
        }
    }
}
