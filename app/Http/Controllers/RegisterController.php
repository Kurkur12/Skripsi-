<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Menampilkan daftar semua register
    public function index()
    {
        $registers = Register::all();
        return response()->json($registers);
    }

    // Menampilkan form untuk membuat register baru
    public function create()
    {
        // Biasanya digunakan untuk menampilkan form, tidak perlu diimplementasikan untuk API
    }

    // Menyimpan register baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'condition' => 'required',
            'quantity' => 'required|integer',
            'date_of_entry' => 'required|date',
        ]);

        $register = Register::create($request->all());
        return response()->json($register, 201);
    }

    // Menampilkan register berdasarkan ID
    public function show($id)
    {
        $register = Register::findOrFail($id);
        return response()->json($register);
    }

    // Menampilkan form untuk mengedit register
    public function edit($id)
    {
        // Biasanya digunakan untuk menampilkan form edit, tidak perlu diimplementasikan untuk API
    }

    // Mengupdate register yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'condition' => 'required',
            'quantity' => 'required|integer',
            'date_of_entry' => 'required|date',
        ]);

        $register = Register::findOrFail($id);
        $register->update($request->all());
        return response()->json($register);
    }

    // Menghapus register berdasarkan ID
    public function destroy($id)
    {
        $register = Register::findOrFail($id);
        $register->delete();
        return response()->json(null, 204);
    }
}
