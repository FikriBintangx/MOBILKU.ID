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
              <a href="<?php echo base_url('booking/checkout/' . $car['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin membooking unit mobil ini? Unit akan langsung dikunci khusus untuk Anda, dan Anda akan diarahkan ke halaman Pembayaran Booking Fee.')" class="w-full h-14 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase shadow-sm">
                <i class="fa-solid fa-cart-shopping text-[10px]"></i> Beli Sekarang
              </a>
              <a href="#" class="w-full h-14 rounded-full border border-[#DADADA] bg-white text-black hover:bg-[#F5F5F5] transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase">
                Ajukan Kredit
              </a>
              <a href="#" class="w-full h-14 rounded-full border border-[#DADADA] bg-white text-black hover:bg-[#F5F5F5] transition-all flex items-center justify-center gap-2 font-bold text-xs tracking-widest uppercase">
                <i class="fa-solid fa-comment"></i> Hubungi Admin
              </a>
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
