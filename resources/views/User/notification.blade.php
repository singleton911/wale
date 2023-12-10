<style>
    /* CSS Style */
    .notification-container {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 15px;
        background-color: #f0f0f0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .notification-container img {
        margin-right: 15px;
        border-radius: 50%;
    }

    .notification-container.read {
        background-color: #f9f9f9;
        /* Background color for read notifications */
    }

    .notification-content {
        flex: 1;
    }

    .notification-content span {
        margin-right: 15px;
        font-weight: bold;
    }

    .notification-reference {
        color: #888;
        margin-top: 5px;
        font-size: 0.9em;
    }

    .notification-time {
        color: #aaa;
        font-size: 0.8em;
    }

    .notification-message {
        margin-top: 10px;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Notifications</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="main-div">
        <div class="notific-container">

            <h1 class="notifications-h1">__Notifications</h1>
            <p class="notifications-p">Notification older than 30 days will be deleted autmatically!</p>

            @forelse ($user->notifications->sortByDesc('created_at') as $notification)
                <div class="notification-container {{ $notification->is_read ? 'read' : '' }}">
                    {{-- $notification->notificationType->icon --}}
                    <img src="data:image/jpeg;base64,{{ $icon[$notification->notificationType->icon] }}" alt="" width="30">
                    <div class="notification-content">
                        <div style="display: flex;">
                            <span>{{ $notification->user->public_name }}</span>
                            <span>{{ $notification->notificationType->name }}</span>
                            <span>Reference #WM{{ $notification->created_at->timestamp }}</span>
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                            <form
                                action="/notification/{{ $notification->created_at->timestamp }}/{{ $notification->id }}"
                                method="post">
                                @csrf
                                @if (!$notification->is_read)
                                    <input type="submit" name="read" id="" class="active"
                                        value="Mark as read" style="cursor: pointer;">
                                @endif
                                <input type="submit" name="delete" class="delete" id="" value="Delete"
                                    style="cursor: pointer;">
                            </form>
                        </div>
                        <p class="notification-message" style="margin-top: 0px; font-size: .9rem">{{ $notification->notificationType->content }}
                            @if ($notification->notificationType->icon == 'order')
                                <a href="/order/{{ $notification->order->created_at->timestamp }}/{{ $notification->option_id }}"
                                    style="font-size: 1rem; text-decoration:underline;">see order details here</a>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; font-size: 1.2rem;">You don't have any notification.</p>
            @endforelse
        </div>
    </div>

    @include('User.footer')
</body>

</html>
