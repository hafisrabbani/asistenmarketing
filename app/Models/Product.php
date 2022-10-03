<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function merk()
    {
        return $this->belongsTo(Merk::class, 'id_merk', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_produk', 'id');
    }

    public function getFirstImg($id)
    {
        return Image::where('id_produk', $id)->first();
    }

    // public function merk()
    // {
    //     return $this->morphTo();
    // }
}
