# Test Password Reset Functionality

## Cara Test Reset Password:

### 1. Dengan Email Setup (Recommended)
1. Setup email di file `.env` (lihat EMAIL_SETUP.md)
2. Buka: http://localhost/management/manajemen/public/forgot-password
3. Masukkan email yang sudah terdaftar
4. Check email untuk mendapatkan link reset

### 2. Dengan Log File (Untuk Testing Tanpa Email)
1. Set di `.env`:
   ```
   MAIL_MAILER=log
   ```
2. Buka: http://localhost/management/manajemen/public/forgot-password
3. Masukkan email yang sudah terdaftar
4. Check file: `storage/logs/laravel.log` untuk melihat email content

### 3. Test dengan User yang Ada
Default users yang bisa ditest:
- Email: manager@test.com (jika ada)
- Email: gudang@test.com (jika ada)
- Email: member@test.com (jika ada)

### 4. Buat User Test Baru
```bash
php artisan tinker
User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password'),
    'role' => 'member'
]);
```

### 5. Flow Lengkap Reset Password:
1. **Forgot Password**: User input email → Sistem kirim email dengan token
2. **Email Link**: User klik link → Redirect ke halaman reset password
3. **Reset Password**: User input password baru → Password berhasil direset
4. **Login**: User bisa login dengan password baru

### 6. Security Features:
- ✅ Token expired dalam 60 menit
- ✅ Rate limiting (1 request per menit per email)
- ✅ Secure token generation
- ✅ Password validation rules
- ✅ Email validation

### 7. Troubleshooting:
- **"Email not found"**: User belum terdaftar di sistem
- **"Email tidak terkirim"**: Check konfigurasi SMTP
- **"Token invalid"**: Link sudah expired atau sudah digunakan
- **"Too many requests"**: Wait 1 menit sebelum request lagi
