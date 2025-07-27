<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Barang;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function dashboardStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_barangs' => Barang::count(),
            'total_rentals' => Rental::count(),
            'pending_rentals' => Rental::where('status', 'pending')->count(),
            'ongoing_rentals' => Rental::where('status', 'ongoing')->count(),
            'available_barangs' => Barang::where('stok', '>', 0)->count(),
            'low_stock_barangs' => Barang::where('stok', '>', 0)->where('stok', '<=', 5)->count(),
            'out_of_stock_barangs' => Barang::where('stok', '<=', 0)->count(),
        ];

        // Recent activities
        $recentRentals = Rental::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'user_name' => $rental->user->name,
                    'barang_name' => $rental->barang->nama_barang,
                    'status' => $rental->status,
                    'created_at' => $rental->created_at
                ];
            });

        // Low stock items
        $lowStockItems = Barang::where('stok', '>', 0)
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'stok' => $barang->stok,
                    'kategori' => $barang->kategori
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistics' => $stats,
                'recent_rentals' => $recentRentals,
                'low_stock_items' => $lowStockItems
            ]
        ]);
    }

    /**
     * Get all users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        $users->getCollection()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * Get single user
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    /**
     * Create user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:member,gudang,manager'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at
            ]
        ], 201);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role' => 'required|in:member,gudang,manager'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}
