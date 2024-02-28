@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
        <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Suppliers</h4>
                </div>
                <div class="tool-right">
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-md">Create New Supplier</a>
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
                    <th>Name</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
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
    document.title='Suppliers';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('suppliers.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: function(data)
            {
                
            },
        },
        columns: [
            {data: 'business_name', name: 'business_name',
                "render": function(data, type, row, meta){
                    data = '<a class="blue-bold" href="suppliers/' + row.id + '">' + data + '</a>';
                    return data;
                }
            },
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
                { text: "Excel",exportOptions: { columns: [0] } ,extend: 'excelHtml5'},
                { text: "CSV" ,exportOptions: { columns: [0] } ,extend: 'csvHtml5'},
                { text: "PDF" ,exportOptions: { columns: [0] } ,extend: 'pdfHtml5'},
                { text: "PRINT" ,exportOptions: { columns: [0] } ,extend: 'print'},
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
});
$(document).on('click', '.dt-edit', function(e) {
      e.preventDefault();
      var ids = $(this).attr('ids');
      window.location = 'suppliers/' + ids;
    });
    $(document).on('click', '.dt-delete', function(e) {
      e.preventDefault();
        $this = $(this);
        var dtRow = $this.parents('tr');
        if(confirm("Are you sure to delete this row?")){
          $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "suppliers/"+$(this).attr('ids'),
            type: 'DELETE',
            data: {
                "id": $(this).attr('ids'),
            },
            success: function(response) {
              // Show a Sweet Alert message after the form is submitted.
              if (response.success) {
                Swal.fire({
                  title: "Supplier!",
                  text: "Supplier deleted successfully.",
                  type: "success",
                }).then((result) => {
                              window.location = "{{url('suppliers')}}"//'/player_detail?username=' + name;
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
</script>
</html>
@endsection