@extends('layouts/sidebar')
@section('content')
<div class="app-header mb-4">
    <h4 class="small-title mb-0">Dashboard</h4>

    <div class="right w-25">
        <div class="row form-group mb-0">
            <div class="col-lg-7">
                <!-- <input type="date" class="form-control"> -->
                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
            <div class="col-lg-5">
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
        
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Sales</h5>
            <b class="d-grey">${{ $made_so_far }}</b><br>
            Made so far<br>
            <b class="d-grey">${{ $expected }}</b><br>
            Expected
            <progress id="file" max="{{ $made_so_far + $expected }}" value="{{ $made_so_far }}">{{ $made_so_far }}</progress>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Appointments</h5>
            <img src="img/Group 15176.png" alt="">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Clients</h5>
            <img src="img/Group 15177.png" alt="">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-3">
            <h5 class="bright-gray">Total Enquiries</h5>
            <img src="img/Group 15178.png" alt="">
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
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {
    $(function() {

        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });
});
</script>
@endsection