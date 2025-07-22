<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        return view('barang.create', compact('nextKodeBarang'));
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

        $data = $request->all();
        
        // Generate kode barang automatically
        $data['kode_barang'] = $this->generateNextKodeBarang();

        // Handle file upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $data['kode_barang']);
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
}
