@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Ringkasan Pesanan</h2>

    <div class="row">
        <div class="col-md-6">
            <table class="table">
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
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }} </td>
                            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Harga</th>
                        <th>Rp{{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label for="member_option" class="form-label mb-0">Pilih Status Member</label>
                        <span id="member_note" class="text-danger" style="display: none;">Dapat juga membuat member</span>
                    </div>
                    <select class="form-select" id="member_option" name="member_option">
                        <option value="non_member" selected>Bukan Member</option>
                        <option value="member">Member</option>
                    </select>

                    <div class="mb-3 mt-3" id="phone_input" style="display: none;">
                        <label for="phone_number" class="form-label">
                            No Telepon <span class="text-danger">(daftar/gunakan member)</span>
                        </label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Masukkan nomor telepon">
                    </div>

                    <div class="mb-3">
                        <label for="total_pay" class="form-label">Total Bayar</label>
                        <input type="text" id="total_pay" name="total_pay" class="form-control" placeholder="Masukkan total bayar">
                        <div id="bayar_error" class="text-danger mt-1" style="display: none;"></div>
                    </div>

                    <form id="summary-form" method="POST">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="order_data" value="{{ json_encode($orderData) }}">
                        <input type="hidden" name="total_price" value="{{ $total }}">

                        <input type="hidden" name="is_member" id="member_status_hidden">
                        <input type="hidden" name="phone" id="phone_number_hidden">
                        <input type="hidden" name="total_pay_hidden" id="total_pay_hidden">

                        <button type="submit" class="btn btn-primary w-100 mt-3">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let memberOption = document.getElementById('member_option');
        let phoneInputDiv = document.getElementById('phone_input');
        let phoneInput = document.getElementById('phone_number');
        let totalPayInput = document.getElementById('total_pay');
        let bayarError = document.getElementById('bayar_error');
        let memberNote = document.getElementById('member_note');
        let form = document.getElementById('summary-form');
        const totalHarga = {{ $total }};

        // Set default tampilan
        if (memberOption.value === 'member') {
            phoneInputDiv.style.display = 'block';
            memberNote.style.display = 'inline';
        } else {
            phoneInputDiv.style.display = 'none';
            memberNote.style.display = 'none';
        }

        memberOption.addEventListener('change', function () {
            if (this.value === 'member') {
                phoneInputDiv.style.display = 'block';
                memberNote.style.display = 'inline';
            } else {
                phoneInputDiv.style.display = 'none';
                memberNote.style.display = 'none';
            }
        });

        function formatRupiah(angka, prefix = "Rp") {
            let numberString = angka.replace(/[^,\d]/g, '').toString(),
                split = numberString.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + (rupiah ? rupiah : '');
        }

        totalPayInput.addEventListener('input', function (e) {
            this.value = formatRupiah(this.value);

            let bayar = this.value.replace(/[^0-9]/g, '').trim();

            if (bayar !== "" && !isNaN(bayar)) {
                let jumlahBayar = parseFloat(bayar);

                if (jumlahBayar < totalHarga) {
                    bayarError.style.display = 'block';
                    bayarError.textContent = 'Jumlah bayar kurang.';
                } else {
                    bayarError.style.display = 'none';
                    bayarError.textContent = '';
                }
            } else {
                bayarError.style.display = 'none';
                bayarError.textContent = '';
            }
        });

        form.addEventListener('submit', function (event) {
            let selectedMember = memberOption.value;
            let phoneValue = phoneInput.value.trim();
            let totalPayValue = totalPayInput.value.replace(/[^0-9]/g, '').trim();

            if (!selectedMember) {
                event.preventDefault();
                alert("Pilih status member terlebih dahulu.");
                return;
            }

            if (selectedMember === 'member' && phoneValue === "") {
                event.preventDefault();
                alert("Masukkan nomor telepon jika memilih Member.");
                return;
            }

            if (totalPayValue === "" || isNaN(totalPayValue) || parseFloat(totalPayValue) <= 0) {
                event.preventDefault();
                alert("Masukkan total bayar yang valid.");
                return;
            }

            if (parseFloat(totalPayValue) < totalHarga) {
                event.preventDefault();
                bayarError.style.display = 'block';
                bayarError.textContent = 'Jumlah bayar kurang.';
                return;
            }

            document.getElementById('member_status_hidden').value = selectedMember;
            document.getElementById('phone_number_hidden').value = phoneValue;
            document.getElementById('total_pay_hidden').value = totalPayValue;

            form.action = (selectedMember === 'member') ? "{{ route('order.member') }}" : "{{ route('order.detail-pembayaran') }}";
        });
    });
</script>
@endsection
