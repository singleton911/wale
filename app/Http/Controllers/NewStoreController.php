<?php

namespace App\Http\Controllers;

use App\Models\NewStore;
use App\Http\Requests\StoreNewStoreRequest;
use App\Http\Requests\UpdateNewStoreRequest;
use App\Models\Category;

class NewStoreController extends Controller
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
        return view('User.open-store', [
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
    public function store(StoreNewStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NewStore $newStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewStore $newStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewStoreRequest $request, NewStore $newStore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewStore $newStore)
    {
        //
    }
}
