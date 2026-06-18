# Catatan Projek - Website Bioskop (Cinema Booking)

## Info Projek

- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: SQLite
- **Frontend**: Tailwind CSS 4, Alpine.js, Vite 7
- **Auth**: Laravel Breeze
- **Payment Gateway**: Midtrans (`midtrans/midtrans-php ^2.6`)
- **API**: Laravel Sanctum

---

## Struktur Database (Models & Relasi)

### User
- Field: `name`, `email`, `password`, `role` (admin/customer)
- Relasi: `hasMany(Transaction)`
- Helper: `isAdmin()`, `isCustomer()`

### Movie
- Field: `title`, `synopsis`, `duration`, `poster`, `genre`, `status`
- Status enum: `now_showing`, `coming_soon` (`App\Enums\MovieStatus`)
- Relasi: `hasMany(Schedule)`

### Studio
- Field: `studio_name`, `capacity`
- Relasi: `hasMany(Seat)`, `hasMany(Schedule)`

### Seat
- Field: `studio_id`, `seat_number` (format: A1-J8)
- Relasi: `belongsTo(Studio)`, `hasMany(TransactionDetail)`

### Schedule
- Field: `movie_id`, `studio_id`, `show_date`, `start_time`, `ticket_price`
- Cast: `show_date => date`, `ticket_price => decimal:2`
- Relasi: `belongsTo(Movie)`, `belongsTo(Studio)`, `hasMany(Transaction)`

### Transaction
- Field: `user_id`, `schedule_id`, `total_price`, `payment_status`, `midtrans_booking_code`
- Cast: `total_price => decimal:2`
- Auto-generate `midtrans_booking_code` saat creating (format: TRX-XXXXXXXXXX)
- Relasi: `belongsTo(User)`, `belongsTo(Schedule)`, `hasMany(TransactionDetail)`

### TransactionDetail
- Field: `transaction_id`, `seat_id`
- Relasi: `belongsTo(Transaction)`, `belongsTo(Seat)`

---

## ERD (Entity Relationship)

```
User (1) ──── (N) Transaction (1) ──── (N) TransactionDetail (N) ──── (1) Seat
                  │                                                              │
                  │                                                         belongs to
                                                                                  │
             belongs to                                                      Studio (1)
                                                                                  │
                  │                                                              │
                  ▼                                                         has many
              Schedule (N) ──── belongs to ──── (1) Movie                      │
                  │                                        │                   ▼
                  │                                        │              Schedule
           belongs to                              has many
                  │                                        │
                  ▼                                        ▼
              Studio (1) ──── (1) Movie ──── (N) Schedule
```

---

## Routes

### Public
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/` | Halaman utama (list film Now Showing & Coming Soon) |
| GET | `/movies` | Sama seperti home |
| GET | `/movies/{movie}` | Detail film + jadwal tayang + kursi tersedia |

### Authenticated (customer)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/booking/{schedule}/seats` | Pilih kursi untuk jadwal tertentu |
| POST | `/booking/{schedule}/checkout` | Proses booking (buat transaksi) |
| GET | `/booking/{transaction}/payment` | Halaman pembayaran |
| POST | `/booking/{transaction}/confirm` | Konfirmasi pembayaran |
| GET | `/my-tickets` | Riwayat transaksi user |
| GET | `/profile` | Edit profil |
| PATCH | `/profile` | Update profil |
| DELETE | `/profile` | Hapus akun |

### Admin (middleware: auth + admin, prefix: /admin)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/admin` | Halaman utama admin |
| GET | `/admin/dashboard` | Dashboard statistik |
| CRUD | `/admin/movies` | Kelola film |
| CRUD | `/admin/studios` | Kelola studio |
| CRUD | `/admin/schedules` | Kelola jadwal |
| GET | `/admin/transactions` | Lihat semua transaksi |

---

## Alur Booking

1. User melihat film di home page
2. User klik film → lihat detail + jadwal
3. User pilih jadwal → masuk halaman pilih kursi (`/booking/{schedule}/seats`)
4. Kursi yang sudah dibooking ditandai (dicek via `TransactionDetail`)
5. User pilih kursi → submit → buat `Transaction` + `TransactionDetail` (status: pending)
6. Redirect ke halaman pembayaran (`/booking/{transaction}/payment`)
7. Konfirmasi pembayaran → update `payment_status` ke `success`

---

## Middleware

- **AdminMiddleware**: Membatasi akses hanya untuk user dengan `role = admin`
- **CustomerMiddleware**: Membatasi akses hanya untuk user dengan `role = customer`

---

## Seeder

`CinemaSeeder` membuat data dummy:
- 4 Studio (kapasitas 80, 80, 60, 60)
- 5 Film Now Showing + 2 Film Coming Soon (film Indonesia & internasional)
- Kursi per studio (A1-J8 format, sesuai kapasitas)
- Jadwal acak untuk film Now Showing (3 jam tayang per film, 7 hari ke depan)

---

## Konfigurasi Penting

- **DB**: SQLite (`database/database.sqlite`)
- **Session**: database driver
- **Queue**: database driver
- **Cache**: database driver
- **Log**: stack/single

---

## Command Penting

```bash
# Setup awal
composer run setup

# Jalankan development server (serve + queue + logs + vite)
composer run dev

# Jalankan test
composer run test

# Migration
php artisan migrate

# Seed database
php artisan db:seed --class=CinemaSeeder
```

---

## Catatan Pengembangan

- Integrasi Midtrans sudah di `composer.json` tapi belum ada service/controller yang menggunakan API Midtrans (pembayaran saat ini hanya update status manual)
- Folder `app/Services` kosong — bisa digunakan untuk Midtrans service
- `payment_status` yang digunakan: `pending`, `success`, `failed`
- Booking conflict check mengabaikan transaksi dengan status `failed`
- Kursi digenerate otomatis oleh seeder berdasarkan kapasitas studio