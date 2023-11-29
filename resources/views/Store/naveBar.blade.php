<div class="nav-bar">
    <div class="start-menus">
        <div class="logo">
            <a href="/store/{{ $store->store_name }}">
                <img src="data:image/png;base64,{{ $icon['whale'] }}" alt="">
            </a>
        </div>
        <div class="name">
            <a href="/store/{{ $store->store_name }}"><span class="w">WHALES</span> <span
                    class="m">STORE</span></a>
        </div>
    </div>
    <div class="end-menus">
        <div class="notification">
            <a href="/store/{{ $store->store_name }}/messages" target="" rel="noopener noreferrer"> <img
                    src="data:image/png;base64,{{ $icon['mail'] }}" class="icon-filter" alt="Messages"
                    width="25"></a>
        </div>
        <div class="notification">
            <a href="/store/{{ $store->store_name }}/notifications" target="" rel="noopener noreferrer"> <img
                    src="data:image/png;base64,{{ $icon['notification'] }}" class="icon-filter" alt="Notification"
                    width="25">
                @if (count($store->notifications->where('is_read', 0)) > 0)
                    <span class="new-notification">{{ count($store->notifications->where('is_read', 0)) }}</span>
                @endif
                </span>
            </a>
        </div>
        <div class="notification">
            <a href="/store/{{ $store->store_name }}/settings" target="" rel="noopener noreferrer"> <img
                    src="data:image/png;base64,{{ $icon['settings'] }}" class="icon-filter" alt="Setting"
                    width="25"></a>
        </div class="notification">
        <div>
            <a href="/store/{{ $store->store_name }}/logout"> <img src="data:image/png;base64,{{ $icon['logout'] }}"
                    class="icon-filter" alt="LogOut" width="25"></a>
        </div>
    </div>
</div>
