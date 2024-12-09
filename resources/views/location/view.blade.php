@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-purple-600">{{ $location->nama_location }}</h1>

    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-purple-500 text-white">
                    <th class="px-4 py-2">Kode Barang</th>
                    <th class="px-4 py-2">Nama Barang</th>
                    <th class="px-4 py-2">Kondisi</th>
                    <th class="px-4 py-2">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2 text-center align-middle">{{ $item->kode_barang }}</td>
                    <td class="px-4 py-2 text-center align-middle">{{ $item->nama_barang }}</td>
                    <td class="px-4 py-2 text-center align-middle">{{ $item->kondisi }}</td>
                    <td class="px-4 py-2 text-center align-middle">{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('home') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Back to Home</a>
</div>
@endsection