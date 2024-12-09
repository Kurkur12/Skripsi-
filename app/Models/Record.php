<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'tbl_record';

    protected $fillable = [
        'code',
        'name',
        'condition',
        'quantity',
        'date_of_entry'
    ];

    protected $casts = [
        'date_of_entry' => 'datetime:Y-m-d',
    ];

    // Pastikan timestamps diset true jika menggunakan created_at dan updated_at
    public $timestamps = true;

    public function register()
    {
        return $this->belongsTo(Register::class, 'code', 'code');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}