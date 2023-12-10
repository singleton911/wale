<?php

namespace App\Http\Controllers;

use App\Models\ShareAccess;
use App\Http\Requests\StoreShareAccessRequest;
use App\Http\Requests\UpdateShareAccessRequest;
use Illuminate\Http\Request;

class ShareAccessController extends Controller
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
    public function create(Request $request)
    {
        if ($request->has('new_share_access')) {
            return redirect()->back()->with('new_share_access', true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShareAccessRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShareAccess $shareAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShareAccess $shareAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShareAccessRequest $request, ShareAccess $shareAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShareAccess $shareAccess)
    {
        //
    }
}
