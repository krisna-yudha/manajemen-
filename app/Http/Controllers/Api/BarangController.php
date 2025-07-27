<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Get all barang with pagination and filters
     */
    public function index(Request $request)
    {
        $query = Barang::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by availability
        if ($request->has('available')) {
            if ($request->available === 'true') {
                $query->where('stok', '>', 0);
            } elseif ($request->available === 'false') {
                $query->where('stok', '<=', 0);
            }
        }

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock === 'true') {
            $query->where('stok', '>', 0)->where('stok', '<=', 5);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $barangs = $query->paginate($perPage);

        // Transform data
        $barangs->getCollection()->transform(function ($barang) {
            return [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'deskripsi' => $barang->deskripsi,
                'stok' => $barang->stok,
                'stok_minimum' => $barang->stok_minimum,
                'lokasi' => $barang->lokasi,
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
                'availability' => $barang->stok <= 0 ? 'unavailable' : ($barang->stok <= 5 ? 'low_stock' : 'available'),
                'created_at' => $barang->created_at,
                'updated_at' => $barang->updated_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $barangs
        ]);
    }

    /**
     * Get available barang only
     */
    public function available(Request $request)
    {
        $query = Barang::where('stok', '>', 0);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $barangs = $query->orderBy('nama_barang')->get();

        $barangs->transform(function ($barang) {
            return [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'deskripsi' => $barang->deskripsi,
                'stok' => $barang->stok,
                'lokasi' => $barang->lokasi,
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
                'availability' => $barang->stok <= 5 ? 'low_stock' : 'available'
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $barangs,
            'total' => $barangs->count()
        ]);
    }

    /**
     * Get all categories
     */
    public function categories()
    {
        $categories = Barang::distinct()->pluck('kategori')->filter()->sort()->values();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Get single barang
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'deskripsi' => $barang->deskripsi,
                'stok' => $barang->stok,
                'stok_minimum' => $barang->stok_minimum,
                'lokasi' => $barang->lokasi,
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
                'availability' => $barang->stok <= 0 ? 'unavailable' : ($barang->stok <= 5 ? 'low_stock' : 'available'),
                'created_at' => $barang->created_at,
                'updated_at' => $barang->updated_at
            ]
        ]);
    }

    /**
     * Create new barang
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|string|max:50|unique:barangs',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['kode_barang', 'nama_barang', 'kategori', 'deskripsi', 'stok', 'stok_minimum', 'lokasi']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('barangs', $filename, 'public');
            $data['foto'] = 'barangs/' . $filename;
        }

        $barang = Barang::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang created successfully',
            'data' => [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'deskripsi' => $barang->deskripsi,
                'stok' => $barang->stok,
                'stok_minimum' => $barang->stok_minimum,
                'lokasi' => $barang->lokasi,
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
                'created_at' => $barang->created_at
            ]
        ], 201);
    }

    /**
     * Update barang
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['kode_barang', 'nama_barang', 'kategori', 'deskripsi', 'stok', 'stok_minimum', 'lokasi']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('barangs', $filename, 'public');
            $data['foto'] = 'barangs/' . $filename;
        }

        $barang->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang updated successfully',
            'data' => [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'deskripsi' => $barang->deskripsi,
                'stok' => $barang->stok,
                'stok_minimum' => $barang->stok_minimum,
                'lokasi' => $barang->lokasi,
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
                'updated_at' => $barang->updated_at
            ]
        ]);
    }

    /**
     * Delete barang
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang not found'
            ], 404);
        }

        // Delete foto
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang deleted successfully'
        ]);
    }
}
