@extends('layouts.admin')
@push('styles')
@endpush
@section('content')
    <section class="">
        <div class="d-flex justify-content-between justify-content-md-end gap-2 pb-2">
            <form action="" class="">
                <input type="search" name="search" id="search" class="form-control" placeholder="Search...">
            </form>
            <div class="dropdown">
                <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-light" type="button">
                    <i class="bi bi-add"></i>
                    Export
                </button>
            </div>
        </div>
        <!-- Data Order -->
        <div class="table-wrapper overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Entity Name</th>
                        <th scope="col">Entity Type</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->entity_name }}</td>
                            <td>{{ $order->entity_type }}</td>
                            <td>{{ $order->type }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                {{-- <form action="{{ route('orders.cancel', ['orderId' => $order->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn text-decoration-underline text-primary">
                                        Detail
                                    </button>
                                </form> --}}

                                <a href="{{ route('orders.show', ['orderId' => $order->id]) }}">Detail</a>

                                {{-- <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-light">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
