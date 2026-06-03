<style>
  /* Custom Timeline Style override for Ultra High Contrast Light Mode */
  .timeline-track {
    position: relative;
    border-left: 2px solid #EAEAEA;
    padding-left: 2.5rem;
  }
  .timeline-glow-line {
    position: absolute;
    left: -2px;
    top: 0;
    width: 2px;
    background-color: #000000;
    transform-origin: top;
    height: 100%;
  }
  .timeline-dot {
    position: absolute;
    left: -7px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #FFFFFF;
    border: 2px solid #DADADA;
    transition: all 0.3s ease;
  }
  .timeline-dot.active {
    background-color: #000000;
    border-color: #000000;
    box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.15);
  }
  .timeline-dot.completed {
    background-color: #10B981; /* emerald-500 */
    border-color: #10B981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
  }
</style>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  
  <!-- Back button -->
  <a href="<?php echo base_url('booking/dashboard'); ?>" class="inline-flex items-center gap-2 text-xs font-mono text-neutral-800 hover:text-black font-bold transition-colors mb-8 stagger-card">
    <i class="fa-solid fa-arrow-left"></i> BACK TO DASHBOARD
  </a>

  <?php
    $bf_payment = null;
    $bf_rejected = false;
    $bf_reject_reason = '';
    $dp_rejected = false;
    $dp_reject_reason = '';
    $pelunasan_rejected = false;
    $pelunasan_reject_reason = '';

    if (!empty($payments)) {
        foreach ($payments as $p) {
            if ($p['payment_type'] === 'booking_fee') {
                $bf_payment = $p;
                if ($p['status'] === 'rejected') {
                    $bf_rejected = true;
                    $bf_reject_reason = $p['rejection_reason'];
                }
            }
            if ($p['payment_type'] === 'dp' && $p['status'] === 'rejected') {
                $dp_rejected = true;
                $dp_reject_reason = $p['rejection_reason'];
            }
            if ($p['payment_type'] === 'pelunasan' && $p['status'] === 'rejected') {
                $pelunasan_rejected = true;
                $pelunasan_reject_reason = $p['rejection_reason'];
            }
        }
    }
    $pre_bank = $bf_payment ? $bf_payment['bank_name'] : '';
    $pre_holder = $bf_payment ? $bf_payment['bank_holder'] : '';
  ?>

  <!-- Header Order info -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12 stagger-card">
    <div>
      <span class="text-xs font-mono text-neutral-500 font-bold tracking-wider">PESANAN #<?php echo $booking['booking_code']; ?></span>
      <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-black mt-1"><?php echo $booking['brand'] . ' ' . $booking['model']; ?></h2>
      <span class="text-[10px] font-mono text-neutral-700 font-medium">Dipesan pada: <?php echo date('d F Y - H:i', strtotime($booking['booking_date'])); ?> WIB</span>
    </div>
    <div class="flex items-center gap-3">
      <span class="px-3 py-1 text-xs font-mono font-bold rounded-full uppercase <?php 
        if ($booking['status'] === 'ordered') echo 'bg-blue-50 text-blue-800 border border-blue-200';
        elseif ($booking['status'] === 'active') echo 'bg-purple-50 text-purple-800 border border-purple-200';
        elseif ($booking['status'] === 'completed') echo 'bg-emerald-50 text-emerald-800 border border-emerald-200';
        else echo 'bg-red-50 text-red-800 border border-red-200';
      ?>"><?php echo strtoupper($booking['status']); ?></span>
      
      <!-- Cancel action if applicable -->
      <?php if (!in_array($booking['status'], array('cancelled', 'completed'))): ?>
        <a href="<?php echo base_url('booking/cancel/' . $booking['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan? Biaya Bukti Pesanan hanya kembali jika di bawah 1 minggu sejak tanggal pesanan.')" class="px-4 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-[10px] font-mono font-bold transition-all duration-300">
          BATALKAN PESANAN
        </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    
    <!-- Left Column: Visual Process Tracker Timeline -->
    <div class="lg:col-span-7 flex flex-col gap-6">
      
      <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 relative shadow-[0_4px_30px_rgba(0,0,0,0.02)] stagger-card">
        
        <!-- Glowing black accent border -->
        <div class="absolute -top-[1px] left-6 w-16 h-[1px] bg-black"></div>

        <h3 class="font-display font-bold text-lg text-black mb-8 flex items-center gap-2">
          <i class="fa-solid fa-list-check text-black"></i> LINE TIMELINE PROSES ADMINISTRASI
        </h3>

        <!-- TIMELINE CONTAINER -->
        <div class="timeline-track space-y-12 relative">
          
          <!-- Animated Glow line inside track -->
          <div class="timeline-glow-line" id="timelineBar"></div>

          <?php
            // Check if booking fee is paid or pending
            $bf_paid = ($booking['booking_fee_status'] === 'paid');
            $bf_pending = false;
            foreach ($payments as $p) {
                if ($p['payment_type'] === 'booking_fee' && $p['status'] === 'pending') {
                    $bf_pending = true;
                    break;
                }
            }
          ?>

          <!-- STEP 1: Bukti Pesanan -->
          <div class="relative flex flex-col gap-2">
            <!-- Timeline dot -->
            <div class="timeline-dot <?php echo $bf_paid ? 'completed' : 'active'; ?>"></div>
            <div class="pl-2">
              <h4 class="font-display font-bold text-black text-base">1. Pembayaran Bukti Pesanan (Rp 500.000)</h4>
              <p class="text-xs text-neutral-600 leading-relaxed mt-1">
                Calon pembeli diwajibkan menyetor Booking Fee sebagai komitmen pesanan.
              </p>
              <?php if ($bf_paid): ?>
                <div class="text-[10px] font-mono text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-2.5 py-1 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                  <i class="fa-solid fa-circle-check"></i> DITERIMA & DIVERIFIKASI (LUNAS)
                </div>
              <?php elseif ($bf_pending): ?>
                <div class="text-[10px] font-mono text-blue-700 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 w-fit mt-2 font-bold inline-flex items-center gap-1.5 animate-pulse">
                  <i class="fa-solid fa-arrows-spin animate-spin"></i> MENUNGGU VERIFIKASI PEMBAYARAN (ADMIN)
                </div>
              <?php else: ?>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mt-2">
                  <?php if ($bf_rejected): ?>
                    <div class="text-[10px] font-mono text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1.5 w-fit font-bold inline-flex items-center gap-1.5">
                      <i class="fa-solid fa-circle-xmark"></i> PENOLAKAN: <?php echo htmlspecialchars($bf_reject_reason); ?>
                    </div>
                    <a href="<?php echo base_url('booking/pay_booking_fee_sim/' . $booking['id']); ?>" class="text-[10px] font-mono bg-black text-white px-3 py-1.5 rounded-lg font-bold hover:bg-neutral-800 w-fit inline-flex items-center gap-1.5 transition-all">
                      <i class="fa-solid fa-arrows-rotate"></i> Upload Ulang Bukti Pesanan
                    </a>
                  <?php else: ?>
                    <div class="text-[10px] font-mono text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1 w-fit font-bold inline-flex items-center gap-1.5">
                      <i class="fa-solid fa-clock"></i> BELUM DIBAYAR
                    </div>
                    <a href="<?php echo base_url('booking/pay_booking_fee_sim/' . $booking['id']); ?>" class="text-[10px] font-mono bg-black text-white px-3 py-1.5 rounded-lg font-bold hover:bg-neutral-800 w-fit inline-flex items-center gap-1.5 transition-all">
                      <i class="fa-solid fa-wallet"></i> Bayar Booking Fee Sekarang
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- STEP 2: DP 30% & KTP SCAN -->
          <div class="relative flex flex-col gap-2">
            <!-- Timeline dot -->
            <div class="timeline-dot <?php echo ($booking['dp_status'] === 'paid') ? 'completed' : 'active'; ?>"></div>
            <div class="pl-2">
              <h4 class="font-display font-bold text-black text-base">2. Uang Muka (30% OTR) & Fotocopy KTP</h4>
              <p class="text-xs text-neutral-600 leading-relaxed mt-1">
                Batas pembayaran DP sebesar 30% adalah <strong>Satu Minggu (7 Hari)</strong> sejak bukti pesanan dibayar.
              </p>
              
              <!-- Deadline / Verification state -->
              <?php if ($booking['dp_status'] === 'paid'): ?>
                <div class="text-[10px] font-mono text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-2.5 py-1 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                  <i class="fa-solid fa-circle-check"></i> DP 30% LUNAS & KTP TERVERIFIKASI
                </div>
              <?php else: ?>
                <div class="text-[10px] font-mono text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                  <i class="fa-solid fa-clock"></i> TENGGAT DP: <?php echo date('d M Y - H:i', strtotime($booking['dp_deadline'])); ?> WIB
                </div>
                
                <?php if ($dp_rejected): ?>
                  <div class="text-[10px] font-mono text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1.5 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-xmark"></i> PENOLAKAN ADMIN: <?php echo htmlspecialchars($dp_reject_reason); ?> (Silakan Unggah Ulang Dokumen)
                  </div>
                <?php endif; ?>
                
                <?php if ($booking['status'] === 'cancelled'): ?>
                  <div class="text-xs text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1 w-fit mt-2 font-mono uppercase font-bold inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-xmark"></i> Batal Overdue (Melebihi 1 Minggu)
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>

          <!-- STEP 3: STNK (2 Weeks) & BPKB (2 Months) Processing -->
          <div class="relative flex flex-col gap-2">
            <!-- Timeline dot -->
            <div class="timeline-dot <?php echo ($booking['stnk_status'] === 'completed') ? 'completed' : (($booking['dp_status'] === 'paid') ? 'active' : ''); ?>"></div>
            <div class="pl-2">
              <h4 class="font-display font-bold text-black text-base">3. Pengurusan Dokumen (STNK & BPKB)</h4>
              <p class="text-xs text-neutral-600 leading-relaxed mt-1">
                Pengurusan STNK memakan waktu rata-rata <strong>2 Minggu</strong>, sedangkan BPKB selesai dalam waktu <strong>2 Bulan</strong>.
              </p>
              
              <div class="grid grid-cols-2 gap-4 mt-3 bg-neutral-50 p-4 rounded-2xl border border-[#EAEAEA] font-mono text-[10px]">
                <div class="flex flex-col gap-1">
                  <span class="text-neutral-500 uppercase font-semibold">Status STNK (2 Minggu):</span>
                  <span class="<?php echo ($booking['stnk_status'] === 'completed') ? 'text-emerald-700' : 'text-blue-700 animate-pulse'; ?> font-bold text-xs">
                    <i class="<?php echo ($booking['stnk_status'] === 'completed') ? 'fa-solid fa-circle-check' : 'fa-solid fa-arrows-spin animate-spin'; ?> mr-1.5"></i>
                    <?php echo ($booking['stnk_status'] === 'completed') ? 'SELESAI' : 'PROSES PEMBUATAN'; ?>
                  </span>
                </div>
                <div class="flex flex-col gap-1">
                  <span class="text-neutral-500 uppercase font-semibold">Status BPKB (2 Bulan):</span>
                  <span class="<?php echo ($booking['bpkb_status'] === 'completed') ? 'text-emerald-700' : 'text-blue-700 animate-pulse'; ?> font-bold text-xs">
                    <i class="<?php echo ($booking['bpkb_status'] === 'completed') ? 'fa-solid fa-circle-check' : 'fa-solid fa-arrows-spin animate-spin'; ?> mr-1.5"></i>
                    <?php echo ($booking['bpkb_status'] === 'completed') ? 'SELESAI' : 'PROSES KEPOLISIAN'; ?>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- STEP 4: Pelunasan & Serah Terima unit -->
          <div class="relative flex flex-col gap-2">
            <!-- Timeline dot -->
            <div class="timeline-dot <?php echo ($booking['pelunasan_status'] === 'paid' && $booking['delivery_status'] === 'delivered') ? 'completed' : (($booking['stnk_status'] === 'completed' && $booking['pelunasan_status'] === 'paid') ? 'active' : ''); ?>"></div>
            <div class="pl-2">
              <h4 class="font-display font-bold text-black text-base">4. Pelunasan & Serah Terima Unit</h4>
              <p class="text-xs text-neutral-600 leading-relaxed mt-1">
                Pembeli melunasi sisa harga mobil (70% OTR) selama pengurusan STNK. Setelah STNK selesai & harga lunas, mobil dapat diambil atau diantar menggunakan <strong>Surat Jalan</strong>.
              </p>

               <div class="grid grid-cols-2 gap-4 mt-3 bg-neutral-50 p-4 rounded-2xl border border-[#EAEAEA] font-mono text-[10px]">
                <div class="flex flex-col gap-1 col-span-2 md:col-span-1">
                  <span class="text-neutral-500 uppercase font-semibold">Status Pelunasan (70%):</span>
                  <span class="<?php echo ($booking['pelunasan_status'] === 'paid') ? 'text-emerald-700' : 'text-red-600'; ?> font-bold text-xs">
                    <?php echo ($booking['pelunasan_status'] === 'paid') ? 'LUNAS' : 'MENUNGGU PELUNASAN'; ?>
                  </span>
                </div>
                <div class="flex flex-col gap-1 col-span-2 md:col-span-1">
                  <span class="text-neutral-500 uppercase font-semibold">Fulfillment Unit:</span>
                  <span class="text-black font-extrabold text-xs uppercase leading-relaxed">
                    <?php 
                      if (empty($booking['delivery_type'])) {
                          echo 'Belum Dikonfigurasi';
                      } elseif ($booking['delivery_type'] === 'pickup') {
                          echo 'Ambil Sendiri di Showroom';
                      } else {
                          echo 'Diantar ke Alamat';
                      }
                    ?>
                  </span>
                </div>
                <?php if (!empty($booking['delivery_type'])): ?>
                <div class="flex flex-col gap-1 col-span-2 pt-2 border-t border-[#EAEAEA] font-sans text-xs text-neutral-800">
                  <?php if ($booking['delivery_type'] === 'pickup'): ?>
                    <div class="flex items-start gap-1.5 text-neutral-600 font-mono text-[10px] uppercase">
                      <i class="fa-solid fa-store mt-0.5"></i>
                      <span>Silakan ambil unit mobil Anda langsung di Showroom DRIVE.X setelah pelunasan diverifikasi.</span>
                    </div>
                  <?php else: ?>
                    <div class="flex flex-col gap-1">
                      <span class="text-neutral-500 font-mono text-[10px] uppercase font-semibold">Alamat Pengiriman:</span>
                      <span class="text-black font-medium"><?php echo htmlspecialchars($booking['delivery_address'] ?? '-'); ?></span>
                    </div>
                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-dashed border-[#EAEAEA]">
                      <div class="flex flex-col gap-0.5">
                        <span class="text-neutral-500 font-mono text-[9px] uppercase font-semibold">Status Pengiriman:</span>
                        <span class="text-black font-mono text-[10px] font-bold uppercase"><?php echo htmlspecialchars($booking['delivery_status']); ?></span>
                      </div>
                      <a href="<?php echo base_url('booking/tracking/' . $booking['id']); ?>" class="flex items-center gap-1.5 text-[9px] font-bold text-white bg-black border border-black px-2.5 py-1.5 rounded-lg hover:bg-neutral-800 transition-colors">
                        <i class="fa-solid fa-location-crosshairs text-[8px] animate-pulse"></i> Lacak Pengiriman
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
                <?php endif; ?>
              </div>

              <?php if ($pelunasan_rejected): ?>
                <div class="text-[10px] font-mono text-red-700 bg-red-50 border border-red-100 rounded px-2.5 py-1.5 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                  <i class="fa-solid fa-circle-xmark"></i> PENOLAKAN ADMIN: <?php echo htmlspecialchars($pelunasan_reject_reason); ?> (Silakan Unggah Ulang Bukti Pelunasan)
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- STEP 5: BPKB Handover -->
          <div class="relative flex flex-col gap-2">
            <!-- Timeline dot -->
            <div class="timeline-dot <?php echo ($booking['status'] === 'completed') ? 'completed' : ''; ?>"></div>
            <div class="pl-2">
              <h4 class="font-display font-bold text-black text-base">5. Serah Terima Dokumen BPKB</h4>
              <p class="text-xs text-neutral-600 leading-relaxed mt-1">
                Dokumen BPKB diserahterimakan secara resmi setelah seluruh rangkaian proses STNK & Pelunasan selesai dan unit telah diserahkan.
              </p>
              <?php if ($booking['status'] === 'completed'): ?>
                <div class="text-[10px] font-mono text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-2.5 py-1 w-fit mt-2 font-bold inline-flex items-center gap-1.5">
                  <i class="fa-solid fa-circle-check"></i> SERAH TERIMA BPKB SELESAI (SELESAI TOTAL)
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Right Column: Interactive Upload Forms & Printables -->
    <div class="lg:col-span-5 flex flex-col gap-6">
      
      <?php
        $dp_pending = false;
        if (!empty($payments)) {
            foreach ($payments as $p) {
                if ($p['payment_type'] === 'dp' && $p['status'] === 'pending') {
                    $dp_pending = true;
                    break;
                }
            }
        }
      ?>

      <!-- Dynamic Form: DP and KTP Upload -->
      <?php if ($booking['dp_status'] === 'unpaid' && $booking['status'] !== 'cancelled'): ?>
        <?php if ($dp_pending): ?>
          <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 shadow-[0_4px_30px_rgba(0,0,0,0.02)] relative overflow-hidden stagger-card">
            <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>
            
            <div class="text-center py-6 space-y-4 relative">
              <div class="w-16 h-16 bg-[#F5F5F5] border border-[#EAEAEA] rounded-full flex items-center justify-center mx-auto text-black text-2xl animate-pulse">
                <i class="fa-solid fa-hourglass-half"></i>
              </div>
              
              <h4 class="font-display font-extrabold text-sm tracking-wider text-black uppercase">DP & KTP MENUNGGU VERIFIKASI</h4>
              <p class="text-xs text-neutral-500 leading-relaxed font-sans max-w-xs mx-auto">
                Berkas KTP dan Bukti Pembayaran DP 30% Anda telah kami terima dan saat ini sedang diverifikasi secara manual oleh Admin.
              </p>

              <div class="pt-4 border-t border-[#EAEAEA] text-[10px] font-mono text-neutral-600 flex flex-col gap-2 bg-[#FAFAFA] p-4 rounded-2xl">
                <div class="flex justify-between">
                  <span>BANK PENGIRIM:</span>
                  <span class="text-black font-bold uppercase"><?php echo htmlspecialchars($pre_bank); ?></span>
                </div>
                <div class="flex justify-between">
                  <span>ATAS NAMA:</span>
                  <span class="text-black font-bold uppercase"><?php echo htmlspecialchars($pre_holder); ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="bg-white border border-[#EAEAEA] hover:border-black rounded-[28px] p-8 shadow-[0_4px_30px_rgba(0,0,0,0.02)] transition-all duration-300 stagger-card">
            <h4 class="font-display font-extrabold text-sm tracking-wider text-black uppercase mb-6 flex items-center gap-2">
              <i class="fa-solid fa-arrow-up-from-bracket"></i> UNGGAH DP & SCAN KTP
            </h4>

            <?php echo form_open_multipart('booking/submit_dp_ktp/' . $booking['id'], array('class' => 'space-y-6 text-xs font-mono')); ?>
              
              <div class="flex flex-col gap-1.5 p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA]">
                <span class="text-neutral-500 font-bold text-[10px] uppercase">JUMLAH DP 30% OTR:</span>
                <span class="text-black font-extrabold text-2xl">Rp <?php echo number_format($booking['dp_amount'], 0, ',', '.'); ?>,-</span>
              </div>

              <!-- Payment method -->
              <div class="flex flex-col gap-2">
                <label class="text-neutral-700 font-bold">Metode Pembayaran:</label>
                <select name="method" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans px-4 py-3.5 rounded-xl transition-all duration-200 outline-none">
                  <option value="transfer">Transfer Bank</option>
                  <option value="cash">Tunai (Showroom)</option>
                </select>
              </div>

              <!-- Bank account specs for transfer -->
              <div onclick="window.copyTextToClipboard('1230009871111', this)" class="copy-tooltip p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA] flex flex-col gap-1 text-[10px] text-neutral-800 hover:border-black transition-colors select-none">
                <span class="text-neutral-500 uppercase font-semibold mb-1">Rekening Transfer Perusahaan (Klik Salin):</span>
                <span class="text-black font-extrabold text-sm"><i class="fa-solid fa-copy mr-1 text-xs text-neutral-400"></i> MANDIRI 123-000-987-1111</span>
                <span class="text-neutral-700 font-medium">A/N PT MOBILKU INTERNET INDONESIA</span>
              </div>

              <!-- Upload files input standard -->
              <div class="flex flex-col gap-2">
                <label class="text-neutral-700 font-bold">1. Unggah Scan KTP Anda:</label>
                <input type="file" name="ktp_file" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-mono file:font-bold file:bg-black file:text-white file:cursor-pointer hover:file:bg-neutral-800 transition-all duration-200">
              </div>

              <div class="flex flex-col gap-2">
                <label class="text-neutral-700 font-bold">2. Bukti Transfer Bank:</label>
                <input type="file" name="evidence_file" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-mono file:font-bold file:bg-black file:text-white file:cursor-pointer hover:file:bg-neutral-800 transition-all duration-200">
              </div>

              <!-- Bank details input of buyer -->
              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label class="text-neutral-700 font-bold">Nama Bank Pengirim:</label>
                  <input type="text" name="bank_name" placeholder="BCA/Mandiri" value="<?php echo htmlspecialchars($pre_bank); ?>" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl transition-all duration-200 outline-none">
                </div>
                <div class="flex flex-col gap-2">
                  <label class="text-neutral-700 font-bold">A/N Pengirim:</label>
                  <input type="text" name="bank_holder" placeholder="Nama Rekening" value="<?php echo htmlspecialchars($pre_holder); ?>" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl transition-all duration-200 outline-none">
                </div>
              </div>

              <button type="submit" class="w-full text-center py-4 bg-black text-white hover:bg-neutral-800 rounded-xl font-bold uppercase tracking-wider text-[11px] transition-all duration-300 shadow-sm">
                Kirim Verifikasi DP
              </button>
            </form>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <?php
        $pelunasan_pending = false;
        if (!empty($payments)) {
            foreach ($payments as $p) {
                if ($p['payment_type'] === 'pelunasan' && $p['status'] === 'pending') {
                    $pelunasan_pending = true;
                    break;
                }
            }
        }
      ?>

      <!-- Dynamic Form: Final Pelunasan Upload -->
      <?php if ($booking['dp_status'] === 'paid' && $booking['pelunasan_status'] === 'unpaid' && $booking['status'] !== 'cancelled'): ?>
        <?php if ($pelunasan_pending): ?>
          <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 shadow-[0_4px_30px_rgba(0,0,0,0.02)] relative overflow-hidden stagger-card">
            <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>
            
            <div class="text-center py-6 space-y-4 relative">
              <div class="w-16 h-16 bg-[#F5F5F5] border border-[#EAEAEA] rounded-full flex items-center justify-center mx-auto text-black text-2xl animate-pulse">
                <i class="fa-solid fa-hourglass-half"></i>
              </div>
              
              <h4 class="font-display font-extrabold text-sm tracking-wider text-black uppercase">PELUNASAN MENUNGGU VERIFIKASI</h4>
              <p class="text-xs text-neutral-500 leading-relaxed font-sans max-w-xs mx-auto">
                Bukti Pembayaran Pelunasan 70% Anda sedang diproses dan ditinjau oleh Admin. Setelah disetujui, Anda dapat menentukan metode serah terima kendaraan.
              </p>

              <div class="pt-4 border-t border-[#EAEAEA] text-[10px] font-mono text-neutral-600 flex flex-col gap-2 bg-[#FAFAFA] p-4 rounded-2xl">
                <div class="flex justify-between">
                  <span>BANK PENGIRIM:</span>
                  <span class="text-black font-bold uppercase"><?php echo htmlspecialchars($pre_bank); ?></span>
                </div>
                <div class="flex justify-between">
                  <span>ATAS NAMA:</span>
                  <span class="text-black font-bold uppercase"><?php echo htmlspecialchars($pre_holder); ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="bg-white border border-[#EAEAEA] hover:border-black rounded-[28px] p-8 shadow-[0_4px_30px_rgba(0,0,0,0.02)] transition-all duration-300 stagger-card">
            <h4 class="font-display font-extrabold text-sm tracking-wider text-black uppercase mb-6 flex items-center gap-2">
              <i class="fa-solid fa-truck-ramp-box"></i> SERAH TERIMA & PELUNASAN (70%)
            </h4>

            <?php echo form_open_multipart('booking/submit_final_payment/' . $booking['id'], array('class' => 'space-y-6 text-xs font-mono')); ?>
              
              <div class="flex flex-col gap-1.5 p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA]">
                <span class="text-neutral-500 font-bold text-[10px] uppercase">SISA HARGA HARUS DILUNASI (70%):</span>
                <span class="text-black font-extrabold text-2xl">Rp <?php echo number_format($booking['remaining_payment'], 0, ',', '.'); ?>,-</span>
              </div>

              <!-- 1. PILIH TIPE SERAH TERIMA -->
              <div class="flex flex-col gap-2">
                <label class="text-neutral-700 font-bold">1. Pilih Tipe Serah Terima:</label>
                <select name="delivery_type" id="deliveryTypeSelect" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans px-4 py-3.5 rounded-xl transition-all duration-200 outline-none">
                  <option value="pickup">Ambil Sendiri di Showroom (Membawa STNK)</option>
                  <option value="delivery">Kirim ke Alamat Rumah (Melalui Kurir + Surat Jalan)</option>
                </select>
              </div>

              <!-- ALAMAT PENGIRIMAN (Ditampilkan jika Kirim ke Rumah dipilih) -->
              <div class="flex flex-col gap-2 hidden" id="deliveryAddressWrapper">
                <div class="flex justify-between items-center">
                  <label class="text-neutral-700 font-bold">Alamat Pengiriman Lengkap:</label>
                  <button type="button" onclick="detectUserLocation()" id="locationBtn" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-[#DADADA] bg-white text-black hover:border-black font-mono text-[9px] font-bold uppercase transition-all shadow-sm">
                    <i class="fa-solid fa-location-crosshairs text-[10px]"></i> Bagikan Lokasi Saya
                  </button>
                </div>
                <textarea name="delivery_address" id="deliveryAddressInput" placeholder="Tulis alamat lengkap pengiriman mobil Anda..." class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans p-4 rounded-xl h-20 outline-none resize-none transition-all duration-200"></textarea>
              </div>

              <!-- 2. PILIH METODE PEMBAYARAN -->
              <div class="flex flex-col gap-2">
                <label class="text-neutral-700 font-bold">2. Pilih Metode Pelunasan:</label>
                <select name="method" id="paymentMethodSelect" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans px-4 py-3.5 rounded-xl transition-all duration-200 outline-none">
                  <option value="transfer">Transfer Bank Sekarang</option>
                  <option value="cash" id="cashOptionLabel">Bayar Cash / Tunai di Showroom</option>
                </select>
              </div>

              <!-- CONTAINER TRANSFER BANK (Disembunyikan jika Cash dipilih) -->
              <div id="transferPaymentWrapper" class="space-y-6">
                <!-- Bank account specs for transfer -->
                <div onclick="window.copyTextToClipboard('1230009871111', this)" class="copy-tooltip p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA] flex flex-col gap-1 text-[10px] text-neutral-800 hover:border-black transition-colors select-none">
                  <span class="text-neutral-500 uppercase font-semibold mb-1">Rekening Transfer Perusahaan (Klik Salin):</span>
                  <span class="text-black font-extrabold text-sm"><i class="fa-solid fa-copy mr-1 text-xs text-neutral-400"></i> MANDIRI 123-000-987-1111</span>
                  <span class="text-neutral-700 font-medium">A/N PT MOBILKU INTERNET INDONESIA</span>
                </div>

                <div class="flex flex-col gap-2">
                  <label class="text-neutral-700 font-bold">Unggah Bukti Payout/Transfer:</label>
                  <input type="file" name="evidence_file" id="evidenceFileInput" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-mono file:font-bold file:bg-black file:text-white file:cursor-pointer hover:file:bg-neutral-800 transition-all duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="flex flex-col gap-2">
                    <label class="text-neutral-700 font-bold">Nama Bank Pengirim:</label>
                    <input type="text" name="bank_name" id="bankNameInput" placeholder="BCA/Mandiri" value="<?php echo htmlspecialchars($pre_bank); ?>" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl transition-all duration-200 outline-none">
                  </div>
                  <div class="flex flex-col gap-2">
                    <label class="text-neutral-700 font-bold">A/N Pengirim:</label>
                    <input type="text" name="bank_holder" id="bankHolderInput" placeholder="Nama Rekening" value="<?php echo htmlspecialchars($pre_holder); ?>" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black px-4 py-3 rounded-xl transition-all duration-200 outline-none">
                  </div>
                </div>
              </div>

              <!-- Button Submit -->
              <button type="submit" class="w-full text-center py-4 bg-black text-white hover:bg-neutral-800 rounded-xl font-bold uppercase tracking-wider text-[11px] transition-all duration-300 shadow-sm">
                Konfirmasi Serah Terima & Pelunasan
              </button>
            </form>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Dynamic Form: Configure Pickup or Delivery once Paid and STNK is completed -->
      <?php if ($booking['stnk_status'] === 'completed' && $booking['pelunasan_status'] === 'paid' && empty($booking['delivery_type']) && $booking['status'] !== 'cancelled'): ?>
        <div class="bg-white border border-[#EAEAEA] hover:border-black rounded-[28px] p-8 shadow-[0_4px_30px_rgba(0,0,0,0.02)] transition-all duration-300 stagger-card">
          <h4 class="font-display font-extrabold text-sm tracking-wider text-black uppercase mb-6 flex items-center gap-2">
            <i class="fa-solid fa-truck-ramp-box"></i> KONFIGURASI SERAH TERIMA UNIT
          </h4>

          <form action="<?php echo base_url('booking/submit_delivery/' . $booking['id']); ?>" method="post" class="space-y-6 text-xs font-mono">
            
            <div class="flex flex-col gap-2">
              <label class="text-neutral-700 font-bold">Pilih Tipe Serah Terima:</label>
              <select name="delivery_type" id="deliveryTypeSelector" required class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans px-4 py-3.5 rounded-xl transition-all duration-200 outline-none">
                <option value="pickup">Ambil Langsung di Showroom (Membawa STNK)</option>
                <option value="delivery">Kirim ke Alamat Rumah (Melalui Kurir + Surat Jalan)</option>
              </select>
            </div>

            <!-- Address input wrapper (displayed only if delivery is selected) -->
            <div class="flex flex-col gap-2 hidden" id="addressInputWrapper">
              <label class="text-neutral-700 font-bold">Alamat Pengiriman Lengkap:</label>
              <textarea name="delivery_address" placeholder="Tulis alamat rumah lengkap Anda..." class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans p-4 rounded-xl h-24 outline-none resize-none transition-all duration-200"></textarea>
            </div>

            <button type="submit" class="w-full text-center py-4 bg-black text-white hover:bg-neutral-800 rounded-xl font-bold uppercase tracking-wider text-[11px] transition-all duration-300 shadow-sm">
              Konfirmasi Serah Terima
            </button>
          </form>
        </div>
      <?php endif; ?>

      <!-- Payments & Receipts List -->
      <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-6 shadow-[0_4px_30px_rgba(0,0,0,0.02)] text-xs font-mono stagger-card">
        <h4 class="font-display font-extrabold text-[10px] tracking-wider text-neutral-500 uppercase mb-4 flex items-center gap-1.5">
          <i class="fa-solid fa-receipt text-black"></i> DAFTAR KWITANSI DAN BUKTI
        </h4>
        <div class="space-y-3">
          <?php if (empty($payments)): ?>
            <div class="p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA] text-neutral-500 font-medium">
              Belum ada kwitansi diterbitkan.
            </div>
          <?php else: ?>
            <?php foreach ($payments as $pay): ?>
              <div class="p-4 bg-neutral-50 rounded-2xl border border-[#EAEAEA] flex items-center justify-between">
                <div class="flex flex-col">
                  <span class="text-black font-bold text-xs"><?php echo strtoupper(str_replace('_', ' ', $pay['payment_type'])); ?></span>
                  <span class="text-[9px] text-neutral-500 font-semibold mt-0.5"><?php echo date('d M Y', strtotime($pay['created_at'])); ?></span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase border <?php echo ($pay['status'] === 'verified') ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200'; ?>">
                    <?php echo $pay['status']; ?>
                  </span>
                  <?php if ($pay['status'] === 'verified'): ?>
                    <a href="<?php echo base_url('admin/kwitansi/' . $pay['id']); ?>" target="_blank" class="text-black hover:underline ml-2 font-bold text-[10px] flex items-center gap-1">
                      Kwitansi <i class="fa-solid fa-print"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- Interactive Dynamic Timeline height logic using Anime.js and address inputs triggers -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    
    // Alur Form Serah Terima & Pelunasan Terpadu
    const deliveryTypeSelect = document.getElementById('deliveryTypeSelect');
    const deliveryAddressWrapper = document.getElementById('deliveryAddressWrapper');
    const deliveryAddressInput = document.getElementById('deliveryAddressInput');
    const cashOptionLabel = document.getElementById('cashOptionLabel');

    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    const transferPaymentWrapper = document.getElementById('transferPaymentWrapper');
    const evidenceFileInput = document.getElementById('evidenceFileInput');
    const bankNameInput = document.getElementById('bankNameInput');
    const bankHolderInput = document.getElementById('bankHolderInput');

    if (deliveryTypeSelect) {
      deliveryTypeSelect.addEventListener('change', function() {
        if (this.value === 'delivery') {
          deliveryAddressWrapper.style.display = 'block';
          deliveryAddressInput.setAttribute('required', 'required');
          if (cashOptionLabel) {
            cashOptionLabel.innerText = "Bayar COD / Tunai saat Mobil Tiba di Rumah";
          }
        } else {
          deliveryAddressWrapper.style.display = 'none';
          deliveryAddressInput.removeAttribute('required');
          if (cashOptionLabel) {
            cashOptionLabel.innerText = "Bayar Cash / Tunai Langsung di Showroom";
          }
        }
      });
    }

    if (paymentMethodSelect) {
      paymentMethodSelect.addEventListener('change', function() {
        if (this.value === 'transfer') {
          transferPaymentWrapper.style.display = 'block';
          evidenceFileInput.setAttribute('required', 'required');
          bankNameInput.setAttribute('required', 'required');
          bankHolderInput.setAttribute('required', 'required');
        } else {
          transferPaymentWrapper.style.display = 'none';
          evidenceFileInput.removeAttribute('required');
          bankNameInput.removeAttribute('required');
          bankHolderInput.removeAttribute('required');
        }
      });
    }

    // Trigger initial state checks on load
    if (deliveryTypeSelect) {
      deliveryTypeSelect.dispatchEvent(new Event('change'));
    }
    if (paymentMethodSelect) {
      paymentMethodSelect.dispatchEvent(new Event('change'));
    }

    // Anime.js interactive Timeline height calculations
    const timelineBar = document.getElementById('timelineBar');
    if (timelineBar) {
      // Calculate active percentage based on booking state
      let heightPct = 0;
      
      const isDpPaid = "<?php echo $booking['dp_status']; ?>" === "paid";
      const isStnkDone = "<?php echo $booking['stnk_status']; ?>" === "completed";
      const isPelunasanPaid = "<?php echo $booking['pelunasan_status']; ?>" === "paid";
      const isComplete = "<?php echo $booking['status']; ?>" === "completed";

      if (isComplete) heightPct = 100;
      else if (isPelunasanPaid) heightPct = 78;
      else if (isStnkDone) heightPct = 52;
      else if (isDpPaid) heightPct = 26;
      else heightPct = 0;

      // Animate the height of the timeline bar using Anime.js spring ease!
      anime({
        targets: timelineBar,
        scaleY: heightPct / 100,
        duration: 1800,
        easing: 'easeOutQuart',
        delay: 500
      });
    }

  });

  // Geolocation sharing logic using browser API + OSM Nominatim Reverse Geocoding
  function detectUserLocation() {
    const btn = document.getElementById('locationBtn');
    const input = document.getElementById('deliveryAddressInput');
    
    if (!navigator.geolocation) {
      alert('Browser Anda tidak mendukung fitur Geolocation / GPS.');
      return;
    }
    
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-[10px]"></i> Mencari GPS...';
    
    navigator.geolocation.getCurrentPosition(
      function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-[10px]"></i> Menerjemahkan Alamat...';
        
        // Reverse Geocoding via OSM Nominatim API
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
          .then(response => response.json())
          .then(data => {
            if (data && data.display_name) {
              input.value = data.display_name;
              btn.innerHTML = '<i class="fa-solid fa-check text-[10px] text-emerald-600"></i> Lokasi Terisi';
              btn.style.borderColor = '#10b981';
            } else {
              input.value = `Koordinat: ${lat}, ${lon}`;
              btn.innerHTML = '<i class="fa-solid fa-location-arrow text-[10px] text-emerald-600"></i> Koordinat Terisi';
            }
            setTimeout(() => {
              btn.disabled = false;
              btn.innerHTML = originalText;
              btn.style.borderColor = '#DADADA';
            }, 3500);
          })
          .catch(err => {
            console.error(err);
            input.value = `Koordinat: ${lat}, ${lon}`;
            btn.innerHTML = '<i class="fa-solid fa-location-arrow text-[10px] text-emerald-600"></i> Koordinat Terisi';
            setTimeout(() => {
              btn.disabled = false;
              btn.innerHTML = originalText;
            }, 3500);
          });
      },
      function(error) {
        let msg = 'Gagal mengakses GPS Anda.';
        if (error.code === error.PERMISSION_DENIED) {
          msg = 'Izin akses lokasi ditolak oleh browser/pengguna.';
        } else if (error.code === error.POSITION_UNAVAILABLE) {
          msg = 'Informasi lokasi GPS tidak tersedia.';
        } else if (error.code === error.TIMEOUT) {
          msg = 'Waktu pengambilan GPS habis (Timeout).';
        }
        alert(msg);
        btn.disabled = false;
        btn.innerHTML = originalText;
      },
      {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
      }
    );
  }
</script>
