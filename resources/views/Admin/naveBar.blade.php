<div class="nav-bar">
    <div class="start-menus">
        <div class="logo">
            <a href="/"><img src="data:image/png;base64,{{ $icon['whale'] }}"></a>
        </div>
        <div class="name">
            <a href="/"><span class="w">WHALES</span> <span class="m">MARKET</span></a>
        </div>
    </div>
    <div class="end-menus">
        <div class="notification" title="shopping cart">
            <a href="/cart" target="" rel="noopener noreferrer"> <img
                    src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter" width="25">
                <span
                    class="{{ $user->carts->count() > 0 ? 'cart-n-tr' : '' }}">{{ $user->carts->count() > 0 ? $user->carts->count() : '' }}</span>
            </a>
        </div>
        <div class="logout" title="open a store here">
            <a href="/open-store"> <img src="data:image/png;base64,{{ $icon['add-store'] }}" class="icon-filter"
                    width="25"></a>
        </div>
        <div class="my-hideout" title="user settings and control panel">
            <a href="#">Settings<img src="data:image/png;base64,{{ $icon['down-arrow'] }}" class="icon-filter"
                    width="25"></a>
            <ul class="hideout-menus">
                <li>
                    <h3>ACCOUNT</h3>
                    <ul>
                        <li><a href="/account/pgp"><img src="data:image/png;base64,{{ $icon['shield'] }}"
                                    class="icon-filter" width="25"> PGP KEY [2FA]</a></li>
                        <li><a href="/account/storeKey"><img src="data:image/png;base64,{{ $icon['partnership'] }}"
                                    class="icon-filter" width="25">Store key</a></li>
                        <li><a href="/account/changePassword"><img
                                    src="data:image/png;base64,{{ $icon['change-management'] }}" class="icon-filter"
                                    width="25"> Change
                                password</a></li>
                        <li><a href="/account/referral"><img src="data:image/png;base64,{{ $icon['bonus'] }}"
                                    class="icon-filter" width="25"> Referral Program</a></li>
                        <li><a href="/account/stats"><img src="data:image/png;base64,{{ $icon['monitoring'] }}"
                                    class="icon-filter" width="25"> Stats</a></li>
                        <li><a href="/account/mirror">Private Mirror</a></li>
                        <li>
                            <a href="/account/theme">
                                <img src="data:image/png;base64,{{ $icon['night-mode'] }}" class="icon-filter"
                                    width="25">

                                Dark Mode
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <h3>WALLET</h3>
                    <ul>
                        <li><a href="/wallet/deposit"><img src="data:image/png;base64,{{ $icon['deposit'] }}"
                                    class="icon-filter" width="25"> Deposit</a></li>
                        <li><a href="/wallet/withdraw"><img src="data:image/png;base64,{{ $icon['withdraw'] }}"
                                    class="icon-filter" width="25"> Withdraw</a></li>
                    </ul>
                </li>
                <li>
                    <h3>SUPPORT</h3>
                    <ul>
                        <li><a href="/ticket"><img src="data:image/png;base64,{{ $icon['plane-tickets'] }}"
                                    class="icon-filter" width="25">Tickets</a>
                        </li>
                        <li><a href="/bugs"><img src="data:image/png;base64,{{ $icon['web-coding'] }}"
                                    class="icon-filter" width="25"> Report bugs</a></li>
                    </ul>
                </li>
                <li>
                    <h3>ORDERS</h3>
                    <ul>
                        <li><a href="/orders/all"><img src="data:image/png;base64,{{ $icon['orders'] }}"
                            class="icon-filter" width="25"> All(<span style="color:blue">{{ $user->orders->count() }}</span>) </a></li>
                        <li><a href="/orders/pending"><img src="data:image/png;base64,{{ $icon['wall-clock'] }}"
                                    class="icon-filter" width="25"> Pending(<span style="color:blue">{{ $user->orders->where('status', 'pending')->count() }}</span>)</a></li>
                        <li><a href="/orders/dispatched"><img src="data:image/png;base64,{{ $icon['fast-delivery'] }}"
                                    class="icon-filter" width="25"> Dispatched(<span style="color:blue">{{ $user->orders->where('status', 'dispatched')->count() }}</span>) </a></li>
                        <li><a href="/orders/completed"><img src="data:image/png;base64,{{ $icon['success'] }}"
                                    class="icon-filter" width="25"> Completed(<span style="color:blue">{{ $user->orders->where('status', 'completed')->count() }}</span>) </a></li>
                        <li><a href="/orders/disputed"><img src="data:image/png;base64,{{ $icon['dispute'] }}"
                                    class="icon-filter" width="25">Disputed(<span style="color:blue">{{ $user->orders->where('status', 'dispute')->count() }}</span>) </a></li>
                        <li><a href="/orders/cancelled"><img src="data:image/png;base64,{{ $icon['close'] }}"
                                    class="icon-filter" width="25">Cancelled(<span style="color:blue">{{ $user->orders->where('status', 'cancelled')->count() }}</span>) </a></li>
                    </ul>
                </li>
                <li>
                    <h3>OTHERS</h3>
                    <ul>
                        <li><a href="/open-store"><img src="data:image/png;base64,{{ $icon['add-store'] }}"
                                    class="icon-filter" width="25"> Open store</a></li>
                        <li><a href="/team"><img src="data:image/png;base64,{{ $icon['group'] }}"
                                    class="icon-filter" width="25"> Meet The Team</a></li>
                        <li><a href="/canary"> <img src="data:image/png;base64,{{ $icon['document'] }}"
                                    class="icon-filter" width="25"> Canary & PGP</a></li>
                        <li><a href="/faq"><img src="data:image/png;base64,{{ $icon['faq'] }}"
                                    class="icon-filter" width="25"> F.A.Q</a></li>
                        <li><a href="/news"><img src="data:image/png;base64,{{ $icon['ads'] }}"
                                    class="icon-filter" width="25"> News</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="notification" title="messages">
            <a href="/messages" target="" rel="noopener noreferrer">
                <img src="data:image/png;base64,{{ $icon['mail'] }}" class="icon-filter" width="25">
                @php
                    $unread_message_counter = 0;
                @endphp
                @foreach ($user->messages as $user_message)
                    @foreach ($user_message->conversation->participants->where('user_id', '!=', $user->id) as $participant)
                        @foreach ($participant->messages as $message)
                            @php
                                $unread_message_counter += $message->status
                                    ->where('user_id', $user->id)
                                    ->where('is_read', 0)
                                    ->count();
                            @endphp
                        @endforeach
                    @endforeach
                @endforeach
                @if ($unread_message_counter > 0)
                    <span class="new-notification">{{ $unread_message_counter }}</span>
                @endif
            </a>
        </div>
        <div class="notification" title="notifications">
            <a href="/notification" target="" rel="noopener noreferrer">
                <img src="data:image/png;base64,{{ $icon['notification'] }}" class="icon-filter" width="25">
            @if ($user->notifications->where('is_read', 0)->count() > 0)
                <span class="new-notification">{{ $user->notifications->where('is_read', 0)->count() }}</span>
            @endif
            </a>
        </div>
        <div class="logout" title="logout">
            <a href="/logout"> <img src="data:image/png;base64,{{ $icon['logout'] }}" class="icon-filter"
                    width="25"></a>
        </div>
    </div>
</div>
