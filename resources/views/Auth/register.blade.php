<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>WHALES MARKET | Auth > SignUp</title>
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="/"><img src="data:image/png;base64,{{ $icon['whale'] }}"></a><br>
        </div>
        <div class="img-name">
            <h1><span class="w">WHALES</span> <span class="m">MARKET</span></h1>
        </div>
        <div class="login-div">
            <h3>SignUp Page</h3>
            <hr>
            <form action="" method="POST">
                @if ($errors->any())
                <ul style="list-style-type: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                @csrf

                <input type="text" name="public_name" class="publicName" placeholder="Public Name*" required><br>
                <span class="cls-1 publicName-spn">Your public name should be descriptive, lowercase best.</span><br>
                <input type="text" name="private_name" class="privateName" placeholder="Private Name*" required><br>
                <span class="cls-1 privateName-spn">Your private name must be unique And should only be in
                    lowercase.</span><br>
                <input type="text" name="login_passphrase" class="login-phrase" placeholder="Login phrase*"
                    required><br>
                <span class="cls-1 login-phrase-spn">Your login phrase to know you are on the legit site!</span><br>
                <input type="number" name="pin_code" class="secretCode" placeholder="Secret code 6 digits*"
                    pattern="[1-9]*" minlength="6" maxlength="6" required><br>
                <span class="cls-1 secretCode-spn">Your secret code must <br> be between 6 and 6 digits in
                    length.</span><br>
                <input type="text" name="referral_link" class="secretCode"
                    placeholder="Referral Public Name (If you have)"><br><br>
                <input type="password" class="password" name="password" placeholder="Password*" required><br>
                <span class="cls-1 password-spn">Your Password must be at least 8 characters long and contain at least
                    one uppercase letter, one lowercase letter, and one symbol.</span><br>
                <input type="password" name="confirm_password" placeholder="Confirm Password*" required><br><br>
                <button type="submit" name="signup" class="signup"><img
                        src="data:image/png;base64,{{ $icon['login'] }}" width="30" class="icon-filter"></button>
            </form>
            <p class="no-account">Already have an account? <a href="/auth/login">Enter here</a></p><br>
            <center>
                <p class="cprght">Copyright &copy; 2023 Whales Market. All rights reserved.
                </p>
            </center>
        </div>
    </div>
</body>

</html>
