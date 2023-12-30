<h1 style="text-align: center;">Coupons({{ $coupons->count() }})</h1>
<table>
    <thead>
        <tr>
            <th># Product</th>
            <th>Coupon Code</th>
            <th>Type</th>
            <th>Discount</th>
            <th>Expired Date</th>
            <th>Usage Limit</th>
            <th>Time Used</th>
            <th>Status</th>
            <th>Created At</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($coupons as $promo)
            <tr>
                <td>#{{ $promo->product->id }}</td>
                <td>{{ $promo->code }}</td>
                <td>{{ $promo->type }}</td>
                <td>{{ $promo->type == 'fixed' ? '$' . $promo->discount : $promo->discount . '%' }}</td>
                <td>{{ $promo->expiration_date }}</td>
                <td>{{ $promo->usage_limit }}</td>
                <td>{{ $promo->times_used }}</td>
                <td {{ $promo->status == 'expired' ? 'style=color:red;' : 'class=active' }}>{{ $promo->status }}</td>
                <td>{{ $promo->updated_at->DiffForHumans() }}</td>
                {{-- <td>
                    <form action="" method="post" style="display: flex; gap:.5em;">
                        @csrf
                        <input type="hidden" name="promo_id" value="{{ Crypt::encrypt($promo->id) }}">
                        <input type="submit" style="font-size: .7rem; background-color: darkred; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                            name="delete" value="Delete">
                    </form>
                </td> --}}
            </tr>
        @empty
            <td colspan="8">There are no coupons code yet....</td>
        @endforelse
    </tbody>
</table>