@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <main class="form-product">
                    <form>
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top"
                                id="size" name="size" placeholder="size" value="{{ $sizes->size }}" disabled readonly>
                            <label for="size">Ukuran Barang</label>
                            
                        </div>
                        <div class="form-floating">
                            <input type="text"
                                class="form-control"
                                id="price" name="price" placeholder="price" value="{{ $sizes->price }}" disabled readonly>
                            <label for="price">Stock Eceran</label>
                            
                        </div>
                        <div class="form-floating">
                            <input type="text"
                                class="form-control rounded-bottom"
                                id="stock" name="stock" placeholder="stock" value="{{ $sizes->stock }}" disabled readonly>
                            <label for="stock">Stock Grosir</label>
                        </div>
                      
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('sizes.index', ['product' => $product]) }}" class="col-6 col-sm-2 text-decoration-none my-3 text-end">Kembali</a>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
