<div class="main-div">
    <div class="notific-container">
        <h1 class="notifications-h1" style="margin:0; padding:0px;;">_Support Ticket_</h1>
        <p class="notifications-p">Please only create new support ticket, if you do not have any (pending, open, eacalated) ticket!</p>
        @if ($errors->any)
            @foreach ($errors->all() as $error)
                <p style="color: red; text-align:cenetr;">{{ $error }}</p>
            @endforeach
        @endif
        @if (session('success'))
            <p style="color: green; text-align:center;">{{ session('success') }}</p>
        @endif
        @if (session('new_ticket'))
            <div>
                <form action="" method="post" class="support-form">
                    @csrf
                    <label for="receiver" class="subject-label" style="width: fit-content;">Subject: <input type="text"
                            name="subject" class="subject" style="border: none; font-size: 1rem;"
                            placeholder="Support Subject..." required> </label>
                            <input type="hidden" name="message_type" value="ticket">
                    <textarea name="contents" placeholder="Write your request message here... max 5K characters!" cols="30"
                        rows="10" required></textarea>
                    <input type="submit" class="submit-nxt" value="Send">
                </form>
            </div>
        @else
            <div style="text-align: center; margin-bottom: 1em;">
                <form action="" method="post">
                    @csrf
                    <input type="submit" name="new_ticket" value="Create New Ticket" class="input-listing">
                </form>
            </div>
        @endif


        <table class="notification-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($user->supports as $ticket)
                    <tr>
                        <td><a
                                href="/messages/{{ $ticket->conversation->created_at->timestamp }}/{{ $ticket->conversation_id }}">#TWM_{{ $ticket->created_at->timestamp }}</a>
                        </td>
                        <td class="{{ $ticket->staff != 0 ? $ticket->staff->role : '' }}">{{ $ticket->staff != 0 ? $ticket->staff->public_name : 'No Staff Yet' }}</td>
                        <th class="{{ $ticket->status }}">{{ $ticket->status }}</th>
                        <td><a
                                href="/messages/{{ $ticket->conversation->created_at->timestamp }}/{{ $ticket->conversation_id }}">View</a>
                        </td>
                        <th>{{ $ticket->created_at->diffForHumans() }}</th>
                    </tr>
                @empty
                    <tr>
                        <td colspan='4'>No support ticket found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
