<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $name }} > {{ $action }}</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
</head>

<body>
    @include('User.navebar')

    <div class="container">
        <div class="main-div">
            <div class="dir">
                <div class="dir-div">
                    <a href="/">Go Back</a>
                </div>
                <div class="prices-div">
                    <span>BTC/USD: <span class="usd"></span></span>
                    <span>XMR/USD: <span class="usd"></span></span>
                </div>
            </div>
            <div class="notific-container">
                <h1 class="notifications-h1">Viewing > #OWM_{{ $order->created_at->timestamp }}</h1>
                <p style="text-align: center; margin-bottom:0px; text-decoration:underline">Please scrow down for
                    (dispute, feedback and note from store)!!!</p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; margin-bottom: 2em;">
                    For any additional information or inquiries, please don't hesitate to reach out to the store
                    directly.
                    <a style="font-size: 1em;"
                        href="/store/show/message/{{ $order->product->store->store_name }}/{{ $order->store_id }}"
                        target="_blank">
                        Click here to message the store
                    </a>
                </p>

                <p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
                    <span style="color: darkorange;">Initiate a Dispute:</span> This option is available if more than 3
                    days have passed since the order was created, and the status is not "pending." Click the button to
                    raise concerns or issues. Otherwise, you can simply "cancel" the order.
                </p>

                <p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
                    <span style="color: darkgreen;">Release this Order:</span> Click the button to confirm order
                    completion. This indicates a successful transaction and satisfaction.
                </p>

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
                            <td>{{ $order->extra_id != 1 ? $order->extraOption->cost : '0.00' }}</td>
                        </tr>
                        <tr>
                            <th>Total Cost </th>
                            <td>${{ number_format($order->product->price * $order->quantity + ($order->extra_id != 1 ? $order->extraOption->cost : '0.00'), 2) }}
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
                            <td>{{ $order->product->payment_type }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="{{ $order->status }}">{{ $order->status }}</td>
                        </tr>
                        <tr>
                            <th>Action</th>
                            <td>
                                <form action="" method="post">
                                    @csrf
                                    @switch($order->status)
                                        @case('pending')
                                            <input type="submit" name="cancel" class="cancel" value="Cancel this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('processing')
                                            <input type="submit" name="dispute" class="dispute" value="Dispute this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                            <input type="submit" name="release" class="release"
                                                value="release fund for this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('shipped')
                                            <input type="submit" name="dispute" class="dispute" value="Dispute this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                            <input type="submit" name="release" class="release"
                                                value="release fund for this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('delivered')
                                            <input type="submit" name="dispute" class="dispute" value="Dispute this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                            <input type="submit" name="release" class="release"
                                                value="release fund for this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('dispute')
                                            This order has been disputed, please see dispute process below.
                                        @break

                                        @case('sent')
                                            <input type="submit" name="dispute" class="dispute" value="Dispute this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                            <input type="submit" name="release" class="release"
                                                value="release fund for this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('dispatched')
                                            <input type="submit" name="dispute" class="dispute" value="Dispute this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                            <input type="submit" name="release" class="release"
                                                value="release fund for this order"
                                                style="cursor: pointer;  margin:.4em; font-weight:bold">
                                        @break

                                        @case('completed')
                                            This order has been completed, thank you!
                                        @break

                                        @case('cancelled')
                                            This order has been cancelled, sorry mate!
                                        @break

                                        @default
                                            Something is wrong with this order, please open a support ticket and paste this
                                            message #OWM_{{ $order->created_at->timestamp }}.
                                    @endswitch
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="text-align: center; margin-bottom:0px; text-decoration:underline">User Shipping Address or
                    Extra Notes</p>
                <textarea class="support-msg" cols="20" rows="5" style="width: 100%; margin: 1em 0px;">{{ $order->shipping_address ?? 'User provided no shipping address or extra notes.' }}</textarea>

                @if ($order->store_notes != null)
                    <p style="text-align: center; margin-bottom:0px; text-decoration:underline">Store Notes For The User
                    </p>
                    <textarea class="support-msg" cols="30" rows="5" style="width: 100%; margin: 1em 0px;">{{ $order->store_notes }}</textarea>
                @endif
                @if ($order->status == 'dispute')
                    @if ($order->dispute->conversation->messages->count() <= 0)
                        <p style="text-align: center;">This order is currently in the dispute process. Kindly provide
                            your reason below.</p>
                        <form action="" method="post" class="support-form">
                            @csrf
                            <textarea name="contents" class="support-msg" id="dispute" cols="90" rows="10"
                                placeholder="Dispute reason here... max characters 1K" required></textarea>
                            <br><br>
                            <input type="submit" class="submit-nxt" name="dispute_form" value="Send">
                        </form>
                    @endif
                    {{-- <p style="transition: opacity 0.3s ease; color: rgba(0, 0, 0, 0.7);">The funds have been
                            released to
                            the
                            store.
                            <br> Thank you for your honest services. Please leave a review for the store below.
                        </p> --}}



                    @if ($order->status == 'dispute')
                        @if ($order->dispute->conversation->messages->count() > 0)
                            <p style="text-align: center;">This order is currently undergoing a dispute process. Please
                                check its status below or respond to any unread messages.</p>
                            @if (session('new_message'))
                                <div>
                                    <form action="" method="post" class="message-reply-form">
                                        @csrf
                                        <textarea name="contents" class="support-msg" placeholder="Write your reply here... max 1K characters!"
                                            cols="30" rows="10" required></textarea>
                                        <input type="hidden" name="message_type"
                                            value="@foreach ($order->dispute->conversation->messages as $message){{ $message->message_type }} @endforeach">
                                        <input type="submit" class="submit-nxt" name="dispute_form" value="Send">
                                    </form>
                                </div>
                            @else
                                <div style="text-align: center; margin-bottom: 1em;">
                                    <form action="" method="post">
                                        @csrf
                                        <input type="submit" name="new_message" value="New Reply"
                                            class="input-listing">
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
                                                        style="margin-right:1em">/mod/System Mod</span>
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


                @if ($order->status == 'completed')
                    @include('User.leaveReview')
                @endif
            </div>
        </div>
    </div>

    @include('User.footer')
</body>

</html>
