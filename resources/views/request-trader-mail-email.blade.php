<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>

<p>Dear {{ $mailData['user']['name'] }},</p>
@if ( $subjectValue === 'New Shared Request' )
    <p>$mailData['sharedBy']['name'] . " has shared you a request titled " .  $mailData['request']['title']</p>
@else
    <p>"You have a matched request titled " . $mailData['request']['title']</p>
@endif

<p>To see the partner request click <a href="{{ route('notifications') }}">here</a></p>

<p>Thanks</p>

</body>

</html> 
