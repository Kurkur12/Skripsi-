@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-blue-600">{{ $location->nama_location }}</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Items in this Location</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->kode_barang }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->nama_barang }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->kondisi }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b border-gray-200 text-center">No items found in this location</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        </a>
    </div>
</div>
@endsection