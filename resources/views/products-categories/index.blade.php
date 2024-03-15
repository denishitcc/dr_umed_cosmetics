@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
        <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Product Categories</h4>
                </div>
                <div class="tool-right">
                    <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#new_Category">+ New Category</a>
                    <!-- <a href="#" class="btn btn-primary btn-md">Back to Products Categories</a> -->
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-md">Back to Products</a>
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
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>
    </div>
    <div class="modal fade" id="new_Category" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New Category</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create_product_category" name="create_product_category" class="form">
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Sub Category Name</label>
                                <input type="text" class="form-control" id="sub_category_name" name="sub_category_name" maxlength="50">
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
    <div class="modal fade" id="edit_product_Category" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Category</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_product_category" name="edit_product_category" class="form">
                @csrf
                <input type="hidden" name="cat_hdn_id" id="cat_hdn_id" value="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control edit_product_category_name" id="category_name" name="category_name" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Sub Category Name</label>
                                <input type="text" class="form-control edit_parent_category_name" id="sub_category_name" name="sub_category_name" maxlength="50">
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
    document.title='Product categories';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('products-categories.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: function(data)
            {
                
            },
        },
        columns: [
            {data: 'category_name', name: 'category_name'},
            {data: 'sub_category_name', name: 'sub_category_name'},
            {data: 'action', name: 'action'},
        ],
        "dom": 'Blrftip',
        "paging": true,
        "pageLength": 10,
        "autoWidth": true,
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                { text: "Excel",exportOptions: { columns: [0,1] } ,extend: 'excelHtml5'},
                { text: "CSV" ,exportOptions: { columns: [0,1] } ,extend: 'csvHtml5'},
                { text: "PDF" ,exportOptions: { columns: [0,1] } ,extend: 'pdfHtml5'},
                { text: "PRINT" ,exportOptions: { columns: [0,1] } ,extend: 'print'},
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
    $("#create_product_category").validate({
        rules: {
            category_name: {
                required: true,
            }
        }
    });
    $("#edit_product_category").validate({
        rules: {
            category_name: {
                required: true,
            }
        }
    });
    $(document).on('submit','#create_product_category',function(e){
		e.preventDefault();
		var valid= $("#create_product_category").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_product_category').serialize() ;

            // var data = new FormData(this);
			submitCreateProductCategoryForm(data);
		}
	});
    $(document).on('submit','#edit_product_category',function(e){
		e.preventDefault();
		var valid= $("#edit_product_category").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_product_category').serialize() ;
            var id = $('#cat_hdn_id').val();
            // var data = new FormData(this);
			submitEditProductCategoryForm(data,id);
		}
	});
        // Modal close event
    $('#new_Category').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#new_Category").validate().resetForm();
    });
    $('#edit_product_Category').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#edit_product_Category").validate().resetForm();
    });
});
    $(document).on('click', '.dt-edit', function(e) {
        
      e.preventDefault();
      $('#cat_hdn_id').val($(this).attr('ids'));
      $('.edit_product_category_name').val($(this).attr('cat_name'));
      $('.edit_parent_category_name').val($(this).attr('parent_cat_name'));
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
            url: "products-categories/"+$(this).attr('ids'),
            type: 'DELETE',
            data: {
                "id": $(this).attr('ids'),
            },
            success: function(response) {
              // Show a Sweet Alert message after the form is submitted.
              if (response.success) {
                Swal.fire({
                  title: "Product Category!",
                  text: "Product Category deleted successfully.",
                  type: "success",
                }).then((result) => {
                              window.location = "{{url('products-categories')}}"//'/player_detail?username=' + name;
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
			url: "{{route('products-categories.store')}}",
            type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Product Category!",
						text: "Product Category created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('products-categories')}}"//'/player_detail?username=' + name;
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
    function submitEditProductCategoryForm(data,id){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: 'products-categories/'+id,
            type: "PUT",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Category!",
						text: "Category updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('products-categories')}}"//'/player_detail?username=' + name;
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