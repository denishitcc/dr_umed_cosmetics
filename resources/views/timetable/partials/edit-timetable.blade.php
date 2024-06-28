{{-- edit_timetable modal start --}}
<div class="modal fade" id="edit_timetable" tabindex="0" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit timetable</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-fill nav-group mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Timetable" aria-selected="true"
                            role="tab">Timetable <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#Leave" aria-selected="false" tabindex="-1"
                            role="tab">Leave <i class="ico-tick ms-1"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="Timetable" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <a href="javascript:void(0)"
                                    class="btn btn-dashed w-100 btn-blue icon-btn-center new_timetable"><i
                                        class="ico-add me-2 fs-5"></i> Timetable </a>
                            </div>
                            {{-- <div class="col-lg-6">
                                <a href="javascript:void(0)" class="btn btn-dashed w-100 btn-blue icon-btn-center"
                                    id="open_copy_timetable"><i class="ico-copy me-2 fs-5"></i> Copy from other staff</a>
                            </div> --}}
                        </div>
                        {{-- New Timetable Section --}}
                        <div class="invo-notice d-block new_timetable_section">
                            <h5 class="bright-gray mb-3">New timetable</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Start date</label>
                                        <input type="date" name="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">End date</label>
                                        <input type="date" name="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table all-db-table align-middle" style="table-layout: fixed;">
                                    <tr class="tbl-title">
                                        <th></th>
                                        <th class="text-center">
                                            <label class="cst-check blue">
                                                <input type="checkbox" name="sun" id="sun-checkbox" value="sun">
                                                <span class="checkmark me-1"></span> Sun
                                            </label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue">
                                                <input type="checkbox" name="mon" id="mon-checkbox" value="mon">
                                                <span class="checkmark me-1"></span> Mon
                                            </label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="tue" value="tue"><span
                                                    class="checkmark me-1"></span> Tue</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="wed" value="wed"><span
                                                    class="checkmark me-1"></span> Wed</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="thu" value="thu"><span
                                                    class="checkmark me-1"></span> Thu</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="fri" value="fri"><span
                                                    class="checkmark me-1"></span> Fri</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="sat" value="sat"><span
                                                    class="checkmark me-1"></span> Sat</label>
                                        </th>
                                    </tr>
                                    <tr id="start_time">
                                        <td>Start time</td>
                                        <td>
                                            <select class="form-select form-control sun_start_time" disabled name="sun_start_time">
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
                                            </select>
                                        </td>
                                        <td >
                                            <select class="form-select form-control mon_start_time" disabled name="mon_start_time">
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
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control tue_start_time" disabled name="tue_start_time">
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
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control wed_start_time" disabled name="wed_start_time">
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
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control thu_start_time" disabled name="thu_start_time">
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
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control fri_start_time" disabled name="fri_start_time">
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
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control sat_start_time" disabled name="sat_start_time">
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
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>End time</td>
                                        <td>
                                            <select class="form-select form-control sun_end_time" disabled name="sun_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control mon_end_time" disabled name="mon_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control tue_end_time" disabled name="tue_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control wed_end_time" disabled name="wed_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control thu_end_time" disabled name="thu_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control fri_end_time" disabled name="fri_end_time">
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
                                        </td>
                                        <td>
                                            <select class="form-select form-control sat_end_time" disabled name="sat_end_time">
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lunch</td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 lunch" disabled>
                                                <i class="ico-add fs-4 sun_leave_icon" ></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 mon_lunch" disabled data-weekdays="2">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 tue_lunch" disabled data-weekdays="3">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 wed_lunch" disabled data-weekdays="4">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 thu_lunch" disabled data-weekdays="5">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 fri_lunch" disabled data-weekdays="6">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 sat_lunch" disabled data-weekdays="7">
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                    </tr>
                                    <tr id="lunch_start">
                                        <td>Lunch Start</td>
                                        <td class="sun_lunch_start">
                                            <select class="form-select form-control" name="sun_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="mon_lunch_start">
                                            <select class="form-select form-control" name="mon_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="tue_lunch_start">
                                            <select class="form-select form-control" name="tue_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="wed_lunch_start">
                                            <select class="form-select form-control" name="wed_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="thu_lunch_start">
                                            <select class="form-select form-control" name="thu_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="fri_lunch_start">
                                            <select class="form-select form-control" name="fri_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td class="sat_lunch_start">
                                            <select class="form-select form-control" name="sat_lunch_start">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="lunch_duration">
                                        <td>Lunch duration </td>
                                        <td class="sun_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="sun_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="mon_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="mon_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="tue_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="tue_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="wed_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="wed_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="thu_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="thu_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="fri_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="fri_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td class="sat_duration">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0" name="sat_duration">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Break</td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 break" disabled>
                                                <i class="ico-add fs-4" ></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 mon_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 tue_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 wed_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 thu_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 fri_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 sat_break" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer px-0">
                                <button type="button" class="btn btn-light btn-md cancel_timetable">Cancel</button>
                                <button type="button" class="btn btn-primary btn-md" id="timetableSavebtn">Save</button>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4 d-flex">
                            <button class="btn btn-primary btn-md me-2 repeat" disabled>Repeat</button>
                            <button class="btn btn-red btn-md delete" disabled>Delete</button>
                        </div>

                        <table class="table all-db-table align-middle mb-4">
                            <thead>
                                <tr>
                                    <th aria-sort="ascending">
                                        <label class="cst-check blue">
                                            <input type="checkbox"><span class="checkmark me-3"></span> Timetable name
                                        </label>
                                    </th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><label class="cst-check blue">
                                            <input type="checkbox" name="time_check[]"><span
                                                class="checkmark me-3"></span> Amy</label>
                                    </td>
                                    <td>Mon, 1 Jul 2024</td>
                                    <td>Until further notice</td>
                                    <td><a href="" class="btn btn-sm black-btn round-6 dt-edit">
                                            <i class="ico-trash"></i></a>
                                    </td>
                                    <td>
                                        <a class="simple-link" data-bs-toggle="collapse" href="#collapseExample1"
                                            aria-expanded="false" aria-controls="collapseExample"
                                            style="width: 25px; height: 25px; margin: auto;"></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5">
                                        <div class="collapse" id="collapseExample1">
                                            <div class="invo-notice d-block">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Timetable name
                                                                <i>(required)</i></label>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Start date</label>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table all-db-table align-middle"
                                                        style="table-layout: fixed;">
                                                        <tr class="tbl-title">
                                                            <th></th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Sun</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Mon</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Tue</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Wed</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Thu</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Fri</label>
                                                            </th>
                                                            <th class="text-center">
                                                                <label class="cst-check blue"><input
                                                                        type="checkbox"><span
                                                                        class="checkmark me-1"></span> Sat</label>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Start time</td>
                                                            <td>
                                                                <select class="form-select form-control" disabled>
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>End time</td>
                                                            <td>
                                                                <select class="form-select form-control" disabled>
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lunch</td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"
                                                                    disabled><i class="ico-add fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                                        class="ico-add fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-red btn-md icon-btn-center w-100"><i
                                                                        class="ico-trash fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                                        class="ico-add fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                                        class="ico-add fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                                        class="ico-add fs-4"></i></button></td>
                                                            <td> <button
                                                                    class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                                        class="ico-add fs-4"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lunch Start</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <select class="form-select form-control">
                                                                    <option>9:00 am</option>
                                                                    <option>9:15 am</option>
                                                                    <option>9:30 am</option>
                                                                </select>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lunch duration </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="0">
                                                                    <span class="input-group-text font-12">Min</span>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer px-0">
                                                    <button type="button"
                                                        class="btn btn-light btn-md">Cancel</button>
                                                    <button type="button"
                                                        class="btn btn-primary btn-md">Save</button>
                                                </div>

                                            </div>
                                        </div>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="Leave" role="tabpanel">
                        <a href="javascript:void(0)" class="btn btn-dashed w-100 btn-blue icon-btn-center mb-4 create_leave"><i
                                class="ico-add me-2 fs-5"></i> Leave</a>

                        <div class="invo-notice d-block mb-4 create_leave_section">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">Leave starts</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">Leave ends</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">Leave reason</label>
                                        <select class="form-select form-control">
                                            <option>None (Unpaid)</option>
                                            <option>new</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" rows="5" placeholder="Add a note"></textarea>
                            </div>
                            <div class="modal-footer px-0">
                                <button type="button" class="btn btn-light btn-md cancel_leave">Cancel</button>
                                <button type="button" class="btn btn-primary btn-md">Save Leaves</button>
                            </div>
                        </div>
                        To create new leave, click on “+ Leave”.
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
{{-- edit_timetable modal end --}}
