<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'user_id',
        'type',
        'quantity_before',
        'quantity_after',
        'quantity_changed',
        'reason',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    /**
     * Relationship to Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create stock log entry
     */
    public static function createLog($barang, $user, $type, $quantityBefore, $quantityAfter, $reason = null, $metadata = null)
    {
        return self::create([
            'barang_id' => $barang->id,
            'user_id' => $user->id,
            'type' => $type,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'quantity_changed' => $quantityAfter - $quantityBefore,
            'reason' => $reason,
            'metadata' => $metadata
        ]);
    }
}
