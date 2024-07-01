@if (count($timetable)> 0)
<div class="mb-4 d-flex">
    <button class="btn btn-primary btn-md me-2 repeat" disabled>Repeat</button>
    <button class="btn btn-red btn-md delete" disabled>Delete</button>
</div>
<table class="table all-db-table align-middle mb-4">
    <thead>
        <tr>
            <th aria-sort="ascending">
                <label class="cst-check blue">
                    <input type="checkbox"><span class="checkmark me-3"></span>Start
                </label>
            </th>
            <th>End</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($timetable as $time)
            <tr>
                <td>
                    <label class="cst-check blue">
                        <input type="checkbox" name="time_check[]"><span class="checkmark me-3"></span>{{ date('D, d M Y', strtotime($time->start_date)) }}
                    </label>
                </td>
                <td> {{ date('D, d M Y', strtotime($time->end_date)) }} </td>
                <td>
                    <a href="" class="btn btn-sm black-btn round-6 dt-edit">
                        <i class="ico-trash"></i>
                    </a>
                </td>
                <td>
                    <a class="simple-link" data-bs-toggle="collapse" href="#collapseExample1" aria-expanded="false"
                        aria-controls="collapseExample" style="width: 25px; height: 25px; margin: auto;"></a>
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
                                <table class="table all-db-table align-middle" style="table-layout: fixed;">
                                    <tr class="tbl-title">
                                        <th></th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Sun</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Mon</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Tue</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Wed</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Thu</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
                                                    class="checkmark me-1"></span> Fri</label>
                                        </th>
                                        <th class="text-center">
                                            <label class="cst-check blue"><input type="checkbox"><span
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
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100" disabled><i
                                                    class="ico-add fs-4"></i></button></td>
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                    class="ico-add fs-4"></i></button></td>
                                        <td> <button class="btn btn-red btn-md icon-btn-center w-100"><i
                                                    class="ico-trash fs-4"></i></button></td>
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                    class="ico-add fs-4"></i></button></td>
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                    class="ico-add fs-4"></i></button></td>
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100"><i
                                                    class="ico-add fs-4"></i></button></td>
                                        <td> <button class="btn btn-primary btn-md icon-btn-center w-100"><i
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
                                                <input type="text" class="form-control" placeholder="0">
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
                                <button type="button" class="btn btn-light btn-md">Cancel</button>
                                <button type="button" class="btn btn-primary btn-md">Save</button>
                            </div>
    
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

