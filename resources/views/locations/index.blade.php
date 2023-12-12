@extends('layouts/sidebar')
@section('content')
<!-- Page content wrapper-->
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
                      <table id="example" class="table all-db-table align-middle" cellspacing="0" width="100%">
                        <thead>
                          <tr>
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
                            <td><a href="#" class="blue-bold">{{$loc->location_name}}</a></td>
                            <td>{{$loc->email}}</td>
                            <td>{{$loc->phone}}</td>
                            <td>{{$loc->street_address.' '.$loc->suburb.' '.$loc->city.' '.$loc->state.' '.$loc->postcode}}</td>
                            <td>{{$loc->latitude}}</td>
                            <td>{{$loc->longitude}}</td>
                            <td>
                              <div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 far fa-edit">
                                  <i class="ico-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm black-btn round-6 dt-delete">
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
        $(document).ready(function() {
          //Only needed for the filename of export files.
          //Normally set in the title tag of your page.
          document.title='Locations';
          // DataTable initialisation
         
            $('#example').DataTable(
            {
              "dom": '<"dt-buttons"><"clear">Bflirtp',
              "paging": true,
              "pageLength": 5,
              "autoWidth": true,
              "columnDefs": [
                { "orderable": false, "targets": 5 }
              ],
              "buttons": [
                'colvis',
                'csvHtml5',
                'excelHtml5',
                'pdfHtml5',
              ]
            }
          );
          //Add row button
          $('.dt-add').each(function () {
            $(this).on('click', function(evt){
              //Create some data and insert it
              var rowData = [];
              var table = $('#example').DataTable();
              //Store next row number in array
              var info = table.page.info();
              rowData.push(info.recordsTotal+1);
              //Some description
              rowData.push('New Order');
              //Random date
              var date1 = new Date(2016,01,01);
              var date2 = new Date(2018,12,31);
              var rndDate = new Date(+date1 + Math.random() * (date2 - date1));//.toLocaleDateString();
              rowData.push(rndDate.getFullYear()+'/'+(rndDate.getMonth()+1)+'/'+rndDate.getDate());
              //Status column
              rowData.push('NEW');
              //Amount column
              rowData.push(Math.floor(Math.random() * 2000) + 1);
              //Inserting the buttons ???
              rowData.push('<button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>');
              //Looping over columns is possible
              //var colCount = table.columns()[0].length;
              //for(var i=0; i < colCount; i++){      }
              
              //INSERT THE ROW
              table.row.add(rowData).draw( false );
            });
          });
          //Edit row buttons
          $('.dt-edit').each(function () {
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