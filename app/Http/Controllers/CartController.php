<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Category;
use App\Models\Promocode;
use App\Models\UserPromos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
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
        $user = auth()->user();
        return view('User.cart', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->quantity = $request->quantity;
        $cart->note    = $request->note;

        if ($cart->save()) {
            return redirect()->back()->with('success', 'Successfully updated your cart.');
        }

        return redirect()->back();
    }

    public function checkAction(UpdateCartRequest $req, Cart $cart){
        if ($req->update === '✔️') {
           return $this->update($req, $cart);
        }elseif ($req->remove === '❌') {
            return $this->destroy($cart);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Delete the Cart instance
        $cart->id;
        $cart->delete();
        return redirect()->back()->with('delete', 'Cart successfully deleted.');
    }


    public function checkPromoInCart(Request $request)
    {
        $user = auth()->user();
        $promos = Promocode::all();
        $userEnteredPromo = $request->promocode; // Assuming 'promocode' is the name of the input field.
    
        if ($request->action !== 'Apply Now') {
           return abort(403);
        }
    
        if ($user->carts->isEmpty()) {
            return Redirect::back()->with('emptycart', 'Insert products into your cart to apply promo code!!');
        }
    
        foreach ($promos as $promo) {
            // Check if there is a match between the user's cart and the promo product
            $matchingCart = $user->carts->where('product_id', $promo->product_id)->first();
    
            if ($matchingCart && $userEnteredPromo == $promo->code) {
                // Check if the user has used this promo code
                if (!$user->usedPromocodes->where('promocode_id', $promo->id)->isEmpty()) {
                    return Redirect::back()->with('alreadyused', 'You have already used this promo code.');
                }
    
                // Record that the user has used this promo code
                $newUsePromo = new UserPromos();
                $newUsePromo->user_id = $user->id;
                $newUsePromo->promocode_id = $promo->id;
                $newUsePromo->cart_id  = $matchingCart->id;
                $newUsePromo->discount = $promo->discount;
                $newUsePromo->save();
    
                return Redirect::back()->with('validPromo', 'You have successfully applied a promo code.');
            }
        }
    
        return Redirect::back()->with('invalidPromo', 'Invalid promo code or no matching product in your cart.');
    }
}
