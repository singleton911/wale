<p style="text-align: center">Market Stores ({{ $stores->count() }})</p>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Store Name</th>
            <th>Owner Name</th>
            <th>Balance</th>
            <th>Created At</th>
            <th>Owner Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stores as $store)
            <tr>
                <td>#{{ $store->id }}</td>
                <td>{{ $store->store_name }}</td>
                <td>{{ $store->user->public_name }}</td>
                <td>${{ $store->user->wallet->balance }}</td>
                <td>{{ $store->created_at->DiffForHumans() }}</td>
                <td>{{ $store->user->last_seen }}</td>

                <td class="{{ $store->user->store_status }}">{{ $store->user->store_status }}</td>
                <td>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="new_store_id" value="{{ Crypt::encrypt($store->id) }}">

                            <a href="/whales/admin/show/new store/{{ $store->created_at->timestamp }}/{{ $store->id }}"
                                style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">Review</a>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
