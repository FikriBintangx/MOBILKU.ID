-- Database Schema for MOBILKU Second-Hand Car Platform
-- Designed for Semester 4 Academic Project

CREATE DATABASE IF NOT EXISTS `db_mobilku` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_mobilku`;

-- --------------------------------------------------------
-- 1. Table: `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `role` ENUM('client', 'staff', 'kurir', 'admin') NOT NULL DEFAULT 'client',
  `fullname` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 2. Table: `cars`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cars` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `brand` VARCHAR(50) NOT NULL,
  `model` VARCHAR(100) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `year` INT NOT NULL,
  `price` DECIMAL(12,2) NOT NULL,
  `color` VARCHAR(30) NOT NULL,
  `plate_number` VARCHAR(15) NOT NULL UNIQUE,
  `engine_number` VARCHAR(50) NOT NULL UNIQUE,
  `frame_number` VARCHAR(50) NOT NULL UNIQUE,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('available', 'booked', 'sold', 'sourced') NOT NULL DEFAULT 'available',
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 3. Table: `bookings`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_code` VARCHAR(20) NOT NULL UNIQUE,
  `user_id` INT NOT NULL,
  `car_id` INT NOT NULL,
  `booking_fee` DECIMAL(10,2) NOT NULL DEFAULT 500000.00,
  `booking_fee_status` ENUM('unpaid', 'paid') NOT NULL DEFAULT 'unpaid',
  `booking_date` DATETIME NOT NULL,
  `dp_deadline` DATETIME NOT NULL, -- booking_date + 7 days
  `dp_amount` DECIMAL(12,2) NOT NULL, -- 30% of price
  `dp_status` ENUM('unpaid', 'paid') NOT NULL DEFAULT 'unpaid',
  `dp_date` DATETIME DEFAULT NULL,
  `ktp_image` VARCHAR(255) DEFAULT NULL,
  `stnk_status` ENUM('processing', 'completed') NOT NULL DEFAULT 'processing',
  `stnk_completed_date` DATETIME DEFAULT NULL,
  `bpkb_status` ENUM('processing', 'completed') NOT NULL DEFAULT 'processing',
  `bpkb_completed_date` DATETIME DEFAULT NULL,
  `remaining_payment` DECIMAL(12,2) NOT NULL, -- 70% of price
  `pelunasan_status` ENUM('unpaid', 'paid') NOT NULL DEFAULT 'unpaid',
  `pelunasan_date` DATETIME DEFAULT NULL,
  `delivery_type` ENUM('pickup', 'delivery') DEFAULT NULL,
  `delivery_address` TEXT DEFAULT NULL,
  `delivery_status` ENUM('none', 'pending', 'shipping', 'delivered') NOT NULL DEFAULT 'none',
  `status` ENUM('ordered', 'active', 'cancelled', 'completed') NOT NULL DEFAULT 'ordered',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`car_id`) REFERENCES `cars`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 4. Table: `car_sourcing`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `car_sourcing` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `owner_name` VARCHAR(100) NOT NULL,
  `owner_phone` VARCHAR(20) NOT NULL,
  `owner_address` TEXT NOT NULL,
  `car_brand` VARCHAR(50) NOT NULL,
  `car_model` VARCHAR(100) NOT NULL,
  `car_year` INT NOT NULL,
  `car_plate` VARCHAR(15) NOT NULL,
  `engine_number` VARCHAR(50) NOT NULL,
  `frame_number` VARCHAR(50) NOT NULL,
  `inspection_date` DATETIME DEFAULT NULL,
  `inspection_notes` TEXT DEFAULT NULL,
  `price_offered` DECIMAL(12,2) DEFAULT NULL,
  `payment_method` ENUM('cash', 'transfer') DEFAULT 'transfer',
  `bank_name` VARCHAR(50) DEFAULT NULL,
  `bank_account` VARCHAR(30) DEFAULT NULL,
  `bank_holder` VARCHAR(100) DEFAULT NULL,
  `payment_status` ENUM('unpaid', 'paid') NOT NULL DEFAULT 'unpaid',
  `payment_date` DATETIME DEFAULT NULL,
  `receipt_number` VARCHAR(50) DEFAULT NULL,
  `status` ENUM('pending', 'inspected', 'purchased', 'rejected') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 5. Table: `payments`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `payment_code` VARCHAR(30) NOT NULL UNIQUE,
  `booking_id` INT DEFAULT NULL,
  `sourcing_id` INT DEFAULT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `payment_type` ENUM('booking_fee', 'dp', 'pelunasan', 'purchase_payout') NOT NULL,
  `payment_method` ENUM('cash', 'transfer') NOT NULL,
  `bank_name` VARCHAR(50) DEFAULT NULL,
  `bank_account` VARCHAR(30) DEFAULT NULL,
  `bank_holder` VARCHAR(100) DEFAULT NULL,
  `evidence_image` VARCHAR(255) DEFAULT NULL,
  `receipt_number` VARCHAR(50) DEFAULT NULL,
  `status` ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`sourcing_id`) REFERENCES `car_sourcing`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 6. Table: `documents`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `documents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `document_type` ENUM('ktp', 'stnk', 'bpkb', 'surat_jalan') NOT NULL,
  `document_number` VARCHAR(50) DEFAULT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'delivered') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 7. Table: `kurir`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurir` (
  `id_kurir` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `no_hp` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `alamat` TEXT NOT NULL,
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 8. Table: `pengiriman`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pengiriman` (
  `id_pengiriman` INT AUTO_INCREMENT PRIMARY KEY,
  `id_transaksi` INT NOT NULL,
  `id_kurir` INT DEFAULT NULL,
  `tanggal_pengiriman` DATETIME DEFAULT NULL,
  `alamat_tujuan` TEXT NOT NULL,
  `status_pengiriman` ENUM('Menunggu Penugasan', 'Kurir Ditugaskan', 'Menunggu Penjemputan', 'Kendaraan Dipersiapkan', 'Dalam Perjalanan', 'Tiba di Lokasi', 'Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai', 'Gagal Kirim', 'Dibatalkan') NOT NULL DEFAULT 'Menunggu Penugasan',
  `catatan` TEXT,
  FOREIGN KEY (`id_transaksi`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_kurir`) REFERENCES `kurir`(`id_kurir`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 9. Table: `surat_jalan`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `surat_jalan` (
  `id_surat_jalan` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pengiriman` INT NOT NULL,
  `nomor_surat` VARCHAR(50) NOT NULL UNIQUE,
  `tanggal` DATE NOT NULL,
  FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman`(`id_pengiriman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 10. Table: `bukti_pengiriman`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bukti_pengiriman` (
  `id_bukti` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pengiriman` INT NOT NULL,
  `foto_serah_terima` VARCHAR(255) DEFAULT NULL,
  `tanda_tangan_penerima` VARCHAR(255) DEFAULT NULL,
  `foto_kendaraan` VARCHAR(255) DEFAULT NULL,
  `waktu_upload` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman`(`id_pengiriman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 11. Table: `tracking_lokasi`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tracking_lokasi` (
  `id_tracking` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pengiriman` INT NOT NULL,
  `latitude` DECIMAL(10,8) NOT NULL,
  `longitude` DECIMAL(11,8) NOT NULL,
  `speed` DECIMAL(5,2) DEFAULT '0.00',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman`(`id_pengiriman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 12. Table: `riwayat_status`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `riwayat_status` (
  `id_status` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pengiriman` INT NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `waktu` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman`(`id_pengiriman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 13. Table: `ratings`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `id_pengiriman` INT NOT NULL,
  `rating_showroom` INT NOT NULL,
  `rating_kurir` INT NOT NULL,
  `review_text` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman`(`id_pengiriman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Seeds for Testing

-- --------------------------------------------------------

-- Insert standard users (Passwords: plain 'admin123' / 'client123' etc. for university grading demo)
INSERT INTO `users` (`username`, `password`, `email`, `role`, `fullname`, `phone`) VALUES
('admin', 'admin123', 'admin@mobilku.com', 'admin', 'Super Administrator', '08123456789'),
('staff', 'staff123', 'staff@mobilku.com', 'staff', 'Staff Admin Keuangan', '08987654321'),
('kurir', 'kurir123', 'kurir@mobilku.com', 'kurir', 'Kurir Pengirim', '08111222333'),
('isagi', 'client123', 'isagi@example.com', 'client', 'Isagi Yoichi', '08129999888'),
('bachira', 'client123', 'bachira@example.com', 'client', 'Bachira Meguru', '08128888777');

-- Insert initial cars catalog
INSERT INTO `cars` (`brand`, `model`, `type`, `year`, `price`, `color`, `plate_number`, `engine_number`, `frame_number`, `image_url`, `status`, `description`) VALUES
('Honda', 'Civic Turbo 1.5 RS', 'Sedan', 2021, 420000000.00, 'Rallye Red', 'B 1010 TUR', 'L15B7-123456', 'MHRFC12345J-10101', 'civic.png', 'available', 'Mobil Honda Civic Turbo RS kondisi sangat prima, servis rutin Honda, kilometer rendah 25.000 KM.'),
('Toyota', 'Innova Reborn 2.4 G Diesel', 'MPV', 2020, 315000000.00, 'Super White', 'B 2291 TYA', '2GD-FTV-98765', 'MHFK24987J-20202', 'innova.png', 'available', 'Innova Reborn Diesel G AT, irit bertenaga, interior bersih terawat, ban baru, siap luar kota.'),
('Mazda', 'Mazda 3 Hatchback', 'Hatchback', 2022, 465000000.00, 'Soul Red Crystal', 'B 303 MZD', 'PE-VPS-334455', 'JM1BP23344J-30303', 'mazda3.png', 'available', 'Mazda 3 Hatchback dengan visual KODO design elegan, warna Soul Red Crystal premium, full original.'),
('Mitsubishi', 'Pajero Sport 2.4 Dakar', 'SUV', 2019, 445000000.00, 'Titanium Grey', 'B 777 DKR', '4N15-778899', 'MMBJR4N15J-77777', 'pajero.png', 'available', 'Pajero Sport Dakar AT, tangguh di segala medan, sunroof aktif, record Mitsubishi resmi, istimewa.'),
('Suzuki', 'Ertiga Hybrid SS', 'MPV', 2023, 235000000.00, 'Metallic Magma Grey', 'B 552 SJK', 'K15B-445566', 'MHFEB15B4J-55555', 'ertiga.png', 'available', 'Suzuki Ertiga Hybrid Smart Sporty, sangat irit bahan bakar, plat ganjil, interior wangi orisinil.');

-- --------------------------------------------------------
-- Seeds for Courier and Tracking System
-- --------------------------------------------------------

INSERT INTO `kurir` (`id_kurir`, `nama`, `email`, `no_hp`, `password`, `alamat`, `status`) VALUES 
(1, 'Kurir Pengirim', 'kurir@mobilku.com', '08111222333', 'kurir123', 'Showroom DRIVE.X Head Office', 'active');

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `car_id`, `booking_fee`, `booking_fee_status`, `booking_date`, `dp_deadline`, `dp_amount`, `dp_status`, `dp_date`, `ktp_image`, `stnk_status`, `stnk_completed_date`, `bpkb_status`, `bpkb_completed_date`, `remaining_payment`, `pelunasan_status`, `pelunasan_date`, `delivery_type`, `delivery_address`, `delivery_status`, `status`, `created_at`) VALUES 
(4, 'BKG-A0E04-2026', 4, 1, 500000.00, 'paid', '2026-05-31 18:35:22', '2026-06-07 18:35:22', 126000000.00, 'paid', '2026-05-31 18:38:58', 'Screenshot_2026-05-29_170550.png', 'completed', '2026-05-31 18:47:50', 'completed', '2026-05-31 18:47:55', 294000000.00, 'paid', '2026-05-31 18:46:14', 'pickup', NULL, 'none', 'completed', '2026-06-01 01:35:22'),
(5, 'BKG-88E21-2026', 4, 2, 500000.00, 'paid', '2026-05-31 18:50:48', '2026-06-07 18:50:48', 94500000.00, 'paid', '2026-05-31 18:53:02', 'Screenshot_2026-05-30_010228.png', 'processing', NULL, 'processing', NULL, 220500000.00, 'paid', '2026-05-31 18:55:17', 'delivery', 'Pasir Gadung, Cikupa, Tangerang Regency, Banten, Java, 15710, Indonesia', 'delivered', 'completed', '2026-06-01 01:50:48');

INSERT INTO `pengiriman` (`id_pengiriman`, `id_transaksi`, `id_kurir`, `tanggal_pengiriman`, `alamat_tujuan`, `status_pengiriman`, `catatan`) VALUES 
(1, 5, 1, '2026-05-31 18:54:58', 'Pasir Gadung, Cikupa, Tangerang Regency, Banten, Java, 15710, Indonesia', 'Selesai', 'Penerima menyatakan kendaraan telah sampai di lokasi.');

INSERT INTO `surat_jalan` (`id_surat_jalan`, `id_pengiriman`, `nomor_surat`, `tanggal`) VALUES 
(1, 1, 'SJ/20260531/00001', '2026-05-31');

INSERT INTO `bukti_pengiriman` (`id_bukti`, `id_pengiriman`, `foto_serah_terima`, `tanda_tangan_penerima`, `foto_kendaraan`, `waktu_upload`) VALUES 
(1, 1, '4ef739ce8ebf91a7d8b9594d0b284932.png', '1bdc44723f027e5b1afaf10b6fdcdb3d.png', '64c48c653ab0c3672540c65a374b2823.png', '2026-05-31 19:00:00');

INSERT INTO `riwayat_status` (`id_status`, `id_pengiriman`, `status`, `waktu`) VALUES 
(1, 1, 'Menunggu Penugasan', '2026-05-31 18:54:58'),
(2, 1, 'Kurir Ditugaskan', '2026-05-31 18:57:19'),
(3, 1, 'Dalam Perjalanan', '2026-05-31 18:59:26'),
(4, 1, 'Tiba di Lokasi', '2026-05-31 18:59:46'),
(5, 1, 'Diserahkan ke Pembeli', '2026-05-31 19:00:00'),
(6, 1, 'Selesai', '2026-05-31 19:02:03');

INSERT INTO `ratings` (`id`, `booking_id`, `id_pengiriman`, `rating_showroom`, `rating_kurir`, `review_text`, `created_at`) VALUES 
(1, 5, 1, 4, 4, 'Sangat puas dengan pelayanan DRIVE.X!', '2026-06-01 02:02:03');

