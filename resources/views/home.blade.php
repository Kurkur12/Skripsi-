<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="border-b bg-white">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img 
                src="{{ asset('images/sragen.png') }}" 
                alt="Logo Kabupaten Sragen"
                class="h-16 w-auto" 
            />
            <h1 class="text-2xl font-semibold">SD Negeri Keden 2</h1>
        </div>
        <a href="{{ route('filament.admin.auth.login') }}" class="px-4 py-2 border rounded-md hover:bg-gray-100">Login</a>
    </div>
</header>

    <main class="flex-1 container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Asset Management System</h1>
            <p class="text-lg text-gray-600">SD Negeri Keden 2 Sragen</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-2">Record</h2>
                    <p class="text-4xl font-bold text-blue-600">{{ $recordCount }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-2">Maintenance</h2>
                    <p class="text-4xl font-bold text-green-600">{{ $maintenanceCount }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-2">Location</h2>
                    <p class="text-4xl font-bold text-purple-600">{{ $locationCount }}</p>
                </div>
            </div>
        </div>

        <!-- Data Viewer -->
        <div class="bg-white rounded-lg shadow-md mb-12">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Data Viewer</h2>
                <select 
                    id="dataSelector"
                    class="w-full p-3 mb-6 border rounded-md"
                >
                    <option value="" selected disabled>Choose data to view</option>
                    <option value="records">Record</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="locations">Location</option>
                </select>
                <div id="dataContainer" class="overflow-x-auto border rounded-lg p-4 bg-gray-50">
                    <!-- Data will be displayed here -->
                </div>
            </div>
        </div>
    </main>

   <!-- Footer section -->
<footer class="bg-gray-100 border-t">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Kontak Kami</h3>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p>HQ9J+QWG, Kebayanan II, Keden, Kalijambe, Sragen Regency, Central Java 57275</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:sdn_keden2@yahoo.com" class="hover:underline">
                            sdn_keden2@yahoo.com
                        </a>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:088216585143" class="hover:underline">
                            088216585143
                        </a>
                    </div>
                </div>
            </div>
            <div class="h-[300px] rounded-lg overflow-hidden bg-gray-200">
                <!-- Update bagian map di footer -->
                <div class="h-[300px] rounded-lg overflow-hidden bg-gray-200">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.2815742837054!2d110.73722!3d-7.434397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a147659271f45%3A0x7a0d4099c8c5b247!2sHQ9J%2BQWG%2C%20Kebayanan%20II%2C%20Keden%2C%20Kalijambe%2C%20Sragen%20Regency%2C%20Central%20Java%2057275!5e0!3m2!1sen!2sid!4v1709754586044!5m2!1sen!2sid" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</footer>

@push('scripts')
<!-- Make sure to load Leaflet JS after the page content -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
@endpush


<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataSelector = document.getElementById('dataSelector');
    const dataContainer = document.getElementById('dataContainer');

    dataSelector.addEventListener('change', function() {
        const selectedOption = this.value;
        if (selectedOption) {
            fetch(`/get-${selectedOption}`)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left text-sm font-medium text-gray-600 uppercase">
                    `;
                    
                    // Defining headers dynamically based on selection
                    const headers = {
                        'records': ['Code', 'Name', 'Condition', 'Quantity'],
                        'maintenance': ['Kode Barang', 'Nama Barang', 'Kondisi', 'Jumlah', 'Tanggal Maintenance', 'Tanggal Maintenance Selanjutnya'],
                        'locations': ['Nama Location']
                    };
                    
                    headers[selectedOption].forEach(header => {
                        html += `<th class="py-3 px-4 border-b">${header}</th>`;
                    });

                    html += `</tr></thead><tbody>`;
                    
                    if (data.length > 0) {
                        data.forEach(item => {
                            html += `<tr class="hover:bg-gray-50">`;
                            headers[selectedOption].forEach(header => {
                                const key = header.toLowerCase().replace(/ /g, '_'); // Assuming keys match header names
                                if (selectedOption === 'locations' && key === 'nama_location') {
                                    html += `
                                        <td class="py-2 px-4 border-b">
                                            <a href="/location/${item.id}" class="text-blue-600 hover:underline">
                                                ${item[key]}
                                            </a>
                                        </td>
                                    `;
                                } else {
                                    html += `<td class="py-2 px-4 border-b">${item[key]}</td>`;
                                }
                            });
                            html += `</tr>`;
                        });
                    } else {
                        html += `
                            <tr>
                                <td colspan="${headers[selectedOption].length}" class="py-4 px-4 text-center text-gray-500">
                                    No data available
                                </td>
                            </tr>
                        `;
                    }

                    html += `</tbody></table>`;
                    dataContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    dataContainer.innerHTML = `
                        <p class="text-red-500 text-center">Error loading data. Please try again later.</p>
                    `;
                });
        } else {
            dataContainer.innerHTML = '';
        }
    });
});
</script>
@endsection
