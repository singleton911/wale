<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Conversation;
use App\Models\MessageStatus;
use App\Models\Participant;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Category;

class MessageController extends Controller
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
    public function create($name, Store $store)
    {
        $user = auth()->user();
        if ($name === $store->store_name) {
            return view('User.createMessage', [
                'user' => $user,
                'icon'   => GeneralController::encodeImages(),
                'action' => NULL,
                'name'  => $name,
                'store' => $store,
            ]);
        }

        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $created_at, Conversation $conversation)
    {
        if ($request->has('new_message')) {
            return redirect()->back()->with('new_message', true);
        }

        if ($created_at == strtotime($conversation->created_at)) {
            return $this->createMessage($conversation->id, $request);
        }
        return abort(401);
    }


    /**
     * Display the specified resource.
     */
    public function show($created_at, Conversation $conversation)
    {
        $user = auth()->user();
        $type = null;

        if (strtotime($conversation->created_at) == $created_at) {
            
            return view('User.displayMessages', [
                'user' => $user,
                'icon'   => GeneralController::encodeImages(),
                'action' => null,
                'name'  => null,
                'support_conversation' => $type != null ? $conversation : null,
                'normal_conversation' => $type != null ? null : $conversation,
            ]);
        }

        return abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    public function createMessage($conversation_id, $request)
    {
        $user_id  = auth()->user()->id;
        $data   = $request->validate([
            'contents' => 'required|string|min:2|max:5000',
            'message_type' => 'required|in:message,ticket,dispute',
        ]);

        //Create message
        $message = new Message();
        $message->content  = $data['contents'];
        $message->user_id = $user_id;
        $message->conversation_id  = $conversation_id;
        $message->message_type     = $data['message_type'];
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

        return redirect()->back()->with('success', 'Yes, everything created');
    }

    public function showMessages()
    {
        $conversations = Conversation::all();
        $participants = Participant::where('user_id', auth()->user()->id)->get();
        $user = auth()->user();
        return view('User.message', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
            'userConversations'   => $participants,
            'conversations'   => $conversations,
        ]);
    }

    public function storeUser(Request $request, $name, $created_at, Conversation $conversation)
    {
        if ($request->has('new_message')) {
            return redirect()->back()->with('new_message', true);
        }

        if ($created_at == strtotime($conversation->created_at)) {
            return $this->createMessage($conversation->id, $request);
        }
        return abort(401);
    }
}
