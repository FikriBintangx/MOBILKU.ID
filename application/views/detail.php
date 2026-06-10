<!-- Car Details Section (Monochrome Apple/Linear Minimalist Style) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" data-aos="fade-up">
  
  <!-- Breadcrumbs -->
  <div class="flex items-center gap-2 text-xs font-mono text-[#666666] mb-8 pb-4 border-b border-[#EAEAEA]">
    <a href="<?php echo base_url(); ?>" class="hover:text-black transition-colors">Beranda</a>
    <span>&rsaquo;</span>
    <a href="<?php echo base_url('#katalog'); ?>" class="hover:text-black transition-colors">Daftar Mobil</a>
    <span>&rsaquo;</span>
    <span class="text-black font-semibold">Detail</span>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    
    <!-- Left Column: Visual Car Image & Tab Details -->
    <div class="lg:col-span-7 flex flex-col gap-8">
      
      <!-- Premium Showroom Picture Area (Frosted Glass) -->
      <div class="bg-white/40 backdrop-blur-xl border border-white/60 rounded-[32px] p-8 relative flex items-center justify-center min-h-[400px] overflow-hidden group shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 16px 16px;"></div>

        <div class="absolute top-4 left-6">
          <span class="px-2.5 py-0.5 rounded-full border border-black/10 text-[9px] font-mono font-bold bg-white text-black"><?php echo $car['year']; ?></span>
        </div>
        <div class="absolute top-4 right-6">
          <span class="px-2.5 py-0.5 rounded-full text-[9px] font-mono font-bold border border-black/10 bg-black text-white dot-matrix blink-dot">
            ● <?php echo strtoupper($car['status']); ?>
          </span>
        </div>

        <?php if (!empty($car['image_url'])): ?>
          <img src="<?php echo base_url('uploads/'.$car['image_url']); ?>" alt="<?php echo $car['brand'].' '.$car['model']; ?>" class="max-h-[280px] w-auto object-contain transform group-hover:scale-105 transition-transform duration-700 drop-shadow-2xl mix-blend-darken z-10">
        <?php else: ?>
          <i class="fa-solid fa-car text-black/5 text-[12rem] absolute select-none transform group-hover:scale-105 transition-transform duration-700"></i>
        <?php endif; ?>
        
        <div class="absolute bottom-4 left-6 right-6 flex justify-between text-[9px] font-mono text-[#999999]">
          <span>ENGINE KEY NO: <?php echo $car['engine_number']; ?></span>
          <span class="blink-dot text-black">SYSTEM SECURE ●</span>
        </div>
      </div>

      <!-- Dynamic Performance Specs -->
      <?php
        $priceM      = floatval($car['price']) / 1000000;
        $mockPower   = round(150 + ($priceM * 0.35));
        $mockSpeed   = round(180 + ($priceM * 0.12));
        $mock0100    = number_format(max(3.2, 11.5 - ($priceM * 0.008)), 1);
      ?>
      <div class="grid grid-cols-4 gap-4">
        <div class="bg-white/40 backdrop-blur-md border border-white/60 rounded-[24px] p-4 flex flex-col justify-center items-center h-24 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
          <span class="text-[8px] font-mono text-[#666] tracking-widest uppercase mb-1 text-center">POWER</span>
          <div class="font-display font-bold text-xl text-black flex items-baseline">
            <?php echo $mockPower; ?><span class="text-[9px] ml-1 text-[#666]">HP</span>
          </div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/60 rounded-[24px] p-4 flex flex-col justify-center items-center h-24 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
          <span class="text-[8px] font-mono text-[#666] tracking-widest uppercase mb-1 text-center">TOP SPEED</span>
          <div class="font-display font-bold text-xl text-black flex items-baseline">
            <?php echo $mockSpeed; ?><span class="text-[9px] ml-1 text-[#666]">KM/H</span>
          </div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/60 rounded-[24px] p-4 flex flex-col justify-center items-center h-24 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
          <span class="text-[8px] font-mono text-[#666] tracking-widest uppercase mb-1 text-center">0-100</span>
          <div class="font-display font-bold text-xl text-black flex items-baseline">
            <?php echo $mock0100; ?><span class="text-[9px] ml-1 text-[#666]">SEC</span>
          </div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/60 rounded-[24px] p-4 flex flex-col justify-center items-center h-24 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
          <span class="text-[8px] font-mono text-[#666] tracking-widest uppercase mb-1 text-center">CLASS</span>
          <div class="font-display font-bold text-xl text-black flex items-baseline uppercase">
            <?php echo $car['type']; ?>
          </div>
        </div>
      </div>

      <!-- Custom Tabs Navigation (Deskripsi, Spesifikasi, Riwayat Servis) -->
      <div class="bg-white/50 backdrop-blur-xl border border-white/50 rounded-[32px] p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <div class="flex border-b border-[#EAEAEA] pb-3 gap-6 text-xs font-mono mb-6">
          <button onclick="switchTab('desc')" id="tab-desc" class="text-black font-bold border-b-2 border-black pb-3 outline-none">DESKRIPSI</button>
          <button onclick="switchTab('specs')" id="tab-specs" class="text-[#666666] hover:text-black pb-3 outline-none">SPESIFIKASI</button>
          <button onclick="switchTab('history')" id="tab-history" class="text-[#666666] hover:text-black pb-3 outline-none">RIWAYAT SERVIS</button>
        </div>

        <div id="content-desc" class="text-xs text-[#666666] leading-relaxed font-sans space-y-4">
          <p class="text-[#111111] font-semibold text-sm">Catatan Resmi Showroom:</p>
          <p><?php echo $car['description']; ?></p>
        </div>

        <div id="content-specs" class="hidden text-xs text-[#666666] leading-relaxed font-mono space-y-3">
          <div class="flex justify-between py-1.5 border-b border-[#EAEAEA]">
            <span>Nomor Mesin:</span>
            <span class="text-black font-semibold"><?php echo $car['engine_number']; ?></span>
          </div>
          <div class="flex justify-between py-1.5 border-b border-[#EAEAEA]">
            <span>Nomor Rangka:</span>
            <span class="text-black font-semibold"><?php echo $car['frame_number']; ?></span>
          </div>
          <div class="flex justify-between py-1.5 border-b border-[#EAEAEA]">
            <span>Tipe Bodi:</span>
            <span class="text-black font-semibold uppercase"><?php echo $car['type']; ?></span>
          </div>
          <div class="flex justify-between py-1.5 border-b border-[#EAEAEA]">
            <span>Warna Eksterior:</span>
            <span class="text-black font-semibold uppercase"><?php echo $car['color']; ?></span>
          </div>
        </div>

        <div id="content-history" class="hidden text-xs text-[#666666] leading-relaxed font-sans text-center py-6">
          <i class="fa-solid fa-clipboard-check text-black/25 text-3xl mb-3"></i>
          <p class="font-mono">Riwayat servis terverifikasi di bengkel resmi. Unit telah lulus uji 150 titik inspeksi.</p>
        </div>
      </div>

    </div>

    <!-- Right Column: Specs Table & Purchase Panel -->
    <div class="lg:col-span-5 flex flex-col gap-8">
      
      <!-- Specifications Table Grid -->
      <div class="bg-white/50 backdrop-blur-xl border border-white/50 rounded-[32px] p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <span class="text-[9px] font-mono text-[#999999] tracking-wider uppercase block mb-1"><?php echo $car['brand']; ?></span>
        <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-black mb-6 leading-tight"><?php echo $car['model']; ?></h2>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-6">
          <span class="px-2.5 py-0.5 rounded-full border border-black/10 text-[9px] font-mono uppercase bg-[#F5F5F5] font-semibold text-black">SUV</span>
          <span class="px-2.5 py-0.5 rounded-full border border-black/10 text-[9px] font-mono uppercase bg-[#F5F5F5] font-semibold text-black">DIESEL</span>
          <span class="px-2.5 py-0.5 rounded-full border border-black/10 text-[9px] font-mono uppercase bg-[#F5F5F5] font-semibold text-black">MATIC</span>
        </div>

        <!-- Specifications list -->
        <div class="space-y-3.5 text-xs font-mono text-[#666666]">
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>TAHUN</span>
            <span class="text-black font-semibold"><?php echo $car['year']; ?></span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>KILOMETER</span>
            <span class="text-black font-semibold uppercase">32.000 KM</span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>TRANSMISI</span>
            <span class="text-black font-semibold uppercase">Automatic</span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>BAHAN BAKAR</span>
            <span class="text-black font-semibold uppercase">Diesel</span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>WARNA</span>
            <span class="text-black font-semibold uppercase"><?php echo $car['color']; ?></span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>PLAT NOMOR</span>
            <span class="text-black font-semibold uppercase"><?php echo $car['plate_number']; ?></span>
          </div>
          <div class="flex justify-between py-2 border-b border-[#EAEAEA]">
            <span>LOKASI</span>
            <span class="text-black font-semibold uppercase">Jakarta Selatan</span>
          </div>
        </div>
      </div>

      <!-- Apple-like Checkout Booking Block -->
      <div class="bg-white/40 backdrop-blur-xl border border-white/60 rounded-[32px] p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <h4 class="font-display font-semibold text-xs tracking-wider text-black uppercase mb-6">
          <i class="fa-solid fa-receipt mr-2"></i>RINGKASAN HARGA & PESANAN
        </h4>

        <div class="space-y-4 font-mono text-xs mb-8 border-b border-[#EAEAEA] pb-6">
          <div class="flex justify-between items-center">
            <span>Harga Mobil (OTR):</span>
            <span class="text-black font-bold">Rp <?php echo number_format($car['price'], 0, ',', '.'); ?>,-</span>
          </div>
          <div class="flex justify-between items-center text-black font-semibold">
            <span>Biaya Booking Fee (Tetap):</span>
            <span>Rp 500.000,-</span>
          </div>
          <div class="flex justify-between items-center">
            <span>Down Payment (DP 30%):</span>
            <span>Rp <?php echo number_format($car['price'] * 0.30, 0, ',', '.'); ?>,-</span>
          </div>
          <div class="flex justify-between items-center">
            <span>Pelunasan Akhir (70%):</span>
            <span>Rp <?php echo number_format($car['price'] * 0.70, 0, ',', '.'); ?>,-</span>
          </div>
        </div>

        <!-- Call to Action Buttons -->
         <?php if ($car['status'] === 'available'): ?>
          <?php if (in_array($this->session->userdata('role'), array('admin', 'staff', 'kurir'))): ?>
            <div class="bg-black/5 border border-black/10 text-black py-4 rounded-xl text-center font-display font-bold text-xs uppercase leading-relaxed">
              AKUN ADMINISTRASI TIDAK DIURUNGKAN MEMBELI MOBIL
            </div>
            <span class="block text-[9px] font-mono text-[#999999] text-center mt-2">
              *Akses Anda dibatasi untuk pengelolaan konten/dashboard saja.
            </span>
          <?php else: ?>
            <div class="space-y-3">
              <button onclick="openBookingConfirmModal(<?php echo $car['id']; ?>, '<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>', <?php echo $car['price']; ?>)" class="w-full h-14 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase shadow-sm cursor-pointer">
                <i class="fa-solid fa-cart-shopping text-[10px]"></i> Beli Sekarang
              </button>
              <button onclick="openCreditModal(<?php echo $car['price']; ?>, '<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>')" class="w-full h-14 rounded-full border border-[#DADADA] bg-white text-black hover:bg-[#F5F5F5] transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase cursor-pointer">
                Ajukan Kredit
              </button>
              <button onclick="openContactAdminModal('<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>', <?php echo $car['year']; ?>)" class="w-full h-14 rounded-full border border-[#DADADA] bg-white text-black hover:bg-[#F5F5F5] transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase cursor-pointer">
                <i class="fa-solid fa-comment"></i> Hubungi Admin
              </button>
            </div>
            <span class="block text-[10px] font-mono text-[#999999] text-center mt-3 leading-relaxed">
              *Tenggat waktu pembayaran DP 30% dan scan KTP adalah 1 minggu setelah booking fee diverifikasi.
            </span>
          <?php endif; ?>
        <?php elseif ($car['status'] === 'booked'): ?>
          <div class="bg-amber-500/5 border border-amber-500/20 text-amber-800 py-4 rounded-xl text-center font-display font-bold tracking-widest text-xs uppercase flex items-center justify-center gap-2 select-none">
            <i class="fa-solid fa-lock text-[10px]"></i> UNIT SEDANG DI-BOOKING (RESERVED)
          </div>
          <span class="block text-[10px] font-mono text-[#999999] text-center mt-3 leading-relaxed">
            *Unit mobil ini sedang diproses transaksinya oleh pembeli lain.
          </span>
        <?php else: ?>
          <div class="bg-[#F5F5F5] border border-[#EAEAEA] text-[#999999] py-4 rounded-xl text-center font-display font-bold tracking-widest text-xs uppercase">
            UNIT SUDAH TERJUAL / SOLD
          </div>
        <?php endif; ?>

      </div>

    </div>

  </div>
</section>

<!-- Smooth Tabs Script -->
<script>
  function switchTab(tabId) {
    const tabs = ['desc', 'specs', 'history'];
    tabs.forEach(t => {
      document.getElementById('content-' + t).classList.add('hidden');
      document.getElementById('tab-' + t).className = 'text-[#666666] hover:text-black pb-3 outline-none';
    });
    
    document.getElementById('content-' + tabId).classList.remove('hidden');
    document.getElementById('tab-' + tabId).className = 'text-black font-bold border-b-2 border-black pb-3 outline-none';
  }
</script>

  <!-- Modal: Booking Confirmation -->
  <div id="bookingConfirmModal" class="fixed inset-0 z-[9999] bg-black/75 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-4">
    <div class="relative max-w-md w-full bg-white border border-[#EAEAEA] rounded-[32px] p-8 shadow-[0_24px_50px_rgba(0,0,0,0.15)] scale-90 opacity-0 transition-all duration-300 ease-out" id="bookingConfirmCard">
      <div class="text-center text-black">
        <div class="w-16 h-16 bg-black text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
          <i class="fa-solid fa-key text-xl"></i>
        </div>
        <h3 class="font-display font-extrabold text-2xl text-black leading-tight mb-3">Konfirmasi Booking</h3>
        <p class="text-xs text-black/75 leading-relaxed font-sans mb-6">
          Apakah Anda yakin ingin membooking unit <span id="confirmCarName" class="font-bold text-black"></span>? 
          Unit ini akan langsung dikunci khusus untuk Anda selama <span class="font-bold text-black">1 minggu</span> agar tidak dapat dipesan orang lain.
        </p>
        
        <div class="bg-[#FAFAFA] rounded-2xl p-4 border border-[#EAEAEA] text-left font-mono text-[11px] mb-8 space-y-2 text-black">
          <div class="flex justify-between">
            <span>Booking Fee (Mengunci Unit):</span>
            <span class="font-bold">Rp 500.000,-</span>
          </div>
          <div class="flex justify-between">
            <span>Uang Muka (DP 30%):</span>
            <span class="font-bold" id="confirmDP"></span>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
          <button onclick="closeBookingConfirmModal()" class="flex-1 h-12 rounded-full border border-[#DADADA] bg-white text-black hover:bg-neutral-50 transition-all font-bold text-xs uppercase tracking-wider cursor-pointer">
            Batal
          </button>
          <a id="confirmBookingBtn" href="#" class="flex-1 h-12 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center font-bold text-xs uppercase tracking-wider shadow-sm text-center">
            Setuju & Lanjut
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Credit Simulator -->
  <div id="creditModal" class="fixed inset-0 z-[9999] bg-black/75 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-4">
    <div class="relative max-w-lg w-full bg-white border border-[#EAEAEA] rounded-[32px] p-8 shadow-[0_24px_50px_rgba(0,0,0,0.15)] scale-90 opacity-0 transition-all duration-300 ease-out" id="creditCard">
      <button onclick="closeCreditModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/5 hover:bg-black/10 border border-black/5 text-black flex items-center justify-center transition-all duration-300">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
      
      <h3 class="font-display font-extrabold text-2xl text-black leading-tight mb-2">Simulasi Kredit</h3>
      <p class="text-xs text-black/60 font-sans mb-6">Simulasikan angsuran bulanan unit <span id="creditCarName" class="font-semibold text-black"></span>.</p>

      <div class="space-y-5 text-black">
        <!-- Car Price -->
        <div class="flex flex-col gap-1.5">
          <label class="text-[9px] font-mono tracking-wider uppercase font-semibold text-black/60">Harga OTR Kendaraan</label>
          <div class="h-12 px-4 rounded-xl border border-[#DADADA] bg-neutral-50 flex items-center text-xs font-mono font-bold" id="simPriceLabel"></div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <!-- Down Payment Percentage -->
          <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-mono tracking-wider uppercase font-semibold text-black/60">Uang Muka (Min. 30%)</label>
            <div class="relative">
              <input type="number" id="simDpPct" min="30" max="90" value="30" oninput="calculateInstallment()" 
                     class="w-full h-12 pl-4 pr-10 rounded-xl border border-[#DADADA] bg-white text-xs font-mono text-black focus:border-black focus:outline-none transition-colors">
              <span class="absolute right-4 top-3.5 text-xs font-mono text-black/60">%</span>
            </div>
          </div>

          <!-- Tenor -->
          <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-mono tracking-wider uppercase font-semibold text-black/60">Tenor (Bulan)</label>
            <select id="simTenor" onchange="calculateInstallment()" 
                    class="w-full h-12 px-4 rounded-xl border border-[#DADADA] bg-white text-xs font-mono text-black focus:border-black focus:outline-none transition-colors">
              <option value="12">12 Bulan (1 Tahun)</option>
              <option value="24">24 Bulan (2 Tahun)</option>
              <option value="36">36 Bulan (3 Tahun)</option>
              <option value="48" selected>48 Bulan (4 Tahun)</option>
              <option value="60">60 Bulan (5 Tahun)</option>
            </select>
          </div>
        </div>

        <!-- Calculated Summary Card -->
        <div class="bg-black/5 rounded-2xl p-4 border border-black/10 font-mono text-xs space-y-2.5">
          <div class="flex justify-between">
            <span>Nominal Uang Muka (DP):</span>
            <span class="font-bold" id="resDp"></span>
          </div>
          <div class="flex justify-between">
            <span>Pokok Pinjaman (Kredit):</span>
            <span class="font-bold" id="resPrincipal"></span>
          </div>
          <div class="flex justify-between py-2 border-t border-black/10 text-sm">
            <span>Angsuran per Bulan:</span>
            <span class="font-bold text-black" id="resInstallment"></span>
          </div>
        </div>

        <button onclick="submitCreditSimulation()" class="w-full h-12 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-bold text-xs uppercase tracking-wider shadow-sm mt-4 cursor-pointer">
          Ajukan Simulasi Kredit
        </button>
      </div>
    </div>
  </div>

  <!-- Modal: Contact Admin -->
  <div id="contactAdminModal" class="fixed inset-0 z-[9999] bg-black/75 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-4">
    <div class="relative max-w-sm w-full bg-white border border-[#EAEAEA] rounded-[32px] p-8 shadow-[0_24px_50px_rgba(0,0,0,0.15)] scale-90 opacity-0 transition-all duration-300 ease-out" id="contactAdminCard">
      <button onclick="closeContactAdminModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/5 hover:bg-black/10 border border-black/5 text-black flex items-center justify-center transition-all duration-300">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>

      <div class="text-center text-black">
        <div class="w-16 h-16 bg-[#121212] text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
          <i class="fa-solid fa-comment-dots text-xl"></i>
        </div>
        <h3 class="font-display font-extrabold text-2xl text-black leading-tight mb-2">Hubungi Admin</h3>
        <p class="text-xs text-black/60 font-sans mb-6">Pilih salah satu metode kontak untuk terhubung dengan tim showroom kami.</p>

        <div class="space-y-3 mb-8 text-left font-mono text-xs">
          <div class="flex items-center gap-3 p-3.5 rounded-xl border border-[#EAEAEA] bg-[#FAFAFA] hover:border-black transition-colors duration-300">
            <i class="fa-solid fa-location-dot text-black text-base w-5 text-center"></i>
            <div>
              <span class="block text-[8px] text-black/50 font-bold uppercase tracking-wider">Showroom Kantor</span>
              <span class="text-[10px] text-black font-bold">DRIVE.X Head Office, Jakarta</span>
            </div>
          </div>
          <div class="flex items-center gap-3 p-3.5 rounded-xl border border-[#EAEAEA] bg-[#FAFAFA] hover:border-black transition-colors duration-300">
            <i class="fa-solid fa-phone text-black text-base w-5 text-center"></i>
            <div>
              <span class="block text-[8px] text-black/50 font-bold uppercase tracking-wider">Telepon & WhatsApp</span>
              <span class="text-[10px] text-black font-bold">0811-1222-333</span>
            </div>
          </div>
        </div>

        <a id="whatsappBtn" href="#" target="_blank" class="w-full h-12 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white transition-all flex items-center justify-center gap-2 font-bold text-xs uppercase tracking-wider shadow-sm text-center">
          <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Chat Instan
        </a>
      </div>
    </div>
  </div>

  <script>
    // Global state variables for simulation
    let currentCarPrice = 0;
    let currentCarModel = '';

    // ==========================================
    // 1. Booking Confirmation Modal Logic
    // ==========================================
    function openBookingConfirmModal(carId, carModel, price) {
      const modal = document.getElementById('bookingConfirmModal');
      const card = document.getElementById('bookingConfirmCard');
      const nameSpan = document.getElementById('confirmCarName');
      const dpSpan = document.getElementById('confirmDP');
      const confirmBtn = document.getElementById('confirmBookingBtn');

      if (modal && card) {
        nameSpan.textContent = carModel;
        
        // Calculate DP 30%
        const dpVal = price * 0.30;
        const formattedDP = new Intl.NumberFormat('id-ID', {
          style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(dpVal).replace('Rp', 'Rp ') + ',-';
        dpSpan.textContent = formattedDP;

        // Set action href
        confirmBtn.setAttribute('href', '<?php echo base_url("booking/checkout/"); ?>' + carId);

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-90', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
      }
    }

    function closeBookingConfirmModal() {
      const modal = document.getElementById('bookingConfirmModal');
      const card = document.getElementById('bookingConfirmCard');
      if (modal && card) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
        card.classList.add('scale-90', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
      }
    }

    // ==========================================
    // 2. Credit Simulator Modal Logic
    // ==========================================
    function openCreditModal(price, carModel) {
      currentCarPrice = price;
      currentCarModel = carModel;

      const modal = document.getElementById('creditModal');
      const card = document.getElementById('creditCard');
      const nameSpan = document.getElementById('creditCarName');
      const priceLabel = document.getElementById('simPriceLabel');

      if (modal && card) {
        nameSpan.textContent = carModel;
        
        const formattedPrice = new Intl.NumberFormat('id-ID', {
          style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(price).replace('Rp', 'Rp ') + ',-';
        priceLabel.textContent = formattedPrice;

        // Reset DP to 30%
        document.getElementById('simDpPct').value = 30;

        calculateInstallment();

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-90', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
      }
    }

    function closeCreditModal() {
      const modal = document.getElementById('creditModal');
      const card = document.getElementById('creditCard');
      if (modal && card) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
        card.classList.add('scale-90', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
      }
    }

    // Real-time Credit Calculations
    function calculateInstallment() {
      let dpPct = parseFloat(document.getElementById('simDpPct').value);
      
      // Enforce minimum 30% Down Payment (per business requirements)
      if (isNaN(dpPct) || dpPct < 30) {
        dpPct = 30;
      }
      if (dpPct > 90) dpPct = 90;

      const tenor = parseInt(document.getElementById('simTenor').value);
      
      const dpValue = currentCarPrice * (dpPct / 100);
      const principal = currentCarPrice - dpValue;

      // Rate simulation: 5% flat interest per year
      const annualRate = 0.05; 
      const totalInterest = principal * annualRate * (tenor / 12);
      const monthlyInstallment = (principal + totalInterest) / tenor;

      // Format & Render outputs
      const f = (val) => new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
      }).format(val).replace('Rp', 'Rp ') + ',-';

      document.getElementById('resDp').textContent = f(dpValue) + ` (${dpPct}%)`;
      document.getElementById('resPrincipal').textContent = f(principal);
      document.getElementById('resInstallment').textContent = f(monthlyInstallment) + ' / Bulan';
    }

    function submitCreditSimulation() {
      const dpPct = document.getElementById('simDpPct').value;
      const tenor = document.getElementById('simTenor').value;
      alert(`Pengajuan Simulasi Kredit untuk unit ${currentCarModel} dengan Tenor ${tenor} Bulan & DP ${dpPct}% berhasil didaftarkan!\n\nSilakan klik "Hubungi Admin" untuk proses persetujuan dan pengiriman berkas persyaratan.`);
      closeCreditModal();
    }

    // ==========================================
    // 3. Contact Admin Modal Logic
    // ==========================================
    function openContactAdminModal(carModel, year) {
      const modal = document.getElementById('contactAdminModal');
      const card = document.getElementById('contactAdminCard');
      const waBtn = document.getElementById('whatsappBtn');

      if (modal && card) {
        // Build custom whatsapp text
        const waText = encodeURIComponent(`Halo Admin DRIVE.X, saya tertarik dengan unit mobil *${carModel}* tahun *${year}*. Bisa bantu informasi selengkapnya mengenai unit ini dan pengurusan pembeliannya?`);
        waBtn.setAttribute('href', 'https://wa.me/628111222333?text=' + waText);

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-90', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
      }
    }

    function closeContactAdminModal() {
      const modal = document.getElementById('contactAdminModal');
      const card = document.getElementById('contactAdminCard');
      if (modal && card) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
        card.classList.add('scale-90', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
      }
    }

    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeBookingConfirmModal();
        closeCreditModal();
        closeContactAdminModal();
      }
    });
  </script>
