<!DOCTYPE html>
    <html lang="en-US">
      <head>
      <meta charset="utf-8">
    </head>
    <body>
        <h3>Hi {{$name}},</h3>
        <p>We received a request to reset your Nectar API password for {{ $email }}. If you made this request,
          please click the link below to reset your password. If not, please ignore this email.</p>
        <a href="{{ url('/password/reset?email=' . $email . '&user_key=' . $confirm_identifier ) }}" target="_blank">Reset Password</a>
 </body>
 </html>