@extends('layouts/sidebar')
@section('title', 'Dashboard')
@section('content')
<style>
#clientchartdiv, #enquirychartdiv {
    width: 100%;
    height: 100px;
    max-width: 100%
}
#Salesperformancechartdiv{
    width: 100%;
    height: 300px;
    max-width: 100%
}
#GenderRatiochartdiv{
    width: 100%;
    height: 300px;
    max-width: 100%
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row mb-4">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <h4 class="small-title mb-0">Dashboard</h4>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="right d-flex">
            <!-- <input type="date" class="form-control"> -->
            <div id="reportrange" class="form-control d-flex align-items-center me-3">
                <i class="fa fa-calendar me-2"></i>
                <span></span> <i class="fa fa-caret-down ms-2"></i>
            </div>

            <select class="form-select" id="locations">
                <option>All</option>
                @if(count($locations)>0)
                    @foreach($locations as $loc)
                        <option value="{{$loc->id}}">{{$loc->location_name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3">
        <div class="card p-3 h-100">
            <h5 class="bright-gray mb-4">Total Sales</h5>

            <div class="d-flex justify-content-between mb-20 tot-sales mb-4">
                <div class="fonts">
                    <h3 class="made_so_far">${{ (Int)$made_so_far }}</h3>
                    Made so far
                </div>
                <div class="fonts">
                    <!-- <h3 class="expected">${{ $made_so_far + $expected }}</h3> -->
                    <h3 class="expected">${{ $expected }}</h3>
                    Expected
                </div>
            </div>
            <div class="progress mb-0">
                @php
                $made_so_far = (int)$made_so_far;
                $expected = (int)$expected;

                if (($expected) === 0) {
                    $percentage_remaining = 0; // or whatever value you want to assign in case of division by zero
                } else {
                    $percentage_remaining = ($made_so_far / $expected) * 100;
                }
                @endphp
                <div class="progress-bar pink sales_progress" role="progressbar"
                    aria-valuenow="{{ $percentage_remaining }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3 h-100">
            <h5 class="bright-gray">Total Appointments</h5>
            <div class="barWrapper">
            @php
            $scheduled_app = (int)$scheduled_app;
            $total_app = (int)$total_app;

            if ($total_app === 0) {
                $scheduled = 0; // or another default value if division by zero
            } else {
                $scheduled = ($scheduled_app / $total_app) * 100;
            }
            @endphp
            <div class="progressText">Scheduled <span class="counter scheduled_app">{{$scheduled_app}}</span></div>
                <div class="progress">
                    <div class="progress-bar scheduled" role="progressbar" aria-valuenow="{{$scheduled}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
            <div class="barWrapper">
                @php
                $completed_app = (int)$completed_app;
                $total_app = (int)$total_app;

                if ($total_app === 0) {
                    $completed = 0; // or another default value if total_app is zero
                } else {
                    $completed = ($completed_app / $total_app) * 100;
                }
                @endphp
                <div class="progressText">Completed <span class="counter completed_app">{{$completed_app}}</span></div>
                <div class="progress">
                    <div class="progress-bar completed" role="progressbar" aria-valuenow="{{$completed}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
            <div class="barWrapper">
                @php
                $cancelled_app = (int)$cancelled_app;
                $total_app = (int)$total_app;

                if ($total_app === 0) {
                    $cancelled = 0; // or another default value if total_app is zero
                } else {
                    $cancelled = ($cancelled_app / $total_app) * 100;
                }
                @endphp
                <div class="progressText">Cancelled <span class="counter cancelled_app">{{$cancelled_app}}</span></div>
                <div class="progress mb-0">
                    <div class="progress-bar cancelled" role="progressbar" aria-valuenow="{{$cancelled}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3 h-100">
            <h5 class="bright-gray">Total Clients</h5>
            <div class="d-flex justify-content-between mb-20 tot-clients mb-3">
                <div class="fonts">
                    <h3 class="mb-0 total_client">{{$total_month_clients}}</h3>
                </div>
                <div class="fonts" style="flex:0 0 80%">
                    <div id="clientchartdiv"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="card p-3 h-100">
            <h5 class="bright-gray">Total Enquiries</h5>
            <div class="d-flex justify-content-between mb-20 tot-enquiry mb-3">
                <div class="fonts">
                    <h3 class="mb-0 total_enquiry">{{$total_month_enquiries}}</h3>
                </div>
                <div class="fonts" style="flex:0 0 80%">
                    <div id="enquirychartdiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-head">
                        <div class="toolbar">
                            <div class="tool-left">
                                <h5 class="bright-gray mb-0">Sales Performance</h5>
                            </div>
                            <div class="tool-right">
                                <div class="text-right">
                                    <button class="btn btn-primary btn-sm mr-2" onclick="filterSalesPerformaceData('month')">Month</button>
                                    <button class="btn btn-primary btn-sm mr-2" onclick="filterSalesPerformaceData('week')">Week</button>
                                    <button class="btn btn-primary btn-sm" onclick="filterSalesPerformaceData('day')">Day</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div id="Salesperformancechartdiv"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-head p-4">
                        <h5 class="bright-gray mb-0">Gender Ratio</h5>
                    </div>
                    <div id="GenderRatiochartdiv"></div>
                </div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="card p-3">
                    <h5 class="bright-gray mb-4">Client’s Ratio</h5>
                    <img src="img/Group 15181.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="black-card p-3 h-100">
            <div class="calendar h-100">
            <h5 class="bright-gray mb-3">Appointments</h5>
                <div id="mycalendar"></div>
                <div class="all_appt mt-3 d-flex justify-content-between mb-3">
                    <h5 class="mb-0">Today's appointments</h5>
                    <a href="javascript:void(0);" style="text-decoration:none;" class='sm-3 view_all_appt font-12' appt-date="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">View All</a>
                </div>
                
                <ul class="black_calendar_appointment">
                @if(count($today_appointments) > 0)
                    @foreach($today_appointments as $appts)
                        <li class="edit_appt" id="{{$appts->id}}" loc-id="{{$appts->location_id}}">
                            <div class="d-flex justify-content-between">
                                <b class="doc_name">
                                    @if(!empty($appts['firstname']) && !empty($appts['lastname']))
                                        {{ $appts['firstname'].' '.$appts['lastname'] }}
                                    @else
                                        No Client
                                    @endif
                                </b>
                                <span class="app_time"> {{ \Carbon\Carbon::parse($appts->start_date)->format('g:i A') }}</span>
                            </div>
                            <span class="service_name">{{$appts['service_name']}} with <b>{{$appts->staff->first_name.' '.$appts->staff->last_name}}</b></span>
                            @if(isset($appts->note->common_notes))
                            <div class="notes">
                                Booking Note : 
                                @if(strlen($appts->note->common_notes) > 20)
                                    {{ substr($appts->note->common_notes, 0, 20) . '...' }}
                                @else
                                    {{ $appts->note->common_notes }}
                                @endif
                            </div>
                            @endif
                        </li>   
                    @endforeach
                    @else
                        <span class="error">No appointments for the selected date.</span>
                    @endif
                </ul>
                
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card p-3 h-100">
        <h5 class="bright-gray mb-4">Recent Activities</h5>
        
        <div class="feed-item">
            <div class="time">08:42</div>
            <div class="text">
                Non-Surgical Rhinoplasty Performed by esteemed cosmetic physician in Hope Island
            </div>
        </div>
        <div class="feed-item">
            <div class="time">10:00</div>
            <div class="text">
                Dr. Eardley has meeeting with 
            </div>
        </div>
        <div class="feed-item">
            <div class="time">10:00</div>
            <div class="text">
                <strong>Karinne Thomson deposited</strong> <strong class="blue">USD 700</strong> to Dr. Umed Cosmetics for treatment
            </div>
        </div>
        <div class="feed-item">
            <div class="time">16:50</div>
            <div class="text">
                Live Seminar by Dr. Jennifer Smith for Cosmetic Treatments and Skin Rejuvenation at Five Dock, Sydney, NSW
            </div>
        </div>
        <div class="feed-item">
            <div class="time">21:03</div>
            <div class="text">
                New order placed for product <strong>Acne Wash 180ml(6oz)</strong> <strong class="blue"> #XF-2356</strong>
            </div>
        </div>
        <div class="feed-item">
            <div class="time">23:03</div>
            <div class="text">
                New order placed for product <strong>Acne Wash 30ml(6oz)</strong> <strong class="blue"> #XF-2356</strong>
            </div>
        </div>

    </div>
</div>
<div class="col-lg-5">
    <div class="card p-3  h-100">
        <h5 class="bright-gray mb-5">Top Selling Treatments</h5>
        <img src="img/Group 15183.png" alt="">
    </div>
</div>
    <div class="col-md-3">
        <div class="card p-3 h-100">
            <h5 class="bright-gray mb-5">Top Selling Products</h5>
            <img src="img/Group 15184.png" alt="">
        </div>
    </div>
</div>
<div class="card">
    <ul class="nav brand-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1"><i class="ico-client"></i> Clients</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_2"><i class="ico-calendar"></i> Appointments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_3"><i class="ico-enquiries"></i> Enquiries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_4"><i class="ico-services"></i> Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_5"><i class="ico-products"></i> Products</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
            <div class="card-body">
                <img src="img/demo-table.png" alt="">
            </div>
            
        </div>
        <div class="tab-pane fade" id="tab_2" role="tabpanel">

            
            <div class="card-body">
                Appointments       
            </div>
            
            
        </div>
        <div class="tab-pane fade" id="tab_3" role="tabpanel">
            <div class="card-body">
            Enquiries
                </div>
        </div>
        <div class="tab-pane fade" id="tab_4" role="tabpanel">
            <div class="card-body">
            Services
                </div>
        </div>
        <div class="tab-pane fade" id="tab_5" role="tabpanel">
            <div class="card-body">
            Products
                </div>
        </div>
        
    </div>
    
</div>
@stop
@section('script')
<script src="{{ asset('js/dashboard.js') }}"></script>
<script>
    var ClientsGraph = {!! json_encode($client_graph) !!};
    var EnquiryGraph = {!! json_encode($enquiry_graph) !!};
    var FilterRoute = "{{ route('dashboard.filter') }}"; 
    var SalesPerformanceFilter = "{{ route('dashboard.sales_performance_filter') }}"; 
    var gender_ratio = {!! json_encode($gender_ratio) !!};
    var TodayAppointments = "{{ route('dashboard.today_appointments') }}"; 
</script>
@endsection