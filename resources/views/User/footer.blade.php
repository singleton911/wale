<div class="footer-div">
    <div class="seco-div">
      <div class="left-div" style="display: flex; gap: 50px;">
        <div>
          <p>Active Users: {{ \App\Models\User::where('status', 'active')->where('role', 'user')->count() }}</p>
          <p>Banned Users: {{ \App\Models\User::where('status', 'banned')->where('role', 'user')->count() }}</p>
        </div>
        <div>
          <p>Active Stores: {{ \App\Models\User::where('status', 'active')->where('role', 'store')->count() }}</p>
          <p>Banned Stores: {{ \App\Models\User::where('status', 'banned')->where('role', 'store')->count() }}</p>
        </div>
      </div>
      <div class="right-div">
        <div class="canary-news">
          <a href="/open-store">Create new store</a>
          <a href="/canary">Canary & PGP</a>
          <a href="/faq">F.A.Q</a>
          <a href="/news">News</a>
        </div>
        <p class="lunched">
          <span>Current Time: {{ now()->setTimezone('America/New_York')->format('F j, Y H:i:s') }} ET,</span>
          <span>Lunched On: 1 February, 2024</span>
          <span>Server Days: {{ now()->diffInDays(\Carbon\Carbon::parse('2024-02-01')) }}</span>
      </p>
  
      </div>
    </div>
    <div class="bottom-div">
      <div class="cprght">
        <p>Copyright &copy; 2024 Whales Market. All rights reserved.</p>
      </div>
    </div>
  </div>
