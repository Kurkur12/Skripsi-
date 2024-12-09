<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Register;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function records()
{
    $records = Record::paginate(15); // Menampilkan 15 item per halaman
    return view('records', compact('records'));
}
    public function index()
    {
        $records = Record::all();
        return view('record.index', compact('records'));
    }

    public function create()
    {
        // Hanya ambil item dengan kondisi 'Baik'
        $items = Register::where('condition', 'Baik')->get();
        return view('record.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|exists:tbl_register,code',
        ]);

        // Ambil data dari Register
        $registerItem = Register::where('code', $validated['code'])->first();
        
        if (!$registerItem) {
            return back()->with('error', 'Item tidak ditemukan.');
        }

        // Buat record baru dengan data dari Register
        $record = new Record();
        $record->code = $registerItem->code;
        $record->name = $registerItem->name;
        $record->condition = 'Baik'; // Set default ke 'Baik'
        $record->quantity = $registerItem->quantity;
        $record->date_of_entry = now();
        
        $record->save();

        return redirect()->route('record.index')->with('success', 'Record created successfully.');
    }
}