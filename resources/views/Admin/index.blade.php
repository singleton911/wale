<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ @asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('store.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('filter.css') }}">
    <title>Whales Market | {{ ($action != NULL ? $action : $user->public_name) }}</title>
</head>
<body>
@include('Admin.naveBar')
    <div class="container">
        <div class="cls-top">
        </div>
        <div class="main">
            <div class="cls-left">
                <div class="wlc-info">
                    <div class="avater">
                        <div class="bg-img">
                            {{-- <img src="avater" class="background-img" alt="" srcset=""> --}}
                            <img src="data:image/png;base64,{{ $icon['osint'] }}" class="background-img">
                        </div>
                    </div>
                    <div class="name-status">
                        <p>Welcome, {{ $user->public_name }}</p>
                        {{-- <p><span>Last Login: </span> <span>{{ $user->last_seen->DiffForHumans() }}</span></p> --}}
                        <p><span>Member Since: </span><span>{{ $user->created_at->format('j F Y') }}</span></p>
                        <p><span>Role:</span> <span class="{{ $user->role }}">{{ $user->role }}</span></p>
                        <p><span>Status: </span> <span class="status-active">{{ $user->status }}</span></p>
                    </div>

                </div>
                <div class="menus">
                    <div class="dashboard">
                        <img src="data:image/png;base64,{{ $icon['dashboard'] }}" class="icon-filter" width="25">
                        <a href="/dashboard">Dashboard</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['user'] }}" class="icon-filter" width="25">
                        <a href="/users">Users</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['add-store'] }}" class="icon-filter" width="25">
                        <a href="/stores">Stores</a>
                    </div>
                    <div class="all-products">
                        <img src="data:image/png;base64,{{ $icon['inventory'] }}" class="icon-filter" width="25">
                        <a href="/products">Products</a>
                    </div>
                    <div class="reviews-a">
                        <img src="data:image/png;base64,{{ $icon['reviews'] }}" class="icon-filter" width="25">
                        <a href="/reviews">Reviews()</a>
                    </div>
                    <div class="orders">
                        <img src="data:image/png;base64,{{ $icon['orders'] }}" class="icon-filter" width="25">
                        <a href="/orders">Orders()</a>
                    </div>
                    <div class="orders">
                        <img src="data:image/png;base64,{{ $icon['bonus'] }}" class="icon-filter" width="25">
                        <a href="/affiliates">Affiliates</a>
                    </div>
                    <div class="wallet">
                        <img src="data:image/png;base64,{{ $icon['wallet'] }}" class="icon-filter" width="25">
                        <a href="/wallets">Wallets</a>
                    </div>
                    <div class="support">
                        <img src="data:image/png;base64,{{ $icon['ads'] }}" class="icon-filter" width="25">
                        <a href="/promotion">Promotions</a>
                    </div>
                    <div class="wallet">
                        <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter" width="25">
                        <a href="/supports">Supports</a>
                    </div>

                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['view'] }}" class="icon-filter" width="25">
                        <a href="/featured">Featured</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['ads'] }}" class="icon-filter" width="25">
                        <a href="/News">News</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter" width="25">
                        <a href="/carts">Carts</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter" width="20">
                        <a href="/categories">Categories</a>
                    </div>

                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['view'] }}" class="icon-filter" width="25">
                        <a href="/new_stores">New stores</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['ads'] }}" class="icon-filter" width="25">
                        <a href="/escrows">Escrows</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter" width="25">
                        <a href="/disputes">Disputes</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter" width="20">
                        <a href="/reports">Reports</a>
                    </div>


                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['view'] }}" class="icon-filter" width="25">
                        <a href="/replies">Replies</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter" width="25">
                        <a href="/faqs">F.A.Q</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['web-coding'] }}" class="icon-filter" width="25">
                        <a href="/bugs">bugs()</a>
                    </div>

                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['ads'] }}" class="icon-filter" width="25">
                        <a href="/market_keys">Market Keys</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter" width="25">
                        <a href="/notification_types">Notification Types()</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter" width="20">
                        <a href="/conversations">Conversations</a>
                    </div>

                    <div class="settings" style="border-top: 2px solid gray;">
                        <img src="data:image/png;base64,{{ $icon['rules'] }}" class="icon-filter" width="25">
                        <a href="/rules">Rules</a>
                    </div>
                </div>
            </div>
            <div class="cls-main">
                @if ($action === 'settings')
                    @include('Admin.settings')
                 @elseif($action === 'users')
                    @include('Admin.users')
               {{-- @elseif($action === 'physical')
                    @include('Store.physical')
                @elseif($action === 'digital')
                    @include('Store.digital')
                @elseif($action === 'wallet')
                    @include('Store.wallet')
                @elseif($action === 'support')
                    @include('Store.support')
                @elseif($action === 'settings')
                    @include('Store.settings')
                @elseif($action === 'products')
                    @include('Store.products')
                @elseif($action === 'edit-product')
                    @include('Store.editlisting')
                @elseif($action === 'notifications')
                    @include('Store.notifications')
                @elseif($action === 'messages')
                    @include('Store.messages')
                @elseif($action === 'orders')
                    @include('Store.orders')
                @elseif($action === 'stats')
                    @include('Store.stats')
                @elseif($action === 'affiliate')
                    @include('Store.affiliate')
                @elseif($action === 'preview-order')
                    @include('Store.orderView')
                @elseif($action === 'reply-review')
                    @include('Store.reply')
                @elseif($action === 'reviews')
                    @include('Store.reviews')
                    @elseif($action === 'promotion')
                    @include('Store.promotion')
                @elseif($action === 'share-access')
                    @include('Store.share')
                @else --}}
                  @include('Admin.dashboard')
                @endif
            </div>
        </div>
        @include('Admin.footer')
</body>

</html>
