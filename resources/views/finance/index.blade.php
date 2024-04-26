@extends('layouts.sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
  <!-- <main> -->
          <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Finance Management</h4>
                </div>
                <div class="tool-right">
                    <a href="#" class="btn btn-primary btn-md">Make Sale</a>
                </div>
            </div>
                
              </div>
              <div class="card-head py-3">
                <div class="toolbar">
                    <div class="tool-left">
                        <div class="cst-drop-select"><select class="location" multiple="multiple" id="MultiSelect_DefaultValues"></select></div>
                    </div>
                </div>
            </div>
              <div class="card-body">
              <div class="row">
                        <table class="table data-table all-db-table align-middle display" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Invoice</th>
                            <th>Client</th>
                            <th>Location</th>
                            <th>Product/Service</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Total</th>
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
  });
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {
    document.title='Finance';
    var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('finance.table') }}",
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    },
    columns: [
        {
            data: 'id', 
            name: 'id',
            render: function (data, type, row) {
                var link = '<a class="blue-bold" href="javascript:void(0)' + row.client_id + '">INV' + data + '</a>';
                return link;
            }
        },
        {
            data: 'client_name', 
            name: 'client_name',
            render: function (data, type, row) {
                var link = '<a class="blue-bold" href="clients/' + row.client_id + '">' + data + '</a>';
                return link;
            }
        },
        {data: 'location_name', name: 'location_name'},
        { data: 'product_names', name: 'product_names' },
        { 
            data: "walk_in_type", 
            name: "walk_in_type",
            defaultContent: '' // Set the default content to an empty string
        },
        {data: 'payment', name: 'payment'},
        { 
            data:  null, 
            name:  null, 
            render: function(data, type, row, meta) {
                return '<span class="badge text-bg-green badge-md">PAID</span>';
            }
        },
        { 
            data: "updated_at", 
            name: "updated_at",
            render: function(data, type, row, meta) {
                // Format the date using moment.js to display only the time part
                return moment(data).format("hh:mm A");
            }
        },
        { 
            data: 'total', 
            name: 'total',
            render: function(data, type, row, meta) {
                // Add a dollar sign ($) before the value
                return '$' + data;
            }
        },
        {data: 'action', name: 'action', orderable: false, searchable: false},
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
                { 
                    text: "Excel",
                    exportOptions: { 
                        columns: [1,2,3,4,5,6,7,8],
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
                        columns: [1,2,3,4,5,6,7,8],
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
                        columns: [1,2,3,4,5,6,7,8],
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
                        columns: [1,2,3,4,5,6,7,8],
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
    'order': [[0, 'desc']],
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
                <input type="search" class="form-control input-sm dt-search" name="search_data" placeholder="Search..." aria-controls="example">
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
table.select.info( false);
$(document).on('change', '#MultiSelect_DefaultValues', function() {
  var vals = $(this).find(':selected').map(function(index, element) {
    return $.fn.dataTable.util.escapeRegex($(element).val());
  }).toArray().join('|').replace("&", "\\&").replace(/\s/g, "\\s");
  if(vals=="")
  {
    vals=null;
  }
  table.columns(2).search(vals, true).draw();
});

// $(document).on('input', '.dt-search', function() {
//     var searchTerm = this.value.trim(); // Trim whitespace from search term

//     // Check if the search term starts with "INV" (for the first column)
//     if (searchTerm.startsWith("INV") || searchTerm.startsWith("inv")) {
//         var digitsOnly = searchTerm.replace(/\D/g, '');
//         table.column(0).search(digitsOnly).draw();
//     } else {
//         // If search term is empty, filter all records; otherwise, filter the second and third columns
//         if ($(this).val() == '') {
//             table.columns([0, 1]).search('').draw();
//         } else {
//             table.columns([1, 2]).search(searchTerm).draw(); // Search in both second and third columns
//         }
//     }
// });

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
  $(document).on('click','.flexSwitchCheckDefault',function(){
    var id =$(this).attr('ids');
    var chk = $(this).val();
    var url = "users/updateStatus";
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
        title: "User Status!",
        text: "Your User Status updated successfully.",
        type: "success",
      }).then((result) => {
              window.location = "{{url('users')}}"//'/player_detail?username=' + name;
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
  });
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    
    var ids = $(this).attr('ids');
    window.location = 'users/' + ids;
  });
$(document).on('click', '.dt-delete', function(e) {
  e.preventDefault();
    $this = $(this);
    var dtRow = $this.parents('tr');
    if(confirm("Are you sure to delete this row?")){
      $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "users/"+$(this).attr('ids'),
        type: 'DELETE',
        data: {
            "id": $(this).attr('ids'),
        },
        success: function(response) {
          // Show a Sweet Alert message after the form is submitted.
          if (response.success) {
            Swal.fire({
              title: "Users!",
              text: "Your Users deleted successfully.",
              type: "success",
            }).then((result) => {
                          window.location = "{{url('users')}}"//'/player_detail?username=' + name;
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