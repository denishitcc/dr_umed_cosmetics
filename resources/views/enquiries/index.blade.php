@extends('layouts/sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
  <!-- <main> -->
          <div class="card">
              <div class="card-head">
              <div class="toolbar">
                <div class="tool-left">
                    <a href="{{ route('enquiries.create') }}" class="btn btn-primary btn-md me-2">New Enquiry</a>
                    <!-- <a href="#" class="btn btn-primary btn-md">Import Enquiry</a> -->
                </div>
                <!-- <div class="tool-right">
                    <a href="#" class="btn tag icon-btn-left btn-md btn-light-grey"><i class="ico-filter me-2 fs-6"></i> Filter By</a>
                </div> -->
            </div>
                
        </div>
        <div class="card-head pt-3">
            <h4 class="small-title mb-3">Enquiries Summary</h4>
            
            <ul class="taskinfo-row">
                <li>
                    <div class="font-24 mb-1">{{count($enquiries)}}</div>
                    <b class="d-grey">Total Enquiries</b>
                </li>
                <li>
                    @php
                    $follow_up_done = \App\Models\Enquiries::where(['enquiry_status' => 'Follow Up Done'])->get();
                    @endphp
                <div class="font-24 mb-1">{{count($follow_up_done)}}</div>
                    <b class="text-succes">Follow Up Done </b>
                </li>
                <li>
                    @php
                    $first_call_done = \App\Models\Enquiries::where(['enquiry_status' => 'First Call Done'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($first_call_done)}}</div>
                    <b class="text-yellow">First Call Done</b>
                </li>
                <li>
                    @php
                    $client_contacted = \App\Models\Enquiries::where(['enquiry_status' => 'Client Contacted'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($client_contacted)}}</div>
                    <b class="text-cyan">Client Contacted</b>
                </li>
                <li>
                    @php
                    $no_response = \App\Models\Enquiries::where(['enquiry_status' => 'No Response'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($no_response)}}</div>
                    <b class="text-light-red">No Response</b>
                </li>
                <li>
                    @php
                    $not_intrested = \App\Models\Enquiries::where(['enquiry_status' => 'Not Intrested'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($not_intrested)}}</div>
                    <b class="text-red">Not Intrested</b>
                </li>
            </ul>
        </div>

        <div class="card-head py-3">
            <div class="toolbar">
                <div class="tool-left">
                    <div class="cst-drop-select"><select class="multiselect" id="MultiSelect_DefaultValues" multiple="multiple"></select></div>
                </div>
                <div class="tool-right">
                    
                </div>
            </div>
        </div>
              
              <div class="card-body">
                <table class="table data-table all-db-table align-middle display" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Enquiry Date</th>
                            <th>Date Created</th>
                            <th>Channel</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
              
          </div>
  <!-- </main> -->
@stop
@section('script')
<script>
    $(function() {
        var name = ['Follow Up Done', 'First Call Done', 'Client Contacted','No Response','Not Intrested'];
        $.map(name, function (x) {
        return $('.multiselect').append("<option>" + x + "</option>");
        });
        $('.multiselect')
        .multiselect({
            allSelectedText: 'Select Status',
            maxHeight: 200,
            includeSelectAllOption: true
        })
        .multiselect('selectAll', false)
        .multiselect('updateButtonText');
    });
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {
    document.title='Enquiries';
    var table = $('.data-table').DataTable({
    processing: true,
    // serverSide: true,
    ajax: {
        url: "{{ route('enquiries.table') }}",
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    },
    columns: [
        {data: 'username', name: 'username',
            "render": function(data, type, row, meta){
                data = '<a class="blue-bold" href="enquiries/' + row.id + '">' + data + '</a>';
                return data;
            }
        },
        {data: 'email', name: 'email'},
        {data: 'phone_number', name: 'phone_number'},
        {data: 'locations_names', name: 'locations_names'},
        {data: 'enquiry_date', name: 'enquiry_date'},
        {
            data: 'created_at',
            name: 'created_at',
            render: function(data, type, row, meta) {
                // Assuming 'date_created' is in a format that can be parsed by Moment.js
                var formattedDate = moment(data).format('DD/MM/YYYY HH:mm:ss');
                return formattedDate;
            }
        },
        {data: 'enquiry_source', name: 'enquiry_source'},
        // {data: 'enquiry_status', name: 'enquiry_status'},
        {data: 'enquiry_status', name: 'enquiry_status',
            "render": function(data, type, row, meta){
                if(data=='Follow Up Done')
                {
                    data = '<span class="badge text-bg-green badge-md">' + data;
                    return data;
                }
                else if(data=='First Call Done')
                {
                    data = '<span class="badge text-bg-yellow badge-md">' + data;
                    return data;
                }
                else if(data=='Client Contacted')
                {
                    data = '<span class="badge text-bg-cyan badge-md">' + data;
                    return data;
                }
                else if(data=='No Response')
                {
                    data = '<span class="badge text-bg-light-red badge-md">' + data;
                    return data;
                }
                else if(data=='Not Intrested')
                {
                    data = '<span class="badge text-bg-red badge-md">' + data;
                    return data;
                }
            }
        },
    ],
    "dom": 'Blrftip',
    "language": {
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search...",
    },
    "paging": true,
    "pageLength": 10,
    "autoWidth": true,
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
$(document).on('change', '#MultiSelect_DefaultValues', function() {
  var vals = $(this).find(':selected').map(function(index, element) {
    return $.fn.dataTable.util.escapeRegex($(element).val());
  }).toArray().join('|').replace("&", "\\&").replace(/\s/g, "\\s");
  if(vals=="")
  {
    vals=null;
  }
  table.columns(7).search(vals, true).draw();
});
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
});
</script>
</html>
@endsection