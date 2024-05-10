<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Preview</title>
    <link rel="stylesheet" href="{{ asset('js/formiojs/dist/formio.full.min.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
       {{-- <link rel="stylesheet" href="{{ asset('js/bootstrap/dist/css/bootstrap.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('js/@formio/contrib/dist/formio-contrib.css') }}"> --}}
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
        <h4>{{ $forms->title }}</h4>
        <hr>
        <label data-form_json="{{ $forms->form_json }}" id="formxml"></label>
        <div id="fb-editor"></div>
    </div>
    <script src="{{ asset('js/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/@formio/js/dist/formio.form.min.js') }}"></script>
    <script src="{{ asset('js/formiojs/dist/formio.full.min.js') }}"></script>
    <script src="{{ asset('js/@formio/js/dist/formio.full.js') }}"></script>
    <script src="{{ asset('js/section_break.js') }}"></script>
    <script src="{{ asset('js/preview.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>