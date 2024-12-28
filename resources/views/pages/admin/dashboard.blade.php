@extends('layouts.admin')

@section('content')
    {{-- start tag --}}
    <div id="tag">
    </div>
    {{-- end tag --}}
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        window.onload = function() {
            if (sessionStorage.getItem('message')) {
                $("#tag").html(`
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${JSON.parse(sessionStorage.getItem('message'))} 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
                sessionStorage.clear();
            }
        }
    </script>
@endpush
