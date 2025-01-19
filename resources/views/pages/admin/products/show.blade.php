@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameFeedback" readonly
                    value="{{ $product->name }}">
                @error('name')
                    <div id="nameFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" aria-describedby="skuFeedback" readonly
                    value="{{ $product->sku }}">
                @error('sku')
                    <div id="skuFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">

                <label for="image" class="form-label">Image</label>
                <img id="imagePreview" class="img-fluid mt-1 mb-2 d-block" src="{{ $product->image }}" loading="lazy">
                @error('image')
                    <div id="imageFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" aria-describedby="categoryFeedback" readonly>
                    <option selected>
                        {{ $product->category->name }}
                    </option>
                </select>
                @error('category')
                    <div id="categoryFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <a href="{{ route('products.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>

    <script>
        const imgPreview = document.querySelector("#imagePreview");

        function imageInputHandler(e) {
            const [file] = e.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
                imgPreview.style.display = "block"
            }
        }
    </script>
@endsection
