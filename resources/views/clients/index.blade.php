@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
    <div class="card">
        <div class="card-head">
        <div class="toolbar mb-0">
                <div class="tool-left">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-md me-2">Add New Client</a>
                    <a href="#" class="btn btn-primary btn-md me-2">Import Client</a>
                    <a href="#" class="btn btn-primary btn-md me-2">Add New Waitlist Client</a>
                    <a href="#" class="btn btn-primary btn-md me-2">Add New Walk-in Sale</a>
                    <a href="#" class="btn btn-primary btn-md">Make New Appointment</a>
                </div>
            </div>
            
        </div>
        <div class="card-head">
            <h4 class="small-title mb-3">Client's Summary</h4>
            
            <ul class="taskinfo-row">
                <li>
                    <div class="font-24 mb-1">{{count($clients)}}</div>
                    <b class="d-grey">Total Clients</b>
                </li>
                <li>
                    @php
                    $active_client = \App\Models\Clients::where(['status' => 'active'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($active_client)}}</div>
                    <b class="text-succes-light">Active Clients </b>
                </li>
                <li>
                    @php
                    $inactive = \App\Models\Clients::where(['status' => 'deactive'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($inactive)}}</div>
                    <b class="text-danger">InActive Clients</b>
                </li>
                <li>
                    <div class="font-24 mb-1">0</div>
                    <b class="text-warning">Client's Appointment Today</b>
                </li>
            </ul>
        </div>
        <div class="card-head py-3">
            <div class="toolbar">
                <div class="tool-left d-flex align-items-center ">
                    <div class="cst-drop-select me-3"><select class="location" multiple="multiple"></select></div>
                    <label class="cst-check"><input type="checkbox" class="checkbox" value="" id="exclude" name="" checked=""><span class="checkmark me-2"></span>Exclude Inactive Clients</label>
                </div>
                <div class="tool-right">
                    <div class="cst-drop-select drop-right"><select class="filter_by" multiple="multiple"></select></div>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
                <table class="table data-table all-db-table align-middle display" style="width:100%;">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Next Appointments</th>
                    <th>Date and Time</th>
                    <th>Status</th> 
                    <th>Location</th>
                    <!--<th>status</th>-->
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
    $(function() {

        var loc_name = [];

        $.ajax({
            url: "get-all-locations",
            cache: false,
            type: "POST",
            success: function(res) {
                for (var i = 0; i < res.length; ++i) {
                    $("#results").append(res[i].location_name);
                    loc_name.push(res[i].location_name); // Push the location_name to the array
                }

                // Move the map function inside the success callback
                $.map(loc_name, function(x) {
                    return $('.location').append("<option>" + x + "</option>");
                });

                // Initialize the multiselect after appending options
                $('.location')
                .multiselect({
                    allSelectedText: 'Select Location',
                    maxHeight: 200,
                    includeSelectAllOption: true
                })
                .multiselect('selectAll', false)
                .multiselect('updateButtonText');
            }
        });
        // var loc_name = [];//['Follow Up Done', 'First Call Done', 'Client Contacted','No Response','Not Intrested'];
        // $.map(loc_name, function (x) {
        // return $('.location').append("<option>" + x + "</option>");
        // });
        // $('.location')
        // .multiselect({
        //     allSelectedText: 'Select Locations',
        //     maxHeight: 200,
        //     includeSelectAllOption: true
        // })
        // .multiselect('selectAll', false)
        // .multiselect('updateButtonText');

        var filter_by = ['All Days', 'Feature Appointments', 'Today','Tomorrow'];
        $.map(filter_by, function (x) {
        return $('.filter_by').append("<option>" + x + "</option>");
        });
        $('.filter_by')
        .multiselect({
            allSelectedText: 'Filter By',
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
    document.title='Clients';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('clients.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            // {data: '', name: ''},
            {data: 'autoId', name: 'autoId'},
            {data: 'username', name: 'username',
                "render": function(data, type, row, meta){
                    data = '<a class="blue-bold" href="clients/' + row.id + '">' + data + '</a>';
                    return data;
                }
            },
            {data: 'email', name: 'email'},
            {data: 'mobile_number', name: 'mobile_number'},
            {"defaultContent": ""},//{data: 'id', name: 'id',"defaultContent": ""},//next appointment details
            {"defaultContent": ""},//{data: 'id', name: 'id'},//appointment date
            // {data: 'status', name: 'status'},
            { data: 'status_bar', name: 'status_bar',
                render: function( data, type, full, meta ) {
                    if(data==null)
                    {
                        data='';
                    }
                    return "<span style='display:none;'>"+data +"</span><div class='form-check form-switch green'><input class='form-check-input flexSwitchCheckDefault' id='flexSwitchCheckDefault' type='checkbox' ids='"+full.id+"' value='"+data +"' "+data +"></div>"
                }
            },
            {"defaultContent": ""},//{data: 'id', name: 'id'},//appointment location
            // {data: 'action', name: 'action', orderable: false, searchable: false},
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
                    { 
                        text: "Excel",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5,6,7],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'excelHtml5'
                    },
                    { 
                        text: "CSV",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5,6,7],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'csvHtml5'
                    },
                    { 
                        text: "PDF",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5,6,7],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'pdfHtml5'
                    },
                    { 
                        text: "PRINT",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5,6,7],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'print'
                    },
                ]
            }
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
    table.column(6).search('checked', true, false).draw();
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
    $(document).on('change','#exclude',function(){
        var ts = $('#exclude').prop('checked');
        if(ts==false)
        {
            table.column(6).search('checked|', true, false).draw();
        }
        else
        {
            table.column(6).search('checked').draw();
        }
    })
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
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
$(document).on('click','.flexSwitchCheckDefault',function(){
    var id =$(this).attr('ids');
    var chk = $(this).val();
    var url = "clients/updateStatus";
    $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data: {// change data to this object
          _token : $('meta[name="csrf-token"]').attr('content'), 
          id:id,
          chk:chk
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
      
      Swal.fire({
        title: "Client Status!",
        text: "Client Status updated successfully.",
        type: "success",
      }).then((result) => {
              window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
          });
    } else {
      Swal.fire({
        title: "Error!",
        text: response.message,
        type: "error",
      });
    }
        },
        error: function (jqXHR, exception) {

        }
    });
})
</script>
</html>
@endsection