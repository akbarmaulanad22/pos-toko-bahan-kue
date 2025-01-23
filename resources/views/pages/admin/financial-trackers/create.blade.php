@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('financial-trackers.store') }}">

            @csrf

            <div class="col-md-4">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ old('description') }}" required>
                @error('description')
                    <div id="descriptionFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountFeedback"
                    value="{{ old('amount') }}" required>
                @error('amount')
                    <div id="amountFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" aria-describedby="typeFeedback" required>
                    <option selected disabled></option>
                    <option value="INCOME" {{ old('type') == 'INCOME' ? 'selected' : '' }}>
                        Income
                    </option>
                    <option value="EXPENSE" {{ old('type') == 'EXPENSE' ? 'selected' : '' }}>
                        Expense
                    </option>
                </select>
                @error('type')
                    <div id="typeFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('financial-trackers.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
