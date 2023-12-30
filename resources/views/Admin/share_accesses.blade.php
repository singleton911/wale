<table>
    <thead>
        <tr>
            <th># ID</th>
            <th>Name</th>
            <th>Total Permissions</th>
            <th>Permissions</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($shares as $share)
            <tr>
                <td>#{{ $share->id }}</td>
                <td style="text-transform: uppercase;">{{ $share->user->public_name }}</td>
                <td>{{ $share->sharePermission->count() }}/12</td>
                <td>
                    <select name="" id="">
                        @foreach ($share->sharePermission as $permission)
                        <option value="">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="{{ $share->status }}">{{ $share->status }}</td>
                <td><form action="" method="post">
                    @csrf
                    <input type="hidden" name="user" value="{{ Crypt::encrypt($share->user_id) }}" id="">
                    <button type="submit"
                    style="font-size: .8rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                    name="edit">Edit Permissions</button>
                <button type="submit"
                    style="font-size: .8rem; background-color: darkred; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                    name="revoke">Revoke</button>
                    </form></td>
            </tr>
            @empty
            <tr>
                <td colspan="5">You don't have any shared access.</td>
            </tr>
            @endforelse

    </tbody>
</table>