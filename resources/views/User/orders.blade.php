<div class="main-div">
    <div class="dir">
        <div class="dir-div">
            <a href="/">Go Back</a>
            <span class="notifications-h1" style="margin-left: 20px;"> {{ $action }} ▶️ Orders </span>
        </div>
        <div class="prices-div">
            <span>BTC/USD: <span class="usd"></span></span>
            <span>XMR/USD: <span class="usd"></span></span>
        </div>
    </div>
    <div class="notific-container">
        <h1 class="notifications-h1" style="text-transform: capitalize"> {{ $action }} > Orders({{ $action != 'all' ? $user->orders->where('status', $action)->count() : $user->orders->count() }})</h1>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Cost Per Item</th>
                    {{-- <th>Total Cost</th> --}}
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                {{-- @if ($action = 'pending') ->where('status', $action) --}}
                @forelse ($user->orders->sortByDesc('updated_at') as $order)
                {{-- @else
                @forelse ($user->orders->where('status', $action) as $order)
                @endif --}}
                    <tr>
                        <td><a href="/listing/{{ $order->product->created_at->timestamp }}/{{ $order->product_id }}">#WM{{ $order->product->created_at->timestamp }}</a></td>
                        <td>${{ $order->product->price }}</td>
                        {{-- <td>647</td> --}}
                        <td>{{ $order->quantity }}</td>
                        <td class="{{ $order->status }}">{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d/m/y') }}</td>
                        <td><a href="/order/{{ $order->created_at->timestamp }}/{{ $order->id }}">view</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan='7'>No {{ $action }} order found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- <form action="" method="post"> 
    @if ($action == 'completed')
    <input type="submit" name="delete" style="color: green;  border-radius: 3px; border: none; font-size: 1.4em; cursor: pointer; margin:0px 1em;" value="View">
    <input type="submit" name="delete" style="color: red;  border-radius: 3px; border: none; font-size: 1.2em; cursor: pointer;" value="Delete">
    @elseif($action === 'pending')
    <input type="submit" name="delete" style="color: green;  border-radius: 3px; border: none; font-size: 1.4em; cursor: pointer; margin:0px 1em;" value="View">
    <input type="submit" name="delete" style="color: darkred;  border-radius: 3px; border: none; font-size: 1.2em; cursor: pointer;" value="Cancel">
    @elseif($action != 'cancelled')
    <input type="submit" name="delete" style="color: green;  border-radius: 3px; border: none; font-size: 1.4em; cursor: pointer; margin:0px 1em;" value="View">
    <input type="submit" name="delete" style="color: darkorange;  border-radius: 3px; border: none; font-size: 1.2em; cursor: pointer;" value="Dispute">
    @else
    @endif
</form> --}}