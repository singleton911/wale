

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Market Canary</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <p>{{ $publickey }}</p>
                <p>{{ $messenc }}</p>
        </div>
    </div>
    </div>
    @include('User.footer')
</body>

</html>
