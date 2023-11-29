<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Http\Requests\StoreBugRequest;
use App\Http\Requests\UpdateBugRequest;

class BugController extends Controller
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
    public function store(StoreBugRequest $request)
    {
        $newBug = new Bug();
        $newBug->user_id  = auth()->user()->id;
        $newBug->type = $request->type;
        $newBug->content = $request->content;
        $newBug->save();
        if ($newBug->save()) {
            return redirect()->back()->with('success', 'Your report have been successfully sent, please wait for admin or mods to review your report, They will message you if your report is a valid bug. Thank you.');
        }
        return abort(403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bug $bug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bug $bug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBugRequest $request, Bug $bug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bug $bug)
    {
        //
    }
}
