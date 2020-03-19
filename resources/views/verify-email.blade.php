<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
	
<p>Dear {{ $user->name }}</p>
<p>Your account has been created, please activate your account by clicking this link</p>
<p><a href="{{ route('verify',$user->email_verification_token) }}">
	{{ route('verify',$user->email_verification_token) }}
</a></p>

<p>Thanks</p>

</body>

</html> 