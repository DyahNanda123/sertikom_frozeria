<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    // nama tabel
    protected $table = 'barang';

    // Primary key
    protected $primaryKey = 'id';

    protected $keyType = 'int';
    public $incrementing = true;

    // Kolom yang tidak boleh diisi manual
    protected $guarded = ['id'];

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        // foreign key: kategori_id, owner key: id
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}