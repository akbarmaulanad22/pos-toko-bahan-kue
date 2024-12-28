@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <main class="form-product">
                    <form
                        action="{{ route('sizes.update', ['product' => $product, 'size' => $sizes]) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top @error('size') is-invalid @enderror"
                                id="size" name="size" placeholder="size" value="{{ old('size', $sizes->size) }}">
                            <label for="size">Ukuran Barang</label>
                            @error('size')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" placeholder="price" value="{{ old('price', $sizes->price) }}">
                            <label for="price">Harga</label>
                            @error('price')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="number" class="form-control rounded-bottom  @error('stock') is-invalid @enderror"
                                id="stock" name="stock" placeholder="stock" value="{{ old('stock', $sizes->stock) }}">
                            <label for="stock">Stock</label>
                            @error('stock')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('sizes.index', ['product' => $product]) }}"
                                class="col-6 col-sm-2 text-decoration-none my-3 text-center">Kembali</a>
                            <button class="col-6 col-sm-2 btn btn-primary my-3" type="submit">Simpan</button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
