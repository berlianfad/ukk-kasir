@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Buat Pesanan</h2>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="Image" width="300">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Stock: {{ $product->stock }}</p>
                            <p class="card-text">Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm me-2"
                                    onclick="decreaseQuantity({{ $product->id }})">-</button>
                                <input type="number" id="qty-{{ $product->id }}" class="form-control text-center"
                                    value="0" min="0" max="{{ $product->stock }}" style="width: 60px;" readonly>
                                <button type="button" class="btn btn-success btn-sm ms-2"
                                    onclick="increaseQuantity({{ $product->id }})">+</button>
                            </div>

                            <p class="mt-2">Subtotal: Rp<span id="subtotal-{{ $product->id }}">0</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <form id="order-form" action="{{ route('order.summary') }}" method="POST">
            @csrf
            <input type="hidden" name="order_data" id="order-data">
            <button type="submit" id="next-button" class="btn btn-primary btn-lg fs-4 px-4 mt-3">Selanjutnya</button>
        </form>
    </div>

    <script>
        let orderData = [];

        function increaseQuantity(productId) {
            let qtyInput = document.getElementById("qty-" + productId);
            let subtotal = document.getElementById("subtotal-" + productId);
            let price = @json($products->pluck('price', 'id'));

            if (parseInt(qtyInput.value) < qtyInput.max) {
                qtyInput.value = parseInt(qtyInput.value) + 1;
                let totalPrice = qtyInput.value * price[productId];
                subtotal.innerText = totalPrice.toLocaleString('id-ID');

                updateOrderData(productId, qtyInput.value, price[productId], totalPrice);
            }
        }

        function decreaseQuantity(productId) {
            let qtyInput = document.getElementById("qty-" + productId);
            let subtotal = document.getElementById("subtotal-" + productId);
            let price = @json($products->pluck('price', 'id'));

            if (parseInt(qtyInput.value) > 0) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                let totalPrice = qtyInput.value * price[productId];
                subtotal.innerText = totalPrice.toLocaleString('id-ID');

                updateOrderData(productId, qtyInput.value, price[productId], totalPrice);
            }
        }

        function updateOrderData(productId, quantity, price, subtotal) {
            let index = orderData.findIndex(item => item.id === productId);

            if (quantity > 0) {
                if (index !== -1) {
                    orderData[index].quantity = quantity;
                    orderData[index].subtotal = subtotal;
                } else {
                    orderData.push({
                        id: productId,
                        name: document.querySelector(`#qty-${productId}`).closest('.card-body').querySelector('.card-title').innerText,
                        price: price,
                        quantity: quantity,
                        subtotal: subtotal
                    });
                }
            } else {
                if (index !== -1) {
                    orderData.splice(index, 1);
                }
            }
        }

        document.getElementById("order-form").addEventListener("submit", function(event) {
            if (orderData.length === 0) {
                alert("Harap pilih minimal satu produk sebelum melanjutkan.");
                event.preventDefault();
            } else {
                document.getElementById("order-data").value = JSON.stringify(orderData);
            }
        });
    </script>
@endsection
