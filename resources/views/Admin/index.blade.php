<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ @asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('store.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('filter.css') }}">
    <title>Whales Market | {{ $action != null ? $action : $user->public_name . 'Admin' }}</title>
</head>

<body>
    @include('Admin.naveBar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container" style="padding: 5px; margin:0px">
                <div class="cls-top">
                </div>
                <div class="main">
                    <div class="cls-left">
                        <div class="wlc-info">
                            <div class="avater">
                                <div class="bg-img">
                                    @php
                                        $avatarKey = $user->avater;
                                    @endphp

                                    <img src="data:image/png;base64,{{ !empty($upload_image[$avatarKey]) ? $upload_image[$avatarKey] : $icon['default'] }}"
                                        class="background-img">

                                </div>
                            </div>
                            <div class="name-status">
                                <p>Welcome, {{ $user->public_name }}</p>
                                <p><span>Last Updated: </span>
                                    <span>{{ $user->updated_at->diffForHumans() }}</span>
                                </p>
                                <p><span>Member Since:
                                    </span><span>{{ $user->created_at->format('j F Y') }}</span>
                                </p>
                                <p><span>Status: </span> <span class="status-active">{{ $user->status }}</span></p>
                                <p><span>Role: </span> <span class="{{ $user->role }}">{{ $user->role }} </span></p>

                            </div>

                        </div>
                        <div class="menus">
                            <div class="dashboard">
                                <img src="data:image/png;base64,{{ $icon['dashboard'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/dashboard">Dashboard</a>
                            </div>

                            <div class="listings">
                                <img src="data:image/png;base64,{{ $icon['group'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/users">Users</a>
                            </div>
                            <div class="all-products">
                                <img src="data:image/png;base64,{{ $icon['new_store'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/new stores">New Stores</a>
                            </div>
                            <div class="support">
                                <img src="data:image/png;base64,{{ $icon['add-store'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/stores">Stores</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['partnership'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/waivers">Stores Waivers</a>
                            </div>

                            <div class="listings">
                                <img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/categories">Categories</a>
                            </div>

                            <div class="all-products">
                                <img src="data:image/png;base64,{{ $icon['dispute'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/disputes">Disputes</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['inventory'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/products">Products</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['orders'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/orders">Orders</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['wallet'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/wallets">Wallets</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/carts">Carts</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['wallet'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/conversations">Conversations</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['news'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/escrows">Escrows</a>
                            </div>


                            <div class="settings" style="border-top: 2px solid gray;">
                                <img src="data:image/png;base64,{{ $icon['coupon'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/coupons">Coupons Codes</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['reviews'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/reviews">Reviews</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['partnership'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/share_accesses">Share Accesses</a>
                            </div>



                            <div class="wallet" style="border-top: 2px solid gray;">
                                <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/support">Supports</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['news'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/news">News</a>
                            </div>
                            <div class="all-products">
                                <img src="data:image/png;base64,{{ $icon['server'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/servers">Servers</a>
                            </div>
                            <div class="support">
                                <img src="data:image/png;base64,{{ $icon['warn'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/reports">Reports</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['logs'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/logs">Logs</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['unauthorized'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/unauthorize">Unauthorize</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['document'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/canary">Canary</a>
                            </div>

                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['functions'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/functions">Market Functions</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['web-coding'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/bugs">Bugs</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['feature'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/featureds">Featureds Listings</a>
                            </div>





                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/faqs">FAQs</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['notifications_type'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/notifications_types">Notification Types</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['rules'] }}" class="icon-filter"
                                    width="25">
                                <a href="/whales/admin/{{ $user->public_name }}/show/rules">Rules</a>
                            </div>
                        </div>
                    </div>
                    <div class="cls-main">
                        @if ($action === 'settings')
                            @include('Admin.settings')
                        @elseif($action === 'users')
                            @include('Admin.users')
                            @elseif($action === 'stores')
                            @include('Admin.stores')
                        @elseif($action === 'new stores')
                            @include('Admin.new_stores')
                        @elseif($action === 'categories')
                            @include('Admin.categories')
                        @elseif($action === 'disputes')
                            @include('Admin.disputes')

                            @elseif($action === 'orders')
                            @include('Admin.orders')
                           
                            @elseif($action === 'wallets')
                            @include('Admin.wallets')
                            @elseif($action === 'carts')
                            @include('Admin.carts')

                            @elseif($action === 'conversations')
                            @include('Admin.conversations')

                            @elseif($action === 'escrows')
                            @include('Admin.escrows')

                            @elseif($action === 'coupons')
                            @include('Admin.coupons')

                            @elseif($action === 'share_accesses')
                            @include('Admin.share_accesses')

                            @elseif($action === 'reviews')
                            @include('Admin.reviews')
                            
                        @elseif($action === 'products')
                            @include('Admin.products')
                        @elseif($action === 'settings')
                            @include('Admin.settings')
                        @elseif($action === 'view')
                            @include('Admin.productView')
                        @elseif($action === 'notifications')
                            @include('Admin.notifications')
                        @elseif($action == 'messages')
                            @include('Admin.messages')
                        @elseif($action === 'news')
                            @include('Admin.news')
                        @elseif($action === 'rules')
                            @include('Admin.rules')
                        @elseif($action === 'support')
                            @include('Admin.support')
                        @elseif($action === 'reports')
                            @include('Admin.reports')
                        @elseif($action === 'waivers')
                            @include('Admin.waivers')

                            {{-- Single display of actions --}}
                            @elseif($action === 'Show User')
                            @include('Admin.user')
                            @elseif($action === 'New Store')
                            @include('Admin.new_store')
                            @elseif($action === 'product')
                            @include('Admin.product')

                        @else
                            @include('Admin.dashboard')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Admin.footer')
</body>

</html>
