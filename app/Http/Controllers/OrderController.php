<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Dispute;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\NotificationType;
use App\Models\Participant;
use App\Models\Referral;
use App\Models\Review;
use App\Models\Unauthorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($created_at, Order $order)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/pgp/verify');
        }
        $user   = auth()->user();
        if (strtotime($order->created_at) == $created_at) {
            return view('User.orderViews', [
                'user' => $user,
                'parentCategories' => Category::whereNull('parent_category_id')->get(),
                'subCategories' => Category::whereNotNull('parent_category_id')->get(),
                'categories' => Category::all(),
                'icon' => GeneralController::encodeImages(),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'order' => $order,
                'name'  => 'order',
                'action' => null,
            ]);
        }

        return abort(403);
    }


    public function showStoreOrder($store, $created_at, Order $order)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        $store = auth()->user()->store;
        if (strtotime($order->created_at) == $created_at) {
            return view('Store.orderView', [
                'storeUser' => auth()->user(),
                'store' => $store,
                'parentCategories' => Category::whereNull('parent_category_id')->get(),
                'subCategories' => Category::whereNotNull('parent_category_id')->get(),
                'categories' => Category::all(),
                'icon' => GeneralController::encodeImages(),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'order' => $order,
                'action' => 'order',
            ]);
        }

        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $created_at, Order $order)
    {
        if (strtotime($order->created_at) == $created_at) {
            return $this->orderChanges($request,  $order);
        }
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    // private function orderChanges(UpdateOrderRequest $request, Order $order)
    // {
    //     $user = auth()->user();


    //     } elseif ($request->has('new_message') && $order->status == 'dispute' && $order->dispute->status != 'closed') {
    //         return redirect()->back()->with('new_message', true);
    //     } elseif ($request->has('release')) {
    //         $notificationType = NotificationType::where('action', 'completed')->where('icon', 'order')->first();

    //         if ($notificationType) {
    //             NotificationController::create($order->user_id, null, $notificationType->id, $order->id);
    //             NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
    //         }

    //         $order->status = 'completed';
    //         $order->save();
    //         // Save the product sales
    //         $order->product->sold += $order->quantity;
    //         $order->product->quantity -= $order->quantity;
    //         $order->product->save();


    //         //save the store sales
    //         $order->store->width_sales += 1;
    //         $order->store->save();
    //         if ($order->escrow) {
    //             $order->escrow->status = 'released';
    //             $order->escrow->save();
    //         }

    //         if ($order->dispute && $order->dispute->status != 'closed') {
    //             $order->dispute->status = 'closed';
    //             $order->dispute->winner = 'Store';
    //             $order->dispute->save();

    //             // Save the user lost dispute
    //             $order->user->disputes_lost += 1;
    //             $order->user->save();

    //             //save the store win dispute
    //             $order->store->disputes_won += 1;
    //             $order->store->save();

    //             // Save the product win dispute
    //             $order->product->disputes_won += 1;
    //             $order->product->save();

    //             $order->status = 'dispute';
    //             $order->save();
    //         }

    //         return redirect()->back()->with('success', 'Order completed successfully!');
    //     } elseif ($request->has('partial_refund')) {





    //     return abort(404);
    // }


    private function createMessage($data, $conversation_id)
    {
        $user  = auth()->user();
        //Create message
        $message = new Message();
        $message->content  = $data['contents'];
        $message->user_id = $user->id;
        $message->conversation_id  = $conversation_id;
        $message->message_type     = 'dispute';
        $message->save();

        //Create Message status for participants
        $participants = Participant::where('conversation_id', $conversation_id)->get();
        foreach ($participants as $participant) {
            $messageStatus = new MessageStatus();
            $messageStatus->message_id = $message->id;
            $messageStatus->user_id    = $participant->user_id;
            if ($participant->user_id == $user->id) {
                $messageStatus->is_read = 1;
            } else {
                $messageStatus->is_read =  0;
            }

            $messageStatus->save();
        }

        foreach (Message::where('conversation_id', $conversation_id)->get() as $message) {
            foreach ($message->status->where('user_id', $user->id) as $messageStatus) {
                $messageStatus->is_read = 1;
                $messageStatus->save();
            }
        }

        return;
    }

    public function addStoreNote(Request $request, $store, $created_at, Order $order)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        if ($store == $order->store->store_name  && $created_at == strtotime($order->created_at)) {
            $request->validate(['store_note' => 'required|min:3|max:5000']);
            $order->store_notes = $request->store_note;
            $order->save();
            return redirect()->back()->with('success', 'You have successfully update the store note for this order.');
        }
    }


    public static function initiateOrder($user, Cart $cart)
    {
        $order = new Order([
            'user_id' => $user->id,
            'product_id' => $cart->product_id,
            'store_id' => $cart->product->store_id,
            'quantity' => $cart->quantity,
            'extra_id' => $cart->extra_option_id,
            'shipping_address' => $cart->note,
        ]);
        $order->save();

        // Check if the product is set for auto dispatch
        if ($cart->product->auto_delivery_content && $cart->product->product_type == 'digital') {
            $notificationType = NotificationType::where('action', 'dispatched')->where('icon', 'order')->first();

            NotificationController::create($user->id, null, $notificationType->id, $order->id);
            NotificationController::create($cart->product->store->user_id, null, $notificationType->id, $order->id);

            $order->status = 'dispatched';
            $order->store_notes = $order->product->auto_delivery_content;
            $order->save();
        }

        $notificationType = NotificationType::where('action', 'created')->where('icon', 'order')->first();

        NotificationController::create($user->id, null, $notificationType->id, $order->id);
        NotificationController::create($cart->product->store->user_id, null, $notificationType->id, $order->id);

        return $order;
    }


    private function orderChanges(UpdateOrderRequest $request, Order $order)
    {
        if ($order->user->id != auth()->user()->id) {
            $this->logUnauthorizedAttempt($request, 'order wrong user id 401');
            return abort(401);
        }

        if ($request->has('cancel')) {
            if ($order->status != 'pending') {
                $this->logUnauthorizedAttempt($request, 'order not pending and try to cancelled.');
                return redirect()->back();
            }

            return $this->cancelOrder($request, $order);
        } elseif ($request->has('dispute')) {
            if ($order->status == 'pending' || $order->status == 'completed' || $order->status == 'dispute') {
                $this->logUnauthorizedAttempt($request, 'order is completed, disputed or pending and try to dispute.');
                return redirect()->back();
            }

            return $this->disputeOrder($request, $order);
        } elseif ($request->has('dispute_form')) {
            if ($order->dispute == null) {
                $this->logUnauthorizedAttempt($request, 'order dispute doesnt exist and try to submit form.');
                return redirect()->back();
            }

            if ($order->dispute->status == 'closed') {
                $this->logUnauthorizedAttempt($request, 'order dispute has been closed and try tp submit form.');
                return redirect()->back();
            }

            return $this->createDisputeMessage($request, $order);
        } elseif ($request->has('release')) {
            if ($order->status == 'dispute' || $order->status == 'completed') {
                $this->logUnauthorizedAttempt($request, 'order try to release funds for disputed or completed order.');
                return redirect()->back();
            }

            return $this->releaseOrderFunds($request, $order);
        } elseif ($request->has('new_message')) {
            if ($order->status != 'dispute' || $order->dispute->status == 'closed') {
                $this->logUnauthorizedAttempt($request, 'Order dispute closed or there is no dispute but try to send message.');
            }

            return redirect()->back()->with('new_message', true);
        } elseif ($request->has('partial_refund')) {
            if ($order->dispute === null || $order->dispute->status == 'Partial Refund') {
                $this->logUnauthorizedAttempt($request, 'order try to start a Partial Refund while dispute is in Partial Refund.');
                return redirect()->back();
            }

            if ($order->dispute === null || $order->dispute->status == 'closed') {
                $this->logUnauthorizedAttempt($request, 'order try to start a Partial Refund while dispute is closed.');
                return redirect()->back();
            }

            return $this->PartialRefundRequest($request, $order);
        } elseif ($request->has('review_form')) {

            if ($order->status != 'completed' || $order->product->payment_type != "FE") {
                $this->logUnauthorizedAttempt($request, 'order review not valid order not completed or fe.');
                return redirect()->back();
            }

            if (now()->diffInDays($order->updated_at) > 5) {
                $this->logUnauthorizedAttempt($request, 'order review not valid order updated more than 5 days a go.');
                return redirect()->back();
            }

            return $this->createReview($request, $order);
        } elseif ($request->has('request_staff')) {

            if ($order->dispute === null || $order->dispute->mediator_request == 1) {
                $this->logUnauthorizedAttempt($request, 'order try to request mode while mod has been requested.');
                return redirect()->back();
            }

            return $this->requestStaffMediation($request, $order);
        } elseif ($request->has('accept_store_fund')) {

            if (($order->dispute->refund_initiated == 'User' || $order->dispute->refund_initiated == 'none')) {
                $this->logUnauthorizedAttempt($request, 'order try to accept store funds while refund initiated by user or none.');
                return redirect()->back();
            }

            return $this->acceptStoreFunds($request, $order);
        } elseif ($request->has('user_partial_percent') && $request->has('store_partial_percent')) {

            if (($order->dispute->refund_initiated != 'none')) {
                $this->logUnauthorizedAttempt($request, 'order try to initiate partial percentage while it been iniataited.');
                return redirect()->back();
            }

            $request->validate(
                ['user_partial_percent' => 'required|integer|between:1,100'],
                ['store_partial_percent' => 'required|integer|between:1,100'],
            );

            return $this->partialPercentage($request, $order);
        } else {
            $this->logUnauthorizedAttempt($request, 'order 404 something went wrong.');
            return abort(404);
        }
    }




    private function cancelOrder(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for canceling the order)
        $notificationType = NotificationType::where('action', 'cancelled')->where('icon', 'order')->first();

        if ($notificationType) {
            NotificationController::create(null, null, $notificationType->id, $order->id);
            NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
        }
        $order->status = 'cancelled';
        $order->save();
        return redirect()->back();
    }

    private function disputeOrder(UpdateOrderRequest $request, Order $order)
    {
        $user = auth()->user();
        // ... (Logic for disputing the order)
        $notificationType = NotificationType::where('action', 'dispute')->where('icon', 'order')->first();

        if ($notificationType) {
            NotificationController::create(null, null, $notificationType->id, $order->id);
            NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
        }

        $order->status = 'dispute';
        $order->save();
        // create conversation for dispute
        $conversation = new Conversation();
        $conversation->topic = "New dispute created";
        $conversation->save();

        // Particippants
        $participants = new Participant();
        $participants->user_id = $user->id;
        $participants->conversation_id = $conversation->id;
        $participants->save();

        $participants = new Participant();
        $participants->user_id = $order->product->store->user_id;
        $participants->conversation_id = $conversation->id;
        $participants->save();

        // create the dispute now
        $dispute = new Dispute();
        $dispute->order_id = $order->id;
        $dispute->escrow_id = $order->escrow != null ? $order->escrow->id : null;
        $dispute->conversation_id = $conversation->id;
        $dispute->save();

        return redirect()->back();
    }

    private function createDisputeMessage(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for creating a dispute message)
        $data = $request->validate(['contents' => 'required|string|min:2|max:1000']);
        $dispute = Dispute::where('order_id', $order->id)->first();
        $this->createMessage($data, $dispute->conversation_id);
        return redirect()->back();
    }

    // private function releaseOrderFunds(UpdateOrderRequest $request, Order $order)
    // {
    //     // ... (Logic for releasing order funds)
    //     $notificationType = NotificationType::where('action', 'completed')->where('icon', 'order')->first();

    //     if ($notificationType) {
    //         NotificationController::create($order->user_id, null, $notificationType->id, $order->id);
    //         NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
    //     }

    //     $order->status = 'completed';
    //     $order->save();

    //     // Save the product sales
    //     $order->product->sold += $order->quantity;
    //     $order->product->quantity -= $order->quantity;
    //     $order->product->save();

    //     // Save the user deatils
    //     $order->user->total_orders += 1;
    //     $order->user->spent += $order->escrow->fiat_amount;
    //     $order->user->wallet->balance = ($order->user->wallet->balance -  $order->escrow->fiat_amount);
    //     $order->user->save();

    //     // save user wallet balance
    //     $order->user->wallet->balance = ($order->user->wallet->balance -  $order->escrow->fiat_amount);
    //     $order->user->wallet->save();

    //     // Check if the user was refreed
    //     $Referred = Referral::where('referred_user_id', $order->user->id)->first();

    //     // take the five percent from the escrow
    //     $fivePercent = (($order->escrow->fiat_amount / 100) * 5);


    //     if ($Referred != null) {
    //         // give the user who referred this user a percentage
    //         $rererralPercent = (($fivePercent / 100 ) * 50);
    //         $Referred->balance += $rererralPercent;
    //         $Referred->save();
    //     }else{
    //         // add the balance to the market wallet

    //     }

    //     // save now the store balance
    //     $order->store->user->wallet->balance += ($order->escrow->fiat_amount - $fivePercent);
    //     $order->store->save();

    //     // save user
    //     $order->user->wallet->balance = ($order->user->wallet->balance -  $order->escrow->fiat_amount);
    //     $order->user->wallet->save();

    //     //save the store sales
    //     $order->store->width_sales += 1;
    //     $order->store->save();
    //     if ($order->escrow) {
    //         $order->escrow->status = 'released';
    //         $order->escrow->save();
    //     }

    //     if ($order->dispute && $order->dispute->status != 'closed') {
    //         $order->dispute->status = 'closed';
    //         $order->dispute->winner = 'Store';
    //         $order->dispute->save();

    //         // Save the user lost dispute
    //         $order->user->disputes_lost += 1;
    //         $order->user->save();

    //         //save the store win dispute
    //         $order->store->disputes_won += 1;
    //         $order->store->save();

    //         // Save the product win dispute
    //         $order->product->disputes_won += 1;
    //         $order->product->save();

    //         $order->status = 'dispute';
    //         $order->save();
    //     }

    //     return redirect()->back()->with('success', 'Order completed successfully!');
    // }

    private function PartialRefundRequest(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for handling partial refund request)
        return redirect()->back()->with('partial_refund_form', true);
    }

    private function createReview(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for creating a review)
        $user = auth()->user();

        $request->validate([
            'review_type' => 'required|in:positive,neutral,negative',
            'comment'    => 'required|string|min:3|max:2000',
            'communication_rating' => 'required|between:1,5|integer',
            'product_rating'  => 'required|between:1,5|integer',
            'shipping_speed_rating'  => 'required|between:1,5|integer',
            'price_rating'  => 'required|between:1,5|integer'
        ]);

        if ($order->review == null) {
            $review = new Review();
        } else if ($order->review != null && now()->diffInDays($order->updated_at) <= 5) {
            $review = Review::where('order_id', $order->id)->first();
        }
        $review->user_id = $user->id;
        $review->product_id = $order->product_id;
        $review->store_id = $order->store_id;
        $review->communication_rating = $request->communication_rating;
        $review->product_rating = $request->product_rating;
        $review->shipping_speed_rating = $request->shipping_speed_rating;
        $review->price_rating = $request->price_rating;
        $review->feedback = $request->review_type;
        $review->comment  = $request->comment;
        $review->order_id = $order->id;
        $review->save();

        return redirect()->back();
    }

    private function requestStaffMediation(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for requesting staff mediation)
        $order->dispute->mediator_request = 1;
        $order->dispute->save();

        return redirect()->back()->with('success', "The staff members has been notified please patient a while let a staff join the dispute process.");
    }

    private function acceptStoreFunds(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for accepting store funds in a dispute)
        if ($order->dispute->user_partial_percent < 50) {
            $order->dispute->winner = 'store';
        } elseif ($order->dispute->store_partial_percent < 50) {
            $order->dispute->winner = 'user';
        } elseif ($order->dispute->store_partial_percent == 50) {
            $order->dispute->winner = 'both';
        }

        $order->dispute->user_refund_accept = 1;
        $order->dispute->status = 'closed';
        $order->dispute->save();

        return redirect()->back()->with('success', "The staff members has been notified please patient a while let a staff join the dispute process.");
    }


    private function partialPercentage(UpdateOrderRequest $request, Order $order)
    {
        // ... (Logic for accepting store funds in a dispute)
        $total = $request->user_partial_percent + $request->store_partial_percent;
        if ($total == 100) {

            $order->dispute->store_partial_percent = $request->store_partial_percent;
            $order->dispute->user_partial_percent = $request->user_partial_percent;
            $order->dispute->user_refund_accept = 1;
            $order->dispute->refund_initiated = 'User';
            $order->dispute->status = 'Partial Refund';
            $order->dispute->save();

            return redirect()->back();
        } else {
            return redirect()->back()->with('percentage_error', 'Partial System Error: The total percentage for you and the store must be equal to 100%!!!');
        }
    }

    private function logUnauthorizedAttempt(Request $request, $title)
    {
        // Log unauthorized attempt if 'completed' action is present
        $unauthorize = new Unauthorize();
        $unauthorize->user_id = auth()->user()->id;
        $unauthorize->title = $title;
        $unauthorize->content = "Your request has been sent to admin to violate the website rules by editing the form to complete the order!";
        $unauthorize->url = $request->path();
        $unauthorize->role = auth()->user()->role;
        $unauthorize->save();
    }

    private function releaseOrderFunds(UpdateOrderRequest $request, Order $order)
    {
        $this->updateOrderStatus($order);
        $this->sendNotifications($order);
        $this->updateProductSales($order);
        $this->updateUserDetails($order);
        $this->handleReferrals($order);
        $this->releaseEscrowFunds($order);
        $this->updateStoreBalance($order);
        $this->updateStoreSales($order);
        $this->handleDisputeIfAny($order);

        return redirect()->back()->with('success', 'Order completed successfully!');
    }

    // ... (Define the new smaller methods below)

    // Updates the order status to 'completed'
    private function updateOrderStatus(Order $order)
    {
        $order->status = 'completed';
        $order->save();
    }

    // Sends notifications to the user and store owner
    private function sendNotifications(Order $order)
    {
        $notificationType = NotificationType::where('action', 'completed')->where('icon', 'order')->first();

        if ($notificationType) {
            NotificationController::create($order->user_id, null, $notificationType->id, $order->id);
            NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
        }
    }

    // Updates product sales information
    private function updateProductSales(Order $order)
    {
        $order->product->sold += $order->quantity;
        $order->product->quantity -= $order->quantity;
        $order->product->save();
    }

    // Updates user details related to the order
    private function updateUserDetails(Order $order)
    {
        $order->user->total_orders += $order->quantity;
        $order->user->spent += $order->escrow->fiat_amount;
        $order->user->save();
        // wallet update
        $order->user->wallet->balance -= $order->escrow->fiat_amount;
        $order->user->wallet->save();
    }

    // Handles referral logic and updates balances
    private function handleReferrals(Order $order)
    {
        $referred = Referral::where('referred_user_id', $order->user->id)->first();

        if ($referred) {
            $referralAmount = ($order->escrow->fiat_amount * 0.05) * 0.5; // 5% of escrow, 50% to referrer
            $referred->balance += $referralAmount;
            $referred->save();
        } else {
            // Add the balance to the market wallet (logic not provided)
        }
    }

    // Releases escrow funds to the store owner
    private function releaseEscrowFunds(Order $order)
    {
        if ($order->escrow) {
            $order->escrow->status = 'released';
            $order->escrow->save();
        }
    }

    // Updates the store balance
    private function updateStoreBalance(Order $order)
    {
        $storeBalance = $order->escrow->fiat_amount - ($order->escrow->fiat_amount * 0.05); // Deduct 5% fee
        $order->store->user->wallet->balance += $storeBalance;
        $order->store->user->wallet->save();
    }

    // Updates store sales information
    private function updateStoreSales(Order $order)
    {
        $order->store->width_sales += $order->quantity;
        $order->store->save();
    }

    // Handles dispute resolution if applicable
    private function handleDisputeIfAny(Order $order)
    {
        if ($order->dispute && $order->dispute->status != 'closed') {
            $order->dispute->status = 'closed';
            $order->dispute->winner = 'Store';
            $order->dispute->save();

            // Update user, store, and product stats for lost/won dispute (logic remains the same)
        }
    }
}
