<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\BlockStore;
use App\Models\Category;
use App\Models\FavoriteStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($store, $action = NULL)
    {
        // $storeInfo = Store::find(1);

        // return View('Store.index', [
        //     'store' => $storeInfo,
        //     'action' => $action,
        //     'icon'  => GeneralController::encodeImages(),
        //     'categories' => Category::all(),
        // ]); 
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
    public function store(StoreStoreRequest $request)
    {
        // return redirect()->back()->with('next-listing-pert', true)->with('parent_category_id', $request->parent_category_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($name = null, Store $store)
    {
        return View('User.store', [
            'store' => $store,
            'name' => $name . ' Store',
            'user' => auth()->user(),
            'action' => Null,
            'icon'  => GeneralController::encodeImages(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        return dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
    }

    public function pgp($name, Store $store)
    {
        if ($name == $store->store_name) {
            return redirect()->back()->with('showpgp', true);
        }

        return abort(403);
    }

    public function reviews($name, Store $store)
    {
        if ($name == $store->store_name) {
            return view('User.storeReviews', [
                'name' => $name . ' Store',
                'user' => auth()->user(),
                'action' => Null,
                'store' => $store,
                'icon'  => GeneralController::encodeImages(),
            ]);
        }

        return abort(403);
    }

    public function checkAction(Request $request, $name, Store $store)
    {
        $user_id  = auth()->user()->id;

        if ($name === $store->store_name) {
            if ($request->has('favorite_store')) {
                $favoriteStore  = new FavoriteStore();
                $favoriteStore->user_id = $user_id;
                $favoriteStore->store_id = $store->id;
                $favoriteStore->save();
                return redirect('/favorite/f_store')->with('success', 'You have add a store to your favorite stores!');;
            } elseif ($request->has('block_store')) {
                $blockStore  = new BlockStore();
                $blockStore->user_id = $user_id;
                $blockStore->store_id = $store->id;
                $blockStore->save();
                return redirect('/blocked/b_store')->with('success', 'You have add a store to your blocked stores!');
            }

            return redirect()->back();
        }

        return abort(404);
    }
}
