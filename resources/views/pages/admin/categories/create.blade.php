@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">

            @csrf

            <div class="col-md-6">
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

                <label for="image" class="form-label">Image</label>
                <img id="imagePreview" class="img-fluid mb-2" style="display: none">
                <input type="file" class="form-control" id="image" name="image" aria-describedby="imageFeedback"
                    required onchange="imageInputHandler(this)">
                <div id="imageFeedbackTerms" class="valid-feedback d-block">
                    *Optional image, Only 400x400
                </div>
                @error('image')
                    <div id="imageFeedback" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('categories.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>

    <script>
        const imgPreview = document.querySelector("#imagePreview");

        function imageInputHandler(e) {
            const [file] = e.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
                imgPreview.style.display = "block"
            }
        }
    </script>
@endsection
