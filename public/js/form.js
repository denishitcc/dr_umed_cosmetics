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

jQuery(function ($) {
    var formxml = $("#formxml").data('form_json');

    var templates = {
        break: function (fieldData) {
            return {
                field: '<hr class=' + fieldData.className + '>'
            };
        },
        signature: function (fieldData) {
            return {
                field: `<section class="signature-component">
                        <h1>Draw Signature</h1>
                        <h2>with mouse or touch</h2>
                        <canvas id="signature-pad" width="400" height="200"></canvas>
                    <div>
                        <button id="save">Save</button>
                        <button id="clear">Clear</button>
                        <button id="showPointsToggle">Show points?</button>
                    </div>
                    <p>
                    <br />
                    <a href="https://codepen.io/kunukn/pen/bgjzpb/" target="_blank">Throttling without lag example here</a><br />
                    <br />
                    <a href="https://github.com/szimek/signature_pad" target="_blank">Signature Pad</a> with custom Simplifying and Throttling
                    </p>
                </section>`
            }
        }
    };
    $(document.getElementById('fb-editor')).formBuilder({
        dataType: 'json',
        disabledAttrs: ['access'],
        disableFields: [
            'autocomplete',
            'button',
            'hidden',
            'number',
            'select'
        ],
        fieldRemoveWarn: false,
        controlPosition: 'left',
        inputSets: [
            {
                label: 'Section Break',
                name: 'section_break', // optional - one will be generated from the label if name not supplied
                showHeader: false, // optional - Use the label as the header for this set of inputs
                fields: [
                    {
                        type: 'break',
                        label: 'Section Break',
                    },
                ]
            },
            // {
            //     label: 'Signature',
            //     name: 'signature', // optional - one will be generated from the label if name not supplied
            //     showHeader: false, // optional - Use the label as the header for this set of inputs
            //     fields: [
            //         {
            //             type: 'signature',
            //             label: 'Signature',
            //         },
            //     ]
            // },
        ],
        disabledFieldButtons: {
            break: ['edit'], // disables the remove butotn for text fields
            signature: ['edit'], // disables the remove butotn for text fields
        },
        templates,
        formData: formxml,
        onSave: function (evt, formData) {
            console.log(formData);
            update(formData);
            // $('.render-wrap').formRender({ formData });
        },
    });
});


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