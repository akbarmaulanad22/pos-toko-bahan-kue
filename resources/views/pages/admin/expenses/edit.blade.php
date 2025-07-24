@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('expenses.update', ['expense' => $expense]) }}">

            @method('PUT')
            @csrf

            <div class="col-md-4">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ old('description', $expense->description) }}" required>
                @error('description')
                    <div id="descriptionFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountFeedback"
                    value="{{ old('amount', $expense->amount) }}" required>
                @error('amount')
                    <div id="amountFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
