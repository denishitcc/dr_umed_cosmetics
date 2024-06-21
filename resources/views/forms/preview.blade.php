<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Preview</title>
    <link rel="stylesheet" href="{{ asset('js/formiojs/dist/formio.full.min.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('js/bootstrap/dist/css/bootstrap.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('js/@formio/contrib/dist/formio-contrib.css') }}"> --}}
</head>
<body>
    <div class="w-50 m-auto">
        <div class="card">
            <div class="client-preview-banner js-client-preview-banner p-3 text-center">
                <i class="fa fa-eye"></i> You are in preview mode.
                <a class="js-return-to-builder" target="_parent" href="{{ route('forms.show', $forms->id) }}">Return to
                    builder.</a>
            </div>
            <div class="content ">
                <div id="topBannerSection" class="text-center">
                    <div id="bannerTop">
                        <div class="acctBtns"></div> <!-- temporary spacer .. collapses too narrow without -->
                        <h2 class="my-3">Dr Umed Cosmetic and Injectables</h2>
                    </div>
                </div>
                <div class="form-group text-center">
                    @if ($user->banner_image != '')
                        <img src="{{ asset('/storage/images/banner_image/' . $user->banner_image) }}" alt=""
                            id="imgBannerPreview">
                    @else
                        <img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt=""
                            id="imgBannerPreview">
                    @endif
                </div>
                <div class="p-4">
                    <h4>{{ $forms->title }}</h4>
                    <hr>
                    <label data-form_json="{{ $forms->form_json }}" id="formxml"></label>
                    <div id="fb-editor"></div>
                </div>
            </div>
        </div>
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