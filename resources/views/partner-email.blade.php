<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
	
@if ( $subjectValue === 'New Partner' )
    <p>Dear {{ $requestingUser->name }},</p>
    <p>Your partner request to {{ $confirmingUser->name }} has been accepted.</p>
@else
    <p>Dear {{ $confirmingUser->name }},</p>
    <p>You have got partner request from  {{ $requestingUser->name }}</p>
@endif

<p>To see the partner request click <a href="{{ route('notifications') }}">here</a></p>

<p>Thanks</p>

</body>

</html> 
