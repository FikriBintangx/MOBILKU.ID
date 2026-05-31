# Dokumen Elisitasi Kebutuhan Sistem - MOBILKU
**Mata Kuliah: Analisis dan Perancangan Sistem Informasi (Semester 4)**

---

## 1. Pendahuluan & Latar Belakang
Perusahaan jual beli mobil bekas ingin mengkomputerisasi administrasi dan proses jual-beli tradisional. Dengan beralih ke platform web terkomputerisasi **MOBILKU**, perusahaan dapat mempermudah calon pembeli maupun penjual dalam bertransaksi, memantau tenggat waktu pembayaran secara akurat, melacak pengurusan dokumen (STNK & BPKB), mengelola kurir pengiriman unit, serta memproses sourcing kendaraan dari perorangan.

---

## 2. Elisitasi Tahap I (Kebutuhan Mentah)
Kebutuhan sistem diperoleh langsung dari analisis deskripsi proses bisnis:
1. Calon pembeli dapat melihat katalog mobil bekas yang tersedia.
2. Calon pembeli membayar Bukti Pesanan (Booking Fee) sebesar Rp. 500.000,-.
3. Calon pembeli memiliki batas waktu 1 minggu untuk membayar Uang Muka (DP) 30% dan mengunggah scan KTP.
4. Jika melebihi 1 minggu tanpa pembayaran DP, pesanan otomatis dianggap batal dan Booking Fee Rp. 500.000,- hangus.
5. Jika dibatalkan dalam waktu kurang dari 1 minggu, Booking Fee dapat dikembalikan penuh.
6. Setelah DP & KTP diterima, perusahaan mengurus STNK (rata-rata 2 minggu) & BPKB (rata-rata 2 bulan).
7. Pembeli melunasi sisa harga mobil (70%) selama masa pengurusan STNK (2 minggu).
8. Setelah STNK selesai dan pelunasan diverifikasi, pembeli dapat memilih mengambil sendiri (Pickup) atau dikirim ke rumah (Delivery).
9. Jika dikirim ke rumah, kurir membawa Surat Jalan resmi sebagai bukti serah terima unit.
10. BPKB diserahterimakan secara terpisah setelah selesai (2 bulan).
11. Penjual perorangan dapat menawarkan mobilnya lewat portal (Sourcing).
12. Staff showroom melakukan inspeksi kelayakan fisik/mesin dan memberikan penawaran harga lunas.
13. Showroom membayar lunas ke penjual via Tunai (Kwitansi instan) atau Transfer Bank (verifikasi transfer).
14. Mobil yang berhasil dibeli dari sourcing perorangan otomatis masuk katalog inventori siap jual.

---

## 3. Elisitasi Tahap II (Metode MDI - Mandatory, Desirable, Inessential)
Penyaringan kebutuhan mentah untuk menetapkan skala prioritas sistem:

### A. Kebutuhan Fungsional (Functional Requirements)
| No | Deskripsi Kebutuhan | Skala (MDI) | Keterangan |
|----|---------------------|-------------|------------|
| 1  | Sistem menampilkan katalog inventori mobil aktif beserta filter brand & harga | **M (Mandatory)** | Krusial untuk pembeli |
| 2  | Sistem memproses transaksi checkout Booking Fee Rp. 500.000,- | **M (Mandatory)** | Mengunci status unit |
| 3  | Sistem memantau batas waktu pembayaran DP (Tenggat 7 Hari) | **M (Mandatory)** | Regulasi bisnis utama |
| 4  | Sistem mendukung unggah scan KTP & slip pembayaran DP | **M (Mandatory)** | Syarat pengurusan berkas |
| 5  | Sistem menyediakan antarmuka pemantauan status STNK & BPKB | **M (Mandatory)** | Menggantikan sistem manual |
| 6  | Sistem memproses konfigurasi serah terima (Ambil Sendiri / Kirim) | **M (Mandatory)** | Logistik pengiriman unit |
| 7  | Sistem menerbitkan dokumen Surat Jalan untuk kurir pengantar | **D (Desirable)** | Perlindungan hukum unit |
| 8  | Sistem menerbitkan Kwitansi Resmi Pembayaran Tunai/Transfer | **M (Mandatory)** | Bukti sah keuangan |
| 9  | Sistem menyediakan portal penawaran mobil bagi penjual (Sourcing) | **M (Mandatory)** | Penyediaan unit masuk |
| 10 | Staff dapat menginput hasil inspeksi kelayakan fisik dan mesin | **M (Mandatory)** | Menentukan nilai tawar |
| 11 | Sistem otomatis memasukkan mobil sourced ke katalog pasca lunas | **D (Desirable)** | Automasi inventori |

### B. Kebutuhan Non-Fungsional (Non-Functional Requirements)
| No | Deskripsi Kebutuhan | Skala (MDI) | Keterangan |
|----|---------------------|-------------|------------|
| 1  | Tampilan website ultra-premium, responsif, dan bernuansa gelap (Anime.js style) | **D (Desirable)** | Nilai estetika tinggi |
| 2  | Animasi staggered entry pada card catalog & timelime interaktif | **D (Desirable)** | UX memukau |
| 3  | Fleksibilitas pemindahan server dengan deteksi Base URL otomatis | **M (Mandatory)** | Kemudahan demo universitas |
| 4  | Validasi format berkas unggahan KTP & bukti bayar (maksimal 2MB) | **M (Mandatory)** | Keamanan sistem berkas |

---

## 4. Elisitasi Tahap III (Final Draft Kebutuhan Sistem)
Daftar final kebutuhan sistem yang akan diimplementasikan penuh pada aplikasi **MOBILKU**:

### A. Fitur Utama Pengguna (Calon Pembeli)
* **Katalog Interaktif**: Pencarian unit mobil real-time dengan filter multi-kriteria berbasis AJAX (Tanpa reload halaman).
* **Checkout Booking**: Pemesanan unit instan dengan penguncian unit agar tidak bisa dipesan pembeli lain.
* **Portal Pelanggan (Customer Dashboard)**: 
  * Tracker timeline interaktif dengan garis progress bercahaya (Anime.js) untuk memantau status secara langsung.
  * Form pengunggahan scan berkas KTP & struk transfer DP 30%.
  * Form pengunggahan struk pelunasan 70%.
  * Pemilihan opsi serah terima (Ambil Sendiri / Kirim dengan alamat rumah).
  * Pengunduhan Kwitansi Pembayaran digital yang sah.

### B. Fitur Utama Pengguna (Penjual Perorangan)
* **Portal Sourcing**: Form pengajuan spesifikasi mobil bekas (Merk, model, nopol, tahun, nomer mesin/rangka).

### C. Fitur Administratif (Staff & Admin Showroom)
* **Approval Pembayaran**: Verifikasi pembayaran Booking Fee, DP, Pelunasan, dan Sourcing Transfer.
* **Timeline Controller**: Memperbarui status pengurusan berkas STNK (rata-rata 2 minggu) & BPKB (rata-rata 2 bulan).
* **Sourcing Checklist**: Menginput hasil inspeksi mobil masuk, memasukkan penawaran harga, dan memproses payout (Cash/Transfer).
* **Automated Ingestion**: Sistem otomatis mengonversi data mobil sourcing menjadi unit katalog aktif pasca payout lunas.

### D. Fitur Kurir Logistik
* **Courier Portal**: Daftar tugas pengantaran mobil pembeli beserta detail alamat.
* **Cargo Dispatch**: Pengunduhan lembaran Surat Jalan serah terima kendaraan tiga pihak.
