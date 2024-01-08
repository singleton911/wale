<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ @asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('store.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('filter.css') }}">
    <title>Whales Market | {{ $action != null ? $action : $user->public_name . ' Moderator' }}</title>
</head>

<body>
    @include('Senior.naveBar')

    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <h1 class="notifications-h1">Viewing Dispute > #OWM_{{ $order->created_at->timestamp }}</h1>
                <p style="text-align: center; margin-bottom:0px; text-decoration:underline">Please scrow down for
                    (dispute replies, feedback and note from store and user)!!!</p>
                <table>
                    <tbody>
                        <tr>
                            <th>Item</th>
                            <td>
                                <a
                                    href="/listing/{{ $order->product->created_at->timestamp }}/{{ $order->product_id }}">{{ $order->product->product_name }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Cost Per Item</th>
                            <td>${{ $order->product->price }}</td>
                        </tr>
                        <tr>
                            <th>Extra Cost</th>
                            <td>${{ $order->extra_id != null ? $order->extraOption->cost : '0.00' }}</td>
                        </tr>
                        <tr>
                            <th>Total Cost </th>
                            <td>${{ number_format($order->product->price * $order->quantity + ($order->extra_id != null ? $order->extraOption->cost : '0.00'), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $order->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $order->updated_at->diffForHumans() }}</td>
                        </tr>
                        <tr>
                            <th>Payment</th>
                            <td class="{{ $order->product->payment_type }}">
                                {{ '{' . $order->product->payment_type . '}' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="{{ $order->status }}">{{ $order->status }}</td>
                        </tr>
                        <tr>
                            <th>Action</th>
                            <td>
                                This order has been disputed, please see dispute process below.
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="text-align: center; margin-bottom:0px; text-decoration:underline">User Shipping Address or
                    Extra Notes</p>
                <textarea class="support-msg" cols="20" rows="5" style="width: 100%; margin: 1em 0px;"
                    {{ $order->status == 'dispute' ? 'disabled' : '' }}>{{ $order->shipping_address ?? 'User provided no shipping address or extra notes.' }}</textarea>

                @if ($order->store_notes != null)
                    <p style="text-align: center; margin-bottom:0px; text-decoration:underline">Store Notes For The
                        User
                    </p>
                    <textarea class="support-msg" cols="30" rows="5" style="width: 100%; margin: 1em 0px;"
                        {{ $order->status == 'dispute' ? 'disabled' : '' }}>{{ $order->store_notes }}</textarea>
                @endif
                @if ($order->status == 'dispute')
                    @if ($order->dispute->conversation->messages->count() <= 0)
                        <p style="text-align: center;">This order is currently in the dispute process. Kindly provide
                            your reason below.</p>
                        <form action="/senior/staff/{{ $user->public_name }}/do/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}" method="post" class="support-form">
                            @csrf
                            <textarea name="contents" class="support-msg" id="dispute" cols="90" rows="10"
                                placeholder="Dispute reason here... max characters 1K" required></textarea>
                            <br><br>
                            <input type="submit" class="submit-nxt" name="dispute_form" value="Send">
                        </form>
                    @endif
                    @if ($order->status == 'dispute')
                        @if ($order->dispute->conversation->messages->count() > 0)
                            <p style="text-align: center;">This order is currently undergoing a dispute process. Please
                                check its status below or respond to any unread messages.</p>
                            <form action="/senior/staff/{{ $user->public_name }}/do/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}" method="post" class="message-reply-form">
                                @csrf
                                <div style="text-align: center; margin-bottom: 1em;">
                                    @if ($order->dispute->winner == 'none' && $order->dispute->refund_initiated == 'Store')
                                        {{-- Accept funds when the store releases your money --}}
                                        <input type="submit" name="accept_store_fund"
                                            value="Accept {{ $order->dispute->partial_percent }}% Store Refund"
                                            class="input-listing"
                                            style="background-color: #2ecc71; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; animation: blink 1s infinite;">

                                        {{-- Decline refund from user --}}
                                        <input type="submit" name="decline_store_refund" value="Decline"
                                            class="input-listing"
                                            style="background-color: red; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                                    @endif
                                    <style>
                                        @keyframes blink {
                                            50% {
                                                background-color: #3498db;
                                                /* Change to a different color at 50% */
                                            }
                                        }
                                    </style>
                                    @if ($order->dispute->winner == 'none' && $order->dispute->refund_initiated == 'none')
                                        {{-- Release funds to store --}}
                                        <input type="submit" name="release" value="Release Fund To Store"
                                            class="input-listing"
                                            style="background-color: #3498db; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                                    @endif
                                    @if (
                                        $order->dispute->winner == 'none' &&
                                            $order->dispute->refund_accept == 'none' &&
                                            $order->dispute->refund_initiated == 'none')
                                        {{-- Ask for a partial refund --}}
                                        <input type="submit" name="partial_refund" value="Start Partial Refund"
                                            class="input-listing"
                                            style="background-color: #e74c3c; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                                    @endif
                                    @if ($order->dispute->status != 'closed')
                                        {{-- Add new reply for the dispute --}}
                                        <input type="submit" name="new_message" value="New Reply"
                                            class="input-listing">
                                </div>
                        @endif

                        </form>
                        {{-- pertial percentage request form --}}
                        @if (session('partial_refund_form'))
                            <div style="margin-top: 1em;">
                                <form action="/senior/staff/{{ $user->public_name }}/do/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}" method="post" class="message-reply-form">
                                    @csrf
                                    <input type="number" name="partial_percent" value=""
                                        placeholder="Enter here the partial percentage  (E.G., 1 - 100)! "
                                        style="padding:5px;" min="1" max="100" required>
                                    <input type="submit" class="submit-nxt" value="Send">
                                </form>
                            </div>
                        @endif

                        @if (session('new_message'))
                            <div style="margin-top: 1em;">
                                <form action="/senior/staff/{{ $user->public_name }}/do/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}" method="post" class="message-reply-form">
                                    @csrf
                                    <textarea name="contents" class="support-msg" placeholder="Write your reply here... max 1K characters!" cols="30"
                                        rows="10" required></textarea>
                                    <input type="hidden" name="message_type" value="dispute">
                                    <input type="submit" class="submit-nxt" name="dispute_form" value="Send">
                                </form>
                            </div>
                        @endif

                        <p style="text-transform:capitalize; text-align:center; margin: .3em 0px;"
                            class="{{ $order->dispute->status == 'closed' ? 'closed' : 'pending' }}">Dispute
                            Status:
                            {{ $order->dispute->status }}</p>
                        <div class="message-div">
                            @if ($order->dispute->status !== 'closed')
                                @forelse ($order->dispute->conversation->messages->sortByDesc('created_at') as $message)
                                    @if ($message->user_id != null)
                                        <div
                                            class="chat-message @if ($message->user->id === $user->id) {{ 'message-right' }} @else {{ 'message-left' }} @endif">
                                            <p>{{ $message->content }}</p>
                                            <p class="owner "> <span
                                                    class="{{ $message->user->role == 'store' ? 'storem' : $message->user->role }}"
                                                    style="margin-right:1em">
                                                    /@if ($message->user->role == 'junior' || $message->user->role == 'senior')
                                                        {{ $message->user->role . ' mod' }}
                                                    @else
                                                        {{ $message->user->role }}
                                                    @endif/{{ $message->user->public_name }}
                                                </span>

                                                @foreach ($message->status as $status)
                                                    @if ($status->user_id != $user->id && $status->user_id != $message->user->id)
                                                        <span
                                                            class="{{ $status->is_read == 1 ? 'message-read' : 'message-unread' }}">[{{ $status->user->role == 'store' ? $status->user->store->store_name : $status->user->public_name }}
                                                            {{ $status->is_read == 1 ? 'read' : 'unread' }}],
                                                        </span>
                                                    @elseif ($status->user_id == $user->id && $status->user_id != $message->user->id)
                                                        <span
                                                            class="{{ $status->is_read == 1 ? 'message-read' : 'message-unread' }}">[{{ $status->user->role == 'store' ? $status->user->store->store_name : $status->user->public_name }}
                                                            {{ $status->is_read == 1 ? 'read' : 'unread' }}],
                                                        </span>
                                                    @endif
                                                @endforeach
                                                sent {{ $message->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="chat-message message-left">
                                            <p>{{ $message->content }}</p>
                                            <p class="owner"> <span class="senior"
                                                    style="margin-right:1em">/mod/System
                                                    Mod</span>
                                                @foreach ($message->status as $status)
                                                    <span
                                                        class="{{ $status->is_read == 1 ? 'message-read' : 'message-unread' }}">[{{ $status->user->role == 'store' ? $status->user->store->store_name : $status->user->public_name }}
                                                        {{ $status->is_read == 1 ? 'read' : 'unread' }}], </span>
                                                @endforeach
                                                sent {{ $message->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    @endif
                                @empty
                                    No message found for this dispute.
                                @endforelse
                            @else
                                <p style="color: green; text-align: center;">The dispute regarding this order
                                    has
                                    been resolved, and {{ $order->dispute->winner }} emerged victorious.</p>
                            @endif
                        </div>
                    @endif
                @endif
                @endif
            </div>
        </div>
    </div>

    @include('Senior.footer')
</body>

</html>
