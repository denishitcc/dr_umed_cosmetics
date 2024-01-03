@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
<!-- <main> -->
    <div class="card">
        <div class="card-head">
        <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Email Templates</h4>
                </div>
                <div class="tool-right">
                    <a href="{{ route('email-templates.create') }}" class="btn btn-primary btn-md">Add Email</a>
                </div>
            </div>
            
        </div>
        
        <div class="card-body">
        <div class="row">
                <div class="col-md-7">
                </div>
                <table class="table data-table all-db-table align-middle display">
                <thead>
                    <tr>
                    <!-- <th>
                    </th> -->
                    <th>Email Template Type</th>
                    <th>Subject</th>
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
    document.title='Users';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('email-templates.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            // {data: '', name: ''},
            {data: 'email_template_type', name: 'email_template_type'},
            {data: 'subject', name: 'subject'},
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
            btns.find('button').addClass('btn btn-default buttons-collection btn-default-dt-options');
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
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    debugger;
    var ids = $(this).attr('ids');
    window.location = 'email-templates/' + ids;
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
</script>
</html>
@endsection