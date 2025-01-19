@extends('layouts.admin')
@push('styles')
@endpush
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
                <button class="btn btn-light" type="button">
                    <i class="bi bi-add"></i>
                    Export
                </button>
            </div>
        </div>
        <!-- Data Order -->
        <div class="table-wrapper overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer</th>
                        {{-- <th scope="col">Amount</th> --}}
                        {{-- <th scope="col">Quantities</th> --}}
                        <th scope="col">Payment</th>
                        <th scope="col">Date</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">AZKA0001</th>
                        <td>Azka</td>
                        {{-- <td>Rp. 100.000,00</td> --}}
                        {{-- <td>10</td> --}}
                        <td>Transfer</td>
                        <td class="text-nowrap">10, August 2022</td>
                        <td class="text-center">
                            <a href="">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- pagination here --}}
        </div>

    </section>
@endsection
