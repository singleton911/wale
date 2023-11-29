<?php
use app\Models\Notification\Notification;

$unreadNotify = Notification::getUnreadNotificationsCount($_SESSION['smod_id']);

?>
<div class="nav-bar">
    <div class="start-menus">
        <div class="logo">
            <a href="/smod"><img src="../../app/Views/Uploads/whale.png" alt="Whales market logo" srcset=""></a>
        </div>
        <div class="name">
            <a href="/smod"><span class="w">WHALES</span> <span class="m">Senior Mod</span></a>
        </div>
    </div>
    <div class="end-menus">
        <div class="notification">
            <a href="/smod/stand-up" target="" rel="noopener noreferrer"><img src="../../../../app/icons/mail.svg" width="20" alt="" srcset="">Stand Up</a>
        </div>
        <div class="notification">
            <a href="/smod/notification" target="" rel="noopener noreferrer"> <img src="../../../../app/icons/notifications.svg"  alt="Notification Icons" srcset=""><span style="border-radius: .5rem; <?php echo !empty($unreadNotify) ? "background-color: darkred;" : "background-color: darkgreen;"; ?> padding: .07em; color: #f1f1f1;"><?php echo !empty($unreadNotify) ? $unreadNotify : "0"; ?></span></a>
        </div>
        <div class="logout">
            <a href="/smod/logout"> <img src="../../../../app/icons/logout.svg" alt="logout Icons" srcset="">LogOut</a>
        </div>
    </div>
</div>