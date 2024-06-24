<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Thank You</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="w-50 m-auto">
        <div class="card p-4">
            <div class="content">
                <div class="form-group text-center">
                    @if($user->banner_image!='')
                        <img src="{{ asset('/storage/images/banner_image/'.$user->banner_image) }}" alt="" id="imgBannerPreview">
                        @else
                        <img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt="" id="imgBannerPreview">
                    @endif
                </div>
                <div class="success-pop p-5 text-center" >
                    <img src="{{ asset('/storage/images/banner_image/success-icon.png') }}" alt="" class="mb-4" style="max-width: 12%;">
                    <span><h3>Thank you!</h3>You are now closing this window,or <a href="{{ route('serviceforms.formUser',[$apptid, $formid]) }}" >click here</a> if you'd like to review or change your answers</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>