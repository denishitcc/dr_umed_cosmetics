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
            $made_so_far = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->sum('total');//for 1 to end of month filter
            
            $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])->where('status','!=','4')->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('appt_id',null)->sum('total');//for 1 to end of month filter
            
            $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
            ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfMonth, $endOfMonth])
            // ->where('appointment.status','!=','4')
            ->sum('walk_in_retail_sale.total');
            
            $expected = (int)$walk_in_count + (int)$walk_in_payment_count;
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
            // Total appointments
            $scheduled_app = Appointment::where('status', '1')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->count();
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
            $total_sales_second_half = Appointment::whereBetween('start_date', [$startDate, $endDate])->where('status','!=','4')->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])->where('appt_id',null)->sum('total');//for 1 to end of month filter
            
            $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
            ->whereBetween('walk_in_retail_sale.invoice_date', [$startDate, $endDate])
            // ->where('appointment.status','!=','4')
            ->sum('walk_in_retail_sale.total');
            
            $expected = (int)$walk_in_count + (int)$walk_in_payment_count;
            // $expected = (int)$walk_in_count;
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
            $completed_app = Appointment::where('status', '4')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->count();

            $cancelled_app = Appointment::where('status', '10')
                ->whereBetween('start_date', [$startDate, $endDate])
                ->count();

            $total_app = Appointment::whereBetween('start_date', [$startDate, $endDate])
                ->count();

            //total clients filter
            $total_filter_clients = Clients::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            // Get clients count grouped by day for the current month
            $client_graph = Clients::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

            //total enquiries filter
            $total_filter_enquiries = Enquiries::whereBetween('enquiry_date', [$startDate, $endDate])
                ->count();

            // Get enquiries count grouped by day for the current month
            $enquiry_graph = Enquiries::select(
                DB::raw('DATE(enquiry_date) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('enquiry_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(enquiry_date)'))
            ->get();
        }else{
            //total sales filter
            $totalSales = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])
            ->where('location_id', $location)
            ->sum('total');

            $total_sales_second_half = Appointment::whereBetween('start_date', [$startDate, $endDate])->where('location_id',$location)->where('status','!=','4')->get();
            $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startDate, $endDate])->where('appt_id',null)->where('location_id',$location)->sum('total');//for 1 to end of month filter
            
            $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
            ->whereBetween('walk_in_retail_sale.invoice_date', [$startDate, $endDate])
            // ->where('appointment.status','!=','4')
            ->sum('walk_in_retail_sale.total');
            
            $expected = (int)$walk_in_count + (int)$walk_in_payment_count;

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
                ->where('location_id',$location)
                ->count();
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
            
            //total clients filter
            $total_filter_clients = Clients::whereBetween('created_at', [$startDate, $endDate])
                ->where('location_id',$location)
                ->count();

            // Get clients count grouped by day for the current month
            $client_graph = Clients::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('location_id',$location)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

            //total enquiries filter
            $total_filter_enquiries = Enquiries::whereBetween('enquiry_date', [$startDate, $endDate])
                ->where('location_name',$location)
                ->count();

            // Get enquiries count grouped by day for the current month
            $enquiry_graph = Enquiries::select(
                DB::raw('DATE(enquiry_date) as date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('enquiry_date', [$startDate, $endDate])
            ->where('location_name',$location)
            ->groupBy(DB::raw('DATE(enquiry_date)'))
            ->get();
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
            'totalFilterClients' => $total_filter_clients,
            'clientGraph'   => $client_graph,
            'totalFilterEnquiries' => $total_filter_enquiries,
            'enquiryGraph'   => $enquiry_graph,
        ]);
    }
    public function sales_performance_filter(Request $request)
    {
        $period = $request->period;
        // dd($period);
        if ($period == 'month') {
            $formattedData = [];
            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            for ($month = 1; $month <= 12; $month++) {
                $startOfMonth = Carbon::create(null, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::create(null, $month, 1)->endOfMonth();

                // Query for all sales within the month
                $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->where('status', '!=', '4')
                    ->get();

                // Calculate expected sales
                $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->where('appt_id', null)
                    ->sum('total');

                $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
                    ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfMonth, $endOfMonth])
                    ->sum('walk_in_retail_sale.total');

                $expected = (int)$walk_in_count + (int)$walk_in_payment_count;

                foreach ($total_sales_second_half as $second) {
                    $ck_found_in_walk_in = WalkInRetailSale::where('appt_id', $second->id)->first();
                    if ($ck_found_in_walk_in) {
                        $expected += $ck_found_in_walk_in->total;
                    } else {
                        $service = Services::where('id', $second->service_id)->first();
                        if ($service) {
                            $expected += $service->standard_price;
                        }
                    }
                }

                // Calculate achieved sales
                $achieved = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->sum('total');

                $formattedData[] = [
                    'period' => $months[$month - 1],
                    'expected' => $expected,
                    'achieved' => $achieved
                ];
            }
            // Return the formatted data as JSON
            return response()->json($formattedData);
        }else if ($period == 'week') {
            $formattedData = [];
            $carbonNow = Carbon::now();
            $currentDate = $carbonNow->copy(); // Current date
        
            // Define the specific week ranges based on today's date (18-06-2024)
            $weeks = [
                ['start' => $currentDate->copy()->subWeeks(1)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(1)->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(2)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(2)->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(3)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(3)->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(4)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(4)->endOfWeek()]
            ];
        
            // Fetch data for each specific week range
            foreach ($weeks as $index => $week) {
                $startOfWeek = $week['start'];
                $endOfWeek = $week['end'];
        
                // Query for sales data within the current week
                $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                    ->where('status', '!=', '4')
                    ->get();
        
                // Calculate expected sales
                $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfWeek, $endOfWeek])
                    ->where('appt_id', null)
                    ->sum('total');
        
                $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
                    ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfWeek, $endOfWeek])
                    ->sum('walk_in_retail_sale.total');
        
                $expected = (int) $walk_in_count + (int) $walk_in_payment_count;
        
                foreach ($total_sales_second_half as $second) {
                    $ck_found_in_walk_in = WalkInRetailSale::where('appt_id', $second->id)->first();
                    if ($ck_found_in_walk_in) {
                        $expected += $ck_found_in_walk_in->total;
                    } else {
                        $service = Services::where('id', $second->service_id)->first();
                        if ($service) {
                            $expected += $service->standard_price;
                        }
                    }
                }
        
                // Calculate achieved sales
                $achieved = WalkInRetailSale::whereBetween('invoice_date', [$startOfWeek, $endOfWeek])
                    ->sum('total');
        
                // Format the data for the current week
                $formattedData[] = [
                    'period' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M'), // Week start and end dates
                    'from' => $startOfWeek->toDateString(), // Start date of the week
                    'to' => $endOfWeek->toDateString(), // End date of the week
                    'expected' => $expected,
                    'achieved' => $achieved
                ];
            }
        
            // Return the formatted data as JSON
            return response()->json($formattedData);
        }else if ($period == 'day') {
            $formattedData = [];
            $carbonNow = Carbon::now();
        
            for ($i = 0; $i < 7; $i++) {
                // Calculate start and end dates for each day
                $startOfDay = $carbonNow->copy()->subDays($i)->startOfDay();
                $endOfDay = $carbonNow->copy()->subDays($i)->endOfDay();
        
                // Query for sales data within the current day
                $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfDay, $endOfDay])
                    ->where('status', '!=', '4')
                    ->get();
        
                // Calculate expected sales
                $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfDay, $endOfDay])
                    ->where('appt_id', null)
                    ->sum('total');
        
                $walk_in_payment_count = WalkInRetailSale::join('appointment', 'walk_in_retail_sale.appt_id', '=', 'appointment.id')
                    ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfDay, $endOfDay])
                    ->sum('walk_in_retail_sale.total');
        
                $expected = (int) $walk_in_count + (int) $walk_in_payment_count;
        
                foreach ($total_sales_second_half as $second) {
                    $ck_found_in_walk_in = WalkInRetailSale::where('appt_id', $second->id)->first();
                    if ($ck_found_in_walk_in) {
                        $expected += $ck_found_in_walk_in->total;
                    } else {
                        $service = Services::where('id', $second->service_id)->first();
                        if ($service) {
                            $expected += $service->standard_price;
                        }
                    }
                }
        
                // Calculate achieved sales
                $achieved = WalkInRetailSale::whereBetween('invoice_date', [$startOfDay, $endOfDay])
                    ->sum('total');
        
                // Format the data for the current day
                $formattedData[] = [
                    'period' => $startOfDay->format('d-m-y'), // Format as desired, e.g., '2024-06-18'
                    'expected' => $expected,
                    'achieved' => $achieved
                ];
            }
        
            // Return the formatted data as JSON
            return response()->json($formattedData);
        }

        // Handle other periods if needed
        // ...

        // Default response if no valid period is provided
        return response()->json(['error' => 'Invalid period'], 400);
    }
}
