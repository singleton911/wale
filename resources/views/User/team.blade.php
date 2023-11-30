<style>
    .container-team {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        color: #ecf0f1;
        font-family: 'Arial', sans-serif;
    }

    .member {
        width: 300px;
        margin: 20px;
        background-color: #34495e;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .member:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .member img {
        width: 100%;
        height: auto;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .member-details {
        padding: 15px;
    }

    .member-name {
        font-size: 22px;
        font-weight: bold;
        margin-top: 10px;
    }

    .member-role {
        font-size: 18px;
        color: #95a5a6;
        margin-top: 5px;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Team</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <p style="text-align: center">Whales Market Team</p>
                <div class="container-team">
                    <div class="member">
                        <img src="data:image/png;base64,{{ $icon['osint'] }}">
                        <div class="member-details">
                            <div class="member-name">John Doe</div>
                            <div class="member-role">Admin</div>
                        </div>
                    </div>
                    <div class="member">
                        <img src="data:image/png;base64,{{ $icon['osint'] }}">
                        <div class="member-details">
                            <div class="member-name">Jane Smith</div>
                            <div class="member-role">Senior Moderator</div>
                        </div>
                    </div>
                    <div class="member">
                        <img src="data:image/png;base64,{{ $icon['osint'] }}">
                        <div class="member-details">
                            <div class="member-name">Alex Johnson</div>
                            <div class="member-role">Junior Moderator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('User.footer')
</body>

</html>
