@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('sizes.store', ['product' => $product]) }}">

            @csrf

            <div class="col-md-6">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" name="size" aria-describedby="sizeFeedback"
                    value="{{ old('size') }}" required>
                @error('size')
                    <div id="sizeFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" aria-describedby="priceFeedback"
                    value="{{ old('price') }}" required>
                @error('price')
                    <div id="priceFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">

                <label for="modal" class="form-label">Modal</label>
                <input type="text" class="form-control" id="modal" name="modal" aria-describedby="modalFeedback"
                    value="{{ old('modal') }}" required>
                @error('modal')
                    <div id="modalFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" aria-describedby="stockFeedback"
                    value="{{ old('stock') }}" required>
                @error('stock')
                    <div id="stockFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('sizes.index', ['product' => $product]) }}" class="btn btn-light">Back</a>
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
