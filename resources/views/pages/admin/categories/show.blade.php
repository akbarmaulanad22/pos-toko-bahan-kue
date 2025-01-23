@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            @csrf

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameFeedback"
                    value="{{ $category->name }}" readonly>
            </div>
            <div class="col-md-6">

                <label for="image" class="form-label">Image</label>
                <img id="imagePreview" class="img-fluid mb-2" style="display: block"
                    src="{{ asset('storage/' . $category->image) }}">
            </div>

            <div class="col-12">
                <a href="{{ route('categories.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
