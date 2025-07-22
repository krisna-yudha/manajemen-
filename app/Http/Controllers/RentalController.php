<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'manager' || $user->role === 'gudang') {
            // Manager dan Gudang bisa lihat semua rental
            $rentals = Rental::with(['user', 'barang', 'approver'])
                ->latest()
                ->paginate(10);
        } else {
            // Member hanya bisa lihat rental sendiri
            $rentals = Rental::with(['barang', 'approver'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }
        
        return view('rental.index', compact('rentals'));
    }

    /**
     * Show pending rentals for approval
     */
    public function pending()
    {
        $pendingRentals = Rental::with(['user', 'barang'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('rental.pending', compact('pendingRentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya tampilkan barang yang benar-benar tersedia untuk dipinjam
        $barangs = Barang::where('status', 'tersedia')
            ->where('kondisi', 'baik')
            ->where('stok', '>', 0)
            ->get()
            ->filter(function($barang) {
                return $barang->stok_tersedia > 0;
            });
            
        return view('rental.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500'
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        
        // Check stok tersedia
        if ($request->jumlah > $barang->stok_tersedia) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok_tersedia]);
        }

        // Calculate total cost
        $days = Carbon::parse($request->tanggal_pinjam)->diffInDays(Carbon::parse($request->tanggal_kembali_rencana)) + 1;
        $total_biaya = $barang->harga_sewa_per_hari ? $barang->harga_sewa_per_hari * $request->jumlah * $days : 0;

        Rental::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keperluan' => $request->keperluan,
            'total_biaya' => $total_biaya,
            'status' => 'pending'
        ]);

        return redirect()->route('rental.index')
            ->with('success', 'Permohonan rental berhasil diajukan dan menunggu approval');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        // Check authorization
        $user = Auth::user();
        if ($user->role !== 'manager' && $user->role !== 'gudang' && $rental->user_id !== $user->id) {
            abort(403);
        }

        return view('rental.show', compact('rental'));
    }

    /**
     * Approve rental
     */
    public function approve(Request $request, Rental $rental)
    {
        $request->validate([
            'catatan_approval' => 'nullable|string|max:500'
        ]);

        $barang = $rental->barang;
        
        // Check stok masih tersedia
        if ($rental->jumlah > $barang->stok_tersedia) {
            return back()->withErrors(['error' => 'Stok tidak mencukupi saat ini']);
        }

        $rental->update([
            'status' => 'approved',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
            'catatan_admin' => $request->catatan_approval
        ]);

        return redirect()->route('rental.pending.gudang')
            ->with('success', 'Rental telah diapprove');
    }

    /**
     * Reject rental
     */
    public function reject(Request $request, Rental $rental)
    {
        $request->validate([
            'catatan_approval' => 'required|string|max:500'
        ]);

        $rental->update([
            'status' => 'rejected',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
            'catatan_admin' => $request->catatan_approval
        ]);

        return redirect()->route('rental.pending.gudang')
            ->with('success', 'Rental telah ditolak');
    }

    /**
     * Start rental (change to ongoing)
     */
    public function start(Rental $rental)
    {
        if ($rental->status !== 'approved') {
            return back()->withErrors(['error' => 'Rental belum diapprove']);
        }

        // Kurangi stok barang saat rental dimulai
        $barang = $rental->barang;
        if ($barang->stok < $rental->jumlah) {
            return back()->withErrors(['error' => 'Stok tidak mencukupi untuk memulai rental']);
        }

        // Update stok dan status rental
        $oldStok = $barang->stok;
        $barang->decrement('stok', $rental->jumlah);
        $newStok = $barang->fresh()->stok;
        
        // Log stock change
        \App\Models\StockLog::createLog(
            $barang,
            \Illuminate\Support\Facades\Auth::user(),
            'rental_out',
            $oldStok,
            $newStok,
            "Rental dimulai untuk #{$rental->kode_rental}",
            ['rental_id' => $rental->id]
        );
        
        $rental->update(['status' => 'ongoing']);

        return redirect()->route('rental.index')
            ->with('success', 'Rental dimulai dan stok telah dikurangi');
    }

    /**
     * Mark rental as taken (change to ongoing)
     */
    public function take(Rental $rental)
    {
        if ($rental->status !== 'approved') {
            return back()->withErrors(['error' => 'Rental belum diapprove']);
        }

        // Kurangi stok barang saat barang diambil
        $barang = $rental->barang;
        if ($barang->stok < $rental->jumlah) {
            return back()->withErrors(['error' => 'Stok tidak mencukupi untuk diambil']);
        }

        // Update stok dan status rental
        $oldStok = $barang->stok;
        $barang->decrement('stok', $rental->jumlah);
        $newStok = $barang->fresh()->stok;
        
        // Log stock change
        \App\Models\StockLog::createLog(
            $barang,
            \Illuminate\Support\Facades\Auth::user(),
            'rental_out',
            $oldStok,
            $newStok,
            "Barang diambil untuk rental #{$rental->kode_rental}",
            ['rental_id' => $rental->id]
        );
        
        $rental->update(['status' => 'ongoing']);

        return redirect()->route('rental.show', $rental)
            ->with('success', 'Barang telah dikonfirmasi diambil dan stok telah dikurangi');
    }

    /**
     * Return rental
     */
    public function return(Request $request, Rental $rental)
    {
        $request->validate([
            'kondisi_kembali' => 'required|string|max:500',
            'denda' => 'nullable|numeric|min:0'
        ]);

        // Kembalikan stok barang saat dikembalikan
        $barang = $rental->barang;
        $oldStok = $barang->stok;
        $barang->increment('stok', $rental->jumlah);
        $newStok = $barang->fresh()->stok;
        
        // Log stock return
        \App\Models\StockLog::createLog(
            $barang,
            \Illuminate\Support\Facades\Auth::user(),
            'rental_return',
            $oldStok,
            $newStok,
            "Barang dikembalikan dari rental #{$rental->kode_rental}",
            ['rental_id' => $rental->id, 'kondisi_kembali' => $request->kondisi_kembali]
        );

        // Update kondisi barang berdasarkan kondisi pengembalian
        $kondisi_kembali = strtolower($request->kondisi_kembali);
        $updated_kondisi = $barang->kondisi;
        $updated_status = $barang->status;
        
        if (strpos($kondisi_kembali, 'rusak') !== false) {
            $updated_kondisi = 'rusak';
            $updated_status = 'tidak_tersedia';
        } elseif (strpos($kondisi_kembali, 'maintenance') !== false || 
                  strpos($kondisi_kembali, 'perbaikan') !== false ||
                  strpos($kondisi_kembali, 'service') !== false) {
            $updated_kondisi = 'maintenance';
            $updated_status = 'maintenance';
        } elseif (strpos($kondisi_kembali, 'baik') !== false || 
                  strpos($kondisi_kembali, 'normal') !== false) {
            $updated_kondisi = 'baik';
            $updated_status = 'tersedia';
        }

        // Update barang condition if needed
        if ($updated_kondisi !== $barang->kondisi || $updated_status !== $barang->status) {
            $barang->update([
                'kondisi' => $updated_kondisi,
                'status' => $updated_status,
                'catatan_maintenance' => $request->kondisi_kembali
            ]);
        }

        $rental->update([
            'status' => 'returned',
            'tanggal_kembali_aktual' => now()->toDateString(),
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $request->denda ?? 0
        ]);

        $kondisiMessage = '';
        if ($updated_kondisi === 'rusak') {
            $kondisiMessage = ' Barang ditandai sebagai RUSAK dan tidak tersedia untuk dipinjam.';
        } elseif ($updated_kondisi === 'maintenance') {
            $kondisiMessage = ' Barang memerlukan MAINTENANCE sebelum dapat dipinjam kembali.';
        }

        return redirect()->route('rental.index')
            ->with('success', 'Barang telah dikembalikan dan stok telah ditambahkan kembali.' . $kondisiMessage);
    }
}
