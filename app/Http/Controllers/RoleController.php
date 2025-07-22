<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    /**
     * Display dashboard based on user role - redirect to role-specific dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Redirect to role-specific dashboard
        switch ($user->role) {
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'gudang':
                return redirect()->route('gudang.dashboard');
            case 'member':
                return redirect()->route('member.dashboard');
            default:
                // Fallback for users without role
                return redirect()->route('member.dashboard');
        }
    }

    /**
     * Display manager dashboard (only for manager)
     */
    public function managerDashboard()
    {
        $totalUsers = \App\Models\User::count();
        $activeRentals = \App\Models\Rental::where('status', 'active')->count();
        $totalBarang = \App\Models\Barang::count();
        $pendingApprovals = \App\Models\Rental::where('status', 'pending')->count();
        
        // Traffic data
        $barangKeluar = \App\Models\Rental::whereIn('status', ['active', 'completed'])->count();
        $barangMasuk = \App\Models\Rental::where('status', 'completed')->count();
        $sedangRental = \App\Models\Rental::where('status', 'active')->count();
        $totalRental = \App\Models\Rental::count();
        
        // Category summary
        $kategoriSummary = \App\Models\Barang::selectRaw('kategori, COUNT(*) as total, 
                                            SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) as tersedia,
                                            SUM(CASE WHEN status = "rental" THEN 1 ELSE 0 END) as rental')
                                        ->groupBy('kategori')
                                        ->get()
                                        ->map(function($item) {
                                            return [
                                                'nama' => $item->kategori ?: 'Tidak Berkategori',
                                                'total' => $item->total,
                                                'tersedia' => $item->tersedia,
                                                'rental' => $item->rental
                                            ];
                                        });
        
        // Recent activities (sample data - you can customize this)
        $recentActivities = [
            ['title' => 'New rental request submitted', 'time' => '2 hours ago'],
            ['title' => 'User role updated', 'time' => '5 hours ago'],
            ['title' => 'Low stock alert: IND0003', 'time' => '1 day ago'],
        ];

        return view('manager.dashboard', compact(
            'totalUsers', 
            'activeRentals', 
            'totalBarang', 
            'pendingApprovals',
            'barangKeluar',
            'barangMasuk', 
            'sedangRental',
            'totalRental',
            'kategoriSummary',
            'recentActivities'
        ));
    }

    /**
     * Display manager report barang (only for manager)
     */
    public function reportBarang()
    {
        // Traffic data untuk grafik - Update logic untuk include maintenance
        $trafikData = [
            'barangKeluar' => \App\Models\Rental::whereIn('status', ['ongoing', 'approved'])->count(),
            'barangMasuk' => \App\Models\Rental::where('status', 'returned')->count(),
            'sedangRental' => \App\Models\Rental::where('status', 'ongoing')->count(),
            'totalRental' => \App\Models\Rental::count(),
            'maintenance' => \App\Models\Barang::where('status', 'maintenance')->count(),
            'rusak' => \App\Models\Barang::where('kondisi', 'rusak')->count()
        ];

        // Data rental per bulan (6 bulan terakhir)
        $rentalPerBulan = [];
        $bulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            $rentalPerBulan[] = \App\Models\Rental::whereYear('created_at', $bulan->year)
                                                 ->whereMonth('created_at', $bulan->month)
                                                 ->count();
        }

        // Status rental untuk pie chart
        $statusRental = [
            'pending' => \App\Models\Rental::where('status', 'pending')->count(),
            'approved' => \App\Models\Rental::where('status', 'approved')->count(),
            'ongoing' => \App\Models\Rental::where('status', 'ongoing')->count(),
            'returned' => \App\Models\Rental::where('status', 'returned')->count(),
            'rejected' => \App\Models\Rental::where('status', 'rejected')->count()
        ];

        // Data user aktif
        $userStats = [
            'totalUsers' => \App\Models\User::count(),
            'manager' => \App\Models\User::where('role', 'manager')->count(),
            'gudang' => \App\Models\User::where('role', 'gudang')->count(),
            'member' => \App\Models\User::where('role', 'member')->count()
        ];

        // Kategori barang untuk bar chart - Update untuk include maintenance dan rusak
        $kategoriData = \App\Models\Barang::selectRaw('kategori, COUNT(*) as total, 
                                        SUM(CASE WHEN status = "tersedia" AND kondisi = "baik" THEN 1 ELSE 0 END) as tersedia,
                                        SUM(CASE WHEN status = "maintenance" OR kondisi = "maintenance" THEN 1 ELSE 0 END) as maintenance,
                                        SUM(CASE WHEN kondisi = "rusak" THEN 1 ELSE 0 END) as rusak')
                                    ->groupBy('kategori')
                                    ->get();

        // Prepare chart data for JavaScript (to avoid VS Code parser issues)
        $chartDataJson = json_encode([
            'bulanLabels' => $bulanLabels,
            'rentalPerBulan' => $rentalPerBulan,
            'statusRental' => [
                'pending' => $statusRental['pending'],
                'approved' => $statusRental['approved'],
                'active' => $statusRental['active'],
                'completed' => $statusRental['completed'],
                'rejected' => $statusRental['rejected']
            ],
            'userStats' => [
                'manager' => $userStats['manager'],
                'gudang' => $userStats['gudang'],
                'member' => $userStats['member']
            ],
            'kategoriLabels' => $kategoriData->pluck('kategori')->map(function($item) { 
                return $item ?: 'Tidak Berkategori'; 
            }),
            'kategoriTersedia' => $kategoriData->pluck('tersedia'),
            'kategoriRental' => $kategoriData->pluck('rental')
        ]);

        return view('manager.report-barang', compact(
            'trafikData',
            'rentalPerBulan',
            'bulanLabels', 
            'statusRental',
            'userStats',
            'kategoriData',
            'chartDataJson'
        ));
    }

    /**
     * Display gudang dashboard (only for gudang)
     */
    public function gudangDashboard()
    {
        // Statistics for gudang dashboard
        $totalBarang = Barang::count();
        $pendingRentals = Rental::where('status', 'pending')->count();
        $activeRentals = Rental::where('status', 'active')->count();
        $lowStockItems = Barang::where('stok', '<', 5)->count();
        
        // Recent rentals
        $recentRentals = Rental::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboards.gudang', compact(
            'totalBarang',
            'pendingRentals', 
            'activeRentals',
            'lowStockItems',
            'recentRentals'
        ));
    }

    /**
     * Display member dashboard (only for member)
     */
    public function memberDashboard()
    {
        $userId = Auth::id();
        
        // Statistics for member
        $myActiveRentals = Rental::where('user_id', $userId)
            ->whereIn('status', ['approved', 'active'])
            ->count();
            
        $myPendingRentals = Rental::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
            
        $myTotalRentals = Rental::where('user_id', $userId)->count();
        
        $availableItems = Barang::where('stok', '>', 0)->count();
        
        // Recent rentals for the member
        $recentRentals = Rental::with('barang')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('member.dashboard', compact(
            'myActiveRentals',
            'myPendingRentals', 
            'myTotalRentals',
            'availableItems',
            'recentRentals'
        ));
    }

    public function memberAvailableBarang(Request $request)
    {
        $search = $request->get('search');
        
        $query = Barang::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        
        $barangs = $query->orderBy('nama_barang')->paginate(12);
        
        // Get unique categories for filter
        $categories = Barang::distinct()->pluck('kategori')->filter()->sort();
        
        return view('member.barang.available', compact('barangs', 'categories'));
    }

    public function memberCreateRental(Request $request)
    {
        // Hanya ambil barang yang benar-benar tersedia untuk dipinjam
        $availableBarangs = Barang::where('status', 'tersedia')
            ->where('kondisi', 'baik')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get()
            ->filter(function($barang) {
                return $barang->stok_tersedia > 0;
            });
            
        $selectedBarang = null;
        if ($request->barang_id) {
            $selectedBarang = Barang::find($request->barang_id);
            if ($selectedBarang && !$selectedBarang->isAvailable()) {
                return redirect()->route('member.rental.create')
                    ->withErrors(['barang_id' => 'Barang yang dipilih tidak tersedia untuk dipinjam']);
            }
        }
            
        return view('member.rental.create', compact('availableBarangs', 'selectedBarang'));
    }

    public function memberStoreRental(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:1000',
            'catatan' => 'nullable|string|max:500'
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        
        // Check if requested quantity is available
        if ($request->jumlah > $barang->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah yang diminta melebihi stok yang tersedia.'])->withInput();
        }

        // Generate rental code
        $lastRental = Rental::latest('id')->first();
        $nextNumber = $lastRental ? ((int) substr($lastRental->kode_rental, 3)) + 1 : 1;
        $kodeRental = 'RNT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Create rental
        $rental = Rental::create([
            'kode_rental' => $kodeRental,
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keperluan' => $request->keperluan,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return redirect()->route('member.rental.show', $rental)
            ->with('success', 'Permintaan rental berhasil diajukan! Silakan tunggu persetujuan dari staf gudang.');
    }

    public function memberShowRental(Rental $rental)
    {
        // Ensure user can only view their own rentals
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $rental->load(['barang', 'approver']);
        
        return view('member.rental.show', compact('rental'));
    }

    public function memberRentalHistory(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        
        $query = Rental::with(['barang'])
            ->where('user_id', Auth::id());
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_rental', 'like', "%{$search}%")
                  ->orWhereHas('barang', function($barangQuery) use ($search) {
                      $barangQuery->where('nama_barang', 'like', "%{$search}%")
                                  ->orWhere('kode_barang', 'like', "%{$search}%");
                  });
            });
        }
        
        $rentals = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $stats = [
            'total' => Rental::where('user_id', Auth::id())->count(),
            'pending' => Rental::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved' => Rental::where('user_id', Auth::id())->where('status', 'approved')->count(),
            'active' => Rental::where('user_id', Auth::id())->where('status', 'active')->count(),
            'completed' => Rental::where('user_id', Auth::id())->where('status', 'completed')->count(),
            'rejected' => Rental::where('user_id', Auth::id())->where('status', 'rejected')->count(),
        ];
        
        return view('member.rental.history', compact('rentals', 'stats'));
    }

    /**
     * Display user management (only for manager)
     */
    public function userManagement(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        
        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($role) {
            $query->where('role', $role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $allUsers = User::all(); // For statistics
        
        // Append search parameters to pagination links
        $users->appends(request()->query());
        
        return view('management.users', compact('users', 'allUsers'));
    }

    /**
     * Show create user form (only for manager)
     */
    public function createUser()
    {
        return view('management.create-user');
    }

    /**
     * Store new user (only for manager)
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:manager,gudang,member'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Auto verify new users created by manager
        ]);

        return redirect()->route('manager.users')->with('success', 'User baru berhasil ditambahkan');
    }

    /**
     * Update user role (only for manager)
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:manager,gudang,member'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Role user berhasil diupdate');
    }

    /**
     * Display maintenance items management (gudang only)
     */
    public function maintenanceBarang()
    {
        // Check authorization
        if (Auth::user()->role !== 'gudang') {
            abort(403, 'Unauthorized action.');
        }

        $maintenanceItems = \App\Models\Barang::where(function($query) {
                $query->where('status', 'maintenance')
                      ->orWhere('kondisi', 'maintenance')
                      ->orWhere('kondisi', 'rusak');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $stats = [
            'maintenance' => \App\Models\Barang::where('status', 'maintenance')->count(),
            'rusak' => \App\Models\Barang::where('kondisi', 'rusak')->count(),
            'need_repair' => \App\Models\Barang::where('kondisi', 'maintenance')->count()
        ];

        return view('gudang.maintenance', compact('maintenanceItems', 'stats'));
    }

    /**
     * Update maintenance status
     */
    public function updateMaintenanceStatus(Request $request, \App\Models\Barang $barang)
    {
        // Check authorization
        if (Auth::user()->role !== 'gudang') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:tersedia,maintenance,tidak_tersedia',
            'kondisi' => 'required|in:baik,maintenance,rusak',
            'catatan_maintenance' => 'nullable|string|max:500'
        ]);

        // Simpan kondisi dan status sebelumnya
        $oldKondisi = $barang->kondisi;
        $oldStatus = $barang->status;

        // Update status dan kondisi barang
        $barang->update([
            'status' => $request->status,
            'kondisi' => $request->kondisi,
            'catatan_maintenance' => $request->catatan_maintenance,
            'updated_at' => now()
        ]);

        // Logika penyesuaian stok berdasarkan perubahan status/kondisi
        $this->adjustStokForMaintenanceStatus($barang, $oldKondisi, $oldStatus, $request->kondisi, $request->status);

        return redirect()->back()->with('success', 'Status maintenance barang berhasil diupdate dan stok telah disesuaikan');
    }

    /**
     * Adjust stok based on maintenance status changes
     */
    private function adjustStokForMaintenanceStatus($barang, $oldKondisi, $oldStatus, $newKondisi, $newStatus)
    {
        // Jika barang dipindah ke maintenance atau rusak, kurangi stok yang tersedia
        if (($oldKondisi === 'baik' && ($newKondisi === 'maintenance' || $newKondisi === 'rusak')) ||
            ($oldStatus === 'tersedia' && $newStatus === 'maintenance')) {
            
            // Tidak mengurangi stok fisik, tetapi menandai sebagai tidak tersedia
            // Stok tetap sama, tapi status berubah
            
        }
        
        // Jika barang kembali dari maintenance/rusak ke baik, tambahkan ke stok tersedia
        if (($oldKondisi === 'maintenance' || $oldKondisi === 'rusak') && $newKondisi === 'baik' && $newStatus === 'tersedia') {
            
            // Barang kembali tersedia untuk dipinjam
            // Tidak perlu menambah stok fisik karena stok tidak dikurangi saat maintenance
            
        }
    }
}
