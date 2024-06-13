<div class="modal fade" id="edit_Working_hours" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit working hours</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invo-notice mb-4">
                    <input type="hidden" id="staff_id">
                    <input type="hidden" id="current_date">
                    <div class="inv-left staff_name"></div>
                    <div class="inv-right d-grey current_date"></div>
                </div>
                <ul class="nav nav-pills nav-fill nav-group mb-3">
                    <li class="nav-item">
                        <a class="nav-link active working_hours_status" data-bs-toggle="tab" href="#tab_1" data-status="1">Working
                            <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link working_hours_status" data-bs-toggle="tab" href="#tab_2" data-status="0">Not Working
                            <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link working_hours_status" data-bs-toggle="tab" href="#tab_3" data-status="2">Leave <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link working_hours_status" data-bs-toggle="tab" href="#tab_4" data-status="3"> Partial Leave  <i class="ico-tick ms-1"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                        <!-- toggle -->
                        <div class="cst-toggle">
                            <div class="accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#working_hour" aria-expanded="false"> Working Hours </button>
                                <div id="working_hour" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control" id="working_start_time">
                                                        <option value="05:00">05:00 AM</option>
                                                        <option value="05:15">05:15 AM</option>
                                                        <option value="05:30">05:30 AM</option>
                                                        <option value="05:45">05:45 AM</option>
                                                        <option value="06:00">06:00 AM</option>
                                                        <option value="06:15">06:15 AM</option>
                                                        <option value="06:30">06:30 AM</option>
                                                        <option value="06:45">06:45 AM</option>
                                                        <option value="07:00">07:00 AM</option>
                                                        <option value="07:15">07:15 AM</option>
                                                        <option value="07:30">07:30 AM</option>
                                                        <option value="07:45">07:45 AM</option>
                                                        <option value="08:00">08:00 AM</option>
                                                        <option value="08:15">08:15 AM</option>
                                                        <option value="08:30">08:30 AM</option>
                                                        <option value="08:45">08:45 AM</option>
                                                        <option value="09:00">09:00 AM</option>
                                                        <option value="09:15">09:15 AM</option>
                                                        <option value="09:30">09:30 AM</option>
                                                        <option value="09:45">09:45 AM</option>
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">End Time</label>
                                                    <select class="form-select form-control" id="working_end_time">
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                        <option value="10:00">10:00 PM</option>
                                                        <option value="10:15">10:15 PM</option>
                                                        <option value="10:30">10:30 PM</option>
                                                        <option value="10:45">10:45 PM</option>
                                                        <option value="11:00">11:00 PM</option>
                                                        <option value="11:15">11:15 PM</option>
                                                        <option value="11:30">11:30 PM</option>
                                                        <option value="11:45">11:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#lunch" aria-expanded="false"> Lunch </button>

                                <div id="lunch" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control" id="lunch_start_time">
                                                        <option value="06:00">06:00 AM</option>
                                                        <option value="06:15">06:15 AM</option>
                                                        <option value="06:30">06:30 AM</option>
                                                        <option value="06:45">06:45 AM</option>
                                                        <option value="07:00">07:00 AM</option>
                                                        <option value="07:15">07:15 AM</option>
                                                        <option value="07:30">07:30 AM</option>
                                                        <option value="07:45">07:45 AM</option>
                                                        <option value="08:00">08:00 AM</option>
                                                        <option value="08:15">08:15 AM</option>
                                                        <option value="08:30">08:30 AM</option>
                                                        <option value="08:45">08:45 AM</option>
                                                        <option value="09:00">09:00 AM</option>
                                                        <option value="09:15">09:15 AM</option>
                                                        <option value="09:30">09:30 AM</option>
                                                        <option value="09:45">09:45 AM</option>
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                        <option value="10:00">10:00 PM</option>
                                                        <option value="10:15">10:15 PM</option>
                                                        <option value="10:30">10:30 PM</option>
                                                        <option value="10:45">10:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Duration(minutes)</label>
                                                    <input type="number" id="lunch_duration_minutes" class="form-select form-control" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#break_time" aria-expanded="false">Break Time </button>

                                <div id="break_time" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control" id="break_start_time">
                                                        <option value="06:00">06:00 AM</option>
                                                        <option value="06:15">06:15 AM</option>
                                                        <option value="06:30">06:30 AM</option>
                                                        <option value="06:45">06:45 AM</option>
                                                        <option value="07:00">07:00 AM</option>
                                                        <option value="07:15">07:15 AM</option>
                                                        <option value="07:30">07:30 AM</option>
                                                        <option value="07:45">07:45 AM</option>
                                                        <option value="08:00">08:00 AM</option>
                                                        <option value="08:15">08:15 AM</option>
                                                        <option value="08:30">08:30 AM</option>
                                                        <option value="08:45">08:45 AM</option>
                                                        <option value="09:00">09:00 AM</option>
                                                        <option value="09:15">09:15 AM</option>
                                                        <option value="09:30">09:30 AM</option>
                                                        <option value="09:45">09:45 AM</option>
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                        <option value="10:00">10:00 PM</option>
                                                        <option value="10:15">10:15 PM</option>
                                                        <option value="10:30">10:30 PM</option>
                                                        <option value="10:45">10:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Duration(minutes)</label>
                                                    <input type="number" id="break_duration" class="form-select form-control" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#custom_time" aria-expanded="false">Custom Time</button>

                                <div id="custom_time" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control" id="custom_start_time">
                                                        <option value="06:00">06:00 AM</option>
                                                        <option value="06:15">06:15 AM</option>
                                                        <option value="06:30">06:30 AM</option>
                                                        <option value="06:45">06:45 AM</option>
                                                        <option value="07:00">07:00 AM</option>
                                                        <option value="07:15">07:15 AM</option>
                                                        <option value="07:30">07:30 AM</option>
                                                        <option value="07:45">07:45 AM</option>
                                                        <option value="08:00">08:00 AM</option>
                                                        <option value="08:15">08:15 AM</option>
                                                        <option value="08:30">08:30 AM</option>
                                                        <option value="08:45">08:45 AM</option>
                                                        <option value="09:00">09:00 AM</option>
                                                        <option value="09:15">09:15 AM</option>
                                                        <option value="09:30">09:30 AM</option>
                                                        <option value="09:45">09:45 AM</option>
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                        <option value="10:00">10:00 PM</option>
                                                        <option value="10:15">10:15 PM</option>
                                                        <option value="10:30">10:30 PM</option>
                                                        <option value="10:45">10:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">End Time </label>
                                                    <select class="form-select form-control" id="custom_end_time">
                                                        <option value="08:00">08:00 AM</option>
                                                        <option value="08:15">08:15 AM</option>
                                                        <option value="08:30">08:30 AM</option>
                                                        <option value="08:45">08:45 AM</option>
                                                        <option value="09:00">09:00 AM</option>
                                                        <option value="09:15">09:15 AM</option>
                                                        <option value="09:30">09:30 AM</option>
                                                        <option value="09:45">09:45 AM</option>
                                                        <option value="10:00">10:00 AM</option>
                                                        <option value="10:15">10:15 AM</option>
                                                        <option value="10:30">10:30 AM</option>
                                                        <option value="10:45">10:45 AM</option>
                                                        <option value="11:00">11:00 AM</option>
                                                        <option value="11:15">11:15 AM</option>
                                                        <option value="11:30">11:30 AM</option>
                                                        <option value="11:45">11:45 AM</option>
                                                        <option value="12:00">12:00 PM</option>
                                                        <option value="12:15">12:15 PM</option>
                                                        <option value="12:30">12:30 PM</option>
                                                        <option value="12:45">12:45 PM</option>
                                                        <option value="1:00">1:00 PM</option>
                                                        <option value="1:15">1:15 PM</option>
                                                        <option value="1:30">1:30 PM</option>
                                                        <option value="1:45">1:45 PM</option>
                                                        <option value="2:00">2:00 PM</option>
                                                        <option value="2:15">2:15 PM</option>
                                                        <option value="2:30">2:30 PM</option>
                                                        <option value="2:45">2:45 PM</option>
                                                        <option value="3:00">3:00 PM</option>
                                                        <option value="3:15">3:15 PM</option>
                                                        <option value="3:30">3:30 PM</option>
                                                        <option value="3:45">3:45 PM</option>
                                                        <option value="4:00">4:00 PM</option>
                                                        <option value="4:15">4:15 PM</option>
                                                        <option value="4:30">4:30 PM</option>
                                                        <option value="4:45">4:45 PM</option>
                                                        <option value="5:00">5:00 PM</option>
                                                        <option value="5:15">5:15 PM</option>
                                                        <option value="5:30">5:30 PM</option>
                                                        <option value="5:45">5:45 PM</option>
                                                        <option value="6:00">6:00 PM</option>
                                                        <option value="6:15">6:15 PM</option>
                                                        <option value="6:30">6:30 PM</option>
                                                        <option value="6:45">6:45 PM</option>
                                                        <option value="7:00">7:00 PM</option>
                                                        <option value="7:15">7:15 PM</option>
                                                        <option value="7:30">7:30 PM</option>
                                                        <option value="7:45">7:45 PM</option>
                                                        <option value="8:00">8:00 PM</option>
                                                        <option value="8:15">8:15 PM</option>
                                                        <option value="8:30">8:30 PM</option>
                                                        <option value="8:45">8:45 PM</option>
                                                        <option value="9:00">9:00 PM</option>
                                                        <option value="9:15">9:15 PM</option>
                                                        <option value="9:30">9:30 PM</option>
                                                        <option value="9:45">9:45 PM</option>
                                                        <option value="10:00">10:00 PM</option>
                                                        <option value="10:15">10:15 PM</option>
                                                        <option value="10:30">10:30 PM</option>
                                                        <option value="10:45">10:45 PM</option>
                                                        <option value="11:00">11:00 PM</option>
                                                        <option value="11:15">11:15 PM</option>
                                                        <option value="11:30">11:30 PM</option>
                                                        <option value="11:45">11:45 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Custom Time Reason</label>
                                                    <select class="form-select form-control" id="custom_time_reason">
                                                        <option value="none">None</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="front_desk">Front Desk</option>
                                                        <option value="meeting">Meeting</option>
                                                        <option value="training">Training</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <label class="form-label">Paid Time</label>
                                                <div class="toggle form-group">
                                                    <input type="radio" name="Paid_Time" value=""
                                                        id="cyes" checked="checked" />
                                                    <label for="cyes">Yes <i class="ico-tick"></i></label>
                                                    <input type="radio" name="Paid_Time" value=""
                                                        id="cno" />
                                                    <label for="cno">No <i class="ico-tick"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#"
                                                    class="btn btn-dashed w-100 btn-red icon-btn-center mb-3"><i
                                                        class="ico-close me-2"></i> Remove Custom Time</a>
                                                <a href="#"
                                                    class="btn btn-dashed w-100 btn-blue icon-btn-center"><i
                                                        class="ico-add me-2"></i> Add Custom Time</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end toggle -->
                    </div>
                    <div class="tab-pane fade" id="tab_2" role="tabpanel">
                        Set to not working.
                    </div>
                    <div class="tab-pane fade" id="tab_3" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label class="form-label">Leave reason </label>
                                    <select class="form-select form-control" id="leave_reason">
                                        <option value="1">None(unpaid)</option>
                                        <option value="2">Annual Leave</option>
                                        <option value="3">Public Holiday</option>
                                        <option value="4">Sick Leave</option>
                                        <option value="5">Unpaid Leave</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_4" role="tabpanel">
                        <div class="cst-toggle">
                            <div class="accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#working_hour" aria-expanded="false"> Partial Leave </button>
                                <div id="working_hour" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">End Time</label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#working_hour" aria-expanded="false"> Working Hours </button>

                                <div id="working_hour" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">End Time</label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#lunch" aria-expanded="false"> Lunch </button>

                                <div id="lunch" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Duration(minutes)</label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#break_time" aria-expanded="false">Break Time </button>

                                <div id="break_time" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Duration(minutes)</label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#custom_time" aria-expanded="false">Custom Time</button>

                                <div id="custom_time" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start Time </label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Duration(minutes)</label>
                                                    <select class="form-select form-control">
                                                        <option>9.30 AM</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Custom Time Reason</label>
                                                    <select class="form-select form-control">
                                                        <option>None</option>
                                                        <option>Option 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <label class="form-label">Paid Time</label>
                                                <div class="toggle form-group">
                                                    <input type="radio" name="Paid_Time" value=""
                                                        id="yes" checked="checked" />
                                                    <label for="yes">Yes <i class="ico-tick"></i></label>
                                                    <input type="radio" name="Paid_Time" value=""
                                                        id="no" />
                                                    <label for="no">No <i class="ico-tick"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#"
                                                    class="btn btn-dashed w-100 btn-red icon-btn-center mb-3"><i
                                                        class="ico-close me-2"></i> Remove Custom Time</a>
                                                <a href="#"
                                                    class="btn btn-dashed w-100 btn-blue icon-btn-center"><i
                                                        class="ico-add me-2"></i> Add Custom Time</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-md">Revert to normal working hours</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md">Cancel</button>
                <button type="button" class="btn btn-primary btn-md" id="WorkingHoursBtn">Save</button>
            </div>
        </div>
    </div>
</div>
