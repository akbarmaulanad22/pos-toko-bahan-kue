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
        <!-- Card 1: Total Barang Terjual -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-primary text-white">
                    Total Barang Keluar
                </div>
                <div class="card-body">
                    <h5 class="card-title">1234</h5>
                    <p class="card-text">Jumlah barang yang telah terjual</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pendapatan Bersih -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-success text-white">
                    Total Pendapatan Bersih
                </div>
                <div class="card-body">
                    <h5 class="card-title">Rp 15,000,000</h5>
                    <p class="card-text">Pendapatan bersih dari penjualan</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Transaksi -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-info text-white">
                    Total Transaksi
                </div>
                <div class="card-body">
                    <h5 class="card-title">567</h5>
                    <p class="card-text">Jumlah total transaksi yang telah dilakukan</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Barang Masuk -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card custom-card">
                <div class="card-header bg-warning text-white">
                    Total Barang Masuk
                </div>
                <div class="card-body">
                    <h5 class="card-title">456</h5>
                    <p class="card-text">Jumlah barang yang masuk ke dalam inventaris</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-link">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Row untuk tabel dalam satu baris -->
    <div class="row mb-4">
        <!-- Data Barang -->
        <div class="col-lg-4 col-md-6 pb-4">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sepatu Olahraga</td>
                            <td>150</td>
                        </tr>
                        <tr>
                            <td>Baju Kaos</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <td>Celana Jeans</td>
                            <td>180</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data Transaksi -->
        <div class="col-lg-4 col-md-6 pb-4">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TX001</td>
                            <td>3</td>
                            <td>Rp 900,000</td>
                        </tr>
                        <tr>
                            <td>TX002</td>
                            <td>2</td>
                            <td>Rp 400,000</td>
                        </tr>
                        <tr>
                            <td>TX003</td>
                            <td>5</td>
                            <td>Rp 1,250,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data Barang Masuk -->
        <div class="col-lg-4 col-md-6 pb-4">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sepatu Olahraga</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Baju Kaos</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>Celana Jeans</td>
                            <td>80</td>
                        </tr>
                    </tbody>
                </table>
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
