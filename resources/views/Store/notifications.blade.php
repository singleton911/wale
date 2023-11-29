<style>
    /* CSS Style */
.notification-container {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 15px;
    background-color:  #f0f0f0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.notification-container img {
    margin-right: 15px;
    border-radius: 50%;
}

.notification-container.read {
    background-color: #f9f9f9; /* Background color for read notifications */
}

.notification-content {
    flex: 1;
}

.notification-content span {
    margin-right: 15px;
    font-weight: bold;
}

.notification-reference {
    color: #888;
    margin-top: 5px;
    font-size: 0.9em;
}

.notification-time {
    color: #aaa;
    font-size: 0.8em;
}

.notification-message {
    margin-top: 10px;
    font-size: 0.9em;
}

</style>
<h1 class="notifications-h1">Notifications</h1>
<p class="notifications-p">Notification older than 30 days will be deleted autmatically!</p>

@forelse ($store->notifications as $notification)
<div class="notification-container {{ $notification->is_read ? 'read' : '' }}">
    <img src="data:image/jpeg;base64,{{ $icon[$notification->notificationType->icon] }}" alt="" width="30">
    <div class="notification-content">
        <div style="display: flex;">
            <span>{{  $notification->user->public_name }}</span>
            <span>{{  $notification->notificationType->name }}</span>
            <span>Reference #WM{{ $notification->created_at->timestamp }}</span>
            <span class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
            <form action="" method="post">
                @csrf 
                @if (!$notification->is_read)
                    <input type="submit" name="read" id="" value="Mark as read">
                @endif
            </form>
        </div>
        <p class="notification-message">{{ $notification->notificationType->content }}</p>
    </div>
</div>
@empty
<p style="text-align: center; font-size: 1.2rem;">You don't have any notification.</p>
@endforelse

