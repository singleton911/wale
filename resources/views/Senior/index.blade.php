<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if ($user->theme == 'dark')
        <link rel="stylesheet" href="{{ asset('dark.theme.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('white.theme.css') }}">
    @endif
    
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('store.white.css') }}">
    <link rel="stylesheet" href="{{ @asset('filter.css') }}">
    <title>Whales Market | {{ $action != null ? $action : $user->public_name . ' Moderator' }}</title>
</head>

<body>
    @include('Senior.naveBar')
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
                                <p><span>Role: </span> <span class="{{ $user->role }}">{{ $user->role }}
                                        Moderator</span></p>

                            </div>

                        </div>
                        <div class="menus">
                            <div class="dashboard">
                                <img src="data:image/png;base64,{{ $icon['dashboard'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/dashboard">Dashboard</a>
                            </div>

                            <div class="listings">
                                <img src="data:image/png;base64,{{ $icon['group'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/users">Users</a>
                            </div>
                            <div class="all-products">
                                <img src="data:image/png;base64,{{ $icon['new_store'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/new stores">New Stores</a>
                            </div>

                            <div class="listings">
                                <img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/categories">Categories</a>
                            </div>
                            <div class="support">
                                <img src="data:image/png;base64,{{ $icon['add-store'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/stores">Stores</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['inventory'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/products">Products</a>
                            </div>

                            <div class="all-products">
                                <img src="data:image/png;base64,{{ $icon['dispute'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/disputes">Disputes</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['plane-tickets'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/support">Support</a>
                            </div>

                            <div class="support">
                                <img src="data:image/png;base64,{{ $icon['warn'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/reports">Reports</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['partnership'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/waivers">Waivers</a>
                            </div>


                            <hr>Supports, reports, settings...
                            <hr>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['shield'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/pgp">2FA PGP KEY</a>
                            </div>

                            <div class="settings">
                                <img alt="🖇️" style="font-size:1.5em; margin-right: .5em;" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/url">Private URL Link</a>
                            </div>

                            <div class="settings">
                                @if ($user->theme == 'white')
                                    <img src="data:image/png;base64,{{ $icon['night-mode'] }}" class="icon-filter"
                                        width="25">
                                    <a href="/senior/staff/{{ $user->public_name }}/show/theme">Dark Mode</a>
                                @else
                                    <img src="data:image/png;base64,{{ $icon['brightness'] }}" class="icon-filter"
                                        width="25">
                                    <a href="/senior/staff/{{ $user->public_name }}/show/theme">Light Mode</a>
                                @endif

                            </div>

                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['faq'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/faq">FAQ</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['web-coding'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/bugs">Bugs</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['document'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/canary">Canary</a>
                            </div>



                            <div class="settings" style="border-top: 2px solid gray;">
                                <img src="data:image/png;base64,{{ $icon['news'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/news">News</a>
                            </div>
                            <div class="wallet">
                                <img src="data:image/png;base64,{{ $icon['wallet'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/wallet">Wallet</a>
                            </div>
                            <div class="settings">
                                <img src="data:image/png;base64,{{ $icon['rules'] }}" class="icon-filter"
                                    width="25">
                                <a href="/senior/staff/{{ $user->public_name }}/show/rules">Rules</a>
                            </div>
                        </div>
                    </div>
                    <div class="cls-main">
                        @if ($action === 'settings')
                            @include('Senior.settings')
                        @elseif($action === 'users')
                            @include('Senior.users')
                        @elseif($action === 'new stores')
                            @include('Senior.new_stores')
                        @elseif($action === 'categories')
                            @include('Senior.categories')
                        @elseif($action === 'disputes')
                            @include('Senior.disputes')
                        @elseif($action === 'products')
                            @include('Senior.products')
                        @elseif($action === 'settings')
                            @include('Senior.settings')
                        @elseif($action === 'view')
                            @include('Store.productView')
                        @elseif($action === 'notifications')
                            @include('Senior.notifications')
                        @elseif($action == 'messages')
                            @include('Senior.messages')


                            @elseif($action == 'stores')
                            @include('Senior.stores')


                        @elseif($action === 'news')
                            @include('Senior.news')
                        @elseif($action === 'rules')
                            @include('Senior.rules')
                        @elseif($action === 'support')
                            @include('Senior.support')
                        @elseif($action === 'reports')
                            @include('Senior.reports')
                        @elseif($action === 'waivers')
                            @include('Senior.waivers')

                        @elseif($action === 'url')
                            @include('Senior.mirror')
                        @elseif($action === 'canary')
                            @include('Senior.canary')
                        @elseif($action === 'pgp')
                            @include('Senior.twofa')
                        @elseif($action === 'faq')
                            @include('Senior.faq')
                        @elseif($action === 'bugs')
                            @include('Senior.bugs')



                            {{-- Single display of actions --}}
                        @elseif($action === 'Show User')
                            @include('Senior.user')
                        @elseif($action === 'New Store')
                            @include('Senior.new_store')
                            @elseif($action === 'Store')
                            @include('Senior.store')

                        @elseif($action === 'product')
                            @include('Senior.product')
                        @else
                            @include('Senior.dashboard')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Senior.footer')
</body>

</html>
