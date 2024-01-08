
<h3 style="text-align: center">Store Owner</h3>
<div class="main-div" style="margin-top:0px">
    <div class="main-store-div">
        <div class="s-main-image">

            <img src="data:image/png;base64,{{ $icon['default'] }}" class="background-img">
            <div>
                <div class="div-p">
                    <p class="store-name">{{ $store->user->public_name }}<span style="font-size: .5em;">User</span>
                    </p>
                    
                </div>
                <div style="margin-top: 0; display:flex; justify-content:space-around">

                    <span>S I N C E</span> <span>{{ $store->user->created_at->format('d F, Y') }}</span>
                </div>
                <div class="div-p">
                    <p>Status: <span class="{{ $store->user->status }}">{{ $store->user->status }}</span></p> |
                    <p>Disputes: [<span style="color: #28a745;">Won ({{ $store->user->disputes_won }})</span>/<span
                            style="color:#dc3545;">Lost ({{ $store->user->disputes_lost }})</span>]</p>
                </div>
                <div class="div-p">
                    <p>Orders: {{ $store->user->total_orders }}</p> |
                    <p>Spent: ${{ $store->user->spent }}</p> |
                    <p>2FA Enable: {{ $store->user->twofa_enable }}</p>
                </div>
                <div class="div-p">
                    <p>Last Seen: {{ $store->user->last_seen }}</p>
                    <p>Store Status: {{ $store->user->store_status }}</p>
                </div>
            </div>
        </div>

        <div class="bio">
            @if ($store->user->twofa_enable)
                <h3 style="text-transform: uppercase;">{{ $store->user->public_name }} > PGP KEY</h3>
                <textarea name="" id="" cols="30" rows="10" style="width: 100%;">{{ $store->user->pgp_key }}</textarea>
            @else
                <h3 style="text-transform: uppercase;">{{ $store->user->public_name }} > PGP KEY</h3>

                <textarea name="" id="" cols="30" rows="10" style="width: 100%;">User has not pgp key...</textarea>
            @endif
        </div>
    </div>
</div>


<h3 style="text-align: center">Store</h3>

<div class="main-div" style="margin-top:0px">
    <div class="main-store-div">
        <div class="s-main-image">

            @php
                $avatarKey = $store->avater;
            @endphp
            <img src="data:image/png;base64,{{ !empty($upload_image[$avatarKey]) ? $upload_image[$avatarKey] : $icon['default'] }}"
                class="background-img">
            <div>
                <div class="div-p">
                    <p class="store-name">{{ $store->store_name }}<span style="font-size: .5em;">Store</span>
                    </p>
                    <p class="span3" style="border: 2px solid skyblue; border-radius:.5rem; padding:5px;">
                        @php
                        $weightedAverage = \App\Models\Review::claculateStoreRating($store->id);
                        @endphp
                        {{ $weightedAverage != 0 ? $weightedAverage : '5.0' }}⭐
                    </p>
                </div>
                <div style="margin-top: 0; display:flex; justify-content:space-around">

                    <span>S I N C E</span> <span>{{ $store->created_at->format('d F, Y') }}</span>
                </div>
                <div class="div-p">
                    <p>Status: <span class="{{ $store->status }}">{{ $store->status }}</span></p> |
                    <p>Sales: {{ $store->width_sales }}</p> |
                    <p>Disputes: [<span style="color: #28a745;">Won ({{ $store->disputes_won }})</span>/<span
                            style="color:#dc3545;">Lost ({{ $store->disputes_lost }})</span>]</p>
                </div>
                <div class="div-p">
                    <p>Listings: {{ $store->products()->where('status', 'Active')->count() }}</p> |
                    <p>Favorited: {{ $store->StoreFavorited->count() }}</p>
                    <p>Wallet Balance: ${{ $store->user->wallet->balance ?? 0.00}} </p>
                </div>
                <div class="div-p">
                    <p class="selling">Selling: <a href=""
                            style="font-size: 15px;">{{ $store->selling }}</a></p>
                </div>
                <div class="div-p ship-from">
                    <p>
                        Ship From: <a href=""
                            style="font-size: 15px; text-transform:uppercase;">{{ $store->ship_from }}</a>
                    </p>
                    <p>
                        Ship To: <a href=""
                            style="font-size: 15px; text-transform:uppercase;">{{ $store->ship_to }}</a>
                    </p>
                </div>
                <div class="div-p">
                    <p>Last Seen: {{ $store->user->last_seen }}</p>
                </div>
            </div>
        </div>
        <div class="bio">
            <h3>Store Descriptions...</h3>
            <textarea name="" id="" cols="30" rows="10" style="width: 100%">{{ $store->store_description }}</textarea>
        </div>


        <form action="" method="post" style="margin-top:1em;">
            @csrf
            <input type="hidden" name="new_store_id" value="{{ Crypt::encrypt($store->id) }}">


            <button type="submit"
                style="font-size: 1rem; background-color: darkred; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                name="decline">Ban Store</button>


            <button type="submit"
                style="font-size: 1rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                name="approve">Approve Store</button>

        </form>
    </div>


</div>
