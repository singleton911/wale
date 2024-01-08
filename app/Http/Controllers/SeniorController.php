<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Dispute;
use App\Models\Featured;
use App\Models\News;
use App\Models\NewStore;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Order;
use App\Models\Participant;
use App\Models\Product;
use App\Models\Report;
use App\Models\Store;
use App\Models\Support;
use App\Models\User;
use App\Models\Waiver;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SeniorController extends Controller
{


    public function index($user, $action = null)
    {
        $auth_user = auth()->user();
    
        // Use paginate method to retrieve paginated results
        $users = User::paginate(50); 
        $stores = Store::paginate(50);
        $reports = Report::paginate(50);
        $wallets = Wallet::paginate(50);
        $products = Product::paginate(50);
        $orders = Order::paginate(50);
        $disputes = Dispute::paginate(50);
        $featureds = Featured::paginate(50);
        $new_stores = NewStore::paginate(50);
        $supports = Support::paginate(50);
        $waiver = Waiver::paginate(50);
        $news = News::paginate(50);
        $categories = Category::paginate(50);
        $conversations = Conversation::paginate(50);
        $participants = Participant::paginate(50);
        $notifications = Notification::paginate(50);
        $userConversations = Participant::where('user_id', auth()->user()->id)->get();
    
        if ($user == $auth_user->public_name && $auth_user->role == 'senior') {
            return view('Senior.index', [
                'user' => $auth_user,
                'action' => $action,
                'icon' => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
                'userConversations'   => $userConversations,
                // Models
                'users' => $users,
                'stores' => $stores,
                'reports' => $reports,
                'wallets' => $wallets,
                'products' => $products,
                'orders' => $orders,
                'disputes' => $disputes,
                'featureds' => $featureds,
                'new_stores' => $new_stores,
                'supports' => $supports,
                'waivers' => $waiver,
                'news' => $news,
                'categories' => $categories,
                'storeConversations' => $participants,
                'conversations' => $conversations,
                'notifications' => $notifications,
                'dashboard_products' => Product::paginate(10)->where('status', 'Pending'),
                'dashboard_new_stores' => NewStore::paginate(10),
            ]);
        }
        return abort(403);
    }
    

    public function user($created_at, User $user){
        $auth_user = auth()->user();
        $show_user = $user;

        if ($created_at == strtotime($user->created_at) && $auth_user->role == 'senior') {

            return view('Senior.index', [
                'user' => $auth_user,
                'show_user' => $user,
                'action'  => 'Show User',
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }



    public function new_store($created_at, NewStore $new_store){
        $auth_user = auth()->user();

        if ($created_at == strtotime($new_store->created_at) && $auth_user->role == 'senior') {

            return view('Senior.index', [
                'user' => $auth_user,
                'new_store' => $new_store,
                'action'  => 'New Store',
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }


    public function product($created_at, Product $product){
        $auth_user = auth()->user();

        if ($created_at == strtotime($product->created_at) && $auth_user->role == 'senior') {

            return view('Senior.index', [
                'user' => $auth_user,
                'product' => $product,
                'action'  => 'product',
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }


    public function supportTicket($created_at, Conversation $conversation){
        $auth_user = auth()->user();

        if ($created_at == strtotime($conversation->created_at) && $auth_user->role == 'senior') {

            return view('Senior.ticket', [
                'user' => $auth_user,
                'conversation' => $conversation,
                'action'  => 'ticket',
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }

    public function joinSupport(Request  $request){
        $request->validate(['support_id' => 'required|min:32']);
        $support_id = Crypt::decrypt($request->support_id);
        $support  = Support::find($support_id);

        if ($request->has('join_support')) {
            if ($support->staff_id == null) {
                $support->staff_id = auth()->user()->id;
                $support->status   = 'open';
                $support->save();

                $participant = new Participant();
                $participant->user_id = auth()->user()->id;
                $participant->conversation_id = $support->conversation_id;
                $participant->save();

                return redirect()->back();
            }
        }

        return abort(403);
    }


    public function banUnbanUser(Request $request){
        $request->validate(['user_id' => 'required|min:32']);
        $user = User::find(Crypt::decrypt($request->user_id));
        if ($user && $request->has('un_ban')) {
            $user->status = 'active';
            $user->save();
            return redirect()->back();

        }elseif ($user && $request->has('ban')) {
            $user->status = 'banned';
            $user->save();
            return redirect()->back();
        }

        return abort(403);
    }


    public function approveDeclineStore(Request $request){
        $request->validate(['new_store_id' => 'required|min:32']);
        $new_store = NewStore::find(Crypt::decrypt($request->new_store_id));

        if ($new_store && $request->has('approve')) {
            $store_user = User::find($new_store->user_id);
            $store_user->store_status = 'active';
            $store_user->role     = 'store';
            $store_user->save(); // Save the changes

            $store = $this->copyStore($new_store);

            $notificationType = NotificationType::where('action', 'approved')->where('icon', 'store')->first();

            if ($store && $notificationType) {
                NotificationController::create($new_store->user_id, auth()->user()->id,$notificationType->id);

                $new_store->delete();
            }

            return redirect('/');

        }elseif ($new_store && $request->has('decline')) {
            $store_user = User::find($new_store->user_id);
            $store_user->store_status = 'rejected';
            $store_user->save(); // Save the changes

            $notificationType = NotificationType::where('action', 'rejected')->where('icon', 'store')->first();

            if ($notificationType) {
                NotificationController::create($new_store->user_id, auth()->user()->id,$notificationType->id);
            }
            return redirect()->back();
        }
        
        

        return abort(403);
    }


    private function copyStore(NewStore $newStore){
        $store = new Store();
        $store->user_id    = $newStore->user_id;
        $store->store_name = $newStore->store_name;
        $store->store_description = $newStore->store_description;
        $store->store_pgp       = $newStore->user->user_pgp;
        $store->store_key   = $newStore->user->store_key;
        $store->selling     = $newStore->selling;
        $store->ship_from   =  $newStore->ship_from;
        $store->ship_to     = $newStore->ship_to;
        $store->last_updated = now();
        $store->avatar      = $newStore->avater;
        $store->save();
        return true;
    }


    public function store($created_at, Store $store){
        $auth_user = auth()->user();

        if ($created_at == strtotime($store->created_at) && $auth_user->role == 'senior') {

            return view('Senior.index', [
                'user' => $auth_user,
                'store' => $store,
                'action'  => 'Store',
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }
}

