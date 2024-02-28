@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
    <div class="card">
        <div class="card-head">
        <div class="toolbar mb-0">
                <div class="tool-left">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-md me-2">Add New Client</a>
                    <!-- <a href="#" class="btn btn-primary btn-md me-2">Import Client</a> -->
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
                    <div class="font-24 mb-1">{{count($count_today_appointments)}}</div>
                    <b class="text-warning">Client's Appointment Today</b>
                </li>
            </ul>
        </div>
        <div class="card-head py-3">
            <div class="toolbar">
                <div class="tool-left d-flex align-items-center ">
                    <div class="cst-drop-select me-3"><select class="location" multiple="multiple" id="MultiSelect_DefaultValues"></select></div>
                    <label class="cst-check"><input type="checkbox" class="checkbox" value="" id="exclude" name="" checked=""><span class="checkmark me-2"></span>Exclude Inactive Clients</label>
                </div>
                <div class="tool-right">
                    <div class="cst-drop-select drop-right"><select class="filter_by" multiple="multiple" id="DayFilter"></select></div>
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
                    <!-- <th>Appointment Status</th> -->
                    <!-- <th>Date and Time</th> -->
                    <th>Status</th> 
                    <!-- <th>Location</th> -->
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
            {
                data: 'appointment_dates',
                name: 'appointment_dates',
                render: function (data, type, row, meta) {
                    if (data === null) {
                        return '';
                    } else {
                        var datesArray = data.split(',');
                        var statusArray = row.app_status.split(',');
                        var locationArray = row.staff_location.split(',');

                        var html_app = '';

                        datesArray.forEach(function (app, index) {
                            var formattedDate = app;
                            var formattedStatus = '';
                            var formattedLocation = '';
                            // Add location
                            if (locationArray[index]) {
                                formattedLocation = '<div class="user-appnt">' + locationArray[index] + '</div>';
                            }

                            // Add a line break after AM or PM
                            formattedDate = formattedDate.replace(/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}\s)(AM|PM)/g, '<b>$1$2</b> (' + formattedLocation + ')');
                            
                            // Add status badge
                            if (statusArray[index]) {
                                if (statusArray[index] == 'Booked') {
                                    formattedStatus = '<span class="badge text-bg-yellow badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Confirmed') {
                                    formattedStatus = '<span class="badge text-bg-cyan badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Started') {
                                    formattedStatus = '<span class="badge text-bg-orange badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Completed') {
                                    formattedStatus = '<span class="badge text-bg-blue badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'No answer') {
                                    formattedStatus = '<span class="badge text-bg-light-red badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Left message') {
                                    formattedStatus = '<span class="badge text-bg-green badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Pencilied in') {
                                    formattedStatus = '<span class="badge text-bg-grey badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Turned up') {
                                    formattedStatus = '<span class="badge text-bg-purple badge-md mb-1" style="background-color:#B7EDED;">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'No show') {
                                    formattedStatus = '<span class="badge text-bg-light-red badge-md mb-1">' + statusArray[index] + '</span>';
                                } else if (statusArray[index] == 'Cancelled') {
                                    formattedStatus = '<span class="badge text-bg-red badge-md mb-1">' + statusArray[index] + '</span>';
                                }
                            }
                            html_app += '<div class="user-appnt">' + formattedDate + formattedStatus + '</div>';
                        });

                        html_app += '';
                        return html_app;
                    }
                }
            },
            { data: 'status_bar', name: 'status_bar',
                render: function( data, type, full, meta ) {
                    if(data==null)
                    {
                        data='';
                    }
                    return "<span style='display:none;'>"+data +"</span><div class='form-check form-switch green'><input class='form-check-input flexSwitchCheckDefault' id='flexSwitchCheckDefault' type='checkbox' ids='"+full.id+"' value='"+data +"' "+data +"></div>"
                }
            },
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
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
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
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
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
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
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
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if(column === 5) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    else if(column === 7) {
                                        return node.textContent;
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
    table.column(5).search('checked', true, false).draw();
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
    $(document).on('change','#exclude',function(){
        var ts = $('#exclude').prop('checked');
        if(ts==false)
        {
            table.column(5).search('checked|', true, false).draw();
        }
        else
        {
            table.column(5).search('checked').draw();
        }
    })
    $(document).on('change', '#MultiSelect_DefaultValues', function() {
        var vals = [];
        $(this).find(':selected').each(function(index, element) {
            vals.push($.fn.dataTable.util.escapeRegex($(element).val()));
        });
        var regex = vals.join('|');
        if (regex == "") {
            regex = null;
        }
        table.columns(4).search(regex, true, false).draw();
    });
    $(document).on('change', '#DayFilter', function() {
        // Get the selected values from the dropdown
        var selectedValues = $(this).val();

        // Define a date filter to get the data for today, tomorrow, or a future date
        var dateFilter = [];

        // Loop through each selected value
        if(selectedValues != null){
            
            selectedValues.forEach(function(selectedValue) {
                switch (selectedValue) {
                    case 'Today':
                        dateFilter.push(new Date().toISOString().slice(0, 10)); // Get today's date in ISO format
                        break;
                    case 'Tomorrow':
                        var Tomorrow = new Date();
                        Tomorrow.setDate(Tomorrow.getDate() + 1); // Get Tomorrow's date
                        dateFilter.push(Tomorrow.toISOString().slice(0, 10)); // Get Tomorrow's date in ISO format
                        break;
                    case 'Feature Appointments':
                        var Future = new Date();
                        Future.setDate(Future.getDate() + 1); // Get Next day's date
                        dateFilter.push(Future.toISOString().slice(0, 10)); // Get Next day's date in ISO format
                        // Assuming 'feature' is a placeholder for the actual date of the last feature appointment,
                        // use the actual date instead of 'feature' in the future.
                        break;
                }
            });
        
        }
        
        // If no value is selected, remove the filter
        if (selectedValues === null || selectedValues.length === 0) {
            selectedValues = null;
            table.column(4).search(selectedValues).draw(); // Clear the filter
            return; // Exit the function early
        }

        // Join the elements of dateFilter with the | pipe sign
        var dateFilterString = dateFilter.join('|');

        // Apply the filter to the DataTable column 4 (assuming column 4 contains the date)
        // table.column(4).search(dateFilterString).draw();
        table.column(4).search(dateFilterString, true, false).draw();
    });


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