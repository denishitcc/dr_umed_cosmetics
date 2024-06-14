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
            // $made_so_far = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $today])->sum('total');//for 1 to today date filter
            $made_so_far = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->sum('total');//for 1 to end of month filter
            
            // $total_sales_second_half = Appointment::whereBetween('start_date', [$tomorrow, $endOfMonth])->get();
            $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('appt_id',null)->sum('total');//for 1 to end of month filter
            // dd($walk_in_count);
            // $expected = 0;//(int)$walk_in_count;
            $expected = (int)$walk_in_count;
            foreach ($total_sales_second_half as $second) {
                // dd($second);
                $ck_found_in_walk_in = WalkInRetailSale::where('appt_id',$second->id)->first();//for 1 to end of month filter
                // dd($ck_found_in_walk_in);
                if($ck_found_in_walk_in)
                {
                    $expected += $ck_found_in_walk_in->total;
                }else{
                    $service = Services::where('id', $second->service_id)->first();
                    if ($service) {
                        $expected += $service->standard_price;
                    }
                }
                
            }
            // dd($expected);
            // Total appointments
            $scheduled_app = Appointment::where('status', '1')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->count();
            // dd($scheduled_app);
            $completed_app = Appointment::where('status', '4')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->count();

            $cancelled_app = Appointment::where('status', '10')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->count();

            $total_app = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->count();

            // Total month clients
            $total_month_clients = Clients::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            // Get clients count grouped by day for the current month
            $client_graph = Clients::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

            // Total month enquiries
            $total_month_enquiries = Enquiries::whereBetween('enquiry_date', [$startOfMonth, $endOfMonth])
                ->count();

            // Fetching monthly enquiries data
            $enquiry_graph = Enquiries::select(
                DB::raw('DATE(enquiry_date) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('enquiry_date', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(enquiry_date)'))
            ->get();
            return view('dashboard', compact('locations', 'made_so_far', 'expected', 'scheduled_app', 'completed_app', 'cancelled_app', 'total_app', 'total_month_clients', 'total_month_enquiries','client_graph','enquiry_graph'));
        } else {
            return redirect()->route('login');
        }
    }
    public function filter(Request $request)
    {
        // dd($request->all());
        // Retrieve parameters from the AJAX request
        $reportRange = $request->input('reportRange');
        $location = $request->input('location');

        // Parse reportRange if necessary, example: "June 1, 2024 to June 30, 2024"
        if ($reportRange) {
            $dateRange = explode(' - ', $reportRange);
            $startDate = Carbon::parse($dateRange[0])->startOfDay();
            $endDate = Carbon::parse($dateRange[1])->endOfDay();
        } else {
            // Default to current month if reportRange is not provided
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        }
        
        // Perform your data retrieval or processing logic based on $startDate, $endDate, and $location
        // Example query to retrieve total sales in the given date range and location
        if($location == 'All')
        {
            //total sales filter
            $totalSales = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])
            ->sum('total');
            $total_sales_second_half = Appointment::whereBetween('start_date', [$startDate, $endDate])->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])->where('appt_id',null)->sum('total');//for 1 to end of month filter
            $expected = (int)$walk_in_count;
            foreach ($total_sales_second_half as $second) {
                $ck_found_in_walk_in = WalkInRetailSale::where('appt_id',$second->id)->first();//for 1 to end of month filter
                if($ck_found_in_walk_in)
                {
                    $expected += $ck_found_in_walk_in->total;
                }else{
                    $service = Services::where('id', $second->service_id)->first();
                    if ($service) {
                        $expected += $service->standard_price;
                    }
                }
            }
            //total appointments filter
            $scheduled_app = Appointment::where('status', '1')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->count();
            // dd($scheduled_app);
            $completed_app = Appointment::where('status', '4')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->count();

            $cancelled_app = Appointment::where('status', '10')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->count();

            $total_app = Appointment::whereBetween('start_date', [$startDate, $endDate])
                ->count();
        }else{
            //total sales filter
            $totalSales = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])
            ->where('location_id', $location)
            ->sum('total');

            $total_sales_second_half = Appointment::whereBetween('start_date', [$startDate, $endDate])->where('location_id',$location)->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])->where('appt_id',null)->where('location_id',$location)->sum('total');//for 1 to end of month filter
            $expected = (int)$walk_in_count;
            foreach ($total_sales_second_half as $second) {
                $ck_found_in_walk_in = WalkInRetailSale::where('appt_id',$second->id)->first();//for 1 to end of month filter
                if($ck_found_in_walk_in)
                {
                    $expected += $ck_found_in_walk_in->total;
                }else{
                    $service = Services::where('id', $second->service_id)->first();
                    if ($service) {
                        $expected += $service->standard_price;
                    }
                }
            }
            //total appointments filter
            //total appointments filter
            $scheduled_app = Appointment::where('status', '1')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->where('location_id',$location)
                ->count();
            // dd($scheduled_app);
            $completed_app = Appointment::where('status', '4')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->where('location_id',$location)
                ->count();

            $cancelled_app = Appointment::where('status', '10')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->where('location_id',$location)
                ->count();

            $total_app = Appointment::whereBetween('start_date', [$startDate, $endDate])
                ->where('location_id',$location)
                ->count();
        }
        
        // You can add more queries here to retrieve other data based on the filters

        // Return the data as JSON response
        return response()->json([
            'totalSales' => $totalSales,
            'expected'   => $expected,
            'scheduledApp' => $scheduled_app,
            'completedApp'   => $completed_app,
            'cancelledApp' => $cancelled_app,
            'totalApp'   => $total_app,
            // Add more data as needed
        ]);
    }
}
