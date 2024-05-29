@extends('layouts/sidebar')
@section('content')
    <!-- Page content-->
    <!-- <main> -->
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-5">Add Location</h4>
                <h5 class="d-grey mb-0">Details</h5>
            </div>
            <form id="create_location" name="create_location" class="form" method="post">
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
                            <input type="text" class="form-control" id="street_address" name="street_address">
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
                            <input type="text" class="form-control" id="latitude" name="latitude">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Longitudes</label>
                            <input type="text" class="form-control" id="longitude" name="longitude">
                            </div>
                    </div>
                </div>

                <div class="map mb-5">
                    <img src="{{ asset('img/demo-map.jpg') }}" alt="">
                </div>

                <h5 class="small-title mt-3">Opening Hours</h5>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-relax align-middle table-hover">
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Sunday" name="days[sunday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="sunday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Sunday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                        <input type="hidden" name="days[sunday][check_days]" value="Sunday">
                                                        <select class="form-select form-control" id="start_time" name="days[sunday][start_time]">
                                                            <option value="12am">12am</option>
                                                            <option value="30am">12:30am</option>
                                                            <option value="1am">1am</option>
                                                            <option value="30am">1:30am</option>
                                                            <option value="2am">2am</option>
                                                            <option value="2:30am">2:30am</option>
                                                            <option value="3am">3am</option>
                                                            <option value="3:30am">3:30am</option>
                                                            <option value="4am">4am</option>
                                                            <option value="4:30am">4:30am</option>
                                                            <option value="5am">5am</option>
                                                            <option value="5:30am">5:30am</option>
                                                            <option value="6am">6am</option>
                                                            <option value="6:30am">6:30am</option>
                                                            <option value="7am">7am</option>
                                                            <option value="7:30am">7:30am</option>
                                                            <option selected="selected" value="8am">8am</option>
                                                            <option value="8:30am">8:30am</option>
                                                            <option value="9am">9am</option>
                                                            <option value="9:30am">9:30am</option>
                                                            <option value="10am">10am</option>
                                                            <option value="10:30am">10:30am</option>
                                                            <option value="11am">11am</option>
                                                            <option value="11:30am">11:30am</option>
                                                            <option value="12pm">12pm</option>
                                                            <option value="12:30pm">12:30pm</option>
                                                            <option value="1pm">1pm</option>
                                                            <option value="1:30pm">1:30pm</option>
                                                            <option value="2pm">2pm</option>
                                                            <option value="2:30pm">2:30pm</option>
                                                            <option value="3pm">3pm</option>
                                                            <option value="3:30pm">3:30pm</option>
                                                            <option value="4pm">4pm</option>
                                                            <option value="4:30pm">4:30pm</option>
                                                            <option value="5pm">5pm</option>
                                                            <option value="5:30pm">5:30pm</option>
                                                            <option value="6pm">6pm</option>
                                                            <option value="6:30pm">6:30pm</option>
                                                            <option value="7pm">7pm</option>
                                                            <option value="7:30pm">7:30pm</option>
                                                            <option value="8pm">8pm</option>
                                                            <option value="8:30pm">8:30pm</option>
                                                            <option value="9pm">9pm</option>
                                                            <option value="9:30pm">9:30pm</option>
                                                            <option value="10pm">10pm</option>
                                                            <option value="10:30pm">10:30pm</option>
                                                            <option value="11pm">11pm</option>
                                                            <option value="11:30pm">11:30pm</option>
                                                        </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                        <select class="form-select form-control" name="days[sunday][to_time]">
                                                            <option value="1am">1am</option>
                                                            <option value="30am">1:30am</option>
                                                            <option value="2am">2am</option>
                                                            <option value="2:30am">2:30am</option>
                                                            <option value="3am">3am</option>
                                                            <option value="3:30am">3:30am</option>
                                                            <option value="4am">4am</option>
                                                            <option value="4:30am">4:30am</option>
                                                            <option value="5am">5am</option>
                                                            <option value="5:30am">5:30am</option>
                                                            <option value="6am">6am</option>
                                                            <option value="6:30am">6:30am</option>
                                                            <option value="7am">7am</option>
                                                            <option value="7:30am">7:30am</option>
                                                            <option selected="selected" value="8am">8am</option>
                                                            <option value="8:30am">8:30am</option>
                                                            <option value="9am">9am</option>
                                                            <option value="9:30am">9:30am</option>
                                                            <option value="10am">10am</option>
                                                            <option value="10:30am">10:30am</option>
                                                            <option value="11am">11am</option>
                                                            <option value="11:30am">11:30am</option>
                                                            <option value="12pm">12pm</option>
                                                            <option value="12:30pm">12:30pm</option>
                                                            <option value="1pm">1pm</option>
                                                            <option value="1:30pm">1:30pm</option>
                                                            <option value="2pm">2pm</option>
                                                            <option value="2:30pm">2:30pm</option>
                                                            <option value="3pm">3pm</option>
                                                            <option value="3:30pm">3:30pm</option>
                                                            <option value="4pm">4pm</option>
                                                            <option value="4:30pm">4:30pm</option>
                                                            <option value="5pm">5pm</option>
                                                            <option value="5:30pm">5:30pm</option>
                                                            <option value="6pm" selected="selected">6pm</option>
                                                            <option value="6:30pm">6:30pm</option>
                                                            <option value="7pm">7pm</option>
                                                            <option value="7:30pm">7:30pm</option>
                                                            <option value="8pm">8pm</option>
                                                            <option value="8:30pm">8:30pm</option>
                                                            <option value="9pm">9pm</option>
                                                            <option value="9:30pm">9:30pm</option>
                                                            <option value="10pm">10pm</option>
                                                            <option value="10:30pm">10:30pm</option>
                                                            <option value="11pm">11pm</option>
                                                            <option value="11:30pm">11:30pm</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[sunday][to_time]">
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Monday" name="days[monday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Monday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Monday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                        <input type="hidden" name="days[monday][check_days]" value="Monday">
                                                        <select class="form-select form-control" id="start_time" name="days[monday][start_time]">
                                                            <option value="12am">12am</option>
                                                            <option value="30am">12:30am</option>
                                                            <option value="1am">1am</option>
                                                            <option value="30am">1:30am</option>
                                                            <option value="2am">2am</option>
                                                            <option value="2:30am">2:30am</option>
                                                            <option value="3am">3am</option>
                                                            <option value="3:30am">3:30am</option>
                                                            <option value="4am">4am</option>
                                                            <option value="4:30am">4:30am</option>
                                                            <option value="5am">5am</option>
                                                            <option value="5:30am">5:30am</option>
                                                            <option value="6am">6am</option>
                                                            <option value="6:30am">6:30am</option>
                                                            <option value="7am">7am</option>
                                                            <option value="7:30am">7:30am</option>
                                                            <option selected="selected" value="8am">8am</option>
                                                            <option value="8:30am">8:30am</option>
                                                            <option value="9am">9am</option>
                                                            <option value="9:30am">9:30am</option>
                                                            <option value="10am">10am</option>
                                                            <option value="10:30am">10:30am</option>
                                                            <option value="11am">11am</option>
                                                            <option value="11:30am">11:30am</option>
                                                            <option value="12pm">12pm</option>
                                                            <option value="12:30pm">12:30pm</option>
                                                            <option value="1pm">1pm</option>
                                                            <option value="1:30pm">1:30pm</option>
                                                            <option value="2pm">2pm</option>
                                                            <option value="2:30pm">2:30pm</option>
                                                            <option value="3pm">3pm</option>
                                                            <option value="3:30pm">3:30pm</option>
                                                            <option value="4pm">4pm</option>
                                                            <option value="4:30pm">4:30pm</option>
                                                            <option value="5pm">5pm</option>
                                                            <option value="5:30pm">5:30pm</option>
                                                            <option value="6pm">6pm</option>
                                                            <option value="6:30pm">6:30pm</option>
                                                            <option value="7pm">7pm</option>
                                                            <option value="7:30pm">7:30pm</option>
                                                            <option value="8pm">8pm</option>
                                                            <option value="8:30pm">8:30pm</option>
                                                            <option value="9pm">9pm</option>
                                                            <option value="9:30pm">9:30pm</option>
                                                            <option value="10pm">10pm</option>
                                                            <option value="10:30pm">10:30pm</option>
                                                            <option value="11pm">11pm</option>
                                                            <option value="11:30pm">11:30pm</option>
                                                        </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[monday][to_time]">
                                                        <option value="1am">1am</option>
                                                            <option value="30am">1:30am</option>
                                                            <option value="2am">2am</option>
                                                            <option value="2:30am">2:30am</option>
                                                            <option value="3am">3am</option>
                                                            <option value="3:30am">3:30am</option>
                                                            <option value="4am">4am</option>
                                                            <option value="4:30am">4:30am</option>
                                                            <option value="5am">5am</option>
                                                            <option value="5:30am">5:30am</option>
                                                            <option value="6am">6am</option>
                                                            <option value="6:30am">6:30am</option>
                                                            <option value="7am">7am</option>
                                                            <option value="7:30am">7:30am</option>
                                                            <option selected="selected" value="8am">8am</option>
                                                            <option value="8:30am">8:30am</option>
                                                            <option value="9am">9am</option>
                                                            <option value="9:30am">9:30am</option>
                                                            <option value="10am">10am</option>
                                                            <option value="10:30am">10:30am</option>
                                                            <option value="11am">11am</option>
                                                            <option value="11:30am">11:30am</option>
                                                            <option value="12pm">12pm</option>
                                                            <option value="12:30pm">12:30pm</option>
                                                            <option value="1pm">1pm</option>
                                                            <option value="1:30pm">1:30pm</option>
                                                            <option value="2pm">2pm</option>
                                                            <option value="2:30pm">2:30pm</option>
                                                            <option value="3pm">3pm</option>
                                                            <option value="3:30pm">3:30pm</option>
                                                            <option value="4pm">4pm</option>
                                                            <option value="4:30pm">4:30pm</option>
                                                            <option value="5pm">5pm</option>
                                                            <option value="5:30pm">5:30pm</option>
                                                            <option value="6pm" selected="selected">6pm</option>
                                                            <option value="6:30pm">6:30pm</option>
                                                            <option value="7pm">7pm</option>
                                                            <option value="7:30pm">7:30pm</option>
                                                            <option value="8pm">8pm</option>
                                                            <option value="8:30pm">8:30pm</option>
                                                            <option value="9pm">9pm</option>
                                                            <option value="9:30pm">9:30pm</option>
                                                            <option value="10pm">10pm</option>
                                                            <option value="10:30pm">10:30pm</option>
                                                            <option value="11pm">11pm</option>
                                                            <option value="11:30pm">11:30pm</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[monday][check_days]" value="Monday">
                                        <select class="form-select form-control" id="start_time" name="days[monday][start_time]">
                                        <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                        <!-- <td class="text-center to_text">To</td> -->
                                        <!-- <td class="to_dates">
                                        <select class="form-select form-control" name="days[monday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Tuesday" name="days[tuesday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Tuesday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Tuesday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                    <input type="hidden" name="days[tuesday][check_days]" value="Tuesday">
                                                    <select class="form-select form-control" id="start_time" name="days[tuesday][start_time]">
                                                        <option value="12am">12am</option>
                                                        <option value="30am">12:30am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[tuesday][to_time]">
                                                        <option value="1am">1am</option>
                                                            <option value="30am">1:30am</option>
                                                            <option value="2am">2am</option>
                                                            <option value="2:30am">2:30am</option>
                                                            <option value="3am">3am</option>
                                                            <option value="3:30am">3:30am</option>
                                                            <option value="4am">4am</option>
                                                            <option value="4:30am">4:30am</option>
                                                            <option value="5am">5am</option>
                                                            <option value="5:30am">5:30am</option>
                                                            <option value="6am">6am</option>
                                                            <option value="6:30am">6:30am</option>
                                                            <option value="7am">7am</option>
                                                            <option value="7:30am">7:30am</option>
                                                            <option selected="selected" value="8am">8am</option>
                                                            <option value="8:30am">8:30am</option>
                                                            <option value="9am">9am</option>
                                                            <option value="9:30am">9:30am</option>
                                                            <option value="10am">10am</option>
                                                            <option value="10:30am">10:30am</option>
                                                            <option value="11am">11am</option>
                                                            <option value="11:30am">11:30am</option>
                                                            <option value="12pm">12pm</option>
                                                            <option value="12:30pm">12:30pm</option>
                                                            <option value="1pm">1pm</option>
                                                            <option value="1:30pm">1:30pm</option>
                                                            <option value="2pm">2pm</option>
                                                            <option value="2:30pm">2:30pm</option>
                                                            <option value="3pm">3pm</option>
                                                            <option value="3:30pm">3:30pm</option>
                                                            <option value="4pm">4pm</option>
                                                            <option value="4:30pm">4:30pm</option>
                                                            <option value="5pm">5pm</option>
                                                            <option value="5:30pm">5:30pm</option>
                                                            <option value="6pm" selected="selected">6pm</option>
                                                            <option value="6:30pm">6:30pm</option>
                                                            <option value="7pm">7pm</option>
                                                            <option value="7:30pm">7:30pm</option>
                                                            <option value="8pm">8pm</option>
                                                            <option value="8:30pm">8:30pm</option>
                                                            <option value="9pm">9pm</option>
                                                            <option value="9:30pm">9:30pm</option>
                                                            <option value="10pm">10pm</option>
                                                            <option value="10:30pm">10:30pm</option>
                                                            <option value="11pm">11pm</option>
                                                            <option value="11:30pm">11:30pm</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[tuesday][check_days]" value="Tuesday">
                                        <select class="form-select form-control" id="start_time" name="days[tuesday][start_time]">
                                            <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[tuesday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Wednesday" name="days[wednesday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Wednesday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Wednesday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                    <input type="hidden" name="days[wednesday][check_days]" value="Wednesday">
                                                    <select class="form-select form-control" id="start_time" name="days[wednesday][start_time]">
                                                        <option value="12am">12am</option>
                                                        <option value="30am">12:30am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[wednesday][to_time]">
                                                    <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm" selected="selected">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[wednesday][check_days]" value="Wednesday">
                                        <select class="form-select form-control" id="start_time" name="days[wednesday][start_time]">
                                            <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[wednesday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Thursday" name="days[thursday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Thursday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Thursday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                    <input type="hidden" name="days[thursday][check_days]" value="Thursday">
                                                    <select class="form-select form-control" id="start_time" name="days[thursday][start_time]">
                                                        <option value="12am">12am</option>
                                                        <option value="30am">12:30am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[thursday][to_time]">
                                                    <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm" selected="selected">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[thursday][check_days]" value="Thursday">
                                        <select class="form-select form-control" id="start_time" name="days[thursday][start_time]">
                                            <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[thursday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Friday" name="days[friday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Friday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Friday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                    <input type="hidden" name="days[friday][check_days]" value="Friday">
                                                    <select class="form-select form-control" id="start_time" name="days[friday][start_time]">
                                                        <option value="12am">12am</option>
                                                        <option value="30am">12:30am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[friday][to_time]">
                                                    <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm" selected="selected">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[friday][check_days]" value="Friday">
                                        <select class="form-select form-control" id="start_time" name="days[friday][start_time]">
                                            <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[friday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="cst-check"><input type="checkbox" class="checkbox" value="Saturday" name="days[saturday][check_status]" checked><span class="checkmark"></span></label>
                                            <!-- <input name="days[0][days_val]" type="hidden" value="Saturday"> -->
                                        </td>
                                        <td>Open</td>
                                        <td>Saturday</td>
                                        <td>
                                            <div class="show-timing">
                                                <div class="show-inner">
                                                    <div class="datble-drop">
                                                    <input type="hidden" name="days[saturday][check_days]" value="Saturday">
                                                    <select class="form-select form-control" id="start_time" name="days[saturday][start_time]">
                                                        <option value="12am">12am</option>
                                                        <option value="30am">12:30am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                    <div class="txt-to">To</div>
                                                    <div class="datble-drop">
                                                    <select class="form-select form-control" name="days[saturday][to_time]">
                                                    <option value="1am">1am</option>
                                                        <option value="30am">1:30am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="2:30am">2:30am</option>
                                                        <option value="3am">3am</option>
                                                        <option value="3:30am">3:30am</option>
                                                        <option value="4am">4am</option>
                                                        <option value="4:30am">4:30am</option>
                                                        <option value="5am">5am</option>
                                                        <option value="5:30am">5:30am</option>
                                                        <option value="6am">6am</option>
                                                        <option value="6:30am">6:30am</option>
                                                        <option value="7am">7am</option>
                                                        <option value="7:30am">7:30am</option>
                                                        <option selected="selected" value="8am">8am</option>
                                                        <option value="8:30am">8:30am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="9:30am">9:30am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="10:30am">10:30am</option>
                                                        <option value="11am">11am</option>
                                                        <option value="11:30am">11:30am</option>
                                                        <option value="12pm">12pm</option>
                                                        <option value="12:30pm">12:30pm</option>
                                                        <option value="1pm">1pm</option>
                                                        <option value="1:30pm">1:30pm</option>
                                                        <option value="2pm">2pm</option>
                                                        <option value="2:30pm">2:30pm</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="3:30pm">3:30pm</option>
                                                        <option value="4pm">4pm</option>
                                                        <option value="4:30pm">4:30pm</option>
                                                        <option value="5pm">5pm</option>
                                                        <option value="5:30pm">5:30pm</option>
                                                        <option value="6pm" selected="selected">6pm</option>
                                                        <option value="6:30pm">6:30pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="7:30pm">7:30pm</option>
                                                        <option value="8pm">8pm</option>
                                                        <option value="8:30pm">8:30pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="9:30pm">9:30pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="10:30pm">10:30pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="11:30pm">11:30pm</option>
                                                    </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                        <!-- <td class="from_dates">
                                        <input type="hidden" name="days[saturday][check_days]" value="Saturday">
                                        <select class="form-select form-control" id="start_time" name="days[saturday][start_time]">
                                            <option value="12am">12am</option>
                                            <option value="30am">12:30am</option>
                                            <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td>
                                        <td class="text-center to_text">To</td>
                                        <td class="to_dates">
                                        <select class="form-select form-control" name="days[saturday][to_time]">
                                        <option value="1am">1am</option>
                                            <option value="30am">1:30am</option>
                                            <option value="2am">2am</option>
                                            <option value="2:30am">2:30am</option>
                                            <option value="3am">3am</option>
                                            <option value="3:30am">3:30am</option>
                                            <option value="4am">4am</option>
                                            <option value="4:30am">4:30am</option>
                                            <option value="5am">5am</option>
                                            <option value="5:30am">5:30am</option>
                                            <option value="6am">6am</option>
                                            <option value="6:30am">6:30am</option>
                                            <option value="7am">7am</option>
                                            <option value="7:30am">7:30am</option>
                                            <option selected="selected" value="8am">8am</option>
                                            <option value="8:30am">8:30am</option>
                                            <option value="9am">9am</option>
                                            <option value="9:30am">9:30am</option>
                                            <option value="10am">10am</option>
                                            <option value="10:30am">10:30am</option>
                                            <option value="11am">11am</option>
                                            <option value="11:30am">11:30am</option>
                                            <option value="12pm">12pm</option>
                                            <option value="12:30pm">12:30pm</option>
                                            <option value="1pm">1pm</option>
                                            <option value="1:30pm">1:30pm</option>
                                            <option value="2pm">2pm</option>
                                            <option value="2:30pm">2:30pm</option>
                                            <option value="3pm">3pm</option>
                                            <option value="3:30pm">3:30pm</option>
                                            <option value="4pm">4pm</option>
                                            <option value="4:30pm">4:30pm</option>
                                            <option value="5pm">5pm</option>
                                            <option value="5:30pm">5:30pm</option>
                                            <option value="6pm" selected="selected">6pm</option>
                                            <option value="6:30pm">6:30pm</option>
                                            <option value="7pm">7pm</option>
                                            <option value="7:30pm">7:30pm</option>
                                            <option value="8pm">8pm</option>
                                            <option value="8:30pm">8:30pm</option>
                                            <option value="9pm">9pm</option>
                                            <option value="9:30pm">9:30pm</option>
                                            <option value="10pm">10pm</option>
                                            <option value="10:30pm">10:30pm</option>
                                            <option value="11pm">11pm</option>
                                            <option value="11:30pm">11:30pm</option>
                                        </select>
                                        </td> -->
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                
                <h5 class="small-title mt-3">Surcharge</h5>
                <div class="container py-4">
                    <div class="row">
                        <div class="col-md-12 form_sec_outer_task">
                        <div class="col-md-12 p-0">
                            <div class="col-md-12 form_field_outer p-0">
                            <div class="row form_field_outer_row">
                                <div class="form-group col-md-6">
                                <input type="text" class="form-control w_90" name="surcharge_type[]" id="type" placeholder="Text" />
                                </div>
                                <div class="form-group col-md-4">
                                <input type="text" class="form-control w_90" name="surcharge_percentage[]" id="percentage" placeholder="Percentage" />
                                </div>
                                <div class="form-group col-md-2 add_del_btn_outer">
                                <span class="btn_round add_node_btn_frm_field" title="Copy or clone this row">
                                    <i class="fas fa-copy"></i>
                                </span>

                                <button class="btn_round remove_node_btn_frm_field" disabled>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-lg-end mt-4">
                    <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("locations") }}'">Discard</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
            </form>
        </div>
<!-- </main> -->
@endsection
@section('script')
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR652zv0sbcR8AkNDA7PbQ3y33_yrzW0Q&libraries=places&callback=initAutocomplete" async></script> -->
<script>

    // let autocomplete;

    // /* ------------------------- Initialize Autocomplete ------------------------ */
    // function initAutocomplete() {
    //     const input = document.getElementById("placeInput");
    //     const options = {
    //         componentRestrictions: { country: "IN" }
    //     }
    //     autocomplete = new google.maps.places.Autocomplete(input, options);
    //     autocomplete.addListener("place_changed", onPlaceChange)
    // }

    /* --------------------------- Handle Place Change -------------------------- */
    // function onPlaceChange() {
    //     const place = autocomplete.getPlace();
    //     console.log(place.formatted_address)
    //     console.log(place.geometry.location.lat())
    //     console.log(place.geometry.location.lng())
    // }
    $(document).ready(function() {
        $("body").on("click", ".add_node_btn_frm_field", function (e) {
            var index = $(this).closest(".form_field_outer").find(".form_field_outer_row").length + 1;
            var cloned_el = $(this).closest(".form_field_outer").find(".form_field_outer_row").first().clone(true);

            // Clear input values in the cloned element
            cloned_el.find('input[type="text"]').val('');

            $(this).closest(".form_field_outer").append(cloned_el);
            
            // Enable all remove buttons
            $(this).closest(".form_field_outer").find(".remove_node_btn_frm_field").prop("disabled", false);
            
            // Disable the remove button for the first row
            $(this).closest(".form_field_outer").find(".remove_node_btn_frm_field").first().prop("disabled", true);

            // Change IDs of cloned elements
            cloned_el.find("input[type='text']").attr("id", "mobileb_no_" + index);
            cloned_el.find("select").attr("id", "no_type_" + index);

            console.log(cloned_el);
            //count++;
        });


        //===== delete the form fieed row
        $("body").on("click", ".remove_node_btn_frm_field", function () {
            $(this).closest(".form_field_outer_row").remove();
            console.log("success");
        });
        
        
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
                    email: true
                },
            }
        });
        $('.checkbox').click(function() {
            
            if(this.checked) {
                $(this).parent().parent().parent().find('.show-timing').show();
                
            }
            else
            {
                
                $(this).parent().parent().parent().find('.show-timing').hide();
                
            }
            $('#textbox1').val(this.checked);        
        });
    });
    $(document).on('submit','#create_location',function(e){
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
