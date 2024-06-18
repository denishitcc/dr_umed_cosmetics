@extends('layouts/sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card">
    @if(Auth::check() && (Auth::user()->role_type == 'admin'))
    <div class="card-head">
        <div class="toolbar">
            <div class="tool-left">
                <a href="#" class="btn btn-primary btn-md me-2" data-bs-toggle="modal" data-bs-target="#new_form">New Form</a>
                <!-- <a href="#" class="btn btn-primary btn-md">Import Form</a> -->
            </div>
        </div>
    </div>
    @elseif(Auth::user()->checkPermission('forms') != 'View Only')
    <div class="card-head">
        <div class="toolbar">
            <div class="tool-left">
                <a href="#" class="btn btn-primary btn-md me-2" data-bs-toggle="modal" data-bs-target="#new_form">New Form</a>
                <!-- <a href="#" class="btn btn-primary btn-md">Import Form</a> -->
            </div>
        </div>
    </div>
    @endif
    <div class="card-head">
        <h4 class="small-title mb-3">Forms Summary</h4>

        <ul class="taskinfo-row">
            <li>
                <div class="font-24 mb-1">{{count($forms)}}</div>
                <b class="d-grey">Total Forms</b>
            </li>
            @php
                $liveForms = $forms->filter(function($form) {
                    return $form->status == 1;
                });
            @endphp
            <li>
                <div class="font-24 mb-1">{{ $liveForms->count() }}</div>
                <b class="text-succes-light">Live Forms </b>
            </li>
            @php
                $draftsForms = $forms->filter(function($form) {
                    return $form->status == 0;
                });
            @endphp
            <li>
                <div class="font-24 mb-1">{{ $draftsForms->count() }}</div>
                <b class="text-warning">Drafts Forms</b>
            </li>
        </ul>
    </div>

    <div class="card-body">
    <table class="table data-table all-db-table align-middle display" style="width:100%;">
        <thead>
            <tr>
            <th>Form Name</th>
            <th>By Whom</th>
            <th>Last Modified</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="new_form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Form options</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create_forms" name="create_forms" class="form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" name="description"></textarea>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <label class="form-label">Available for use</label>
                            <div class="toggle">
                                <input type="radio" name="status" value="1" id="yes" class="status">
                                <label for="yes">Yes <i class="ico-tick"></i></label>
                                <input type="radio" name="status" value="0" id="no" checked="checked" class="status">
                                <label for="no">No <i class="ico-tick"></i></label>
                            </div>
                        </div>

                        <div class="col-lg-2 form_live" style="display:none;">
                            <label class="form-label d-block">&nbsp;</label>
                            <span class="badge text-bg-green badge-md">Live</span>
                        </div>
                        <div class="col-lg-2 form_draft">
                            <label class="form-label d-block">&nbsp;</label>
                            <span class="badge text-bg-grey badge-md">Draft</span>
                        </div>
                    </div>
                </div>

                <div class="info-light invo-notice">
                    <em class="d-grey font-13">This form can now be added to client appointments by selecting the Forms button to the left of the Dr. Umed Portal appointment book.</em>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light" onclick="window.location='{{ url("forms") }}'">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
     var moduleConfig = {
        updateForm:             "{!! route('serviceforms.formUpdate') !!}",
        updateHTMLFormContent:  "{!! route('serviceforms.formHTMLUpdate') !!}",
        deleteForm:             "{!! route('serviceforms.formDelete') !!}",
    }
$(document).ready(function() {

    $("#create_forms").validate({
        rules: {
            title: {
                required: true,
            },
            description:{
                required: true,
            }
        }
    });


    document.title='Forms';
    var table = $('.data-table').DataTable({
    processing: true,
    // serverSide: true,
    ajax: {
        url: "{{ route('forms.table') }}",
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    },
    columns: [
        {data: 'title', name: 'title',
            "render": function(data, type, row, meta){
                data = '<a class="blue-bold" href="forms/' + row.id + '">' + data + '</a>';
                return data;
            }
        },
        {
            data: 'by_whom',
            name: 'by_whom',
            render: function(data, type, row, meta) {
                // Add a static prefix to the "by_whom" column
                data = 'by ' + data;
                return data;
            }
        },
        {
            data: 'updated_at',
            name: 'updated_at',
            render: function(data, type, row, meta) {
                // Assuming 'updated_at' is in a format that can be parsed by Moment.js
                var formattedDate = moment(data).format('DD-MM-YYYY HH:mm:ss');
                return formattedDate;
            }
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, row, meta) {
                // Conditionally add class based on the status value
                var statusClass = data == 1 ? 'Live' : 'Drafts';
                if(statusClass == 'Live')
                {
                    return '<span class="badge text-bg-green badge-md">'+statusClass+'</span>';
                }else{
                    return '<span class="badge text-bg-grey badge-md">'+statusClass+'</span>';
                }
            }
        },
        {data: 'action', name: 'action'},
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
            { text: "Excel",exportOptions: { columns: [0,1,2,3] } ,extend: 'excelHtml5'},
            { text: "CSV" ,exportOptions: { columns: [0,1,2,3] } ,extend: 'csvHtml5'},
            { text: "PDF" ,exportOptions: { columns: [0,1,2,3] } ,extend: 'pdfHtml5'},
            { text: "PRINT" ,exportOptions: { columns: [0,1,2,3] } ,extend: 'print'},
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
    table.select.info( false);
    $('.status').change(function(){

        if ($("input[name='status'][value='1']").prop("checked"))
        {
            $('.form_live').show();
            $('.form_draft').hide();
        }else{
            $('.form_draft').show();
            $('.form_live').hide();
        }
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
})
$(document).on('submit','#create_forms',function(e){
    e.preventDefault();
    var valid= $("#create_forms").validate();
        if(valid.errorList.length == 0){
        // var data = $('#create_user').serialize() ;

        var data = new FormData(this);
        submitCreateForms(data);
    }
});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    var ids = $(this).attr('ids');
    window.location = 'forms/' + ids;
});
$(document).on('click','.deleteFormBtn',function(e){

    if(confirm("Are you sure you want to delete this form?")){
        var id = $(".deleteFormBtn").data('formid');

        $.ajax({
            url: moduleConfig.deleteForm,
            type: 'POST',
            data: {
                'form_id' : id
            },
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        title: "Forms!",
                        text: data.message,
                        icon: "success",
                    });
                    window.location.href = '/forms';
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                    });
                }
            },
            error: function (error) {
                console.error('Error fetching events:', error);
            }
        });
    }
    else{
        return false;
    }
});
function submitCreateForms(data){

    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('forms.store')}}",
        type: "post",
        // contentType: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                Swal.fire({
                    title: "Form!",
                    text: "Form created successfully.",
                    icon: "success",
                }).then((result) => {
                    window.location = "{{url('forms')}}"//'/player_detail?username=' + name;
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
}
</script>
@endsection