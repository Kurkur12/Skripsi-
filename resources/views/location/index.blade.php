<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Location Management</h1>

        <button id="showFormBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
            Add Location
        </button>

        <div id="locationForm" class="hidden bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_location">
                        Nama Location
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_location" type="text" name="nama_location" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_barang">
                        Kode Barang
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kode_barang" type="text" name="kode_barang" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_barang">
                        Nama Barang
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_barang" type="text" name="nama_barang" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kondisi">
                        Kondisi
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kondisi" type="text" name="kondisi" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                        Quantity
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="quantity" type="number" name="quantity" required>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Add Location
                    </button>
                </div>
            </form>
        </div>

        <table class="w-full bg-white shadow-md rounded mb-4">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nama Location</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($locations as $location)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $location->id_location }}</td>
                    <td class="py-3 px-6 text-left">{{ $location->nama_location }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const showFormBtn = document.getElementById('showFormBtn');
        const locationForm = document.getElementById('locationForm');

        showFormBtn.addEventListener('click', () => {
            locationForm.classList.toggle('hidden');
            locationForm.classList.add('transition', 'duration-300', 'ease-in-out');
            
            if (locationForm.classList.contains('hidden')) {
                locationForm.classList.remove('opacity-100', 'scale-100');
                locationForm.classList.add('opacity-0', 'scale-95');
            } else {
                locationForm.classList.remove('opacity-0', 'scale-95');
                locationForm.classList.add('opacity-100', 'scale-100');
            }
        });
    </script>
</body>
</html>