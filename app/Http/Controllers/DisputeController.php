<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Http\Requests\StoreDisputeRequest;
use App\Http\Requests\UpdateDisputeRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\NotificationType;
use App\Models\Order;
use App\Models\Participant;
use Illuminate\Http\Request;
use Symfony\Component\Mime\MessageConverter;

class DisputeController extends Controller
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
    public function store(StoreDisputeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispute $dispute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dispute $dispute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisputeRequest $request, Dispute $dispute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dispute $dispute)
    {
        //
    }

    public function disputeShow(Request $request, $user, $created_at, Dispute $dispute)
    {
      
        if ($created_at == strtotime($dispute->created_at)) {
            return view('Senior.dispute', [
                'parentCategories' => Category::whereNull('parent_category_id')->get(),
                'subCategories' => Category::whereNotNull('parent_category_id')->get(),
                'categories' => Category::all(),
                'icon' => GeneralController::encodeImages(),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'order' => Order::where('id', $dispute->order_id)->first(),
                'action' => 'order',
                'user' => auth()->user(),
                'dispute' => $dispute,
            ]);
        }
    }


    public function disputeDo(Request $request, $user, $created_at, Dispute $dispute)
    {
        $user = auth()->user();
        if ($created_at == strtotime($dispute->created_at)) {
            if ($request->has('join_dispute') && $dispute->mediator_id == null) {

                $participant = new Participant();
                $participant->user_id = $user->id;
                $participant->conversation_id = $dispute->conversation_id;
                $participant->save();

                $dispute->mediator_id = $user->id;
                $dispute->save();
                return redirect()->back();

            }elseif ($request->has('new_message') && $dispute->mediator_id == $user->id){
                return redirect()->back()->with('new_message', true);

            }elseif ($request->has('contents') && $dispute->mediator_id == $user->id){
                $this->createMessage($dispute->conversation_id, $request);
                return redirect()->back();

            } elseif ($request->has('release')) {
            // $notificationType = NotificationType::where('action', 'completed')->where('icon', 'order')->first();

            // if ($notificationType) {
            //     NotificationController::create($order->user_id, null, $notificationType->id, $order->id);
            //     NotificationController::create($order->product->store->user_id, null, $notificationType->id, $order->id);
            // }

            // $order->status = 'completed';
            // $order->save();
            // // Save the product sales
            // $order->product->sold += $order->quantity;
            // $order->product->quantity -= $order->quantity;
            // $order->product->save();


            // //save the store sales
            // $order->store->width_sales += 1;
            // $order->store->save();
            // if ($order->escrow) {
            //     $order->escrow->status = 'released';
            //     $order->escrow->save();
            // }

            // if ($dispute && $order->dispute->status != 'closed') {
            //     $dispute->status = 'closed';
            //     $dispute->winner = 'Store';
            //     $dispute->save();

            //     // Save the user lost dispute
            //     $order->user->disputes_lost += 1;
            //     $order->user->save();

            //     //save the store win dispute
            //     $order->store->disputes_won += 1;
            //     $order->store->save();

            //     // Save the product win dispute
            //     $order->product->disputes_won += 1;
            //     $order->product->save();

            //     $order->status = 'dispute';
            //     $order->save();
        //}

            return redirect()->back()->with('success', 'Order completed successfully!');
        } elseif ($request->has('partial_refund')) {
            return redirect()->back()->with('partial_refund_form', true);

        }elseif ($request->has('partial_percent')) {
            $request->validate(['partial_percent' => 'required|integer|between:1,100']);

            $dispute->partial_percent = $request->partial_percent;
            $dispute->refund_initiated = 'staff';
            $dispute->status = 'Partial Refund';
            $dispute->save();
            return redirect()->back();
        }

            
        }


        return abort(404);
    }

    public function createMessage($conversation_id, $request)
    {
        $user = auth()->user();
        $data   = $request->validate([
            'contents' => 'required|string|min:2|max:5000',
            'message_type' => 'required|in:message,ticket,dispute',
        ]);

        $lastMessage = Message::where('conversation_id', $conversation_id)->first();
        

        if ($lastMessage) {
           if ($request->message_type == 'ticket' && $lastMessage['message_type'] == 'ticket') {
            $support = $user->supports->where('conversation_id', $conversation_id)->first();
            if ($support != null && $support->status != 'open') {
                return redirect()->back();
            }
           }elseif ($request->message_type == 'ticket' && $lastMessage['message_type'] == 'ticket') {
            # code...
           }elseif ($request->message_type == 'ticket' && $lastMessage['message_type'] == 'ticket') {
            # code...
           }
        }
        //Create message
        $message = new Message();
        $message->content  = $data['contents'];
        $message->user_id = $user->id;
        $message->conversation_id  = $conversation_id;
        $message->message_type     = $data['message_type'];
        $message->save();

        //Create Message status for participants
        $participants = Participant::where('conversation_id', $conversation_id)->get();
        foreach ($participants as $participant) {
            $messageStatus = new MessageStatus();
            $messageStatus->message_id = $message->id;
            $messageStatus->user_id    = $participant->user_id;
            $messageStatus->is_read    = $user->id == $participant->user_id ? 1 : 0;
            $messageStatus->save();
        }

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
