<div class="modal fade" id="repeat_Appointment" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Repeat appointment for <label id="repeat_name"></label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invo-notice mb-4">
                    <div class="inv-left">
                        <b id="repeat_services_name"></b><br>
                        <span class="d-grey" id="servicewithdoctorname"></span>
                    </div>
                </div>
                <form method="post" id="repeatappt">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Repeat every</label>
                                <input type="number" class="form-control" placeholder="1" name="repeat_every_no" value="1">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <select class="form-select form-control repeat_every" name="repeat_every">
                                    <option selected>Choose option</option>
                                    <option value="day">Day(s)</option>
                                    <option value="week">Week(s)</option>
                                    <option value="month">Month(s)</option>
                                    <option value="year">Year(s)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="days" style="display: none;">
                        <label class="cst-check me-4">
                            <input type="checkbox" value="monday" name="weekdays[]"><span class="checkmark me-2"></span> Monday</label>
                        <label class="cst-check me-4">
                            <input type="checkbox" value="tuesday" name="weekdays[]"><span class="checkmark me-2"></span> Tuesday</label>
                        <label class="cst-check me-4">
                            <input type="checkbox" value="wednesday" name="weekdays[]" ><span class="checkmark me-2"></span> Wednesday</label>
                        <label class="cst-check me-4">
                            <input type="checkbox" value="thrusday" name="weekdays[]"><span class="checkmark me-2"></span> Thursday</label>
                        <label class="cst-check me-4">
                            <input type="checkbox" value="friday" name="weekdays[]"><span class="checkmark me-2"></span> Friday</label>
                        <label class="cst-check">
                            <input type="checkbox" value="saturaday" name="weekdays[]"><span class="checkmark me-2"></span> Saturday</label><br>
                        <label class="cst-check">
                            <input type="checkbox" value="sunday" name="weekdays[]"><span class="checkmark me-2"></span> Sunday</label>
                    </div>

                    <div class="form-group" id="years" style="display: none;">
                        <div class="col-auto">
                            <label class="cst-radio">
                                <input type="radio" name="repeat_year" value="0">
                                <span class="checkmark me-2"></span><label class="year"></label>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="cst-radio">
                                <input type="radio" name="repeat_year" value="1">
                                <span class="checkmark me-2">
                                    <input type="hidden" name="repeat_day" id="repeat_day">
                                    <input type="hidden" name="repeat_year_month" id="repeat_year_month">
                                </span><label class="week_year"></label>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="month" style="display: none;">
                        <div class="col-auto">
                            <label class="cst-radio">
                                <input type="radio" name="repeat_month" value="0" >
                                <span class="checkmark me-2"></span><label id="repeat_every_month"></label>
                            </label>
                        </div>
                        <div class="col-auto">
                            <input type="hidden" name="repeat_every_month_weekday" class="repeat_every_month_weekday">
                            <label class="cst-radio">
                                <input type="radio" name="repeat_month" value="1">
                                <span class="checkmark me-2"></span><label id="repeat_every_month_weekday"></label>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Preferred time</label>
                                {{-- <select class="form-select form-control">
                                    <option>10.30 AM</option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select> --}}
                                <select id="repeatTime" name="repeat_time" class="form-control">
                                    <option value="5:00">5:00 am</option>
                                    <option value="5:15">5:15 am</option>
                                    <option value="5:30">5:30 am</option>
                                    <option value="5:45">5:45 am</option>
                                    <option value="6:00">6:00 am</option>
                                    <option value="6:15">6:15 am</option>
                                    <option value="6:30">6:30 am</option>
                                    <option value="6:45">6:45 am</option>
                                    <option value="7:00">7:00 am</option>
                                    <option value="7:15">7:15 am</option>
                                    <option value="7:30">7:30 am</option>
                                    <option value="7:30">7:30 am</option>
                                    <option value="8:00">8:00 am</option>
                                    <option value="8:15">8:15 am</option>
                                    <option value="8:30">8:30 am</option>
                                    <option value="8:45">8:45 am</option>
                                    <option value="9:00">9:00 am</option>
                                    <option value="9:15">9:15 am</option>
                                    <option value="9:30">9:30 am</option>
                                    <option value="9:45">9:45 am</option>
                                    <option value="10:00">10:00 am</option>
                                    <option value="10:15">10:15 am</option>
                                    <option value="10:30">10:30 am</option>
                                    <option value="10:45">10:45 am</option>
                                    <option value="11:00" selected="selected">11:00 am</option>
                                    <option value="11:15">11:15 am</option>
                                    <option value="11:30">11:30 am</option>
                                    <option value="11:45">11:45 am</option>
                                    <option value="12:00">12:00 pm</option>
                                    <option value="12:15">12:15 pm</option>
                                    <option value="12:30">12:30 pm</option>
                                    <option value="12:45">12:45 pm</option>
                                    <option value="13:00">1:00 pm</option>
                                    <option value="13:15">1:15 pm</option>
                                    <option value="13:30">1:30 pm</option>
                                    <option value="13:45">1:45 pm</option>
                                    <option value="14:00">2:00 pm</option>
                                    <option value="14:15">2:15 pm</option>
                                    <option value="14:30">2:30 pm</option>
                                    <option value="14:45">2:45 pm</option>
                                    <option value="15:00">3:00 pm</option>
                                    <option value="15:15">3:15 pm</option>
                                    <option value="15:30">3:30 pm</option>
                                    <option value="15:45">3:45 pm</option>
                                    <option value="16:00">4:00 pm</option>
                                    <option value="16:15">4:15 pm</option>
                                    <option value="16:30">4:30 pm</option>
                                    <option value="16:45">4:45 pm</option>
                                    <option value="17:00">5:00 pm</option>
                                    <option value="17:15">5:15 pm</option>
                                    <option value="17:30">5:30 pm</option>
                                    <option value="17:45">5:45 pm</option>
                                    <option value="18:00">6:00 pm</option>
                                    <option value="18:15">6:15 pm</option>
                                    <option value="18:30">6:30 pm</option>
                                    <option value="18:45">6:45 pm</option>
                                    <option value="19:00">7:00 pm</option>
                                    <option value="19:15">7:15 pm</option>
                                    <option value="19:30">7:30 pm</option>
                                    <option value="19:45">7:45 pm</option>
                                    <option value="20:00">8:00 pm</option>
                                    <option value="20:15">8:15 pm</option>
                                    <option value="20:30">8:30 pm</option>
                                    <option value="20:45">8:45 pm</option>
                                    <option value="21:00">9:00 pm</option>
                                    <option value="21:15">9:15 pm</option>
                                    <option value="21:30">9:30 pm</option>
                                    <option value="21:45">9:45 pm</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <label class="form-label mb-3">Stop repeating </label><br>

                    <div class="form-group">
                        <div class="row align-items-center ">
                            <div class="col-auto">
                                <label class="cst-radio">
                                    <input type="radio" name="stop_repeating" value="on">
                                    <span class="checkmark me-2"></span>On
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="hidden" class="form-control" name="appointment_date" id="appointment_date">
                                <input type="hidden" class="form-control" name="appointment_duration" id="appointment_duration">
                                <input type="text" class="form-control" name="stop_repeating_date" id="stop_repeating_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row align-items-center ">
                            <div class="col-auto">
                                <label class="cst-radio">
                                    <input type="radio" name="stop_repeating" value="after">
                                    <span class="checkmark me-2"></span>After
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control" name="no_of_appointment" min="1" step="1">
                            </div>
                            appointments
                        </div>
                    </div>
                    <label style="color: red" id="repeat_error">You must select an Stop repeating.</label>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-md" id="repeatAppointmentSaveBtn">Create Appointments</button>
            </div>
        </form>
        </div>
    </div>
</div>
