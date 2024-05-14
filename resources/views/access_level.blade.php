@extends('layouts/sidebar')
@section('content')
<!-- <main> -->
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-3">Access levels</h4>
            </div>
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
                                    <td class="text-left"> {{$app->name}}</td>
                                    <input type="hidden" name="name[]" value="{{$app->name}}">
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
            </div>
            
        </div>
<!-- </main> -->
@stop
@section('script')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    //Targets
    $.each( $('.targets'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#targets_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#targets_content').remove();
        }
    });
    $('.targets').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#targets_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="targets[]" value="0" id="targets_content">');
        }
    });
    //Limited
    $.each( $('.limited'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#limited_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#limited_content').remove();
        }
    });
    $('.limited').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#limited_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="limited[]" value="0" id="limited_content">');
        }
    });
    //Standard
    $.each( $('.standard'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#standard_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#standard_content').remove();
        }
    });
    $('.standard').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#standard_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="standard[]" value="0" id="standard_content">');
        }
    });
    //Standard +
    $.each( $('.standardplus'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#standardplus_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#standardplus_content').remove();
        }
    });
    $('.standardplus').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#standardplus_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="standardplus[]" value="0" id="standardplus_content">');
        }
    });
    //Advanced
    $.each( $('.advance'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#advance_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#advance_content').remove();
        }
    });
    $('.advance').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#advance_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="advance[]" value="0" id="advance_content">');
        }
    });
    //Advanced +
    $.each( $('.advanceplus'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#advanceplus_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#advanceplus_content').remove();
        }
    });
    $('.advanceplus').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#advanceplus_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="advanceplus[]" value="0" id="advanceplus_content">');
        }
    });
    //Admin
    $.each( $('.admin'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#admin_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#admin_content').remove();
        }
    });
    $('.admin').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().find('#admin_content').remove();
        }
        else{
            $(this).parent().parent().parent().append('<input type="hidden" name="admin[]" value="0" id="admin_content">');
        }
    });
    //Accounts
    $.each( $('.account'), function( key, value ) {
        console.log( value.text );
        if($(this).parent().parent().parent().find('#account_content').val() == '1')
        {
            $(this).parent().parent().parent().find('#account_content').remove();
        }
    });
    $('.account').on('change', function () {
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