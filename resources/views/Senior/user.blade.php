<div class="main-div" style="margin-top:0px">
    <div class="main-store-div">
        <div class="s-main-image">

            @php
                $avatarKey = $show_user->avatar;
            @endphp
            <img src="data:image/png;base64,{{ !empty($upload_image[$avatarKey]) ? $upload_image[$avatarKey] : $icon['default'] }}"
                class="background-img">
            <div>
                <div class="div-p">
                    <p class="store-name">{{ $show_user->public_name }}<span style="font-size: .5em;">User</span>
                    </p>
                </div>
                <div style="margin-top: 0; display:flex; justify-content:space-around">

                    <span>S I N C E</span> <span>{{ $show_user->created_at->format('d F, Y') }}</span>
                </div>
                <div class="div-p">
                    <p>Status: <span class="{{ $show_user->status }}">{{ $show_user->status }}</span></p> |
                    <p>Disputes: [<span style="color: #28a745;">Won ({{ $show_user->disputes_won }})</span>/<span
                            style="color:#dc3545;">Lost ({{ $show_user->disputes_lost }})</span>]</p>
                </div>
                <div class="div-p">
                    <p>Orders: {{ $show_user->total_orders }}</p> |
                    <p>Spent: ${{ $show_user->spent }}</p> |
                    <p>2FA Enable: {{ $show_user->twofa_enable }}</p>
                </div>
                <div class="div-p">
                    <p>Last Seen: {{ $show_user->last_seen  }}</p>
                    <p>Store Status: {{ $show_user->store_status }}</p>
                </div>
                <div class="div-p">
                    <p>Store Key: {{ $show_user->store_key }}</p>
                </div>
                <div class="div-p">
                    <p>Balance: ${{ $show_user->wallet->balance ?? 0.00 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bio">
            @if ($show_user->twofa_enable)
                <h3 style="text-transform: uppercase;">{{ $show_user->public_name }} > PGP KEY</h3>
                <textarea name="" id="" cols="30" rows="10" style="width: 100%;">{{ $show_user->pgp_key }}</textarea>
            @else
                <h3 style="text-transform: uppercase;">{{ $show_user->public_name }} > PGP KEY</h3>
              
                <textarea name="" id="" cols="30" rows="10" style="width: 100%;">User has not pgp key...</textarea>

            @endif
        </div>
        <form action="" method="post" style="margin-top: 1em;">
            @csrf
            <input type="hidden" name="user_id" value="{{ Crypt::encrypt($show_user->id) }}">

            @if ($show_user->status == 'active')
                <button type="submit"
                    style="font-size: 1rem; background-color: darkred; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                    name="ban">Ban {{ $show_user->public_name }}</button>

            @elseif($show_user->status == 'banned')
                <button type="submit"
                    style="font-size: 1rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                    name="un_ban">Un Banned {{ $show_user->public_name }}</button>
            @endif
        </form>
    </div>
</div>
