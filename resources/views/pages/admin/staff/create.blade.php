@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('staffs.store') }}">

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
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>

                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailFeedback"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div id="emailFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="role_id" class="form-label">Role</label>
                <input type="hidden" name="role_name" id="role_name">
                <select class="form-select" id="role_id" name="role_id" aria-describedby="roleFeedback" required
                    onchange="handleChangeProduct(this)">
                    <option selected disabled></option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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

            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>

                <input type="password" class="form-control" id="password" name="password"
                    aria-describedby="passwordFeedback" required>
                @error('password')
                    <div id="passwordFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Password Confirmation</label>

                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    aria-describedby="password_confirmationFeedback" required>
                @error('password_confirmation')
                    <div id="password_confirmationFeedback" class="invalid-feedback d-block">
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
@push('scripts')
    <script>
        // set old value
        document.getElementById("role_name").value = document.getElementById("role_id").selectedOptions[0].text;

        // change value
        function handleChangeProduct(e) {
            document.getElementById("role_name").value = (e.options[e.selectedIndex].text);
        }
    </script>
@endpush
