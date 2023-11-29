<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationTypes = [
            // News
            ['name' => 'New News', 'content' => 'A new news article has been published.', 'action' => 'created', 'icon' => 'news'],
            ['name' => 'News Updated', 'content' => 'An existing news article has been updated.', 'action' => 'created', 'icon' => 'news'],
            ['name' => 'New System Announcement', 'content' => 'Important announcement from the system administrator.', 'action' => 'announcement', 'icon' => 'news'],

            // Order
            ['name' => 'Order created', 'content' => 'A new order has been created.', 'action' => 'created', 'icon' => 'order'],
            ['name' => 'Order Disputed', 'content' => 'A dispute has been initiated for your order.', 'action' => 'disputed', 'icon' => 'order'],
            ['name' => 'Order Dispatch', 'content' => 'Your order is has been dispatched.', 'action' => 'dispatched', 'icon' => 'order'],
            ['name' => 'Order Completed', 'content' => 'Your order has been successfully completed.', 'action' => 'completed', 'icon' => 'order'],
            ['name' => 'Order Cancelled', 'content' => 'Your order has been cancelled.', 'action' => 'cancelled', 'icon' => 'order'],
            ['name' => 'Order Shipped', 'content' => 'Your order has been shipped.', 'action' => 'shipped', 'icon' => 'order'],
            ['name' => 'Order Delivered', 'content' => 'Your order has been delivered.', 'action' => 'delivered', 'icon' => 'order'],
            ['name' => 'Order Accepted', 'content' => 'Your order has been accepted by the store.', 'action' => 'accepted', 'icon' => 'order'],

            // Store
            ['name' => 'Store Key Generated', 'content' => 'A new encryption key has been generated for your store.', 'action' => 'key', 'icon' => 'store'],
            ['name' => 'Store Pending Approval', 'content' => 'Your store is pending approval for activation.', 'action' => 'pending', 'icon' => 'store'],
            ['name' => 'Store Approved', 'content' => 'Your store has been approved and is now active.', 'action' => 'approved', 'icon' => 'store'],
            ['name' => 'Store Rejected', 'content' => 'Your store activation request has been rejected.', 'action' => 'rejected', 'icon' => 'store'],

            // Account
            ['name' => 'Account PGP Added', 'content' => 'PGP encryption key has been added to your account.', 'action' => 'pgp', 'icon' => 'account'],
            ['name' => 'Account Trust Level Upgraded', 'content' => 'Your account trust level has been upgraded.', 'action' => 'upgraded', 'icon' => 'trust'],
            ['name' => 'Account Escalated', 'content' => 'Your account issue has been escalated for review.', 'action' => 'escalated', 'icon' => 'account'],
            ['name' => 'Account on Vacation', 'content' => 'Your account is on vacation mode.', 'action' => 'vacation', 'icon' => 'account'],
            ['name' => 'Account Warned', 'content' => 'A warning has been issued for your account.', 'action' => 'warning', 'icon' => 'account'],
            ['name' => 'Account Password Changed', 'content' => 'Your account password has been changed.', 'action' => 'change', 'icon' => 'account'],
            ['name' => 'Account Private Mirror Added', 'content' => 'A private mirror has been added to your account.', 'action' => 'added', 'icon' => 'mirror'],

            // Referral
            ['name' => 'Account Referral Added', 'content' => 'A referral link has been added to your account.', 'action' => 'added', 'icon' => 'referral'],
            ['name' => 'Referral Payment Received', 'content' => 'You have received payment for a referral.', 'action' => 'received', 'icon' => 'referral'],

            // Listings
            ['name' => 'Listing Almost Out of Stock', 'content' => 'Your listing is almost out of stock.', 'action' => 'out', 'icon' => 'listing'],
            ['name' => 'Listing Restocked', 'content' => 'Your listing has been restocked.', 'action' => 'restock', 'icon' => 'listing'],
            ['name' => 'New Listings', 'content' => 'Your favorite store added new listings check them out.', 'action' => 'added', 'icon' => 'listing'],

            // Deposits and Withdrawals
            ['name' => 'New Incoming Deposit', 'content' => 'A new deposit has been received in your account.', 'action' => 'received', 'icon' => 'deposit'],
            ['name' => 'Deposit Confirmed', 'content' => 'Your deposit has been confirmed and added to your balance.', 'action' => 'confirmed', 'icon' => 'deposit'],
            ['name' => 'Deposit Cancelled', 'content' => 'Your deposit request has been cancelled.', 'action' => 'cancellled', 'icon' => 'deposit'],
            ['name' => 'Deposit Rejected', 'content' => 'Your deposit request has been rejected.', 'action' => 'rejected', 'icon' => 'deposit'],
            ['name' => 'New Withdrawal Request', 'content' => 'A new withdrawal request has been submitted.', 'action' => 'submitted', 'icon' => 'withdraw'],
            ['name' => 'Withdrawal In Progress', 'content' => 'Your withdrawal request is in progress.', 'action' => 'progress', 'icon' => 'withdraw'],
            ['name' => 'Withdrawal Completed', 'content' => 'Your withdrawal request has been completed.', 'action' => 'completed', 'icon' => 'withdraw'],

             // Shared Access
             ['name' => 'New Shared Access Given', 'content' => 'Shared access has been given to your account.', 'action' => 'given', 'icon' => 'shared'],
             ['name' => 'Shared Access Taken', 'content' => 'Shared access has been removed from your account.', 'action' => 'taken', 'icon' => 'shared'],

             // Other Events
             ['name' => 'Escrow Time Increased', 'content' => 'The escrow time for your order has been increased.', 'action' => 'increased', 'icon' => 'escrow'],
             ['name' => 'Percentage Refund', 'content' => 'A percentage of your order has been refunded.', 'action' => 'refund', 'icon' => 'escrow'],
             ['name' => '100% Refund', 'content' => 'Your order has been fully refunded.', 'action' => 'full-refund', 'icon' => 'escrow'],

             // Report
            ['name' => 'Product Reported', 'content' => 'A product has been reported by a user for violation of market rules.', 'action' => 'reported', 'icon' => 'listing'],
            ['name' => 'Store Reported', 'content' => 'Your has been reported by a user for violation of market rules.', 'action' => 'reported', 'icon' => 'store'],


            // Bug
            ['name' => 'Bug Report Confirmed', 'content' => 'Your bug report has been confirmed and is under review.', 'action' => 'confirmed', 'icon' => 'bug'],
            ['name' => 'Bug Report Accepted', 'content' => 'Your bug report has been reviewed and accepted.', 'action' => 'accepted', 'icon'=> 'bug'],
            ['name' => 'Bug Report Rejected', 'content' => 'Your bug report has been reviewed and rejected.', 'action' => 'rejected', 'icon'=> 'bug'],
            ['name' => 'Bug Report Submitted', 'content' => 'A new bug report has been submitted.', 'action' => 'submitted', 'icon'=> 'bug'],


        ];

        foreach ($notificationTypes as $type) {
            NotificationType::create($type);
        }
    }
}
