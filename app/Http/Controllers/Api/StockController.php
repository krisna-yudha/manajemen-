<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Get stock logs
     */
    public function logs(Request $request)
    {
        $query = StockLog::with(['barang', 'user']);

        // Filter by barang
        if ($request->has('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Date range filter
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        $logs->getCollection()->transform(function ($log) {
            return [
                'id' => $log->id,
                'barang' => [
                    'id' => $log->barang->id,
                    'kode_barang' => $log->barang->kode_barang,
                    'nama_barang' => $log->barang->nama_barang
                ],
                'user' => [
                    'id' => $log->user->id,
                    'name' => $log->user->name
                ],
                'type' => $log->type,
                'jumlah' => $log->jumlah,
                'stok_sebelum' => $log->stok_sebelum,
                'stok_sesudah' => $log->stok_sesudah,
                'keterangan' => $log->keterangan,
                'created_at' => $log->created_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $logs
        ]);
    }

    /**
     * Adjust stock
     */
    public function adjust(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer',
            'type' => 'required|in:addition,reduction,adjustment',
            'keterangan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $barang = Barang::find($request->barang_id);
        $stokSebelum = $barang->stok;

        // Calculate new stock based on type
        switch ($request->type) {
            case 'addition':
                $stokBaru = $stokSebelum + abs($request->jumlah);
                break;
            case 'reduction':
                $stokBaru = max(0, $stokSebelum - abs($request->jumlah));
                break;
            case 'adjustment':
                $stokBaru = abs($request->jumlah);
                break;
        }

        // Update stock
        $barang->update(['stok' => $stokBaru]);

        // Create stock log
        StockLog::create([
            'barang_id' => $barang->id,
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'jumlah' => $request->jumlah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokBaru,
            'keterangan' => $request->keterangan
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Stock adjusted successfully',
            'data' => [
                'barang_id' => $barang->id,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokBaru,
                'selisih' => $stokBaru - $stokSebelum,
                'type' => $request->type
            ]
        ]);
    }

    /**
     * Get low stock items
     */
    public function lowStock()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->get();

        $barangs->transform(function ($barang) {
            return [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'stok' => $barang->stok,
                'stok_minimum' => $barang->stok_minimum,
                'lokasi' => $barang->lokasi
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $barangs,
            'total' => $barangs->count(),
            'message' => $barangs->count() > 0 ? 'Found items with low stock' : 'No items with low stock'
        ]);
    }
}
