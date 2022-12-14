<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function products()
    {
        return $this->hasMany(Product::class, 'id_merk', 'id');
        // return $this->morphMany(Product::class, 'merk');
    }
}
