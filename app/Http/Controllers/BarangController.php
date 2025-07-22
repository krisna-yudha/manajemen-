<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate next kode barang
        $nextKodeBarang = $this->generateNextKodeBarang();
        
        // Get existing barangs for stock addition option
        $existingBarangs = Barang::select('id', 'kode_barang', 'nama_barang', 'stok')
            ->orderBy('nama_barang')
            ->get();
        
        return view('barang.create', compact('nextKodeBarang', 'existingBarangs'));
    }

    /**
     * Generate next kode barang with format IND + 4 digits
     */
    private function generateNextKodeBarang()
    {
        // Get the latest barang with IND prefix
        $latestBarang = Barang::where('kode_barang', 'LIKE', 'IND%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        if ($latestBarang) {
            // Extract number from the latest code
            $lastNumber = (int) substr($latestBarang->kode_barang, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format with leading zeros to make it 4 digits
        return 'IND' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('add_to_existing') && $request->add_to_existing) {
            return $this->addStockToExisting($request);
        }

        $request->validate([
            'nama_barang' => 'required|max:255|unique:barangs,nama_barang',
            'kategori' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'harga_sewa_per_hari' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:tersedia,tidak_tersedia,maintenance'
        ], [
            'nama_barang.unique' => 'Nama barang sudah ada. Gunakan opsi "Tambah Stok Barang Existing" jika ingin menambah stok untuk barang yang sama.'
        ]);

        $data = $request->all();
        
        // Generate kode barang automatically
        $data['kode_barang'] = $this->generateNextKodeBarang();

        // Handle file upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang = Barang::create($data);

        // Log initial stock
        \App\Models\StockLog::createLog(
            $barang,
            Auth::user(),
            'manual_add',
            0,
            $barang->stok,
            'Barang baru ditambahkan ke inventory'
        );

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $data['kode_barang']);
    }

    /**
     * Add stock to existing item
     */
    private function addStockToExisting(Request $request)
    {
        $request->validate([
            'existing_barang_id' => 'required|exists:barangs,id',
            'additional_stock' => 'required|integer|min:1',
            'stock_reason' => 'required|string|max:500'
        ]);

        $barang = Barang::findOrFail($request->existing_barang_id);
        $oldStok = $barang->stok;
        
        $barang->increment('stok', $request->additional_stock);
        $newStok = $barang->fresh()->stok;

        // Log the stock addition
        \App\Models\StockLog::createLog(
            $barang,
            Auth::user(),
            'manual_add',
            $oldStok,
            $newStok,
            $request->stock_reason
        );

        return redirect()->route('barang.index')
            ->with('success', "Stok barang {$barang->nama_barang} berhasil ditambah {$request->additional_stock} unit. Total stok sekarang: {$newStok}");
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|max:255',
            'kategori' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'harga_sewa_per_hari' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:tersedia,tidak_tersedia,maintenance'
        ]);

        $data = $request->except('kode_barang'); // Exclude kode_barang from update

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        // Delete photo
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }

    /**
     * Display available items for members
     */
    public function available()
    {
        $barangs = Barang::where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->latest()
            ->paginate(12);
            
        return view('barang.available', compact('barangs'));
    }

    /**
     * Adjust stock manually (for gudang only)
     */
    public function adjustStock(Request $request, Barang $barang)
    {
        $request->validate([
            'adjustment_type' => 'required|in:add,subtract',
            'adjustment_amount' => 'required|integer|min:1',
            'adjustment_reason' => 'required|string|max:500'
        ]);

        $oldStok = $barang->stok;
        
        if ($request->adjustment_type === 'add') {
            $barang->increment('stok', $request->adjustment_amount);
            $newStok = $barang->fresh()->stok;
            
            // Log the stock change
            \App\Models\StockLog::createLog(
                $barang,
                Auth::user(),
                'manual_add',
                $oldStok,
                $newStok,
                $request->adjustment_reason
            );
            
            $message = "Stok ditambah {$request->adjustment_amount} unit. Dari {$oldStok} menjadi {$newStok}";
        } else {
            if ($barang->stok < $request->adjustment_amount) {
                return back()->withErrors(['adjustment_amount' => 'Jumlah pengurangan melebihi stok yang tersedia']);
            }
            
            $barang->decrement('stok', $request->adjustment_amount);
            $newStok = $barang->fresh()->stok;
            
            // Log the stock change
            \App\Models\StockLog::createLog(
                $barang,
                Auth::user(),
                'manual_subtract',
                $oldStok,
                $newStok,
                $request->adjustment_reason
            );
            
            $message = "Stok dikurangi {$request->adjustment_amount} unit. Dari {$oldStok} menjadi {$newStok}";
        }
        
        return back()->with('success', $message . ". Alasan: {$request->adjustment_reason}");
    }
}
