<div class="main-div">
    <div class="notific-container">
        <h1 class="notifications-h1" style="margin:0; padding:0px;;">_Messages_</h1>
        <p class="notifications-p">Read messages older than 10 days will be deleted autmatically!</p>
        @php
            $displayedConversations = [];
        @endphp
    
        @forelse ($user->messages->sortByDesc('created_at') as $message)
            @if ($message->conversation->id == $message->conversation_id)
                @if (!isset($displayedConversations[$message->conversation->id]))
                    <a href="messages/{{ $message->conversation->created_at->timestamp }}/{{ $message->conversation->id }}" class="notification-container">
                        <img src="data:image/jpeg;base64,
                        @if ($message->message_type == 'message')
                         {{ $icon['mail'] }}
                        @elseif ($message->message_type == 'ticket')
                        {{ $icon['plane-tickets'] }}
                        @else
                        {{ $icon['dispute'] }}
                        @endif
                        " alt="" width="30">
                        <div class="notification-content">
                            <div style="display: flex;">
                                <span>{{ $message->conversation->topic }}</span>
                                <span>Reference #WM{{ $message->conversation->created_at->timestamp }}</span>
                                <span class="notification-time">{{ $message->conversation->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="notification-message">
                                {{ Str::limit($message->content, 20, '......') }}
                                        @php
                                            $unread_message_counter = 0;
                                        @endphp
                                        @foreach ($message->conversation->participants->where('user_id', '!=', $user->id) as $participant)
                                            @foreach ($participant->messages as $message)
                                            @php
                                                $unread_message_counter += $message->status->where('user_id', $user->id)->where('is_read', 0)->count();
                                            @endphp
                                            @endforeach
                                        @endforeach
                                @if ($unread_message_counter > 0)
                                <span class="count-unread-messages">{{ $unread_message_counter }}</span>
                                @endif
                            </p>
                        </div>
                    </a>
                    @php
                        $displayedConversations[$message->conversation->id] = true;
                    @endphp
                @endif
            @endif
        @empty
            <p style="text-align: center; font-size: 1.2rem;">You don't have any message.</p>
        @endforelse
    </div>
    
</div>
