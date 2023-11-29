<?php
require_once __DIR__ . '/../../controllers/MarketController.php';
require_once __DIR__ . '/../../controllers/StoreController.php';

use app\Models\categories\Category;
use app\Models\Message\Chat;
use app\Models\Message\Message;
use app\Models\Notification\Notification;
use app\Models\Product\Product;
use app\Models\Reviews\Reviews;

$pending = Product::count_pending_products($conn);
$systemUnread = Notification::getUnreadSupportNotificationsCount(0);
?>
<head>
    <link rel="stylesheet" href="../../../../../../../app/Views/store/storegenCss.css">
    <title><?= isset($action) ? $action: "Home";?> | Whales Market</title>
</head>
<?php
require_once 'nav-bar.php';
?>
<div class="container">
    <div class="cls-top">

    </div>
    <div class="main">
        <div class="cls-left">
            <div class="wlc-info">
                <div class="avater">
                    <div class="bg-img">
                        <img src="../../../Assets/Images/ee8cef4927538da2a8cfa9e3ecad29ce7cfbcd5f.jpg" class="background-img" alt="" srcset="">
                        <!-- <img src="../../Assets/Images/ee8cef4927538da2a8cfa9e3ecad29ce7cfbcd5f.jpg" class="top-img" alt="" srcset=""> -->
                    </div>

                </div>
                <div class="name-status">
                    <p>Welcome, Mamoud</p>
                    <p><span>Last Login: </span> <span>27/04/2023</span></p>
                    <p><span>Last Activites: </span> <span><a href="?action=last-activites">see here</a></span></p>
                    <p><span>Level:</span> <span class="trust-level-7">Senior Mod</span></p>
                    <p><span>Status: </span> <span class="status-active">Active</span></p>
                </div>

            </div>
            <div class="menus">
                <div class="dashboard">
                    <img src="../../../../app/icons/dashboard.svg" width="20" alt="" srcset="">
                    <a href="/smod">Dashboard</a>
                </div>
                <div class="reviews" style="margin: 0;">
                    <img src="../../../app/icons/reviews.svg" width="20" alt="" srcset="">
                    <a href="/smod/reviews">Today Reviews(<?= Reviews::countAllTodayReviews(); ?>)</a>
                </div>
                <div class="new-listings">
                    <img src="../../../app/icons/pending.svg" width="20" alt="" srcset="">
                    <a href="/smod/listings">Pending Listings<?= !empty($pending) ? '<span class="unread" style="color: darkred;">('.$pending.')</span>' : '<span style="color: green;">('.$pending.')</span>';?></a>
                </div>
                <div class="market-tickets">
                    <img src="../../../app/icons/problem.svg" alt="" srcset="">
                    <a href="/smod/disputes">Disputes(0)</a>
                </div>
                <div class="market-tickets">
                    <img src="../../../app/icons/monitoring.svg" alt="" srcset="">
                    <a href="/smod/stats">Market Stats</a>
                </div>
                <div class="wallet">
                    <img src="../../../app/icons/wallet.svg" alt="" srcset="">
                    <a href="/smod/payout">Wallet(payout)</a>
                </div>
                <div class="guides">
                    <img src="../../../../app/icons/chat.svg" width="20" alt="" srcset="">
                    <a href="/smod/guides">Moderation Guidelines</a>
                </div>
                <div class="market-tickets">
                    <img src="../../../app/icons/help_center.svg" alt="" srcset="">
                    <a href="/smod/support">Support Tickets<?= !empty($systemUnread) ? '<span class="unread" style="color: darkred;">('.$systemUnread.')</span>' : '<span style="color: green;">('.$systemUnread.')</span>' ;?></a>
                </div>
                <div class="settings">
                    <img src="../../../app/icons/security.svg" width="20" alt="" srcset="">
                    <a href="/smod/settings">Settings(Edit)</a>
                </div>
            </div>
        </div>
        <div class="cls-main">
            <?php

            if (isset($action) && $action == 'guides') {
                require_once 'guides.php';
            }elseif (isset($action) && $action == 'payout') {
                require_once 'payout.php';
            }elseif (isset($action) && $action == 'settings') {
                require_once 'settings.php';
            }elseif (isset($action) && $action == 'stand-up') {
                require_once 'stand-up.php';
            } elseif (isset($action) && $action == 'reviews') {
                require_once 'reviews.php';
            }elseif (isset($action) && $action == 'notification') {
                require_once 'notifications.php';
            }elseif (isset($action) && $action == 'stats') {
                require_once 'stats.php';
            }elseif (isset($action) && $action == 'disputes') {
                require_once 'disputes.php';
            }elseif (isset($action) && $action == 'listings') {
                require_once 'listings.php';
            }elseif (isset($action) && $action == 'support') {
                require_once 'system_messages.php';
            }elseif (isset($support_id) && !empty($support_id)) {
                require_once 'support.php';
            }else {
                require_once 'dashboard.php';
            }
            ?>
    </div>
</div>
<?php
    require_once 'footer.php';
?>