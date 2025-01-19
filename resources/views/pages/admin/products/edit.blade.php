@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('products.update', ['product' => $product]) }}"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameFeedback" required
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <div id="nameFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" aria-describedby="skuFeedback" required
                    value="{{ old('sku', $product->sku) }}">
                @error('sku')
                    <div id="skuFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">

                <label for="image" class="form-label">Image</label>
                <img id="imagePreview" class="img-fluid mt-1 mb-2 d-block" src="{{ $product->image }}" loading="lazy">
                <input type="file" class="form-control" id="image" aria-describedby="imageFeedback" required
                    onchange="imageInputHandler(this)">
                <div id="imageFeedbackTerms" class="valid-feedback d-block">
                    *Optional image, Only 400x400
                </div>
                @error('image')
                    <div id="imageFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" aria-describedby="categoryFeedback" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div id="categoryFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
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
