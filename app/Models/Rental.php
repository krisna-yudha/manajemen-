<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rental',
        'user_id',
        'barang_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'tanggal_disetujui',
        'tanggal_diambil',
        'keperluan',
        'catatan',
        'status',
        'catatan_admin',
        'catatan_approval',
        'disetujui_oleh',
        'approved_by',
        'approved_at',
        'total_biaya',
        'kondisi_kembali',
        'denda'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'approved_at' => 'datetime',
        'total_biaya' => 'decimal:2',
        'denda' => 'decimal:2',
    ];

    /**
     * Relasi ke user (peminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Relasi ke user yang approve
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    /**
     * Check jika rental overdue
     */
    public function isOverdue()
    {
        return $this->status === 'ongoing' && 
               Carbon::now()->gt($this->tanggal_kembali_rencana);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800',
            'ongoing' => 'bg-green-100 text-green-800',
            'returned' => 'bg-gray-100 text-gray-800',
            'overdue' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get duration in days
     */
    public function getDurationAttribute()
    {
        return $this->tanggal_pinjam->diffInDays($this->tanggal_kembali_rencana) + 1;
    }

    /**
     * Auto generate kode rental
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rental) {
            if (empty($rental->kode_rental)) {
                $rental->kode_rental = 'RNT' . date('Ymd') . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
