<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo $title; ?></title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      color: #111;
      background-color: #fff;
      padding: 40px;
      font-size: 11px;
      line-height: 1.4;
    }
    .report-container {
      max-width: 900px;
      margin: 0 auto;
      border: 1px solid #000;
      padding: 30px;
    }
    .header {
      border-bottom: 2px dashed #000;
      padding-bottom: 15px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .brand {
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 2px;
      text-transform: uppercase;
    }
    .brand-sub {
      font-size: 9px;
      color: #666;
      margin-top: 3px;
    }
    .doc-title {
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
      text-align: right;
    }
    .doc-meta {
      font-size: 9px;
      color: #555;
      text-align: right;
      margin-top: 4px;
    }
    .summary-box {
      display: grid;
      grid-template-cols: repeat(4, 1fr);
      gap: 10px;
      margin-bottom: 25px;
    }
    .summary-card {
      border: 1px solid #000;
      padding: 12px;
      background-color: #fafafa;
    }
    .summary-label {
      font-size: 8px;
      color: #666;
      text-transform: uppercase;
      font-weight: bold;
    }
    .summary-value {
      font-size: 12px;
      font-weight: bold;
      margin-top: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    th {
      border-bottom: 2px solid #000;
      padding: 8px 4px;
      text-transform: uppercase;
      font-weight: bold;
      text-align: left;
      font-size: 10px;
    }
    td {
      border-bottom: 1px dotted #ccc;
      padding: 8px 4px;
      vertical-align: top;
    }
    .text-right {
      text-align: right;
    }
    .bold {
      font-weight: bold;
    }
    .badge {
      border: 1px solid #000;
      padding: 1px 6px;
      font-size: 8px;
      font-weight: bold;
      text-transform: uppercase;
      display: inline-block;
    }
    .footer {
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }
    .signature {
      text-align: center;
      width: 200px;
    }
    .sig-line {
      border-bottom: 1px solid #000;
      margin-top: 50px;
      font-weight: bold;
      padding-bottom: 5px;
    }
    .print-controls {
      max-width: 900px;
      margin: 20px auto 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: sans-serif;
    }
    .btn {
      padding: 8px 16px;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      font-size: 11px;
      text-transform: uppercase;
    }
    .btn-outline {
      background: transparent;
      color: #000;
      border: 1px solid #000;
      margin-right: 10px;
    }
    @media print {
      .print-controls {
        display: none !important;
      }
      body {
        padding: 0;
      }
      .report-container {
        border: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <div class="print-controls">
    <div>
      <button onclick="window.history.back()" class="btn btn-outline">&larr; Kembali</button>
      <button onclick="window.print()" class="btn">Cetak PDF / Print</button>
    </div>
    <span style="font-size: 11px; color: #666;">*Gunakan opsi cetak Landscape/Potrait sesuai kenyamanan browser Anda.</span>
  </div>

  <div class="report-container">
    <div class="header">
      <div>
        <div class="brand">DRIVE.X Platform</div>
        <div class="brand-sub">Premium Second-Hand Car & Transaksi Sourcing</div>
      </div>
      <div>
        <div class="doc-title">Laporan Pertanggungjawaban Ledger</div>
        <div class="doc-meta">Tanggal Cetak: <?php echo date('d M Y H:i'); ?><br>Tipe Laporan: <?php echo strtoupper($filter_type); ?></div>
      </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
      <?php if ($filter_type !== 'pembelian'): ?>
        <div class="summary-card">
          <div class="summary-label">Total Penjualan</div>
          <div class="summary-value">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></div>
        </div>
        <div class="summary-card">
          <div class="summary-label">Transaksi Penjualan</div>
          <div class="summary-value"><?php echo $count_sales; ?> Unit</div>
        </div>
      <?php endif; ?>

      <?php if ($filter_type !== 'penjualan'): ?>
        <div class="summary-card">
          <div class="summary-label">Total Sourcing (Beli)</div>
          <div class="summary-value">Rp <?php echo number_format($total_purchases, 0, ',', '.'); ?></div>
        </div>
        <div class="summary-card">
          <div class="summary-label">Transaksi Pembelian</div>
          <div class="summary-value"><?php echo $count_purchases; ?> Unit</div>
        </div>
      <?php endif; ?>
    </div>

    <!-- TABLE AREA -->
    <?php if ($filter_type !== 'pembelian'): ?>
      <h3 style="font-size:12px; font-weight:bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 30px;">A. LEDGER PENJUALAN UNIT (CLIENT ORDER)</h3>
      <table>
        <thead>
          <tr>
            <th>No Booking</th>
            <th>Pembeli</th>
            <th>Kendaraan</th>
            <th>Booking Fee</th>
            <th>DP (30%)</th>
            <th>Pelunasan (70%)</th>
            <th class="text-right">Total Masuk</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($sales_data)): ?>
            <?php foreach ($sales_data as $s): ?>
              <tr>
                <td class="bold"><?php echo $s['booking_code']; ?></td>
                <td><?php echo $s['fullname']; ?></td>
                <td><?php echo $s['brand'] . ' ' . $s['model'] . ' (' . $s['plate_number'] . ')'; ?></td>
                <td>Rp 500.000</td>
                <td>Rp <?php echo number_format($s['dp_amount'], 0, ',', '.'); ?></td>
                <td>Rp <?php echo number_format($s['remaining_payment'], 0, ',', '.'); ?></td>
                <td class="text-right bold">
                  <?php 
                    $in = 0;
                    if ($s['booking_fee_status'] === 'paid') $in += 500000;
                    if ($s['dp_status'] === 'paid') $in += $s['dp_amount'];
                    if ($s['pelunasan_status'] === 'paid') $in += $s['remaining_payment'];
                    echo 'Rp ' . number_format($in, 0, ',', '.');
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align:center; padding:20px; color:#666;">Tidak ada transaksi penjualan dalam periode ini.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <?php if ($filter_type !== 'penjualan'): ?>
      <h3 style="font-size:12px; font-weight:bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 30px;">B. LEDGER PEMBELIAN UNIT (CAR SOURCING)</h3>
      <table>
        <thead>
          <tr>
            <th>No Kwitansi</th>
            <th>Pemilik / Penjual</th>
            <th>Unit Kendaraan</th>
            <th>Nopol / KM</th>
            <th>Metode Payout</th>
            <th class="text-right">Total Keluar (Harga Beli)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($purchase_data)): ?>
            <?php foreach ($purchase_data as $p): ?>
              <tr>
                <td class="bold"><?php echo $p['receipt_number'] ? $p['receipt_number'] : 'CS-TEMP-'.$p['id']; ?></td>
                <td><?php echo $p['owner_name']; ?></td>
                <td><?php echo $p['car_brand'] . ' ' . $p['car_model'] . ' (' . $p['car_year'] . ')'; ?></td>
                <td><?php echo $p['car_plate']; ?> / <?php echo number_format($p['mileage'], 0, ',', '.'); ?> KM</td>
                <td><div class="badge"><?php echo strtoupper($p['payout_method'] ?? 'cash'); ?></div></td>
                <td class="text-right bold">Rp <?php echo number_format($p['price_offered'], 0, ',', '.'); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center; padding:20px; color:#666;">Tidak ada transaksi pembelian sourcing dalam periode ini.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="footer">
      <div>
        <div style="font-size: 9px; color: #666;">*Dokumen ini merupakan arsip laporan keuangan resmi dari DRIVE.X platform.</div>
      </div>
      <div class="signature">
        <div>Jakarta, <?php echo date('d M Y'); ?></div>
        <div style="font-size: 9px; color: #555; margin-bottom: 50px;">Otoritas Verifikasi Keuangan</div>
        <div class="sig-line"><?php echo $this->session->userdata('fullname'); ?></div>
        <div style="font-size: 8px; color: #666; text-transform: uppercase;">Peran: <?php echo $this->session->userdata('role'); ?></div>
      </div>
    </div>
  </div>

</body>
</html>
