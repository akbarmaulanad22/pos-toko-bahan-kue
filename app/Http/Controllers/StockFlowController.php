<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockFlowRequest;
use App\Models\Product;
use App\Models\StockFlow;

class StockFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.stockflows.index',  [
            'title' => 'StockFlows',
            'stockflows' => StockFlow::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.stockflows.create', [
            'title' => 'Create StockFlow',
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StockFlowRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockFlowRequest $request)
    {
        StockFlow::create($request->all());
        return redirect()->route('stockflow.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockFlow  $stockflow
     * @return \Illuminate\Http\Response
     */
    public function show(StockFlow $stockflow)
    {
        return view('pages.admin.stockflows.show', [
            'title' => 'Detail StockFlow',
            'stockflow' => $stockflow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockFlow  $stockflow
     * @return \Illuminate\Http\Response
     */
    public function edit(StockFlow $stockflow)
    {
        return view('pages.admin.stockflows.edit', [
            'title' => 'Edit StockFlow',
            'stockflow' => $stockflow,
            'products' => Product::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StockFlowRequest  $request
     * @param  \App\Models\StockFlow  $stockflow
     * @return \Illuminate\Http\Response
     */
    public function update(StockFlowRequest $request, StockFlow $stockflow)
    {
        $stockflow->update($request->all());
        return redirect()->route('stockflow.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockFlow  $stockflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockFlow $stockflow)
    {
        
        $stockflow->delete();
        return redirect()->route('stockflow.index');

    }
}
