
@if ($action === null)
    @switch($name)
        @case('cart')
            @include('User.cart')
        @break

        @case('open-store')
            @include('User.open-store')
        @break

        @case('messages')
            @include('User.message')
        @break

        @case('notification')
            @include('User.notification')
        @break

        @case('canary')
            @include('User.canary')
        @break

        @case('news')
            @include('User.news')
        @break

        @case('team')
            @include('User.team')
        @break

        @case('faq')
            @include('User.faq')
        @break

        @case('ticket')
            @include('User.ticket')
        @break

        @case('bugs')
            @include('User.bugs')
        @break

        @default
            @include('User.main')
    @endswitch
@else
    @switch($action)
        @case('pgp')
            @include('User.2fa')
        @break

        @case('storeKey')
            @include('User.storeKey')
        @break

        @case('changePassword')
            @include('User.changePassword')
        @break

        @case('referral')
            @include('User.referral')
        @break

        @case('stats')
            @include('User.stats')
        @break

        @case('mirror')
            @include('User.mirror')
        @break

        @case('theme')
            @include('User.theme')
        @break

        @case('f_store')
            @include('User.favoriteStore')
        @break

        @case('b_store')
            @include('User.blockedStore')
        @break

        @case('f_listing')
            @include('User.favoriteListing')
        @break

        @case('deposit')
            @include('User.deposit')
        @break

        @case('withdraw')
            @include('User.withdraw')
        @break

        @case('all')
        @include('User.orders')
    @break

        @case('pending')
            @include('User.orders')
        @break

        @case('dispatched')
            @include('User.orders')
        @break

        @case('completed')
            @include('User.orders')
        @break

        @case('disputed')
            @include('User.orders')
        @break

        @case('cancelled')
            @include('User.orders')
        @break

        @default
            @include('User.main')
    @endswitch
@endif