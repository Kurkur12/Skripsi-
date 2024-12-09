<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    public function maintenance()
{
    $maintenanceItems = Maintenance::paginate(15); // Menampilkan 15 item per halaman
    return view('maintenance', compact('maintenanceItems'));
}
    public function index()
{
    $maintenances = Maintenance::all();
    return view('maintenance.index', compact('maintenances'));
}

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_maintenance' => 'required|date',
            'maintenance_selanjutnya' => 'required|date',
        ]);

        Maintenance::create($request->all());

        return redirect()->route('maintenance.index')->with('success', 'Item added successfully.');
    }
}