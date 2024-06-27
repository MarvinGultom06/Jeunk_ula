@extends('template.main')

@section('content')
<div class="flex-1 p-8">
    <h1 class="text-4xl font-bold mb-8 text-primary">Shopping Cart</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Product</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Price</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Quantity</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Total</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be loaded here dynamically -->
            </tbody>
        </table>
        <div class="flex justify-end mb-8">
            <p class="text-xl font-bold subtotal">Subtotal: Rp 0</p>
        </div>
        <div class="flex justify-end">
            <form action="{{ route('checkout.show') }}" method="GET">
                @csrf
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg">Proceed to Checkout</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchCartItems();
    });

    function fetchCartItems() {
        fetch('/api/cart')
            .then(response => response.json())
            .then(cartItems => {
                updateCartTable(cartItems);
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
            });
    }

    function updateCartTable(cartItems) {
        const tableBody = document.getElementById('cart-items');
        tableBody.innerHTML = ''; // Clear existing table rows
        let subtotal = 0;

        cartItems.forEach(item => {
            const price = parseFloat(item.product.price);
            const total = price * item.quantity;
            subtotal += total;
            const row = `
            <tr>
                <td class="border-b border-gray-200 p-4 flex items-center">
                    <img src="images/${item.product.image}" alt="${item.product.name}" class="h-16 w-16 object-cover rounded mr-4">
                    ${item.product.name}
                </td>
                <td class="border-b border-gray-200 p-4">${formatRupiah(price)}</td>
                <td class="border-b border-gray-200 p-4">
                    <button class="px-3 py-2 bg-gray-200" onclick="decrementQuantity(${item.id})">-</button>
                    <input id="quantity-${item.id}" type="text" class="quantity-input w-12 text-center" value="${item.quantity}" readonly>
                    <button class="px-3 py-2 bg-gray-200" onclick="incrementQuantity(${item.id})">+</button>
                </td>
                <td class="border-b border-gray-200 p-4">${formatRupiah(total)}</td>
                <td class="border-b border-gray-200 p-4">
                    <button class="px-3 py-2 bg-gray-200 bg-red-500 rounded text-white" onclick="removeFromCart(${item.id})">Remove</button>
                </td>
            </tr>
        `;
            tableBody.innerHTML += row;
        });

        document.querySelector('.subtotal').textContent = `Subtotal: ${formatRupiah(subtotal)}`;
    }

    function incrementQuantity(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        let quantity = parseInt(input.value);
        quantity++;
        updateCartItem(itemId, quantity);
    }

    function decrementQuantity(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        let quantity = parseInt(input.value);
        if (quantity > 1) {
            quantity--;
            updateCartItem(itemId, quantity);
        } else {
            removeFromCart(itemId);
        }
    }

    function updateCartItem(itemId, newQuantity) {
        fetch(`/api/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                fetchCartItems(); // Refresh the cart to update subtotal and total
            })
            .catch(error => console.error('Error updating cart item:', error));
    }

    function removeFromCart(itemId) {
        fetch(`/api/cart/remove/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item removed from cart.');
                    fetchCartItems(); // Refresh the cart to reflect changes
                } else {
                    alert('Failed to remove item from cart.');
                }
            })
            .catch(error => console.error('Error removing cart item:', error));
    }

    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endpush
