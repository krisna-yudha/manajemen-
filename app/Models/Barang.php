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
        'status',
        'catatan_maintenance'
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
        return $this->status === 'tersedia' && $this->kondisi === 'baik' && $this->stok > 0;
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
     * Get stok tersedia untuk dipinjam (tidak termasuk yang sedang maintenance/rusak)
     */
    public function getStokTersediaAttribute()
    {
        // Stok tersedia adalah stok fisik dikurangi yang sedang dipinjam
        // Dan hanya tersedia jika status barang tersedia dan kondisi baik
        if ($this->status !== 'tersedia' || $this->kondisi !== 'baik') {
            return 0;
        }
        
        return max(0, $this->stok - $this->stok_dipinjam);
    }

    /**
     * Get status ketersediaan untuk rental
     */
    public function getRentalStatusAttribute()
    {
        if ($this->kondisi === 'rusak') {
            return 'Rusak - Tidak dapat dipinjam';
        }
        
        if ($this->kondisi === 'maintenance') {
            return 'Dalam Maintenance';
        }
        
        if ($this->status === 'maintenance') {
            return 'Sedang Maintenance';
        }
        
        if ($this->status === 'tidak_tersedia') {
            return 'Tidak Tersedia';
        }
        
        if ($this->stok_tersedia <= 0) {
            return 'Stok Habis';
        }
        
        return 'Tersedia untuk dipinjam';
    }
}
