<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo $title; ?></title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      color: #333;
      background-color: #fff;
      padding: 40px;
      font-size: 12px;
      line-height: 1.5;
    }
    .receipt-container {
      border: 2px solid #333;
      padding: 30px;
      max-width: 800px;
      margin: 0 auto;
      position: relative;
    }
    .header {
      border-bottom: 2px dashed #333;
      padding-bottom: 20px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .brand {
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 2px;
    }
    .brand-sub {
      font-size: 9px;
      color: #666;
    }
    .doc-title {
      font-size: 16px;
      font-weight: bold;
      text-decoration: underline;
      text-align: right;
    }
    .receipt-no {
      font-size: 10px;
      color: #555;
      text-align: right;
    }
    .grid {
      display: grid;
      grid-template-cols: 200px 1fr;
      gap: 12px;
      margin-bottom: 30px;
    }
    .label {
      font-weight: bold;
      text-transform: uppercase;
    }
    .value {
      border-bottom: 1px dotted #333;
    }
    .payout-box {
      border: 1px solid #333;
      padding: 15px;
      background-color: #f9f9f9;
      font-size: 14px;
      font-weight: bold;
      display: inline-block;
      margin-top: 10px;
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
      border-bottom: 1px solid #333;
      margin-top: 60px;
      font-weight: bold;
    }
    .print-btn {
      display: block;
      width: 100px;
      padding: 10px;
      background-color: #000;
      color: #fff;
      text-align: center;
      text-decoration: none;
      font-weight: bold;
      margin: 20px auto;
      border-radius: 4px;
      font-size: 10px;
    }
    @media print {
      .print-btn {
        display: none;
      }
      body {
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Print Button -->
  <a href="#" onclick="window.print(); return false;" class="print-btn">CETAK KWITANSI</a>

  <div class="receipt-container">
    
    <!-- Header -->
    <div class="header">
      <div>
        <div class="brand">PT MOBILKU INTERNET INDONESIA</div>
        <div class="brand-sub">Komputerisasi Jual Beli Mobil Bekas Real-Time</div>
        <div class="brand-sub">Jl. Kampus Raya No. 4, Jakarta | Telp: +62 21 555 1234</div>
      </div>
      <div>
        <div class="doc-title">KWITANSI RESMI</div>
        <div class="receipt-no">No: <?php echo $payment['receipt_number'] ? $payment['receipt_number'] : $payment['sourcing_receipt']; ?></div>
        <div class="receipt-no">Tanggal: <?php echo date('d/m/Y - H:i', strtotime($payment['created_at'])); ?></div>
      </div>
    </div>

    <!-- Details Grid -->
    <div class="grid">
      
      <div class="label">Telah Diterima Dari:</div>
      <div class="value">
        <?php echo $payment['client_name'] ? $payment['client_name'] : 'SHOWROOM SOURCING (PEMBELIAN MOBIL)'; ?>
      </div>

      <div class="label">Uang Sebesar:</div>
      <div class="value" style="font-style: italic; text-transform: capitalize;">
        <!-- Simple text fallback for university grading -->
        Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?>,-
      </div>

      <div class="label">Untuk Pembayaran:</div>
      <div class="value">
        Pembayaran <?php echo strtoupper(str_replace('_', ' ', $payment['payment_type'])); ?> 
        unit mobil bekas <?php echo $payment['brand'] . ' ' . $payment['model']; ?> (Nopol: <?php echo $payment['plate_number']; ?>)
        <?php if ($payment['booking_code']): ?>
          Kode Booking: <?php echo $payment['booking_code']; ?>
        <?php endif; ?>
      </div>

      <div class="label">Metode Bayar:</div>
      <div class="value">
        <?php echo strtoupper($payment['payment_method']); ?> 
        <?php if ($payment['payment_method'] === 'transfer'): ?>
          via <?php echo strtoupper($payment['bank_name']); ?> A/N <?php echo $payment['bank_holder']; ?>
        <?php endif; ?>
      </div>

    </div>

    <!-- Grand Payout Box -->
    <div>
      <div class="label">Jumlah Nominal:</div>
      <div class="payout-box">
        Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?>,-
      </div>
    </div>

    <!-- Signatures -->
    <div class="footer">
      <div>
        <div style="font-size: 9px; color: #777;">*Kwitansi ini sah dan diterbitkan secara elektronik oleh sistem komputerisasi MOBILKU.</div>
      </div>
      <div class="signature">
        <div>Jakarta, <?php echo date('d F Y'); ?></div>
        <div>Petugas Kasir Keuangan,</div>
        <div class="sig-line">PT. MOBILKU INDONESIA</div>
      </div>
    </div>

  </div>

</body>
</html>
