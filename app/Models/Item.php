<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'kode_barang', 'nama_barang', 'kondisi', 'jumlah'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

