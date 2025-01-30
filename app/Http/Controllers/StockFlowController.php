<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockFlowRequest;
use App\Models\Product;
use App\Models\StockFlow;
use App\Services\LogStockFlowService;
use App\Services\ProductSizeService;
use Exception;
use Illuminate\Http\Request;

class StockFlowController extends Controller
{
    protected LogStockFlowService $logStockFlowService;

    public function __construct(LogStockFlowService $logStockFlowService)
    {
        $this->logStockFlowService = $logStockFlowService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.stockflows.index', [
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
            'products' => Product::all(),
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
        try {
            StockFlow::create($request->all());

            $productSizeService = new ProductSizeService();
            $productSizeService->updateStock(new Request($request->all()));

            $this->logStockFlowService->insert(new Request($request->all()), 'insert');

            return redirect()->route('stockflow.index');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->route('stockflow.index');
        }
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
            'stockflow' => $stockflow,
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
            'products' => Product::all(),
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
        try {
            $productSizeService = new ProductSizeService();
            $productSizeService->updateStock(new Request($request->all()), $stockflow);

            $stockflow->update($request->all());

            $this->logStockFlowService->insert(new Request($request->all()), 'update');

            return redirect()->route('stockflow.index');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->route('stockflow.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockFlow  $stockflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockFlow $stockflow)
    {
        try {
            $productSizeService = new ProductSizeService();
            $productSizeService->cancelUpdateStock($stockflow);

            // set product name for logging
            $stockflow->product_name = $stockflow->product->name;

            $stockflow->delete();

            $this->logStockFlowService->insert(new Request($stockflow->toArray()), 'insert');

            return redirect()->route('stockflow.index');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->route('stockflow.index');
        }
    }

    public function getSizesProduct(Request $request)
    {
        $producstSizeService = new ProductSizeService();
        return response()->json($producstSizeService->getSizes($request->id));
    }
}
