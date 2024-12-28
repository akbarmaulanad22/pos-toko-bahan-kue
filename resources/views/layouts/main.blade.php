<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="/css/stylesulawesi.css">
</head>

<body>
    <div class="link-wrapper">
        <h1>Toko Bahan Kue Azka</h1>
    </div>

   @yield('content')

    <script>
        function setPrice(price, stock, index) {
            var priceContent = document.getElementById("price-" + index);
            var stockContent = document.getElementById("stock-" + index);

            priceContent.textContent = "Rp. " + price;
            stockContent.textContent = "Stok: " + stock;
        }
    </script>

</body>

</html>
