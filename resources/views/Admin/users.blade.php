<p class="notifications-p">Users Table > Total users({{ $users->count() }})</p>

<div>
<form action="" method="post">
    <select name="sort_by_role" id="">
        <option value="">---Users Role---</option>
        <option value="user">User</option>
        <option value="store">Store</option>
        <option value="junior">Junior Mod</option>
        <option value="senior">Senior Mod</option>
        <option value="admin">Admin</option>
    </select>

    <select name="sort_by_status" id="">
        <option value="">---Users Status---</option>
        <option value="active">Active</option>
        <option value="banned">Banned</option>
        <option value="escalated'">Escalated'</option>
        <option value="vacation">Vacation</option>
    </select>


    <select name="sort_by_balance" id="">
        <option value="">---Wallet Balance---</option>
        <option value="lowest">Lowest balance</option>
        <option value="highest">Highest balance</option>
        <option value="no_wallet">No Wallet</option>
    </select>

    <select name="users_per_page" id="">
        <option value="">---Users Per Page---</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="150">150</option>
        <option value="250">250</option>
        <option value="500">500</option>
    </select>
<input type="text" placeholder="Enter user(id, public name, private name, role, status)">
    <input type="submit" value="Search">
</form>
</div>

<table class="notification-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>User</th>
            <th>Balance</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <form action="" method="post">@csrf
                <td>{{ $user->id }}</td>
                <td>{{ $user->public_name }}</td>
                <td>{{ !$user->wallet ? 'No wallet yet' :  $user->wallet->balance }}</td>
                <td class="{{ $user->role }}">{{ $user->role }}</td>
                <td class="{{ $user->status }}">{{ $user->status }}</td>
                <td>{{ $user->created_at->DiffForHumans() }}</td>
                <td><a href="/user/{{ $user->role }}/{{ $user->id }}" style="font-size:1rem; text-decoration:underline; margin-right: 1em;">View</a>
                    <input type="submit" class="banned" name="banned" value="Banned" style="cursor: pointer;">
                </td>
            </form>
            </tr>
        @endforeach
    </tbody>
</table>
