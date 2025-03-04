@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4">Giỏ Hàng</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($cart) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Sách</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <tr data-id="{{ $item['id'] }}">
                                <td>{{ $item['title'] }}</td>
                                <td>{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-center nowrap">
                                    <button class="btn btn-sm btn-primary decrease-qty">-</button>
                                    <input type="number" class="quantity-input text-center" value="{{ $item['quantity'] }}" min="1" style="width: 50px;">
                                    <button class="btn btn-sm btn-primary increase-qty">+</button>
                                </td>
                                <td class="total-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('books.app.checkout_cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">x</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tổng tiền -->
            <div class="d-flex justify-content-between mt-4">
                <h5>Tổng thanh toán: <i id="total-amount" class="text-danger">
                    {{ number_format(array_sum(array_map(function ($item) { return $item['price'] * $item['quantity']; }, $cart)), 0, ',', '.') }} VND
                </i></h5>
                <a href="{{ route('books.app.checkout_cart.finalize') }}" class="btn btn-success">Thanh toán</a>
            </div>
        @else
            <div class="alert alert-warning text-center mt-4">
                Giỏ hàng của bạn trống.
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const updateQuantity = (btn, change) => {
                const row = btn.closest("tr");
                const itemId = row.getAttribute("data-id");
                const input = row.querySelector(".quantity-input");
                let newQuantity = parseInt(input.value) + change;
                
                if (newQuantity < 1) newQuantity = 1; // Đảm bảo số lượng tối thiểu là 1
                input.value = newQuantity;

                // Gửi AJAX cập nhật số lượng
                fetch(`{{ route('books.app.checkout_cart.update') }}`, {
                    method: "POST",
                    headers: { 
                        "Content-Type": "application/json", 
                        "X-CSRF-TOKEN": '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: itemId, quantity: newQuantity })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.querySelector(".total-price").innerText = data.newTotal;
                        document.getElementById("total-amount").innerText = data.cartTotal;
                    }
                }).catch(error => console.error(error));
            };

            document.querySelectorAll(".increase-qty").forEach(btn => {
                btn.addEventListener("click", function () {
                    updateQuantity(this, 1);
                });
            });

            document.querySelectorAll(".decrease-qty").forEach(btn => {
                btn.addEventListener("click", function () {
                    updateQuantity(this, -1);
                });
            });

            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("change", function () {
                    const row = this.closest("tr");
                    const itemId = row.getAttribute("data-id");
                    let newQuantity = parseInt(this.value);
                    
                    if (isNaN(newQuantity) || newQuantity < 1) {
                        newQuantity = 1;
                        this.value = newQuantity;
                    }

                    fetch(`{{ route('books.app.checkout_cart.update') }}`, {
                        method: "POST",
                        headers: { 
                            "Content-Type": "application/json", 
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: itemId, quantity: newQuantity })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.querySelector(".total-price").innerText = data.newTotal;
                            document.getElementById("total-amount").innerText = data.cartTotal;
                        }
                    }).catch(error => console.error(error));
                });
            });
        });
    </script>
@endsection
