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
                <a href="{{ route('staffs.create') }}" class="btn btn-light">
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staffs as $staff)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ optional($staff->role)->name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-3 px-4">
                                    <a href="{{ route('staffs.show', ['staff' => $staff]) }}" class="text-decoration-none">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('staffs.edit', ['staff' => $staff]) }}" class="text-decoration-none">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('staffs.destroy', ['staff' => $staff]) }}" method="POST">
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
                            <td scope="row" colspan="5" class="text-center">No Staff Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
