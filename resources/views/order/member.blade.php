@extends('layouts.app', ['title' => 'Penjualan', 'page' => 'sale'])

@section('content')
    <div class="container mt-4">
        <form id="sale-form" action="{{ route('order.detail-pembayaran') }}" method="POST">
            @csrf
            @method('POST')

            @if (Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="container p-3 bg-white border rounded shadow-sm mb-4">
                        <h4 class="mb-3">Ringkasan Penjualan</h4>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($orderData as $item)
                                    @php
                                        $subtotal = (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 0);
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $item['name'] ?? '-' }}</td>
                                        <td>{{ $item['quantity'] ?? 0 }}</td>
                                        <td>Rp {{ number_format((float) ($item['price'] ?? 0), 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total Harga</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total Bayar</th>
                                    <th>Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="container p-3 bg-white border rounded shadow-sm mb-4">
                        <h4 class="mb-3">Informasi Member</h4>

                        @php
                            $poinBaru = floor($total * 0.01);
                            $totalPoin = $poinSaatIni + $poinBaru;
                        @endphp

                        <label for="customer_name"><strong>Nama Member:</strong></label>
                        <input type="text" name="customer_name_input" id="customer_name" class="form-control mb-2"
                            value="{{ old('customer_name_input', $namaPengguna ?? '') }}" placeholder="Masukkan Nama"
                            required>

                        <input type="hidden" name="phone" id="phone_number"
                            value="{{ old('phone', $nomorTelepon ?? '') }}">
                        <input type="hidden" name="is_member" value="{{ old('is_member', $statusMember ?? '') }}">

                        <p><strong>Poin:</strong> <span id="total_poin">{{ $totalPoin }}</span></p>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="check_poin" id="check_poin"
                                {{ $countSale < 1 ? 'disabled' : '' }}>
                            <label class="form-check-label" for="check_poin">Gunakan poin</label>
                            @if ($countSale < 1)
                                <div id="poin-error" class="text-danger mt-1">
                                    Anda tidak bisa menggunakan poin pada saat pembelian pertama.
                                </div>
                            @endif
                        </div>

                        <input type="hidden" name="poin_digunakan" id="poin_digunakan" value="0">
                        <input type="hidden" name="points_earned" value="{{ $poinBaru }}">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary w-100">Selanjutnya</button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="order_data" value="{{ json_encode($orderData) }}">
            <input type="hidden" name="total_price" value="{{ $total }}">
            <input type="hidden" name="total_pay_hidden" value="{{ $jumlahBayar ?? $total }}">

        </form>
    </div>

    <script>
        document.getElementById('check_poin')?.addEventListener('change', function() {
            let totalHarga = {{ $total }};
            let poinTersedia = {{ $poinSaatIni + $poinBaru }};
            let poinInput = document.getElementById('poin_digunakan');

            if (this.checked) {
                poinInput.value = Math.min(totalHarga, poinTersedia);
            } else {
                poinInput.value = 0;
            }
        });


        document.getElementById('sale-form').addEventListener('submit', function(e) {
            const customerName = document.getElementById('customer_name').value.trim();
            const phone = document.getElementById('phone_number').value.trim();
            const checkbox = document.getElementById('check_poin');
            const countSale = {{ $countSale }};
            const errorDiv = document.getElementById('poin-error');

            if (!customerName || !phone) {
                alert('Nama dan nomor telepon harus diisi.');
                e.preventDefault();
                return;
            }

            if (checkbox?.checked && countSale < 1) {
                errorDiv.style.display = 'block';
                e.preventDefault();
                return;
            }
        });
    </script>
@endsection
