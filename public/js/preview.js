jQuery(function ($) {
    var formjson = $("#formxml").data('form_json');
    Formio.createForm(document.getElementById('fb-editor'), formjson, {
        // readOnly: true
    }).then(function (form) {
        form.submission = {
            data: {
                firstName: 'Joe',
                lastName: 'Smith'
            }
        };
        form.on('submit', (submission) => {
            console.log(submission);
            // submission.emit(true);
            console.log('The form was just submitted!!!');
        });
        form.on('change', function(changed) {
            console.log('Form was changed', changed);
        });
    })
});