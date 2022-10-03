<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{

    protected $keyword;

    public function index()
    {
        return view('clients.index');
    }

    public function test()
    {
        $products = Product::find(1);
        // return $products;
        dd($products->images);
    }

    public function query(Request $request)
    {
        $data = $request->validate([
            'keyword' => 'required|string'
        ]);

        $data = Product::where('nama_produk', 'like', '%' . $data['keyword'] . '%')
            ->orWhere('deskripsi', 'like', '%' . $data['keyword'] . '%')
            ->get();
        $res = [];
        if (!empty($data)) {
            foreach ($data as $d) {
                $res[] = [
                    'id' => $d->id,
                    'nama_produk' => $d->nama_produk,
                    'deskripsi' => substr($d->deskripsi, 0, 200),
                    'image' => $d->getFirstImg($d->id)->name
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $res
        ]);
    }

    public function detail($id)
    {
        $product = Product::where([
            'id' => $id
        ])->firstOrFail();
        return view('clients.detail', [
            'product' => $product
        ]);
    }

    public function searchIndex($name = null)
    {
        $data = NULL;
        if ($name != NULL) {
            $data = Product::where('nama_produk', 'like', '%' . $name . '%')
                ->orWhere('deskripsi', 'like', '%' . $name . '%')
                ->get();
        }

        return view('clients.search', [
            'data' => $data
        ]);
    }
}
