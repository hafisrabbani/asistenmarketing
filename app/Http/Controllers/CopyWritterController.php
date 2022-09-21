<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Str;

class CopyWritterController extends Controller
{
    public function index(Request $request)
    {
        return view('writter.copywrite.index', [
            'products' => Product::where('id_writter', $request->session()->get('writterId'))->get()
        ]);
    }

    public function insert()
    {
        return view('writter.copywrite.insert');
    }

    public function insertProduct(int $writterId, array $params): int
    {
        $product = Product::create([
            'id_writter' => $writterId,
            'id_merk' => 1,
            'nama_produk' => $params['name'],
            'slug' => Str::slug($params['name']),
            'deskripsi' => $params['description'],
        ]);

        return $product->id;
    }

    public function insertPost(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|unique:products,nama_produk',
            'description' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png|max:2048'
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah ada',
            'description.required' => 'Deskripsi produk harus diisi',
            'images.required' => 'Gambar produk harus diisi',
            'images.mimes' => 'File yang diupload harus berupa gambar',
            'images.max' => 'Ukuran file yang diupload maksimal 2MB',
        ]);


        $product = $this->insertProduct($request->session()->get('writterId'), [
            'name' => $request->nama_produk,
            'description' => $request->description,
        ]);

        $id = $product;
        // storing and save
        $count = 1;
        foreach ($request->file('images') as $image) {
            $name = Str::slug($request->nama_produk) . '-' . time() . '(' . $count . ').' . $image->extension();
            $image->move(storage_path('/images/product/'), $name);
            Image::create([
                'name' => $name,
                'upload_by' => $request->session()->get('writterId'),
                'id_produk' => $id,
            ]);
            $count++;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
        ]);
    }


    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        $images = Image::where('id_produk', $id)->paginate(10);
        return view('writter.copywrite.edit', [
            'product' => $product,
            'images' => $images,
        ]);
    }

    public function editPost(int $id, Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|unique:products,nama_produk,' . $id,
            'description' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png|max:2048'
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah ada',
            'description.required' => 'Deskripsi produk harus diisi',
            'images.mimes' => 'File yang diupload harus berupa gambar',
            'images.max' => 'Ukuran file yang diupload maksimal 2MB',
        ]);
        $product = Product::where('id', $id)->update([
            'nama_produk' => $request->nama_produk,
            'id_merk' => 1,
            'id_writter' => $request->session()->get('writterId'),
            'slug' => Str::slug($request->nama_produk),
            'deskripsi' => $request->description,
        ]);

        $count = 1;
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $name = Str::slug($request->nama_produk) . '-' . time() . '(' . $count . ').' . $image->extension();
                $image->move(storage_path('/images/product/'), $name);
                Image::create([
                    'name' => $name,
                    'upload_by' => $request->session()->get('writterId'),
                    'id_produk' => $id,
                ]);
                $count++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diubah',
        ]);
    }

    public function deleteImg(Request $request)
    {
        $image = Image::findOrFail($request->id);
        $image->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Gambar berhasil dihapus',
        ]);
    }
}
