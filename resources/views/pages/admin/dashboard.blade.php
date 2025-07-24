@extends('layouts.admin')

@push('styles')
    <style>
        /* Membuat card dan kolom memiliki tinggi yang sama */
        .row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .col-md-3 {
            display: flex;
            flex-direction: column;
        }

        .custom-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Membuat card mengisi seluruh tinggi kolom */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Pastikan body card memiliki flex-grow agar kontennya bisa mengisi tinggi card */
        .custom-card .card-body {
            flex-grow: 1;
            background: #f8f9fa;
        }

        .custom-card .card-header {
            font-size: 1.1rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .custom-card .card-footer {
            text-align: right;
        }

        .custom-card .card-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .custom-card .card-footer a:hover {
            text-decoration: underline;
        }

        /* Animasi hover */
        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        @media (max-width: 767px) {
            .custom-card {
                margin-bottom: 20px;
            }

            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>

    <!-- Custom CSS untuk desain estetik -->
    <style>
        .table-wrapper {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .table-wrapper:hover {
            transform: translateY(-5px);
            /* font-size: 1.25rem;
                                                                                                            font-weight: 600;
                                                                                                            margin-bottom: 15px;
                                                                                                            color: #333;
                                                                                                            text-align: center; */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle;
            font-size: 1rem;
            color: #495057;
        }

        .table thead {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        /* Efek responsif pada perangkat kecil */
        @media (max-width: 767px) {

            .table th,
            .table td {
                font-size: 0.875rem;
            }

            .row {
                flex-direction: column;
                /* Membuat tabel tampil vertikal pada perangkat kecil */
            }
        }
    </style>
@endpush

@section('content')
    {{-- start tag --}}
    <div id="tag">
    </div>
    {{-- end tag --}}

    {{-- content --}}
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-warning text-white">
                    Total Role
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $roleCount }}</h5>
                    <p class="card-text">Jumlah peran pengguna</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('roles.index') }}" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-primary text-white">
                    Total Staff
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $staffCount }}</h5>
                    <p class="card-text">Jumlah staff aktif</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('staffs.index') }}" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-success text-white">
                    Total Category
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $categoryCount }}</h5>
                    <p class="card-text">Jumlah kategori</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('categories.index') }}" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-info text-white">
                    Total Product
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productCount }}</h5>
                    <p class="card-text">Jumlah total produk</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>


    </div>

    {{-- end content --}}
@endsection
@push('scripts')
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
    <script>
        document.querySelectorAll('.custom-card').forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('clicked');
                card.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                }, 300);
            });
        });
    </script>
@endpush
