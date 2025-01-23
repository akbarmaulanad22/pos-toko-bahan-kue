@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('stockflow.update', ['stockflow' => $stockflow]) }}"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-select" id="product_id" name="product_id" aria-describedby="productFeedback" required>
                    <option selected disabled></option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $stockflow->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div id="productFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" aria-describedby="typeFeedback" required>
                    <option selected disabled></option>
                    <option value="INCOMING" {{ old('type', $stockflow->type) == 'INCOMING' ? 'selected' : '' }}>
                        Incoming
                    </option>
                    <option value="OUTGOING" {{ old('type', $stockflow->type) == 'OUTGOING' ? 'selected' : '' }}>
                        Outgoing
                    </option>
                </select>
                @error('type')
                    <div id="typeFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity"
                    aria-describedby="quantityFeedback" value="{{ old('quantity', $stockflow->quantity) }}" required>
                @error('quantity')
                    <div id="quantityFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ old('description', $stockflow->description) }}">
                @error('description')
                    <div id="descriptionFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>



            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('stockflow.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
