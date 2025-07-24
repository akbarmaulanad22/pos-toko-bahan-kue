@extends('layouts.admin')
@push('styles')
    <style>
        .invoice-header {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .status-badge {
            font-size: 0.8rem;
        }

        .summary {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endpush
@section('content')
    <section class="">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="w-100">
                        <div class="invoice-header d-flex align-items-center justify-content-start gap-2">
                            #{{ $order->id }}
                            <span
                                class="badge {{ $order->status == 'Cancelled' ? 'bg-danger' : ($order->status == 'Pending' ? 'bg-warning' : '') }} status-badge">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="text-muted d-block d-md-flex justify-content-between">
                            <div class="d-block d-md-inline">
                                {{ $order->total_price }} IDR <span class="d-none d-md-inline">&middot;</span>
                                <span class="d-block d-md-inline">
                                    Paid at {{ date('d m Y', strtotime($order->pay_at)) }}
                                </span>
                            </div>
                            @if (Carbon\Carbon::parse($order->created_at)->diffInDays(Carbon\Carbon::now()) < 1)
                                @if ($order->status != 'Cancelled')
                                    <div class="d-block d-md-inline text-right">
                                        <form href="{{ route('orders.cancel', ['orderId' => $order->id]) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn text-danger text-decoration-underline"
                                                style="font-size: 0.8rem">
                                                Cancel All
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                {{-- 
                                <div class="d-block d-md-inline">
                                    <span class="badge bg-warning">Due in
                                        {{ Carbon\Carbon::parse($order->created_at)->diffInDays(Carbon\Carbon::now()) }}
                                        days</span>
                                </div> --}}
                            @endif
                        </div>
                    </div>
                </div>

                {{-- <h5 class="fw-bold">Payment batch January 2023</h5> --}}

                <div class="row mt-4">

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold">Entity Name</p>
                        <p class="mb-0">{{ $order->entity_name }}</p>
                        <p class="mb-1 fw-bold">Entity Type</p>
                        <p class="mb-0">{{ $order->entity_type }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold">Invoice Number</p>
                        <p>{{ $order->id }}</p>
                        <p class="mb-1 fw-bold">Issued</p>
                        <p>
                            {{ $order->created_at }}
                        </p>
                        <p class="mb-1 fw-bold">Due date</p>
                        <p>
                            {{ $order->created_at }}
                        </p>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>SIZE</th>
                                <th>QTY</th>
                                <th>UNIT PRICE</th>
                                <th>AMOUNT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($orderDetails->count() > 1)
                                @foreach ($orderDetails as $orderDetail)
                                    <tr>
                                        <th>
                                            {{ $orderDetail->size }}
                                        </th>
                                        <td>
                                            {{ $orderDetail->quantity }}
                                        </td>
                                        <td>
                                            {{ $orderDetail->price }} IDR
                                        </td>
                                        <td>
                                            {{ $orderDetail->total_price }} IDR
                                        </td>
                                        <td>
                                            @if ($orderDetail->is_cancelled == 0)
                                                <form method="POST"
                                                    action="{{ route('orders.cancelPerItem', ['orderId' => $orderDetail->order_id, 'sizeId' => $orderDetail->product_size_id]) }}">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($orderDetails as $orderDetail)
                                    <tr>
                                        <th>
                                            {{ $orderDetail->product_name }}
                                        </th>
                                        <td>
                                            {{ $orderDetail->size }}
                                        </td>
                                        <td>
                                            {{ $orderDetail->quantity }}
                                        </td>
                                        <td>
                                            {{ $orderDetail->price }} IDR
                                        </td>
                                        <td>
                                            {{ $orderDetail->total_price }} IDR
                                        </td>
                                        <td>
                                            @if ($orderDetail->is_cancelled == 1)
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>{{ $order->total_price }} IDR</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>{{ $order->total_price }} IDR</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-muted summary">Terms & Conditions: Please ensure payment is made by the due date to
                        avoid any late fees. Payment is due on or before the due date.</p>
                </div>
            </div>
        </div>

    </section>
@endsection
