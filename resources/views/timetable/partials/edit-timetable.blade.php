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
                            <div class="col-lg-6">
                                <a href="javascript:void(0)"
                                    class="btn btn-dashed w-100 btn-blue icon-btn-center new_timetable"><i
                                        class="ico-add me-2 fs-5"></i> Timetable </a>
                            </div>
                            <div class="col-lg-6">
                                <a href="javascript:void(0)" class="btn btn-dashed w-100 btn-blue icon-btn-center"
                                    id="open_copy_timetable"><i class="ico-copy me-2 fs-5"></i> Copy from other staff</a>
                            </div>
                        </div>
                        {{-- New Timetable Section --}}
                        <div class="invo-notice d-block new_timetable_section">
                            <h5 class="bright-gray mb-3">New timetable</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Timetable name <i>(required)</i></label>
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
                                <table class="table all-db-table align-middle" style="table-layout: fixed;">
                                    <tr class="tbl-title">
                                        <th></th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="sun" value="sun"><span
                                                    class="checkmark me-1"></span> Sun</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox" name="mon" value="mon"><span
                                                    class="checkmark me-1"></span> Mon</label>
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
                                    <tr>
                                        <td>Start time</td>
                                        <td data-day="sun">
                                            <select class="form-select form-control sun_start_time" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td data-day="sun">
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>End time</td>
                                        <td>
                                            <select class="form-select form-control sun_end_time" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-control" disabled>
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lunch</td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 sun_lunch" disabled>
                                                <i class="ico-add fs-4 sun_leave_icon" ></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                    </tr>
                                    <tr id="lunch_start">
                                        <td>Lunch Start</td>
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
                                        <td>
                                            <select class="form-select form-control">
                                                <option>9:00 am</option>
                                                <option>9:15 am</option>
                                                <option>9:30 am</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="lunch_duration">
                                        <td>Lunch duration </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="0">
                                                <span class="input-group-text font-12">Min</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Break</td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 sun_break" disabled>
                                                <i class="ico-add fs-4 sun_leave_icon" ></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Custom time 1</td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100 sun_custom" disabled>
                                                <i class="ico-add fs-4 sun_leave_icon" ></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-md icon-btn-center w-100" disabled>
                                                <i class="ico-add fs-4"></i></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer px-0">
                                <button type="button" class="btn btn-light btn-md cancel_timetable">Cancel</button>
                                <button type="button" class="btn btn-primary btn-md">Save</button>
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
