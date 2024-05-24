<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $forms->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('js/formiojs/dist/formio.full.min.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('js/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/@formio/contrib/dist/formio-contrib.css') }}">
</head>
<body>
    <div class="content">
        <div id="topBannerSection">
        </div>
        <div class="form-group">
            @if($user->banner_image!='')
                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/'.$user->banner_image) }}" alt="" id="imgBannerPreview"></div>
                @else
                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt="" id="imgBannerPreview"></div>
            @endif
        </div>
        <h4>{{ $forms->title }}</h4>
        <input type="hidden" id="appointment_id" name="appointment_id" value="{{ $appointment->appointment_id }}">
        <input type="hidden" id="form_id" name="form_id" value="{{ $appointment->form_id }}">
        <input type="hidden" id="appointment_form_id" name="appointment_form_id" value="{{ $appointment->id }}">
        {{-- <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}"> --}}
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
    <script type="text/javascript">
        var moduleConfig = {
            serviceFormUpdate:     "{!! route('serviceforms.serviceFormUpdate') !!}",
        };
    </script>
</body>
</html>