<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Label - {{ $product->sku }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
        }
        .label-card {
            background: white;
            padding: 20px;
            border: 2px solid black;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }
        .sku {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        .name {
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
        }
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .label-card { border: 1px solid black; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="label-card">
        <span class="name">{{ $product->name }}</span>
        
        {{-- QR Code --}}
        <div style="display: flex; justify-content: center;">
            {!! QrCode::size(150)->generate($product->sku) !!}
        </div>

        <span class="sku">{{ $product->sku }}</span>
        <p style="font-size: 10px; margin-top: 10px;">AEROSPACE WMS PROPERTY</p>
    </div>

</body>
</html>