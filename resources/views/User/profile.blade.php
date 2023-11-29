<div class="user-info">
    <h2>Public Info</h2>
    <div class="avater">
        <img src="data:image/png;base64,{{ $icon['user'] }}" width="50">
    </div>
    <div class="info">
        <p><span class="first">Name</span> <span class="last">{{ $user->public_name }}</p>
        <p><span class="first">Status </span> <span class="last active">{{ $user->status }}</span></p>
        <p><span class="first">Joined</span> <span class="last"> {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span></p>
        <p><span class="first">Spent</span> <span class="last"> {{ $user->spent }}</span></p>
        <p><span class="first">Balance</span> <span class="last">{{ $user->balance }}</span>
        <p><span class="first">Trust Level</span><span style="color: white;" class="last trust-level-{{ $user->trust_level }}">UTL {{ $user->trust_level }}</span></p>
    </div>
</div>