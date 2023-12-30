<p style="text-align: center">Market Disputes ({{ $disputes->where('status', '!=', 'closed')->count() }})</p>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Order ID</th>
            <th>Amount</th>
            <th>Mediator</th>
            <th>Status</th>
            <th>Start At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($disputes as $dispute)
            <tr>
                <td>#{{ $dispute->id }}</td>
                <td>{{ $dispute->order_id }}</td>
                <td>$0.00</td>
                <td class="{{ $dispute->mediator_id != null ?  $dispute->moderator->role : '' }}">{{ $dispute->mediator_id != null ? $dispute->moderator->public_name : 'No moderator join yet.' }}</td>
                <td class="{{ $dispute->status }}">{{ $dispute->status }}</td>
                <td>{{ $dispute->created_at->DiffForHumans() }}</td>
                <td>
                    <form action="/senior/staff/{{ $user->public_name }}/do/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}" method="post">
                        @csrf
                        @if (($dispute->status != 'closed'&& $dispute->mediator_id == null) || $dispute->mediator_id == $user->id)
                            <a href="/senior/staff/{{ $user->public_name }}/show/dispute/{{ $dispute->created_at->timestamp }}/{{ $dispute->id }}"
                                style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                        @endif

                        @if ($dispute->mediator_id == null)
                        <button type="submit"
                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                        name="join_dispute">Join</button>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
