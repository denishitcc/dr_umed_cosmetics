@extends('layouts/sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
  <!-- <main> -->
          <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Staff Management</h4>
                </div>
                <div class="tool-right">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-md">Add Staff</a>
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
                          <!-- <div class="col-md-7 mb-4">
                            <select id='location' class="form-select form-control" style="width: 200px">
                                <option value="">Select Location</option>
                                @foreach($locations as $location)
                                <option value="{{$location->location_name}}">{{$location->location_name}}</option>
                                @endforeach
                            </select>
                          </div> -->
                        <table class="table data-table all-db-table align-middle display">
                        <thead>
                          <tr>
                            <th>Photo</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role Type</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Last Login</th>
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
      debugger;
      var loc_name = [];

      $.ajax({
          url: "get-all-locations",
          cache: false,
          type: "POST",
          success: function(res) {
              debugger;
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
    document.title='Users';
    var table = $('.data-table').DataTable({
    processing: true,
    // serverSide: true,
    ajax: {
        url: "{{ route('users.table') }}",
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    },
    columns: [
        { data: 'image', name: 'image',
            render: function( data, type, full, meta ) {
              debugger;
              if(data == '')
              {
                return "<figure class='photo'><img src=\"images/banner_image/no-image.jpg\"></figure>";
              }
              else
              {
                return "<figure class='photo'><img src=\"images/user_image/" + data + "\"></figure>";
              }
            }
        },
        {data: 'autoId', name: 'autoId'},
        {data: 'username', name: 'username',
            "render": function(data, type, row, meta){
                data = '<a class="blue-bold" href="users/' + row.id + '">' + data + '</a>';
                return data;
            }
        },
        {data: 'email', name: 'email'},
        {data: 'phone', name: 'phone'},
        {data: 'role_type', name: 'role_type'},
        {data: 'staff_member_location', name: 'staff_member_location'},
        { data: 'status_bar', name: 'status_bar',
            render: function( data, type, full, meta ) {debugger;
                return "<div class='form-check form-switch green'><input class='form-check-input flexSwitchCheckDefault' id='flexSwitchCheckDefault' type='checkbox' ids='"+full.id+"' value='"+data +"' "+data +"></div>"
            }
        },
        {data: 'last_login', name: 'last_login'},
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
            { text: "Excel",exportOptions: { columns: [1,2,3,4,5,7] } ,extend: 'excelHtml5'},
            { text: "CSV" ,exportOptions: { columns: [1,2,3,4,5,7] } ,extend: 'csvHtml5'},
            { text: "PDF" ,exportOptions: { columns: [1,2,3,4,5,7] } ,extend: 'pdfHtml5'},
            { text: "PRINT" ,exportOptions: { columns: [1,2,3,4,5,7] } ,extend: 'print'},
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
$(document).on('change', '#MultiSelect_DefaultValues', function() {
  var vals = $(this).find(':selected').map(function(index, element) {
    return $.fn.dataTable.util.escapeRegex($(element).val());
  }).toArray().join('|').replace("&", "\\&").replace(/\s/g, "\\s");
  if(vals=="")
  {
    vals=null;
  }
  table.columns(6).search(vals, true).draw();
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
    debugger;
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