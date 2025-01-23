@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-label="name input" readonly
                    value="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" aria-label="sku input" readonly
                    value="{{ $product->sku }}">
            </div>

            <div class="col-md-6">

                <label for="image" class="form-label">Image</label>
                <img id="imagePreview" class="img-fluid mt-1 mb-2 d-block" src="{{ asset('storage/' . $product->image) }}"
                    aria-label="image input" loading="lazy">
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="sku" aria-label="sku input" readonly
                    value="{{ $product->category->name }}">
            </div>

            <div class="col-12">
                <a href="{{ route('products.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
