@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
    <div class="card">
    @if(Auth::check() && (Auth::user()->role_type == 'admin'))
        <div class="card-head">
            <div class="toolbar">
                <div class="tool-left d-flex">
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-md icon-btn-left me-2">
                        <i class="ico-add me-2 fs-5"></i> Add One Product
                    </a>
                    <a href="{{ route('products-categories.index') }}" class="btn btn-orange btn-md icon-btn-left me-2">
                        <i class="ico-forms me-2 fs-5"></i> Categories
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-sea-green btn-md icon-btn-left me-2">
                        <i class="ico-truck me-2 fs-4"></i> Suppliers
                    </a>
                    <form id="import_product" name="import_product" class="form d-flex align-items-center">
                        @csrf
                        <label for="import" class="btn btn-primary btn-md icon-btn-left me-2">
                            <i class="ico-import me-2 fs-4"></i> Import a Product List
                        </label>
                        <a href="{{ asset('/storage/csv_files/sample_products.csv') }}" class="simple-link">Download sample file</a>
                        <input type="file" id="import" name="csv_file" style="display:none;" accept=".csv">
                    </form>
                </div>
                <div class="tool-right">
                    <!-- <a href="#" class="btn icon-btn-left btn-md btn-light-grey"><i class="ico-filter me-2 fs-6"></i> Filter By</a> -->
                </div>
            </div>
        </div>
    @else
    <div class="card-head">
        <div class="toolbar">
            <div class="tool-left d-flex">
                @if(Auth::user()->checkPermission('products') != 'View Only')
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-md icon-btn-left me-2">
                        <i class="ico-add me-2 fs-5"></i> Add One Product
                    </a>
                    <a href="{{ route('products-categories.index') }}" class="btn btn-orange btn-md icon-btn-left me-2">
                        <i class="ico-forms me-2 fs-5"></i> Categories
                    </a>
                @else
                    <a href="{{ route('products-categories.index') }}" class="btn btn-orange btn-md icon-btn-left me-2">
                        <i class="ico-forms me-2 fs-5"></i> Categories
                    </a>
                @endif
                @if(Auth::user()->checkPermission('suppliers') != 'No permission')
                    <a href="{{ route('suppliers.index') }}" class="btn btn-sea-green btn-md icon-btn-left me-2">
                        <i class="ico-truck me-2 fs-4"></i> Suppliers
                    </a>
                @endif
                @if(Auth::user()->checkPermission('products') != 'View Only')
                <form id="import_product" name="import_product" class="form d-flex align-items-center">
                    @csrf
                    <label for="import" class="btn btn-primary btn-md icon-btn-left me-2">
                        <i class="ico-import me-2 fs-4"></i> Import a Product List
                    </label>
                    <a href="{{ asset('/storage/csv_files/sample_products.csv') }}" class="simple-link">Download sample file</a>
                    <input type="file" id="import" name="csv_file" style="display:none;" accept=".csv">
                </form>
                @endif
            </div>
            <div class="tool-right">
                <!-- <a href="#" class="btn icon-btn-left btn-md btn-light-grey"><i class="ico-filter me-2 fs-6"></i> Filter By</a> -->
            </div>
        </div>
    </div>
    @endif
        <div class="card-head">
            <h4 class="small-title mb-3">Products Summary</h4>
            
            <ul class="taskinfo-row">
                @php
                $products = \App\Models\Products::get();
                @endphp 
                <li>
                    <div class="font-24 mb-1">{{count($products)}}</div>
                    <b class="d-grey">Total Products</b>
                </li>
                @php
                $categories = \App\Models\ProductsCategories::get();
                @endphp
                <li>
                    <div class="font-24 mb-1">{{count($categories)}}</div>
                    <b class="text-succes-light">Total Categories </b>
                </li>
                @php
                $suppliers = \App\Models\Suppliers::get();
                @endphp 
                <li>
                    <div class="font-24 mb-1">{{count($suppliers)}}</div>
                    <b class="text-danger">Total Suppliers</b>
                </li>
            </ul>
        </div>
        <!-- <div class="card-head py-3">
            <div class="toolbar">
                <div class="tool-left d-flex align-items-center ">
                    <div class="cst-drop-select me-3"><select class="location">
                        <option>Edit</option>
                        <option>Category</option>
                        <option>Availability</option>
                        <option>Min/Max Stocks Level</option>
                    </select></div>
                </div>
            </div>
        </div> -->
        <div class="card-body">
        <div class="row">
                <table class="table data-table all-db-table align-middle display" style="width:100%;">
                <thead>
                    <tr>
                    <th>
                        <label class="cst-check blue">
                            @if ($permission != 'View Only')
                            <input type="checkbox" id="select-all"class="checkbox">
                            @else
                            <input type="checkbox" id="select-all"class="checkbox" disabled>
                            @endif
                            <span class="checkmark"></span>
                        </label>
                    </th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price ($ Inc GST)</th>
                    <th>Cost ($ Exc GST)</th>
                    <th>Margin (%)</th>
                    <th>On Hand</th>
                    <th>On Hand($)</th> 
                    <th>Suppliers</th>
                    <th>Supplier Code</th>
                    <th>Category</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>
    </div>

<div id="new_category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">New Category</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update_product_category" name="update_product_category" class="form">
            @csrf
            <input type="hidden" name="products_id" id="products_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <select class="form-select form-control" id="category_name" name="category_name" maxlength="50">
                                <option selected value="" > -- select an option -- </option>
                                @if(count($all_product_categories)>0)
                                    @foreach($all_product_categories as $cats)
                                            <option value="{{$cats->id}}">{{$cats->category_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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
        <form id="change_product_availability" name="change_product_availability" class="form">
            @csrf
            <input type="hidden" name="prds_id" id="prds_id" value="">
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
<div class="modal fade" id="Change_min_max" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Change min/max for selected products</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="change_min_max_form" name="change_min_max_form" class="form">
        @csrf
        <input type="hidden" name="hdn_id" id="hdn_id">
        <div class="modal-body">
            
            <div class="row">
            
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <label class="form-label">Min</label>
                    <input type="text" class="form-control" placeholder="-" name="min_price" id="min_price" maxlength="5">
                    </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <label class="form-label">Max </label>
                    <input type="text" class="form-control" placeholder="-" name="max_price" id="max_price" maxlength="5">
                    </div>
            </div>
            <div class="col-auto mt-5">
                <input type="hidden" name="loc_status" id="loc_status" value="0">
                <label class="cst-check"><input type="checkbox" value="1" id="set_loc" name="loc_status"><span class="checkmark me-2"></span> Set differently by location</label>
            </div>

        </div>

        <div class="table-responsive mt-3">
            <table class="table align-middle mb-0 set_locations_data" style="display:none;">
                <thead>
                    <tr>
                        <th colspan="2">Set location min/max overrides	</th>
                        <th>Min</th>
                        <th>Max</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($locations) > 0)
                    @foreach($locations as $index => $loc)
                    <tr>
                        <td width="3%">
                            <!-- <input type="hidden" name="locations_availability[]" value="{{$loc->location_name}}"> -->
                            <label class="cst-check check_value"><input type="checkbox" value="{{$loc->id}}" checked name="locations_availability[]"><span class="checkmark"></span></label>
                        </td>
                        <td width="65%"> {{$loc->location_name}}</td>
                        <td class="ava_check"><input type="text" class="form-control" placeholder="-" id="min_price" name="availability_min[]" maxlength="5" > </td>
                        
                        <td class="ava_check"> <input type="text" class="form-control" placeholder="-" id="max_price" name="availability_max[]" maxlength="5" ></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light btn-md cancel_min_max">Cancel</button>
            <button type="submit" class="btn btn-primary btn-md">Save</button>
        </div>
        </form>
    </div>
    </div>
</div>
<div class="modal fade" id="Product_Performance" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title me-3">Product Performance</h4> 
        @if ($permission != 'View Only')
        <a href="{{ route('products.show', ['product' => ':productId']) }}" class="simple-link p_details">Product Details</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="invo-notice mb-3">
                <div class="inv-left"><b class="product_detail_name">Test products</b></div>
                
            </div>
            
            <table class="table all-db-table align-middle w-50">
                <tr>
                    <td><b>Price(incl. GST)</b></td>
                    <td class="product_detail_price_inc_gst">$19.00</td>
                </tr>
                <tr>
                    <td><b>Price(excl. GST)</b></td>
                    <td class="product_detail_price_exc_gst">$19.00</td>
                </tr>
                <tr>
                    <td><b>Cost</b></td>
                    <td class="product_detail_cost">$19.00</td>
                </tr>
                <tr>
                    <td><b>Margin($)</b></td>
                    <td class="product_detail_margin_dollar">$19.00</td>
                </tr>
                <tr>
                    <td><b>Margin(%)</b></td>
                    <td class="product_detail_margin_per">$19.00</td>
                </tr>
            </table>
            
            <div class="table-responsive">
                <table class="table all-db-table align-middle">
                    <thead>
                    <tr>
                        <th class="mine-shaft" width="45%" ></th>
                        <th class="mine-shaft" width="30%" aria-sort="ascending">Stock on hand (Units)</th>
                        <th class="mine-shaft" width="25%">Stock on hand (Value)</th>
                        
                    </tr>
                </thead>
                <tbody class="prod_details">
                    <tr>
                        <td><b>Total</b></td>
                        <td><span class="blue-bold">$0.00 </span></td>
                        <!-- <td><span class="blue-bold">$0.00 </span></td> -->
                    </tr>
                    <tr>
                        <td>item1</td>
                        <td class="product_quantitity">0</td>
                        <!-- <td>$0.00</td> -->
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal" aria-label="Close">Close</button>
        </div>
    </div>
    </div>
</div>
<!-- </main> -->
     
@stop
@section('script')
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {
    $('.cancel_form').click(function(){
        $('#change_Availability').modal('toggle');
    })
    $('.cancel_min_max').click(function(){
        $('#change_min_max_form')[0].reset();
        $('.set_locations_data').hide();
        $('#Change_min_max').modal('toggle');
    })
    $(document).on("input", "#min_price", function() {
        this.value = this.value.replace(/\D/g,'');
    });
    $(document).on("input", "#max_price", function() {
        this.value = this.value.replace(/\D/g,'');
    });

    $('.check_value').click(function(){
        if (!$(this).find('input').is(':checked')) {
            $(this).parent().parent().find('.ava_check').hide();
        }else{
            $(this).parent().parent().find('.ava_check').show();
        }
    })
    $("#update_product_category").validate({
        rules: {
            category_name: {
                required: true,
            }
        }
    });
    $('#set_loc').click(function(){
        if (!$(this).is(':checked')) {
            $('.set_locations_data').hide();
        }
        else{
            $('.set_locations_data').show();
        }
    })

    $('#select-all').on('change', function () {
        // Select or deselect all checkboxes based on the 'select-all' checkbox state
        $('.data-table td:first-child input[type="checkbox"]').prop('checked', this.checked);
        // Update DataTable's selected rows
        table.rows().select(this.checked);
    });


    document.title='Products';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('products.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            {
            data: null,
                "render": function(data, type, row, meta){
                    var link = ''; // Initialize link variable
                    // Check permission here
                    if ("{{ $permission }}" != 'View Only') {
                        // Permission allows viewing
                        link = '<label class="cst-check blue"><input type="checkbox" data-ids="' + row.id + '" id="select-all" class="checkbox checked_data"><span class="checkmark"></span></label>';
                        return link;
                    } else {
                        // Permission does not allow viewing
                        link = '<label class="cst-check blue"><input type="checkbox" data-ids="' + row.id + '" id="select-all" class="checkbox checked_data" disabled><span class="checkmark"></span></label>';
                        return link;
                    }
                    return link;
                    },
                orderable: false,
            },
            {
                data: 'product_name', name: 'product_name',
                "render": function(data, type, row, meta){
                    var link = ''; // Initialize link variable
                    // Check permission here
                    if ("{{ $permission }}" != 'View Only') {
                        // Permission allows viewing
                        link = '<a class="blue-bold" href="products/' + row.id + '">' + data + '</a>';
                        return link;
                    } else {
                        // Permission does not allow viewing
                        link = '<a class="blue-bold" href="javascript:void(0);">' + data + '</a>';
                        return link;
                    }
                    return link;
                }
            },
            {data: 'type', name: 'type'},
            {data: 'price', name: 'price'},
            {data: 'cost', name: 'cost'},
            // {data: 'margin', name: 'margin'},
            {
                data: 'margin', 
                name: 'margin',
                render: function(data, type, row, meta) {
                    return parseFloat(data).toFixed(2); // Format to 2 decimal places
                }
            },
            {data: 'on_hand', name: 'on_hand'},
            {data: 'on_hand_price', name: 'on_hand_price'},
            {data: 'supplier_name', name: 'supplier_name'},
            { data: 'supplier_code', name: 'supplier_code'},
            {data: 'category_name', name: 'category_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "dom": 'Blrftip',
        "language": {
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search...",
            "infoFiltered": "", 
        },
        "paging": true,
        "pageLength": 10,
        "autoWidth": true,
        'columnDefs': [{
            // "targets": [0],
            'orderable': false,
        }],
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                { text: "Excel",exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10] } ,extend: 'excelHtml5'},
                { text: "CSV" ,exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10] } ,extend: 'csvHtml5'},
                { text: "PDF" ,exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10] } ,extend: 'pdfHtml5'},
                { text: "PRINT" ,exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10] } ,extend: 'print'},
            ],
            dropup: true
            },
            {
                extend: 'collection',
                text: '<i class="fa fa-edit"></i> Edit',
                buttons: [
                    {
                        text: "Category",
                        className: 'copyButton',
                        action: function () {
                            var checkedArr = [];
                            $(".checked_data").each(function () {
                                if ($(this).is(":checked")) {
                                    // If checkbox is checked, add its value to the array
                                    checkedArr.push($(this).attr('data-ids'));
                                }
                            });
                            console.log('test',checkedArr);
                            $('#products_id').val(checkedArr);
                            $('#new_category').modal('show');
                            $('.dt-button-collection').hide();
                        },
                    },
                    { 
                        text: "Availability",
                        action: function () {
                            var checkedArr = [];
                            $(".checked_data").each(function () {
                                if ($(this).is(":checked")) {
                                    // If checkbox is checked, add its value to the array
                                    checkedArr.push($(this).attr('data-ids'));
                                }
                            });
                            console.log('test',checkedArr);
                            $('#prds_id').val(checkedArr);
                            $('#change_Availability').modal('show');
                            $('.dt-button-collection').hide();
                        }
                    },
                    { 
                        text: "Min/Max Stocks Level",
                        action: function () {
                            var checkedArr = [];
                            $(".checked_data").each(function () {
                                if ($(this).is(":checked")) {
                                    // If checkbox is checked, add its value to the array
                                    checkedArr.push($(this).attr('data-ids'));
                                }
                            });
                            console.log('test',checkedArr);
                            $('#hdn_id').val(checkedArr);
                            $('#Change_min_max').modal('show');
                            $('.dt-button-collection').hide();
                        }
                    },
                ],
                dropup: true,
            },
            {
                text: '<i class="ico-trash fs-5 text-light-red btn-default-delete"></i>', // Delete icon
                className: '',
                action: function (e, dt, node, config) {
                    var checkedArr = [];
                    $(".checked_data").each(function () {
                        if ($(this).is(":checked")) {
                            // If checkbox is checked, add its value to the array
                            checkedArr.push($(this).attr('data-ids'));
                        }
                    });
                    console.log('test',checkedArr);

                    // $this = $(this);
                    // var dtRow = $this.parents('tr');
                    if(confirm("Are you sure to delete this row?")){
                        $.ajax({
                        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: "products/"+checkedArr,
                        type: 'DELETE',
                        data: {
                            "id": checkedArr,
                        },
                        success: function(response) {
                            // Show a Sweet Alert message after the form is submitted.
                            if (response.success) {
                            Swal.fire({
                                title: "Product!",
                                text: "Your Product deleted successfully.",
                                icon: "success",
                            }).then((result) => {
                                            window.location = "{{url('products')}}"//'/player_detail?username=' + name;
                                        });
                            } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                            });
                            }
                        },
                        });
                        var table = $('#example').DataTable();
                        // table.row(dtRow[0].rowIndex-1).remove().draw( false );
                    }
                },
            },

        ],
        select: {
            style : "multi",
            selector: 'td:first-child input[type="checkbox"]', // Update the selector
        },
        // 'order': [[0, 'desc']],
        initComplete: function () {
            var btns = $('.dt-buttons'),
                dtFilter = $('.dataTables_filter'),
                dtInfo  = $('.dataTables_info'),
                api     = this.api(),
                page_info = api.rows( {page:'current'} ).data().page.info(),
                length = page_info.length,
                start = 0;
                

            var pageInfoHtml = `
                <div class="dt-page-jump">
                    <select name="pagelist" id="pagelist" class="pagelist">
            `;
            
            for(var count = 1; count <= page_info.pages; count++)
            {
                var page_number = count - 1;

                pageInfoHtml += `<option value="${page_number}" data-start="${start}" data-length="${length}">${count}</option>`;

                start = start + page_info.length;
            }
            
            pageInfoHtml += `</select></div>`;
                
            dtFilter.find('label').remove();
            
            dtFilter.html(
            `
            <label>
                <div class="input-group search">
                    <span class="input-group-addon">
                        <span class="ico-mini-search"></span>
                    </span>
                    <input type="search" class="form-control input-sm dt-search" placeholder="Search..." aria-controls="example">
                </div>
            </label>
            `);
            
            $(pageInfoHtml).insertAfter(dtInfo);
            btns.addClass('btn-group');
            btns.find('button').removeAttr('class');
            btns.find('button').addClass('btn btn-default buttons-collection');
            $.each(btns.find('button'), function(index, button) {
                if(index==2)
                {
                    $(this).addClass('btn-default-delete');
                }
            });

        },
        "drawCallback": function( settings ) {
            var   api     = this.api(),
            dtInfo  = $('.dataTables_info');
            var page_info = api.rows( {page:'current'} ).data().page.info();
            $('#totalpages').text(page_info.pages);
            var html = '';

            var start = 0;

            var length = page_info.length;

            for(var count = 1; count <= page_info.pages; count++)
            {
            var page_number = count - 1;

            html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';

            start = start + page_info.length;
            }

            $('#pagelist').html(html);

            $('#pagelist').val(page_info.page);
        }
    });
    // table.column(6).search('checked', true, false).draw();
    $(document).on('input', '.dt-search', function()
    {
        table.search($(this).val()).draw() ;
    });
    $(document).on('change', '#pagelist', function()
    {
        var page_no = $('#pagelist').find(":selected").text();
        var table = $('.data-table').dataTable();
        table.fnPageChange(page_no - 1,true);
    });
    $(document).on('submit','#update_product_category',function(e){
		e.preventDefault();
		var valid= $("#update_product_category").validate();
			if(valid.errorList.length == 0){
			var data = $('#update_product_category').serialize() ;

            // var data = new FormData(this);
			submitUpdateProductCategoryForm(data);
		}
	});
    $(document).on('submit','#change_min_max_form',function(e){
		e.preventDefault();
		// var valid= $("#change_min_max_form").validate();
			// if(valid.errorList.length == 0){
			var data = $('#change_min_max_form').serialize() ;

            // var data = new FormData(this);
			submitMinMaxForm(data);
		// }
	});
    
    $(document).on('submit','#change_product_availability',function(e){
        e.preventDefault();
        var valid= $("#change_product_availability").validate();
            if(valid.errorList.length == 0){
            var data = $('#change_product_availability').serialize() ;
            submitChangeProductAvailabilityForm(data);
        }
    });

    //default edit button disabled
    $('.fa-edit').parent().parent().attr('disabled',true);
    //default delete icon disabled
    $('.ico-trash').parent().parent().attr('disabled',true);
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    var ids = $(this).attr('ids');
    window.location = 'products/' + ids;
});
$(document).on('click', '#select-all', function (e) {
    if ($(this).is(':checked')) {
        // Default edit button enabled
        $('.fa-edit').parent().parent().prop('disabled', false);
        // Default delete icon enabled
        $('.ico-trash').parent().parent().prop('disabled', false);
    } else {
        var anyCheckboxChecked = false;

        $('.checkbox').each(function (key, element) {
            if ($(element).is(':checked')) {
                // At least one checkbox is checked
                console.log('Checkbox is checked.');
                anyCheckboxChecked = true;
                return false;  // Stop the iteration, as we only need to know if any checkbox is checked
            }
        });

        // Enable or disable based on the variable
        if (anyCheckboxChecked) {
            $('.fa-edit').parent().parent().prop('disabled', false);
            $('.ico-trash').parent().parent().prop('disabled', false);
        } else {
            // No checkbox is checked
            $('.fa-edit').parent().parent().prop('disabled', true);
            $('.ico-trash').parent().parent().prop('disabled', true);
        }
    }
});

// Additional code to handle the case where all checkboxes are unchecked
$(document).on('change', '.checkbox', function() {
    if (!$('.checkbox:checked').length) {
        $('.fa-edit').parent().parent().prop('disabled', true);
        $('.ico-trash').parent().parent().prop('disabled', true);
    }
});
$(document).on('change','#import_product',function(e){
    e.preventDefault();
    var data = new FormData(this);
    submitImportProductForm(data);
});
$(document).on('click','.product_statistics',function(e){
    var id = $(this).attr('ids');

    var route = "{{ route('products.show', ['product' => ':productId']) }}";
    
    // Replace ':productId' in the route string with the actual product ID
    var updatedRoute = route.replace(':productId', id);
    
    // Update the href attribute of the anchor tag
    $('.p_details').attr('href', updatedRoute);

    $('#Product_Performance').modal('show');
    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.product-performance')}}",
        type: "post",
        data: {id:id},
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                $('.product_detail_name').text(response.data.product_name);
                $('.product_detail_price_inc_gst').text('$'+response.data.price);
                $('.product_detail_price_exc_gst').text('$' + (response.data.price - (response.data.price / 11).toFixed(2)).toFixed(2));
                $('.product_detail_cost').text('$'+response.data.cost);
                $('.product_detail_margin_dollar').text('$'+parseFloat(response.data.price - (response.data.price / 11) - response.data.cost).toFixed(2));
                $('.product_detail_margin_per').text(parseFloat(response.data.product_margin).toFixed(2));

                // Clear existing tbody content
                $('.prod_details').empty();

                // Calculate total quantity and price
                var totalQuantity = response.productQuantities.reduce((acc, val) => acc + (parseInt(val) || 0), 0);
                var totalPrice = response.productPrice.reduce((acc, val) => acc + (parseFloat(val) || 0), 0);

                // Append total row
                var totalRow = '<tr><td><b>Total</b></td><td class="total_quantity">' + totalQuantity + '</td><td class="total_price">$' + totalPrice.toFixed(2) + '</td></tr>';
                $('.prod_details').append(totalRow);

                // Append rows for each product location
                for (var i = 0; i < response.productLocations.length; i++) {
                    var location = response.productLocations[i];
                    var quantity = parseInt(response.productQuantities[i]) || 0;
                    var price = parseFloat(response.productPrice[i]) || 0;
                    var productStatus = response.productStatus[i];

                    // Check if product status is "Available"
                    if (productStatus === "Available") {
                        var row = '<tr><td>' + location + '</td><td class="product_quantity">' + quantity + '</td><td class="product_price">$' + price.toFixed(2) + '</td></tr>';
                        $('.prod_details').append(row);
                    } else {
                        // If product status is not "Available", do not display quantity and price
                        var row = '<tr><td>' + location + '</td><td class="product_quantity">Not Available</td><td class="product_price"></td></tr>';
                        $('.prod_details').append(row);
                    }
                }
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
})
function submitUpdateProductCategoryForm(data){
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.update-product-category')}}",
        type: "post",
        data: data,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Product Category!",
                    text: "Product Category updated successfully.",
                    icon: "success",
                }).then((result) => {
                    // $('.data-table').DataTable().ajax.reload();
                    // $('#new_category').modal('hide');
                    window.location = "{{url('products')}}"//'/player_detail?username=' + name;
                });
                
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
}
function submitChangeProductAvailabilityForm(data){
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.change-product-availability')}}",
        type: "post",
        data: data,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Product Availability!",
                    text: "Product Availability updated successfully.",
                    icon: "success",
                }).then((result) => {
                    // $('.data-table').DataTable().ajax.reload();
                    // $('#new_category').modal('hide');
                    window.location = "{{url('products')}}"//'/player_detail?username=' + name;
                });
                
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
}
function submitMinMaxForm(data){
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.update-stocks-level-products')}}",
        type: "post",
        data: data,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Stock Level!",
                    text: "Stock Level updated successfully.",
                    icon: "success",
                }).then((result) => {
                    // $('.data-table').DataTable().ajax.reload();
                    // $('#new_category').modal('hide');
                    window.location = "{{url('products')}}"//'/player_detail?username=' + name;
                });
                
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
}
function submitImportProductForm(data){
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.import')}}",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Product!",
                    text: "Product import successfully.",
                    icon: "success",
                }).then((result) => {
                    window.location = "{{url('products')}}";
                });
                
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                }).then((result) => {
                    window.location = "{{url('products')}}";
                });
            }
        },
    });
}
</script>
</html>
@endsection