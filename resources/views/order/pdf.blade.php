<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .receipt {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            font-size: 24px;
        }

        .section {
            margin-bottom: 15px;
        }

        .line {
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            border-top: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .section p {
            margin: 5px 0;
        }

        .mt-3 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Nota Pembayaran</h2>
        <div class="store-info text-center mb-4">
            @if(isset($paymentDetails['toko']) && $paymentDetails['toko'] != null)
                <h3>Nama Toko: {{ $paymentDetails['toko']->nama_toko }}</h3>
                <p>Alamat: {{ $paymentDetails['toko']->alamat }}</p>
                <p>No. HP: {{ $paymentDetails['toko']->no_hp }}</p>
            @else
                <p>Fresh Flowers</p>
            @endif
        </div>

        <div class="section">
            <p><strong>Invoice:</strong> {{ $paymentDetails['invoice'] }}</p>
            <p><strong>Tanggal:</strong> {{ $paymentDetails['created_at'] }}</p>
            <p><strong>Kasir:</strong> {{ $paymentDetails['kasir'] }}</p>
        </div>

        @if ($paymentDetails['is_member'] === 'member')
        <div class="section">
            <p><strong>Telepon:</strong> {{ $paymentDetails['phone'] }}</p>
            <p><strong>Member Sejak:</strong> {{ $paymentDetails['member_since'] }}</p>
        </div>
        @endif

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align:right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentDetails['products'] as $product)
                    <tr>
                        <td>{{ $product['name'] }} x{{ $product['quantity'] }} </td>
                        <td style="text-align:right">Rp {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section">
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($paymentDetails['total_pay'], 0, ',', '.') }}</p>
            <p><strong>Poin Digunakan:</strong> {{ number_format($paymentDetails['poin_digunakan'], 0, ',', '.') }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($paymentDetails['total_asli'] - $paymentDetails['poin_digunakan'], 0, ',', '.') }}</p>
            <p><strong>Kembalian:</strong> Rp {{ number_format($paymentDetails['kembalian'], 0, ',', '.') }}</p>
        </div>

        <div class="line"></div>

        <div class="text-center mt-3">
            <p>--- Terima Kasih ---</p>
        </div>
    </div>
</body>
</html>
