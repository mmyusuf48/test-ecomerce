@php
    use App\Models\Product;

    $products = Product::all();

@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="h-48 object-cover">
                        <img class="w-full h-full " src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-700 mb-2">Price: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-gray-700 mb-4">Stock: {{ $product->stock }}</p>
                        <div class=" items-center">
                            <form action="{{ route('cart.store', $product->id) }}" method="post">
                                @csrf
                                <div class="my-3">
                                    <label for="quantity-input" class="block mb-2 text-sm font-medium text-gray-900 ">Choose quantity:</label>
                                    <div class="relative flex items-center w-full">
                                        <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 rounded-s-lg p-3 h-11 border-gray-300 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                            <svg class="w-3 h-3 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity-input" name="qty" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-100 focus:border-blue-100 block w-full py-2.5"  required />
                                        <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 rounded-e-lg p-3 h-11 border-gray-300 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                            <svg class="w-3 h-3 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-3 rounded-md w-full">Add To Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const decrementButton = document.getElementById('decrement-button');
            const incrementButton = document.getElementById('increment-button');
            const quantityInput = document.getElementById('quantity-input');

            decrementButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                if (!isNaN(currentValue) && currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            incrementButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                if (!isNaN(currentValue)) {
                    quantityInput.value = currentValue + 1;
                } else {
                    quantityInput.value = 1;
                }
            });

            quantityInput.addEventListener('input', function () {
                let currentValue = parseInt(quantityInput.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    quantityInput.value = 1;
                }
            });
        });
    </script>
</x-app-layout>
