<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Preview</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
</head>
<body>
    <div class="client-preview-banner js-client-preview-banner">
        <i class="fa fa-eye"></i> You are in preview mode.
        <a class="js-return-to-builder" target="_parent" href="{{ route('forms.show', $forms->id) }}">Return to builder.</a>
    </div>
    <div class="content">
        <div id="topBannerSection">
            <div id="bannerTop" class="container">
                <div class="acctBtns"></div> <!-- temporary spacer .. collapses too narrow without -->
                <h1>Dr Umed Cosmetic and Injectables</h1>
            </div>
        </div>
        <div class="form-group">
            @if($user->banner_image!='')
                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/'.$user->banner_image) }}" alt="" id="imgBannerPreview"></div>
                @else
                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt="" id="imgBannerPreview"></div>
            @endif
        </div>
        <label data-form_json="{{ $forms->form_json }}" id="formxml"></label>
        <form ></form>
        <div id="fb-editor"></div>
    </div>
</body>
</html>
<script src="{{ asset('js/preview.js') }}"></script>