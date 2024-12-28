@extends('layouts.admin')

@section('content')
    <div class="btn-toolbar mt-2 mb-4 justify-content-end col-lg-8">
        <div class="btn-group me-2">
            <a href="{{ route('sizes.create', ['product' => $product]) }}" class="btn btn-sm btn-primary ">
                <i class="bi bi-plus-lg "></i> Ukuran
            </a>
        </div>

    </div>


    <div class="table-responsive small col-lg-8">
        @if (session()->has('SUCCESS'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('SUCCESS') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session()->has('FAILED'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('FAILED') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ukuran</th>
                    <th scope="col">Harga</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if (count($sizes) > 0)
                    @foreach ($sizes as $size)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $size->size }}</td>
                            <td>{{ $size->price }}</td>
                            <td class="text-center">
                                <div class="d-none d-sm-block">
                                    <div class="d-flex justify-content-center gap-3 px-4">

                                        <a href="{{ route('sizes.show', ['product' => $product, 'size' => $size]) }}"
                                            class="text-decoration-none">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('sizes.edit', ['product' => $product, 'size' => $size]) }}"
                                            class="text-decoration-none">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form
                                            action="{{ route('sizes.destroy', ['product' => $product, 'size' => $size]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-decoration-none border-0 bg-transparent text-primary p-0 m-0">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="d-block d-sm-none">
                                    <div class="dropdown position-static">

                                        <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu position-absolute" aria-labelledby="dropdownMenuButton1">
                                            <li class="d-flex justify-content-between gap-3 px-4">

                                                <a href="{{ route('sizes.show', ['product' => $product, 'size' => $size]) }}"
                                                    class="text-decoration-none">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('sizes.edit', ['product' => $product, 'size' => $size]) }}"
                                                    class="text-decoration-none">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form
                                                    action="{{ route('sizes.destroy', ['product' => $product, 'size' => $size]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-decoration-none border-0 bg-transparent text-primary p-0 m-0">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td scope="col" colspan="5" class="text-center">Tidak ada ukuran ditemukan</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
@endsection
