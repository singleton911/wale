
<legend>Support Tickets <form action="" method="post"><input type="submit" value="Open New Ticket" style="background-color: rgb(4, 61, 84); padding: 5px; cursor:pointer; border: 2px solid skyblue; color:#f1f1f1;"></form></legend>
<table>
    <thead>
        <tr>
          <th>ID</th>
          <th>SUBJECT</th>
          <th>STATUS</th>
          <th>Last Reply</th>
          <th>Staff</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($store->supports as $support)
      <tr>
        <td>{{ '#WMS'.strtotime($support->created_at) }}</td>
        <td>{{ $support->conversation->topic }}</td>
        <td>{{ $support->status }}</td>
        <td>{{ \Carbon\Carbon::parse($support->created_at)->diffForHumans() }}</td>
        <td>{{ $support->staff->public_name}}</td>
        <th>Action</th>
    </tr>
    @empty
        <tr>
          <td colspan="6">You don't have any support ticket.</td>
        </tr>
    @endforelse
    </tbody>
</table>
