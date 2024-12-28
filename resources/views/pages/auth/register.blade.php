@extends('layouts.auth')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <main class="form-register">
                    <h1 class="h3 mb-3 fw-normal text-center">Welcome</h1>
                    <form method="POST">
                        @csrf
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                            <label for="name">Name</label>
                            @error('name')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="name@example.com" value="{{ old('email') }}">
                            <label for="email">Email address</label>
                            @error('email')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="password"
                                class="form-control rounded-bottom @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation">
                            <label for="password_confirmation">Password Confirmation</label>
                            @error('password_confirmation')
                                <div class="invalid-feedback mb-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div> --}}
                        <button class="btn btn-primary w-100 my-3" type="submit">Register</button>
                    </form>

                    <small class="d-block text-center">
                        Already registered? <a class="text-decoration-none" href="{{ route('login') }}">login</a>
                    </small>

                </main>
            </div>
        </div>
    </div>
@endsection
