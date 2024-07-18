<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <div class="my-4">
                    <a href="{{ route('product.create') }}" class="py-2 px-8 bg-cyan-500 hover:bg-cyan-600 text-white rounded-sm">Create</a>
                </div>
                <table class="table-auto w-full border-collapse rounded-md">
                    <thead>
                        <tr class="bg-teal-400 text-white">
                            <th class="border px-4 py-2">Image</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Code</th>
                            <th class="border px-4 py-2">Price</th>
                            <th class="border px-4 py-2">Stock</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="bg-white">
                                <td class="border px-4 py-2 flex justify-center">
                                    <img class="w-24" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                                </td>
                                <td class="border px-4 py-2 text-center">{{ $product->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $product->code }}</td>
                                <td class="border px-4 py-2 text-center">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2 text-center">{{ $product->stock }} pcs</td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('product.edit', $product->id) }}" class="bg-amber-400 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
                                            Edit
                                        </a>

                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
