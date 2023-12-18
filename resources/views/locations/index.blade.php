@extends('layouts/sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
  <main>
          <div class="card">
              <div class="card-head">
                <a href="{{ route('locations.create') }}" class="btn btn-primary btn-md me-2">New Location</a>
                <a href="#" class="btn btn-primary btn-md">Import Location CSV</a>
              </div>
              <div class="card-head">
                <h4 class="small-title mb-0">All Locations</h4>
            </div>
              <div class="card-body">
                      <table id="example" class="table all-db-table align-middle display select" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                            <th>Location Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Latitudes</th>
                            <th>Longitudes</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(count($locations)>0)
                          @foreach($locations as $loc)
                          <tr>
                            <td></td>
                            <td><a href="{{URL::to('locations')}}/{{$loc->id}}" class="blue-bold">{{$loc->location_name}}</a></td>
                            <td>{{$loc->email}}</td>
                            <td>{{$loc->phone}}</td>
                            <td>{{$loc->street_address.' '.$loc->suburb.' '.$loc->city.' '.$loc->state.' '.$loc->postcode}}</td>
                            <td>{{$loc->latitude}}</td>
                            <td>{{$loc->longitude}}</td>
                            <td>
                                <div class="action-box">
                                  <button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids="{{$loc->id}}">
                                    <i class="ico-edit"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids="{{$loc->id}}">
                                    <i class="ico-trash"></i>
                                  </button>
                                </div>
                            </td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
              </div>
              
              
          </div>
  </main>
@stop
    @section('script')
    <script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $(document).ready(function() {
            document.title='Locations';
            var table = $('#example').DataTable({
            "dom": 'Blfrtip',
            "paging": true,
            "pageLength": 5,
            "autoWidth": true,
            'columnDefs': [{
              'targets': 0,
              'searchable': false,
              'orderable': false,
              'className': 'dt-body-center',
              'render': function (data, type, full, meta){
                  return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
              }
            }],
            buttons: [
              {
                  extend: 'excelHtml5',
                  text: '<i class="fa fa-file-excel-o"></i> Excel',
                  titleAttr: 'Export to Excel',
                  title: 'Locations',
                  exportOptions: {
                      columns: [1,2,3,4,5,6] 
                  }
              },
              {
                  extend: 'csvHtml5',
                  text: '<i class="fa fa-file-text-o"></i> CSV',
                  titleAttr: 'CSV',
                  title: 'Locations',
                  exportOptions: {
                      columns: [1,2,3,4,5,6] 
                  }
              },
              {
                  extend: 'pdfHtml5',
                  text: '<i class="fa fa-file-pdf-o"></i> PDF',
                  titleAttr: 'PDF',
                  title: 'Locations',
                  exportOptions: {
                      columns: [1,2,3,4,5,6] 
                  },
              },
          ],
          'order': [[1, 'desc']]
    });

    // Handle click on "Select all" control
    $('#example-select-all').on('click', function(){debugger;
        // Get all rows with search applied
        var rows = table.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#example tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
          var el = $('#example-select-all').get(0);
          // If "Select all" control is checked and has 'indeterminate' property
          if(el && el.checked && ('indeterminate' in el)){
              // Set visual state of "Select all" control
              // as 'indeterminate'
              el.indeterminate = true;
          }
        }
    });

  });
  $(document).on('click', '.dt-edit', function(e) {
      e.preventDefault();
      debugger;
      var ids = $(this).attr('ids');
      window.location = 'locations/' + ids;
    });
    $(document).on('click', '.dt-delete', function(e) {
      e.preventDefault();
        $this = $(this);
        var dtRow = $this.parents('tr');
        if(confirm("Are you sure to delete this row?")){
          $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "locations/"+$(this).attr('ids'),
            type: 'DELETE',
            data: {
                "id": $(this).attr('ids'),
            },
            success: function(response) {
              // Show a Sweet Alert message after the form is submitted.
              if (response.success) {
                Swal.fire({
                  title: "Locations!",
                  text: "Your Locations deleted successfully.",
                  type: "success",
                }).then((result) => {
                              window.location = "{{url('locations')}}"//'/player_detail?username=' + name;
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
</body>

</html>
@endsection