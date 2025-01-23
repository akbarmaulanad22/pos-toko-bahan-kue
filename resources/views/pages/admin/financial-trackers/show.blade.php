@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">


            <div class="col-md-4">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    aria-describedby="descriptionFeedback" value="{{ $financial->description }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountFeedback"
                    value="{{ $financial->amount }}" readonly>
            </div>

            <div class="col-md-4">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" aria-describedby="typeFeedback"
                    value="{{ $financial->type }}" readonly>
            </div>

            <div class="col-12">
                <a href="{{ route('financial-trackers.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
