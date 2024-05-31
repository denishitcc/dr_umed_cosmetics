@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
        <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Gift Cards</h4>
                </div>
                <div class="tool-right">
                    @if(Auth::check() && (Auth::user()->role_type == 'admin'))
                    <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#gift_card">+ Free vouchers</a>
                    @elseif(Auth::user()->checkPermission('gift-card') != 'View Only')
                    <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#gift_card">+ Free vouchers</a>
                    @endif
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
                    <th></th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>
    </div>
    <div class="modal fade" id="gift_card" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Create Free Vouchers</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create_gift_cards" name="create_gift_cards" class="form">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Quantity to create</label>
                                <input type="text" class="form-control" id="quanitity" name="quanitity" maxlength="20">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Value of each voucher</label>
                                <div class="input-group value_error">
                                    <input type="text" class="form-control" id="value" name="value" maxlength="50">
                                    <span class="input-group-text "><span class="ico-dollar fs-4"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Expires</label>
                                <select class="form-select" id="expiry_date" name="expiry_date">
                                    <option value="Never">Never</option>
                                    <option value="1 month">1 month</option>
                                    <option value="2 months">2 months</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option selected="" value="1 year">1 year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" maxlength="500" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-md">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_gift_cards" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Gift Card <span class="tracking_number"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_gift_card" name="edit_gift_card" class="form">
                @csrf
                <input type="hidden" name="hdn_id" id="hdn_id" value="">
                <input type="hidden" name="is_expired_hidden" id="is_expired_hidden" value="0">
                <div class="modal-body">

                <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Initial value</label>
                                <input type="text" class="form-control" id="initial_value" name="initial_value" maxlength="20" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Remaining value</label> 
                                <div class="input-group edit_value_error">
                                    <input type="text" class="form-control" id="remaining_value" name="remaining_value" maxlength="50">
                                    <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="checkbox" name="is_expired" id="is_expired" value="1" onchange="toggleExpiryDate()">
                                <label class="form-label">Expires</label><br>
                                <input type="date" name="edit_expiry_date" id="edit_expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" id="edit_notes" name="edit_notes" maxlength="500" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-md">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_transactions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Transactions for <span class="tracking_number"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancel_gift_card" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Cancel Gift Card <span class="tracking_number"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this voucher? It will no longer be redeemable, and its remaining balance will be set to 0.</p>
                    <p>This can not be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal" aria-label="Close">Don't cancel</button>
                    <button class="btn btn-red btn-md dt-cancel" ids="" data-bs-dismiss="modal" aria-label="Close">Cancel this gift card</button>
                </div>
            </div>
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
    document.title='Gift Cards';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('gift-card.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: function(data)
            {
                
            },
        },
        columns: [
            {data: 'details', name: 'details'},
            {data: 'remaining_value', name: 'remaining_value'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "dom": 'Blrftip',
        "language": {
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search...",
            "infoFiltered": "", 
        },
        "paging": true,
        "pageLength": 10,
        "autoWidth": true,
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
    table.select.info( false);
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
    $("#create_gift_cards").validate({
        rules: {
            quanitity: {
                required: true,
                min: 1,
                max: 1000
            },
            value: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "value") {
                error.insertAfter(".value_error");
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#edit_gift_card").validate({
        rules: {
            remaining_value: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "remaining_value") {
                error.insertAfter(".edit_value_error");
            } else {
                error.insertAfter(element);
            }
        }
    });
    $(document).on('submit','#create_gift_cards',function(e){
		e.preventDefault();
		var valid= $("#create_gift_cards").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_gift_cards').serialize() ;

            // var data = new FormData(this);
			submitCreateGiftCardForm(data);
		}
	});
    $(document).on('submit','#edit_gift_card',function(e){
		e.preventDefault();
		var valid= $("#edit_gift_card").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_gift_card').serialize() ;
            var id = $('#hdn_id').val();
            // var data = new FormData(this);
			submitEditGiftCardForm(data,id);
		}
	});
        // Modal close event
    $('#gift_card').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#gift_card").validate().resetForm();
    });
    $('#edit_gift_cards').on('hidden.bs.modal', function() {
        // Clear validation messages when modal is closed
        $("#edit_gift_card").validate().resetForm();
    });
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    $('#hdn_id').val($(this).attr('ids'));
    $('#initial_value').val($(this).attr('initial_value'));
    $('#remaining_value').val($(this).attr('remaining_value'));
    $('#edit_notes').text($(this).attr('notes'));
    $('#edit_expiry_date').val($(this).attr('expiry_date'));
    $('.tracking_number').text($(this).attr('tracking_number'))
    if($(this).attr('expiry_date') != "")
    {
        $('#is_expired').prop('checked', true);
    }else{
        $('#is_expired').prop('checked', false);
        $('#edit_expiry_date').hide();
    }
});
$(document).on('click', '.dt-transaction', function(e) {
    e.preventDefault();
    var id = $(this).attr('ids');
    $('.tracking_number').text($(this).attr('tracking_number'))
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('gift-card.transactions') }}",
        type: "POST",
        data: {'id': id},
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response) {
                $('#edit_transactions .modal-body').html(response); // Render transactions in modal body
                $('#edit_transactions').modal('show'); // Show the modal
            }
        }
    });
}); 
$(document).on('click','.cancel-gift',function(e){
    e.preventDefault();
    var id = $(this).attr('ids');
    $('.dt-cancel').attr('ids',id);
    $('.tracking_number').text($(this).attr('tracking_number'))
})
$(document).on('click', '.dt-cancel', function(e) {
    e.preventDefault();
    var id = $(this).attr('ids');
        $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('gift-card.cancel') }}",
        type: 'POST',
        data: {
            "id": $(this).attr('ids'),
        },
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
            Swal.fire({
                title: "Gift Card!",
                text: "Gift Card Cancelled successfully.",
                type: "success",
            }).then((result) => {
                            window.location = "{{url('gift-card')}}"//'/player_detail?username=' + name;
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
});
function submitCreateGiftCardForm(data){
    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('gift-card.store')}}",
        type: "post",
        data: data,
        success: function(response) {
            
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Gift Card!",
                    text: "Gift Card created successfully.",
                    type: "success",
                }).then((result) => {
                    window.location = "{{url('gift-card')}}"//'/player_detail?username=' + name;
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
}
function submitEditGiftCardForm(data,id){
    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: 'gift-card/'+id,
        type: "PUT",
        data: data,
        success: function(response) {
            
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Gift Card!",
                    text: "Gift Card updated successfully.",
                    type: "success",
                }).then((result) => {
                    window.location = "{{url('gift-card')}}"//'/player_detail?username=' + name;
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
}
function toggleExpiryDate() {
    var checkbox = document.getElementById("is_expired");
    var expiryDateInput = document.getElementById("edit_expiry_date");
    
    if (checkbox.checked) {
        expiryDateInput.style.display = "block";
        expiryDateInput.value = getCurrentDate();
    } else {
        expiryDateInput.style.display = "none";
    }
}
function getCurrentDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();
    
    return yyyy + '-' + mm + '-' + dd;
}
</script>
</html>
@endsection