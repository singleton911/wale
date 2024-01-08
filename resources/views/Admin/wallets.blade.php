<h1 style="text-align: center;">Wallets({{ $wallets->count() }})</h1>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Owner</th>
            <th>Owner Role</th>
            <th>Balance</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($wallets as $wallet)
        <tr>
            <td>#{{ $wallet->id }}</td>
            <td>{{ $wallet->user->public_name }}</td>
            <td class="{{ $wallet->user->role }}">{{ $wallet->user->role }}</td>
            <td>{{ $wallet->balance}}</td>
            <td class="{{ $wallet->status }}">{{ $wallet->status }}</td>
            <td>{{ $wallet->created_at->DiffForHumans() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>