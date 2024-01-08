<h1 style="text-align: center;">Escrows({{ $escrows->count() }})</h1>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Amount</th>
            <th>Order</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($escrows as $escrow)
            <tr class="self-container">
                <td>#{{ $escrow->id }}</td>
                <td>${{ $escrow->fiat_amount }}</td>
                <td>#{{ $escrow->order_id }}</td>
               <td class="{{ $escrow->status }}">{{ $escrow->status }}</td>
               <td>{{ $escrow->created_at->DiffForHumans() }}</td>
            </tr>
        </form>
    @empty

        <tr>
            <td colspan="5">
                <span class="no-notification">
                    Cart is currently empty.
                </span>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>