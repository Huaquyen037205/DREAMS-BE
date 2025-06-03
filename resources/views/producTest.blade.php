<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f8f8f8;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        .product-item {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 0 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .product-item:hover {
            transform: scale(1.02);
        }
        .product-item img {
            max-width: 100%;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .product-name {
            font-size: 16px;
            margin: 5px 0;
        }
        .product-price {
            color: #e91e63;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Danh sách sản phẩm</h2>
<div class="product-grid">
@foreach ($products as $product)
    <div class="product-item">
        @if($product->img && count($product->img))
          <img src="{{ url('img/' . $product->img->first()->name) }}" alt="{{ $product->img->first()->name }}">

        @else
            <img src="{{ url('img/default.jpg') }}" alt="No image">
        @endif
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">{{ number_format($product->variant[0]->price ?? 0) }}đ</div>
    </div>
@endforeach
</div>
</body>
</html>
