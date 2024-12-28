@extends('layouts.main')
@section('content')
    <div>
        <div class="link-wrapper">
            <h3>Produk Konsumsi</h3>
            <a href="{{ route('main.products') }}">Lihat selengkapnya...</a>
        </div>

        <div class="row">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="col">
                        <span class="category-box">
                            <p>{{ $product->category->name }}</p>
                        </span>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        <h3>{{ $product->name }}</h3>
                        <p>
                            <span style="color: rgb(255, 175, 47)" id="price-{{ $loop->iteration }}">Rp.
                                {{ optional($product->sizes->first())->price ?? '-' }}</span>
                            <span style="color: rgb(254, 134, 154)" id="stock-{{ $loop->iteration }}">Stok:
                                {{ optional($product->sizes->first())->stock ?? '-' }}</span>
                        </p>

                        <div class="col-footer">
                            <span style="color: rgb(22, 7, 225)">Ukuran : </span>
                            <span class="button-wrap">
                                @foreach ($product->sizes as $size)
                                    <button
                                        onclick="setPrice({{ $size->price }}, {{ $size->stock }}, {{ $loop->parent->iteration }})">{{ $size->size }}</button>
                                @endforeach
                            </span>
                        </div>

                    </div>
                @endforeach
            @else
                <div class="col">
                    <h3 style="font-weight: 300">Tidak ada produk</h3>
                </div>
            @endif
        </div>
    </div>
@endsection
