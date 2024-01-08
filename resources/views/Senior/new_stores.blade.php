<p style="text-align: center">Market New Stores ({{ $new_stores->count() }})</p>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Store Name</th>
            <th>Owner Name</th>
            <th>Created At</th>
            <th>Owner Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($new_stores as $new_store)
            <tr>
                <td>#{{ $new_store->id }}</td>
                <td>{{ $new_store->store_name }}</td>
                <td>{{ $new_store->user->public_name }}</td>
                <td>{{ $new_store->created_at->DiffForHumans() }}</td>
                <td>{{ $new_store->user->last_seen }}</td>
                <td class="{{ $new_store->user->store_status }}">{{ $new_store->user->store_status }}</td>
                <td>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="new_store_id" value="{{ Crypt::encrypt($new_store->id) }}">

                            <a href="/senior/staff/show/new store/{{ $new_store->created_at->timestamp }}/{{ $new_store->id }}"
                                style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">Review</a>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
