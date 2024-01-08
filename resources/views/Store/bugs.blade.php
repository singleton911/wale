<div class="notific-container">
    <h1 class="notifications-h1" style="margin:0; padding:0px;">_Bug Reporting Form_</h1>
    <p class="notifications-p"></p>
    @if ($errors->any)
        @foreach ($errors->all() as $error)
            <p style="color: red; text-align:center">{{ $error }}</p>
        @endforeach
    @endif
    @if (session('success'))
        <p style="color: green; text-align:center;">{{ session('success') }}</p>
    @endif

    <form action="/store/{{ $store->store_name }}/do/bugs" method="post" class="support-form">
        @csrf
        <select class="select-opt" name="type" id="" required>
            <option value="">---Select Bug Type---</option>
            <option value="withdraw">Withdraw</option>
            <option value="deposit">Deposit</option>
            <option value="server">Server</option>
            <option value="key failed">PGP key failed</option>
            <option value="account  issue">Account issue</option>
            <option value="styling">Styling Broken</option>
            <option value="others">Others</option>
        </select> <br> <br>
        <textarea name="content" class="support-msg"
            placeholder="Well Written Report Message here... lesst than 15K characters!" required></textarea>
        <input type="submit" class="submit-nxt" name="send_report" value="Send">
    </form>
</div>
