<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Card</title>
</head>
<body>
    <table style="width: 60%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em; background-color: #fff; margin: auto;">
        <tr>
            <td colspan="3" style="text-align: center;">
                <?php
                    $user = \App\Models\User::where('role_type', 'admin')->first();
                    $imageUrl = asset('storage/images/banner_image/' . $user->banner_image);
                ?>
                <img src="{{ $imageUrl }}" alt="">
                <!-- <img src="https://drumed.itcc.net.au/storage/images/banner_image/demo-banner%20(1).jpg" alt=""> -->
            </td>
        </tr>
        <tr>
            <td style="width: 10%;"></td>
            <td style="text-align: center; padding: 20px 20px 0 20px;">
                <strong>GIFT CARD</strong>
                <div style="padding: 20px; background: #f7fbff; border-radius: 20px; border: 2px dashed #a3bbd3; margin: 10px 0 0 0;">
                    Dr Umed Cosmetic and Injectables<br>has sent you a
                    <div style="font-size: 50px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; color: #0747A6; line-height: 1.3em;">${{$value}}</div>
                    to use at Dr Umed Cosmetic and Injectables
                </div>
            </td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 0.9rem; text-align: center; color: #0747A6; border-bottom: 1px solid #EBF5FF;">
                <strong>{{$notes}}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 0.9rem; text-align: center; font-size: 14px; line-height: normal;">
                Value: <strong>${{$value}}</strong><br>
                Gift Card number: <strong>{{$voucher_num}}</strong><br>
                Expiry date: <strong>{{ \Carbon\Carbon::parse($expiry_date)->format('d F Y') }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 0.9rem; text-align: center; line-height: normal;">
                <button type="button" style="background: #0747A6; border-color: #0747A6; text-align: center; vertical-align: middle; cursor: pointer; user-select: none; border-radius: 5px; box-shadow: none; padding: 12px 40px; font-weight: 500; color: #fff; border: 0; font-size: 18px;">Book Now</button>
            </td>
        </tr>
    </table>
</body>
</html>
