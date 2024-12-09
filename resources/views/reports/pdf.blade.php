<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        h1 { color: #2c3e50; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .report-info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="report-info">
        <p><strong>Periode:</strong> {{ $startDate }} - {{ $endDate }}</p>
        <p><strong>Jenis Filter:</strong> {{ ucfirst(str_replace('_', ' ', $filterType)) }}</p>
    </div>
    <table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            @if($reportType === 'maintenance')
                <th>Tanggal Maintenance Selanjutnya</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item['kode'] }}</td>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ $item['kondisi'] }}</td>
                <td>{{ $item['jumlah'] ?? '-' }}</td>
                <td>{{ $item['tanggal'] }}</td>
                @if($reportType === 'maintenance')
                    <td>{{ $item['tanggal_next'] }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
    <footer>
        <p>Generated on {{ date('Y-m-d H:i:s') }}</p>
    </footer>
</body>
</html>