<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    /**
     * Get all rentals with pagination and filters
     */
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'barang']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user (for admin)
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('barang', function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $rentals = $query->paginate($perPage);

        // Transform data
        $rentals->getCollection()->transform(function ($rental) {
            return [
                'id' => $rental->id,
                'user' => [
                    'id' => $rental->user->id,
                    'name' => $rental->user->name,
                    'email' => $rental->user->email
                ],
                'barang' => [
                    'id' => $rental->barang->id,
                    'kode_barang' => $rental->barang->kode_barang,
                    'nama_barang' => $rental->barang->nama_barang,
                    'kategori' => $rental->barang->kategori
                ],
                'jumlah' => $rental->jumlah,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'tanggal_kembali_aktual' => $rental->tanggal_kembali_aktual,
                'status' => $rental->status,
                'catatan' => $rental->catatan,
                'created_at' => $rental->created_at,
                'updated_at' => $rental->updated_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $rentals
        ]);
    }

    /**
     * Get user's own rentals
     */
    public function myRentals(Request $request)
    {
        $query = Rental::with(['barang'])
            ->where('user_id', $request->user()->id);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->orderBy('created_at', 'desc')->get();

        $rentals->transform(function ($rental) {
            return [
                'id' => $rental->id,
                'barang' => [
                    'id' => $rental->barang->id,
                    'kode_barang' => $rental->barang->kode_barang,
                    'nama_barang' => $rental->barang->nama_barang,
                    'kategori' => $rental->barang->kategori,
                    'foto' => $rental->barang->foto ? asset('storage/' . $rental->barang->foto) : null
                ],
                'jumlah' => $rental->jumlah,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'tanggal_kembali_aktual' => $rental->tanggal_kembali_aktual,
                'status' => $rental->status,
                'catatan' => $rental->catatan,
                'created_at' => $rental->created_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $rentals,
            'total' => $rentals->count()
        ]);
    }

    /**
     * Get pending rentals
     */
    public function pending()
    {
        $rentals = Rental::with(['user', 'barang'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        $rentals->transform(function ($rental) {
            return [
                'id' => $rental->id,
                'user' => [
                    'id' => $rental->user->id,
                    'name' => $rental->user->name,
                    'email' => $rental->user->email
                ],
                'barang' => [
                    'id' => $rental->barang->id,
                    'kode_barang' => $rental->barang->kode_barang,
                    'nama_barang' => $rental->barang->nama_barang,
                    'stok' => $rental->barang->stok
                ],
                'jumlah' => $rental->jumlah,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'catatan' => $rental->catatan,
                'created_at' => $rental->created_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $rentals,
            'total' => $rentals->count()
        ]);
    }

    /**
     * Create new rental
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check stock availability
        $barang = Barang::find($request->barang_id);
        if ($barang->stok < $request->jumlah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock',
                'available_stock' => $barang->stok
            ], 400);
        }

        $rental = Rental::create([
            'user_id' => $request->user()->id,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        $rental->load(['barang']);

        return response()->json([
            'status' => 'success',
            'message' => 'Rental request created successfully',
            'data' => [
                'id' => $rental->id,
                'barang' => [
                    'id' => $rental->barang->id,
                    'kode_barang' => $rental->barang->kode_barang,
                    'nama_barang' => $rental->barang->nama_barang
                ],
                'jumlah' => $rental->jumlah,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'status' => $rental->status,
                'created_at' => $rental->created_at
            ]
        ], 201);
    }

    /**
     * Update rental status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,ongoing,returned,rejected',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $rental = Rental::with(['barang'])->find($id);

        if (!$rental) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rental not found'
            ], 404);
        }

        $oldStatus = $rental->status;
        $newStatus = $request->status;

        // Handle stock changes based on status transitions
        if ($oldStatus === 'pending' && $newStatus === 'approved') {
            // Reduce stock when approved
            $rental->barang->decrement('stok', $rental->jumlah);
        } elseif ($oldStatus === 'approved' && $newStatus === 'ongoing') {
            // No stock change needed
        } elseif (in_array($oldStatus, ['approved', 'ongoing']) && $newStatus === 'returned') {
            // Return stock when returned
            $rental->barang->increment('stok', $rental->jumlah);
            $rental->tanggal_kembali_aktual = now();
        } elseif ($oldStatus === 'pending' && $newStatus === 'rejected') {
            // No stock change needed
        }

        $rental->update([
            'status' => $newStatus,
            'catatan' => $request->catatan ?? $rental->catatan
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rental status updated successfully',
            'data' => [
                'id' => $rental->id,
                'status' => $rental->status,
                'previous_status' => $oldStatus,
                'updated_at' => $rental->updated_at
            ]
        ]);
    }

    /**
     * Get single rental
     */
    public function show($id)
    {
        $rental = Rental::with(['user', 'barang'])->find($id);

        if (!$rental) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rental not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $rental->id,
                'user' => [
                    'id' => $rental->user->id,
                    'name' => $rental->user->name,
                    'email' => $rental->user->email
                ],
                'barang' => [
                    'id' => $rental->barang->id,
                    'kode_barang' => $rental->barang->kode_barang,
                    'nama_barang' => $rental->barang->nama_barang,
                    'kategori' => $rental->barang->kategori,
                    'foto' => $rental->barang->foto ? asset('storage/' . $rental->barang->foto) : null
                ],
                'jumlah' => $rental->jumlah,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'tanggal_kembali_aktual' => $rental->tanggal_kembali_aktual,
                'status' => $rental->status,
                'catatan' => $rental->catatan,
                'created_at' => $rental->created_at,
                'updated_at' => $rental->updated_at
            ]
        ]);
    }
}
