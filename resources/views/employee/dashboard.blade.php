@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <!-- Periksa apakah $toko ada, jika tidak tampilkan pesan default -->
        <h2>Selamat Datang, Di {{ $toko->nama_toko ?? 'Toko Tidak Tersedia' }}!</h2>

        <div class="card p-4 mb-4 mx-auto" style="max-width: 1000px; background-color: #f8f9fa; margin-top: 100px;">
            <h3 class="fw-bold mb-3">Total Penjualan Hari Ini</h3>
            <h1 class="display-4 fw-bold">{{ $jumlahTransaksi }}</h1>
            <small class="d-block mt-3">Jumlah total penjualan yang terjadi hari ini.</small>
            <small class="text-muted">Terakhir diperbarui: {{ $lastUpdated }}</small>
        </div>
    </div>
@endsection
