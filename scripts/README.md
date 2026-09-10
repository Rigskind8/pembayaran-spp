# Testing lokal dengan ngrok

## Jalankan aplikasi + tunnel publik

Dari folder project:

```powershell
Set-ExecutionPolicy -Scope Process Bypass
.\scripts\serve-local-ngrok.ps1
```

Script akan:

1. Menjalankan Laravel pada `http://localhost:8000` dengan host `0.0.0.0`.
2. Membuka tunnel ngrok ke port tersebut.
3. Menampilkan URL `https://....ngrok-free.app` yang bisa dibagikan untuk testing.
4. Menghentikan server Laravel saat ngrok dihentikan dengan `Ctrl+C`.

## Jika ngrok belum login

Buat akun ngrok, ambil authtoken, lalu jalankan sekali:

```powershell
ngrok config add-authtoken TOKEN_NGROK_ANDA
```

Jangan commit atau membagikan token ngrok.

## Catatan testing

- Database tetap memakai MySQL lokal pada `.env`; orang lain hanya mengakses aplikasi melalui tunnel.
- Pastikan akun testing tidak menggunakan password produksi dan jangan menaruh data sensitif.
- URL publik berubah setiap kali tunnel gratis dibuat ulang.
- Jika asset masih menunjuk ke URL lama, set sementara `APP_URL` di `.env` ke URL ngrok lalu jalankan `php artisan config:clear`.
- Untuk menghentikan akses publik, tekan `Ctrl+C` pada terminal ngrok.
