# Dokumentasi Diagram UML - MOBILKU
**Mata Kuliah: Analisis dan Perancangan Sistem Informasi (Semester 4)**

---

## 1. Panduan Integrasi Draw.io
Showroom Anda sudah memiliki beberapa file `.drawio` di folder [diagram-mobil](file:///c:/Users/ISAGI/OneDrive/Documents/SEMESTER%204/MOBILKU/diagram-mobil). Dokumen ini menyajikan model rancangan usulan terbaru dalam format **Mermaid UML Syntax** interaktif. Anda dapat langsung menyalin kode Mermaid di bawah ini ke editor online (seperti [mermaid.live](https://mermaid.live)) untuk mengekspor gambar vector (.png/.svg) untuk laporan kuliah Anda, atau memperbarui diagram Draw.io Anda berdasarkan struktur matang di bawah.

---

## 2. Use Case Diagram
Menggambarkan interaksi aktor (Calon Pembeli, Penjual Perorangan, Staff/Admin, Kurir) dengan fungsionalitas sistem **MOBILKU**.

```mermaid
usecaseDiagram
    actor Pembeli as "Calon Pembeli"
    actor Penjual as "Penjual Perorangan"
    actor Staff as "Staff / Admin Showroom"
    actor Kurir as "Kurir Logistik"

    %% Pembeli Use Cases
    Pembeli --> (Lihat Katalog & Filter Mobil)
    Pembeli --> (Checkout Booking Fee Rp 500rb)
    Pembeli --> (Unggah DP 30% & Scan KTP)
    Pembeli --> (Unggah Bukti Pelunasan 70%)
    Pembeli --> (Konfigurasi Serah Terima)
    Pembeli --> (Lacak Timeline Administrasi)

    %% Penjual Use Cases
    Penjual --> (Tawarkan Mobil / Sourcing Form)

    %% Staff / Admin Use Cases
    Staff --> (Verifikasi Pembayaran & Beri Kwitansi)
    Staff --> (Update Status STNK & BPKB)
    Staff --> (Input Hasil Inspeksi Sourcing)
    Staff --> (Proses Pembayaran Sourcing & Payout)
    Staff --> (Kelola Inventori Mobil)

    %% Kurir Use Cases
    Kurir --> (Lihat Jadwal & Dashboard Pengiriman)
    Kurir --> (Unduh/Cetak Surat Jalan)
    Kurir --> (Update Status Pengiriman)
    Kurir --> (Unggah Bukti Serah Terima & Foto)
    Kurir --> (Lihat Riwayat Pengiriman)
```

---

## 3. Class Diagram
Menggambarkan struktur kelas, relasi database (Active Record), dan kardinalitas antar entitas dalam sistem **MOBILKU**.

```mermaid
classDiagram
    class User {
        +int id (PK)
        +string username
        +string password
        +string email
        +enum role
        +string fullname
        +string phone
        +timestamp created_at
        +register()
        +login()
    }

    class Car {
        +int id (PK)
        +string brand
        +string model
        +string type
        +int year
        +decimal price
        +string color
        +string plate_number
        +string engine_number
        +string frame_number
        +string image_url
        +enum status
        +text description
        +insert_car()
        +update_status()
    }

    class Booking {
        +int id (PK)
        +string booking_code
        +int user_id (FK)
        +int car_id (FK)
        +decimal booking_fee
        +enum booking_fee_status
        +datetime booking_date
        +datetime dp_deadline
        +decimal dp_amount
        +enum dp_status
        +datetime dp_date
        +string ktp_image
        +enum stnk_status
        +datetime stnk_completed_date
        +enum bpkb_status
        +datetime bpkb_completed_date
        +decimal remaining_payment
        +enum pelunasan_status
        +datetime pelunasan_date
        +enum delivery_type
        +text delivery_address
        +enum delivery_status
        +enum status
        +create_booking()
        +cancel_booking()
        +set_fulfillment()
    }

    class CarSourcing {
        +int id (PK)
        +string owner_name
        +string owner_phone
        +text owner_address
        +string car_brand
        +string car_model
        +int car_year
        +string car_plate
        +string engine_number
        +string frame_number
        +datetime inspection_date
        +text inspection_notes
        +decimal price_offered
        +enum payment_method
        +string bank_name
        +string bank_account
        +string bank_holder
        +enum payment_status
        +datetime payment_date
        +string receipt_number
        +enum status
        +create_request()
        +record_inspection()
        +record_payout()
    }

    class Payment {
        +int id (PK)
        +string payment_code
        +int booking_id (FK)
        +int sourcing_id (FK)
        +decimal amount
        +enum payment_type
        +enum payment_method
        +string bank_name
        +string bank_account
        +string bank_holder
        +string evidence_image
        +string receipt_number
        +enum status
        +log_payment()
        +verify_payment()
    }

    class Document {
        +int id (PK)
        +int booking_id (FK)
        +enum document_type
        +string document_number
        +string file_path
        +enum status
        +insert_document()
        +deliver_document()
    }

    class Courier {
        +int id_kurir (PK)
        +string nama
        +string email
        +string no_hp
        +string password
        +text alamat
        +enum status
    }

    class Delivery {
        +int id_pengiriman (PK)
        +int id_transaksi (FK)
        +int id_kurir (FK)
        +datetime tanggal_pengiriman
        +text alamat_tujuan
        +enum status_pengiriman
        +text catatan
        +create_delivery()
        +assign_courier()
        +update_delivery_status()
    }

    class SuratJalan {
        +int id_surat_jalan (PK)
        +int id_pengiriman (FK)
        +string nomor_surat
        +date tanggal
        +generate_surat_jalan()
    }

    class DeliveryProof {
        +int id_bukti (PK)
        +int id_pengiriman (FK)
        +string foto_serah_terima
        +string tanda_tangan_penerima
        +string foto_kendaraan
        +timestamp waktu_upload
        +upload_delivery_proof()
    }

    User "1" --> "0..*" Booking : makes
    Car "1" --> "0..1" Booking : ordered_in
    Booking "1" --> "0..*" Payment : triggers
    Booking "1" --> "0..*" Document : belongs_to
    CarSourcing "1" --> "0..1" Payment : triggers
    
    Booking "1" --> "0..1" Delivery : triggers
    Courier "1" --> "0..*" Delivery : handles
    Delivery "1" --> "0..1" SuratJalan : generates
    Delivery "1" --> "0..1" DeliveryProof : verifies
```

---

## 4. Activity Diagram (Alur Jual-Beli Mobil)
Menggambarkan alur aktivitas transaksi pembelian mobil bekas, mencakup tenggat waktu DP 1 minggu, pengurusan STNK & BPKB, serta serah terima unit.

```mermaid
stateDiagram-v2
    [*] --> CariMobil : Calon Pembeli Memilih Mobil
    CariMobil --> BayarBookingFee : Setuju Membeli
    BayarBookingFee --> TungguDP : Membayar Bukti Pesanan Rp 500rb
    
    state TungguDP {
        [*] --> CekWaktu
        CekWaktu --> BatalOverdue : Lebih Dari 1 Minggu (7 Hari)
        CekWaktu --> BayarDP_KTP : Kurang Dari 1 Minggu
        BayarDP_KTP --> SelesaiDP : Unggah DP 30% & Scan KTP
    }

    BatalOverdue --> UangHangus : Booking Fee Rp 500rb Hangus
    UangHangus --> [*] : Pesanan Batal Otomatis

    state OpsiCancellable {
        BayarDP_KTP --> BatalkanManual : Klik Batal Manual (< 1 Minggu)
        BatalkanManual --> UangKembali : Booking Fee Dikembalikan Penuh
    }
    UangKembali --> [*] : Pesanan Batal Manual

    SelesaiDP --> VerifikasiAdmin : Staff Admin Memverifikasi Berkas
    VerifikasiAdmin --> PengurusanDokumen : Berkas Valid (DP Lunas)
    
    state PengurusanDokumen {
        [*] --> STNK_Proses : Urus STNK (Rata-rata 2 Minggu)
        [*] --> BPKB_Proses : Urus BPKB (Rata-rata 2 Bulan)
    }

    STNK_Proses --> TungguPelunasan : Sambil Menunggu STNK Selesai
    TungguPelunasan --> BayarPelunasan : Pembeli Membayar Sisa 70%
    BayarPelunasan --> SerahTerimaUnit : STNK Selesai & Pelunasan Lunas

    state SerahTerimaUnit {
        [*] --> OpsiSerahTerima
        OpsiSerahTerima --> AmbilShowroom : Pickup Sendiri
        OpsiSerahTerima --> KirimRumah : Diantar Kurir
        KirimRumah --> SuratJalan : Kurir Membawa Surat Jalan
    }

    SerahTerimaUnit --> TungguBPKB : Unit Mobil Diterima Pembeli
    BPKB_Proses --> SerahTerimaBPKB : BPKB Selesai (2 Bulan)
    TungguBPKB --> SerahTerimaBPKB : Serah Terimakan BPKB
    SerahTerimaBPKB --> TransaksiSelesai : Selesai
    TransaksiSelesai --> [*]
```

---

## 5. Sequence Diagram (Booking & Timeline Checklist)
Menggambarkan interaksi antar objek sistem berdasarkan urutan waktu dari pemesanan hingga serah terima berkas BPKB.

```mermaid
sequenceDiagram
    autonumber
    actor Pembeli as Calon Pembeli
    participant Web as Sistem Web MOBILKU
    participant DB as MySQL Database
    participant Admin as Staff Admin Showroom
    actor Kurir as Kurir Logistik

    %% 1. Booking Fee Checkout
    Pembeli->>Web: Pilih Unit & Klik Pesan Sekarang
    Web->>DB: create_booking() & lock_car_status()
    DB-->>Web: ID Booking Berhasil dibuat (Status: Ordered)
    Web->>Pembeli: Tampilkan Tagihan Bukti Pesanan (Rp 500.000)
    Pembeli->>Web: Bayar Bukti Pesanan & Kirim
    Web->>DB: log_payment(booking_fee) & verify_payment()
    DB-->>Web: Status Booking menjadi Active
    Web-->>Pembeli: Beri Notifikasi (Tenggat DP: 7 Hari)

    %% 2. DP 30% and KTP upload
    Note over Pembeli, Admin: Batas Waktu 1 Minggu (7 Hari)
    Pembeli->>Web: Unggah Scan KTP & Bukti Transfer DP 30%
    Web->>DB: upload_dp_ktp() & log_payment(dp)
    DB-->>Web: Data disimpan (Status Pembayaran: Pending)
    Admin->>Web: Buka Admin Panel & Cek Berkas DP
    Admin->>Web: Klik Setujui Pembayaran DP
    Web->>DB: verify_payment(dp)
    DB-->>Web: Status DP menjadi Paid
    Web-->>Admin: Cetak Kwitansi DP Otomatis
    Web-->>Pembeli: Status Pesanan Diperbarui

    %% 3. Document Processing
    Note over Admin, DB: Pengurusan STNK (2 Minggu) & BPKB (2 Bulan)
    Admin->>Web: Mulai Pengurusan STNK & BPKB
    Pembeli->>Web: Lacak Timeline (Progress Bar Naik)
    Pembeli->>Web: Unggah Bukti Pelunasan Sisa 70%
    Web->>DB: log_payment(pelunasan)
    Admin->>Web: Klik Setujui Pembayaran Pelunasan
    Web->>DB: verify_payment(pelunasan)
    DB-->>Web: Status Pelunasan menjadi Paid
    Web-->>Admin: Cetak Kwitansi Pelunasan
    Admin->>Web: Set Status STNK selesai (2 minggu)
    Web->>DB: update_doc_progress(stnk, completed)

    %% 4. Handover & Surat Jalan
    Pembeli->>Web: Pilih Metode Serah Terima (Kirim Ke Rumah)
    Web->>DB: set_fulfillment(delivery, alamat)
    DB->>DB: insert_document(surat_jalan)
    Web-->>Pembeli: Beri Notifikasi Jadwal Pengiriman
    Kurir->>Web: Buka Portal Kurir & Unduh Surat Jalan
    Kurir->>Pembeli: Antar Mobil & Tanda Tangan Surat Jalan
    Kurir->>Web: Update Status Pengiriman (Delivered)
    Web->>DB: update_delivery_status(delivered)

    %% 5. BPKB Handover
    Note over Admin, Pembeli: Setelah 2 Bulan
    Admin->>Web: Set Status BPKB selesai
    Web->>DB: update_doc_progress(bpkb, completed)
    Admin->>Pembeli: Serah Terimakan Dokumen BPKB Asli
    Admin->>Web: Selesaikan Pesanan (Handover Complete)
    Web->>DB: complete_booking() & update_car_status(sold)
    DB-->>Web: Sukses
    Web-->>Pembeli: Transaksi Selesai Total
```
