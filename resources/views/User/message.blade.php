<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Messages</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')

    <div class="main-div">
        <div class="notific-container">
            <h1 class="notifications-h1" style="margin:0; padding:0px;;">_Messages_</h1>
            <p class="notifications-p">Read messages older than 10 days will be deleted autmatically!</p>
            @forelse ($userConversations->sortByDesc('updated_at') as $userConversation)
                @foreach ($conversations->where('id', $userConversation->conversation_id) as $conversation)
                    <a href="/messages/{{ $conversation->created_at->timestamp }}/{{ $conversation->id }}"
                        class="notification-container">
                        @php
                            $latestMessage = $conversation
                                ->messages()
                                ->latest()
                                ->first();
                        @endphp
                        @if ($latestMessage)
                            <img src="data:image/jpeg;base64,
                            @if ($latestMessage->message_type == 'dispute') {{ $icon['dispute'] }}
                            @elseif ($latestMessage->message_type == 'ticket')
                            {{ $icon['plane-tickets'] }}
                            @else
                            {{ $icon['mail'] }} @endif 
                            "
                                alt="" class="icon-filter" width="40">
                        @else
                            <img src="data:image/jpeg;base64,{{ $icon['mail'] }}"alt="" class="icon-filter"
                                width="40">
                        @endif
                        <div class="notification-content">
                            <div style="display: flex;">
                                <span>{{ $conversation->topic }}</span>
                                <span>Reference #WM{{ $conversation->created_at->timestamp }}</span>
                                <span class="notification-time">{{ $conversation->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="notification-message">
                                @if ($latestMessage)
                                    {{ Str::limit($latestMessage->content, 50, '...') }}
                                @else
                                    No message send yet to this conversation...
                                @endif
                                @php
                                    $unread_message_counter = 0;
                                @endphp
                                @foreach ($conversation->messages as $message)
                                    @php
                                        $unread_message_counter += $message->status
                                            ->where('user_id', $user->id)
                                            ->where('is_read', 0)
                                            ->count();
                                    @endphp
                                @endforeach
                                @if ($unread_message_counter > 0)
                                    <span class="count-unread-messages">{{ $unread_message_counter }}</span>
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            @empty
              You do not have any message...
            @endforelse
        </div>

    </div>
    @include('User.footer')
</body>

</html>
