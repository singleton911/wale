@if (session('ddos_visited'))
    

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>WHALES MARKET | Auth > LogIn</title>
    <style>
            html {
        background-color: rgb(43, 43, 64);
        /*  rgb(43, 43, 64) rgba(0, 0, 0, 0) rgb(239, 242, 245)*/
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="/"><img src="data:image/png;base64,{{ $icon['whale'] }}"></a>
        </div>
        <div class="img-name">
            <h1><span class="w">WHALES</span> <span class="m">MARKET</span></h1>
        </div>
        
        <div style="display: flex; text-align: center; justify-content: center; align-items: center; margin-top:5px; font-weight: 900; color: #cdcbcb;">
            This Page will expire in:
            <span class="countdown"> </span>seconds
          </div>

        <div class="login-div">
            <h3>LogIn Page</h3><hr>
            <form action="" method="post">
                @if (session('success'))
                    <span style="color:green;">{{ session('success') }}</span>
                @endif
                @if ($errors->any())
                <ul style="list-style-type: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                @csrf
                <input type="text" name="private_name" class="privateName" placeholder="Private Name" required><br>
                <span class="cls-1 privateName-spn">Login with your private name only, <br> It is private no
                    worries.</span><br>
                <input type="password" name="password" placeholder="Password" required><br><br>

                <input type="number" name="session_timer" maxlength="3" minlength="2"
                    placeholder="Session Timer (in minutes 10 to 360)" required><br><br>
                <div id="capatcha-code-img">
                    <img src="/captcha" alt="none yet" srcset="">
                    <input type="text" id="captcha" maxlength="8" minlength="8" name="captcha" placeholder="Captcha..." required>
                </div> 
                <button type="submit" name="login" class="login"><img src="data:image/png;base64,{{ $icon['login'] }}" width="40" class="icon-filter"></button>
            </form>
            <p class="no-account">New Here? <a href="/auth/signup">Create account</a></p><br>
            <center>
                <p class="cprght"> Copyright &copy; 2024 Whales Market. All rights reserved.</p>
            </center>
        </div>
    </div>
</body>

</html>
@else
session: expired;
@endif
