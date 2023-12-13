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
                            <td><a href="#" class="blue-bold">{{$loc->location_name}}</a></td>
                            <td>{{$loc->email}}</td>
                            <td>{{$loc->phone}}</td>
                            <td>{{$loc->street_address.' '.$loc->suburb.' '.$loc->city.' '.$loc->state.' '.$loc->postcode}}</td>
                            <td>{{$loc->latitude}}</td>
                            <td>{{$loc->longitude}}</td>
                            <td>
                              <div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 far dt-edit">
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
                      
                      <!-- Modal -->
                      <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Row information</h4>
                            </div>
                            <div class="modal-body">
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
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
          'order': [[1, 'asc']]
    });

    // Handle click on "Select all" control
    $('#example-select-all').on('click', function(){
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
    //Edit row buttons
    $('.dt-edit').each(function () {debugger;
      $(this).on('click', function(evt){
        $this = $(this);
        var dtRow = $this.parents('tr');
        $('div.modal-body').innerHTML='';
        $('div.modal-body').append('Row index: '+dtRow[0].rowIndex+'<br/>');
        $('div.modal-body').append('Number of columns: '+dtRow[0].cells.length+'<br/>');
        for(var i=0; i < dtRow[0].cells.length; i++){
          $('div.modal-body').append('Cell (column, row) '+dtRow[0].cells[i]._DT_CellIndex.column+', '+dtRow[0].cells[i]._DT_CellIndex.row+' => innerHTML : '+dtRow[0].cells[i].innerHTML+'<br/>');
        }
        $('#myModal').modal('show');
      });
    });
    //Delete buttons
    $('.dt-delete').each(function () {
      $(this).on('click', function(evt){
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
    });
    $('#myModal').on('hidden.bs.modal', function (evt) {
      $('.modal .modal-body').empty();
    });

  });
    </script>
</body>

</html>
@endsection