🎓 PMB Online - Sistem Penerimaan Mahasiswa Baru
📌 Deskripsi

PMB Online adalah sistem berbasis web yang digunakan untuk mengelola proses penerimaan mahasiswa baru secara digital. Sistem ini dibangun menggunakan framework Laravel dengan konsep MVC (Model-View-Controller) serta menggunakan Tailwind CSS untuk tampilan antarmuka yang modern dan responsif.

Aplikasi ini menyediakan fitur lengkap mulai dari registrasi akun mahasiswa, pengisian formulir pendaftaran, upload dokumen, hingga dashboard admin untuk proses verifikasi data.

🚀 Fitur Utama
👨‍🎓 Mahasiswa
Registrasi & Login
Formulir pendaftaran (multi-step)
Upload dokumen (KTP, Ijazah, dll)
Dashboard mahasiswa (progress pendaftaran)
Status pendaftaran (Draft, Review, Terverifikasi)
Unduh bukti pendaftaran
👨‍💼 Admin
Dashboard monitoring
CRUD Data Pendaftaran
CRUD User Management
Verifikasi pendaftaran (ACC / Tolak / Revisi)
Laporan & Statistik (grafik & distribusi)
Pengaturan sistem
🛠️ Teknologi yang Digunakan
Backend : Laravel 12 / 13
Frontend : Blade + Tailwind CSS
Database : MySQL
JavaScript : Vanilla JS (validasi form)
Chart : Chart.js / ApexCharts (opsional)
Server : Apache / Laravel Built-in Server
🧱 Arsitektur Sistem

Aplikasi menggunakan pola MVC (Model-View-Controller):

Model → Mengelola data dan database
View → Tampilan UI (Blade)
Controller → Logika bisnis & penghubung Model dan View
📊 Modul Sistem
Public Pages → Landing page, program studi, informasi, kontak
Mahasiswa Panel → Form pendaftaran & status
Admin Panel → Manajemen data, user, laporan
Sistem Validasi → Input validation & workflow status
Reporting → Grafik & statistik pendaftaran
🔐 Keamanan Sistem
Validasi input (frontend & backend)
Proteksi CSRF Laravel
Authentication & Authorization (Role-based)
Validasi file upload
Sanitasi data input
⚙️ Kebutuhan Sistem
Fungsional
CRUD data pendaftaran
CRUD user
Upload & verifikasi dokumen
Monitoring status pendaftaran
Non-Fungsional
Sistem berjalan 24/7
Mendukung minimal 20 user bersamaan
Responsif (desktop & mobile)
Aman dari serangan umum (XSS, CSRF)
🖥️ Instalasi
# Clone repository
git clone https://github.com/username/pmb-online.git

# Masuk ke folder project
cd pmb-online

# Install dependency
composer install

# Copy file env
cp .env.example .env

# Generate key
php artisan key:generate

# Setup database di .env

# Migrasi database
php artisan migrate

# Jalankan server
php artisan serve
📷 Tampilan Sistem
Landing Page

Menampilkan informasi umum PMB dan ajakan pendaftaran.

Dashboard Mahasiswa

Menampilkan progress pendaftaran dan status.

Dashboard Admin

Menampilkan statistik, grafik, dan data terbaru.

Data Pendaftaran

CRUD data mahasiswa.

Kelola User

Manajemen akun dan role pengguna.


Admin Login 
Email: admin@university.ac.id
Password: password


🔗 Link
🌐 Portfolio: https://reinaldyportfolio.vercel.app/
💻 GitHub: https://github.com/ReinaldyDwiAllailKusnadi
🔗 LinkedIn: https://www.linkedin.com/in/reinaldydwi
👨‍💻 Author

Reinaldy Dwi Alil Kusnadi
Mahasiswa Sistem Informasi
Telkom University
