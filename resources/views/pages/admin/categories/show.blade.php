@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <main class="form-product">
                    <form>
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top" id="name" name="name"
                                placeholder="Name" value="{{ $category->name }}" disabled readonly>
                            <label for="name">Nama</label>

                        </div>

                        @if ($category->image)
                            <img id="imagePreview" class="img-fluid rounded-bottom"
                                src="{{ asset('storage/' . $category->image) }}">
                        @endif

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('categories.index') }}"
                                class="col-6 col-sm-2 text-decoration-none my-3 text-end">Kembali</a>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
