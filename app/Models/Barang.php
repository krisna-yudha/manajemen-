<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'kategori',
        'stok',
        'stok_minimum',
        'kondisi',
        'lokasi_penyimpanan',
        'harga_sewa_per_hari',
        'foto',
        'status'
    ];

    protected $casts = [
        'harga_sewa_per_hari' => 'decimal:2',
    ];

    /**
     * Relasi ke rental
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Check jika stok low
     */
    public function isLowStock()
    {
        return $this->stok <= $this->stok_minimum;
    }

    /**
     * Check jika barang tersedia
     */
    public function isAvailable()
    {
        return $this->status === 'tersedia' && $this->stok > 0;
    }

    /**
     * Get stok yang sedang dipinjam
     */
    public function getStokDipinjamAttribute()
    {
        return $this->rentals()
            ->whereIn('status', ['approved', 'ongoing'])
            ->sum('jumlah');
    }

    /**
     * Get stok tersedia untuk dipinjam
     */
    public function getStokTersediaAttribute()
    {
        return $this->stok - $this->stok_dipinjam;
    }
}
