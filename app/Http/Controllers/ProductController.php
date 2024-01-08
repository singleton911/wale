<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\BlockStore;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Escrow;
use App\Models\ExtraOption;
use App\Models\FavoriteListing;
use App\Models\FavoriteStore;
use App\Models\NotificationType;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Review;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
    public function create($store, $action)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }
        if ($action == 'physical') {
            return $this->createPhysicalListing();
        } elseif ($action == 'digital') {
            return $this->createDigitalListing();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        $store = auth()->user()->store;

        if ($request->next == 'Next') {
            $this->saveProduct($request);
        } elseif ($request->extra_set == 'Save') {
            $this->saveExtraOptions($request);
        } elseif ($request->skip == 'Skip') {
            return redirect()->back()->with('success', 'Product created successfully and it has no extra shipping or options, it now pending waiting to be approved by mods or admin.');
        }

        // Redirect to the appropriate route or view
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($created_at, Product $product)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/pgp/verify');
        }
        // Assuming $created_at is a timestamp
        $timestamp = strtotime($product->created_at);

        if ($timestamp !== false && $timestamp == $created_at) {
            return view('User.productPreview', [
                'product' => $product,
                'user' => auth()->user(),
                'parentCategories' => Category::where('parent_category_id', NULL)->get(),
                'subCategories' => Category::where('parent_category_id', '!=', NULL)->get(),
                'icon'   => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($store, $created_at, Product $product)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        return view('Store.index', [
            'product' => $product,
            'store' => auth()->user()->store,
            'storeUser' => auth()->user(),
            'action' => "edit-product",
            'icon'  => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $store, $created_at, Product $product)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        if ($store == $product->store->store_name && $created_at == strtotime($product->created_at)) {

            if ($request->save_next == 'Save and Next') {
                return $this->updateProduct($request, $product->id);
            } elseif ($request->skip_next == 'Skip and Next') {
                return redirect()->back()->with('next-form', true)->with('product_id', Crypt::encrypt($product->id));
            } elseif ($request->has('extra_set')) {
                return $this->updateExtraOptions($request, $product);
            } elseif ($request->skip == 'Skip') {
                // return $this->saveExtraOptions($request);
                return redirect()->back()->with('success', 'Product created successfully and it has no extra shipping or options, it now pending waiting to be approved by mods or admin.');
            } elseif ($request->skip == 'Skip') {
                return redirect()->back()->with('success', 'Product created successfully and it has no extra shipping or options, it now pending waiting to be approved by mods or admin.');
            }
        } else {
            return "Stop modifying the URL, the admin knows!!!";
        }
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
        $user = auth()->user();
        $extra = $request->extra_shipping_option  != null ? ExtraOption::findOrFail($request->extra_shipping_option)['cost'] : NULL;
        $listingFavorited = $user->favoriteListings->where('product_id', $product->id)->first();
        $storeFavorited   = $user->favoriteStores->where('store_id', $product->store_id)->first();
        $blockedStore     = $user->blockedStores->where('store_id', $product->store_id)->first();

        if (strtotime($product->created_at) == $created_at) {
            // .. (add this product to cart)
            if ($request->has('add_to_cart')) {
                return $this->addToCart($request, $product);
            } elseif ($request->has('buy_now') || $request->has('complete_order')) {
                $balanceCheck = $user->wallet->balance >= ($product->price + $extra);

                if ($request->has('buy_now')) {
                    $redirectData = $balanceCheck ? ['enter_adderss' => true, 'extra_shipping_option' => $request->extra_shipping_option, 'items' => $request->items] : ['error' => 'Insufficient funds! Please add more funds to order this product. ^.^'];
                } elseif ($request->has('complete_order') && $request->has('store_pgp')) {
                    if ($balanceCheck) {

                        $this->initiateOrder($request, $product);
                        $redirectData = ['success' => 'Order created successfully. Check your order status in settings or notifications!'];
                    } else {
                        $redirectData = ['error' => 'Insufficient funds! Please add more funds to order this product. ^.^'];
                    }
                } else {
                    $redirectData = ['error' => 'stop motifying the form, auto check system has notifiy the admin!'];
                }
                return redirect()->back()->with($redirectData);
            } elseif ($request->has('favorite_listing') && $listingFavorited == null) {
                FavoriteListing::create(['user_id' => $user->id, 'product_id' => $product->id]);
            } elseif ($request->has('favorite_store') && $storeFavorited == null) {
                FavoriteStore::create(['user_id' => $user->id, 'store_id' => $product->store->id]);
            } elseif ($request->has('block_store') && $blockedStore == null) {
                BlockStore::create(['user_id' => $user->id, 'store_id' => $product->store->id]);
            }

            return redirect()->back();
        }

        return abort(404);
    }


    private function initiateOrder(Request $request, Product $product)
    {
        // Your existing logic for initiating an order
        $user = auth()->user();

        $sendData = $request->validate([
            'items' => 'required|integer|min:1|max:100000',
            'extra_shipping_option' => 'sometimes|nullable|integer',
            'address_text' => 'sometimes|nullable|string',
        ]);

        $notificationType = NotificationType::where('action', 'created')->where('icon', 'order')->first();
        $extra = $sendData['extra_shipping_option'] != null ? $sendData['extra_shipping_option'] : null;

        $order                    = new Order();
        $order->user_id           = $user->id;
        $order->product_id        = $product->id;
        $order->store_id          = $product->store_id;
        $order->quantity          = $sendData['items'];
        $order->extra_id          = $extra;
        $order->shipping_address  = $request->has('encrypt_for_me') ? GeneralController::encryptPGPNotes($sendData['address_text'], $product->store->user->pgp_key) : $sendData['address_text'];
        $order->save();

        if ($extra != null) {
            $extra_cost = ExtraOption::where('id', $extra)->first();
            $amount = $product->price + $extra_cost->cost;
        } else {
            $amount = $product->price;
        }

        // deduct the amount from the user balance and add it to escrow...
        $user->wallet->balance -= $amount;
        $user->wallet->save();

        if ($product->payment_type == 'FE' && $product->store->is_fe_enable === 1) {
            $product->store->user->wallet->balance += $amount;
            $product->store->user->wallet->save();
        } else {
            // add funds to escrow
            $this->makeEscrow($order->id, $amount);
        }

        NotificationController::create($user->id, null, $notificationType->id, $order->id);
        NotificationController::create($product->store->user_id, null, $notificationType->id, $order->id);

        return $order;
    }

    // add the order to escrow
    private function makeEscrow($order, $amount)
    {
        $new_eascrow = new Escrow();
        $new_eascrow->order_id = $order;
        $new_eascrow->fiat_amount   = $amount;
        $new_eascrow->save();
    }


    // Add to cart
    private function addToCart($request, $product)
    {
        // Check if the product is already in the cart for the current user
        $user = auth()->user();
        $existingCartItem = $user->carts->where('product_id', $product->id)->first();

        $sendData = $request->validate([
            'items'                 => 'required|integer|min:1|max:100000',
            'extra_shipping_option' => 'sometimes|nullable|integer',
        ]);

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $existingCartItem->quantity +=  $sendData['items'];
            $existingCartItem->extra_option_id =  $sendData['extra_shipping_option'] ?? NULL;
            $existingCartItem->save();

            return redirect('/cart')->with('success', 'Product quantity updated in cart');
        } else {
            // If the product is not in the cart, create a new cart item
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $product->id;
            $cart->quantity = $sendData['items'];
            $cart->extra_option_id = $sendData['extra_shipping_option'] ?? null;
            $cart->save();

            return redirect('/cart')->with('success', 'New product added to cart');
        }
        return redirect()->back();
    }

    public function reviews($created_at, Product $product)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/pgp/verify');
        }

        if ($created_at == strtotime($product->created_at)) {
            return view('User.productReviews', [
                'name' => $product->product_name,
                'user' => auth()->user(),
                'action' => Null,
                'product' => $product,
                'icon'  => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }

        return abort(403);
    }


    private function createPhysicalListing()
    {
        return view('Store.index', [
            'store' => auth()->user()->store,
            'storeUser' => auth()->user(),
            'action' => "physical",
            'icon'  => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'categories' => Category::all(),
        ]);
    }

    private function createDigitalListing()
    {
        return view('Store.index', [
            'store' => auth()->user()->store,
            'storeUser' => auth()->user(),
            'action' => "digital",
            'icon'  => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'categories' => Category::all(),
        ]);
    }


    private function saveProduct($request)
    {
        // Validate the request data
        $request->validate([
            'store_id'              => 'required|integer',
            'product_name'          => 'required|string|min:3|max:80',
            'product_description'   => 'required|string|max:2500',
            'price'                 => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'quantity'              => 'required|integer|min:1',
            'ship_from'             => 'string|max:50',
            'payment_type'          => 'required|string|min:2|max:7',
            'product_type'          => 'required|string|in:digital,physical',
            'ship_to'               => 'string|max:50',
            'parent_category_id'    => 'required|integer',
            'sub_category_id'       => 'required|integer',
            'return_policy'         => 'sometimes|nullable|min:3|max:500',
            'auto_delivery_content' => 'sometimes|nullable|string|max:500',
            'image_path1'           => 'required|image|mimes:jpeg,png,jpg|max:2000|distinct',
            'image_path2'           => 'sometimes|image|mimes:jpeg,png,jpg|max:2000|distinct',
            'image_path3'           => 'sometimes|image|mimes:jpeg,png,jpg|max:2000|distinct',
        ]);

        //Save the images to public/storage/Product_Images with unique, encrypted names
        $imagePaths = [];
        foreach (['image_path1', 'image_path2', 'image_path3'] as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);

                // Call the function to process and store the image
                $imagePath = GeneralController::processAndStoreImage($file, 'Product_Images');

                $imagePaths[$key] = $imagePath;
            }
        }

        $product = new Product();
        $product->store_id              = auth()->user()->store->id;
        $product->product_name          = $request->product_name;
        $product->product_description   = $request->product_description;
        $product->price                 = $request->price;
        $product->quantity              = $request->quantity;
        $product->ship_from             = $request->ship_from;
        $product->payment_type          = $request->payment_type;
        $product->product_type          = $request->product_type;
        $product->ship_to               = $request->ship_to;
        $product->parent_category_id    = $request->parent_category_id;
        $product->sub_category_id       = $request->sub_category_id;
        $product->return_policy         = $request->return_policy ?? null;
        $product->auto_delivery_content = $request->auto_delivery_content ?? null;
        $product->image_path1           = $imagePaths['image_path1'];
        $product->image_path2           = $imagePaths['image_path2'] ?? null;
        $product->image_path3           = $imagePaths['image_path3'] ?? null;
        $product->save();
        return redirect()->back()->with('success', 'Product created successfully')->with('next-form', true)->with('product_id', Crypt::encrypt($product->id));
    }

    private function saveExtraOptions($request)
    {
        $store = auth()->user()->store;
        $product_id = $request->product_id != null ? Crypt::decrypt($request->product_id) : null;

        // Validate the request data for each shipping method
        for ($i = 1; $i <= 10; $i++) {
            $request->validate([
                "shipping_method{$i}" => 'sometimes|nullable|string|max:255',
                "shipping_cost{$i}" => 'sometimes|nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            // Check if the shipping method key exists in the request
            $shipping_method_key = "shipping_method{$i}";
            // Break out of the loop if the shipping method is null or an empty string
            if ($request->$shipping_method_key === null || $request->$shipping_method_key === '') {
                break;
            }


            // Create and save ExtraOption model instance
            try {
                $extra = new ExtraOption();
                $extra->product_id = $product_id;
                $extra->name = $request->$shipping_method_key;
                $extra->cost = $request->has("shipping_cost{$i}") ? $request->{"shipping_cost{$i}"} : "0.00";
                $extra->save();
            } catch (\Exception $e) {
                // Handle the exception, log it, or redirect with an error message
                return redirect()->back()->with('error', 'An error occurred while saving extra options.');
            }
        }

        return redirect()->back()->with('success', 'Product created successfully with extra shipping options. It is now pending approval by mods or admin.');
    }

    private function updateExtraOptions($request, $product)
    {
        // return dd($request);

        $store = auth()->user()->store;

        // check if there is already an old extra options
        $extraOption_counts = $product->extraShipping->count();

        // Validate the request data for each shipping method
        for ($i = 0; $i < 10; $i++) {
            if ($i < $extraOption_counts) {
                $extraOption = $product->extraShipping[$i];
                $request->validate([
                    "shipping_old_method{$extraOption->id}" => 'sometimes|nullable|string|max:255',
                    "shipping_old_cost{$extraOption->id}" => 'sometimes|nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                ]);

                $extra = ExtraOption::find($extraOption->id);
                $extra->name = $request->shipping_old_method . $extraOption->id;
                $extra->cost = $request->shipping_old_cost . $extraOption->id;
                $extra->save();
            }

            // $request->validate([
            //     "shipping_new_method{$i}" => 'sometimes|nullable|string|max:255',
            //     "shipping_new_cost{$i}" => 'sometimes|nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            // ]);



            // // Check if the shipping method key exists in the request
            // $shipping_method_key = "shipping_new_method{$i}";
            // // Break out of the loop if the shipping method is null or an empty string
            // if ($request->$shipping_method_key === null || $request->$shipping_method_key === '') {
            //     break;
            // }


            // // Create and save ExtraOption model instance
            // try {
            //     $extra = new ExtraOption();
            //     $extra->product_id = $product->id;
            //     $extra->name = $request->$shipping_method_key;
            //     $extra->cost = $request->has("shipping_cost{$i}") ? $request->{"shipping_cost{$i}"} : "0.00";
            //     $extra->save();
            // } catch (\Exception $e) {
            //     // Handle the exception, log it, or redirect with an error message
            //     return redirect()->back()->with('error', 'An error occurred while saving extra options.');
            // }
        }

        return redirect()->back()->with('success', 'Product created successfully with extra shipping options. It is now pending approval by mods or admin.');
    }

    private function updateProduct($request, $product_id)
    {
        // Validate the request data
        $request->validate([
            'product_description'   => 'required|string|max:2500',
            'price'                 => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'quantity'              => 'required|integer|min:1',
            'ship_from'             => 'string|max:50',
            'product_type'          => 'required|string|in:digital,physical',
            'ship_to'               => 'string|max:50',
            'return_policy'         => 'sometimes|nullable|min:3|max:500',
            'auto_delivery_content' => 'sometimes|nullable|string|max:500',
            'image_path2'           => 'sometimes|image|mimes:jpeg,png,jpg|max:2000|distinct',
            'image_path3'           => 'sometimes|image|mimes:jpeg,png,jpg|max:2000|distinct',
        ]);

        //Save the images to public/storage/Product_Images with unique, encrypted names
        $imagePaths = [];
        $allowedKeys = ['image_path2', 'image_path3'];

        foreach ($allowedKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);

                // Call the function to process and store the image
                $imagePath = GeneralController::processAndStoreImage($file, 'Product_Images');

                // Use the original key in the $imagePaths array
                $imagePaths[$key] = $imagePath;
            }
        }

        $product = Product::find($product_id);

        $product->product_description   = $request->product_description;
        $product->price                 = $request->price;
        $product->quantity              = $request->quantity;
        $product->ship_from             = $request->ship_from;
        $product->product_type          = $request->product_type;
        $product->ship_to               = $request->ship_to;
        $product->return_policy         = $request->return_policy ?? null;
        $product->auto_delivery_content = $request->auto_delivery_content ?? null;

        // Check if keys exist in the $imagePaths array before accessing them
        $product->image_path2 = $imagePaths['image_path2'] ?? $product->image_path2;
        $product->image_path3 = $imagePaths['image_path3'] ?? $product->image_path3;

        $product->save();


        return redirect()->back()->with('success', 'Product update successfully')->with('next-form', true)->with('product_id', Crypt::encrypt($product->id));
    }

    public function singleView($store, $created_at, Product $product)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        $timestamp = strtotime($product->created_at);

        if ($timestamp !== false && $timestamp == $created_at) {
            return view('Store.index', [
                'product' => $product,
                'store' => auth()->user()->store,
                'storeUser' => auth()->user(),
                'action' => 'view',
                'parentCategories' => Category::where('parent_category_id', NULL)->get(),
                'subCategories' => Category::where('parent_category_id', '!=', NULL)->get(),
                'icon'   => GeneralController::encodeImages(),
                'product_image' => GeneralController::encodeImages('Product_Images'),
                'upload_image' => GeneralController::encodeImages('Upload_Images'),
            ]);
        }
    }

    public function productStatus(Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }
        $product_id = $request->product_id ?? null;

        // Decrypt product_id if it is not null
        if ($product_id !== null) {
            $product_id = Crypt::decrypt($product_id);
        }

        // Check if product_id is still not null after decryption
        if ($product_id !== null) {
            $product = Product::find($product_id);

            // Check if the product status is not 'pending'
            if ($product && $product->status != 'Pending' && $product->status != 'Rejected') {
                if ($request->statusChange == 'Pause') {
                    $product->status = 'Paused';
                    $product->save();
                } elseif ($request->statusChange == 'UnPause') {
                    $product->status = 'Active';
                    $product->save();
                }
            } elseif ($request->boost == 'Boost') {
                return "Still under developement... sorry :xD";
            } else {
                return redirect()->back()->with('error', 'Product is still pending or rejected or Invalid product ID.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid product ID');
        }

        // Flash success message if no exception is thrown
        return redirect()->back()->with('success', 'Product status updated successfully');
    }
}
