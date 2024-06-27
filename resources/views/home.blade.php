@extends('template.main')

@section('content')
<div class="container mx-auto p-8">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Jeunk Ula" class="logo rounded-full h-14 w-auto mr-4">
            <h1 class="text-4xl font-bold text-primary">Jeunk Ula - Produk</h1>
        </div>
        <div class="mb-8 flex">
            <input type="text" id="search-input" class="w-full p-4 border border-gray-300 rounded-lg" placeholder="Cari produk...">
            <button id="search-button" class="ml-2 p-4 bg-primary text-white rounded-lg">Cari</button>
        </div>
    </div>
    <div class="mb-8 flex">
        <select id="sort-select" class="p-4 border border-gray-300 rounded-lg">
            <option value="">Urutkan berdasarkan</option>
            <option value="low-to-high">Harga: Terendah ke Tertinggi</option>
            <option value="high-to-low">Harga: Tertinggi ke Terendah</option>
        </select>
    </div>
    <div class="mb-8 flex">
        <select id="category-select" class="p-4 border border-gray-300 rounded-lg">
            <option value="">Filter berdasarkan Kategori</option>
            <option value="manis">Manis</option>
            <option value="asin">Asin</option>
        </select>
    </div>
    <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Data Produk -->
    </div>
</div>
@endsection

@push('styles')
<style>
    .logo {
        width: auto; /* Lebar otomatis */
        max-height: 5rem; /* Tinggi maksimum */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const sortSelect = document.getElementById('sort-select');
        const categorySelect = document.getElementById('category-select');

        searchButton.addEventListener('click', function() {
            fetchProducts(searchInput.value, sortSelect.value, categorySelect.value);
        });

        sortSelect.addEventListener('change', function() {
            fetchProducts(searchInput.value, sortSelect.value, categorySelect.value);
        });

        categorySelect.addEventListener('change', function() {
            fetchProducts(searchInput.value, sortSelect.value, categorySelect.value);
        });

        
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                fetchProducts(searchInput.value, sortSelect.value, categorySelect.value);
            }
        });

        fetchProducts();
    });

    function fetchProducts(searchTerm = '', sortOption = '', category = '') {
        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                const { products, cartItems } = data;
                const productList = document.getElementById('product-list');
                productList.innerHTML = ''; // Bersihkan daftar produk

                let filteredProducts = products.filter(product => 
                    product.name.toLowerCase().includes(searchTerm.toLowerCase())
                );

                if (category) {
                    filteredProducts = filteredProducts.filter(product => 
                        product.description.toLowerCase().includes(category.toLowerCase())
                    );
                }

                if (sortOption === 'low-to-high') {
                    filteredProducts.sort((a, b) => a.price - b.price);
                } else if (sortOption === 'high-to-low') {
                    filteredProducts.sort((a, b) => b.price - a.price);
                }

                filteredProducts.forEach(product => {
                    const isInCart = cartItems.hasOwnProperty(product.id);
                    const quantity = isInCart ? cartItems[product.id].quantity : 1;
                    const productCard = `
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <img src="images/${product.image}" alt="${product.name}" class="h-48 w-full object-cover mb-4 rounded-lg">
                            <h2 class="text-2xl font-bold mb-2">${product.name}</h2>
                            <p class="text-gray-700 mb-4">Harga: Rp ${numberWithCommas(product.price)}</p>
                            <button id="add-button-${product.id}" class="bg-primary text-white px-4 py-2 rounded-lg ${isInCart ? 'hidden' : ''}" onclick="addToCart(${product.id}, 1)">Tambahkan ke Keranjang</button>
                            <div id="quantity-input-${product.id}" class="flex items-center mt-4 ${isInCart ? '' : 'hidden'}">
                                <button class="px-3 py-2 bg-gray-200" onclick="decrementQuantity(${product.id})">-</button>
                                <input id="quantity-${product.id}" type="text" class="w-12 text-center mx-3" value="${quantity}" readonly>
                                <button class="px-3 py-2 bg-gray-200" onclick="incrementQuantity(${product.id})">+</button>
                            </div>
                        </div>
                    `;
                    productList.innerHTML += productCard;
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    function addToCart(productId, initialQuantity) {
        const addButton = document.getElementById(add-button-${productId});
        const quantityInput = document.getElementById(quantity-${productId});
        const quantityInputContainer = document.getElementById(quantity-input-${productId});

        fetch(/api/cart/add/${productId}, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: initialQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                addButton.style.display = 'none';
                quantityInput.value = initialQuantity;
                quantityInputContainer.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
            });
    }

    function incrementQuantity(productId) {
        const quantityInput = document.getElementById(quantity-${productId});
        let quantity = parseInt(quantityInput.value);
        quantity++;
        quantityInput.value = quantity;
        addToCart(productId, quantity);
    }

    function decrementQuantity(productId) {
        const quantityInput = document.getElementById(quantity-${productId});
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            addToCart(productId, quantity);
        } else {
            removeFromCart(productId);
        }
    }

    function removeFromCart(productId) {
        fetch(/api/cart/remove/product/${productId}, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const addButton = document.getElementById(add-button-${productId});
                const quantityInputContainer = document.getElementById(quantity-input-${productId});
                addButton.style.display = 'block';
                quantityInputContainer.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error removing from cart:', error);
            });
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endpush