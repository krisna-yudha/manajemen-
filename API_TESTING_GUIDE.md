# Panduan Testing API dengan Postman

## Setup Postman Environment

### 1. Buat Environment Baru
- Nama: `Rental Management API`
- Variables:
  - `base_url`: `http://localhost/management/manajemen/public/api`
  - `token`: (akan diisi setelah login)

## Authentication Endpoints

### 1. Register User
- **Method**: POST
- **URL**: `{{base_url}}/register`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "role": "member"
  }
  ```

### 2. Login
- **Method**: POST
- **URL**: `{{base_url}}/login`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "email": "test@example.com",
    "password": "password123"
  }
  ```
- **Response**: Simpan `token` dari response ke environment variable

### 3. Get User Profile
- **Method**: GET
- **URL**: `{{base_url}}/user`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 4. Logout
- **Method**: POST
- **URL**: `{{base_url}}/logout`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

## Barang Endpoints

### 1. Get All Barang
- **Method**: GET
- **URL**: `{{base_url}}/barangs`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```
- **Query Parameters (Optional)**:
  - `search`: kata kunci pencarian
  - `kategori`: filter kategori
  - `per_page`: jumlah per halaman (default: 15)

### 2. Get Single Barang
- **Method**: GET
- **URL**: `{{base_url}}/barangs/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 3. Create Barang (Role: Manager/Gudang)
- **Method**: POST
- **URL**: `{{base_url}}/barangs`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "nama_barang": "Laptop Gaming",
    "kategori": "Elektronik",
    "deskripsi": "Laptop gaming high-end",
    "harga": 15000000,
    "stok": 5
  }
  ```

### 4. Update Barang
- **Method**: PUT
- **URL**: `{{base_url}}/barangs/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "nama_barang": "Laptop Gaming Updated",
    "kategori": "Elektronik",
    "deskripsi": "Laptop gaming high-end updated",
    "harga": 16000000,
    "stok": 10
  }
  ```

### 5. Delete Barang
- **Method**: DELETE
- **URL**: `{{base_url}}/barangs/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 6. Get Available Barang
- **Method**: GET
- **URL**: `{{base_url}}/barangs/available`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 7. Get Low Stock Barang
- **Method**: GET
- **URL**: `{{base_url}}/barangs/low-stock`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 8. Get Categories
- **Method**: GET
- **URL**: `{{base_url}}/barangs/categories`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

## Rental Endpoints

### 1. Get All Rentals
- **Method**: GET
- **URL**: `{{base_url}}/rentals`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```
- **Query Parameters (Optional)**:
  - `status`: pending, ongoing, completed
  - `per_page`: jumlah per halaman

### 2. Get My Rentals (Member only)
- **Method**: GET
- **URL**: `{{base_url}}/rentals/my`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 3. Create Rental
- **Method**: POST
- **URL**: `{{base_url}}/rentals`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "barang_id": 1,
    "jumlah": 2,
    "tanggal_mulai": "2024-12-30",
    "tanggal_selesai": "2025-01-05",
    "keperluan": "Untuk acara kantor"
  }
  ```

### 4. Get Single Rental
- **Method**: GET
- **URL**: `{{base_url}}/rentals/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 5. Update Rental Status (Manager/Gudang)
- **Method**: POST
- **URL**: `{{base_url}}/rentals/1/update-status`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "status": "approved",
    "catatan": "Rental disetujui"
  }
  ```

### 6. Return Rental (Manager/Gudang)
- **Method**: POST
- **URL**: `{{base_url}}/rentals/1/return`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "jumlah_dikembalikan": 2,
    "kondisi": "baik",
    "catatan": "Barang dikembalikan dalam kondisi baik"
  }
  ```

## Stock Endpoints

### 1. Get Stock Logs
- **Method**: GET
- **URL**: `{{base_url}}/stocks/logs`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```
- **Query Parameters (Optional)**:
  - `barang_id`: filter berdasarkan barang
  - `type`: in, out, adjustment
  - `start_date`: tanggal mulai (YYYY-MM-DD)
  - `end_date`: tanggal akhir (YYYY-MM-DD)

### 2. Adjust Stock (Manager/Gudang)
- **Method**: POST
- **URL**: `{{base_url}}/stocks/adjust`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "barang_id": 1,
    "type": "addition",
    "jumlah": 10,
    "keterangan": "Penambahan stok dari supplier"
  }
  ```

### 3. Get Low Stock Items
- **Method**: GET
- **URL**: `{{base_url}}/stocks/low-stock`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

## User Management Endpoints (Manager only)

### 1. Get Dashboard Stats
- **Method**: GET
- **URL**: `{{base_url}}/users/dashboard-stats`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

### 2. Get All Users
- **Method**: GET
- **URL**: `{{base_url}}/users`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```
- **Query Parameters (Optional)**:
  - `role`: member, gudang, manager
  - `search`: kata kunci pencarian

### 3. Create User
- **Method**: POST
- **URL**: `{{base_url}}/users`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "role": "member"
  }
  ```

### 4. Update User
- **Method**: PUT
- **URL**: `{{base_url}}/users/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  Accept: application/json
  ```
- **Body (JSON)**:
  ```json
  {
    "name": "Updated User",
    "email": "updated@example.com",
    "role": "gudang"
  }
  ```

### 5. Delete User
- **Method**: DELETE
- **URL**: `{{base_url}}/users/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Accept: application/json
  ```

## Tips Testing:

1. **Urutan Testing**:
   - Register/Login terlebih dahulu
   - Test barang endpoints
   - Test rental endpoints
   - Test stock management
   - Test user management

2. **Token Management**:
   - Setiap request (kecuali register/login) butuh Authorization header
   - Token akan expired, login ulang jika mendapat error 401

3. **Role-based Testing**:
   - Member: hanya bisa rental dan lihat data
   - Gudang: bisa manage stock dan approve rental
   - Manager: akses penuh ke semua fitur

4. **Error Handling**:
   - 400: Bad Request
   - 401: Unauthorized
   - 403: Forbidden
   - 404: Not Found
   - 422: Validation Error
   - 500: Server Error
