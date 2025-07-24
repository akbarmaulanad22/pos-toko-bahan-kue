<?php

namespace App\Http\Controllers;

use App\Services\LogOrderService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected LogOrderService $logOrderService;
    protected OrderService $orderService;

    public function __construct(LogOrderService $logOrderService, OrderService $orderService)
    {
        $this->logOrderService = $logOrderService;
        $this->orderService = $orderService;

    }
    
    public function index()
    {
        $orders = DB::table('orders')->get();

        return view('pages.admin.orders.index', [
            'title' => 'Orders',
            'orders' => $orders,
        ]);
    }

    public function show(int $orderId)
    {
        $order = DB::table('orders')
                    ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                    ->where('id', $orderId)
                    ->select('id', 'entity_name', 'entity_type', 'type', 'status',  'orders.pay_at', 'orders.created_at', DB::raw('SUM(order_details.quantity * order_details.price) as total_price'))->groupBy('orders.id')
                    ->first();

        if (!$order) {
            abort(404);
        }

        $orderDetails = DB::table('order_details')
                        ->join('product_sizes', 'product_sizes.id', '=', 'order_details.product_size_id')
                        ->join('products', 'products.id', '=', 'product_sizes.product_id')
                        ->where('order_id', $orderId)
                        ->select('products.name as product_name', 'product_sizes.size', 'order_details.*', DB::raw('order_details.quantity * order_details.price as total_price'))
                        ->get();

        return view('pages.admin.orders.show', [
            'title' => 'Order Details',
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    public function store(Request $request)
    {
        try {
            
            $validatedRequest = $this->orderService->validateOrder($request);

            if ($request->entity_type == 'Customer') {
                $this->orderService->validateStockOut($validatedRequest);
                $this->orderService->decreaseStock($validatedRequest);
            } else {
                $this->orderService->increaseStock($validatedRequest);
            }

            $order = $this->orderService->createOrder($validatedRequest);
            $this->logOrderService->insert($validatedRequest, 'insert', $order['order_id']);
            
            return response()->json(
                [
                    'message' => 'Order Created',
                    'data' => $request->all(),
                ],
                201,
            );
        } catch (\Exception $exception) {
            if ($exception->getCode() == 422) {
                return response()->json(
                    [
                        'message' => $exception->getMessage(),
                        'data' => $request->all(),
                    ],
                    422,
                );
            }

            return response()->json(
                [
                    'message' => $exception->getMessage(),
                    'data' => $request->all(),
                ],
                500,
            );
        }
    }

    public function cancel(int $orderId)
    {
        try {
            DB::transaction(function () use ($orderId) {
                $order = DB::table('orders')->where('id', $orderId)->first();
                
                // Ambil semua `product_size_id` dan `quantity` dari `order_details`
                $orderDetails = DB::table('order_details')
                    ->where('order_id', $orderId)
                    ->where('is_cancelled', false)
                    ->get(['product_size_id', 'quantity']);

                
                $caseQuery = '';
                if ($order->entity_type == 'Customer') {
                    // Update stok produk secara massal
                    $caseQuery = $this->orderService->incrementStock($orderDetails);
                } else {
                    // Update stok produk secara massal
                    $caseQuery = $this->orderService->decrementStock($orderDetails);
                }

                DB::table('product_sizes')
                    ->whereIn('id', $orderDetails->pluck('product_size_id'))
                    ->update(['stock' => DB::raw($caseQuery)]);

                // Tandai semua order detail sebagai dibatalkan
                DB::table('order_details')
                    ->where('order_id', $orderId)
                    ->update(['is_cancelled' => true]);

                // Tandai order sebagai dibatalkan
                DB::table('orders')
                    ->where('id', $orderId)
                    ->update(['status' => 'Cancelled']);

                // get order data for log
                $order = DB::table('orders')->where('id', $orderId)->first();
                $this->logOrderService->insert((array) $order, 'delete', $orderId);
            });

            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function pay(int $orderId)
    {
        try {
            DB::transaction(function () use ($orderId) {
                $order = DB::table('orders')->where('id', $orderId)->first();

                if ($order->status != 'Pending' ) {
                    return response()->json(
                    [
                        'message' => "Order not available for pay",
                        'data' => null,
                    ],
                    400,
                );
                }
                
                $order->update([
                    'status' => 'Completed',
                    'pay_at' => now()
                ]);

                $this->logOrderService->insert((array) $order, 'update', $orderId);
            });

            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function cancelPerItem(int $orderId, int $sizeId)
    {
        try {
            DB::transaction(function () use ($orderId, $sizeId) {
                $order = DB::table('orders')->where('id', $orderId)->first();

                // Ambil semua `product_size_id` dan `quantity` dari `order_details`
                $orderDetails = DB::table('order_details')
                    ->where('order_id', $orderId)
                    ->where('product_size_id', $sizeId)
                    ->where('is_cancelled', false)
                    ->get(['product_size_id', 'quantity']);

                
                $caseQuery = '';
                if ($order->entity_type == 'Customer') {
                    // Update stok produk secara massal
                    $caseQuery = $this->orderService->incrementStock($orderDetails);
                } else {
                    // Update stok produk secara massal
                    $caseQuery = $this->orderService->decrementStock($orderDetails);
                }

                DB::table('product_sizes')
                    ->whereIn('id', $orderDetails->pluck('product_size_id'))
                    ->update(['stock' => DB::raw($caseQuery)]);

                // Tandai order detail sebagai dibatalkan
                DB::table('order_details')
                    ->where('order_id', $orderId)
                    ->update(['is_cancelled' => true]);
            });

            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
