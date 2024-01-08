<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Market Canary</title>
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
                <h1>Canary's</h1>
                {{-- @foreach ($canaries as $canary) --}}
                    <div class="canary-div">
                        <p>Title</p>
                        <p>contents</p>
                    </div>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
    </div>
    <style>
        h1{
            text-align: center;
            color: var(--main-color);
        }


.canary-div {
  margin-bottom: 1.4em;
  border-radius: 8px;
  box-shadow: var(--shadow);
  color: var(--dark-color-text);
  border: 1px solid grey;
  border-radius: .5rem;
}

p{
  color: var(--dark-color-text);
  margin-left: 2em;
  margin-bottom: 1em;
  word-wrap: break-word;

}


    </style>
    @include('User.footer')
</body>

</html>
