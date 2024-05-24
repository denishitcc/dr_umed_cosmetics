jQuery(function ($) {
    var formjson = $("#formxml").data('form_json');
    Formio.createForm(document.getElementById('fb-editor'), formjson, {
        // readOnly: true
    }).then(function (form) {
        form.on('submit', (submission) => {
            var form_id                 = $('#form_id').val(),
                appointment_id          = $('#appointment_id').val(),
                appointment_form_id     = $('#appointment_form_id').val(),
                formfilleddata  = submission.data;

            $.ajax({
                url: moduleConfig.serviceFormUpdate,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointment_id'        : appointment_id,
                    'form_id'               : form_id,
                    'form_user_data'        : formfilleddata,
                    'appointment_form_id'   : appointment_form_id
                },
                success: function (data) {
                    if (data.success) {
                        alert('Form filled successfully.');
                    } else {
                        alert('Something went wrong');
                    }
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        });
        form.on('change', function(changed) {
            // console.log('Form was changed', changed);
        });
    })
});