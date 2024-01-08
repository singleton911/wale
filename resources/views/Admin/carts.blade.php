<h1 style="text-align: center;">Carts({{ $carts->count() }})</h1>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Extra/Shipping</th>
            <th>Price/Item</th>
            <th>Discount</th>
            <th>Note/Address</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($user->carts as $cart)
            <tr class="self-container">
                <td>#{{ $cart->id }}</td>
                <td>{{ $cart->user->public_name }}</td>
                <td>{{ Str::limit($cart->product->product_name, 3, '...') }}</td>
                <td>{{ $cart->quantity }}</td>
                <td>+${{ $cart->extraShipping->cost ?? '0.00' }}</td>
                <td>${{ $cart->product->price }}</td>
                <td>${{ $cart->discount }}</td>
                <td>
                    <textarea name="note" id="" style="width:100%;"
                        placeholder="Write here you note like: address or any note to send to this product owner." rows="2">{{ $cart->note != null ? $cart->note : '' }}</textarea>
                </td>
                <td>{{ $cart->created_at->DiffForHumans() }}</td>
            </tr>
        </form>
    @empty

        <tr>
            <td colspan="10">
                <span class="no-notification">
                    Cart is currently empty.
                </span>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>