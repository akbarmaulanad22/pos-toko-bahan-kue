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
            <div class="d-flex justify-content-end">
                <a href="#" class="btn btn-light">
                    <i class="bi bi-add"></i>
                    Export
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <div class="fw-semibold">Pendapatan Kotor (Penjualan)</div>
                    <div class="fs-5 text-success">Rp{{ number_format($totalPendapatanKotor, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <div class="fw-semibold">Pengeluaran</div>
                    <div class="fs-5 text-danger">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <div class="fw-semibold">Pendapatan Bersih</div>
                    <div class="fs-5 text-primary">Rp{{ number_format($totalPendapatanBersih, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>


        <!-- Data Product -->
        <div class="table-wrapper overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($combinedReports as $combinedReport)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $combinedReport->date }}</td>
                            <td>{{ $combinedReport->type }}</td>
                            <td>{{ $combinedReport->amount }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td scope="row" colspan="6" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
