<h1 style="text-align: center;">Conversations({{ $conversations->count() }})</h1>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Topic</th>
            <th>Total Messages</th>
            <th>Participants</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($conversations as $conversation)
            <tr class="self-container">
                <td>#{{ $conversation->id }}</td>
                <td>{{ $conversation->topic }}</td>
                <td>{{ $conversation->messages->count() }}</td>
               <td>{{ $conversation->participants->count() }}</td>
               <td>{{ $conversation->created_at->DiffForHumans() }}</td>
            </tr>
        </form>
    @empty

        <tr>
            <td colspan="10">
                <span class="no-notification">
                    Cart is currently empty.
                </span>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>