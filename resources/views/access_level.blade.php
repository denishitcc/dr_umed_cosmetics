@extends('layouts/sidebar')
@section('content')
<main>
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-3">Access levels</h4>
                <p class="mb-0">Access levels can be customised to suit your business needs. To choose or change a staff person's access level, go to <a href="">Staff and Kitomba 1 users.</a>

                </p>
            </div>
            <ul class="nav brand-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_1"><i class="ico-enquiries"></i> Appointments & Clients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_2"><i class="ico-business-settings"></i> Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_3"><i class="ico-appt-reminder"></i> Reporting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_4"><i class="ico-staff-user"></i> Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_5"><i class="ico-equalizer"></i> Marketing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_6"><i class="ico-client"></i> Administration</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                    <form method="post" name="access" action="update-access-level">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                @foreach($access as $acc)
                                <tr>
                                    <td class="text-left"> {{$acc->appointments_and_clients}}</td>
                                    
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" value="1" {{  ($acc->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" value="1" {{  ($acc->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" value="1" {{  ($acc->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" value="1" {{  ($acc->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" value="1" {{  ($acc->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" value="1" {{  ($acc->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" value="1" {{  ($acc->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="accounts[]" value="1" {{  ($acc->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="tab_2" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                <tr>
                                    <td class="text-left"> Prepare sales</td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"> Complete sales	</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Edit prices	</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Apply manual discounts</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View completed invoices</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Edit completed invoice (basic) <i class="ico-help"  data-toggle="tooltip" data-placement="top" title="Users can edit line item quantities, who did the work, comments, credit sale to, add items, add new payments, create backdated invoices."></i>
                                            
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Edit completed invoice (advanced) <i class="ico-help"  data-toggle="tooltip" data-placement="top" title="Users can add/edit/remove discounts or surcharges, edit payment dates, edit/remove payments, edit/remove line items."></i></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Delete completed invoice (same-day only)</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Delete completed invoice	</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="tab_3" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                <tr>
                                    <td class="text-left"> View own Targets	</td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View own Scoreboard</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View business Scoreboard</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View Benchmark</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Run all reports	</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View and set Targets	</td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="tab_4" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                <tr>
                                    <td class="text-left"> View own timetable	
                                    </td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Add and edit staff timetables	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Add and edit timetable overrides	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">View own Time Sheets	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Approve Time Sheets	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Add and edit Kitomba 1 users	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="tab_5" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                <tr>
                                    <td class="text-left">Create Mailchimp campaigns	

                                    </td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Create Kmail campaigns	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Create Text campaigns	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="tab_6" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table all-db-table align-middle">
                                <tbody>
                                <tr class="tbl-title">
                                    <th></th>
                                    <th class="text-center">Targets</th>
                                    <th class="text-center">Limited</th>
                                    <th class="text-center">Standard</th>
                                    <th class="text-center">Standard +</th>
                                    <th class="text-center">Advanced</th>
                                    <th class="text-center">Advanced +</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Accounts</th>
                                </tr>
                                <tr>
                                    <td class="text-left">Manage Products and Services	
                                    </td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Set up Time Clock	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Create and manage Forms	
                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Add and manage Reasons	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Edit and cancel Vouchers	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Search Vouchers	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Edit business settings	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Manage business leave	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Create Voucher batches	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Manage rooms and equipment	

                                        </td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value="" disabled checked><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                        <td class="text-center"><label class="cst-check blue"><input type="checkbox" value=""><span class="checkmark"></span></label></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </div>
                </div>
            </div>
            
        </div>
</main>
@stop
@section('script')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection