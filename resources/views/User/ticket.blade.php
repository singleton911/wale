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

<link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <h1 class="notifications-h1" style="margin:0; padding:0px;;">_Support Ticket_</h1>
                <p class="notifications-p">Please only create new support ticket, if you do not have any (pending, open,
                    eacalated) ticket!</p>
                @if ($errors->any)
                    @foreach ($errors->all() as $error)
                        <p style="color: red; text-align:cenetr;">{{ $error }}</p>
                    @endforeach
                @endif
                @if (session('success'))
                    <p style="color: green; text-align:center;">{{ session('success') }}</p>
                @endif
                @if (session('new_ticket'))
                    <div>
                        <form action="" method="post" class="support-form">
                            @csrf
                            <label for="receiver" class="subject-label" style="width: fit-content;">Subject: <input
                                    type="text" name="subject" class="subject" style="border: none; font-size: 1rem;"
                                    placeholder="Support Subject..." required> </label>
                            <input type="hidden" name="message_type" value="ticket">
                            <textarea name="contents" placeholder="Write your request message here... max 5K characters!" cols="30"
                                rows="10" required></textarea>
                            <input type="submit" class="submit-nxt" value="Send">
                        </form>
                    </div>
                @else
                    <div style="text-align: center; margin-bottom: 1em;">
                        <form action="" method="post">
                            @csrf
                            <input type="submit" name="new_ticket" value="Create New Ticket" class="input-listing">
                        </form>
                    </div>
                @endif


                <table>
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Staff</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($user->supports as $ticket)
                            <tr>
                                <td><a
                                        href="/messages/{{ $ticket->conversation->created_at->timestamp }}/{{ $ticket->conversation_id }}">#TWM_{{ $ticket->created_at->timestamp }}</a>
                                </td>
                                <td class="{{ $ticket->staff_id != null ? $ticket->staff->role : '' }}">
                                    {{ $ticket->staff != null ? $ticket->staff->public_name : 'No Staff Yet' }}</td>
                                <td class="{{ $ticket->status }}">{{ $ticket->status }}</td>
                                <td><a
                                        href="/messages/{{ $ticket->conversation->created_at->timestamp }}/{{ $ticket->conversation_id }}">View</a>
                                </td>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan='4'>No support ticket found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('User.footer')
</body>

</html>
