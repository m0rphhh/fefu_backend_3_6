<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Catalog </title>

</head>
<body>
    Catalog
    @include('catalog.catalog_list', ['$categories', $categories])

    @foreach($products as $product)
        <a href={{ route('product', $product->slug) }}>
            <h1> {{ $product->name }}</h1>
        </a>
        <h1> {{ $product->price }} руб.</h1>
    @endforeach
    {{ $products->links() }}
</body>
</html>

