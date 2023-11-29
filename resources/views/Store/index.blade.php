<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ @asset('store.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('filter.css') }}">
    <title>Whales Market | {{ ($action != NULL ? $action : $store->store_name.' Store') }}</title>
</head>
<body>
@include('Store.naveBar')
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
                        <p>Welcome, {{ $store->store_name }}</p>
                        <p><span>Last Updated: </span> <span>{{ \Carbon\Carbon::parse($store->updated_at)->diffForHumans() }}</span></p>
                        <p><span>Member Since: </span><span>{{ \Carbon\Carbon::parse($store->created_at)->format('j F Y') }}</span></p>
                        <p><span>Trust Level:</span> <span class="trust-level-{{ $store->trust_level }}">STL {{ $store->trust_level }}</span></p>
                        <p><span>Status: </span> <span class="status-active">{{ $store->status }}</span></p>
                    </div>

                </div>
                <div class="menus">
                    <div class="dashboard">
                        <img src="data:image/png;base64,{{ $icon['dashboard'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/dashboard">Dashboard</a>
                    </div>
                    <div class="listings">
                        <img src="data:image/png;base64,{{ $icon['add'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/add-listings">Add Listings</a>
                    </div>
                    <div class="all-products">
                        <img src="data:image/png;base64,{{ $icon['inventory'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/products">Products</a>
                    </div>
                    <div class="reviews-a">
                        <img src="data:image/png;base64,{{ $icon['reviews'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/reviews">Reviews</a>
                    </div>
                    <div class="reviews-a">
                        <img src="data:image/png;base64,{{ $icon['reviews'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/share-access">Share Access</a>
                    </div>
                    {{-- <div class="reviews-a">
                        <img src="data:image/png;base64,{{ $icon['mail'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/messages">Messages(
                            @if ($messageStatusCount > 0)
                            <span class="unread">{{ $messageStatusCount }}</span>
                        @else
                        <span class="read">0</span>
                        @endif
                        )</a>
                    </div> --}}
                    {{--
                    <div class="notification-str">
                        <img src="data:image/png;base64,{{ $icon['notification'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/notifications">Notifications(
                        @if (count($store->notifications->where('is_read', 0)) > 0)
                            <span class="unread">{{ count($store->notifications->where('is_read', 0)) }}</span>
                        @else
                        <span class="read">0</span>
                        @endif
                        )</a>
                    </div> --}}
                    <div class="orders">
                        <img src="data:image/png;base64,{{ $icon['orders'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/orders">Orders(
                            @if (count($store->orders->where('status', '!=', 'completed')->where('status', '!=', 'cancelled')) > 0)
                            <span class="unread">{{ count($store->orders->where('status', '!=', 'completed')->where('status', '!=', 'cancelled')) }}</span>
                        @else
                        <span class="read">0</span>
                        @endif
                        )</a>
                    </div>
                    <div class="orders">
                        <img src="data:image/png;base64,{{ $icon['monitoring'] }}" class="icon-filter" width="25">                        
                        <a href="/store/{{ $store->store_name }}/stats">Store Stats</a>
                    </div>
                    <div class="orders">
                        <img src="data:image/png;base64,{{ $icon['bonus'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/affiliate">Affiliate</a>
                    </div>
                    <div class="wallet">
                        <img src="data:image/png;base64,{{ $icon['wallet'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/wallet">Wallet</a>
                    </div>
                    <div class="support">
                        <img src="data:image/png;base64,{{ $icon['ads'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/promotion">Promotion</a>
                    </div>
                    <div class="wallet">
                        <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/support">Support</a>
                    </div>
                    {{-- <div class="settings">
                        <img src="data:image/png;base64,{{ $icon['settings'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/settings">Settings</a>
                    </div> --}}
                    <div class="settings" style="border-top: 2px solid gray;">
                        <img src="data:image/png;base64,{{ $icon['rules'] }}" class="icon-filter" width="25">
                        <a href="/store/{{ $store->store_name }}/rules">Rules</a>
                    </div>
                </div>
            </div>
            <div class="cls-main">
                @if ($action === 'settings')
                    @include('Store.settings')
                @elseif($action === 'add-listings')
                    @include('Store.createListing')
                @elseif($action === 'physical')
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
                @else
                  @include('Store.dashboard')
                @endif
            </div>
        </div>
        @include('Store.footer')
</body>

</html>
