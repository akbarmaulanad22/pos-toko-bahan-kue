@extends('layouts.auth')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <main class="form-signin w-100 m-auto">
                    <h1 class="h3 mb-3 fw-normal text-center">Welcome back</h1>

                    @if (session()->has('registerSuccessfully'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('registerSuccessfully') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session()->has('loginFailed'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('loginFailed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST">
                        @csrf
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

                        {{-- <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div> --}}
                        <button class="btn btn-primary w-100 py-2 my-3" type="submit">Login</button>
                    </form>

                    <small class="d-block text-center">
                        not registered? register <a class="text-decoration-none"
                            href="/niggadilarangmasukwak/register">here</a>
                    </small>

                </main>
            </div>
        </div>
    </div>
@endsection
