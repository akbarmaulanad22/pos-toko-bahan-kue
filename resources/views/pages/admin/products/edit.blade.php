@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <main class="form-product">
                    <form method="POST" action="{{ route('products.update', ['product' => $product]) }}"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Name" value="{{ old('name', $product->name) }}">
                            <label for="name">Nama Barang</label>
                            @error('name')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="">
                            <select class="form-select rounded-0 @error('category_id') is-invalid @enderror" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($product->image)
                            <img id="imagePreview" class="img-fluid" src="{{ asset('storage/' . $product->image) }}">
                        @else
                            <img id="imagePreview" class="img-fluid" style="display: none">
                        @endif
                        <div class="input-group mb-3">
                            <input class="form-control rounded-0 rounded-bottom @error('image') is-invalid @enderror"
                                id="floatingInput2" type="file" name="image" id="imageInput"
                                onchange="imageInputHandler(this)">
                            @error('image')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="valid-feedback mb-2 d-block">
                                    <span class="d-block">*opsional gambar produk</span>
                                    <span class="d-block">*ukuran 400x400</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('products.index') }}"
                                class="col-6 col-sm-2 text-decoration-none my-3 text-center">Kembali</a>
                            <button class="col-6 col-sm-2 btn btn-primary my-3" type="submit">Simpan</button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
