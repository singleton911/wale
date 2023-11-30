<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>WHALES MARKET | STORE</title>
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                @if ($user->store_status == 'in_active')
                <h3>Creating New Store</h3>
                <hr>
                @if ($errors->any())
                    <ul style="list-style: none">
                        @foreach ($errors->all() as $error)
                            <li style="color:red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div>
                    @if ($user->twofa_enable == 'no')
                        <p
                            style="text-align: center; background-color: rgb(255, 239, 238); padding: 8px; border: none; margin-bottom: 16px; box-sizing: border-box; border-radius: 5px; color: rgb(90, 8, 1); font-family:Verdana, Geneva, Tahoma, sans-serif;">
                            Two-Factor Authentication is Disabled, add your public pgp key that match your public name
                            and check
                            the `enable 2FA box` to enable 2FA! for you to continue!!! <br><br>Sorry Mate ༼ つ ◕_◕ ༽つ</p>
                    @else
                        <form action="" method="post">
                            @csrf
                            <input type="text" class="publicName" name="store_key" placeholder="Enter your store key (64-128 characters)"
                                required><br>
                            <span class="cls-1 publicName-spn">You can find your store key, <br> In Market > Settings >
                                Account >
                                Store key.</span><br>
                            <button type="submit" name="login" class="login"><img
                                    src="data:image/png;base64,{{ $icon['login'] }}" width="30"
                                    class="icon-filter"></button>
                        </form>
                    @endif
                </div>

                @else

                @include('Store.createStore')
                @endif
            </div>
        </div>
    </div>
    @include('User.footer')
</body>

</html>
