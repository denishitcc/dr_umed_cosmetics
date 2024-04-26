jQuery(function ($) {
    var formxml = $("#formxml").data('form_json');
    var formRenderOpts = {
        dataType: 'json',
        formData: formxml
    };

    var renderedForm = $('<div>');
    renderedForm.formRender(formRenderOpts);
    renderedForm.html();
    $('#fb-editor').append(renderedForm);
});