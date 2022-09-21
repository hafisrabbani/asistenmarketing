<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id');
    }

    public function writter()
    {
        return $this->belongsTo(Writter::class, 'upload_by', 'id');
    }
}
