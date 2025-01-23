@extends('layouts.admin')
@section('content')
    <section class="">
        <div class="d-flex justify-content-between justify-content-md-end gap-2 pb-2">
            <form action="" class="">
                <input type="search" name="search" id="search" class="form-control" placeholder="Search...">
            </form>
            <div class="dropdown">
                <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <!-- Data Log Staff -->
        <div class="table-wrapper overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Actor</th>
                        <th scope="col">Action</th>
                        <th scope="col">Input</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logStaffs as $logStaff)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $logStaff->created_by }}</td>
                            <td>{{ $logStaff->action }}</td>
                            <td>{{ $logStaff->input }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td scope="row" colspan="5" class="text-center">No Log Staffs Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
