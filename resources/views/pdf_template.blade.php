<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appointmentform->forms->title }}</title>
</head>
<body>
    <table style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em; background-color: #fff; margin: auto;">
        <tr>
            <td style="text-align: center;">
               <img src="https://drumed.itcc.net.au/storage/images/banner_image/demo-banner%20(1).jpg" alt="company-logo" style="width: auto; max-width: 100% !important;">
            </td>
         </tr>
         <tr>
            <td>
               <h2 style="margin: 20px 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.5em; border-bottom: 2px solid #333; padding-bottom: 25px; line-height: normal;">
                 {{ $appointmentform->forms->title }}
                </h2>
            </td>
         </tr>
         {{-- {{ dd($originalform) }} --}}
         @foreach ($originalform as $key => $form)
            <tr>
                {{-- <td style="padding-bottom: 10px;">
                    <strong>Are you worried about your appearance in any way?</strong><br>
                    [X] Yes <br>
                    [&nbsp;] no
                </td> --}}

                @if ($form['type'] == 'textfield')
                    <td style="padding-bottom: 10px;">
                        <strong> {{ $form['label'] }} </strong><br>
                        <input type="text" style="height: 35px; width: 100%;" value="{{ $form['ans'] }}">
                    </td>
                @endif
                @if ($form['type'] == 'textarea')
                    <td style="padding-bottom: 10px;">
                        <strong> {{ $form['label'] }} </strong><br>
                        <textarea cols="30" rows="10" style="height: 35px; width: 100%;">{{ $form['ans'] }}</textarea>
                    </td>
                @endif
                @if ($form['type'] == 'radio')
                    <td style="padding-bottom: 10px;">
                        <strong> {{ $form['label'] }} </strong><br>
                        {{ $form['ans']  }}
                    </td>
                @endif
                @if ($form['type'] == 'content')
                    <td style="padding-bottom: 10px;">
                        {!! $form['html']  !!}
                    </td>
                 @endif
                @if ($form['type'] == 'signature')
                    <td style="padding-bottom: 10px;">
                        <strong> {{ $form['label'] }} </strong><br>
                        <img src="{{ $data['data']['signature'] }}" alt="">
                    </td>
                @endif
                @if ($form['type'] == 'datetime')
                    <td style="padding-bottom: 10px;">
                        <strong> {{ $form['label'] }} </strong><br>
                        {{ \Carbon\Carbon::parse($data['data']['dateTime'])->format('h:i a d M Y')}}
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
</body>
</html>
