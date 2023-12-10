<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\Participant;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class ConversationController extends Controller
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
    public function store(StoreConversationRequest $request, $name, Store $store)
    {
        $user_id  = auth()->user()->id;

        if ($request->has('new_message')) {
            return redirect()->back()->with('new_message', true);
        }

        if ($store->store_name === $name) {
            return $this->createMessage($store->id, $request);
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show($created_at, Conversation $conversation)
    {
        $user = auth()->user();
        $type = null;
        if (strtotime($conversation->created_at) == $created_at) {
            // Mark all messages under this conversation as read for the specified user
            foreach ($conversation->messages as $message) {
                foreach ($message->status->where('user_id', $user->id) as $status) {
                    if ($status->is_read == 0) {
                        // Assuming MessageStatus is an Eloquent model
                        $messageStatus = MessageStatus::find($status->id);
                        if ($messageStatus) {
                            $messageStatus->is_read = 1;
                            $messageStatus->save();
                            return redirect('/messages/' . $created_at . '/' . $conversation->id);
                        }
                    }
                }
            }
            return view('User.displayMessages', [
                'user' => $user,
                'icon'   => GeneralController::encodeImages(),
                'action' => null,
                'name'  => null,
                'conversation' => $conversation,
            ]);
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationRequest $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        //
    }


    public function createMessage($store, StoreConversationRequest $request)
    {
        $user_id  = auth()->user()->id;
        $store_user_id = Store::find($store)->user_id;
        $data   = $request->validate([
            'subject' => 'required|string|min:1|max:100',
            'contents' => 'required|string|min:2|max:5000',
            'message_type' => 'required|in:message,ticket,dispute',
        ]);

        // Create conversation
        $conversation = new Conversation();
        $conversation->topic = $data['subject'];
        $conversation->save();

        // Participants
        foreach ([$user_id, $store_user_id] as $id) {
            $participant = new Participant();
            $participant->user_id = $id;
            $participant->conversation_id = $conversation->id;
            $participant->save();
        }

        // Create message
        $message = new Message();
        $message->content  = $data['contents'];
        $message->user_id = $user_id;
        $message->conversation_id  = $conversation->id;
        $message->message_type     = $data['message_type'];
        $message->save();

        foreach ([$user_id, $store_user_id] as $participant) {
            $messageStatus = new MessageStatus();
            $messageStatus->message_id = $message->id;
            $messageStatus->user_id    = $participant;
            $messageStatus->is_read    = $user_id == $participant ? 1 : 0;
            $messageStatus->save();
        }

        return redirect()->back()->with('success', 'Your message has been successfully sent to the store.');
    }


    public function showStore($name, $created_at, Conversation $conversation)
    {
        $user = auth()->user();
        $store = auth()->user()->store;

        if (strtotime($conversation->created_at) == $created_at) {
            // Mark all messages under this conversation as read for the specified user
            foreach ($conversation->messages as $message) {
                foreach ($message->status->where('user_id', $user->id) as $status) {
                    if ($status->is_read == 0) {
                        // Assuming MessageStatus is an Eloquent model
                        $messageStatus = MessageStatus::find($status->id);
                        if ($messageStatus) {
                            $messageStatus->is_read = 1;
                            $messageStatus->save();
                            return redirect('/store/'.$store->store_name.'/show/messages/' . $created_at . '/' . $conversation->id);
                        }
                    }
                }
            }
            return view('Store.displayMessages', [
                'store' => $store,
                'user' => $user,
                'storeUser' => $user,
                'icon'   => GeneralController::encodeImages(),
                'conversation' => $conversation,
            ]);
        }

        return abort(404);
    }
}
