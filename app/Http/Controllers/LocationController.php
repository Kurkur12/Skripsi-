<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Item;
use Illuminate\Http\Request;

class LocationController extends Controller
{   
    public function show(Location $location)
    {
        $location->load('items');
        return view('locations.show', compact('location'));
    }

    public function index()
    {
        $locations = Location::all();
        return view('location.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_location' => 'required',
            'items' => 'required|array',
            'items.*.kode_barang' => 'required',
            'items.*.nama_barang' => 'required',
            'items.*.kondisi' => 'required',
            'items.*.jumlah' => 'required|integer',
        ]);

        $location = Location::create([
            'nama_location' => $request->nama_location
        ]);

        foreach ($request->items as $item) {
            $location->items()->create($item);
        }
        
        return redirect()->route('locations.index')->with('success', 'Location added successfully');
    }

    public function getItemInfo(Request $request)
    {
        $kodeBarang = $request->input('kode_barang');
        $item = Item::where('kode_barang', $kodeBarang)->first();

        if ($item) {
            return response()->json([
                'nama_barang' => $item->nama_barang,
                'kondisi' => $item->kondisi,
                'jumlah' => $item->jumlah,
            ]);
        }

        return response()->json([], 404);
    }
}

