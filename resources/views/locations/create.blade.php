@extends('layouts/sidebar')
@section('content')
    <!-- Page content-->
    <main>
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-5">Add Location</h4>
                <h5 class="d-grey mb-0">Details</h5>
            </div>
            <form id="create_location" name="create_location" class="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Location Name </label>
                            <input type="text" class="form-control" id="location_name" name="location_name">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Phone </label>
                            <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Email  Address</label>
                            <input type="text" class="form-control" id="email_address" name="email_address">
                            </div>
                    </div>
                </div>
            </div>
            <div class="card-head">
                <h5 class="d-grey mb-0">Address Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" id="placeInput" name="street_address">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="suburb" name="suburb">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">State/Region</label>
                            <input type="text" class="form-control" id="state" name="state">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Post Code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Latitudes</label>
                            <input type="text" class="form-control" id="latitudes" name="latitudes">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Longitudes</label>
                            <input type="text" class="form-control" id="longitudes" name="longitudes">
                            </div>
                    </div>
                </div>

                <div class="map">
                    <img src="{{ asset('img/demo-map.jpg') }}" alt="">
                </div>

                <h5 class="small-title mb-4 mt-3">Opening Hours</h5>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-relax align-middle table-hover">
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Sunday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Monday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Tuesday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Wednesday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Thursday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Friday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-checks"><input type="checkbox" value=""><span class="checkmark"></span></label>
                                        </td>
                                        <td>Open</td>
                                        <td>Saturday</td>
                                        <td>
                                        
                                        <select class="form-select form-control">
                                            <option value="0">12am</option>
                                            <option value="30">12:30am</option>
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option selected="selected" value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center">To</td>
                                        <td>
                                        <select class="form-select form-control">
                                            <option value="60">1am</option>
                                            <option value="90">1:30am</option>
                                            <option value="120">2am</option>
                                            <option value="150">2:30am</option>
                                            <option value="180">3am</option>
                                            <option value="210">3:30am</option>
                                            <option value="240">4am</option>
                                            <option value="270">4:30am</option>
                                            <option value="300">5am</option>
                                            <option value="330">5:30am</option>
                                            <option value="360">6am</option>
                                            <option value="390">6:30am</option>
                                            <option value="420">7am</option>
                                            <option value="450">7:30am</option>
                                            <option value="480">8am</option>
                                            <option value="510">8:30am</option>
                                            <option value="540">9am</option>
                                            <option value="570">9:30am</option>
                                            <option value="600">10am</option>
                                            <option value="630">10:30am</option>
                                            <option value="660">11am</option>
                                            <option value="690">11:30am</option>
                                            <option value="720">12pm</option>
                                            <option value="750">12:30pm</option>
                                            <option value="780">1pm</option>
                                            <option value="810">1:30pm</option>
                                            <option value="840">2pm</option>
                                            <option value="870">2:30pm</option>
                                            <option value="900">3pm</option>
                                            <option value="930">3:30pm</option>
                                            <option value="960">4pm</option>
                                            <option value="990">4:30pm</option>
                                            <option value="1020">5pm</option>
                                            <option value="1050">5:30pm</option>
                                            <option selected="selected" value="1080">6pm</option>
                                            <option value="1110">6:30pm</option>
                                            <option value="1140">7pm</option>
                                            <option value="1170">7:30pm</option>
                                            <option value="1200">8pm</option>
                                            <option value="1230">8:30pm</option>
                                            <option value="1260">9pm</option>
                                            <option value="1290">9:30pm</option>
                                            <option value="1320">10pm</option>
                                            <option value="1350">10:30pm</option>
                                            <option value="1380">11pm</option>
                                            <option value="1410">11:30pm</option>
                                    </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                <div class="col-lg-12 text-lg-end mt-4">
                    <button type="button" class="btn btn-light me-2">Discard</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
            </form>
        </div>
</main>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR652zv0sbcR8AkNDA7PbQ3y33_yrzW0Q&libraries=places&callback=initAutocomplete" async></script>
<script>

    let autocomplete;

    /* ------------------------- Initialize Autocomplete ------------------------ */
    function initAutocomplete() {
        const input = document.getElementById("placeInput");
        const options = {
            componentRestrictions: { country: "IN" }
        }
        autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener("place_changed", onPlaceChange)
    }

    /* --------------------------- Handle Place Change -------------------------- */
    function onPlaceChange() {
        const place = autocomplete.getPlace();
        console.log(place.formatted_address)
        console.log(place.geometry.location.lat())
        console.log(place.geometry.location.lng())
    }
    $(document).ready(function() {
		$("#create_location").validate({
            rules: {
                location_name: {
                    required: true,
                },
                phone:{
                    required: true,
                },
                email_address:{
                    required: true,
                },
            }
        });
    });
    $(document).on('submit','#create_location',function(e){debugger;
		e.preventDefault();
		var valid= $("#create_location").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_location').serialize() ;
			submitCreateLocationForm(data);
		}
	});
    function submitCreateLocationForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('locations.store')}}",
			type: "post",
			data: data,
			success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Location!",
						text: "Your Location created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('locations')}}"//'/player_detail?username=' + name;
                    });
					
				} else {
					debugger;
					Swal.fire({
						title: "Error!",
						text: response.message,
						type: "error",
					});
				}
			},
		});
	}
</script>
@endsection
