@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            <div class="col-md-6">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" name="size" aria-describedby="sizeFeedback"
                    value="{{ $size->size }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" aria-describedby="priceFeedback"
                    value="{{ $size->price }}" readonly>
            </div>

            <div class="col-md-6">

                <label for="modal" class="form-label">Modal</label>
                <input type="text" class="form-control" id="modal" name="modal" aria-describedby="modalFeedback"
                    value="{{ $size->modal }}" readonly>
            </div>

            <div class="col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" aria-describedby="stockFeedback"
                    value="{{ $size->stock }}" readonly>
            </div>

            <div class="col-12">
                <a href="{{ route('sizes.index', ['product' => $product]) }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
