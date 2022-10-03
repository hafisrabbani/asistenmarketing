<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Merk;

class MerkController extends Controller
{
    public function index()
    {
        $merks = Merk::all();
        return view('writter.merk', [
            'merks' => $merks
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:merks,name'
        ], [
            'name.required' => 'Nama merk harus diisi',
            'name.unique' => 'Nama merk sudah ada'
        ]);

        Merk::create([
            'name' => $request->name
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Merk berhasil ditambahkan'
        ]);
    }

    public function delete()
    {
        $id = request()->validate([
            'id' => 'required|integer'
        ]);

        $merk = Merk::find($id['id']);
        if ($merk->products->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Merk tidak dapat dihapus karena masih memiliki produk'
            ], 400);
        }

        $merk->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Merk berhasil dihapus'
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->validate([
            'id' => 'required|integer'
        ], [
            'id.required' => 'ID merk harus diisi',
            'id.integer' => 'ID merk harus berupa angka'
        ]);

        $merk = Merk::find($id['id']);
        $merk->name = $request->name;
        $merk->save();
        return response()->json([
            'status' => 'success',
            'data' => $merk
        ]);
    }
}
