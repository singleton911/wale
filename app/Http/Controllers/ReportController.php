<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
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
    public function create($name = NULL, $id = null)
    {
        $user = auth()->user();
        if (is_numeric($name)) {
            if (strtotime(Product::where('id', $id)->first()->created_at) == $name) {
                $product = Product::where('id', $id)->first();
                return view('User.report', [
                    'user' => $user,
                    'icon'   => GeneralController::encodeImages(),
                    'action' => NULL,
                    'name'  => $name,
                    'product' => $product,
                    'is_listing' => 1,
                    'is_store' => 0,
                ]);
           }
          
        }elseif (is_string($name)) {
            if (Store::where('id', $id)->first()->store_name == $name) {
                $store = Store::where('id', $id)->first();
                return view('User.report', [
                    'user' => $user,
                    'icon'   => GeneralController::encodeImages(),
                    'action' => NULL,
                    'name'  => $name,
                    'store' => $store,
                    'is_store' => 1,
                    'is_listing' => 0,
                ]);
           }
        }

        return $id;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function storeUser(Request $request, $name, Store $store)
    {
        $data  = $request->validate([
            'subject' => 'required|string|min:3|max:100',
            'report' => 'required|string|min:10|max:5000',
        ]);
        if ($name ===  $store->store_name) {
            $report = new Report();
            $report->user_id  = auth()->user()->id;
            $report->reported_id = $store->id;
            $report->subject    =  $data['subject'];
            $report->report     = $data['report'];
            $report->is_store    = true;
            $report->save();
            return redirect()->back()->with('success', 'You have successfully reported this store. Please with for admin or mods to review your report. we will message.');
        }
    }

    public function listing(Request $request, $created_at, Product $product)
    {
        $data  = $request->validate([
            'subject' => 'required|string|min:3|max:100',
            'report' => 'required|string|min:10|max:5000',
        ]);
        if ($created_at == strtotime($product->created_at)) {
            $report = new Report();
            $report->user_id  = auth()->user()->id;
            $report->reported_id = $product->id;
            $report->subject    =  $data['subject'];
            $report->report     = $data['report'];
            $report->save();
            return redirect()->back()->with('success', 'You have successfully reported this listing. Please with for admin or mods to review your report, we will message.');
        }
    }
}
