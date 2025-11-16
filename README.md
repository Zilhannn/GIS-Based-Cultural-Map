# 🗺️ Cultural Map Garut, Jawa Barat, Indonesia

## 📖 Tentang Proyek
**Cultural Map Garut** adalah proyek berbasis web yang bertujuan untuk memperkenalkan serta melestarikan kekayaan budaya yang ada di Kabupaten Garut, Jawa Barat.  
Melalui peta interaktif, pengguna dapat menjelajahi lokasi-lokasi bersejarah, situs budaya, kesenian tradisional, hingga kuliner khas yang menjadi identitas masyarakat Garut.

---

## 🎯 Tujuan Proyek
- Menyediakan platform interaktif untuk mengenalkan budaya Garut kepada masyarakat luas.  
- Menjadi sumber informasi digital bagi wisatawan dan peneliti.  
- Mendorong pelestarian budaya lokal melalui teknologi.  

---

## 🧩 Fitur Utama
- 🌍 **Peta Interaktif:** Menampilkan titik lokasi situs budaya, tempat wisata, dan kuliner khas.  
- 🏛️ **Informasi Detail:** Deskripsi sejarah, foto, dan keterangan setiap lokasi.  
- 🔍 **Fitur Pencarian:** Memudahkan pengguna menemukan destinasi berdasarkan kategori.  
- 📱 **Tampilan Responsif:** Dapat diakses dari perangkat desktop maupun mobile.  
- 🗃️ **Integrasi GIS:** Menggunakan **QGIS** untuk manajemen data spasial.  

---

## 🧠 Teknologi yang Digunakan

| Teknologi | Keterangan |
|------------|-------------|
| **Laravel** | Framework utama untuk backend |
| **Leaflet.js / Mapbox** | Library untuk menampilkan peta interaktif |
| **MySQL / PostgreSQL** | Database penyimpanan data budaya |
| **QGIS** | Pengelolaan data spasial (GIS) |
| **Bootstrap / Tailwind CSS** | Tampilan antarmuka web |
| **JavaScript (Vue/React)** | Interaktivitas peta dan UI |

---

## 🗂️ Struktur Proyek
```
CulturalMapGarut/
│
├── app/                 # Logika backend Laravel
├── public/              # Aset publik (gambar, CSS, JS)
├── resources/           # View & komponen frontend
├── routes/              # File routing Laravel
├── database/            # Migrasi & seeding data
└── README.md            # Dokumentasi proyek
```

---

## ⚙️ Cara Menjalankan Proyek
1. Clone repository ini:
   ```bash
   git clone https://github.com/Zilhannn/GIS-Based-Cultural-Map
   ```
2. Masuk ke folder project:
   ```bash
   cd GIS-Based-Cultural-Map
   ```
3. Install dependencies:
   ```bash
   composer install
   npm install
   ```
4. Salin file `.env.example` menjadi `.env` lalu ubah konfigurasi database.
5. Jalankan migration:
   ```bash
   php artisan migrate
   ```
6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
7. Akses di browser:
   ```
   http://localhost:8000
   ```

---

## 📸 Tangkapan Layar (Screenshots)
> Tambahkan gambar antarmuka atau peta interaktif di sini  
> (misalnya `/public/screenshots/homepage.png`)

```
![Homepage](public/screenshots/homepage.png)
![Peta Budaya](public/screenshots/map.png)
```

---

## 👥 Tim Pengembang
- **Nama:** Zilhan Salman  
- **Peran:** Fullstack Developer / GIS Developer  
- **Instansi:** Universitas / Lembaga terkait  

---

## 📚 Referensi
- Pemerintah Kabupaten Garut – *Data Pariwisata dan Kebudayaan*  
- Badan Pusat Statistik (BPS) Garut – *Profil Daerah 2024*  
- Dokumentasi Laravel: [https://laravel.com/docs](https://laravel.com/docs)  
- Leaflet.js: [https://leafletjs.com](https://leafletjs.com)

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah lisensi **MIT**.  
Anda bebas menggunakan, menyalin, atau memodifikasi proyek ini dengan tetap mencantumkan atribusi kepada pengembang asli.
