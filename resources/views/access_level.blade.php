@extends('layouts/sidebar')
@section('content')
<!-- <main> -->
        <div class="card">
            
            <div class="card-head  pt-3">
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
                    <form method="post" name="access" action="update-appointment-clients">
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
                                @foreach($appointment_client as $app)
                                <tr>
                                    <td class="text-left"> {{$app->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$app->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($app->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($app->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($app->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($app->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($app->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($app->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($app->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($app->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($app->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($app->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($app->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($app->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($app->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($app->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($app->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($app->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
                    <form method="post" action="update-sales">
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
                                @foreach($sales as $sale)
                                <tr>
                                    <td class="text-left"> {{$sale->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$sale->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($sale->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($sale->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($sale->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($sale->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($sale->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($sale->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($sale->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($sale->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($sale->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($sale->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($sale->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($sale->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($sale->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($sale->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($sale->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($sale->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
                <div class="tab-pane fade" id="tab_3" role="tabpanel">
                <form method="post" action="update-reporting">
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
                                @foreach($reporting as $report)
                                <tr>
                                    <td class="text-left"> {{$report->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$report->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($report->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($report->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($report->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($report->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($report->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($report->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($report->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($report->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($report->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($report->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($report->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($report->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($report->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($report->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($report->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($report->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
                <div class="tab-pane fade" id="tab_4" role="tabpanel">
                <form method="post" action="update-staff">
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
                                @foreach($staffs as $staff)
                                <tr>
                                    <td class="text-left"> {{$staff->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$staff->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($staff->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($staff->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($staff->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($staff->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($staff->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($staff->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($staff->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($staff->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($staff->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($staff->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($staff->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($staff->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($staff->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($staff->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($staff->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($staff->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
                <div class="tab-pane fade" id="tab_5" role="tabpanel">
                <form method="post" action="update-marketing">
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
                                @foreach($marketing as $market)
                                <tr>
                                    <td class="text-left"> {{$market->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$market->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($market->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($market->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($market->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($market->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($market->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($market->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($market->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($market->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($market->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($market->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($market->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($market->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($market->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($market->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($market->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($market->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
                <div class="tab-pane fade" id="tab_6" role="tabpanel">
                <form method="post" action="update-administration">
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
                                @foreach($administration as $administrate)
                                <tr>
                                    <td class="text-left"> {{$administrate->sub_name}}</td>
                                    <input type="hidden" name="name[]" value="{{$administrate->sub_name}}">
                                    <input type="hidden" name="targets[]" value="{{  ($administrate->targets == 1) ? 1 : 0}}" id="targets_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="targets[]" class="targets" value="1" {{  ($administrate->targets == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="limited[]" value="{{  ($administrate->limited == 1) ? 1 : 0}}" id="limited_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="limited[]" class="limited" value="1" {{  ($administrate->limited == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standard[]" value="{{  ($administrate->standard == 1) ? 1 : 0}}" id="standard_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standard[]" class="standard" value="1" {{  ($administrate->standard == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="standardplus[]" value="{{  ($administrate->standardplus == 1) ? 1 : 0}}" id="standardplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="standardplus[]" class="standardplus" value="1" {{  ($administrate->standardplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advance[]" value="{{  ($administrate->advance == 1) ? 1 : 0}}" id="advance_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advance[]" class="advance" value="1" {{  ($administrate->advance == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="advanceplus[]" value="{{  ($administrate->advanceplus == 1) ? 1 : 0}}" id="advanceplus_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="advanceplus[]" class="advanceplus" value="1" {{  ($administrate->advanceplus == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="admin[]" value="{{  ($administrate->admin == 1) ? 1 : 0}}" id="admin_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="admin[]" class="admin" value="1" {{  ($administrate->admin == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
                                    <input type="hidden" name="account[]" value="{{  ($administrate->account == 1) ? 1 : 0}}" id="account_content">
                                    <td class="text-center"><label class="cst-check blue"><input type="checkbox" name="account[]" class="account" value="1" {{  ($administrate->account == 1 ? ' checked' : '') }}><span class="checkmark"></span></label></td>
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
            </div>
            
        </div>
<!-- </main> -->
@stop
@section('script')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    //Targets
    $.each( $('.targets'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#targets_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#targets_content').remove();
        }
    });
    $('.targets').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#targets_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="targets[]" value="0" id="targets_content">');
        }
    });
    //Limited
    $.each( $('.limited'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#limited_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#limited_content').remove();
        }
    });
    $('.limited').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#limited_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="limited[]" value="0" id="limited_content">');
        }
    });
    //Standard
    $.each( $('.standard'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#standard_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#standard_content').remove();
        }
    });
    $('.standard').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#standard_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="standard[]" value="0" id="standard_content">');
        }
    });
    //Standard +
    $.each( $('.standardplus'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#standardplus_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#standardplus_content').remove();
        }
    });
    $('.standardplus').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#standardplus_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="standardplus[]" value="0" id="standardplus_content">');
        }
    });
    //Advanced
    $.each( $('.advance'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#advance_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#advance_content').remove();
        }
    });
    $('.advance').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#advance_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="advance[]" value="0" id="advance_content">');
        }
    });
    //Advanced +
    $.each( $('.advanceplus'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#advanceplus_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#advanceplus_content').remove();
        }
    });
    $('.advanceplus').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#advanceplus_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="advanceplus[]" value="0" id="advanceplus_content">');
        }
    });
    //Admin
    $.each( $('.admin'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#admin_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#admin_content').remove();
        }
    });
    $('.admin').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#admin_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="admin[]" value="0" id="admin_content">');
        }
    });
    //Accounts
    $.each( $('.account'), function( key, value ) {debugger;
        console.log( value.text );
        if($(this).parent().parent().parent().find('#account_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#account_content').remove();
        }
    });
    $('.account').on('change', function () {debugger;
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#account_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="account[]" value="0" id="account_content">');
        }
    });
});
</script>
@endsection