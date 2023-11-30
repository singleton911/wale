<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\BlockStore;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ExtraOption;
use App\Models\FavoriteListing;
use App\Models\FavoriteStore;
use App\Models\NotificationType;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(StoreProductRequest $request)
    {
        // Retrieve validated data from the request
        $validatedData = $request->validated();

        // Save the images to public/storage/Product_Images with unique, encrypted names
        $imagePaths = [];
        foreach (['image_path1', 'image_path2', 'image_path3'] as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);

                // Call the function to process and store the image
                $imagePath = GeneralController::processAndStoreImage($file, 'Product_Images');

                $imagePaths[$key] = $imagePath;
            }
        }

        // Create a new Product instance with the validated data and image paths
        $product = Product::create($request->all());

        // Redirect to the appropriate route or view
        // You might want to redirect to the product details page or another page
        return redirect()->back()->with('success', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show($created_at, Product $product)
    {
        // Assuming $created_at is a timestamp
        $timestamp = strtotime($product->created_at);

        if ($timestamp !== false && $timestamp == $created_at) {
            return view('User.productPreview', [
                'product' => $product,
                'user' => auth()->user(),
                'parentCategories' => Category::where('parent_category_id', NULL)->get(),
                'subCategories' => Category::where('parent_category_id', '!=', NULL)->get(),
                'icon'   => GeneralController::encodeImages(),
            ]);
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function checkAction(Request $request, $created_at, Product $product)
    {
        $timestamp = strtotime($product->created_at);
        $user_id  = auth()->user()->id;
        $extra = $request->extra_shipping_option != 1 ? ExtraOption::where('id', $request->extra_shipping_option)->first()['cost'] : 0;
        if ($timestamp !== false && $timestamp == $created_at) {
            if ($request->has('add_to_cart')) {
                return $this->addToCart($request, $product);

            } elseif ($request->has('buy_now')) {
                // Check user's wallet balance before initiating the order
                if ($this->checkUserWalletBalance($user_id, ($product->price + $extra))) {
                    return redirect()->back()->with([
                        'enter_adderss' => true,
                        'extra_shipping_option' => $request->extra_shipping_option,
                        'items' => $request->items,
                    ]);
                } else {
                    // Insufficient balance, handle accordingly
                    return redirect()->back()->with('error', 'Insufficient balance to place the order.');
                }
            } elseif ($request->has('complete_order')) {
                // Check user's wallet balance before initiating the order
                if ($this->checkUserWalletBalance($user_id, ($product->price + $extra))) {
                    // User has sufficient balance, proceed with order initiation
                    $this->initiateOrder($request, $product);
                    return redirect()->back()->with('success', 'Order created successfully please see your order status in setting or notification!');
                } else {
                    // Insufficient balance, handle accordingly
                    return redirect()->back()->with('error', 'Insufficient balance to place the order.');
                }
            } elseif ($request->has('favorite_listing')) {
                $favoriteListing = new FavoriteListing();
                $favoriteListing->user_id = $user_id;
                $favoriteListing->product_id = $product->id;
                $favoriteListing->save();
                return redirect()->back();
            } elseif ($request->has('favorite_store')) {
                $favoriteStore  = new FavoriteStore();
                $favoriteStore->user_id = $user_id;
                $favoriteStore->store_id = $product->store->id;
                $favoriteStore->save();
                return redirect()->back();
            } elseif ($request->has('block_store')) {
                $blockStore  = new BlockStore();
                $blockStore->user_id = $user_id;
                $blockStore->store_id = $product->store->id;
                $blockStore->save();
                return redirect()->back();
            }
            return redirect()->back();
        }

        return abort(404);
    }


    private function initiateOrder(Request $request, Product $product)
    {
        // Your existing logic for initiating an order
        $user_id = auth()->user()->id;
        $sendData = $request->validate([
            'items' => 'required|integer|min:1|max:100000',
            'extra_shipping_option' => 'required|integer|min:1',
            'address_text' => 'sometimes|nullable|string|max:100000',
        ]);
        
        $notificationType = NotificationType::where('action', 'created')->where('icon', 'order')->first();

        $order                    = new Order();
        $order->user_id           = $user_id;
        $order->product_id        = $product->id;
        $order->store_id          = $product->store_id;
        $order->quantity          = $sendData['items'];
        $order->extra_id          = $sendData['extra_shipping_option'];
        $order->shipping_address  = $sendData['address_text'];
        $order->save();

        NotificationController::create($user_id, null, $notificationType->id, $order->id);
        NotificationController::create($product->store->user_id, null, $notificationType->id, $order->id);

        return $order;
    }

    private function checkUserWalletBalance($userId, $requiredBalance)
    {
        // Retrieve the user's wallet balance from the database
        $userWallet = Wallet::where('user_id', $userId)->first();

        if ($userWallet && $userWallet->balance >= $requiredBalance) {
            // User has sufficient balance
            return true;
        }

        // Insufficient balance
        return false;
    }

    private function addToCart($request, $product)
    {
        // Check if the product is already in the cart for the current user
        $existingCartItem = Cart::where('user_id', auth()->user()->id)
            ->where('product_id', $product->id)
            ->first();
        $sendData = $request->validate([
            'items'                 => 'required|integer|min:1|max:100000',
            'extra_shipping_option' => 'required|integer|min:1',
        ]);

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $existingCartItem->quantity +=  $sendData['items'];
            $existingCartItem->extra_option_id =  $sendData['extra_shipping_option'];
            $existingCartItem->save();

            return redirect('/cart')->with('success', 'Product quantity updated in cart');
        } else {
            // If the product is not in the cart, create a new cart item
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->quantity = $sendData['items'];
            $cart->extra_option_id = $sendData['extra_shipping_option'];
            $cart->save();

            return redirect('/cart')->with('success', 'New product added to cart');
        }
        return redirect()->back();
    }
    
    public function reviews($created_at, Product $product)
    {
        if ($created_at == strtotime($product->created_at)) {
            return view('User.productReviews', [
                'name' => $product->product_name,
                'user' => auth()->user(),
                'action' => Null,
                'product' => $product,
                'icon'  => GeneralController::encodeImages(),
            ]);
        }

        return abort(403);
    }
}
