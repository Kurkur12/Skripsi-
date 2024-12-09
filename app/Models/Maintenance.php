<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'tbl_maintenance';
    protected $primaryKey = 'id_maintenance';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kondisi',
        'jumlah',
        'tanggal_maintenance',
        'tanggal_maintenance_selanjutnya',
    ];

    protected $casts = [
        'tanggal_maintenance' => 'datetime:Y-m-d',
        'tanggal_maintenance_selanjutnya' => 'datetime:Y-m-d',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function barang()
    {
        return $this->belongsTo(Register::class, 'barang_id');
    }
}