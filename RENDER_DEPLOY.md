# Deploy ke Render — Panduan Singkat

Langkah cepat untuk membuat aplikasi Laravel ini live di Render.

1) Buat service di Render
- Pilih "Web Service" dan hubungkan ke repository Git
- Gunakan `render.yaml` yang sudah ada (Render akan pakai konfigurasi build/start di file)

2) Set Environment Variables (Render dashboard -> Environment)
- `APP_KEY` : jalankan `php artisan key:generate --show` secara lokal lalu tempel di Render
- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-app.onrender.com`
- Database (Managed PostgreSQL): set `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Storage (S3-compatible): set `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `AWS_URL` (optional)
- Mail: `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`

3) Tambah Managed Database (opsional tapi direkomendasikan)
- Di dashboard Render -> Databases -> Create PostgreSQL
- Copy connection details ke env vars aplikasi

4) Pastikan `FILESYSTEM_DISK` di env di-set ke `s3` jika pakai object storage, atau `local` jika pakai persistent disk.

5) Deploy & Verifikasi
- Push perubahan ke repo; Render akan build dan deploy sesuai `render.yaml`.
- Jika migrasi gagal saat build, jalankan migration manual via: Render -> Shell -> `php artisan migrate --force`.
- Periksa logs di Render (Build logs dan Instance logs) untuk error.

6) Storage & Uploads
- `php artisan storage:link` sudah di-run selama build (ada di `render.yaml`).
- Pastikan bucket S3/public permission dan `APP_URL` benar sehingga file bisa diakses.

7) Troubleshooting umum
- 500 errors: cek logs, `APP_DEBUG=false` di production — gunakan logs untuk detail.
- Missing APP_KEY: generate dan set di Render
- Queue workers: Jika butuh queue worker, tambahkan Background Worker service di Render dengan `php artisan queue:work --sleep=3 --tries=3`

Jika mau, saya bisa: membuat PR berisi semua file perubahan ini, atau memandu kamu step-by-step di dashboard Render. Mau saya buat PR atau lanjut pandu manual? 
