@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
        <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Discount Coupons</h4>
                </div>
                <div class="tool-right">
                    @if(Auth::check() && (Auth::user()->role_type == 'admin'))
                    <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#new_discount_coupons">+ New Discount Coupon</a>
                    @elseif(Auth::user()->checkPermission('discount-coupons') != 'View Only')
                    <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#new_discount_coupons">+ New Discount Coupon</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
                <div class="col-md-7">
                </div>
                <table class="table data-table all-db-table align-middle display" style="width:100%;">
                <thead>
                    <tr>
                    <th>Location Name</th>
                    <th>Discount Type</th>
                    <th>Discount Percentage</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>
    </div>
    <div class="modal fade" id="new_discount_coupons" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New Discount Coupon</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create_discount_coupons" name="create_discount_coupons" class="form">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Location Name</label>
                                <select class="form-select" id="locations" name="locations">
                                    <option selected="" value=""> -- select an option -- </option>
                                    @if(count($locations)>0)
                                        @foreach($locations as $loc)
                                            <option value="{{$loc->id}}">{{$loc->location_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Discount Type</label>
                                <input type="text" class="form-control" id="discount_type" name="discount_type" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Discount Percentage</label>
                                <input type="text" class="form-control" id="discount_percentage" name="discount_percentage" maxlength="50">
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
    <div class="modal fade" id="edit_discount_coupon" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Discount Coupons</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_discount_coupons" name="edit_discount_coupons" class="form">
                @csrf
                <input type="hidden" name="hdn_id" id="hdn_id" value="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Location Name</label>
                                <select class="form-select" id="edit_locations" name="edit_locations">
                                    <option selected="" value=""> -- select an option -- </option>
                                    @if(count($locations)>0)
                                        @foreach($locations as $loc)
                                            <option value="{{$loc->id}}">{{$loc->location_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Discount Type</label>
                                <input type="text" class="form-control" id="edit_discount_type" name="edit_discount_type" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Discount Percentage</label>
                                <input type="text" class="form-control" id="edit_discount_percentage" name="edit_discount_percentage" maxlength="50">
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
    document.title='Discount Coupons';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('discount-coupons.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: function(data)
            {
                
            },
        },
        columns: [
            {data: 'locations_names', name: 'locations_names'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'discount_percentage', name: 'discount_percentage'},
            {data: 'action', name: 'action'},
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
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                { text: "Excel",exportOptions: { columns: [0,1,2] } ,extend: 'excelHtml5'},
                { text: "CSV" ,exportOptions: { columns: [0,1,2] } ,extend: 'csvHtml5'},
                { text: "PDF" ,exportOptions: { columns: [0,1,2] } ,extend: 'pdfHtml5'},
                { text: "PRINT" ,exportOptions: { columns: [0,1,2] } ,extend: 'print'},
            ],
            dropup: true
            },
        ],
        select: {
            style : "multi",
        },
        'order': [[1, 'desc']],
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
        },
        "drawCallback": function( settings ) {
                var   api     = this.api(),
                dtInfo  = $('.dataTables_info');

                // Output the data for the visible rows to the browser's console
            //   console.log( api.rows( {page:'current'} ).data() );

                var page_info = api.rows( {page:'current'} ).data().page.info();
            //   
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
    table.select.info( false);
    $(document).on('input', '.dt-search', function()
    {
        // table.ajax.reload();//for server side
        table.search($(this).val()).draw() ;
    });
    $(document).on('change', '#pagelist', function()
    {
        var page_no = $('#pagelist').find(":selected").text();
        var table = $('.data-table').dataTable();
        table.fnPageChange(page_no - 1,true);
        // table.ajax.reload();
    });
    $("#create_discount_coupons").validate({
        rules: {
            locations: {
                required: true,
            },
            discount_type: {
                required: true,
            },
            discount_percentage: {
                required: true,
            },
            
        }
    });
    $("#edit_discount_coupons").validate({
        rules: {
            edit_locations: {
                required: true,
            },
            edit_discount_type: {
                required: true,
            },
            edit_discount_percentage: {
                required: true,
            },
        }
    });
    $(document).on('submit','#create_discount_coupons',function(e){
		e.preventDefault();
		var valid= $("#create_discount_coupons").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_discount_coupons').serialize() ;

            // var data = new FormData(this);
			submitCreateProductCategoryForm(data);
		}
	});
    $(document).on('submit','#edit_discount_coupons',function(e){
        debugger;
		e.preventDefault();
		var valid= $("#edit_discount_coupons").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_discount_coupons').serialize() ;
            var id = $('#hdn_id').val();
            // var data = new FormData(this);
			submitEditDiscountCouponsForm(data,id);
		}
	});
        // Modal close event
    $('#new_discount_coupons').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#new_discount_coupons").validate().resetForm();
    });
    $('#edit_discount_coupons').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#edit_discount_coupons").validate().resetForm();
    });
});
    $(document).on('click', '.dt-edit', function(e) {

        debugger;
      e.preventDefault();
      $('#hdn_id').val($(this).attr('ids'));
      $('#edit_locations').val($(this).attr('location_id'));
      $('#edit_discount_type').val($(this).attr('discount_type'));
      $('#edit_discount_percentage').val($(this).attr('discount_percentage'));
    //   var selectedValue = $(this).attr('parent_cat_name').trim();
    //     $('.edit_parent_category_name option').filter(function () {
    //         return $(this).text().trim() === selectedValue;
    //     }).prop('selected', true);
    });
    $(document).on('click', '.dt-delete', function(e) {
      e.preventDefault();
        $this = $(this);
        var dtRow = $this.parents('tr');
        if(confirm("Are you sure to delete this row?")){
          $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "discount-coupons/"+$(this).attr('ids'),
            type: 'DELETE',
            data: {
                "id": $(this).attr('ids'),
            },
            success: function(response) {
              // Show a Sweet Alert message after the form is submitted.
              if (response.success) {
                Swal.fire({
                  title: "Discount Coupons!",
                  text: "Discount Coupons deleted successfully.",
                  type: "success",
                }).then((result) => {
                              window.location = "{{url('discount-coupons')}}"//'/player_detail?username=' + name;
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
    function submitCreateProductCategoryForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('discount-coupons.store')}}",
            type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Discount Coupon!",
						text: "Discount Coupon created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('discount-coupons')}}"//'/player_detail?username=' + name;
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
    function submitEditDiscountCouponsForm(data,id){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: 'discount-coupons/'+id,
            type: "PUT",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Discount Coupon!",
						text: "Discount Coupon updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('discount-coupons')}}"//'/player_detail?username=' + name;
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
</script>
</html>
@endsection