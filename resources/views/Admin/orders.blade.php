<h1 class="notifications-h1" style="text-transform: capitalize"> Orders({{ $orders->count() }})</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cost Per Item</th>
            <th>Quantity</th>
            <th>Payment Type</th>
            <th>Store</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($orders->sortBy('updated_at') as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>${{ $order->product->price }}</td>
                {{-- <td>647</td> --}}
                <td>{{ $order->quantity }}</td>
                <td class="{{ $order->product->payment_type }}">{{ '{'.$order->product->payment_type.'}' }}</td>
                <td>{{ $order->store->store_name }}</td>
                <td class="{{ $order->status }}">{{ $order->status }}</td>
                <td>{{ $order->created_at->DiffForHumans() }}</td>
                <td><a href="/order/{{ $order->created_at->timestamp }}/{{ $order->id }}">view</a></td>
            </tr>
        @empty
            <tr>
                <td colspan='7'>No {{ $action }} order found.</td>
            </tr>
        @endforelse
    </tbody>
</table>