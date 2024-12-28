@extends('layouts.main')
@section('content')
    <div>
        <div class="link-wrapper">
            <div>
                <h3>{{ $title }}</h3>
            </div>
            <form action="" method="get">
                <input type="search" name="search" placeholder="cari sesuatu" value="{{ request()->query('search') }}">
            </form>
        </div>

        <div class="row">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="col">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        <h3>{{ $product->name }}</h3>
                        <p>
                            <span style="color: rgb(255, 175, 47)" id="price-{{ $loop->iteration }}">Rp.
                                {{ optional($product->sizes->first())->price ?? '-' }}</span>
                            <span style="color: rgb(254, 134, 154)" id="stock-{{ $loop->iteration }}">Stok:
                                {{ optional($product->sizes->first())->stock ?? '-' }}</span>
                        </p>

                        <div class="col-footer">
                            <span style="color: rgb(22, 7, 225)">Ukuran(gr) : </span>
                            <span class="button-wrap">
                                @if (count($product->sizes) > 0)
                                    @foreach ($product->sizes as $size)
                                        <button
                                            onclick="setPrice({{ $size->price }}, {{ $size->stock }}, {{ $loop->parent->iteration }})">{{ $size->size }}</button>
                                    @endforeach
                                @else
                                    <span>-</span>
                                @endif
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
        {{ $products->links() }}
    </div>
@endsection
