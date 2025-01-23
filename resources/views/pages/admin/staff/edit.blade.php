@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('staffs.update', ['staff' => $staff]) }}">

            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameFeedback"
                    value="{{ old('name', $staff->name) }}" required>
                @error('name')
                    <div id="nameFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>

                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailFeedback"
                    value="{{ old('email', $staff->email) }}" required>
                @error('email')
                    <div id="emailFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-select" id="role_id" name="role_id" aria-describedby="roleFeedback" required>
                    <option selected disabled></option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $staff->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div id="roleFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('staffs.index') }}" class="btn btn-light">Back</a>
            </div>

        </form>
    </section>
@endsection
