@extends('layouts/sidebar')
@section('content')
<style>
#chartdiv {
    width: 100%;
    height: 100px;
    max-width: 100%
}
</style>
<div class="app-header mb-4">
    <h4 class="small-title mb-0">Dashboard</h4>

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
                    <option value="{{$loc->location_name}}">{{$loc->location_name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray mb-4">Total Sales</h5>

            <div class="d-flex justify-content-between mb-20 tot-sales mb-3">
                <div class="fonts">
                    <h3>${{ (Int)$made_so_far }}</h3>
                    Made so far
                </div>
                <div class="fonts">
                    <h3>${{ $made_so_far + $expected }}</h3>
                    Expected
                </div>
            </div>
            <div class="progress mb-0">
                @php
                $percentage_remaining = ((int)$made_so_far / ((int)$made_so_far + $expected)) * 100;
                @endphp
                <div class="progress-bar pink" role="progressbar"
                    aria-valuenow="{{ $percentage_remaining }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Appointments</h5>
            <div class="barWrapper">
            @php
            $scheduled = ((int)$scheduled_app / (int)$total_app) * 100;
            @endphp
            <div class="progressText">Scheduled <span class="counter">{{$scheduled_app}}</span></div>
                <div class="progress">
                    <div class="progress-bar scheduled" role="progressbar" aria-valuenow="{{$scheduled}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
            <div class="barWrapper">
                @php
                $completed = ((int)$completed_app / (int)$total_app) * 100;
                @endphp
                <div class="progressText">Completed <span class="counter">{{$completed_app}}</span></div>
                <div class="progress">
                    <div class="progress-bar completed" role="progressbar" aria-valuenow="{{$completed}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
            <div class="barWrapper">
                @php
                $cancelled = ((int)$cancelled_app / (int)$total_app) * 100;
                @endphp
                <div class="progressText">Cancelled <span class="counter">{{$cancelled_app}}</span></div>
                <div class="progress cancelled mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{$cancelled}}" aria-valuemin="0" aria-valuemax="100">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Clients</h5>
            <div class="d-flex justify-content-between mb-20 tot-clients mb-3">
                <div class="fonts">
                    <h3 class="mb-0">{{$total_month_clients}}</h3>
                </div>
                <div class="fonts" style="flex:0 0 80%">
                    <div id="chartdiv"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Enquiries</h5>
            <div class="d-flex justify-content-between mb-20 tot-enquiry mb-3">
                <div class="fonts">
                    <h3 class="mb-0">{{$total_month_enquiries}}</h3>
                </div>
                <div class="fonts">
                    Graph
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-9">
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-3">
                    <h5 class="bright-gray mb-3">Sales Performance</h5>
                    <img src="img/Group 15179.png" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-3">
                    <h5 class="bright-gray mb-5">Gender Ratio</h5>
                    <img src="img/Group 15180.png" alt="">
                </div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="card p-3">
                    <h5 class="bright-gray mb-4">Client’s Ratio</h5>
                    <img src="img/Group 15181.png" alt="">
                </div>
            </div>
            <div class="col-lg-5 mt-4">
                <div class="card p-3">
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
            <div class="col-lg-7 mt-4">
                <div class="card p-3">
                    <h5 class="bright-gray mb-5">Top Selling Treatments</h5>
                    <img src="img/Group 15183.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <img src="img/Frame 2.png" alt="" class="mb-3">
        <div class="card p-3">
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
                2       
            </div>
            
            
        </div>
        <div class="tab-pane fade" id="tab_3" role="tabpanel">
            <div class="card-body">
                3       
                </div>
        </div>
        <div class="tab-pane fade" id="tab_4" role="tabpanel">
            <div class="card-body">
                4       
                </div>
        </div>
        <div class="tab-pane fade" id="tab_5" role="tabpanel">
            <div class="card-body">
                5       
                </div>
        </div>
        
    </div>
    
</div>
@stop
@section('script')
<script src="{{ asset('js/dashboard.js') }}"></script>
<script>
    var ClientsGraph = {!! json_encode($client_graph) !!};
</script>
@endsection