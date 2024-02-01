@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
    <div class="card">
    <div class="card-head">
    <div class="toolbar">
        <div class="tool-left d-flex">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-md icon-btn-left me-2"><i class="ico-add me-2 fs-5"></i> Add One Product</a>
            <a href="#" class="btn btn-primary btn-md icon-btn-left me-2"><i class="ico-import me-2 fs-4"></i> Import a Product List</a>
            <a href="{{ route('products-categories.index') }}" class="btn btn-orange btn-md icon-btn-left me-2"><i class="ico-forms me-2 fs-5"></i> Categories</a>
            <a href="{{ route('suppliers.index') }}" class="btn btn-sea-green btn-md icon-btn-left me-2"><i class="ico-truck me-2 fs-4"></i> Suppliers</a>
        </div>
        <div class="tool-right">
            <a href="#" class="btn icon-btn-left btn-md btn-light-grey"><i class="ico-filter me-2 fs-6"></i> Filter By</a>
        </div>
    </div>
    </div>
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
                <table class="table data-table all-db-table align-middle display">
                <thead>
                    <tr>
                    <th>
                        <label class="cst-check">
                            <input type="checkbox" id="select-all"class="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price ($ Inc GST)</th>
                    <th>Cost ($ Exc GST)</th>
                    <th>Margin</th>
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
                                <option selected value="(top-level)" > -- select an option -- </option>
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
                            <input type="hidden" name="locs_name[]" value="{{$loc->location_name}}">
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
        <form id="change_availability_form" name="change_availability_form" class="form">
        @csrf
        <div class="modal-body">
            
            <div class="row">
            
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <label class="form-label">Min</label>
                    <input type="text" class="form-control" placeholder="-">
                    </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <label class="form-label">Max </label>
                    <input type="text" class="form-control" placeholder="-">
                    </div>
            </div>
            <div class="col-auto mt-5">
                <label class="cst-check"><input type="checkbox" value="" id="set_loc"><span class="checkmark me-2"></span> Set differently by location</label>
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
                            <label class="cst-check"><input type="checkbox" value=""><span class="checkmark"></span></label>
                        </td>
                        <td width="65%"> {{$loc->location_name}}</td>
                        <td><input type="text" class="form-control" placeholder="-"> </td>
                        
                        <td> <input type="text" class="form-control" placeholder="-"></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light btn-md">Cancel</button>
            <button type="button" class="btn btn-primary btn-md">Save</button>
        </div>
        </form>
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
    
    $('#set_loc').click(function(){
        debugger;
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
                        data = '<label class="cst-check"><input type="checkbox" data-ids="' + row.id + '" id="select-all" class="checkbox checked_data"><span class="checkmark"></span></label>';
                        return data;
                    },
                orderable: false,
            },
            {data: 'product_name', name: 'product_name'},
            {data: 'type', name: 'type'},
            {data: 'price', name: 'price'},
            {data: 'cost', name: 'cost'},
            {data: 'margin', name: 'margin'},
            {"defaultContent": ""},//{data: 'id', name: 'id'},//appointment date
            {"defaultContent": ""},//{data: 'id', name: 'id'},//appointment date
            {data: 'supplier_name', name: 'supplier_name'},
            { data: 'supplier_code', name: 'supplier_code'},
            {data: 'category_name', name: 'category_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "dom": 'Blrftip',
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
                { text: "Excel",exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,extend: 'excelHtml5'},
                { text: "CSV" ,exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,extend: 'csvHtml5'},
                { text: "PDF" ,exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,extend: 'pdfHtml5'},
                { text: "PRINT" ,exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,extend: 'print'},
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
                            debugger;
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
                            debugger;
                            var checkedArr = [];
                            $(".checked_data").each(function () {
                                if ($(this).is(":checked")) {
                                    // If checkbox is checked, add its value to the array
                                    checkedArr.push($(this).attr('data-ids'));
                                }
                            });
                            console.log('test',checkedArr);
                            $('#products_id').val(checkedArr);
                            $('#change_Availability').modal('show');
                            $('.dt-button-collection').hide();
                        }
                    },
                    { 
                        text: "Min/Max Stocks Level",
                        action: function () { 
                            debugger;
                            var checkedArr = [];
                            $(".checked_data").each(function () {
                                if ($(this).is(":checked")) {
                                    // If checkbox is checked, add its value to the array
                                    checkedArr.push($(this).attr('data-ids'));
                                }
                            });
                            console.log('test',checkedArr);
                            $('#products_id').val(checkedArr);
                            $('#Change_min_max').modal('show');
                            $('.dt-button-collection').hide();
                        }
                    },
                ],
                dropup: true
            },
            {
                text: '<i class="ico-trash fs-5 text-light-red"></i>', // Delete icon
                className: 'btn btn-default-delete',
                action: function (e, dt, node, config) {
                    // Define the action you want to perform when the icon is clicked
                    // For example, you can trigger a delete action here
                    alert('Delete icon clicked!');
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
                <div class="input-group">
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
    $(document).on('keyup', '.dt-search', function()
    {
        table.search($(this).val()).draw() ;
    });
    $(document).on('change', '#pagelist', function()
    {
        var page_no = $('#pagelist').find(":selected").text();
        var table = $('.data-table').dataTable();
        table.fnPageChange(page_no - 1,true);
    });

    $(document).on('submit','#update_product_category',function(e){debugger;
        e.preventDefault();
        var valid= $("#update_product_category").validate();
            if(valid.errorList.length == 0){
            var data = $('#update_product_category').serialize() ;
            submitUpdateProductCategoryForm(data);
        }
    });
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    var ids = $(this).attr('ids');
    window.location = 'products/' + ids;
});
$(document).on('click', '.dt-delete', function(e) {
    e.preventDefault();
    $this = $(this);
    var dtRow = $this.parents('tr');
    if(confirm("Are you sure to delete this row?")){
        $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "email-templates/"+$(this).attr('ids'),
        type: 'DELETE',
        data: {
            "id": $(this).attr('ids'),
        },
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
            Swal.fire({
                title: "Email Template!",
                text: "Your Email Template deleted successfully.",
                type: "success",
            }).then((result) => {
                            window.location = "{{url('email-templates')}}"//'/player_detail?username=' + name;
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
        var table = $('#example').DataTable();
        table.row(dtRow[0].rowIndex-1).remove().draw( false );
    }
});
function submitUpdateProductCategoryForm(data){
    debugger;
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('products.update-product-category')}}",
        type: "post",
        // contentType: 'multipart/form-data',
        // cache: false,
        // contentType: false,
        // processData: false,
        data: data,
        success: function(response) {
            debugger;
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Product Category!",
                    text: "Product Category updated successfully.",
                    type: "success",
                }).then((result) => {
                    window.location = "{{url('products')}}"//'/player_detail?username=' + name;
                });
                
            } else {
                debugger;
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    type: "error",
                });
            }
        },
    });
}
</script>
</html>
@endsection