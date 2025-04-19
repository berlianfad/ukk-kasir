@extends('layouts.app', ['title' => 'Detail Pembayaran', 'page' => 'detail-pembayaran'])

@section('content')
<div class="receipt">
    <h2>Nota Pembayaran</h2>
    <div class="store-info text-center mb-4">
        @if(isset($paymentDetails['toko']) && $paymentDetails['toko'] != null)
            <h3>{{ $paymentDetails['toko']->nama_toko }}</h3>
            <p>{{ $paymentDetails['toko']->alamat }}</p>
            <p>No. HP: {{ $paymentDetails['toko']->no_hp }}</p>
        @else
            <p>Fresh Flowers</p>
        @endif
    </div>

    <div class="section">
        <p><strong>Invoice:</strong> {{ $paymentDetails['invoice'] }}</p>
        <p><strong>Kasir:</strong> {{ $paymentDetails['kasir'] }}</p>
        <p><strong>Status:</strong> {{ $paymentDetails['is_member'] }}</p>
        <p><strong>No Telp:</strong> {{ $paymentDetails['order']->no_telp ?? '-' }}</p>

    </div>
    <div class="section">
        <!-- Tambahkan konten lain sesuai kebutuhan -->
    </div>
        <div class="section">
            @if ($paymentDetails['is_member'] === 'member')
                <p><strong>Member Sejak:</strong> {{ $paymentDetails['member_since'] }}</p>
                <p><strong>Member Poin:</strong> {{ $paymentDetails['poin_didapat'] }}</p>
            @endif
        </div>

        <div class="section highlight">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align:right">Harga</th>
                        <th style="text-align:right">Quantity</th>
                        <th style="text-align:right">No Telp</th>
                        <th style="text-align:right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentDetails['products'] as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td style="text-align:right">Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td style="text-align:right">{{ $product['quantity'] }}</td>
                            <td style="text-align:right">Rp {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <div class="d-flex justify-content-between fs-4 ">
                    <span>Total Pembayaran:</span>
                    <strong>Rp {{ number_format($paymentDetails['total_pay'], 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between fs-4">
                    <span>Poin Digunakan:</span>
                    <strong>{{ number_format($paymentDetails['poin_digunakan'], 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between fs-4">
                    <span>Total Harga:</span>
                    <strong>Rp
                        {{ number_format($paymentDetails['total_asli'] - $paymentDetails['poin_digunakan'], 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between fs-4">
                    <span>Kembalian:</span>
                    <strong>Rp {{ number_format($paymentDetails['kembalian'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>


        <div class="text-center">
            <p>--- Terima Kasih ---</p>
        </div>

        <div class="btn-container">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('orders.downloadPDF', ['id' => $paymentDetails['order']->id]) }}"
                class="btn btn-primary">Unduh PDF</a>
        </div>
    </div>
@endsection
