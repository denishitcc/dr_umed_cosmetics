var DU = {};
(function () {
    DU.form = {
        init: function (){
            this.addHandler();
        },

        addHandler: function (){
            var context = this;

            context.draftLiveStatus();
            context.changeStatus();
            context.formUpdate();
            context.formDelete();
            context.formBuilder();
        },

        draftLiveStatus: function(){
            if ($("input[name='status'][value='1']").prop("checked"))
            {
                $('.form_live').show();
                $('.form_draft').hide();
            }else{
                $('.form_draft').show();
                $('.form_live').hide();
            }
        },

        changeStatus: function(){
            var context = this;
            jQuery('.status').change(function(){
                context.draftLiveStatus();
            });
        },

        formBuilder: function(){
            var context = this;
            var formjson = $("#formxml").data('form_json');
            Formio.builder(document.getElementById('form-editor'), formjson, {}).then(function (builder) {
                builder.on('change', function () {
                    update(builder.schema);
                });
            });
        },

        formUpdate: function(){
            var context = this;
            $('#edit_form').on('submit' ,function(e){
                e.preventDefault();
                var serviceForm        = new FormData($('#create_forms')[0]);
                $.ajax({
                    headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: moduleConfig.updateForm,
                    type: 'POST',
                    data: serviceForm,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    // headers: {
                    //     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    // },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Forms!",
                                text: data.message,
                                info: "success",
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message,
                                info: "error",
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching events:', error);
                    }
                });
            });
        },

        formDelete: function(){
            var context = this;
            $('#deleteFormBtn').on('click' ,function(e){

                if(confirm("Are you sure you want to delete this form?")){
                    var id = $("#deleteFormBtn").data('formid');

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
                                    info: "success",
                                });
                                window.location.href = '/forms';
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: data.message,
                                    info: "error",
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
        }
    }

})();

function update(formData){
    var fid = $("#deleteFormBtn").data('formid');

    $.ajax({
        url: moduleConfig.updateHTMLFormContent,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'form_id'   : fid,
            'form_json' : formData
        },
        success: function (data) {
            if (data.success) {
                Swal.fire({
                    title: "Forms!",
                    text: data.message,
                    info: "success",
                });
                location.reload();
            } else {
                Swal.fire({
                    title: "Error!",
                    text: data.message,
                    info: "error",
                });
            }
        },
        error: function (error) {
            console.error('Error fetching events:', error);
        }
    });
}