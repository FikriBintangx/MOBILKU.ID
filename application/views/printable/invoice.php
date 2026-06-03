<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <!-- Google Fonts: Outfit for titles, IBM Plex Mono for data/numbers -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --font-outfit: 'Outfit', sans-serif;
      --font-mono: 'IBM Plex Mono', monospace;
      --bg-color: #ffffff;
      --text-main: #111111;
      --text-muted: #666666;
      --border-color: #eaeaea;
      --accent-color: #000000;
      --success-color: #10b981;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-outfit);
      color: var(--text-main);
      background-color: var(--bg-color);
      line-height: 1.5;
      padding: 40px 20px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .invoice-container {
      max-width: 800px;
      margin: 0 auto;
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 48px;
      background: #ffffff;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
      position: relative;
      overflow: hidden;
    }

    /* Decorative Nothing OS Dot Grid Pattern at top header corner */
    .invoice-container::before {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      width: 150px;
      height: 150px;
      background-image: radial-gradient(var(--border-color) 1.5px, transparent 1.5px);
      background-size: 8px 8px;
      opacity: 0.5;
      pointer-events: none;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 48px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 32px;
    }

    .brand-section h1 {
      font-size: 28px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      line-height: 1;
      margin-bottom: 6px;
    }

    .brand-section p {
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .meta-section {
      text-align: right;
    }

    .meta-section h2 {
      font-family: var(--font-mono);
      font-size: 14px;
      font-weight: 600;
      letter-spacing: -0.2px;
      margin-bottom: 4px;
      text-transform: uppercase;
    }

    .meta-section p {
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-muted);
    }

    .info-grid {
      display: grid;
      grid-template-cols: 1fr 1fr;
      gap: 32px;
      margin-bottom: 40px;
    }

    .info-card {
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 20px;
    }

    .info-card h3 {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
      margin-bottom: 12px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 6px;
    }

    .info-card p {
      font-size: 14px;
      margin-bottom: 4px;
    }

    .info-card p strong {
      font-weight: 600;
    }

    .mono-text {
      font-family: var(--font-mono);
      font-size: 13px;
    }

    .car-details {
      margin-bottom: 40px;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 24px;
      background: #fafafa;
    }

    .car-details h3 {
      font-size: 14px;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .car-details h3 span {
      font-family: var(--font-mono);
      font-size: 16px;
      font-weight: 700;
    }

    .specs-grid {
      display: grid;
      grid-template-cols: repeat(3, 1fr);
      gap: 16px;
    }

    .spec-item {
      display: flex;
      flex-direction: column;
    }

    .spec-label {
      font-size: 11px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 2px;
    }

    .spec-value {
      font-family: var(--font-mono);
      font-size: 13px;
      font-weight: 500;
    }

    .table-section {
      margin-bottom: 40px;
    }

    .table-section h3 {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
      margin-bottom: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    th {
      border-bottom: 2px solid var(--text-main);
      padding: 12px 8px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    td {
      border-bottom: 1px solid var(--border-color);
      padding: 16px 8px;
      font-size: 13px;
    }

    .amount-cell {
      text-align: right;
      font-family: var(--font-mono);
      font-weight: 500;
    }

    .summary-card {
      border-top: 2px solid var(--text-main);
      margin-top: 16px;
      padding-top: 16px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      width: 300px;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .summary-row.total {
      font-size: 18px;
      font-weight: 800;
      border-top: 1px solid var(--border-color);
      padding-top: 12px;
      margin-top: 8px;
    }

    .summary-row.total span:last-child {
      font-family: var(--font-mono);
    }

    .stamp-container {
      position: absolute;
      bottom: 48px;
      left: 48px;
    }

    .paid-stamp {
      border: 3px double var(--success-color);
      color: var(--success-color);
      font-family: var(--font-mono);
      font-size: 16px;
      font-weight: 700;
      text-transform: uppercase;
      padding: 8px 18px;
      border-radius: 8px;
      display: inline-block;
      transform: rotate(-8deg);
      letter-spacing: 2px;
      background-color: rgba(16, 185, 129, 0.03);
    }

    .footer {
      margin-top: 80px;
      display: flex;
      justify-content: flex-end;
    }

    .signature-block {
      text-align: center;
      width: 220px;
    }

    .signature-block p {
      font-size: 12px;
      color: var(--text-muted);
    }

    .signature-space {
      height: 70px;
    }

    .signature-name {
      font-weight: 600;
      border-bottom: 1px solid var(--text-main);
      padding-bottom: 4px;
      margin-bottom: 4px;
      font-size: 14px;
    }

    .actions-bar {
      max-width: 800px;
      margin: 24px auto 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-back {
      font-family: var(--font-outfit);
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s ease;
    }

    .btn-back:hover {
      color: var(--text-main);
    }

    .btn-print {
      font-family: var(--font-outfit);
      background-color: var(--accent-color);
      color: #ffffff;
      border: none;
      padding: 12px 24px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 12px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: opacity 0.2s ease;
    }

    .btn-print:hover {
      opacity: 0.9;
    }

    @media print {
      body {
        padding: 0;
        background-color: #ffffff;
      }
      .invoice-container {
        border: none;
        box-shadow: none;
        padding: 0;
        border-radius: 0;
      }
      .invoice-container::before {
        display: none;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <!-- Load fontawesome for print icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <div class="invoice-container">
    
    <!-- Stamp: Lunas / Paid -->
    <div class="stamp-container">
      <div class="paid-stamp">
        LUNAS / SELESAI
      </div>
    </div>

    <!-- Header Section -->
    <div class="header">
      <div class="brand-section">
        <h1>DRIVE.X</h1>
        <p>Premium Used Vehicles &amp; Sourcing</p>
      </div>
      <div class="meta-section">
        <h2>INVOICE RESMI</h2>
        <p>No: <?php echo $booking['booking_code']; ?></p>
        <p class="mono-text" style="margin-top: 4px;"><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></p>
      </div>
    </div>

    <!-- Info Grid (Buyer & Seller Info) -->
    <div class="info-grid">
      <div class="info-card">
        <h3>INFORMASI PEMBELI</h3>
        <p><strong><?php echo esc($booking['fullname']); ?></strong></p>
        <p class="mono-text"><?php echo esc($booking['email']); ?></p>
        <p class="mono-text"><?php echo esc($booking['phone']); ?></p>
        <p style="margin-top: 8px; font-size: 12px; color: var(--text-muted);">
          Metode Serah Terima: <br>
          <strong style="color: var(--text-main); font-family: var(--font-mono);">
            <?php echo $booking['delivery_type'] === 'delivery' ? 'KIRIM KE ALAMAT' : 'AMBIL LANGSUNG'; ?>
          </strong>
        </p>
        <?php if ($booking['delivery_type'] === 'delivery'): ?>
          <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
            Alamat: <?php echo esc($booking['delivery_address']); ?>
          </p>
        <?php endif; ?>
      </div>
      
      <div class="info-card">
        <h3>DIKELUARKAN OLEH</h3>
        <p><strong>DRIVE.X Head Office</strong></p>
        <p class="mono-text">billing@drivex.id</p>
        <p class="mono-text">+62 821-9988-7766</p>
        <p style="margin-top: 8px; font-size: 12px; color: var(--text-muted);">
          Status STNK: <strong style="color: var(--text-main); font-family: var(--font-mono);"><?php echo strtoupper($booking['stnk_status'] ?? 'PROSES'); ?></strong><br>
          Status BPKB: <strong style="color: var(--text-main); font-family: var(--font-mono);"><?php echo strtoupper($booking['bpkb_status'] ?? 'PROSES'); ?></strong>
        </p>
      </div>
    </div>

    <!-- Car Details -->
    <div class="car-details">
      <h3>
        <span>DETAIL KENDARAAN</span>
        <span><?php echo esc($booking['brand'] . ' ' . $booking['model']); ?></span>
      </h3>
      <div class="specs-grid">
        <div class="spec-item">
          <span class="spec-label">Tahun Pembuatan</span>
          <span class="spec-value"><?php echo $booking['year']; ?></span>
        </div>
        <div class="spec-item">
          <span class="spec-label">Warna</span>
          <span class="spec-value"><?php echo esc($booking['color']); ?></span>
        </div>
        <div class="spec-item">
          <span class="spec-label">Nomor Polisi</span>
          <span class="spec-value"><?php echo esc($booking['plate_number']); ?></span>
        </div>
        <div class="spec-item" style="margin-top: 8px;">
          <span class="spec-label">Nomor Rangka</span>
          <span class="spec-value"><?php echo esc($booking['frame_number']); ?></span>
        </div>
        <div class="spec-item" style="margin-top: 8px;">
          <span class="spec-label">Nomor Mesin</span>
          <span class="spec-value"><?php echo esc($booking['engine_number']); ?></span>
        </div>
        <div class="spec-item" style="margin-top: 8px;">
          <span class="spec-label">Tipe Transmisi</span>
          <span class="spec-value"><?php echo esc($booking['type'] ?? 'Automatic'); ?></span>
        </div>
      </div>
    </div>

    <!-- Payment Breakdown Table -->
    <div class="table-section">
      <h3>RIWAYAT PEMBAYARAN TERVERIFIKASI</h3>
      <table>
        <thead>
          <tr>
            <th style="width: 15%;">TANGGAL</th>
            <th style="width: 25%;">KODE TRANSAKSI</th>
            <th style="width: 20%;">METODE</th>
            <th style="width: 20%;">JENIS PEMBAYARAN</th>
            <th style="width: 20%; text-align: right;">NOMINAL</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $total_paid = 0;
          if (!empty($payments)): 
            foreach ($payments as $pay): 
              $total_paid += $pay['amount'];
          ?>
            <tr>
              <td class="mono-text"><?php echo date('d/m/y', strtotime($pay['created_at'])); ?></td>
              <td class="mono-text"><?php echo esc($pay['payment_code']); ?></td>
              <td><?php echo strtoupper($pay['payment_method']); ?> (<?php echo esc($pay['bank_name']); ?>)</td>
              <td>
                <?php 
                  if ($pay['payment_type'] === 'booking_fee') {
                    echo 'Booking Fee';
                  } elseif ($pay['payment_type'] === 'dp') {
                    echo 'Down Payment (DP)';
                  } else {
                    echo 'Pelunasan';
                  }
                ?>
              </td>
              <td class="amount-cell">Rp <?php echo number_format($pay['amount'], 0, ',', '.'); ?></td>
            </tr>
          <?php 
            endforeach; 
          else:
          ?>
            <tr>
              <td colspan="5" style="text-align: center; color: var(--text-muted);">Tidak ada riwayat pembayaran terverifikasi.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Summary Section -->
    <div class="summary-card">
      <div class="summary-row">
        <span>Harga Kendaraan</span>
        <span class="mono-text">Rp <?php echo number_format($booking['car_price'], 0, ',', '.'); ?></span>
      </div>
      <div class="summary-row">
        <span>Total Pembayaran Terverifikasi</span>
        <span class="mono-text">Rp <?php echo number_format($total_paid, 0, ',', '.'); ?></span>
      </div>
      <div class="summary-row total">
        <span>Sisa Tagihan</span>
        <span>Rp 0</span>
      </div>
    </div>

    <!-- Signature Footer -->
    <div class="footer">
      <div class="signature-block">
        <p>DRIVE.X Finance Officer,</p>
        <div class="signature-space"></div>
        <div class="signature-name">Aditya W. Wibowo</div>
        <p>Staff Administrasi Keuangan</p>
      </div>
    </div>

  </div>

  <!-- Actions Bar -->
  <div class="actions-bar no-print">
    <a href="javascript:window.close();" class="btn-back">
      <i class="fa-solid fa-arrow-left"></i> Tutup Halaman
    </a>
    <button onclick="window.print();" class="btn-print">
      <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
    </button>
  </div>

</body>
</html>
