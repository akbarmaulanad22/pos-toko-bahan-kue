@extends('layouts.admin')

@section('content')
    <section>
        <form class="row g-3">

            <div class="col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameFeedback"
                    value="{{ $staff->name }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>

                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailFeedback"
                    value="{{ $staff->email }}" readonly>
            </div>

            <div class="col-md-6">
                <label for="role_id" class="form-label">Role</label>
                <input type="text" class="form-control" id="role_id" name="role_id" aria-describedby="roleFeedback"
                    value="{{ optional($staff->role)->name }}" readonly>
            </div>


            <div class="col-12">
                <a href="{{ route('staffs.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>
    </section>
@endsection
