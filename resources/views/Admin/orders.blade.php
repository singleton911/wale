<div>
    <legend>Store > Orders</legend>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Listing</th>
                    <th>Buyer</th>
                    <th>No. Items</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($store->orders()->orderBy('updated_at', 'desc')->paginate(50) as  $order)
                <tr>

                    <td>{{ $order->product->product_name }}</td>
                    <td>{{ $order->user->public_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                    <td class="order-status-cls">{{ $order->status }}</td>
                    <td>
                        <form action="" method="post" style="margin-bottom: 0px;">
                            <input type="hidden" name="orderid" value="">
                            <a href="/store/order/" class="view-info">View</a>

                        </form>
                    </td>

                </tr>
                @empty
                    <tr>
                        <td colspan="6">Looks like you don't have any order yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
