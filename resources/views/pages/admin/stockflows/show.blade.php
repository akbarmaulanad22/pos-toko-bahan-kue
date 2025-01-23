@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            <div class="col-md-6">
                <label for="product_id" class="form-label">Product</label>
                <input type="text" class="form-control" id="product_id" name="product_id"
                    aria-describedby="product_idFeedback" value="{{ old('product_id', $stockflow->quantity) }}" readonly>
            </div>

            <div class="col-md-6">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" aria-describedby="typeFeedback"
                    value="{{ old('type', $stockflow->type) }}" readonly>
            </div>

            <div class="col-md-6">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity"
                    aria-describedby="quantityFeedback" value="{{ old('quantity', $stockflow->quantity) }}" readonly>
            </div>

            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ old('description', $stockflow->description) }}"
                    readonly>
            </div>



            <div class="col-12">
                <a href="{{ route('stockflow.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
