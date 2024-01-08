<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Support Ticket</title>
    @if ($user->theme == 'dark')
    <link rel="stylesheet" href="{{ asset('dark.theme.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('white.theme.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('market.white.css') }}">
<meta http-equiv="refresh" content="{{ session('session_timer') }};url=/kick/{{ $user->public_name }}/out">

    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <h1 class="notifications-h1" style="margin:0; padding:0px;;">_Bug Reporting Form_</h1>
                <p class="notifications-p">Please only create new support ticket, if you do not have any (pending, open,
                    eacalated) ticket!</p>
                @if ($errors->any)
                    @foreach ($errors->all() as $error)
                        <p style="color: red; text-align:center">{{ $error }}</p>
                    @endforeach
                @endif
                @if (session('success'))
                    <p style="color: green; text-align:center;">{{ session('success') }}</p>
                @endif

                <form action="" method="post" class="support-form">
                    @csrf
                    <select class="select-opt" name="type" id="" required>
                        <option value="">---Select Bug Type---</option>
                        <option value="withdraw">Withdraw</option>
                        <option value="deposit">Deposit</option>
                        <option value="server">Server</option>
                        <option value="key failed">PGP key failed</option>
                        <option value="account  issue">Account issue</option>
                        <option value="styling">Styling Broken</option>
                        <option value="others">Others</option>
                    </select> <br> <br>
                    <textarea name="content" class="support-msg"
                        placeholder="Well Written Report Message here... lesst than 15K characters!" required></textarea>
                    <input type="submit" class="submit-nxt" name="send_report" value="Send">
                </form>
            </div>
        </div>
    </div>
    @include('User.footer')
</body>

</html>
