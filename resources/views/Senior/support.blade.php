<p style="text-align: center">Support Tickets({{ $supports->count() }})</p>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Topic</th>
            <th>Sender Name</th>
            <th>Sender Role</th>
            <th>Saff</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($supports as $ticket)
            <tr>
                <td>#{{ $ticket->id }}</td>
                <td>{{ $ticket->conversation->topic }}</td>
                <td>{{ $ticket->user->public_name }}</td>
                <td>{{ $ticket->user->role }}</td>
                <td class="{{ $ticket->staff_id != null ? $ticket->staff->role : '' }}">{{ $ticket->staff_id != null ? $ticket->staff->public_name : 'No staff yet' }}</td>
                <td class="{{ $ticket->status }}">{{ $ticket->status }}</td>
                <td>{{ $ticket->created_at->DiffForHumans() }}</td>
                <td>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="support_id" value="{{ Crypt::encrypt($ticket->id) }}">

                        @if ($ticket->status != 'closed' && $ticket->staff_id == $user->id)
                            <a href="/senior/staff/show/ticket/{{ $ticket->conversation->created_at->timestamp }}/{{ $ticket->conversation_id }}"
                                style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                        @endif

                        @if ($ticket->staff_id == null)
                        <button type="submit"
                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                        name="join_support">Join</button>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>