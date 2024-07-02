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

            // Fetch gender ratio
            $gender_ratio = Clients::select('gender', DB::raw('count(*) as count'))
            ->whereIn('id', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->select('client_id')->from('walk_in_retail_sale')->whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                ->union(
                    Appointment::select('client_id')->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                );
            })
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['gender'] => $item['count']];
            });

            // Ensure gender_ratio includes both 'Men' and 'Women' keys with default values if they are not present
            $gender_ratio = array_merge(['Men' => 0, 'Women' => 0], $gender_ratio->toArray());

            //Calendar appointments
            $today = Carbon::today()->toDateString(); // Get today's date in YYYY-MM-DD format

            // Fetch appointments for today and include client firstname, lastname, and service_name
            $today_appointments = Appointment::with('staff','note')->leftJoin('clients', 'appointment.client_id', '=', 'clients.id')
                ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
                ->whereDate('appointment.start_date', $today)
                ->orderBy('appointment.start_date', 'asc') // Sort by start_date in descending order
                ->limit(5) // Limit to the latest 5 appointment
                ->get(['appointment.*', 'clients.firstname', 'clients.lastname', 'services.service_name']);
            // dd($today_appointments);

            //for clients tab data
            $currentDateTime = now()->timezone('Asia/Kolkata')->format('Y-m-d H:i:s');
            
            $client_data = Clients::leftJoin('appointment', function($join) use ($currentDateTime) {
                $join->on('clients.id', '=', 'appointment.client_id')
                    ->where('appointment.start_date', '>=', $currentDateTime);
            })
            ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
            ->leftJoin('users', 'appointment.staff_id', '=', 'users.id')
            ->leftJoin('locations', 'users.staff_member_location', '=', 'locations.id')
            ->leftJoin('appointments_notes', 'appointments_notes.appointment_id', '=', 'appointment.id')
            ->select('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status', 
                    DB::raw('GROUP_CONCAT(CONCAT(DATE_FORMAT(appointment.start_date, "%d-%m-%Y %h:%i %p"), "|", services.service_name, " with ", CONCAT(users.first_name, " ", users.last_name))) as appointment_dates'),
                    DB::raw('GROUP_CONCAT(CASE appointment.status 
                        WHEN 1 THEN "Booked" 
                        WHEN 2 THEN "Confirmed"
                        WHEN 3 THEN "Started" 
                        WHEN 4 THEN "Completed"
                        WHEN 5 THEN "No answer" 
                        WHEN 6 THEN "Left message"
                        WHEN 7 THEN "Pencilied in" 
                        WHEN 8 THEN "Turned up"
                        WHEN 9 THEN "No show" 
                        WHEN 10 THEN "Cancelled"
                    END) as app_status'),
                    DB::raw('GROUP_CONCAT(users.staff_member_location) as staff_member_location'),
                    DB::raw('GROUP_CONCAT(appointments_notes.common_notes SEPARATOR ",") as common_notes'),
                    DB::raw('GROUP_CONCAT(appointments_notes.treatment_notes SEPARATOR ",") as treatment_notes')
            )
            ->groupBy('clients.id', 
                    'clients.firstname', 
                    'clients.lastname', 
                    'clients.email', 
                    'clients.mobile_number', 
                    'clients.status'
            )
            ->where('clients.status','active')
            ->orderby('id','desc')->limit('5')
            ->get();
            foreach($client_data as $datas){
                $loc= explode(',',$datas->staff_member_location);
                $locationsArray = [];
                foreach($loc as $locs){
                    $locations = Locations::where('id', $locs)->pluck('location_name')->toArray();
                    $locationsArray[] = implode(", ", $locations);
                }
                $datas->staff_location = implode(", ", $locationsArray);
            }
            // dd($client_data);
            return view('dashboard', compact('locations', 'made_so_far', 'expected', 'scheduled_app', 'completed_app', 'cancelled_app', 'total_app', 'total_month_clients', 'total_month_enquiries','client_graph','enquiry_graph','gender_ratio','today_appointments','client_data'));
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
             // Gender ratio filter
                $gender_ratio = Clients::select('gender', DB::raw('count(*) as count'))
                ->whereIn('id', function ($query) use ($startDate, $endDate) {
                    $query->select('client_id')->from('walk_in_retail_sale')->whereBetween('invoice_date', [$startDate, $endDate])
                        ->union(
                            Appointment::select('client_id')->whereBetween('start_date', [$startDate, $endDate])
                        );
                })
                ->groupBy('gender')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->gender => $item->count];
                })
                ->toArray();

            // Ensure gender_ratio includes both 'Men' and 'Women' keys with default values if they are not present
            $gender_ratio = array_merge(['Male' => 0, 'Female' => 0], $gender_ratio);
            //gender ratio filter end

            //appointments filter 
            if(isset($request->date))
            {
                $other_appointments = Appointment::with('staff','note')->leftJoin('clients', 'appointment.client_id', '=', 'clients.id')
                ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
                ->whereDate('appointment.start_date', $request->date)
                ->orderBy('appointment.start_date', 'asc') // Sort by start_date in descending order
                ->limit(5) // Limit to the latest 5 appointment
                ->get(['appointment.*', 'clients.firstname', 'clients.lastname', 'services.service_name']);
            }
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
            
            //gender ratio filter start
            $gender_ratio = Clients::select('gender', DB::raw('count(*) as count'))
            ->whereIn('id', function ($query) use ($startDate, $endDate,$location) {
                $query->select('client_id')->from('walk_in_retail_sale')->where('location_id',$location)->whereBetween('invoice_date', [$startDate, $endDate])
                ->union(
                    Appointment::select('client_id')->where('location_id',$location)->whereBetween('start_date', [$startDate, $endDate])
                );
            })
            ->groupBy('gender')
            
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['gender'] => $item['count']];
            });

            // Ensure gender_ratio includes both 'Men' and 'Women' keys with default values if they are not present
            $gender_ratio = array_merge(['Men' => 0, 'Women' => 0], $gender_ratio->toArray());
            //gender ratio filter end

            //appointments filter 
            if(isset($request->date))
            {
                $other_appointments = Appointment::with('staff','note')->leftJoin('clients', 'appointment.client_id', '=', 'clients.id')
                ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
                ->whereDate('appointment.start_date', $request->date)
                ->orderBy('appointment.start_date', 'asc') // Sort by start_date in descending order
                ->limit(5) // Limit to the latest 5 appointment
                ->where('appointment.location_id',$location)
                ->get(['appointment.*', 'clients.firstname', 'clients.lastname', 'services.service_name']);
            }
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
            'genderGraph'   => $gender_ratio,
            'appointmentComp' => $other_appointments
        ]);
    }
    public function sales_performance_filter(Request $request)
    {
        $period = $request->period;
        // dd($period);
        if ($period == 'month') {
            $formattedData = [];
            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            // Loop through the last 12 months including the current month
            for ($i = 0; $i < 12; $i++) {
                // Calculate month and year for each iteration
                $month = $currentMonth - $i;
                $year = $currentYear;

                if ($month <= 0) {
                    $month += 12;
                    $year--;
                }

                // Calculate start and end of the month
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                // Query for all sales within the month
                $total_sales_second_half = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->where('status', '!=', '4')
                    ->get();

                // Calculate expected sales
                $walk_in_count = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->whereNull('appt_id')
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

                // Store data for the current month in formattedData array
                $formattedData[] = [
                    'period' => $months[$month - 1],
                    'expected' => $expected,
                    'achieved' => $achieved
                ];
            }
            // Return the formatted data as JSON
            return response()->json(array_reverse($formattedData));
        }else if ($period == 'week') {
            $formattedData = [];
            $carbonNow = Carbon::now();
            $currentDate = $carbonNow->copy(); // Current date
        
            // Define the specific week ranges based on today's date (18-06-2024)
            $weeks = [];
            
            // Loop to get data for last 4 weeks including current week
            for ($i = 0; $i < 4; $i++) {
                $startOfWeek = $currentDate->copy()->subWeeks($i)->startOfWeek();
                $endOfWeek = $currentDate->copy()->subWeeks($i)->endOfWeek();
        
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
            return response()->json(array_reverse($formattedData));
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
            return response()->json(array_reverse($formattedData));
        }

        // Handle other periods if needed
        // ...

        // Default response if no valid period is provided
        return response()->json(['error' => 'Invalid period'], 400);
    }
    public function today_appointments(Request $request)
    {
        $location_id = $request->location_ids;
        if($location_id == 'All')
        {
            // Fetch appointments for today and include client firstname, lastname, and service_name
            $other_appointments = Appointment::with('staff','note')->leftJoin('clients', 'appointment.client_id', '=', 'clients.id')
            ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
            ->whereDate('appointment.start_date', $request->date)
            ->orderBy('appointment.start_date', 'asc') // Sort by start_date in descending order
            ->limit(5) // Limit to the latest 5 appointment
            ->get(['appointment.*', 'clients.firstname', 'clients.lastname', 'services.service_name']);
        }else{
            // Fetch appointments for today and include client firstname, lastname, and service_name
            $other_appointments = Appointment::with('staff','note')->leftJoin('clients', 'appointment.client_id', '=', 'clients.id')
            ->leftJoin('services', 'appointment.service_id', '=', 'services.id')
            ->whereDate('appointment.start_date', $request->date)
            ->where('appointment.location_id',$location_id)
            ->orderBy('appointment.start_date', 'asc') // Sort by start_date in descending order
            ->limit(5) // Limit to the latest 5 appointment
            ->get(['appointment.*', 'clients.firstname', 'clients.lastname', 'services.service_name']);
        }
        

        return response()->json($other_appointments);
    }
    public function client_ratio_filter(Request $request)
    {
        $period = $request->period;
        if ($period == 'month') {
            $formattedData = [];
            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
            // Get current month and year
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        
            // Loop through the last 12 months including the current month
            for ($i = 0; $i < 12; $i++) {
                // Calculate month and year for each iteration
                $month = $currentMonth - $i;
                $year = $currentYear;
        
                if ($month <= 0) {
                    $month += 12;
                    $year--;
                }
        
                // Calculate start and end of the month
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
                // Client's Ratio start
                // Casual clients count
                $casual_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->where('appt_id', null)
                    ->where('customer_type', 'casual')
                    ->count();
        
                // New clients count (both appointment and walk-in)
                $new_client_appt = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->where('client_type', 'New Clients')
                    ->count();
        
                $new_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->where('appt_id', null)
                    ->where('customer_type', 'new')
                    ->count();
        
                $new_clients = $new_client_appt + $new_client_walk_in;
        
                // Returning clients count (appointment)
                $returning_client_appt = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->where('client_type', 'Returning Clients')
                    ->count();
        
                // Rebooked clients count (appointment)
                $rebooked_client_appt = Appointment::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->where('client_type', 'Rebooked Clients')
                    ->count();
        
                // Client's Ratio end
        
                // Calculate achieved sales
                $achieved = WalkInRetailSale::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->sum('total');
        
                // Prepare data for the current month
                $formattedData[] = [
                    'category' => $months[$month - 1],
                    'casual_clients' => $casual_client_walk_in,
                    'new_clients' => $new_clients,
                    'returning_client_appt' => $returning_client_appt,
                    'rebooked_client_appt' => $rebooked_client_appt,
                    'achieved_sales' => $achieved
                ];
            }
        
            // Return the formatted data as JSON
            return response()->json(array_reverse($formattedData));
        }else if ($period == 'week') {
            $formattedData = [];
            $carbonNow = Carbon::now();
            $currentDate = $carbonNow->copy(); // Current date
        
            // Define the specific week ranges based on today's date
            $weeks = [
                ['start' => $currentDate->copy()->startOfWeek(), 'end' => $currentDate->copy()->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(1)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(1)->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(2)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(2)->endOfWeek()],
                ['start' => $currentDate->copy()->subWeeks(3)->startOfWeek(), 'end' => $currentDate->copy()->subWeeks(3)->endOfWeek()]
            ];
        
            // Fetch data for each specific week range
            foreach ($weeks as $index => $week) {
                $startOfWeek = $week['start'];
                $endOfWeek = $week['end'];
        
                // Query for client ratio data within the current week
                $casual_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfWeek, $endOfWeek])
                    ->where('appt_id', null)
                    ->where('customer_type', 'casual')
                    ->count();
        
                $new_client_appt = Appointment::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                    ->where('client_type', 'New Clients')
                    ->count();
        
                $new_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfWeek, $endOfWeek])
                    ->where('appt_id', null)
                    ->where('customer_type', 'new')
                    ->count();
        
                $new_clients = $new_client_appt + $new_client_walk_in;
        
                $returning_client_appt = Appointment::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                    ->where('client_type', 'Returning Clients')
                    ->count();
        
                $rebooked_client_appt = Appointment::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                    ->where('client_type', 'Rebooked Clients')
                    ->count();
        
                $formattedData[] = [
                    'category' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M'),
                    'casual_clients' => $casual_client_walk_in,
                    'new_clients' => $new_clients,
                    'returning_client_appt' => $returning_client_appt,
                    'rebooked_client_appt' => $rebooked_client_appt
                ];
            }
            // Return the formatted data as JSON
            return response()->json(array_reverse($formattedData));
        }else if ($period == 'day') {
            $formattedData = [];
            $carbonNow = Carbon::now();
        
            for ($i = 0; $i < 7; $i++) {
                // Calculate start and end dates for each day
                $startOfDay = $carbonNow->copy()->subDays($i)->startOfDay();
                $endOfDay = $carbonNow->copy()->subDays($i)->endOfDay();
        
                // Query for client ratio data within the current day
                $casual_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfDay, $endOfDay])
                    ->where('appt_id', null)
                    ->where('customer_type', 'casual')
                    ->count();
        
                $new_client_appt = Appointment::whereBetween('start_date', [$startOfDay, $endOfDay])
                    ->where('client_type', 'New Clients')
                    ->count();
        
                $new_client_walk_in = WalkInRetailSale::whereBetween('invoice_date', [$startOfDay, $endOfDay])
                    ->where('appt_id', null)
                    ->where('customer_type', 'new')
                    ->count();
        
                $new_clients = $new_client_appt + $new_client_walk_in;
        
                $returning_client_appt = Appointment::whereBetween('start_date', [$startOfDay, $endOfDay])
                    ->where('client_type', 'Returning Clients')
                    ->count();
        
                $rebooked_client_appt = Appointment::whereBetween('start_date', [$startOfDay, $endOfDay])
                    ->where('client_type', 'Rebooked Clients')
                    ->count();
        
                $formattedData[] = [
                    // 'period' => $startOfDay->format('d-m-y'), // Format as desired, e.g., '2024-06-18'
                    'category' => $startOfDay->format('d-m-y'), // Format as desired, e.g., '18 Jun 2024'
                    'casual_clients' => $casual_client_walk_in,
                    'new_clients' => $new_clients,
                    'returning_client_appt' => $returning_client_appt,
                    'rebooked_client_appt' => $rebooked_client_appt
                ];
            }
            // Return the formatted data as JSON
            return response()->json(array_reverse($formattedData));
        }
        // Default response if no valid period is provided
        return response()->json(['error' => 'Invalid period'], 400);
    }
    public function selling_treatments_name_filter(Request $request)
    {
        $period = $request->period;
        if ($period == 'month') {
            // Get current month and year
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        
            // Calculate the start date for 12 months ago
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        
            // Fetch top 4 distinct services by total price over the last 12 months including the current month
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name')
                ->where('walk_in_products.product_type', 'service')
                ->whereBetween('walk_in_retail_sale.invoice_date', [$startDate, Carbon::now()->endOfMonth()])
                ->groupBy('walk_in_products.product_name')
                ->havingRaw('SUM(walk_in_products.product_price) > 0')
                ->orderByRaw('SUM(walk_in_products.product_price) DESC')
                ->limit(4)
                ->pluck('walk_in_products.product_name')
                ->toArray(); // Convert pluck result to array
        
            // Initialize an array to store valid service names
            $validServices = [];
        
            // Iterate over each service name
            foreach ($topServices as $service) {
                // Check if the service has a non-zero price for any month
                $hasNonZeroPrice = false;
        
                // Iterate over 12 months
                for ($i = 0; $i < 12; $i++) {
                    $month = $currentMonth - $i;
                    $year = $currentYear;
                    if ($month <= 0) {
                        $year--;
                        $month = 12 + $month;
                    }
        
                    // Calculate start and end dates for the current month
                    $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                    $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
                    // Query to check if the service has non-zero price for this month
                    $totalMonthPrice = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $service)
                        ->whereBetween('walk_in_retail_sale.invoice_date', [$startDate, $endDate])
                        ->sum('walk_in_products.product_price');
        
                    // If any month has non-zero price, set flag and break the loop
                    if ($totalMonthPrice > 0) {
                        $hasNonZeroPrice = true;
                        break;
                    }
                }
        
                // If service has non-zero price for any month, add it to validServices array
                if ($hasNonZeroPrice) {
                    $validServices[] = $service;
                }
            }
        
            // Return validServices as JSON response
            return response()->json($validServices);
        }else if ($period == 'week') {
            $currentWeek = Carbon::now()->weekOfYear;
            $currentYear = Carbon::now()->year;
        
            // Fetch top 4 distinct services by total price over the current year, excluding services with a total price of 0
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name')
                ->where('walk_in_products.product_type', 'service')
                ->whereYear('walk_in_retail_sale.invoice_date', $currentYear)
                ->groupBy('walk_in_products.product_name')
                ->havingRaw('SUM(walk_in_products.product_price) > 0')
                ->orderByRaw('SUM(walk_in_products.product_price) DESC')
                ->limit(4)
                ->pluck('walk_in_products.product_name');
        
            // Initialize an array to store valid service names
            $validServices = [];
        
            // Iterate over each service name
            foreach ($topServices as $service) {
                // Check if the service has a non-zero price for any week
                $hasNonZeroPrice = false;
        
                for ($i = 0; $i < 4; $i++) {
                    $week = $currentWeek - $i;
                    $year = $currentYear;
                    if ($week <= 0) {
                        $year--;
                        $week = Carbon::createFromDate($year, 12, 31)->weekOfYear + $week;
                    }
                    $startOfWeek = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->startOfWeek();
                    $endOfWeek = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->endOfWeek();
        
                    // Query to check if the service has non-zero price for this week
                    $totalWeekPrice = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $service)
                        ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfWeek, $endOfWeek])
                        ->sum('walk_in_products.product_price');
        
                    // If any week has non-zero price, set flag and break the loop
                    if ($totalWeekPrice > 0) {
                        $hasNonZeroPrice = true;
                        break;
                    }
                }
        
                // If service has non-zero price for any week, add it to validServices array
                if ($hasNonZeroPrice) {
                    $validServices[] = $service;
                }
            }
        
            // Return validServices as JSON response
            return response()->json($validServices);
        } elseif ($period == 'day') {
            $currentDate = Carbon::now();
        
            // Calculate the start date for 7 days ago
            $startDate = $currentDate->copy()->subDays(6); // 6 days ago from today
        
            // Fetch top 4 distinct services by total price over the last 7 days, excluding services with a total price of 0
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name', DB::raw('SUM(walk_in_products.product_price) as total_price'))
                ->where('walk_in_products.product_type', 'service')
                ->whereBetween('walk_in_retail_sale.invoice_date', [$startDate, $currentDate])
                ->groupBy('walk_in_products.product_name')
                ->orderByDesc('total_price')
                ->limit(4)
                ->pluck('walk_in_products.product_name')
                ->toArray(); // Convert pluck result to array
        
            // Initialize an array to store valid service names
            $validServices = [];
        
            // Iterate over each service name
            foreach ($topServices as $service) {
                // Check if the service has a non-zero price for any day within the last 7 days
                $hasNonZeroPrice = false;
        
                // Iterate over the last 7 days
                for ($i = 0; $i < 7; $i++) {
                    $dateToCheck = $currentDate->copy()->subDays($i);
        
                    // Query to check if the service has non-zero price for this day
                    $totalDayPrice = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $service)
                        ->whereDate('walk_in_retail_sale.invoice_date', $dateToCheck)
                        ->sum('walk_in_products.product_price');
        
                    // If any day has non-zero price, set flag and break the loop
                    if ($totalDayPrice > 0) {
                        $hasNonZeroPrice = true;
                        break;
                    }
                }
        
                // If service has non-zero price for any day, add it to validServices array
                if ($hasNonZeroPrice) {
                    $validServices[] = $service;
                }
            }
        
            // Return validServices as JSON response
            return response()->json($validServices);
        }                
    }
    public function selling_treatments_filter(Request $request)
    {
        $period = $request->period;
        if ($period == 'month') {
            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        
            // Fetch all distinct services and their total prices over the year
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name', DB::raw('SUM(walk_in_products.product_price) as total_price'))
                ->where('walk_in_products.product_type', 'service')
                ->groupBy('walk_in_products.product_name')
                ->orderByDesc('total_price')
                ->limit(4)
                ->pluck('walk_in_products.product_name');
        
            $dataTopSellingTreatments = [];
            foreach ($topServices as $treatment) {
                $treatmentData = [];
                $hasNonZeroPrice = false; // Flag to check if any non-zero price found for this service
        
                for ($i = 0; $i < 12; $i++) {
                    $month = $currentMonth - $i;
                    $year = $currentYear;
                    if ($month <= 0) {
                        $month += 12;
                        $year--;
                    }
                    $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                    $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
                    $top_selling_treatments = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->select('walk_in_products.product_name', 'walk_in_products.product_price', DB::raw('SUM(walk_in_products.product_quantity) as total_product_quantity'), DB::raw('SUM(walk_in_products.product_price) as total_product_price'))
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $treatment)
                        ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfMonth, $endOfMonth])
                        ->groupBy('walk_in_products.product_name', 'walk_in_products.product_price')
                        ->orderByDesc('total_product_quantity')
                        ->first();
        
                    $totalMonthPrice = $top_selling_treatments ? $top_selling_treatments->total_product_price : 0;
        
                    // Check if total price is greater than 0
                    if ($totalMonthPrice > 0) {
                        $hasNonZeroPrice = true; // Set flag if non-zero price found for this service
                    }
        
                    // Always add data for the month to $treatmentData
                    $treatmentData[] = [
                        'date' => $startOfMonth->timestamp * 1000, // Convert to milliseconds
                        'month' => $months[$month - 1], // Convert to milliseconds
                        'price' => (int)$totalMonthPrice
                    ];
                }
        
                // Only add service to $dataTopSellingTreatments if hasNonZeroPrice is true
                if ($hasNonZeroPrice) {
                    $dataTopSellingTreatments[$treatment] = array_reverse($treatmentData);
                }
            }
        
            return response()->json($dataTopSellingTreatments);
        
        }elseif ($period == 'week') {
            $currentWeek = Carbon::now()->weekOfYear;
            $currentYear = Carbon::now()->year;

            // Fetch all distinct services and their total prices over the current year
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name', DB::raw('SUM(walk_in_products.product_price) as total_price'))
                ->where('walk_in_products.product_type', 'service')
                ->groupBy('walk_in_products.product_name')
                ->orderByDesc('total_price')
                ->limit(4)
                ->pluck('walk_in_products.product_name');

            $dataTopSellingTreatments = [];
            foreach ($topServices as $treatment) {
                $treatmentData = [];
                $hasNonZeroPrice = false; // Flag to check if any non-zero price found for this service

                for ($i = 0; $i < 4; $i++) {
                    $week = $currentWeek - $i;
                    $year = $currentYear;
                    if ($week <= 0) {
                        $year--;
                        $week = Carbon::createFromDate($year, 12, 31)->weekOfYear + $week;
                    }
                    $startOfWeek = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->startOfWeek();
                    $endOfWeek = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->endOfWeek();

                    $top_selling_treatments = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->select('walk_in_products.product_name', 'walk_in_products.product_price', DB::raw('SUM(walk_in_products.product_quantity) as total_product_quantity'), DB::raw('SUM(walk_in_products.product_price) as total_product_price'))
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $treatment)
                        ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfWeek, $endOfWeek])
                        ->groupBy('walk_in_products.product_name', 'walk_in_products.product_price')
                        ->orderByDesc('total_product_quantity')
                        ->first();

                    $totalWeekPrice = $top_selling_treatments ? $top_selling_treatments->total_product_price : 0;

                    // Check if total price is greater than 0
                    if ($totalWeekPrice > 0) {
                        $hasNonZeroPrice = true; // Set flag if non-zero price found for this service
                    }

                    // Always add data for the week to $treatmentData
                    $treatmentData[] = [
                        'date' => $startOfWeek->timestamp * 1000, // Convert to milliseconds
                        'week' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M'), // Format week range
                        'price' => (int)$totalWeekPrice
                    ];
                }

                // Only add service to $dataTopSellingTreatments if hasNonZeroPrice is true
                if ($hasNonZeroPrice) {
                    $dataTopSellingTreatments[$treatment] = array_reverse($treatmentData);
                }
            }

            return response()->json($dataTopSellingTreatments);
        }elseif ($period == 'day') {
            $currentDate = Carbon::now();
        
            // Fetch all distinct services and their total prices over the current year
            $topServices = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                ->select('walk_in_products.product_name', DB::raw('SUM(walk_in_products.product_price) as total_price'))
                ->where('walk_in_products.product_type', 'service')
                ->groupBy('walk_in_products.product_name')
                ->orderByDesc('total_price')
                ->limit(4)
                ->pluck('walk_in_products.product_name');
        
            $dataTopSellingTreatments = [];
        
            // Loop through the last 6 days plus today (total 7 days)
            for ($i = 0; $i < 7; $i++) {
                $date = $currentDate->copy()->subDays($i);
        
                $startOfDay = $date->copy()->startOfDay();
                $endOfDay = $date->copy()->endOfDay();
        
                // Initialize data array for each day
                $dailyData = [];
        
                // Fetch data for each treatment
                foreach ($topServices as $treatment) {
                    $top_selling_treatments = WalkInRetailSale::leftJoin('walk_in_products', 'walk_in_retail_sale.id', '=', 'walk_in_products.walk_in_id')
                        ->select('walk_in_products.product_name', 'walk_in_products.product_price', DB::raw('SUM(walk_in_products.product_quantity) as total_product_quantity'), DB::raw('SUM(walk_in_products.product_price) as total_product_price'))
                        ->where('walk_in_products.product_type', 'service')
                        ->where('walk_in_products.product_name', $treatment)
                        ->whereBetween('walk_in_retail_sale.invoice_date', [$startOfDay, $endOfDay])
                        ->groupBy('walk_in_products.product_name', 'walk_in_products.product_price')
                        ->orderByDesc('total_product_quantity')
                        ->first();
        
                    $totalDayPrice = $top_selling_treatments ? $top_selling_treatments->total_product_price : 0;
        
                    // Add data for the treatment to the daily data array
                    $dailyData[$treatment] = [
                        'date' => $startOfDay->timestamp * 1000, // Convert to milliseconds
                        'day' => $date->format('Y-m-d'),
                        'price' => (int)$totalDayPrice
                    ];
                }
        
                // Store daily data for each treatment
                foreach ($topServices as $treatment) {
                    if (!isset($dataTopSellingTreatments[$treatment])) {
                        $dataTopSellingTreatments[$treatment] = [];
                    }
        
                    // Add data for the treatment to the daily data if price is greater than 0
                    $dataTopSellingTreatments[$treatment][] = [
                        'date' => $dailyData[$treatment]['date'],
                        'price' => $dailyData[$treatment]['price']
                    ];
                }
            }
        
            // Remove treatments with all zero prices
            foreach ($dataTopSellingTreatments as $treatment => $treatmentData) {
                $countNonZeroPrices = collect($treatmentData)->filter(function ($item) {
                    return $item['price'] > 0;
                })->count();
        
                if ($countNonZeroPrices === 0) {
                    unset($dataTopSellingTreatments[$treatment]);
                }
            }
        
            // Reverse each treatment's data to ensure chronological order
            foreach ($dataTopSellingTreatments as $treatment => &$treatmentData) {
                $treatmentData = array_reverse($treatmentData);
            }
        
            return response()->json($dataTopSellingTreatments);
        }
                
        return response()->json(['error' => 'Invalid period'], 400);
    }
}
