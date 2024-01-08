<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > {{ $name }} > {{ $action }}</title>

    @if ($user->theme == 'dark')
        <link rel="stylesheet" href="{{ asset('dark.theme.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('white.theme.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta http-equiv="refresh" content="{{ session('session_timer') }};url=/kick/{{ $user->public_name }}/out">
</head>

<body>
{{-- <script>
    alert('Please disable javascript, > open new tap > type "about:config" > "accept an proceed if asked" > search javascript > look for "Javascript.enable" on right click on the 2 arrows and disable it" come here again refresh the page > "Done"');
</script> --}}

    @if (session('let_welcome'))
        @include('User.welcome')

    @elseif (session('ask_pgp'))
        @include('Auth.pgp')

    @else
        @include('User.navebar')

        {{-- @include('User.news') --}}

        @if ($name == 'store')
            @include('User.store')
        @else
            @include('User.action')
        @endif

        @include('User.footer')
    @endif
</body>

</html>
