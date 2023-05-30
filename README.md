# BPP-SEKOLAH

Aplikasi pendataan pembayaran uang komite atau biaya penyelenggara pendidikan dibuat dengan Framework Laravel 9. Dengan sistem pembayaran menggunakan payment gateway. Aplikasi ini cocok untuk digunakan untuk di sekolah. <br>

Beberapa CRUD menggunakan modal dan AJAX untuk pengambilan data agar mengurangi penggunaan pindah halaman. Dan seluruh menu menggunakan DataTable Server Side Processing.

### Prasyarat

Berikut beberapa hal yang perlu diinstal terlebih dahulu:

-   Composer (https://getcomposer.org/)
-   PHP ^8.1.x
-   MySQL RDBMS

### Fitur

-   CRUD Data Siswa
-   CRUD Data Kelas
-   CRUD Data Jurusan
-   CRUD Data Transaksi
-   CRUD Data Tagihan
-   CRUD Data Administrator
-   Laporan

### Langkah-langkah instalasi

-   Clone repository ini

HTTPS

```
https://github.com/Muhammad-Jafar/Aplikasi-BPP-Sekolah.git
```

-   Install seluruh packages yang dibutuhkan

```bash
composer install
```

-   Siapkan database dan atur file .env sesuai dengan konfigurasi Anda
-   Ubah value APP_NAME= pada file .env menjadi nama aplikasi yang anda inginkan
-   Jika sudah, migrate seluruh migrasi dan seeding data

```bash
php artisan migrate --seed
```

- Generate JWT Secret Token

```bash
php artisan jwt:secret
```

-   Ketik perintah dibawah ini untuk membuat cache baru dari beberapa konfigurasi yang telah diubah

```bash
php artisan optimize
```

-   Jalankan local server

```bash
php artisan serve
```

-   _(Opsional)_ Secara default debugbar akan aktif, untuk menonaktifkannnya cari variabel `DEBUGBAR_ENABLED` pada file .env dan ubah valuenya menjadi `false`

-   Akses ke halaman

```
http://127.0.0.1:8000
```

---

-   User default aplikasi untuk login

##### Administrator

```
Email       : admin@mail.com
Password    : admin
```

##### Supervisor

```
Email       : spv@mail.com
Password    : supervisor
```

##### Siswa

```
Email       : susanto@mail.com
Password    : siswa
```

### Dibuat dengan

- [Laravel](https://laravel.com/) - Backend Framework
- [Bootstrap](https://getbootstrap.com/) - Frontend Framework


### Pembuat

-   **Muhammad Jafar**  - [muhammadjafar](https://github.com/Muhammad-Jafar)

### Lisensi

Aplikasi ini dibuat dengan MIT lisensi. Jadi boleh untuk dibagi dan diubah sebagai bahan belajar.

### Ucapan terima kasih

-   [Mazer Dashboard Theme](https://github.com/zuramai/mazer)
-   Stackoverflow
-   Google
