<h3 style="text-align: center">Stores and Products Reports ({{ $reports->count() }})</h3>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Reporter Name</th>
            <th>Reported Name</th>
            <th>Reported Type</th>
            <th>Status</th>
            <th>Reported At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>#{{ $report->id }}</td>
                <td>{{ $report->user->public_name }}</td>

                @if ($report->is_store == 1)
                    <td>{{ $report->store->store_name }}</td>
                    <td>Store</td>
                @else
                    <td>{{ Str::limit($report->product->product_name, 10, '...') }}</td>
                    <td>Product</td>
                @endif
                <td>{{ $report->status }}</td>
                <td>{{ $report->created_at->DiffForHumans() }}</td>
                <td>
                    <a href="/senior/staff/show/report/{{ $report->created_at->timestamp }}/{{ $report->id }}"
                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">Review</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
