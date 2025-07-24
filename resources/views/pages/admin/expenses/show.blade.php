@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">
            <div class="col-md-4">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ $expense->description }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountFeedback"
                    value="{{ $expense->amount }}" readonly>
            </div>
            <div class="col-12">
                <a href="{{ route('expense-trackers.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
