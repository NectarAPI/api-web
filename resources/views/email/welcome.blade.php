<!DOCTYPE html>
    <html lang="en-US">
      <head>
      <meta charset="utf-8">
    </head>
    <body>
        <h3>Hi {{$name}},</h3>
        <p>Please click the link below to verify your registration</p>
        <a href="{{ url('/verify?email=' . $email . '&user_key=' . $confirm_identifier ) }}" target="_blank">Verify Registration</a>
 </body>
 </html>