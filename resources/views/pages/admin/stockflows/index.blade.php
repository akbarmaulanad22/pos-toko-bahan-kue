@extends('layouts.admin')
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
                <a href="{{ route('stockflow.create') }}" class="btn btn-light">
                    <i class="bi bi-add"></i>
                    Create
                </a>
            </div>
        </div>
        <!-- Data Product -->
        <div class="table-wrapper overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Description</th>
                        <th scope="col">Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stockflows as $stockflow)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $stockflow->product->name }}</td>
                            <td>{{ $stockflow->description }}</td>
                            <td>{{ $stockflow->type }}</td>
                            <td>{{ $stockflow->quantity }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-3 px-4">
                                    <a href="{{ route('stockflow.show', ['stockflow' => $stockflow]) }}"
                                        class="text-decoration-none">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('stockflow.edit', ['stockflow' => $stockflow]) }}"
                                        class="text-decoration-none">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('stockflow.destroy', ['stockflow' => $stockflow]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-decoration-none border-0 bg-transparent text-primary p-0 m-0">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td scope="row" colspan="6" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
