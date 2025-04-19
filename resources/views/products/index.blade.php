@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Produk</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    @if (Auth::user()->role == 'Admin')
                        <tr>
                            <th colspan="6">
                                <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="{{ Auth::user()->role == 'Admin' ? 6 : 5 }}">
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari nama, harga, atau stok..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                </div>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        @if (Auth::user()->role == 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $index }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="Image" width="150"
                                    height="100">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            @if (Auth::user()->role == 'Admin')
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-warning btn-sm">Update</a>

                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateStockModal{{ $product->id }}">Update Stok</button>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        <div class="modal fade" id="updateStockModal{{ $product->id }}" tabindex="-1"
                            aria-labelledby="updateStockModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStockModalLabel">Update Stok Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('products.updateStock', $product->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" value="{{ $product->name }}"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Stok</label>
                                                <input type="number" name="stock" class="form-control"
                                                    value="{{ $product->stock }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

            {{-- {{ $products->links('pagination::bootstrap-5') }} --}}
        </div>
    </div>
@endsection
