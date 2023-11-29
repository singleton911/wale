<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Dispute;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\NotificationType;
use App\Models\Participant;
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
        $user   = auth()->user();
        if (strtotime($order->created_at) == $created_at) {
            return view('User.orderViews', [
                'user' => $user,
                'parentCategories' => Category::whereNull('parent_category_id')->get(),
                'subCategories' => Category::whereNotNull('parent_category_id')->get(),
                'categories' => Category::all(),
                'icon' => GeneralController::encodeImages(),
                'order' => $order,
                'name'  => 'order',
                'action' => null,
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

    private function orderChanges(UpdateOrderRequest $request, Order $order)
    {
        if ($request->cancel === 'Cancel this order') {
            $notificationType = NotificationType::where('action', 'cancelled')->where('icon', 'order')->first();

            if ($notificationType) {
                NotificationController::create(null,null,$notificationType->id, $order->id);
                NotificationController::create($order->product->store->user_id,null,$notificationType->id, $order->id);
            }
            $order->status = 'cancelled';
            $order->save();
            return redirect()->back();
        }else if ($request->dispute === 'Dispute this order'){
            $notificationType = NotificationType::where('action', 'disputed')->where('icon', 'order')->first();

            if ($notificationType) {
                NotificationController::create(null,null,$notificationType->id, $order->id);
                NotificationController::create($order->product->store->user_id,null,$notificationType->id, $order->id);
            }

            $order->status = 'dispute';
            $order->save();
            // create conversation for dispute
            $conversation = new Conversation();
            $conversation->topic = "New dispute created";
            $conversation->save();
            
            // Particippants
            $participants = new Participant();
            $participants->user_id = auth()->user()->id;
            $participants->conversation_id = $conversation->id;
            $participants->save();

            $participants = new Participant();
            $participants->user_id = $order->product->store->user_id;
            $participants->conversation_id = $conversation->id;
            $participants->save();

            // create the dispute now
            $dispute = new Dispute();
            $dispute->user_id  = auth()->user()->id;
            $dispute->order_id = $order->id;
            $dispute->conversation_id = $conversation->id;
            $dispute->save();

            return redirect()->back();
        }elseif ($request->dispute_form == 'Send' && $order->dispute->static != 'closed') {
            $data = $request->validate(['contents' => 'required|string|min:10|max:1000']);
            $dispute = Dispute::where('order_id', $order->id)->first();
            $this->createMessage($data, $dispute->conversation_id);
            return redirect()->back();
        }elseif ($request->new_message == 'New Reply' && $order->dispute->static != 'closed') {
            return redirect()->back()->with('new_message', true);

        }elseif ($request->release == 'release fund for this order') {
            $notificationType = NotificationType::where('action', 'completed')->where('icon', 'order')->first();

            if ($notificationType) {
                NotificationController::create(null,null,$notificationType->id, $order->id);
                NotificationController::create($order->product->store->user_id,null,$notificationType->id, $order->id);
            }

            $order->status = 'completed';
            $order->save();
            //return redirect()->back();
            return "Ok let release this funds";
        }
        return abort(403);
    }


    private function createMessage($data, $conversation_id)
    {
        $user_id  = auth()->user()->id;
        //Create message
        $message = new Message();
        $message->content  = $data['contents'];
        $message->user_id = $user_id;
        $message->conversation_id  = $conversation_id;
        $message->message_type     = 'dispute';
        $message->save();

        //Create Message status for participants
        $participants = Participant::where('conversation_id', $conversation_id)->get();
        foreach ($participants as $participant) {
            $messageStatus = new MessageStatus();
            $messageStatus->message_id = $message->id;
            $messageStatus->user_id    = $participant->user_id;
            $messageStatus->is_read    = $user_id == $participant->user_id ? 1 : 0;
            $messageStatus->save();
        }

        return;
    }
}
