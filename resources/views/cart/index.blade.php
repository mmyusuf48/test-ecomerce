<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">PRODUK</th>
                            <th class="py-2 text-left">PILIHAN HARGA</th>
                            <th class="py-2 text-left">KUANTITAS</th>
                            <th class="py-2 text-left">SUBTOTAL</th>
                            <th class="py-2 text-left">HAPUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $carts as $cart )
                            <tr class="border-b">
                                <td class="py-2">
                                    <div class="flex items-center">
                                        <img src="{{ asset('images/' . $cart->product->image) }}" alt="Product 1" class="w-20 h-20 mr-4">
                                        <div>
                                            <div>{{ $cart->product->name }}</div>
                                            <div class="text-gray-500">{{ $cart->product->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                                <td class="py-2">
                                    <div class="flex items-center">
                                        <form action="{{ route('cart.incrementDecrement', $cart->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="type" value="minus">
                                            <button type="submit" class="bg-gray-100 p-1 rounded-l">-</button>
                                        </form>
                                        <input type="number" value="{{ $cart->qty }}" class="w-12 text-center border-0">
                                        <form action="{{ route('cart.incrementDecrement', $cart->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="type" value="plus">
                                            <button class="bg-gray-100 p-1 rounded-r">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-2">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</td>
                                <td class="py-2 text-red-600 cursor-pointer">
                                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">X</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="py-2 text-right">
                                <div class="flex gap-4">
                                    <div id="open-modal" class="text-green-600 cursor-pointer">
                                        Gunakan Kode Diskon/Reward
                                    </div>
                                    <div class="">
                                        {{ $discountCode }}
                                    </div>
                                </div>
                                <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                        </div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                            <form action="{{ route('cart') }}" method="GET">
                                                @csrf
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                                Kode Diskon/Reward
                                                            </h3>
                                                            <div class="mt-2">
                                                                <input type="text" name="kode" id="discount-code" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan Kode Di Sini">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <button id="close-modal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Tutup
                                                    </button>
                                                    <button id="apply-discount" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Terapkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td colspan="4" class="py-2 text-right">DISKON</td>
                            <td class="py-2 text-right">
                                {{--  {{ $diskon }}  --}}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td colspan="4" class="py-2 text-right">TOTAL</td>
                            <td class="py-2 text-right">{{ $grandTotal }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal');
            const openModalButton = document.getElementById('open-modal');
            const closeModalButton = document.getElementById('close-modal');
            const applyDiscountButton = document.getElementById('apply-discount');

            openModalButton.addEventListener('click', function () {
                modal.classList.remove('hidden');
                modal.classList.add('block');
            });

            closeModalButton.addEventListener('click', function () {
                modal.classList.remove('block');
                modal.classList.add('hidden');
            });

            applyDiscountButton.addEventListener('click', function () {
                const discountCode = document.getElementById('discount-code').value;
                console.log(discountCode);

                modal.classList.remove('block');
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
