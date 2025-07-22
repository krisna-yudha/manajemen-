# Setup Email untuk Password Reset

## 1. Gmail Setup (Recommended untuk Testing)

### Langkah-langkah:
1. **Buka Gmail Settings:**
   - Login ke Gmail
   - Klik Settings (gear icon) → "See all settings"
   - Klik tab "Forwarding and POP/IMAP"
   - Enable IMAP

2. **Setup App Password:**
   - Kunjungi: https://myaccount.google.com/security
   - Klik "2-Step Verification" (harus diaktifkan terlebih dahulu)
   - Klik "App passwords"
   - Pilih "Mail" dan device "Other"
   - Copy password yang dihasilkan

3. **Update file .env:**
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=email_anda@gmail.com
   MAIL_PASSWORD=app_password_yang_dicopy
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@manajemen.com"
   MAIL_FROM_NAME="Manajemen Rental"
   ```

## 2. Mailtrap Setup (Recommended untuk Development)

1. **Daftar di Mailtrap.io** (gratis)
2. **Buat Inbox baru**
3. **Copy kredential SMTP:**
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@manajemen.com"
   MAIL_FROM_NAME="Manajemen Rental"
   ```

## 3. Testing

Setelah setup email:
1. Restart web server
2. Buka halaman "Forgot Password"
3. Masukkan email yang terdaftar
4. Check email/mailtrap untuk link reset password

## 4. Troubleshooting

- **Error "Connection refused"**: Check firewall/antivirus
- **Authentication failed**: Pastikan app password benar
- **Email tidak terkirim**: Check spam folder
- **Token expired**: Link reset berlaku 60 menit

## 5. Alternative untuk Testing Lokal

Jika tidak ingin setup email, gunakan:
```
MAIL_MAILER=log
```

Email akan disimpan di `storage/logs/laravel.log`
