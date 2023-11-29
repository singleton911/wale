{{-- <legend>Composing Support Message[$total/5]</legend>
<form action="" method="post" class="form-container">
    <label class="form-label">To</label>
    <select name="receiver" class="form-select" id="">
        <option value="1">System</option>
    </select>
    <label class="form-label">Message Type</label>
    <select name="message_type" class="form-select" id="">
        <option value="listings_problem">Listings problem</option>
        <option value="withdraw">Withdraw</option>
        <option value="deposit">Deposit</option>
        <option value="server">Server</option>
        <option value="key_failed">PGP key failed</option>
        <option value="new_feature">New feature suggestion</option>
        <option value="bad_features">Bad features</option>
        <option value="account_issue">Account issue</option>
        <option value="technical_support">Technical support</option>
        <option value="feedback">feedback</option>
        <option value="others">Others</option>
    </select>


    <label class="form-label">Message</label>
    <textarea name="support-msg" class="support-msg" placeholder="Message here..." required></textarea>
    <input type="submit" class="submit-nxt" name="send_ticket" value="Send">
</form>

<input type="submit" class="submit-nxt" name="close" style="background-color: red;" value="Close"> --}}

<legend>Store Share Access <form action="" method="post"><input type="submit" value="Add New Share Access" style="background-color: rgb(4, 61, 84); padding: 5px; cursor:pointer; border: 2px solid skyblue; color:#f1f1f1;"></form></legend>
<table>
    <thead>
        <tr>
          <th>Name</th>
          <th>Permissions</th>
          <th>Status</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      {{-- @forelse ($store->supports as $support) --}}
      {{-- <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th></th>
    </tr>
    @empty --}}
        <tr>
          <td colspan="4">You don't have any share access.</td>
        </tr>
    {{-- @endforelse --}}
    </tbody>
</table>