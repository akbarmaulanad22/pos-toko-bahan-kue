@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('roles.store') }}">

            @csrf

            <div class="col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameFeedback"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div id="nameFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('roles.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
