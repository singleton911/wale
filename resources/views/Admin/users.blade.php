<p style="text-align: center">Market Users ({{ $users->count() }})</p>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Public Name</th>
            <th>Role</th>
            <th>Total Orders</th>
            <th>Member Since</th>
            <th>Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>{{ $user->public_name }}</td>
                <td class="{{ $user->role }}">{{ $user->role }}</td>
                <td>{{ $user->total_orders }}</td>
                <td>{{ $user->created_at->DiffForHumans() }}</td>
                <td>{{ $user->last_seen }}</td>
                <td class="{{ $user->status }}">{{ $user->status }}</td>
                <td>
                    <a href="/senior/staff/show/user/{{ $user->created_at->timestamp }}/{{ $user->id }}"
                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
