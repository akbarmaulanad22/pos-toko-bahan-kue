@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('stockflow.store') }}" enctype="multipart/form-data">

            @csrf

            <div class="col-md-5">
                <label for="product_id" class="form-label">Product</label>
                <input type="hidden" name="product_name" id="product_name">
                <select class="form-select" id="product_id" name="product_id" aria-describedby="productFeedback" required
                    onchange="handleChangeProduct(this)">
                    <option selected disabled></option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
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

            <div class="col-md-4">
                <label for="size_id" class="form-label">Size</label>
                <input type="hidden" name="size_name" id="size_name">
                <select class="form-select" id="size_id" name="size_id" aria-describedby="sizeFeedback" required
                    onchange="handleChangeSize(this)">
                    <option selected disabled></option>

                </select>
                @error('size_id')
                    <div id="sizeFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" aria-describedby="typeFeedback" required>
                    <option selected disabled></option>
                    <option value="INCOMING" {{ old('type') == 'INCOMING' ? 'selected' : '' }}>
                        Incoming
                    </option>
                    <option value="OUTGOING" {{ old('type') == 'OUTGOING' ? 'selected' : '' }}>
                        Outgoing
                    </option>
                    <option value="MISSING" {{ old('type') == 'MISSING' ? 'selected' : '' }}>
                        Missing
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
                    aria-describedby="quantityFeedback" value="{{ old('quantity') }}" required>
                @error('quantity')
                    <div id="quantityFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ old('description') }}">
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
@push('scripts')
    <script>
        function handleChangeProduct(e) {
            document.getElementById("product_name").value = (e.options[e.selectedIndex].text);

            const url = '{{ route('sizes.json') }}?id=' + e.options[e.selectedIndex].value

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const sizeSelect = document.getElementById('size_id');
                    sizeSelect.innerHTML = '<option selected disabled></option>'; // Clear previous options
                    data.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size.id;
                        option.text = size.size;
                        sizeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching product data:', error));
            // e.options[e.selectedIndex].value
        }

        function handleChangeSize(e) {
            document.getElementById("size_name").value = (e.options[e.selectedIndex].text);
        }
    </script>
@endpush
