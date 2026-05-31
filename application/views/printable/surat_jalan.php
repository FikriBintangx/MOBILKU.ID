<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <!-- Google Fonts: Outfit for titles, IBM Plex Mono for technical specs -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --font-outfit: 'Outfit', sans-serif;
      --font-mono: 'IBM Plex Mono', monospace;
      --border-color: #eaeaea;
      --text-main: #111111;
      --text-muted: #666666;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-outfit);
      color: var(--text-main);
      background-color: #ffffff;
      line-height: 1.5;
      padding: 40px 20px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 48px;
      position: relative;
    }

    /* Dot grid decorative pattern */
    .container::before {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      width: 120px;
      height: 120px;
      background-image: radial-gradient(var(--border-color) 1.5px, transparent 1.5px);
      background-size: 8px 8px;
      opacity: 0.5;
      pointer-events: none;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 40px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 24px;
    }

    .brand h1 {
      font-size: 24px;
      font-weight: 800;
      letter-spacing: -0.5px;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .brand p {
      font-family: var(--font-mono);
      font-size: 10px;
      color: var(--text-muted);
      text-transform: uppercase;
    }

    .doc-meta {
      text-align: right;
    }

    .doc-meta h2 {
      font-size: 16px;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .doc-meta p {
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--text-muted);
    }

    .notice {
      background-color: #fafafa;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 16px 20px;
      font-size: 13px;
      margin-bottom: 32px;
    }

    .grid {
      display: grid;
      grid-template-cols: 1fr 1fr;
      gap: 24px;
      margin-bottom: 32px;
    }

    .card {
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 20px;
    }

    .card h3 {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-muted);
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 8px;
      margin-bottom: 12px;
    }

    .card p {
      font-size: 13px;
      margin-bottom: 4px;
    }

    .mono {
      font-family: var(--font-mono);
    }

    .specs-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 32px;
    }

    .specs-table th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--text-muted);
      border-bottom: 2px solid var(--text-main);
      padding: 8px;
    }

    .specs-table td {
      font-size: 13px;
      border-bottom: 1px solid var(--border-color);
      padding: 12px 8px;
    }

    .docs-section {
      background: #fafafa;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 20px;
      margin-bottom: 40px;
    }

    .docs-section h3 {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      margin-bottom: 12px;
    }

    .docs-list {
      list-style-type: none;
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-main);
    }

    .docs-list li {
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .signatures {
      display: grid;
      grid-template-cols: 1fr 1fr 1fr;
      gap: 24px;
      margin-top: 48px;
      text-align: center;
    }

    .sig-box {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 120px;
    }

    .sig-box p {
      font-size: 12px;
      color: var(--text-muted);
    }

    .sig-line {
      font-weight: 600;
      border-bottom: 1px solid var(--text-main);
      padding-bottom: 4px;
      margin-bottom: 4px;
      font-size: 13px;
    }

    .print-bar {
      max-width: 800px;
      margin: 24px auto 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-back {
      font-size: 13px;
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 600;
    }

    .btn-print {
      background-color: #000000;
      color: #ffffff;
      border: none;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
    }

    @media print {
      body {
        padding: 0;
      }
      .container {
        border: none;
        padding: 0;
      }
      .container::before {
        display: none;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <div class="container">
    
    <!-- Header -->
    <div class="header">
      <div class="brand">
        <h1>DRIVE.X LOGISTICS</h1>
        <p>Premium Vehicle Courier Service</p>
      </div>
      <div class="doc-meta">
        <h2>SURAT JALAN</h2>
        <p>No: <?php echo esc($delivery['nomor_surat'] ? $delivery['nomor_surat'] : 'SJ/TEMP'); ?></p>
        <p class="mono" style="margin-top: 4px;">Tgl Kirim: <?php echo date('d M Y', strtotime($delivery['tanggal_pengiriman'] ? $delivery['tanggal_pengiriman'] : date('Y-m-d'))); ?></p>
      </div>
    </div>

    <!-- Notice -->
    <div class="notice">
      Mohon diterima 1 (satu) unit kendaraan bermotor roda empat dalam kondisi baik, lengkap dengan surat-surat kendaraan serta kelengkapan serah terima standar showroom di bawah ini.
    </div>

    <!-- Receiver & Courier Info -->
    <div class="grid">
      <div class="card">
        <h3>Penerima Unit (Pembeli)</h3>
        <p><strong><?php echo esc($delivery['client_name']); ?></strong></p>
        <p class="mono"><?php echo esc($delivery['client_phone']); ?></p>
        <p style="margin-top: 8px; color: var(--text-muted); font-size: 12px;">Alamat Tujuan:</p>
        <p style="font-weight: 500; font-size: 12px;"><?php echo esc($delivery['alamat_tujuan']); ?></p>
      </div>
      <div class="card">
        <h3>Ekspedisi &amp; Kurir Pengirim</h3>
        <p><strong><?php echo esc($delivery['courier_name'] ? $delivery['courier_name'] : 'Kurir Logistik'); ?></strong></p>
        <p class="mono"><?php echo esc($delivery['courier_phone'] ? $delivery['courier_phone'] : '-'); ?></p>
        <p style="margin-top: 8px; color: var(--text-muted); font-size: 12px;">Kode Booking:</p>
        <p class="mono"><strong><?php echo esc($delivery['booking_code']); ?></strong></p>
      </div>
    </div>

    <!-- Vehicle Details Table -->
    <table class="specs-table">
      <thead>
        <tr>
          <th style="width: 40%;">Spesifikasi Kendaraan</th>
          <th style="width: 30%;">Identitas Rangka</th>
          <th style="width: 30%;">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong style="font-size: 14px; text-transform: uppercase;"><?php echo esc($delivery['brand'] . ' ' . $delivery['model']); ?></strong><br>
            <span style="font-size: 11px; color: var(--text-muted);">Tahun <?php echo $delivery['year']; ?> &bull; Warna <?php echo esc($delivery['color']); ?></span>
          </td>
          <td class="mono" style="font-size: 11px; line-height: 1.4;">
            No. Rangka: <?php echo esc($delivery['frame_number']); ?><br>
            No. Mesin: <?php echo esc($delivery['engine_number']); ?>
          </td>
          <td>
            Nomor Polisi:<br>
            <strong class="mono" style="font-size: 14px;"><?php echo esc($delivery['plate_number']); ?></strong>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Documents Checkboxes -->
    <div class="docs-section">
      <h3>DOKUMEN &amp; KELENGKAPAN YANG DISERAHKAN</h3>
      <ul class="docs-list">
        <li><i class="fa-regular fa-square-check"></i> 1 Unit Kunci Kontak Utama Kendaraan</li>
        <li><i class="fa-regular fa-square-check"></i> 1 Lembar Dokumen STNK Asli (Status STNK: <?php echo strtoupper($delivery['stnk_status'] ?? 'COMPLETED'); ?>)</li>
        <li>
          <?php if ($delivery['bpkb_status'] === 'completed'): ?>
            <i class="fa-regular fa-square-check"></i> 1 Lembar Buku BPKB Asli (Diserahkan Lunas)
          <?php else: ?>
            <i class="fa-regular fa-square"></i> Buku BPKB Asli (Status BPKB: PROSES - Diserahkan terpisah setelah 2 bulan pengurusan)
          <?php endif; ?>
        </li>
      </ul>
    </div>

    <!-- Signatures -->
    <div class="signatures">
      <div class="sig-box">
        <p>Pengirim (Showroom),</p>
        <div class="sig-line">Aditya W. Wibowo</div>
        <p>Logistics Coordinator</p>
      </div>
      <div class="sig-box">
        <p>Kurir Pengantar,</p>
        <div class="sig-line"><?php echo esc($delivery['courier_name'] ? $delivery['courier_name'] : 'Kurir Logistik'); ?></div>
        <p>Staff Ekspedisi</p>
      </div>
      <div class="sig-box">
        <p>Penerima (Pembeli),</p>
        <div class="sig-line"><?php echo esc($delivery['client_name']); ?></div>
        <p>Tanda Tangan &amp; Nama Terang</p>
      </div>
    </div>

  </div>

  <!-- Print Actions Bar -->
  <div class="print-bar no-print">
    <a href="javascript:window.close();" class="btn-back">
      <i class="fa-solid fa-arrow-left"></i> Tutup
    </a>
    <button onclick="window.print();" class="btn-print">
      <i class="fa-solid fa-print"></i> Cetak Surat Jalan
    </button>
  </div>

</body>
</html>
