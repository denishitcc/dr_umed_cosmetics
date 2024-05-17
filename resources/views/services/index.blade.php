@extends('layouts.sidebar')
@section('title', 'Services')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card">
    <div class="card-head">
        <div class="toolbar">
            <div class="tool-left d-flex align-items-center ">
                <h4 class="small-title mb-0" style="white-space: nowrap;">All services</h4>
                <div class="input-group search mx-4 w-auto h-44">
                    <span class="input-group-addon">
                        <span class="ico-mini-search"></span>
                    </span>
                    <input type="search" class="form-control input-sm" placeholder="Search Services" id="search_services">
                    </div>
                    @if(Auth::check() && (Auth::user()->role_type == 'admin'))
                    <form id="import_service" name="import_service" class="form d-flex align-items-center">
                        @csrf
                        <label for="import" class="btn btn-primary btn-md icon-btn-left me-2"><i class="ico-import me-2 fs-4"></i> Import a Services List</label>
                        <a href="{{ asset('/storage/csv_files/sample_services.csv') }}" class="simple-link">Download sample file</a>
                        <input type="file" id="import" name="csv_file" style="display:none;" accept=".csv">    
                    </form>
                    @elseif(Auth::user()->checkPermission('services') != 'View Only')
                    <form id="import_service" name="import_service" class="form d-flex align-items-center">
                        @csrf
                        <label for="import" class="btn btn-primary btn-md icon-btn-left me-2"><i class="ico-import me-2 fs-4"></i> Import a Services List</label>
                        <a href="{{ asset('/storage/csv_files/sample_services.csv') }}" class="simple-link">Download sample file</a>
                        <input type="file" id="import" name="csv_file" style="display:none;" accept=".csv">    
                    </form>
                    @endif
            </div>
        </div>
    </div>
    <div class="card-body no-pd">
        <div class="scaffold-layout-outr">
            <div class="scaffold-layout-list-details">
                <div class="ctg-greybox-list-box">
                    <div class="ctg-greybox h-100">
                        <div class="p-4">
                            <h6 class="mb-4">Categories</h6>
                            <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#new_Category">+ New Category</a>
                        </div>
                        
                        <ul class="ctg-tree">
                            <li class="white-active blue-active">
                                <div class="disflex all_services">
                                    <a href="#">All Services & Tasks</a> <span class="count">{{count($list_service)}}</span>
                                </div>
                            </li>
                            @foreach($categories as $parentCategory)
                                <li class="parent_category">
                                    <div class="disflex">
                                        <a href="#" ids="{{$parentCategory->id}}">{{ $parentCategory->category_name }}</a>
                                        <span class="count">{{ $list_service->where('category_id', $parentCategory->id)->count() }}</span>
                                    </div>
                                    <!-- <ul>
                                        @foreach($list_cat->where('parent_category', $parentCategory->id) as $subcategory)
                                            <li ids="{{$subcategory->id}}" class="child_category">
                                                <a href="#">{{ $subcategory->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul> -->
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="ctg-greybox-details-box">
                    <div class="pe-4 py-4">
                        <h6 class="mb-4 service_name">All Services & Tasks</h6>
                        <div class="mb-4 d-flex">
                            @if(Auth::check() && (Auth::user()->role_type == 'admin'))
                            <a href="{{URL::to('services/create')}}" class="btn btn-primary btn-md me-2">+ Add New Service</a>
                            @elseif(Auth::user()->checkPermission('services') != 'View Only')
                            <a href="{{URL::to('services/create')}}" class="btn btn-primary btn-md me-2">+ Add New Service</a>
                            @endif
                            <a href="#" id="" style="display:none"; class="btn btn-secondary btn-md icon-btn-left edit_service" data-bs-toggle="modal" data-bs-target="#edit_Category";><i class="ico-edit me-2 fs-4"></i>  <!-- Icon element for "Edit Category" -->Edit Category  <!-- Text content for the hyperlink --></a>
                            <a href="#" style="display:none"; class="btn simple-link set_availability" data-bs-toggle="modal" data-bs-target="#change_Availability">Set availability for this category</a>
                        </div>

                        <div class="table-responsive">
                            <!-- <table class="table all-db-table align-middle table-striped">
                                <thead>
                                <tr>
                                    <th class="blue-bold" width="75%" aria-sort="ascending">Services in this category</th>
                                    <th class="blue-bold" width="25%">Minutes </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" style="color: #282828;"><b>Face - 2x BBL $800 +2x HALO $2000</b></a></td>
                                    <td>90 mins</td>
                                </tr>
                            </tbody>
                            </table> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
    
</div>
<div class="modal fade" id="new_Category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">New Category</h4>
            <button type="button" class="btn-close category_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create_category" name="create_category" class="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="cst-check"><input type="checkbox" value="1" name="show_business_summary" checked><span class="checkmark me-2"></span>Show on Business Summary in Dr. Umed</label>
                </div>
                <div class="form-group mb-0">
                    <label class="cst-check"><input type="checkbox" value="1" name="trigger_when_sold"><span class="checkmark me-2"></span>Trigger Everyday Marketing when sold</label>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-md">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_Category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Edit Category</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_category" name="edit_category" class="form">
            @csrf
            <input type="hidden" name="cat_hdn_id" id="cat_hdn_id" value="">
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control edit_category_name" id="edit_category_name" name="category_name" maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="cst-check"><input type="checkbox" value="1" name="show_business_summary" checked><span class="checkmark me-2"></span>Show on Business Summary in Dr. Umed</label>
                </div>
                <div class="form-group mb-0">
                    <label class="cst-check"><input type="checkbox" value="1" name="trigger_when_sold"><span class="checkmark me-2"></span>Trigger Everyday Marketing when sold</label>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light me-2 delete_category">Delete</button>
            <button type="submit" class="btn btn-primary btn-md">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="change_Availability" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change availability</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="change_availability_form" name="change_availability_form" class="form">
            @csrf
            <input type="hidden" name="hdn_cat_id" id="hdn_cat_id" value="">
            <div class="modal-body">
                <table class="table all-db-table align-middle mb-0">
                    <thead>
                    <tr>
                        <th class="blue-bold" width="40%" aria-sort="ascending">Location</th>
                        <th class="blue-bold text-center" width="20%">(no change)</th>
                        <th class="blue-bold text-center" width="20%" style="background-color: #F4B5A7;">Not available</th>
                        <th class="blue-bold text-center" width="20%" style="background-color: #D3EDBF;">Available </th>
                    </tr>
                </thead>
                <tbody>
                @if(count($locations) > 0)
                    @foreach($locations as $index => $loc)
                        <tr>
                            <td><b>{{$loc->location_name}}</b></td>
                            <input type="hidden" name="locs_name[]" value="{{$loc->id}}">
                            <td class="text-center"><label class="cst-radio"><input type="radio" checked class="no_change" name="availability{{$index}}" value="(no change)"><span class="radio-lg dark"></span></label></td>
                            <td class="text-center"><label class="cst-radio"><input type="radio" name="availability{{$index}}" value="Not available"><span class="radio-lg dark"></span></label></td>
                            <td class="text-center"><label class="cst-radio"><input type="radio" name="availability{{$index}}" value="Available"><span class="radio-lg dark"></span></label></td>
                        </tr>
                    @endforeach
                @endif
                
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md cancel_form">Cancel</button>
                <button type="submit" class="btn btn-primary btn-md">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('.cancel_form').click(function(){
        $('#change_Availability').modal('hide');
    })
    
    //get services from category
    var categories = 'All Services & Tasks';
    $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('services.get-services')}}",
        data: {// change data to this object
            _token : $('meta[name="csrf-token"]').attr('content'), 
            categories:categories
        },
        dataType: "json",
        success: function(res) {
            
            if(res.data.length > 0)
            {
                $('.table-responsive').empty();
                $('.table-responsive').append("<table class='table all-db-table align-middle table-striped service-tbl'><thead><tr><th class='blue-bold' width='75%' aria-sort='ascending'>Services in this category</th><th class='blue-bold' width='25%'>Minutes </th></tr></thead><tbody id='fbody'>");
                $.each(res.data, function(index, res) {
                    var url = '{{ URL::to("services/") }}/' + res.id; // Corrected URL formatting
                    if(res.duration != null)
                    {
                        var dur = res.duration;
                    }else{
                        var dur = '0';
                    }
                    $('.table-striped').append("<tr><td><a href='" + url + "' style='color: #282828;'><b>" + res.service_name + "</b></a></td><td>" + dur + " mins</td></tr>");
                });
                $('.table-responsive').append("</tbody></table>");
            }
            else{
                $('.table-responsive').empty();
            }
        },
        error: function (jqXHR, exception) {

        }
    });
    $("#create_category").validate({
        rules: {
            category_name: {
                required: true,
                remote: {
                    url: "../services/checkCategoryName", // Replace with the actual URL to check email uniqueness
                    type: "post", // Use "post" method for the AJAX request
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        category_name: function () {
                            return $("#category_name").val(); // Pass the value of the email field to the server
                        },
                        page_type:'create'
                    },
                    dataFilter: function (data) {
                        var json = $.parseJSON(data);
                        var chk = json.exists ? '"Category already exist!"' : '"true"';
                        return chk;
                    }
                }
            },
        },
    });
    $("#edit_category").validate({
        rules: {
            category_name: {
                required: true,
                remote: {
                    url: "../services/checkCategoryName", // Replace with the actual URL to check email uniqueness
                    type: "post", // Use "post" method for the AJAX request
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        category_id: function () {
                            return $("#cat_hdn_id").val(); // Pass the value of the email field to the server
                        },
                        category_name: function () {
                            return $("#edit_category_name").val(); // Pass the value of the email field to the server
                        },
                        page_type:'edit'
                    },
                    dataFilter: function (data) {
                        var json = $.parseJSON(data);
                        var chk = json.exists ? '"Category already exist!"' : '"true"';
                        return chk;
                    }
                }
            },
        }
    });
    $(document).on('submit','#create_category',function(e){
		e.preventDefault();
		var valid= $("#create_category").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_category').serialize() ;

            // var data = new FormData(this);
			submitCreateCategoryForm(data);
		}
	});
    $(document).on('submit','#edit_category',function(e){
		e.preventDefault();
		var valid= $("#edit_category").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_category').serialize() ;

            // var data = new FormData(this);
			submitEditCategoryForm(data);
		}
	});
    $('.all_services').click(function(){
        $('.edit_service').hide();
        $('.set_availability').hide();
        //for active current class
        $(this).parent().parent().find('.blue-active').removeClass('blue-active');
        $(this).parent().parent().parent().parent().find('.active').removeClass('active');
        $(this).parent().addClass('blue-active'); 
        $(this).parent().addClass('active');
        $('.service_name').text($(this).find('a').text());
        // alert('hi');
        return false;
        //get services from category
        var categories = 'All Services & Tasks';
        $.ajax({
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('services.get-services')}}",
            data: {// change data to this object
              _token : $('meta[name="csrf-token"]').attr('content'), 
              categories:categories
            },
            dataType: "json",
            success: function(res) {
                
                if(res.data.length > 0)
                {
                    $('.table-responsive').empty();
                    $('.table-responsive').append("<table class='table all-db-table align-middle table-striped'><thead><tr><th class='blue-bold' width='75%' aria-sort='ascending'>Services in this category</th><th class='blue-bold' width='25%'>Minutes </th></tr></thead><tbody>");
                    $.each(res.data, function(index, res) {
                        var url = '{{ URL::to("services/") }}/' + res.id; // Corrected URL formatting
                        var duration = res.duration != null ? res.duration : "0";
                        $('.table-striped').append("<tr><td><a href='" + url + "' style='color: #282828;'><b>" + res.service_name + "</b></a></td><td>" + duration + " mins</td></tr>");
                    });
                    $('.table-responsive').append("</tbody></table>");
                }
                else{
                    $('.table-responsive').empty();
                }
            },
            error: function (jqXHR, exception) {

           }
        });
        return false;
    })
    // $('.child_category').click(function(e){
    //     if($(this).find('.count').text() > 0)
    //     {
    //         $('.set_availability').show();
    //     }else{
    //         $('.set_availability').hide();
    //     }
    //     $('.edit_service').show();
    //     // $('.set_availability').show();
    //     //for active current class
    //     $(this).parent().parent().parent().parent().find('.blue-active').removeClass('blue-active');
    //     $(this).parent().parent().parent().parent().find('.active').removeClass('active');
    //     $(this).addClass('active');

    //     //bind data in edit category name
    //     $('.edit_category_name').val($(this).find('a').text());
        
    //     //parent category selected
    //     // var cat = $(this).parent().parent().find('.disflex').find('a').text();
    //     var cat = $(this).parent().parent().find('.disflex').find('a').attr('ids');
    //     var targetValue = cat;

    //     $('#parent_category_edit  option').each(function(){
    //         if (this.value == targetValue) {
    //             $('#parent_category_edit').val(targetValue);
    //         }
    //     });
    //     $('#cat_hdn_id').val($(this).attr('ids'));
    //     $('.service_name').text($(this).find('a').text());

    //     //bind value in set availability
    //     $('#hdn_cat_id').val($(this).attr('ids'));
    //     //get services from category
    //     var categories = $(this).attr('ids');
    //     $.ajax({
    //         type: "POST",
    //         headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: "{{route('services.get-services')}}",
    //         data: {// change data to this object
    //           _token : $('meta[name="csrf-token"]').attr('content'), 
    //           categories:categories
    //         },
    //         dataType: "json",
    //         success: function(res) {
                
    //             if(res.data.length > 0)
    //             {
    //                 $('.table-responsive').empty();
    //                 $('.table-responsive').append("<table class='table all-db-table align-middle table-striped' id='ser_tbl'><thead><tr><th class='blue-bold' width='75%' aria-sort='ascending'>Services in this category</th><th class='blue-bold' width='25%'>Minutes </th></tr></thead><tbody>");
    //                 $.each(res.data, function(index, res) {
    //                     var url = '{{ URL::to("services/") }}/' + res.id; // Corrected URL formatting
    //                     $('.table-striped').append("<tr><td><a href='" + url + "' style='color: #282828;'><b>" + res.service_name + "</b></a></td><td>" + res.duration + " mins</td></tr>");
    //                 });
    //                 $('.table-responsive').append("</tbody></table>");
    //             }
    //             else{
    //                 $('.table-responsive').empty();
    //             }
    //         },
    //         error: function (jqXHR, exception) {

    //        }
    //     });
    //     return false;
    // })
    $('.parent_category').click(function(){
        if($(this).find('.disflex').find('.count').text() > 0)
        {
            $('.set_availability').show();
        }
        else{
            $('.set_availability').hide();
        }
        $('.edit_service').show();
        
        //for active current class
        $(this).parent().find('.blue-active').removeClass('blue-active');
        $(this).parent().parent().parent().parent().find('.active').removeClass('active');
        $(this).addClass('blue-active');
        $(this).parent().addClass('active');

        //bind data in edit category name
        $('.edit_category_name').val($(this).find('.disflex').find('a').text());
        // $('#cat_hdn_id').val($(this).attr('ids'));
        $('#cat_hdn_id').val($(this).find('.disflex').find('a').attr('ids'));

        $('#parent_category_edit').val('0');
        $('.service_name').text($(this).find('.disflex').find('a').text());
        $('#parent_category_edit option:not(:first)').prop('disabled', true);
        //get services from category
        var categories = $(this).find('.disflex').find('a').attr('ids');
        
        //bind value in set availability
        $('#hdn_cat_id').val($(this).find('.disflex').find('a').attr('ids'));
        $.ajax({
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('services.get-services')}}",
            data: {// change data to this object
              _token : $('meta[name="csrf-token"]').attr('content'), 
              categories:categories
            },
            dataType: "json",
            success: function(res) {
                
                if(res.data.length > 0)
                {
                    $('.table-responsive').empty();
                    $('.table-responsive').append("<table class='table all-db-table align-middle table-striped'><thead><tr><th class='blue-bold' width='75%' aria-sort='ascending'>Services in this category</th><th class='blue-bold' width='25%'>Minutes </th></tr></thead><tbody>");
                    $.each(res.data, function(index, res) {
                        var url = '{{ URL::to("services/") }}/' + res.id; // Corrected URL formatting
                        var duration = res.duration != null ? res.duration : "0";
                        $('.table-striped').append("<tr><td><a href='" + url + "' style='color: #282828;'><b>" + res.service_name + "</b></a></td><td>" + duration + " mins</td></tr>");
                    });
                    $('.table-responsive').append("</tbody></table>");
                }
                else{
                    $('.table-responsive').empty();
                }
            },
            error: function (jqXHR, exception) {

           }
        });
        return false;
    })
    $(document).on('submit','#change_availability_form',function(e){
        e.preventDefault();
        var valid= $("#change_availability_form").validate();
            if(valid.errorList.length == 0){
            var data = $('#change_availability_form').serialize() ;

            // var data = new FormData(this);
            submitChangeAvailabilityForm(data);
        }
    });
    // $(document).on('blur','#category_name',function(e){
    //     var category_name = $(this).val();
    //     var url = "../services/checkCategoryName";
    //     $.ajax({
    //         type: "POST",
    //         headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: url,
    //         data: {// change data to this object
    //           _token : $('meta[name="csrf-token"]').attr('content'), 
    //           category_name:category_name
    //         },
    //         dataType: "json",
    //         success: function(res) {
    //             if(res.exists){
    //               $('#category_name').after('<p style="color:red";>Category already exist');
    //                 // alert('true');
    //             }else{
    //                 // alert('false');
    //             }
    //         },
    //         error: function (jqXHR, exception) {

    //        }
    //    });
    // })
    $(document).on('input', '#search_services', function(e) {
        
        // blue-active
        $('.ctg-tree').find('.blue-active').removeClass('blue-active');
        $('.ctg-tree').find('.active').removeClass('active');
        $('.ctg-tree').find('.white-active').addClass('blue-active');
        var search = $(this).val().toLowerCase();
        //get services from category
        var categories = 'All Services & Tasks';
        $.ajax({
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('services.get-services')}}",
            data: {// change data to this object
                _token : $('meta[name="csrf-token"]').attr('content'), 
                categories:categories,
                search:search
            },
            dataType: "json",
            success: function(res) {
                
                if(res.data.length > 0)
                {
                    $('.table-responsive').empty();
                    $('.table-responsive').append("<table class='table all-db-table align-middle table-striped service-tbl'><thead><tr><th class='blue-bold' width='75%' aria-sort='ascending'>Services in this category</th><th class='blue-bold' width='25%'>Minutes </th></tr></thead><tbody id='fbody'>");
                    $.each(res.data, function(index, res) {
                        var url = '{{ URL::to("services/") }}/' + res.id; // Corrected URL formatting
                        if(res.duration != null)
                        {
                            var dur = res.duration;
                        }else{
                            var dur = '0';
                        }
                        $('.table-striped').append("<tr><td><a href='" + url + "' style='color: #282828;'><b>" + res.service_name + "</b></a></td><td>" + dur + " mins</td></tr>");
                    });
                    $('.table-responsive').append("</tbody></table>");
                }
                else{
                    $('.table-responsive').empty();
                    $('.table-responsive').html('No results for this search.');
                }
            },
            error: function (jqXHR, exception) {

            }
        });
        
        // var value = $(this).val().toLowerCase();
        // $(".service-tbl > tbody > tr").each(function() {
        //     var rowText = $(this).text().toLowerCase();
        //     $(this).toggle(rowText.indexOf(value) > -1 || value === "");
        // });
    });
    $(document).on('change','#import_service',function(e){
        e.preventDefault();
        // var valid= $("#import_service").validate();
            // if(valid.errorList.length == 0){
            var data = new FormData(this);
            submitImportServiceForm(data);
        // }
    });
    $(document).on('click','.category_close',function(e){
        $('#category_name').val('');
    })
    $(document).on('click','.delete_category',function(e){
        var id = $('#cat_hdn_id').val();
        if(confirm("Are you sure to delete this category?")){
            $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "/delete-category/"+id,
            type: 'DELETE',
            data: {
                "id": id,
            },
                success: function(response) {
                    // Show a Sweet Alert message after the form is submitted.
                    if (response.success) {
                    Swal.fire({
                        title: "Category!",
                        text: "Your Category deleted successfully.",
                        type: "success",
                    }).then((result) => {
                                    window.location = "{{url('services')}}"//'/player_detail?username=' + name;
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
    })
    function submitCreateCategoryForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('services.store-category')}}",
            type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Category!",
						text: "Category created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('services')}}"//'/player_detail?username=' + name;
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
    function submitEditCategoryForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('services.update-category')}}",
            type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Category!",
						text: "Category updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('services')}}"//'/player_detail?username=' + name;
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
    function submitChangeAvailabilityForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('services.change-services-availability')}}",
            type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Change Availibility!",
						text: "Change availibility successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('services')}}"//'/player_detail?username=' + name;
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
    function submitImportServiceForm(data){
        
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('services.import')}}",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            success: function(response) {
                
                // Show a Sweet Alert message after the form is submitted.
                if (response.success) {
                    
                    Swal.fire({
                        title: "Service!",
                        text: "Service import successfully.",
                        type: "success",
                    }).then((result) => {
                        window.location = "{{url('services')}}";
                    });
                    
                } else {
                    
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                    }).then((result) => {
                        window.location = "{{url('services')}}";
                    });
                }
            },
        });
    }
});

</script>
@endsection