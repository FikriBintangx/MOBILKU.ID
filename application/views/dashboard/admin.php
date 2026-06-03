<!-- 06. DASHBOARD ADMIN WIREFRAME REDESIGN (Framer x Nothing OS Monochrome Layout) -->
<style>
  body {
    background-image: url('<?php echo base_url("assets/images/bg2.png"); ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  /* SOLUSI UI: Panel utama Solid White agar bersih dan kontras dengan background yang ramai */
  .bg-white {
    background-color: #ffffff !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important; /* Shadow agar mengambang */
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
  }

  /* Kembalikan efek frosted halus khusus untuk Card */
  .framer-card, .card {
    background-color: rgba(255, 255, 255, 0.75) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border: 1px solid #EAEAEA !important;
  }
  
  /* Tombol biarkan solid */
  button.bg-black, .btn-black {
    background-color: #000 !important;
    color: #fff !important;
  }
</style>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" data-aos="fade-up" data-aos-duration="700">
  
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white border border-[#EAEAEA] rounded-[28px] overflow-hidden shadow-sm min-h-[720px]">
    
    <!-- LEFT SIDEBAR: Brand & Navigation Menu -->
    <div class="lg:col-span-3 border-r border-[#EAEAEA] p-8 flex flex-col justify-between bg-white">
      <div class="space-y-10">
        <!-- Brand Title & Subtext -->
        <div>
          <h2 class="font-display font-extrabold text-2xl text-black tracking-tight leading-none mb-1">CarBuySell</h2>
          <span class="text-[10px] font-mono text-[#999999] uppercase tracking-wider">Admin-Panel</span>
        </div>

        <!-- Navigation Menu List -->
        <nav class="flex flex-col gap-1 font-sans text-sm font-medium text-[#666666] pb-12">
          
          <div class="text-[#999999] text-[9px] font-bold uppercase tracking-widest px-4 mb-2 mt-4">Menu Utama</div>
          <a href="javascript:void(0)" onclick="switchAdminPanel('dashboard')" id="menu-dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-black text-white transition-all mx-2 shadow-[0_4px_12px_rgba(0,0,0,0.1)]">
            <i class="fa-solid fa-chart-line text-xs w-4 text-center"></i>
            <span>Dashboard</span>
          </a>

          <div class="text-[#999999] text-[9px] font-bold uppercase tracking-widest px-4 mb-2 mt-6">Inventory & Transaksi</div>
          <a href="javascript:void(0)" onclick="switchAdminPanel('kelola-mobil')" id="menu-kelola-mobil" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all mx-2">
            <i class="fa-solid fa-car text-xs w-4 text-center"></i>
            <span>Kelola Mobil</span>
          </a>
          
          <div class="space-y-1 mt-1 mx-2">
            <button onclick="document.getElementById('submenu-transaksi').classList.toggle('hidden')" class="w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all">
              <div class="flex items-center gap-3">
                <i class="fa-solid fa-wallet text-xs w-4 text-center"></i>
                <span>Transaksi</span>
              </div>
              <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </button>
            <div id="submenu-transaksi" class="hidden pl-11 pr-4 py-1 space-y-1 border-l-2 border-[#EAEAEA] ml-6 mb-2 mt-1">
              <a href="javascript:void(0)" onclick="switchAdminPanel('transaksi')" id="menu-transaksi" class="flex items-center justify-between text-xs text-[#999999] hover:text-black transition-all py-1.5 group">
                <span>Penjualan / Pesanan</span>
                <span id="badge-pesanan" class="hidden font-mono dot-matrix bg-red-500 text-white rounded-full px-1.5 py-0.5 text-[8px] font-bold shadow-sm">0</span>
              </a>
              <a href="javascript:void(0)" onclick="switchAdminPanel('transaksi'); setTimeout(() => { document.getElementById('progress-section').scrollIntoView({behavior: 'smooth', block: 'start'}); }, 100);" id="menu-progress" class="flex items-center justify-between text-xs text-[#999999] hover:text-black transition-all py-1.5 group">
                <span>Progress Dokumen</span>
                <span id="badge-progress" class="hidden font-mono dot-matrix bg-black text-white rounded-full px-1.5 py-0.5 text-[8px] font-bold shadow-sm">0</span>
              </a>
              <a href="javascript:void(0)" onclick="switchAdminPanel('sourcing')" id="menu-sourcing" class="flex items-center justify-between text-xs text-[#999999] hover:text-black transition-all py-1.5 group">
                <span>Pembelian / Sourcing</span>
                <span id="badge-sourcing" class="hidden font-mono dot-matrix bg-blue-500 text-white rounded-full px-1.5 py-0.5 text-[8px] font-bold shadow-sm">0</span>
              </a>
            </div>
          </div>

          <div class="text-[#999999] text-[9px] font-bold uppercase tracking-widest px-4 mb-2 mt-6">Logistik</div>
          <div class="space-y-1 mx-2">
            <button onclick="document.getElementById('submenu-pengiriman').classList.toggle('hidden')" class="w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all">
              <div class="flex items-center gap-3">
                <i class="fa-solid fa-truck-fast text-xs w-4 text-center"></i>
                <span>Pengiriman</span>
              </div>
              <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </button>
            <div id="submenu-pengiriman" class="hidden pl-11 pr-4 py-1 space-y-1 border-l-2 border-[#EAEAEA] ml-6 mb-2 mt-1">
              <a href="javascript:void(0)" onclick="switchAdminPanel('pengiriman')" id="menu-pengiriman" class="block text-xs text-[#999999] hover:text-black transition-all py-1.5">Proses Pengiriman</a>
              <a href="<?php echo base_url('admin/monitoring_pengiriman'); ?>" class="block text-xs text-[#999999] hover:text-black transition-all py-1.5">Monitoring Tracker</a>
            </div>
          </div>

          <div class="text-[#999999] text-[9px] font-bold uppercase tracking-widest px-4 mb-2 mt-6">Manajemen & Laporan</div>
          <a href="javascript:void(0)" onclick="switchAdminPanel('pelanggan')" id="menu-pelanggan" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all mx-2">
            <i class="fa-solid fa-users text-xs w-4 text-center"></i>
            <span>Data Pelanggan</span>
          </a>

          <div class="space-y-1 mt-1 mx-2">
            <button onclick="document.getElementById('submenu-laporan').classList.toggle('hidden')" class="w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all">
              <div class="flex items-center gap-3">
                <i class="fa-solid fa-file-invoice-dollar text-xs w-4 text-center"></i>
                <span>Laporan</span>
              </div>
              <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </button>
            <div id="submenu-laporan" class="hidden pl-11 pr-4 py-1 space-y-1 border-l-2 border-[#EAEAEA] ml-6 mb-2 mt-1">
              <a href="javascript:void(0)" onclick="switchAdminPanel('laporan_penjualan')" id="menu-laporan_penjualan" class="block text-xs text-[#999999] hover:text-black transition-all py-1.5">Laporan Penjualan</a>
              <a href="javascript:void(0)" onclick="switchAdminPanel('laporan_pembelian')" id="menu-laporan_pembelian" class="block text-xs text-[#999999] hover:text-black transition-all py-1.5">Laporan Pembelian</a>
            </div>
          </div>

          <div class="text-[#999999] text-[9px] font-bold uppercase tracking-widest px-4 mb-2 mt-6">Sistem</div>
          <a href="javascript:void(0)" onclick="switchAdminPanel('pengaturan')" id="menu-pengaturan" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all mx-2">
            <i class="fa-solid fa-sliders text-xs w-4 text-center"></i>
            <span>Pengaturan</span>
          </a>
          <a href="javascript:void(0)" onclick="switchAdminPanel('user')" id="menu-user" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black transition-all mx-2">
            <i class="fa-solid fa-user-gear text-xs w-4 text-center"></i>
            <span>Manajemen User</span>
          </a>
          <a href="<?php echo base_url('mobil/logout'); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-red-50 hover:text-red-600 transition-all font-mono text-xs mt-6 mx-2 border border-red-100">
            <i class="fa-solid fa-power-off text-xs w-4 text-center text-red-600"></i>
            <span class="text-red-600 font-bold">Logout Sistem</span>
          </a>
        </nav>
      </div>

      <!-- Tiny Technical Matrix Indicator -->
      <div class="pt-6 border-t border-[#EAEAEA] text-[8px] font-mono text-[#999999]">
        <span>SYSTEM OPERATIONAL</span>
        <div class="dot-matrix text-black mt-1 blink-dot">● ONLINE</div>
      </div>
    </div>

    <!-- RIGHT CONTAINER: Analytics, Lists & Workspaces -->
    <div class="lg:col-span-9 p-8 bg-[#FAFAFA] space-y-8 overflow-y-auto relative">
      
      <!-- 1. DASHBOARD PANEL -->
      <div id="panel-dashboard" class="space-y-8 admin-panel-div">
        <!-- TOP ROW: 4 Clean Statistical Counter Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[10px] uppercase font-mono tracking-wider">Mobil Tersedia</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block">
              <?php echo number_format($this->db->get_where('cars', array('status' => 'available'))->num_rows(), 0, ',', '.'); ?>
            </span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[10px] uppercase font-mono tracking-wider">Transaksi</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block">
              <?php echo number_format(count($bookings), 0, ',', '.'); ?>
            </span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[10px] uppercase font-mono tracking-wider">Pembeli</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block">
              <?php echo number_format($this->db->get_where('users', array('role' => 'client'))->num_rows(), 0, ',', '.'); ?>
            </span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[10px] uppercase font-mono tracking-wider">Penjual</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block">
              <?php echo number_format(count($sourcing), 0, ',', '.'); ?>
            </span>
          </div>
        </div>

        <!-- MIDDLE ROW: Sales Graph & Recent Transactions list side by side -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
          <?php
            // Dynamic Sales Graph Calculator — ONLY completed transactions
            $current_year = date('Y');
            $monthly_sales = array_fill(1, 12, 0); // Months 1 to 12

            foreach ($bookings as $b) {
                // Only count successfully completed bookings
                if ($b['status'] !== 'completed') continue;
                $b_year = date('Y', strtotime($b['booking_date']));
                if ($b_year == $current_year) {
                    $b_month = (int)date('n', strtotime($b['booking_date']));
                    $monthly_sales[$b_month]++;
                }
            }

            // Calculate coordinates
            $points = array();
            $max_sales = max($monthly_sales);
            $scale_max = ($max_sales > 0) ? $max_sales : 5;

            $month_names = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

            // Generate X, Y coordinates for 12 months
            for ($m = 1; $m <= 12; $m++) {
                $x = (($m - 1) / 11) * 300;
                $ratio = $monthly_sales[$m] / $scale_max;
                $y = 110 - ($ratio * 80);
                $points[] = array('x' => $x, 'y' => $y, 'val' => $monthly_sales[$m], 'm' => $m, 'label' => $month_names[$m]);
            }

            // Generate SVG path string
            $path_str = "";
            $area_path_str = "";
            
            if ($max_sales == 0) {
                $path_str = "M 0,110 L 300,110";
                $area_path_str = "M 0,110 L 300,110 L 300,120 L 0,120 Z";
            } else {
                $path_str = "M " . $points[0]['x'] . "," . $points[0]['y'];
                for ($i = 1; $i < count($points); $i++) {
                    $path_str .= " L " . $points[$i]['x'] . "," . $points[$i]['y'];
                }
                $area_path_str = $path_str . " L 300,120 L 0,120 Z";
            }
          ?>

          <!-- Left: Sales Graph Chart (7 cols) -->
          <div class="lg:col-span-7 bg-white border border-[#EAEAEA] rounded-[24px] p-6 shadow-sm relative overflow-hidden flex flex-col justify-between framer-card">
            <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>
            
            <div class="flex justify-between items-center mb-6">
              <div>
                <h4 class="font-display font-bold text-sm text-black">Grafik Penjualan</h4>
                <p class="text-[8px] font-mono text-neutral-400 mt-0.5">TRANSAKSI SELESAI — TAHUN <?php echo $current_year; ?></p>
              </div>
              <span class="text-[9px] font-mono border border-[#EAEAEA] px-2.5 py-1 rounded-full font-bold uppercase">Tahun Ini</span>
            </div>

            <!-- Interactive Chart with hover tooltip -->
            <div class="flex gap-4 items-stretch h-44 relative">
              <!-- Left Y-Axis Labels -->
              <div class="flex flex-col justify-between text-[8px] font-mono text-[#999999] text-right w-6 select-none">
                <span><?php echo $scale_max; ?></span>
                <span><?php echo round($scale_max * 0.75); ?></span>
                <span><?php echo round($scale_max * 0.50); ?></span>
                <span><?php echo round($scale_max * 0.25); ?></span>
                <span>0</span>
              </div>

              <!-- Chart SVG with interactive hover -->
              <div class="flex-grow relative h-full" id="chart-container">

                <!-- Hover Tooltip (absolutely positioned over chart) -->
                <div id="chart-tooltip" style="display:none;position:absolute;z-index:20;pointer-events:none;background:#000;color:#fff;border-radius:10px;padding:6px 12px;font-family:'IBM Plex Mono',monospace;font-size:10px;font-weight:700;white-space:nowrap;transform:translateX(-50%);box-shadow:0 8px 24px rgba(0,0,0,0.18);">
                  <span id="chart-tooltip-text">Jan: 0</span>
                  <div style="position:absolute;bottom:-5px;left:50%;transform:translateX(-50%);width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #000;"></div>
                </div>

                <svg id="sales-chart-svg" class="absolute inset-0 w-full h-full" viewBox="0 0 300 120" preserveAspectRatio="none" style="cursor:crosshair;overflow:visible;">
                  <defs>
                    <pattern id="matrix-dot-grid-dense" width="8" height="8" patternUnits="userSpaceOnUse">
                      <circle cx="1.5" cy="1.5" r="0.5" fill="#EAEAEA" />
                    </pattern>
                  </defs>
                  
                  <!-- Background -->
                  <rect width="100%" height="100%" fill="url(#matrix-dot-grid-dense)" />
                  
                  <!-- Grid lines -->
                  <line x1="0" y1="30" x2="300" y2="30" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="2 3"></line>
                  <line x1="0" y1="60" x2="300" y2="60" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="2 3"></line>
                  <line x1="0" y1="90" x2="300" y2="90" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="2 3"></line>

                  <!-- Crosshair (single, correct placement) -->
                  <line id="chart-crosshair" x1="0" y1="0" x2="0" y2="120" stroke="#000" stroke-width="0.8" stroke-dasharray="3 3" opacity="0" pointer-events="none"/>

                  <!-- Area fill -->
                  <path d="<?php echo $area_path_str; ?>" fill="rgba(0,0,0,0.04)"></path>
                  
                  <!-- Main line -->
                  <path d="<?php echo $path_str; ?>" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  
                  <!-- Data dots only (no hover circles - hover handled by JS mousemove) -->
                  <?php foreach ($points as $p): ?>
                    <circle 
                      class="chart-data-dot"
                      id="dot-m<?php echo $p['m']; ?>"
                      cx="<?php echo $p['x']; ?>" 
                      cy="<?php echo $p['y']; ?>" 
                      r="<?php echo $p['val'] > 0 ? '4' : '3'; ?>" 
                      fill="<?php echo $p['val'] > 0 ? '#000' : '#DADADA'; ?>"
                      data-month="<?php echo $p['label']; ?>"
                      data-val="<?php echo $p['val']; ?>"
                      data-x="<?php echo $p['x']; ?>"
                      data-y="<?php echo $p['y']; ?>"
                      pointer-events="none"
                    />
                  <?php endforeach; ?>

                  <!-- Full transparent overlay rect for mouse tracking -->
                  <rect id="chart-mouse-overlay" x="0" y="0" width="300" height="120" fill="transparent" />
                </svg>
              </div>
            </div>
            <div class="flex justify-between items-center text-[8px] font-mono text-[#999999] pt-4 mt-2 border-t border-[#EAEAEA]">
              <span>JAN</span><span>MAR</span><span>MEI</span><span>JUL</span><span>SEP</span><span>NOP</span><span>DES</span>
            </div>
          </div>

          <!-- Right: Recent Transactions List (5 cols) -->
          <div class="lg:col-span-5 bg-white border border-[#EAEAEA] rounded-[24px] p-6 shadow-sm flex flex-col justify-between framer-card">
            <div>
              <div class="flex justify-between items-center mb-6">
                <h4 class="font-display font-bold text-sm text-black">Transaksi Terbaru</h4>
                <a href="javascript:void(0)" onclick="switchAdminPanel('transaksi')" class="text-[10px] font-mono font-bold text-[#666666] hover:text-black hover:underline uppercase">Lihat Semua</a>
              </div>
              <div class="space-y-3">
                <?php 
                  $shown = 0;
                  foreach ($bookings as $b): 
                    if ($shown >= 4) break;
                    $shown++;
                    // Status badge config
                    if ($b['status'] === 'completed') {
                      $statusBg = 'bg-emerald-50'; $statusText = 'text-emerald-700'; $statusBorder = 'border-emerald-200'; $statusLabel = 'Selesai'; $statusIcon = 'fa-circle-check';
                    } elseif ($b['status'] === 'cancelled') {
                      $statusBg = 'bg-red-50'; $statusText = 'text-red-700'; $statusBorder = 'border-red-200'; $statusLabel = 'Batal'; $statusIcon = 'fa-circle-xmark';
                    } elseif ($b['status'] === 'ordered') {
                      $statusBg = 'bg-blue-50'; $statusText = 'text-blue-700'; $statusBorder = 'border-blue-200'; $statusLabel = 'Pending'; $statusIcon = 'fa-clock';
                    } else {
                      $statusBg = 'bg-purple-50'; $statusText = 'text-purple-700'; $statusBorder = 'border-purple-200'; $statusLabel = ucfirst($b['status']); $statusIcon = 'fa-spinner';
                    }
                ?>
                  <div class="flex items-center justify-between gap-3 p-3 rounded-[14px] hover:bg-[#FAFAFA] transition-colors group cursor-default">
                    <div class="flex items-center gap-3">
                      <!-- Avatar -->
                      <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-black text-xs font-display flex-shrink-0
                        <?php echo ($b['status'] === 'completed') ? 'bg-emerald-100 border border-emerald-200' : (($b['status'] === 'cancelled') ? 'bg-red-100 border border-red-200' : 'bg-[#F5F5F5] border border-[#EAEAEA]'); ?>">
                        <?php echo strtoupper(substr($b['fullname'], 0, 1)); ?>
                      </div>
                      <div>
                        <span class="font-bold text-black font-sans block text-[12px] leading-tight"><?php echo $b['fullname']; ?></span>
                        <span class="text-[9px] text-[#999999] block mt-0.5 font-mono"><?php echo $b['brand'] . ' ' . $b['model']; ?></span>
                        <span class="text-[8px] text-[#BBBBBB] font-mono"><?php echo $b['booking_code']; ?></span>
                      </div>
                    </div>
                    <div class="text-right flex flex-col items-end gap-1.5">
                      <span class="text-black font-bold font-sans text-[12px]">Rp <?php echo number_format($b['car_price'] * 0.30, 0, ',', '.'); ?></span>
                      <!-- Status badge -->
                      <span class="px-2 py-0.5 rounded-full text-[8px] font-mono font-bold border inline-flex items-center gap-1 <?php echo $statusBg . ' ' . $statusText . ' ' . $statusBorder; ?>">
                        <i class="fa-solid <?php echo $statusIcon; ?> text-[7px]"></i>
                        <?php echo $statusLabel; ?>
                      </span>
                    </div>
                  </div>
                <?php endforeach; ?>
                
                <?php if ($shown === 0): ?>
                  <div class="text-center py-8 text-[#999999] font-mono text-xs border border-dashed border-[#EAEAEA] rounded-[18px] bg-[#FAFAFA]">
                    Belum ada transaksi masuk saat ini.
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
      // ===== INTERACTIVE CHART HOVER (mousemove approach - no glitch) =====
      (function() {
        const svg    = document.getElementById('sales-chart-svg');
        const overlay= document.getElementById('chart-mouse-overlay');
        const tooltip= document.getElementById('chart-tooltip');
        const tipText= document.getElementById('chart-tooltip-text');
        const cross  = document.getElementById('chart-crosshair');
        const container = document.getElementById('chart-container');
        if (!svg || !overlay || !tooltip) return;

        // Collect data point info from DOM
        const dots = Array.from(svg.querySelectorAll('.chart-data-dot'));
        const dataPoints = dots.map(function(d) {
          return {
            el:    d,
            x:     parseFloat(d.getAttribute('data-x')),
            y:     parseFloat(d.getAttribute('data-y')),
            val:   parseInt(d.getAttribute('data-val'), 10),
            month: d.getAttribute('data-month'),
            origR: parseInt(d.getAttribute('r'), 10),
            origFill: d.getAttribute('fill')
          };
        });

        let activeIdx = -1;

        // Convert mouse event coords to SVG viewBox coords
        function toSVGCoords(evt) {
          const rect = svg.getBoundingClientRect();
          return {
            x: (evt.clientX - rect.left) / rect.width  * 300,
            y: (evt.clientY - rect.top)  / rect.height * 120
          };
        }

        // Find nearest data point by X distance
        function nearestPoint(svgX) {
          let best = 0, bestDist = Infinity;
          dataPoints.forEach(function(p, i) {
            const d = Math.abs(p.x - svgX);
            if (d < bestDist) { bestDist = d; best = i; }
          });
          // Only highlight if within ~20px SVG units
          return bestDist < 22 ? best : -1;
        }

        // Convert SVG X to container px (for tooltip)
        function svgXtoPx(svgX) {
          return svgX / 300 * svg.getBoundingClientRect().width;
        }
        function svgYtoPx(svgY) {
          return svgY / 120 * svg.getBoundingClientRect().height;
        }

        function resetDot(p) {
          p.el.setAttribute('r', p.origR);
          p.el.setAttribute('fill', p.origFill);
        }
        function highlightDot(p) {
          p.el.setAttribute('r', p.val > 0 ? '7' : '5');
          p.el.setAttribute('fill', '#000');
        }

        overlay.addEventListener('mousemove', function(evt) {
          const coords = toSVGCoords(evt);
          const idx    = nearestPoint(coords.x);

          if (idx === -1) {
            // Mouse not near any point — hide
            if (activeIdx !== -1) {
              resetDot(dataPoints[activeIdx]);
              activeIdx = -1;
            }
            tooltip.style.opacity = '0';
            tooltip.style.pointerEvents = 'none';
            if (cross) cross.setAttribute('opacity', '0');
            return;
          }

          const p = dataPoints[idx];

          // Only update DOM if active point changed
          if (idx !== activeIdx) {
            if (activeIdx !== -1) resetDot(dataPoints[activeIdx]);
            highlightDot(p);
            activeIdx = idx;

            // Update tooltip text
            tipText.textContent = p.month + ': ' + p.val + ' transaksi selesai';
          }

          // Position tooltip above the dot (in container px)
          const px = svgXtoPx(p.x);
          const py = svgYtoPx(p.y);
          tooltip.style.display   = 'block';
          tooltip.style.opacity   = '1';
          tooltip.style.left      = px + 'px';
          tooltip.style.top       = (py - 48) + 'px';

          // Move crosshair
          if (cross) {
            cross.setAttribute('x1', p.x);
            cross.setAttribute('x2', p.x);
            cross.setAttribute('opacity', '0.35');
          }
        });

        overlay.addEventListener('mouseleave', function() {
          if (activeIdx !== -1) { resetDot(dataPoints[activeIdx]); activeIdx = -1; }
          tooltip.style.opacity = '0';
          setTimeout(function(){ tooltip.style.display = 'none'; }, 150);
          if (cross) cross.setAttribute('opacity', '0');
        });

        // Smooth tooltip fade
        tooltip.style.transition = 'opacity 0.15s ease';
        tooltip.style.opacity    = '0';
      })();
      </script>


      <!-- 2. KELOLA MOBIL PANEL -->

      <div id="panel-kelola-mobil" class="hidden space-y-8 admin-panel-div">
        <!-- CARD 1: KATALOG STOK & STATUS MOBIL -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card">
          <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <h3 class="font-display font-bold text-base text-black flex items-center gap-2">
              <i class="fa-solid fa-car text-black"></i> KELOLA STOK & STATUS KATALOG MOBIL
            </h3>
            
            <!-- BULK SAVE BUTTON -->
            <button type="submit" form="bulk-car-catalog-form" class="px-6 py-2.5 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-sans font-bold text-[10px] uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
              <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Semua Perubahan
            </button>
          </div>

          <div class="overflow-x-auto">
            <form id="bulk-car-catalog-form" action="<?php echo base_url('admin/update_all_cars_catalog'); ?>" method="post">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <table class="w-full text-left font-mono text-xs">
                <thead>
                  <tr class="border-b border-[#EAEAEA] text-[#666666]">
                    <th class="py-3 uppercase font-semibold">Mobil</th>
                    <th class="py-3 uppercase font-semibold">Plat Nomor</th>
                    <th class="py-3 uppercase font-semibold">Harga</th>
                    <th class="py-3 uppercase text-right font-semibold">Pengaturan (Stok, Status, Simpan)</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                  <?php if (empty($cars)): ?>
                    <tr>
                      <td colspan="4" class="py-6 text-center text-[#999999]">Tidak ada mobil dalam database katalog.</td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($cars as $c): ?>
                      <tr class="hover:bg-[#FAFAFA] transition-colors">
                        <td class="py-4">
                          <div class="flex items-center gap-3">
                            <?php if (!empty($c['image_url'])): ?>
                              <img src="<?php echo base_url('uploads/' . $c['image_url']); ?>" alt="" class="w-12 h-8 object-cover rounded-lg border border-[#EAEAEA]">
                            <?php else: ?>
                              <div class="w-12 h-8 bg-neutral-100 border border-[#EAEAEA] rounded-lg flex items-center justify-center text-[10px] text-neutral-400 font-bold uppercase">CAR</div>
                            <?php endif; ?>
                            <div>
                              <span class="font-bold text-black font-sans block text-[13px] leading-tight uppercase"><?php echo esc($c['brand'] . ' ' . $c['model']); ?></span>
                              <span class="text-[9px] text-[#999999] block mt-0.5"><?php echo esc($c['year'] . ' | ' . ($c['color'] ?? 'Default')); ?></span>
                            </div>
                          </div>
                        </td>
                        <td class="py-4 font-bold text-black uppercase"><?php echo esc($c['plate_number']); ?></td>
                        <td class="py-4 font-sans font-bold">Rp <?php echo number_format($c['price'], 0, ',', '.'); ?></td>
                        <td class="py-4 text-right">
                          <div class="inline-flex items-center justify-end gap-2">
                            <div class="flex items-center gap-1">
                              <span class="text-[9px] text-neutral-400 uppercase font-bold">Stok:</span>
                              <input type="number" name="stocks[<?php echo $c['id']; ?>]" value="<?php echo $c['stock']; ?>" min="0" required class="cyber-input w-14 text-center font-bold font-mono text-xs py-1 px-1.5">
                            </div>

                            <div class="flex items-center gap-1">
                              <span class="text-[9px] text-neutral-400 uppercase font-bold">Status:</span>
                              <select name="statuses[<?php echo $c['id']; ?>]" class="bg-white border border-[#EAEAEA] text-black rounded-xl px-2 py-1 font-mono text-[10px] h-8 outline-none focus:border-black transition-all">
                                <option value="available" <?php echo ($c['status'] === 'available') ? 'selected' : ''; ?>>AVAILABLE</option>
                                <option value="booked" <?php echo ($c['status'] === 'booked') ? 'selected' : ''; ?>>BOOKED</option>
                                <option value="sold" <?php echo ($c['status'] === 'sold') ? 'selected' : ''; ?>>SOLD</option>
                              </select>
                            </div>

                            <!-- Single Row Save Button -->
                            <button type="submit" name="single_car_id" value="<?php echo $c['id']; ?>" class="px-4 py-1.5 h-8 rounded-full bg-neutral-200 text-black hover:bg-neutral-300 font-sans font-bold text-[9px] uppercase transition-colors flex items-center justify-center">
                              Simpan
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </form>
          </div>
        </div>


      </div>

      <!-- 3. TRANSAKSI PANEL -->
      <div id="panel-transaksi" class="hidden space-y-8 admin-panel-div">
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card">
          <h3 class="font-display font-bold text-base text-black mb-6 flex items-center gap-2">
            <i class="fa-solid fa-square-check text-black"></i> VERIFIKASI TRANSAKSI DAN PEMBAYARAN MASUK
          </h3>
          <?php if (empty($pending_payments)): ?>
            <div class="text-center py-12 border border-dashed border-[#EAEAEA] rounded-[18px] bg-[#FAFAFA] font-mono text-xs text-[#999999]">
              Tidak ada antrean verifikasi pembayaran tertunda saat ini.
            </div>
          <?php else: ?>
            <div class="space-y-4">
            <div class="space-y-6">
              <?php 
                $grouped_payments = [];
                foreach ($pending_payments as $pay) {
                    $b_id = !empty($pay['booking_id']) ? 'booking_' . $pay['booking_id'] : 'sourcing_' . ($pay['sourcing_id'] ?? uniqid());
                    $grouped_payments[$b_id][] = $pay;
                }
              ?>
              <?php foreach ($grouped_payments as $b_id => $group): ?>
                <?php 
                  $first = $group[0];
                  $isBooking = (strpos($b_id, 'booking_') === 0);
                ?>
                <div class="bg-white border border-[#EAEAEA] rounded-[22px] p-5 space-y-4 shadow-sm">
                  <!-- Header Group -->
                  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#F0F0F0] pb-4">
                    <div>
                      <?php if ($isBooking): ?>
                        <div class="flex items-center gap-2">
                          <span class="px-2 py-0.5 rounded bg-black text-white font-mono text-[9px] font-bold uppercase tracking-wider">BOOKING: <?php echo $first['booking_code']; ?></span>
                          <span class="text-xs text-neutral-500 font-sans font-semibold"><?php echo $first['client_name']; ?></span>
                        </div>
                        <h4 class="font-display font-extrabold text-sm text-black uppercase mt-1">
                          <i class="fa-solid fa-car text-[10px] mr-1"></i> <?php echo $first['car_brand'] . ' ' . $first['car_model'] . ' (' . $first['car_year'] . ')'; ?>
                        </h4>
                      <?php else: ?>
                        <span class="px-2 py-0.5 rounded bg-neutral-200 text-black font-mono text-[9px] font-bold uppercase tracking-wider">SOURCING</span>
                        <h4 class="font-display font-extrabold text-sm text-black uppercase mt-1">
                          <i class="fa-solid fa-tags text-[10px] mr-1"></i> Pembelian Sourcing Mobil
                        </h4>
                      <?php endif; ?>
                    </div>
                    <?php if ($isBooking): ?>
                      <div class="text-right font-mono text-[10px] text-neutral-500">
                        Harga OTR: <strong class="text-black font-sans">Rp <?php echo $first['car_price']; ?></strong>
                      </div>
                    <?php endif; ?>
                  </div>

                  <!-- Inner Payment Items -->
                  <div class="space-y-3">
                    <?php foreach ($group as $pay): ?>
                      <?php
                        $up = base_url('uploads/');
                        $detailData = json_encode([
                          'payment_code' => $pay['payment_code'],
                          'payment_type' => strtoupper(str_replace('_', ' ', $pay['payment_type'])),
                          'amount'       => number_format($pay['amount'], 0, ',', '.'),
                          'payment_method'=> $pay['payment_method'] ?? 'transfer',
                          'delivery_type'=> $pay['delivery_type'] ?? '',
                          'delivery_address'=> $pay['delivery_address'] ?? '',
                          'bank_name'    => strtoupper($pay['bank_name'] ?? ''),
                          'bank_account' => $pay['bank_account'] ?? '-',
                          'bank_holder'  => $pay['bank_holder'] ?? '-',
                          'evidence'     => !empty($pay['evidence_image']) ? $up . $pay['evidence_image'] : '',
                          'client_name'  => $pay['client_name'] ?? '-',
                          'client_email' => $pay['client_email'] ?? '-',
                          'client_phone' => $pay['client_phone'] ?? '-',
                          'ktp_image'    => !empty($pay['ktp_image']) ? $up . $pay['ktp_image'] : '',
                          'booking_code' => $pay['booking_code'] ?? '-',
                          'car_brand'    => $pay['car_brand'] ?? '-',
                          'car_model'    => $pay['car_model'] ?? '-',
                          'car_year'     => $pay['car_year'] ?? '-',
                          'car_price'    => number_format($pay['car_price'] ?? 0, 0, ',', '.'),
                          'car_plate'    => $pay['car_plate'] ?? '-',
                          'car_image'    => !empty($pay['car_image']) ? $up . $pay['car_image'] : '',
                          'dp_amount'    => number_format($pay['dp_amount'] ?? 0, 0, ',', '.'),
                          'remaining'    => number_format($pay['remaining_payment'] ?? 0, 0, ',', '.'),
                        ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
                      ?>
                      <div class="p-4 bg-[#FAFAFA] rounded-[14px] border border-[#EAEAEA] hover:border-[#DADADA] transition-colors flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 font-mono text-xs">
                        <div class="space-y-1">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-black text-[10.5px]"><?php echo $pay['payment_code']; ?></span>
                            <span class="px-2 py-0.5 rounded-full border border-black/10 text-[8px] text-black font-bold uppercase bg-white"><?php echo strtoupper(str_replace('_', ' ', $pay['payment_type'])); ?></span>
                            <span class="text-[9px] text-[#999]"><?php echo date('d M Y - H:i', strtotime($pay['created_at'])); ?></span>
                          </div>
                          <div class="text-[#666666] text-[11px]">
                            Pengirim: <strong class="text-black font-sans"><?php echo $pay['bank_holder']; ?></strong> (<?php echo strtoupper($pay['bank_name']); ?>) | 
                            Jumlah: <strong class="text-black font-sans font-bold">Rp <?php echo number_format($pay['amount'], 0, ',', '.'); ?></strong>
                          </div>
                        </div>
                        <div class="flex items-center gap-2">
                          <!-- DETAIL BUTTON -->
                          <button
                            onclick='openPaymentDetail(<?php echo $detailData; ?>)'
                            class="px-3.5 py-2 rounded-full border border-[#DADADA] bg-white text-[#333] hover:bg-[#F5F5F5] hover:border-black transition-all font-sans font-bold text-[9px] uppercase tracking-wider inline-flex items-center gap-1"
                          >
                            <i class="fa-solid fa-magnifying-glass"></i> Detail
                          </button>

                          <?php if ($this->session->userdata('role') === 'manager'): ?>
                            <?php if ($isBooking): ?>
                              <a href="<?php echo base_url('admin/approve_payment/' . $pay['id']); ?>" class="px-4 py-2 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-sans font-bold text-[9px] uppercase tracking-wider inline-flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Setujui
                              </a>
                              <button onclick="openRejectModal(<?php echo $pay['id']; ?>)" class="px-4 py-2 rounded-full border border-red-200 text-red-600 hover:bg-red-50 transition-all font-sans font-bold text-[9px] uppercase tracking-wider inline-flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> Tolak
                              </button>
                            <?php else: ?>
                              <a href="<?php echo base_url('admin/approve_sourcing_payment/' . $pay['id']); ?>" class="px-4 py-2 rounded-full bg-neutral-200 text-black hover:bg-neutral-300 transition-all font-sans font-bold text-[9px] uppercase tracking-wider">
                                Setujui Sourcing
                              </a>
                            <?php endif; ?>
                          <?php else: ?>
                            <span class="px-3 py-1.5 rounded-lg bg-neutral-100 text-neutral-400 font-mono text-[9px] font-bold uppercase tracking-wider inline-flex items-center gap-1.5 border border-neutral-200 select-none">
                              <i class="fa-solid fa-lock text-[8px]"></i> Persetujuan Manager
                            </span>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- PROGRESS PENGURUSAN STNK & BPKB DIPINDAHKAN KE SINI -->
        <div id="progress-section" class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card">
          <h3 class="font-display font-bold text-base text-black mb-6 flex items-center gap-2">
            <i class="fa-solid fa-folder-open text-black"></i> PROGRESS PENGURUSAN STNK & BPKB
          </h3>
          <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
              <thead>
                <tr class="border-b border-[#EAEAEA] text-[#666666]">
                  <th class="py-3 uppercase font-semibold">Pelanggan</th>
                  <th class="py-3 uppercase font-semibold">Tipe Mobil</th>
                  <th class="py-3 uppercase font-semibold">Status STNK</th>
                  <th class="py-3 uppercase font-semibold">Status BPKB</th>
                  <th class="py-3 uppercase text-right font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                <?php 
                  $count = 0;
                  foreach ($bookings as $b): 
                    if (in_array($b['status'], array('cancelled', 'completed'))) continue;
                    $count++;
                ?>
                  <tr class="hover:bg-[#FAFAFA] transition-colors">
                    <td class="py-4 font-sans font-semibold text-black text-sm"><?php echo $b['fullname']; ?></td>
                    <td class="py-4 text-[#666666]"><?php echo $b['brand'] . ' ' . $b['model']; ?></td>
                    <td class="py-4">
                      <span class="px-2.5 py-0.5 rounded-full text-[9px] font-semibold border border-black/10 <?php echo ($b['stnk_status'] === 'completed') ? 'bg-black text-white' : 'bg-[#F5F5F5] text-black'; ?>">
                        <?php echo strtoupper($b['stnk_status']); ?>
                      </span>
                    </td>
                    <td class="py-4">
                      <span class="px-2.5 py-0.5 rounded-full text-[9px] font-semibold border border-black/10 <?php echo ($b['bpkb_status'] === 'completed') ? 'bg-black text-white' : 'bg-[#F5F5F5] text-black'; ?>">
                        <?php echo strtoupper($b['bpkb_status']); ?>
                      </span>
                    </td>
                    <td class="py-4 text-right">
                      <form action="<?php echo base_url('admin/update_doc_status'); ?>" method="post" class="inline-flex gap-2">
                        <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                        <select name="doc_type" class="bg-white border border-[#DADADA] text-black rounded-lg px-2 py-1 text-[10px]">
                          <option value="stnk">STNK</option>
                          <option value="bpkb">BPKB</option>
                        </select>
                        <select name="status" class="bg-white border border-[#DADADA] text-black rounded-lg px-2 py-1 text-[10px]">
                          <option value="completed">SELESAI</option>
                          <option value="processing">PROSES</option>
                        </select>
                        <button type="submit" class="px-3 py-1 rounded-full bg-black text-white font-sans font-bold text-[9px] uppercase hover:bg-neutral-800 transition-colors">
                          Update
                        </button>
                      </form>
                      <?php if ($b['bpkb_status'] === 'completed'): ?>
                        <a href="<?php echo base_url('admin/complete_booking/' . $b['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan transaksi ini dan menyerahkan BPKB?')" class="px-3 py-1.5 rounded-full bg-black text-white border border-black font-sans font-bold text-[9px] uppercase hover:bg-neutral-800 transition-all inline-block ml-2 align-middle">
                          <i class="fa-solid fa-handshake mr-1"></i> Serahkan BPKB
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if ($count === 0): ?>
                  <tr>
                    <td colspan="5" class="py-6 text-center text-[#999999]">Tidak ada dokumen aktif yang sedang diproses.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <!-- 4. PELANGGAN PANEL (Unified Customer Buyer & Seller/Sourcing Portal) -->
      <div id="panel-pelanggan" class="hidden space-y-6 admin-panel-div">
        <!-- Sub-navigation Tabs -->
        <div class="flex border-b border-[#EAEAEA] gap-6 text-xs font-mono mb-6">
          <button onclick="switchPelangganTab('buyer')" id="tab-btn-buyer" class="pb-3 border-b-2 border-black text-black font-bold uppercase transition-all flex items-center gap-2">
            <i class="fa-solid fa-shopping-bag"></i> Transaksi Beli (Pembeli)
          </button>
          <button onclick="switchPelangganTab('seller')" id="tab-btn-seller" class="pb-3 border-b-2 border-transparent text-[#999999] font-medium hover:text-black uppercase transition-all flex items-center gap-2">
            <i class="fa-solid fa-tags"></i> Penawaran Sourcing (Penjual)
          </button>
        </div>

        <!-- Buyer Sub-panel -->
        <div id="sub-panel-buyer" class="space-y-6 pelanggan-sub-panel">
          <!-- Header Stats Row -->
          <div class="grid grid-cols-3 gap-4">
            <?php 
              $total_buyers = count($buyers);
              $active_buyers = 0;
              foreach($buyers as $by) { if($by['total_orders'] > 0) $active_buyers++; }
            ?>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
              <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Total Pembeli</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $total_buyers; ?></span>
            </div>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
              <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Sudah Transaksi</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $active_buyers; ?></span>
            </div>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
              <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Belum Transaksi</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $total_buyers - $active_buyers; ?></span>
            </div>
          </div>

          <!-- Buyer List Table -->
          <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
            <h3 class="font-display font-bold text-base text-black mb-6 flex items-center gap-2 relative">
              <i class="fa-solid fa-user-tie text-black"></i> DAFTAR PEMBELI TERVERIFIKASI
            </h3>
            <div class="overflow-x-auto relative">
              <table class="w-full text-left font-mono text-xs">
                <thead>
                  <tr class="border-b border-[#EAEAEA] text-[#666666]">
                    <th class="py-3 uppercase font-semibold">#</th>
                    <th class="py-3 uppercase font-semibold">Nama Pembeli</th>
                    <th class="py-3 uppercase font-semibold">Email / Telp</th>
                    <th class="py-3 uppercase font-semibold">Total Order</th>
                    <th class="py-3 uppercase text-right font-semibold">Total Spend</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                  <?php if (!empty($buyers)): ?>
                    <?php $bi = 1; foreach ($buyers as $by): ?>
                      <tr class="hover:bg-[#FAFAFA] transition-colors">
                        <td class="py-4 text-[#999999]"><?php echo $bi++; ?></td>
                        <td class="py-4">
                          <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#F5F5F5] border border-[#EAEAEA] flex items-center justify-center font-bold text-black text-xs font-display">
                              <?php echo strtoupper(substr($by['fullname'], 0, 1)); ?>
                            </div>
                            <div>
                              <span class="font-bold text-black font-sans block text-[13px] leading-tight"><?php echo $by['fullname']; ?></span>
                            </div>
                          </div>
                        </td>
                        <td class="py-4">
                          <span class="block text-[#333333]"><?php echo $by['email']; ?></span>
                          <span class="block text-[#999999] text-[9px]"><?php echo $by['phone']; ?></span>
                        </td>
                        <td class="py-4">
                          <span class="px-2.5 py-0.5 rounded-full <?php echo ($by['total_orders'] > 0) ? 'bg-black text-white' : 'bg-[#F5F5F5] text-[#999999]'; ?> text-[9px] font-semibold">
                            <?php echo $by['total_orders']; ?> order
                          </span>
                        </td>
                        <td class="py-4 text-right font-sans font-bold text-black">
                          Rp <?php echo number_format($by['total_spent'] ?? 0, 0, ',', '.'); ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <!-- Fallback dummy data -->
                    <?php 
                      $dummyBuyers = [
                        ['fullname'=>'Budi Santoso','email'=>'budi@gmail.com','phone'=>'0812-3456-7890','total_orders'=>3,'total_spent'=>495000000],
                        ['fullname'=>'Siti Aisyah','email'=>'siti@gmail.com','phone'=>'0813-2345-6789','total_orders'=>1,'total_spent'=>120000000],
                        ['fullname'=>'Andi Wijaya','email'=>'andi@gmail.com','phone'=>'0817-8765-4321','total_orders'=>2,'total_spent'=>640000000],
                        ['fullname'=>'Rudi Hermawan','email'=>'rudi@gmail.com','phone'=>'0816-1234-5678','total_orders'=>1,'total_spent'=>415000000],
                      ];
                      $bi = 1;
                      foreach($dummyBuyers as $by):
                    ?>
                      <tr class="hover:bg-[#FAFAFA] transition-colors">
                        <td class="py-4 text-[#999999]"><?php echo $bi++; ?></td>
                        <td class="py-4">
                          <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#F5F5F5] border border-[#EAEAEA] flex items-center justify-center font-bold text-black text-xs font-display">
                              <?php echo strtoupper(substr($by['fullname'], 0, 1)); ?>
                            </div>
                            <div>
                              <span class="font-bold text-black font-sans block text-[13px] leading-tight"><?php echo $by['fullname']; ?></span>
                            </div>
                          </div>
                        </td>
                        <td class="py-4">
                          <span class="block text-[#333333]"><?php echo $by['email']; ?></span>
                          <span class="block text-[#999999] text-[9px]"><?php echo $by['phone']; ?></span>
                        </td>
                        <td class="py-4">
                          <span class="px-2.5 py-0.5 rounded-full bg-black text-white text-[9px] font-semibold">
                            <?php echo $by['total_orders']; ?> order
                          </span>
                        </td>
                        <td class="py-4 text-right font-sans font-bold text-black">
                          Rp <?php echo number_format($by['total_spent'], 0, ',', '.'); ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Seller Sub-panel -->
        <div id="sub-panel-seller" class="hidden space-y-6 pelanggan-sub-panel">
          <!-- Header Stats -->
          <div class="grid grid-cols-3 gap-4">
            <?php 
              $total_sourcing = count($sourcing);
              $pending_src = 0; $inspected_src = 0; $rejected_src = 0;
              foreach($sourcing as $s) {
                if($s['status'] === 'pending') $pending_src++;
                if($s['status'] === 'inspected') $inspected_src++;
                if($s['status'] === 'rejected') $rejected_src++;
              }
            ?>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card">
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Total Pengajuan</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $total_sourcing; ?></span>
            </div>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card">
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Menunggu Inspeksi</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $pending_src; ?></span>
            </div>
            <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card">
              <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Terverifikasi</span>
              <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $inspected_src; ?></span>
            </div>
          </div>

          <!-- Sourcing Submissions Table -->
          <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
            <div class="flex justify-between items-center mb-6 relative z-10">
              <h3 class="font-display font-bold text-base text-black flex items-center gap-2">
                <i class="fa-solid fa-tags text-black"></i> PENGAJUAN SOURCING & INSPEKSI MOBIL
              </h3>
              <button onclick="document.getElementById('modal-walkin').style.display='flex'" class="px-4 py-2.5 h-9 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-mono text-[10px] font-bold uppercase flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Penjualan (Walk-in)
              </button>
            </div>
            <div class="overflow-x-auto relative">
              <table class="w-full text-left font-mono text-xs">
                <thead>
                  <tr class="border-b border-[#EAEAEA] text-[#666666]">
                    <th class="py-3 uppercase font-semibold">Pemilik</th>
                    <th class="py-3 uppercase font-semibold">Unit</th>
                    <th class="py-3 uppercase font-semibold">Tahun / KM</th>
                    <th class="py-3 uppercase font-semibold">Status</th>
                    <th class="py-3 uppercase font-semibold">Harga Ditawar</th>
                    <th class="py-3 uppercase text-right font-semibold">Aksi Inspeksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                  <?php if (!empty($sourcing)): ?>
                    <?php foreach ($sourcing as $s): ?>
                      <tr class="hover:bg-[#FAFAFA] transition-colors">
                        <td class="py-4">
                          <span class="font-bold text-black font-sans block"><?php echo $s['owner_name']; ?></span>
                          <span class="text-[9px] text-[#999999]"><?php echo $s['owner_phone']; ?></span>
                        </td>
                        <td class="py-4">
                          <span class="font-bold text-black"><?php echo $s['car_brand'] . ' ' . $s['car_model']; ?></span>
                        </td>
                        <td class="py-4">
                          <span class="block"><?php echo $s['car_year']; ?></span>
                          <span class="text-[#999999] text-[9px]"><?php echo number_format($s['mileage'], 0, ',', '.'); ?> KM</span>
                        </td>
                        <td class="py-4">
                          <?php
                            $statusMap = ['pending'=>'bg-[#F5F5F5] text-black','inspected'=>'bg-black text-white','rejected'=>'bg-red-50 text-red-600'];
                            $statusClass = $statusMap[$s['status']] ?? 'bg-[#F5F5F5] text-black';
                          ?>
                          <span class="px-2.5 py-0.5 rounded-full <?php echo $statusClass; ?> text-[9px] font-semibold border border-black/10">
                            <?php echo strtoupper($s['status']); ?>
                          </span>
                        </td>
                        <td class="py-4 font-sans font-bold text-black">
                          <?php echo $s['price_offered'] ? 'Rp ' . number_format($s['price_offered'], 0, ',', '.') : '<span class="text-[#999999] font-normal">Belum dinilai</span>'; ?>
                        </td>
                        <td class="py-4 text-right">
                           <?php if ($this->session->userdata('role') === 'manager'): ?>
                             <?php if ($s['status'] === 'pending'): ?>
                               <form action="<?php echo base_url('admin/evaluate_sourcing'); ?>" method="post" class="inline-flex gap-2">
                                 <input type="hidden" name="sourcing_id" value="<?php echo $s['id']; ?>">
                                 <input type="text" name="price_offered" placeholder="Nilai (Rp)" class="bg-[#F5F5F5] border border-[#EAEAEA] rounded-lg px-2 py-1 text-[10px] w-24 text-black">
                                 <input type="text" name="inspection_notes" placeholder="Catatan..." class="bg-[#F5F5F5] border border-[#EAEAEA] rounded-lg px-2 py-1 text-[10px] w-24 text-black">
                                 <select name="status" class="bg-white border border-[#DADADA] rounded-lg px-2 py-1 text-[10px] text-black">
                                   <option value="inspected">SETUJUI</option>
                                   <option value="rejected">TOLAK</option>
                                 </select>
                                 <button type="submit" class="px-3 py-1 rounded-full bg-black text-white font-sans font-bold text-[9px] uppercase">Proses</button>
                               </form>
                             <?php elseif ($s['status'] === 'inspected' && empty($s['payout_date'])): ?>
                               <form action="<?php echo base_url('admin/pay_seller/' . $s['id']); ?>" method="post" class="inline-flex gap-2">
                                 <select name="payment_method" class="bg-white border border-[#DADADA] rounded-lg px-2 py-1 text-[10px] text-black">
                                   <option value="cash">CASH</option>
                                   <option value="transfer">TRANSFER</option>
                                 </select>
                                 <button type="submit" class="px-3 py-1.5 rounded-full bg-black text-white font-sans font-bold text-[9px] uppercase">Bayar Penjual</button>
                               </form>
                             <?php else: ?>
                               <span class="text-[9px] text-[#999999] font-mono">SELESAI</span>
                             <?php endif; ?>
                           <?php else: ?>
                             <?php if ($s['status'] === 'pending' || ($s['status'] === 'inspected' && empty($s['payout_date']))): ?>
                               <span class="px-2.5 py-1 rounded-xl bg-neutral-100 text-neutral-400 font-mono text-[8px] font-bold uppercase tracking-wider inline-flex items-center gap-1 border border-neutral-200 select-none">
                                 <i class="fa-solid fa-lock text-[7px]"></i> Persetujuan Manager
                                </span>
                             <?php else: ?>
                               <span class="text-[9px] text-[#999999] font-mono">SELESAI</span>
                             <?php endif; ?>
                           <?php endif; ?>
                         </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="py-12 text-center text-[#999999]">Belum ada pengajuan sourcing masuk.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>      <div id="panel-laporan_penjualan" class="hidden space-y-6 admin-panel-div">
        <!-- Penjualan Pie Chart -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card flex gap-6">
          <div class="flex-grow">
            <h3 class="font-display font-bold text-base text-black flex items-center gap-2 mb-2">
              <i class="fa-solid fa-chart-pie"></i> GRAFIK PENJUALAN
            </h3>
            <p class="text-[10px] text-[#999999] font-mono mb-4">Proporsi Status Penjualan</p>
            <div class="flex items-center gap-10 h-40">
              <?php
                $status_counts = ['completed' => 0, 'pending' => 0, 'processing' => 0, 'cancelled' => 0];
                foreach ($bookings as $b) {
                  if (isset($status_counts[$b['status']])) $status_counts[$b['status']]++;
                }
                $total_b = max(1, count($bookings));
              ?>
              <div class="w-32 h-32 rounded-full relative shadow-[0_8px_32px_rgba(0,0,0,0.15)] overflow-hidden" style="background: conic-gradient(black <?php echo ($status_counts['completed']/$total_b)*100; ?>%, #EAEAEA 0);">
                <!-- Inner circle to make it a donut chart -->
                <div class="absolute inset-[10px] bg-white rounded-full flex flex-col items-center justify-center shadow-inner">
                   <span class="text-xl font-bold font-sans text-black leading-none"><?php echo $total_b; ?></span>
                   <span class="text-[8px] font-mono text-[#999999] tracking-wider mt-1">TOTAL DATA</span>
                </div>
              </div>
              <div class="space-y-3 text-xs font-mono">
                <div class="flex items-center justify-between w-40 border-b border-[#EAEAEA] pb-2">
                  <div class="flex items-center gap-2"><div class="w-3 h-3 bg-black rounded-sm"></div> <span class="font-bold">Selesai</span></div>
                  <span class="text-[#666666]"><?php echo $status_counts['completed']; ?></span>
                </div>
                <div class="flex items-center justify-between w-40 border-b border-[#EAEAEA] pb-2">
                  <div class="flex items-center gap-2"><div class="w-3 h-3 bg-[#EAEAEA] rounded-sm"></div> <span class="font-bold text-[#999999]">Lainnya</span></div>
                  <span class="text-[#666666]"><?php echo $total_b - $status_counts['completed']; ?></span>
                </div>
              </div>
            </div>
            <a href="<?php echo base_url('admin/cetak_laporan?type=penjualan'); ?>" target="_blank" class="mt-6 px-4 py-2 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-mono text-[10px] font-bold uppercase inline-flex items-center gap-1.5">
              <i class="fa-solid fa-file-pdf"></i> Cetak Laporan Penjualan (PDF)
            </a>
          </div>
        </div>

        <!-- Financial Summary Cards -->
        <?php 
          $total_revenue = 0;
          $total_dp = 0;
          $total_pelunasan = 0;
          $total_booking_fee = 0;
          foreach ($bookings as $b) {
              if ($b['booking_fee_status'] === 'paid') { $total_revenue += 500000; $total_booking_fee += 500000; }
              if ($b['dp_status'] === 'paid') {
                  $total_revenue += $b['dp_amount'];
                  $total_dp += $b['dp_amount'];
              }
              if ($b['pelunasan_status'] === 'paid') {
                  $total_revenue += $b['remaining_payment'];
                  $total_pelunasan += $b['remaining_payment'];
              }
          }
        ?>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
            <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Total Revenue</span>
            <span class="text-black font-display font-extrabold text-xl mt-1 block">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></span>
            <div class="mt-3 h-1 w-full bg-[#F5F5F5] rounded-full overflow-hidden">
              <div class="h-full bg-black rounded-full" style="width: 100%"></div>
            </div>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
            <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Booking Fee</span>
            <span class="text-black font-display font-extrabold text-xl mt-1 block">Rp <?php echo number_format($total_booking_fee, 0, ',', '.'); ?></span>
            <div class="mt-3 h-1 w-full bg-[#F5F5F5] rounded-full overflow-hidden">
              <div class="h-full bg-black rounded-full" style="width: <?php echo $total_revenue > 0 ? min(100, round($total_booking_fee / $total_revenue * 100)) : 0; ?>%"></div>
            </div>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
            <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">DP Terkumpul</span>
            <span class="text-black font-display font-extrabold text-xl mt-1 block">Rp <?php echo number_format($total_dp, 0, ',', '.'); ?></span>
            <div class="mt-3 h-1 w-full bg-[#F5F5F5] rounded-full overflow-hidden">
              <div class="h-full bg-black rounded-full" style="width: <?php echo $total_revenue > 0 ? min(100, round($total_dp / $total_revenue * 100)) : 0; ?>%"></div>
            </div>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 framer-card relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px;"></div>
            <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider">Pelunasan</span>
            <span class="text-black font-display font-extrabold text-xl mt-1 block">Rp <?php echo number_format($total_pelunasan, 0, ',', '.'); ?></span>
            <div class="mt-3 h-1 w-full bg-[#F5F5F5] rounded-full overflow-hidden">
              <div class="h-full bg-black rounded-full" style="width: <?php echo $total_revenue > 0 ? min(100, round($total_pelunasan / $total_revenue * 100)) : 0; ?>%"></div>
            </div>
          </div>
        </div>

        <?php
          // Dynamic Revenue Graph Calculator
          $monthly_revenue = array_fill(1, 12, 0); // Months 1 to 12
          
          // Get all verified payments from database
          $this->db->select('*');
          $this->db->from('payments');
          $this->db->where('status', 'verified');
          $verified_payments = $this->db->get()->result_array();

          foreach ($verified_payments as $pay) {
              $p_year = date('Y', strtotime($pay['created_at']));
              if ($p_year == $current_year) {
                  $p_month = (int)date('n', strtotime($pay['created_at']));
                  $monthly_revenue[$p_month] += floatval($pay['amount']);
              }
          }

          $max_revenue = max($monthly_revenue);
          $scale_rev_max = ($max_revenue > 0) ? $max_revenue : 10000000; // Default range 10M

          // Generate coordinates for Revenue (width 420, height 160, baseline 140, ceiling 20)
          $rev_points = array();
          for ($m = 1; $m <= 12; $m++) {
              $x = (($m - 1) / 11) * 420;
              $ratio = $monthly_revenue[$m] / $scale_rev_max;
              $y = 140 - ($ratio * 110); // baseline is 140, peak height is 110px
              $rev_points[] = array('x' => $x, 'y' => $y, 'val' => $monthly_revenue[$m]);
          }

          // Generate SVG path strings
          $rev_path = "";
          $rev_area = "";
          if ($max_revenue == 0) {
              $rev_path = "M 0,140 L 420,140";
              $rev_area = "M 0,140 L 420,140 L 420,150 L 0,150 Z";
          } else {
              $rev_path = "M " . $rev_points[0]['x'] . "," . $rev_points[0]['y'];
              for ($i = 1; $i < count($rev_points); $i++) {
                  $rev_path .= " L " . $rev_points[$i]['x'] . "," . $rev_points[$i]['y'];
              }
              $rev_area = $rev_path . " L 420,150 L 0,150 Z";
          }

          // Generate coordinates for Transaction count (dashed line)
          $tx_points = array();
          for ($m = 1; $m <= 12; $m++) {
              $x = (($m - 1) / 11) * 420;
              $ratio = $monthly_sales[$m] / $scale_max;
              $y = 140 - ($ratio * 110);
              $tx_points[] = array('x' => $x, 'y' => $y, 'val' => $monthly_sales[$m]);
          }

          $tx_path = "M " . $tx_points[0]['x'] . "," . $tx_points[0]['y'];
          for ($i = 1; $i < count($tx_points); $i++) {
              $tx_path .= " L " . $tx_points[$i]['x'] . "," . $tx_points[$i]['y'];
          }
        ?>

        <!-- Matrix Revenue Chart -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
          <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 relative">
            <div>
              <h4 class="font-display font-bold text-sm text-black">Grafik Revenue Bulanan</h4>
              <div class="flex items-center gap-2 mt-0.5">
                <span id="chart-live-indicator" class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <p id="chart-subtitle" class="text-[9px] font-mono text-neutral-400 uppercase tracking-wider">GRAFIK KEUANGAN LIVE — TAHUN <?php echo $current_year; ?></p>
              </div>
            </div>
            
            <!-- Interactive Segmented Toggle Controls -->
            <div class="flex bg-neutral-100 p-0.5 rounded-xl border border-neutral-200/50 font-mono text-[9px] font-bold select-none self-end sm:self-auto">
              <button onclick="toggleChartMode('all')" id="btn-chart-all" class="px-3 py-1.5 rounded-lg bg-white text-black shadow-sm transition-all duration-200">SEMUA</button>
              <button onclick="toggleChartMode('rev')" id="btn-chart-rev" class="px-3 py-1.5 rounded-lg text-neutral-500 hover:text-black transition-all duration-200">REVENUE</button>
              <button onclick="toggleChartMode('tx')" id="btn-chart-tx" class="px-3 py-1.5 rounded-lg text-neutral-500 hover:text-black transition-all duration-200">TRANSAKSI</button>
            </div>
          </div>
          
          <!-- Multi-Line Matrix Chart SVG -->
          <div class="flex gap-4 items-stretch h-52 relative">
            <!-- Y-axis labels -->
            <div class="flex flex-col justify-between text-[8px] font-mono text-[#999999] text-right w-8 select-none pb-4">
              <span><?php echo ($scale_rev_max >= 1000000000) ? round($scale_rev_max / 1000000000, 1) . 'B' : (($scale_rev_max >= 1000000) ? round($scale_rev_max / 1000000, 1) . 'M' : number_format($scale_rev_max, 0, ',', '.')); ?></span>
              <span><?php echo ($scale_rev_max >= 1000000000) ? round(($scale_rev_max*0.75) / 1000000000, 1) . 'B' : (($scale_rev_max >= 1000000) ? round(($scale_rev_max*0.75) / 1000000, 1) . 'M' : number_format($scale_rev_max*0.75, 0, ',', '.')); ?></span>
              <span><?php echo ($scale_rev_max >= 1000000000) ? round(($scale_rev_max*0.50) / 1000000000, 1) . 'B' : (($scale_rev_max >= 1000000) ? round(($scale_rev_max*0.50) / 1000000, 1) . 'M' : number_format($scale_rev_max*0.50, 0, ',', '.')); ?></span>
              <span><?php echo ($scale_rev_max >= 1000000000) ? round(($scale_rev_max*0.25) / 1000000000, 1) . 'B' : (($scale_rev_max >= 1000000) ? round(($scale_rev_max*0.25) / 1000000, 1) . 'M' : number_format($scale_rev_max*0.25, 0, ',', '.')); ?></span>
              <span>0</span>
            </div>
            <!-- Chart body -->
            <div class="flex-grow relative" id="revenue-chart-container">

              <!-- Tooltip Card -->
              <div id="revenue-chart-tooltip" style="display:none; position:absolute; z-index:40; pointer-events:none; background:#000; color:#fff; border-radius:10px; padding:8px 12px; font-family:'IBM Plex Mono',monospace; font-size:9px; font-weight:700; white-space:nowrap; transform:translate(-50%, -100%); margin-top:-10px; box-shadow:0 8px 24px rgba(0,0,0,0.18); transition: left 0.1s cubic-bezier(0.25, 1, 0.5, 1), top 0.1s cubic-bezier(0.25, 1, 0.5, 1);">
                <div id="rev-tooltip-month" style="color:#888; font-size:7px; text-transform:uppercase; margin-bottom:2px;">Mei</div>
                <div id="rev-tooltip-val">Rp 0</div>
                <div id="rev-tooltip-tx" style="font-size:7px; font-weight:normal; margin-top:2px;">0 Transaksi</div>
                <div style="position:absolute; bottom:-4px; left:50%; transform:translateX(-50%); width:0; height:0; border-left:4px solid transparent; border-right:4px solid transparent; border-top:4px solid #000;"></div>
              </div>

              <svg class="absolute inset-0 w-full h-full" viewBox="0 0 420 160" preserveAspectRatio="none" style="overflow:visible;">
                <defs>
                  <pattern id="lap-dot-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="0.6" fill="#EAEAEA"/>
                  </pattern>
                  <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#000000" stop-opacity="0.08"/>
                    <stop offset="100%" stop-color="#000000" stop-opacity="0"/>
                  </linearGradient>
                </defs>

                <!-- Dot grid background -->
                <rect width="100%" height="140" fill="url(#lap-dot-grid)"/>

                <!-- Horizontal guide lines -->
                <line x1="0" y1="35" x2="420" y2="35" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="3 4"/>
                <line x1="0" y1="70" x2="420" y2="70" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="3 4"/>
                <line x1="0" y1="105" x2="420" y2="105" stroke="#EAEAEA" stroke-width="0.8" stroke-dasharray="3 4"/>

                <!-- Vertical month separator lines -->
                <line x1="0" y1="0" x2="0" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="38" y1="0" x2="38" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="76" y1="0" x2="76" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="114" y1="0" x2="114" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="152" y1="0" x2="152" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="190" y1="0" x2="190" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="229" y1="0" x2="229" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="267" y1="0" x2="267" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="305" y1="0" x2="305" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="343" y1="0" x2="343" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="381" y1="0" x2="381" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>
                <line x1="420" y1="0" x2="420" y2="140" stroke="#F5F5F5" stroke-width="0.8"/>

                <!-- Live crosshairs tracker -->
                <line id="rev-crosshair-x" x1="0" y1="0" x2="0" y2="140" stroke="#000" stroke-width="0.8" stroke-dasharray="2 3" opacity="0" style="transition: all 0.1s ease;"/>
                <line id="rev-crosshair-y" x1="0" y1="0" x2="420" y2="0" stroke="#000" stroke-width="0.8" stroke-dasharray="2 3" opacity="0" style="transition: all 0.1s ease;"/>

                <!-- Revenue Area Fill -->
                <path id="chart-rev-area" d="<?php echo $rev_area; ?>" fill="url(#areaGrad)" style="transition: opacity 0.3s ease;"/>

                <!-- Revenue Line (main — solid black) -->
                <path id="chart-rev-path" d="<?php echo $rev_path; ?>" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: opacity 0.3s ease;"/>

                <!-- Transaksi Line (dashed gray) -->
                <path id="chart-tx-path" d="<?php echo $tx_path; ?>" fill="none" stroke="#CCCCCC" stroke-width="1.8" stroke-dasharray="5 4" stroke-linecap="round" style="transition: opacity 0.3s ease;"/>

                <!-- Dynamic hover tracker dot -->
                <circle id="rev-tracker-dot" cx="0" cy="0" r="6" fill="#000" stroke="#fff" stroke-width="2.5" opacity="0" style="transition: all 0.1s cubic-bezier(0.25, 1, 0.5, 1);"/>
              </svg>

              <!-- Absolute Invisible Hover Detectors (12 slices) -->
              <div class="absolute inset-0 flex">
                <?php
                  $month_names_json = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                  for($m=1;$m<=12;$m++):
                    $tx_count = $monthly_sales[$m] ?? 0;
                    $rev_val = $monthly_revenue[$m] ?? 0;
                    $px = (($m - 1) / 11) * 100; // percent X
                    $py = $rev_points[$m-1]['y'];
                    $tx_py = $tx_points[$m-1]['y'];
                ?>
                  <div class="h-full flex-grow cursor-pointer"
                       onmouseenter="showRevenuePoint('<?php echo $month_names_json[$m-1]; ?>', <?php echo $rev_val; ?>, <?php echo $tx_count; ?>, <?php echo $px; ?>, <?php echo $py; ?>, <?php echo $tx_py; ?>, <?php echo $m; ?>)"
                       onmouseleave="hideRevenuePoint()"></div>
                <?php endfor; ?>
              </div>

            </div>
          </div>
          <!-- X-axis month labels -->
          <div id="chart-x-axis" class="flex justify-between items-center text-[8px] font-mono text-[#999999] pt-2 mt-2 border-t border-[#EAEAEA] pl-12 select-none">
            <span class="transition-colors duration-200">JAN</span>
            <span class="transition-colors duration-200">FEB</span>
            <span class="transition-colors duration-200">MAR</span>
            <span class="transition-colors duration-200">APR</span>
            <span class="transition-colors duration-200">MEI</span>
            <span class="transition-colors duration-200">JUN</span>
            <span class="transition-colors duration-200">JUL</span>
            <span class="transition-colors duration-200">AGS</span>
            <span class="transition-colors duration-200">SEP</span>
            <span class="transition-colors duration-200">OKT</span>
            <span class="transition-colors duration-200">NOP</span>
            <span class="transition-colors duration-200">DES</span>
          </div>
        </div>

        <!-- Javascript interaction handler for revenue chart -->
        <script>
          let activeChartMode = 'all';

          function toggleChartMode(mode) {
            activeChartMode = mode;
            const revArea = document.getElementById('chart-rev-area');
            const revPath = document.getElementById('chart-rev-path');
            const txPath = document.getElementById('chart-tx-path');
            
            // Update button styles
            const btnAll = document.getElementById('btn-chart-all');
            const btnRev = document.getElementById('btn-chart-rev');
            const btnTx = document.getElementById('btn-chart-tx');

            [btnAll, btnRev, btnTx].forEach(btn => {
              btn.classList.remove('bg-white', 'text-black', 'shadow-sm');
              btn.classList.add('text-neutral-500');
            });

            if (mode === 'all') {
              btnAll.classList.add('bg-white', 'text-black', 'shadow-sm');
              btnAll.classList.remove('text-neutral-500');
              if (revArea) revArea.style.opacity = '1';
              if (revPath) revPath.style.opacity = '1';
              if (txPath) txPath.style.opacity = '1';
            } else if (mode === 'rev') {
              btnRev.classList.add('bg-white', 'text-black', 'shadow-sm');
              btnRev.classList.remove('text-neutral-500');
              if (revArea) revArea.style.opacity = '1';
              if (revPath) revPath.style.opacity = '1';
              if (txPath) txPath.style.opacity = '0.08';
            } else if (mode === 'tx') {
              btnTx.classList.add('bg-white', 'text-black', 'shadow-sm');
              btnTx.classList.remove('text-neutral-500');
              if (revArea) revArea.style.opacity = '0';
              if (revPath) revPath.style.opacity = '0';
              if (txPath) txPath.style.opacity = '1';
            }
            hideRevenuePoint();
          }

          function showRevenuePoint(month, value, txCount, pctX, yVal, txYVal, monthIdx) {
            const container = document.getElementById('revenue-chart-container');
            const tooltip = document.getElementById('revenue-chart-tooltip');
            const crosshairX = document.getElementById('rev-crosshair-x');
            const crosshairY = document.getElementById('rev-crosshair-y');
            const trackerDot = document.getElementById('rev-tracker-dot');
            const subtitle = document.getElementById('chart-subtitle');

            const width = container.clientWidth;
            const leftOffset = (pctX / 100) * width;
            const targetY = (activeChartMode === 'tx') ? txYVal : yVal;

            // Fill tooltip text
            document.getElementById('rev-tooltip-month').textContent = month;
            document.getElementById('rev-tooltip-val').textContent = 'Rp ' + Number(value).toLocaleString('id-ID');
            document.getElementById('rev-tooltip-tx').textContent = txCount + ' Transaksi';

            // Position tooltip
            tooltip.style.left = leftOffset + 'px';
            tooltip.style.top = targetY + 'px';
            tooltip.style.display = 'block';

            // Update SVG elements
            const svgX = (pctX / 100) * 420;
            crosshairX.setAttribute('x1', svgX);
            crosshairX.setAttribute('x2', svgX);
            crosshairX.setAttribute('opacity', '1');

            crosshairY.setAttribute('y1', targetY);
            crosshairY.setAttribute('y2', targetY);
            crosshairY.setAttribute('opacity', '1');

            trackerDot.setAttribute('cx', svgX);
            trackerDot.setAttribute('cy', targetY);
            trackerDot.setAttribute('opacity', '1');

            // Set tracker color based on mode
            if (activeChartMode === 'tx') {
              trackerDot.setAttribute('fill', '#CCCCCC');
            } else {
              trackerDot.setAttribute('fill', '#000000');
            }

            // Update live metrics indicator in chart header
            subtitle.textContent = `${month.toUpperCase()}: Rp ${Number(value).toLocaleString('id-ID')} (${txCount} TX)`;
            subtitle.classList.remove('text-neutral-400');
            subtitle.classList.add('text-black', 'font-bold');

            // Highlight X Axis label
            const axisLabels = document.querySelectorAll('#chart-x-axis span');
            axisLabels.forEach((label, idx) => {
              if (idx === (monthIdx - 1)) {
                label.classList.remove('text-[#999999]');
                label.classList.add('text-black', 'font-bold', 'scale-110');
              } else {
                label.classList.remove('text-black', 'font-bold', 'scale-110');
                label.classList.add('text-[#999999]');
              }
            });
          }

          function hideRevenuePoint() {
            document.getElementById('revenue-chart-tooltip').style.display = 'none';
            document.getElementById('rev-crosshair-x').setAttribute('opacity', '0');
            document.getElementById('rev-crosshair-y').setAttribute('opacity', '0');
            document.getElementById('rev-tracker-dot').setAttribute('opacity', '0');

            const subtitle = document.getElementById('chart-subtitle');
            subtitle.textContent = 'GRAFIK KEUANGAN LIVE — TAHUN <?php echo $current_year; ?>';
            subtitle.classList.remove('text-black', 'font-bold');
            subtitle.classList.add('text-neutral-400');

            const axisLabels = document.querySelectorAll('#chart-x-axis span');
            axisLabels.forEach(label => {
              label.classList.remove('text-black', 'font-bold', 'scale-110');
              label.classList.add('text-[#999999]');
            });
          }
        </script>

        <!-- Transaction Ledger Table -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
          <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
          <div class="flex justify-between items-center mb-6 relative">
            <h3 class="font-display font-bold text-base text-black uppercase flex items-center gap-2">
              <i class="fa-solid fa-file-invoice-dollar text-black"></i> Ledger Transaksi
            </h3>
            
            <!-- OPTIMIZED REPORT PRINT FILTER FORM (Nothing OS Style) -->
            <form action="<?php echo base_url('admin/cetak_laporan'); ?>" method="get" target="_blank" class="inline-flex items-center gap-2 m-0">
              <select name="type" required class="bg-white border border-[#DADADA] text-black rounded-xl px-3 py-2 font-mono text-[10px] h-9 outline-none focus:border-black transition-all">
                <option value="semua">Semua Laporan (Keduanya)</option>
                <option value="penjualan">Laporan Penjualan Unit</option>
                <option value="pembelian">Laporan Pembelian (Sourcing)</option>
              </select>
              <button type="submit" class="px-4 py-2.5 h-9 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-mono text-[10px] font-bold uppercase flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Cetak Laporan PDF
              </button>
            </form>
          </div>
          <div class="overflow-x-auto relative">
            <table class="w-full text-left font-mono text-xs">
              <thead>
                <tr class="border-b border-[#EAEAEA] text-[#666666]">
                  <th class="py-3 uppercase font-semibold">Order</th>
                  <th class="py-3 uppercase font-semibold">Harga OTR</th>
                  <th class="py-3 uppercase font-semibold">DP (30%)</th>
                  <th class="py-3 uppercase font-semibold">Lunas (70%)</th>
                  <th class="py-3 uppercase font-semibold">Status</th>
                  <th class="py-3 uppercase text-right font-semibold">Total Masuk</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                <?php if (!empty($bookings)): ?>
                  <?php foreach ($bookings as $b): ?>
                    <tr class="hover:bg-[#FAFAFA] transition-colors">
                      <td class="py-4">
                        <span class="font-bold text-black font-sans block"><?php echo $b['fullname']; ?></span>
                        <span class="text-[9px] text-[#999999] block"><?php echo $b['booking_code']; ?> — <?php echo $b['brand'] . ' ' . $b['model']; ?></span>
                      </td>
                      <td class="py-4">Rp <?php echo number_format($b['car_price'], 0, ',', '.'); ?></td>
                      <td class="py-4">
                        <span class="<?php echo ($b['dp_status'] === 'paid') ? 'text-black font-bold' : 'text-[#999999]'; ?>">
                          Rp <?php echo number_format($b['dp_amount'], 0, ',', '.'); ?>
                        </span>
                      </td>
                      <td class="py-4">
                        <span class="<?php echo ($b['pelunasan_status'] === 'paid') ? 'text-black font-bold' : 'text-[#999999]'; ?>">
                          Rp <?php echo number_format($b['remaining_payment'], 0, ',', '.'); ?>
                        </span>
                      </td>
                      <td class="py-4">
                        <?php 
                          $st = $b['status'];
                          $stc = ['pending'=>'bg-[#F5F5F5] text-black','processing'=>'bg-[#F5F5F5] text-black','completed'=>'bg-black text-white','cancelled'=>'bg-red-50 text-red-600'];
                          $stClass = $stc[$st] ?? 'bg-[#F5F5F5] text-black';
                        ?>
                        <span class="px-2.5 py-0.5 rounded-full <?php echo $stClass; ?> text-[9px] font-semibold border border-black/10">
                          <?php echo strtoupper($st); ?>
                        </span>
                      </td>
                      <td class="py-4 text-right font-sans font-bold text-black">
                        <?php 
                          $in = 0;
                          if ($b['booking_fee_status'] === 'paid') $in += 500000;
                          if ($b['dp_status'] === 'paid') $in += $b['dp_amount'];
                          if ($b['pelunasan_status'] === 'paid') $in += $b['remaining_payment'];
                          echo 'Rp ' . number_format($in, 0, ',', '.');
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-12 text-center text-[#999999]">Belum ada data ledger transaksi masuk saat ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- PANEL LAPORAN PEMBELIAN -->
      <div id="panel-laporan_pembelian" class="hidden space-y-6 admin-panel-div">
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card">
          <h3 class="font-display font-bold text-base text-black flex items-center gap-2 mb-2">
            <i class="fa-solid fa-chart-pie"></i> GRAFIK PEMBELIAN (SOURCING)
          </h3>
          <p class="text-[10px] text-[#999999] font-mono mb-4">Proporsi Status Sourcing Mobil</p>
          <div class="flex items-center gap-10 h-40">
            <?php
              $src_counts = ['purchased' => 0, 'rejected' => 0, 'pending' => 0, 'inspected' => 0];
              foreach ($sourcing as $s) {
                if (isset($src_counts[$s['status']])) $src_counts[$s['status']]++;
              }
              $total_s = max(1, count($sourcing));
            ?>
            <div class="w-32 h-32 rounded-full relative shadow-[0_8px_32px_rgba(0,0,0,0.15)] overflow-hidden" style="background: conic-gradient(black <?php echo ($src_counts['purchased']/$total_s)*100; ?>%, #999999 <?php echo (($src_counts['purchased']+$src_counts['inspected'])/$total_s)*100; ?>%, #EAEAEA 0);">
              <!-- Inner circle to make it a donut chart -->
              <div class="absolute inset-[10px] bg-white rounded-full flex flex-col items-center justify-center shadow-inner">
                 <span class="text-xl font-bold font-sans text-black leading-none"><?php echo $total_s; ?></span>
                 <span class="text-[8px] font-mono text-[#999999] tracking-wider mt-1">TOTAL DATA</span>
              </div>
            </div>
            <div class="space-y-3 text-xs font-mono">
              <div class="flex items-center justify-between w-48 border-b border-[#EAEAEA] pb-2">
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-black rounded-sm"></div> <span class="font-bold">Terbeli</span></div>
                <span class="text-[#666666]"><?php echo $src_counts['purchased']; ?></span>
              </div>
              <div class="flex items-center justify-between w-48 border-b border-[#EAEAEA] pb-2">
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-[#999999] rounded-sm"></div> <span class="font-bold text-[#666666]">Inspeksi</span></div>
                <span class="text-[#666666]"><?php echo $src_counts['inspected']; ?></span>
              </div>
              <div class="flex items-center justify-between w-48 border-b border-[#EAEAEA] pb-2">
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-[#EAEAEA] rounded-sm"></div> <span class="font-bold text-[#999999]">Lainnya</span></div>
                <span class="text-[#666666]"><?php echo ($total_s - $src_counts['purchased'] - $src_counts['inspected']); ?></span>
              </div>
            </div>
          </div>
          <a href="<?php echo base_url('admin/cetak_laporan?type=pembelian'); ?>" target="_blank" class="mt-6 px-4 py-2 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-mono text-[10px] font-bold uppercase inline-flex items-center gap-1.5">
            <i class="fa-solid fa-file-pdf"></i> Cetak Laporan Pembelian (PDF)
          </a>
        </div>
      </div>

      <div id="panel-pengaturan" class="hidden admin-panel-div">
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card space-y-6">
          <div class="pb-4 border-b border-[#EAEAEA]">
            <h3 class="font-display font-bold text-base text-black uppercase">PENGATURAN SYSTEM</h3>
            <p class="text-[10px] font-mono text-[#999999]">Sesuaikan konstanta, batasan finansial, dan parameter transaksi internal DRIVE.X.</p>
          </div>

          <form id="settingsForm" onsubmit="saveSettings(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs font-mono text-[#666666]">
            <div class="flex flex-col gap-2">
              <label class="text-black font-bold uppercase">Nama Showroom / Platform</label>
              <input type="text" value="DRIVE.X Premium Marketplace" required class="cyber-input text-xs w-full">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-black font-bold uppercase">Biaya Booking Fee (IDR)</label>
              <input type="number" value="500000" required class="cyber-input text-xs w-full">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-black font-bold uppercase">Persentase Uang Muka (DP %)</label>
              <select class="cyber-input text-xs w-full">
                <option value="30" selected>30% (Standard)</option>
                <option value="40">40%</option>
                <option value="50">50%</option>
              </select>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-black font-bold uppercase">Maintenance Mode</label>
              <select class="cyber-input text-xs w-full">
                <option value="0" selected>NONAKTIF (System Live)</option>
                <option value="1">AKTIF (Maintenance)</option>
              </select>
            </div>

            <div class="sm:col-span-2 pt-4 flex justify-end">
              <button type="submit" class="px-8 py-3.5 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-display font-bold uppercase text-xs">
                Simpan Konfigurasi
              </button>
            </div>
          </form>

          <!-- Danger Zone: Reset Database -->
          <div class="pt-6 border-t border-[#EAEAEA] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
              <h4 class="text-xs text-red-600 font-bold uppercase"><i class="fa-solid fa-triangle-exclamation"></i> Zona Bahaya: Reset Database</h4>
              <p class="text-[10px] text-neutral-500 font-sans mt-1">Ini akan menghapus seluruh data transaksi, pembayaran, kwitansi, dokumen STNK/BPKB, dan mengembalikan stok mobil ke default (5 unit).</p>
            </div>
            <a href="<?php echo base_url('admin/reset_db'); ?>" onclick="return confirm('WARNING: Apakah Anda yakin ingin mereset seluruh database transaksi? Tindakan ini tidak dapat dibatalkan.')" class="px-6 py-3 rounded-full border border-red-200 text-red-600 hover:bg-red-50 transition-all font-mono text-[10px] font-bold uppercase">
              <i class="fa-solid fa-trash-can mr-1.5"></i> Reset Semua Transaksi
            </a>
          </div>
        </div>
      </div>

      <!-- ================= CAR SOURCING PANEL ================= -->
      <div id="panel-sourcing" class="hidden space-y-6 admin-panel-div">
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
          <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
          <div class="flex justify-between items-center mb-6 relative">
            <h3 class="font-display font-bold text-base text-black flex items-center gap-2">
              <i class="fa-solid fa-tags text-black"></i> KELOLA CAR SOURCING (UNIT MASUK)
            </h3>
            <div class="text-[9px] font-mono text-[#999999] border border-[#EAEAEA] px-3 py-1.5 rounded-full uppercase">
              <?php echo count($sourcing); ?> TOTAL AJUAN
            </div>
          </div>

          <div class="overflow-x-auto relative">
            <table class="w-full text-left font-mono text-xs">
              <thead>
                <tr class="border-b border-[#EAEAEA] text-[#666666]">
                  <th class="py-3 uppercase font-semibold">Pengaju (Pemilik)</th>
                  <th class="py-3 uppercase font-semibold">Spesifikasi Unit</th>
                  <th class="py-3 uppercase font-semibold">Nopol / KM</th>
                  <th class="py-3 uppercase font-semibold">Harga Diminta</th>
                  <th class="py-3 uppercase font-semibold">Status</th>
                  <th class="py-3 uppercase text-right font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                <?php if (!empty($sourcing)): ?>
                  <?php foreach ($sourcing as $s): ?>
                    <tr class="hover:bg-[#FAFAFA] transition-colors">
                      <td class="py-4">
                        <span class="font-bold text-black font-sans block text-[13px] leading-tight"><?php echo esc($s['owner_name']); ?></span>
                        <span class="text-[9px] text-[#999999]"><?php echo esc($s['owner_phone']); ?></span>
                      </td>
                      <td class="py-4">
                        <strong class="text-black uppercase"><?php echo esc($s['car_brand'] . ' ' . $s['car_model']); ?></strong>
                        <span class="text-[9px] text-[#999999] block">Tahun <?php echo $s['car_year']; ?> &bull; Warna <?php echo esc($s['car_color'] ?? 'Default'); ?></span>
                        <span class="text-[9px] font-bold block mt-1 <?php echo ($s['sourcing_method'] === 'antar') ? 'text-blue-600' : 'text-purple-600'; ?>">
                          <i class="fa-solid <?php echo ($s['sourcing_method'] === 'antar') ? 'fa-building' : 'fa-house'; ?> mr-1"></i>
                          <?php echo ($s['sourcing_method'] === 'antar') ? 'Customer Antar ke Showroom' : 'Jemput/Survey ke Rumah'; ?>
                        </span>
                      </td>
                      <td class="py-4">
                        <span class="font-bold text-black"><?php echo esc($s['car_plate']); ?></span>
                        <span class="text-[9px] text-[#999999] block"><?php echo number_format($s['mileage'], 0, ',', '.'); ?> KM</span>
                      </td>
                      <td class="py-4">Rp <?php echo number_format($s['price_desired'], 0, ',', '.'); ?></td>
                      <td class="py-4">
                        <?php
                          $st = $s['status'];
                          $bg = 'bg-[#F5F5F5] text-black';
                          if ($st === 'purchased') $bg = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                          elseif ($st === 'rejected') $bg = 'bg-red-50 text-red-700 border-red-200';
                          elseif ($st === 'revision_required') $bg = 'bg-amber-50 text-amber-800 border-amber-200';
                          elseif ($st === 'inspected') $bg = 'bg-blue-50 text-blue-800 border-blue-200';
                        ?>
                        <span class="px-2.5 py-0.5 rounded-full <?php echo $bg; ?> text-[9px] font-semibold uppercase border">
                          <?php 
                            if ($st === 'pending') echo 'PENDING';
                            elseif ($st === 'revision_required') echo 'REVISI';
                            elseif ($st === 'inspected') {
                              echo $s['customer_approved'] ? 'DISETUJUI (PAYOUT)' : 'INSPEKSI SELESAI';
                            }
                            elseif ($st === 'purchased') echo 'TERBELI';
                            elseif ($st === 'rejected') echo 'DITOLAK';
                            elseif ($st === 'cancelled') echo 'BATAL';
                          ?>
                        </span>
                      </td>
                      <td class="py-4 text-right space-x-1 whitespace-nowrap">
                        <!-- Detail Documents View Button -->
                        <button onclick="viewSourcingDetail(<?php echo htmlspecialchars(json_encode($s)); ?>)" class="px-3 py-1 rounded-xl border border-[#DADADA] text-black hover:border-black font-bold uppercase text-[9px]"><i class="fa-solid fa-eye"></i> Berkas</button>
                        
                        <?php if ($this->session->userdata('role') === 'manager'): ?>
                          <?php if ($st === 'pending' || $st === 'revision_required'): ?>
                            <button onclick="openSourcingRevisionModal(<?php echo $s['id']; ?>)" class="px-3 py-1 rounded-xl border border-amber-300 text-amber-800 hover:bg-amber-50 font-bold uppercase text-[9px]">Revisi</button>
                            <button onclick="openSourcingRejectModal(<?php echo $s['id']; ?>)" class="px-3 py-1 rounded-xl border border-red-300 text-red-700 hover:bg-red-50 font-bold uppercase text-[9px]">Tolak</button>
                            <button onclick="openSourcingInspectionModal(<?php echo $s['id']; ?>, <?php echo $s['price_desired']; ?>)" class="px-3 py-1 rounded-xl bg-black text-white hover:bg-neutral-800 font-bold uppercase text-[9px]">Survey</button>
                          <?php elseif ($st === 'inspected' && $s['customer_approved']): ?>
                            <button onclick="openSourcingPayoutModal(<?php echo $s['id']; ?>, <?php echo $s['price_offered']; ?>)" class="px-3 py-1 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-bold uppercase text-[9px]">Proses Payout</button>
                          <?php endif; ?>
                        <?php else: ?>
                          <?php if ($st === 'pending' || $st === 'revision_required' || ($st === 'inspected' && $s['customer_approved'])): ?>
                            <span class="px-2.5 py-1 rounded-xl bg-neutral-100 text-neutral-400 font-mono text-[8px] font-bold uppercase tracking-wider inline-flex items-center gap-1 border border-neutral-200 select-none">
                              <i class="fa-solid fa-lock text-[7px]"></i> Persetujuan Manager
                            </span>
                          <?php endif; ?>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-12 text-center text-[#999999]">Belum ada data car sourcing masuk saat ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ================= PENGIRIMAN MOBIL PANEL ================= -->
      <div id="panel-pengiriman" class="hidden space-y-6 admin-panel-div">
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
          <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
          <div class="flex justify-between items-center mb-6 relative">
            <h3 class="font-display font-bold text-base text-black flex items-center gap-2">
              <i class="fa-solid fa-truck-fast text-black"></i> MANAJEMEN PENGIRIMAN &amp; KURIR
            </h3>
            <div class="text-[9px] font-mono text-[#999999] border border-[#EAEAEA] px-3 py-1.5 rounded-full uppercase">
              <?php echo count($deliveries); ?> AKTIF
            </div>
          </div>

          <div class="overflow-x-auto relative">
            <table class="w-full text-left font-mono text-xs">
              <thead>
                <tr class="border-b border-[#EAEAEA] text-[#666666] text-[10px]">
                  <th class="py-3 uppercase font-semibold" style="width: 140px; min-width: 140px;">Kode Order</th>
                  <th class="py-3 uppercase font-semibold" style="min-width: 250px;">Pembeli / Alamat</th>
                  <th class="py-3 uppercase font-semibold" style="min-width: 200px;">Kendaraan</th>
                  <th class="py-3 uppercase font-semibold" style="min-width: 150px;">Kurir Ditugaskan</th>
                  <th class="py-3 uppercase font-semibold" style="min-width: 140px;">Status Pengiriman</th>
                  <th class="py-3 uppercase text-right font-semibold" style="width: 200px; min-width: 200px;">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                <?php if (!empty($deliveries)): ?>
                  <?php foreach ($deliveries as $del): ?>
                    <tr class="hover:bg-[#FAFAFA] transition-colors">
                      <td class="py-4" style="vertical-align: middle;">
                        <strong class="text-black font-sans block text-[13px] leading-tight"><?php echo esc($del['booking_code']); ?></strong>
                        <span class="text-[9px] font-bold text-neutral-500 block mt-0.5"><?php echo esc($del['nomor_surat'] ? $del['nomor_surat'] : 'SURAT JALAN BELUM TERBIT'); ?></span>
                      </td>
                      <td class="py-4" style="vertical-align: middle;">
                        <span class="font-sans font-bold text-black text-[13px] block"><?php echo esc($del['client_name']); ?></span>
                        <span class="text-[10px] text-[#666666] block leading-relaxed mt-0.5" style="max-width: 260px; white-space: normal; word-break: break-word;"><?php echo esc($del['alamat_tujuan']); ?></span>
                      </td>
                      <td class="py-4" style="vertical-align: middle;">
                        <strong class="text-black font-sans text-[12px] block uppercase"><?php echo esc($del['brand'] . ' ' . $del['model']); ?></strong>
                        <span class="text-[9px] font-mono text-neutral-500 block mt-0.5"><?php echo esc($del['plate_number']); ?></span>
                      </td>
                      <td class="py-4" style="vertical-align: middle;">
                        <?php if ($del['courier_name']): ?>
                          <span class="text-black font-sans font-bold text-xs flex items-center gap-1.5"><i class="fa-solid fa-user-check text-[10px] text-emerald-600"></i> <?php echo esc($del['courier_name']); ?></span>
                        <?php else: ?>
                          <span class="px-2 py-0.5 rounded border border-red-200 text-red-600 bg-red-50 font-bold uppercase text-[9px] inline-flex items-center gap-1"><i class="fa-solid fa-circle-exclamation text-[8px]"></i>Belum Ditugaskan</span>
                        <?php endif; ?>
                      </td>
                      <td class="py-4" style="vertical-align: middle;">
                        <?php
                          $dst = $del['status_pengiriman'];
                          $dbg = 'bg-[#F5F5F5] text-black border-black/10';
                          if ($dst === 'Selesai') $dbg = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                          elseif ($dst === 'Dalam Perjalanan') $dbg = 'bg-blue-50 text-blue-800 border-blue-200';
                          elseif ($dst === 'Kurir Ditugaskan') $dbg = 'bg-neutral-100 text-neutral-800 border-neutral-300';
                        ?>
                        <span class="px-2.5 py-0.5 rounded-full <?php echo $dbg; ?> text-[9px] font-bold uppercase border whitespace-nowrap">
                          <?php echo esc($dst); ?>
                        </span>
                      </td>
                      <td class="py-4 text-right" style="vertical-align: middle; white-space: nowrap;">
                        <?php if ($dst === 'Menunggu Penugasan'): ?>
                          <!-- Assign Courier Inline Form -->
                          <?php echo form_open('admin/assign_courier_task', ['class' => 'flex items-center gap-2 m-0 justify-end']); ?>
                            <input type="hidden" name="id_pengiriman" value="<?php echo $del['id_pengiriman']; ?>">
                            <select name="id_kurir" required class="bg-white border border-[#DADADA] text-black font-sans px-2.5 py-1.5 rounded-xl text-[10px] outline-none focus:border-black transition-colors" style="width: 120px;">
                              <option value="">Pilih Kurir...</option>
                              <?php foreach ($couriers as $k): ?>
                                <option value="<?php echo $k['id_kurir']; ?>"><?php echo esc($k['nama']); ?></option>
                              <?php endforeach; ?>
                            </select>
                            <button type="submit" class="px-3.5 py-2 rounded-full bg-black text-white hover:bg-neutral-800 font-sans font-bold uppercase text-[9px] tracking-wider transition-all">Tugaskan</button>
                          </form>
                        <?php else: ?>
                          <a href="<?php echo base_url('admin/surat_jalan/' . $del['id_transaksi']); ?>" target="_blank" class="px-3.5 py-2 rounded-full border border-[#DADADA] text-black bg-white hover:border-black font-sans font-bold uppercase text-[9px] tracking-wider inline-flex items-center gap-1"><i class="fa-solid fa-print"></i> Cetak SJ</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-12 text-center text-[#999999]">Belum ada permintaan pengiriman kendaraan masuk saat ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ================= MODALS FOR CAR SOURCING ================= -->
      <!-- 1. DETAIL VIEWER MODAL -->
      <div id="sourcing-detail-overlay" onclick="closeSourcingDetailBackdrop(event)" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
        <div id="sourcing-detail-box" style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:680px; position:relative; margin:16px; max-height:90vh; overflow-y:auto;" font-mono text-xs>
          <div style="display:flex; align-items:center; justify-content:between; border-bottom:1px solid #EAEAEA; padding-bottom:16px; margin-bottom:20px;">
            <h3 id="sourcing-detail-title" style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Detail Car Sourcing</h3>
            <button onclick="closeSourcingDetail()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
          </div>

          <div class="grid grid-cols-2 gap-6 text-xs font-mono text-[#666666] mb-6">
            <div>
              <h4 class="text-black font-bold uppercase mb-2">Profil Penjual</h4>
              <p>Nama: <strong id="sd-owner-name" class="text-black">-</strong></p>
              <p>Telepon: <strong id="sd-owner-phone" class="text-black">-</strong></p>
              <p>Alamat: <strong id="sd-owner-address" class="text-black italic">-</strong></p>
            </div>
            <div>
              <h4 class="text-black font-bold uppercase mb-2">Spesifikasi Mobil</h4>
              <p>Unit: <strong id="sd-car-unit" class="text-black">-</strong></p>
              <p>No Polisi: <strong id="sd-car-plate" class="text-black">-</strong></p>
              <p>KM: <strong id="sd-car-mileage" class="text-black">-</strong></p>
              <p>Harga Penawaran: <strong id="sd-car-price" class="text-black text-sm">-</strong></p>
            </div>
          </div>

          <div class="border-t border-[#EAEAEA] pt-4 mb-6">
            <h4 class="text-black font-bold uppercase font-mono text-xs mb-2">Kondisi Kendaraan</h4>
            <p id="sd-description" class="bg-[#FAFAFA] border border-[#EAEAEA] rounded-xl p-3 text-neutral-700 italic">-</p>
          </div>

          <div class="border-t border-[#EAEAEA] pt-4">
            <h4 class="text-black font-bold uppercase font-mono text-xs mb-3">Foto &amp; Dokumen Terlampir</h4>
            <div class="grid grid-cols-5 gap-3" id="sd-images-grid">
              <div class="border border-[#EAEAEA] rounded-xl overflow-hidden bg-neutral-50 text-center">
                <span class="text-[8px] font-bold block bg-neutral-100 py-1 uppercase text-[#999999]">STNK</span>
                <a id="sd-stnk-link" href="#" target="_blank"><img id="sd-stnk-img" src="" alt="STNK" class="w-full h-16 object-cover"></a>
              </div>
              <div class="border border-[#EAEAEA] rounded-xl overflow-hidden bg-neutral-50 text-center">
                <span class="text-[8px] font-bold block bg-neutral-100 py-1 uppercase text-[#999999]">BPKB</span>
                <a id="sd-bpkb-link" href="#" target="_blank"><img id="sd-bpkb-img" src="" alt="BPKB" class="w-full h-16 object-cover"></a>
              </div>
              <div class="border border-[#EAEAEA] rounded-xl overflow-hidden bg-neutral-50 text-center">
                <span class="text-[8px] font-bold block bg-neutral-100 py-1 uppercase text-[#999999]">Depan</span>
                <a id="sd-front-link" href="#" target="_blank"><img id="sd-front-img" src="" alt="Depan" class="w-full h-16 object-cover"></a>
              </div>
              <div class="border border-[#EAEAEA] rounded-xl overflow-hidden bg-neutral-50 text-center">
                <span class="text-[8px] font-bold block bg-neutral-100 py-1 uppercase text-[#999999]">Belakang</span>
                <a id="sd-back-link" href="#" target="_blank"><img id="sd-back-img" src="" alt="Belakang" class="w-full h-16 object-cover"></a>
              </div>
              <div class="border border-[#EAEAEA] rounded-xl overflow-hidden bg-neutral-50 text-center">
                <span class="text-[8px] font-bold block bg-neutral-100 py-1 uppercase text-[#999999]">Interior</span>
                <a id="sd-interior-link" href="#" target="_blank"><img id="sd-interior-img" src="" alt="Interior" class="w-full h-16 object-cover"></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. REVISION REQUEST MODAL -->
      <div id="sourcing-revision-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:440px; position:relative; margin:16px;" font-mono text-xs>
          <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
            <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Minta Revisi Dokumen</h3>
            <button onclick="closeSourcingRevision()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
          </div>
          <?php echo form_open('', ['id' => 'sourcing-revision-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Catatan Perbaikan Berkas:</label>
              <textarea name="revisions_required" required placeholder="Tuliskan berkas/dokumen apa yang harus diunggah ulang pembeli..." class="cyber-input py-2 h-24 w-full rounded-xl"></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-4">
              <button type="button" onclick="closeSourcingRevision()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
              <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Kirim Catatan</button>
            </div>
          </form>
        </div>
      </div>

      <!-- 3. REJECT MODAL -->
      <div id="sourcing-reject-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:440px; position:relative; margin:16px;" font-mono text-xs>
          <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
            <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Tolak Pengajuan Sourcing</h3>
            <button onclick="closeSourcingReject()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
          </div>
          <?php echo form_open('', ['id' => 'sourcing-reject-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Alasan Penolakan:</label>
              <textarea name="rejection_reason" required placeholder="Tulis alasan penolakan secara jelas..." class="cyber-input py-2 h-24 w-full rounded-xl"></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-4">
              <button type="button" onclick="closeSourcingReject()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
              <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 text-white font-bold uppercase">Tolak Pengajuan</button>
            </div>
          </form>
        </div>
      </div>

      <!-- 4. PHYSICAL INSPECTION & PRICE OFFER MODAL -->
      <div id="sourcing-inspection-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:480px; position:relative; margin:16px;" font-mono text-xs>
          <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
            <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Hasil Inspeksi &amp; Tawar Harga</h3>
            <button onclick="closeSourcingInspection()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
          </div>
          <?php echo form_open('', ['id' => 'sourcing-inspection-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
            
            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Hasil Survey Fisik &amp; Dokumen:</label>
              <textarea name="inspection_notes" required placeholder="Tuliskan catatan survey (Mesin sehat, body 90% mulus, BPKB lengkap dll)..." class="cyber-input py-2 h-20 w-full rounded-xl"></textarea>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Harga Maksimal Penawaran Showroom (Rp):</label>
              <input type="number" name="price_offered" id="offered-price-input" required class="cyber-input text-xs w-full">
              <span class="text-[9px] text-[#999999]">Harga diinginkan user: Rp <span id="sd-user-price-label">-</span></span>
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button type="button" onclick="closeSourcingInspection()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
              <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Kirim Penawaran Harga</button>
            </div>
          </form>
        </div>
      </div>

      <!-- 5. PROCESS PAYOUT MODAL -->
      <div id="sourcing-payout-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:480px; position:relative; margin:16px;" font-mono text-xs>
          <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
            <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Pembayaran Payout Sourcing</h3>
            <button onclick="closeSourcingPayout()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
          </div>
          <?php echo form_open_multipart('', ['id' => 'sourcing-payout-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
            
            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Nominal Payout Lunas:</label>
              <div class="text-base text-black font-extrabold" id="payout-amount-label">Rp -</div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-bold text-black uppercase">Metode Payout:</label>
              <select name="payment_method" id="payout-method-select" onchange="togglePayoutFields(this.value)" class="cyber-input text-xs w-full">
                <option value="transfer">Bank Transfer (Rekomendasi)</option>
                <option value="cash">Tunai (Cash)</option>
              </select>
            </div>

            <div id="payout-transfer-fields" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                  <label class="font-bold text-black uppercase">Nama Bank:</label>
                  <input type="text" name="bank_name" placeholder="BCA/Mandiri" class="cyber-input text-xs w-full">
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="font-bold text-black uppercase">Nomor Rekening:</label>
                  <input type="text" name="bank_account" placeholder="12345678" class="cyber-input text-xs w-full">
                </div>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-bold text-black uppercase">Atas Nama Pemegang Rekening:</label>
                <input type="text" name="bank_holder" placeholder="Nama Lengkap" class="cyber-input text-xs w-full">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-bold text-black uppercase">Upload Bukti Transfer Resmi (Wajib, PDF/JPG/PNG):</label>
                <input type="file" name="receipt_file" class="text-xs">
              </div>
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button type="button" onclick="closeSourcingPayout()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
              <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold uppercase">Selesaikan Pembayaran</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Script helpers for sourcing modals -->
      <script>
        function viewSourcingDetail(data) {
          document.getElementById('sd-owner-name').textContent = data.owner_name;
          document.getElementById('sd-owner-phone').textContent = data.owner_phone;
          document.getElementById('sd-owner-address').textContent = data.owner_address;
          document.getElementById('sd-car-unit').textContent = data.car_brand + ' ' + data.car_model + ' (' + data.car_year + ')';
          document.getElementById('sd-car-plate').textContent = data.car_plate;
          document.getElementById('sd-car-mileage').textContent = Number(data.mileage).toLocaleString('id-ID') + ' KM';
          document.getElementById('sd-car-price').textContent = 'Rp ' + Number(data.price_desired).toLocaleString('id-ID');
          document.getElementById('sd-description').textContent = data.description || 'Tidak ada deskripsi.';

          // Images
          const uploads = '<?php echo base_url("uploads/"); ?>';
          
          if (data.stnk_doc) {
            document.getElementById('sd-stnk-img').src = uploads + data.stnk_doc;
            document.getElementById('sd-stnk-link').href = uploads + data.stnk_doc;
          } else {
            document.getElementById('sd-stnk-img').src = '';
          }

          if (data.bpkb_doc) {
            document.getElementById('sd-bpkb-img').src = uploads + data.bpkb_doc;
            document.getElementById('sd-bpkb-link').href = uploads + data.bpkb_doc;
          } else {
            document.getElementById('sd-bpkb-img').src = '';
          }

          if (data.photo_front) {
            document.getElementById('sd-front-img').src = uploads + data.photo_front;
            document.getElementById('sd-front-link').href = uploads + data.photo_front;
          } else {
            document.getElementById('sd-front-img').src = '';
          }

          if (data.photo_back) {
            document.getElementById('sd-back-img').src = uploads + data.photo_back;
            document.getElementById('sd-back-link').href = uploads + data.photo_back;
          } else {
            document.getElementById('sd-back-img').src = '';
          }

          if (data.photo_interior) {
            document.getElementById('sd-interior-img').src = uploads + data.photo_interior;
            document.getElementById('sd-interior-link').href = uploads + data.photo_interior;
          } else {
            document.getElementById('sd-interior-img').src = '';
          }

          document.getElementById('sourcing-detail-overlay').style.display = 'flex';
        }

        function closeSourcingDetail() {
          document.getElementById('sourcing-detail-overlay').style.display = 'none';
        }

        function closeSourcingDetailBackdrop(event) {
          if (event.target === document.getElementById('sourcing-detail-overlay')) closeSourcingDetail();
        }

        function openSourcingRevisionModal(id) {
          document.getElementById('sourcing-revision-overlay').style.display = 'flex';
          document.getElementById('sourcing-revision-form').action = '<?php echo base_url("admin/request_sourcing_revision/"); ?>' + id;
        }

        function closeSourcingRevision() {
          document.getElementById('sourcing-revision-overlay').style.display = 'none';
        }

        function openSourcingRejectModal(id) {
          document.getElementById('sourcing-reject-overlay').style.display = 'flex';
          document.getElementById('sourcing-reject-form').action = '<?php echo base_url("admin/reject_sourcing/"); ?>' + id;
        }

        function closeSourcingReject() {
          document.getElementById('sourcing-reject-overlay').style.display = 'none';
        }

        function openSourcingInspectionModal(id, desiredPrice) {
          document.getElementById('sourcing-inspection-overlay').style.display = 'flex';
          document.getElementById('sourcing-inspection-form').action = '<?php echo base_url("admin/save_inspection/"); ?>' + id;
          document.getElementById('offered-price-input').value = desiredPrice;
          document.getElementById('sd-user-price-label').textContent = Number(desiredPrice).toLocaleString('id-ID');
        }

        function closeSourcingInspection() {
          document.getElementById('sourcing-inspection-overlay').style.display = 'none';
        }

        function openSourcingPayoutModal(id, offeredPrice) {
          document.getElementById('sourcing-payout-overlay').style.display = 'flex';
          document.getElementById('sourcing-payout-form').action = '<?php echo base_url("admin/process_sourcing_payout/"); ?>' + id;
          document.getElementById('payout-amount-label').textContent = 'Rp ' + Number(offeredPrice).toLocaleString('id-ID');
        }

        function closeSourcingPayout() {
          document.getElementById('sourcing-payout-overlay').style.display = 'none';
        }

        function togglePayoutFields(val) {
          const fields = document.getElementById('payout-transfer-fields');
          if (val === 'cash') {
            fields.style.display = 'none';
          } else {
            fields.style.display = 'block';
          }
        }
      </script>

      <div id="panel-user" class="hidden space-y-6 admin-panel-div">
        <!-- Header Stats -->
        <div class="grid grid-cols-4 gap-4">
          <?php
            $role_counts = ['admin'=>0,'staff'=>0,'kurir'=>0,'client'=>0];
            if (!empty($users)) { foreach($users as $u) { if(isset($role_counts[$u['role']])) $role_counts[$u['role']]++; } }
          ?>
          <?php foreach(['admin'=>'Admin','staff'=>'Staff','kurir'=>'Kurir','client'=>'Client'] as $role => $label): ?>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-4 framer-card">
            <span class="text-[#999999] block text-[9px] uppercase font-mono tracking-wider"><?php echo $label; ?></span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $role_counts[$role]; ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- User Management Table -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm framer-card relative overflow-hidden">
          <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>
          <div class="flex justify-between items-center mb-6 relative">
            <h3 class="font-display font-bold text-base text-black flex items-center gap-2">
              <i class="fa-solid fa-user-gear text-black"></i> MANAJEMEN USER SISTEM
            </h3>
            <div class="text-[9px] font-mono text-[#999999] border border-[#EAEAEA] px-3 py-1.5 rounded-full">
              <?php echo count($users); ?> REGISTERED USERS
            </div>
          </div>
          <div class="overflow-x-auto relative">
            <table class="w-full text-left font-mono text-xs">
              <thead>
                <tr class="border-b border-[#EAEAEA] text-[#666666]">
                  <th class="py-3 uppercase font-semibold">User</th>
                  <th class="py-3 uppercase font-semibold">Email</th>
                  <th class="py-3 uppercase font-semibold">Telp</th>
                  <th class="py-3 uppercase font-semibold">Role</th>
                  <th class="py-3 uppercase text-right font-semibold">Bergabung</th>
                  <th class="py-3 uppercase text-right font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-[#EAEAEA] text-[#333333]">
                <?php if (!empty($users)): ?>
                  <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-[#FAFAFA] transition-colors">
                      <td class="py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-full bg-[#F5F5F5] border border-[#EAEAEA] flex items-center justify-center font-bold text-black text-xs font-display">
                            <?php echo strtoupper(substr($u['username'], 0, 1)); ?>
                          </div>
                          <div>
                            <span class="font-bold text-black font-sans block text-[13px] leading-tight"><?php echo $u['fullname']; ?></span>
                            <span class="text-[9px] text-[#999999]">@<?php echo $u['username']; ?></span>
                          </div>
                        </div>
                      </td>
                      <td class="py-4 text-[#666666]"><?php echo $u['email']; ?></td>
                      <td class="py-4 text-[#666666]"><?php echo $u['phone']; ?></td>
                      <td class="py-4">
                        <?php
                          $roleClass = ['manager'=>'bg-purple-600 text-white', 'admin'=>'bg-black text-white','staff'=>'bg-[#F5F5F5] text-black border border-black/20','kurir'=>'bg-[#F5F5F5] text-[#666666]','client'=>'bg-[#F5F5F5] text-black'];
                          $rc = $roleClass[$u['role']] ?? 'bg-[#F5F5F5] text-black';
                        ?>
                        <span class="px-2.5 py-0.5 rounded-full <?php echo $rc; ?> text-[9px] font-semibold font-display uppercase">
                          <?php echo strtoupper($u['role']); ?>
                        </span>
                      </td>
                      <td class="py-4 text-right text-[#999999]"><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                      <td class="py-4 text-right">
                        <?php if($this->session->userdata('role') === 'manager' && $u['id'] !== $this->session->userdata('user_id')): ?>
                          <button onclick="openRoleModal(<?php echo $u['id']; ?>, '<?php echo $u['role']; ?>')" class="px-3 py-1 rounded-xl bg-black text-white font-bold uppercase text-[9px]">Edit Role</button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-12 text-center text-[#999999]">Belum ada user terdaftar saat ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== REJECT PAYMENT MODAL ===== -->
<div id="reject-modal-overlay" onclick="handleOverlayClick(event)" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); align-items:center; justify-content:center;">
  <div id="reject-modal-box" style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:40px 44px; width:100%; max-width:480px; position:relative; margin:16px;">
    
    <!-- Dot-matrix decorative pattern -->
    <div style="position:absolute;inset:0;border-radius:28px;overflow:hidden;pointer-events:none;opacity:0.025;background-image:radial-gradient(#000 1.2px, transparent 1.2px);background-size:14px 14px;"></div>
    
    <!-- Header -->
    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px;">
      <div>
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
          <div style="width:36px;height:36px;border-radius:50%;background:#FEF2F2;border:1px solid #FECACA;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-circle-xmark" style="color:#EF4444; font-size:16px;"></i>
          </div>
          <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:17px; color:#000; margin:0; letter-spacing:-0.3px;">Tolak Pembayaran</h3>
        </div>
        <p style="font-family:'IBM Plex Mono',monospace; font-size:10px; color:#999; margin:0; text-transform:uppercase; letter-spacing:0.08em;">Admin · Reject Payment Confirmation</p>
      </div>
      <button onclick="closeRejectModal()" style="width:32px;height:32px;border-radius:50%;border:1px solid #EAEAEA;background:#F5F5F5;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background 0.2s;" onmouseover="this.style.background='#e5e5e5'" onmouseout="this.style.background='#F5F5F5'">
        <i class="fa-solid fa-xmark" style="font-size:12px; color:#666;"></i>
      </button>
    </div>

    <!-- Divider -->
    <div style="height:1px; background:#EAEAEA; margin-bottom:24px;"></div>

    <!-- Warning note -->
    <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:14px; padding:12px 16px; margin-bottom:22px; display:flex; align-items:center; gap:10px;">
      <i class="fa-solid fa-triangle-exclamation" style="color:#EF4444; font-size:13px; flex-shrink:0;"></i>
      <p style="font-family:'IBM Plex Mono',monospace; font-size:10px; color:#b91c1c; margin:0; line-height:1.6;">Tindakan ini akan menolak pembayaran dan mengirim notifikasi alasan kepada pembeli.</p>
    </div>

    <!-- Form -->
    <form id="reject-modal-form" action="" method="post">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <input type="hidden" id="reject-payment-id" name="payment_id" value="">
      
      <div style="margin-bottom:20px;">
        <label style="display:block; font-family:'IBM Plex Mono',monospace; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#333; margin-bottom:8px;">
          Alasan Penolakan <span style="color:#EF4444;">*</span>
        </label>
        <textarea 
          id="reject-reason-input"
          name="reason" 
          rows="4"
          placeholder="Contoh: Nama pengirim tidak sesuai, jumlah transfer kurang Rp 50.000, atau bukti pembayaran buram..."
          required
          style="width:100%; box-sizing:border-box; background:#FAFAFA; border:1.5px solid #EAEAEA; border-radius:14px; padding:14px 16px; font-family:'IBM Plex Mono',monospace; font-size:11px; color:#333; resize:vertical; min-height:100px; outline:none; transition:border-color 0.2s;"
          onfocus="this.style.borderColor='#000'; this.style.background='#fff';"
          onblur="this.style.borderColor='#EAEAEA'; this.style.background='#FAFAFA';"
        ></textarea>
      </div>

      <!-- Action Buttons -->
      <div style="display:flex; gap:12px;">
        <button type="button" onclick="closeRejectModal()" style="flex:1; padding:13px; border-radius:50px; border:1.5px solid #EAEAEA; background:#fff; font-family:'Outfit',sans-serif; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.06em; color:#666; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#F5F5F5'" onmouseout="this.style.background='#fff'">
          Batal
        </button>
        <button type="submit" id="reject-submit-btn" style="flex:1.5; padding:13px; border-radius:50px; border:none; background:#EF4444; font-family:'Outfit',sans-serif; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.06em; color:#fff; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#EF4444'">
          <i class="fa-solid fa-circle-xmark"></i> Konfirmasi Tolak
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ===== PAYMENT DETAIL MODAL ===== -->
<div id="payment-detail-overlay" onclick="handleDetailOverlayClick(event)" style="display:none; position:fixed; inset:0; z-index:9998; background:rgba(0,0,0,0.5); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); align-items:center; justify-content:center; padding:16px;">
  <div id="payment-detail-box" style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 40px 100px rgba(0,0,0,0.22); width:100%; max-width:640px; position:relative; max-height:90vh; overflow-y:auto; scrollbar-width:thin;">
    
    <!-- Dot-matrix decorative -->
    <div style="position:absolute;top:0;left:0;right:0;height:200px;border-radius:28px 28px 0 0;overflow:hidden;pointer-events:none;opacity:0.025;background-image:radial-gradient(#000 1.2px, transparent 1.2px);background-size:14px 14px;"></div>
    
    <!-- Sticky Header -->
    <div style="position:sticky;top:0;z-index:10;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-radius:28px 28px 0 0;border-bottom:1px solid #EAEAEA;padding:28px 32px 20px;">
      <div style="display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:40px;height:40px;border-radius:50%;background:#000;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-file-invoice" style="color:#fff;font-size:15px;"></i>
          </div>
          <div>
            <h3 id="detail-modal-title" style="font-family:'Outfit',sans-serif;font-weight:800;font-size:17px;color:#000;margin:0;letter-spacing:-0.4px;">Detail Transaksi</h3>
            <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;margin:0;text-transform:uppercase;letter-spacing:0.08em;">Admin · Payment Verification</p>
          </div>
        </div>
        <button onclick="closePaymentDetail()" style="width:34px;height:34px;border-radius:50%;border:1px solid #EAEAEA;background:#F5F5F5;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background 0.2s;" onmouseover="this.style.background='#e5e5e5'" onmouseout="this.style.background='#F5F5F5'">
          <i class="fa-solid fa-xmark" style="font-size:13px;color:#666;"></i>
        </button>
      </div>
    </div>

    <!-- Body -->
    <div style="padding:28px 32px 32px;display:flex;flex-direction:column;gap:24px;">

      <!-- CAR SECTION -->
      <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:18px;overflow:hidden;">
        <div id="detail-car-image-wrap" style="width:100%;height:160px;background:#F0F0F0;overflow:hidden;display:none;">
          <img id="detail-car-image" src="" alt="" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div style="padding:16px 20px;">
          <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 8px;">Mobil yang Dibeli</p>
          <p id="detail-car-name" style="font-family:'Outfit',sans-serif;font-weight:800;font-size:20px;color:#000;margin:0 0 4px;">-</p>
          <div style="display:flex;gap:16px;align-items:center;flex-wrap:wrap;">
            <span id="detail-car-plate" style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#666;"><i class="fa-solid fa-hashtag" style="font-size:8px;"></i> -</span>
            <span id="detail-car-price" style="font-family:'Outfit',sans-serif;font-weight:700;font-size:14px;color:#000;">Rp -</span>
          </div>
        </div>
      </div>

      <!-- PAYMENT INFO -->
      <div>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 12px;">Informasi Pembayaran</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:14px 16px;">
            <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#999;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">Kode Pembayaran</p>
            <p id="detail-payment-code" style="font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:700;color:#000;margin:0;">-</p>
          </div>
          <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:14px 16px;">
            <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#999;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">Tipe</p>
            <p id="detail-payment-type" style="font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:700;color:#000;margin:0;">-</p>
          </div>
          <div style="background:#000;border-radius:14px;padding:14px 16px;">
            <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#888;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">Jumlah Transfer</p>
            <p id="detail-amount" style="font-family:'Outfit',sans-serif;font-size:16px;font-weight:800;color:#fff;margin:0;">Rp -</p>
          </div>
          <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:14px 16px;">
            <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#999;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">Kode Booking</p>
            <p id="detail-booking-code" style="font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:700;color:#000;margin:0;">-</p>
          </div>
        </div>
      </div>

      <!-- BANK TRANSFER DETAILS -->
      <div>
        <p id="detail-bank-heading" style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 12px;">Detail Transfer Bank</p>
        <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:18px 20px;display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span id="detail-bank-name-label" style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Bank</span>
            <span id="detail-bank-name" style="font-family:'Outfit',sans-serif;font-weight:700;font-size:13px;color:#000;">-</span>
          </div>
          <div id="detail-bank-divider-1" style="height:1px;background:#EAEAEA;"></div>
          <div id="detail-bank-account-row" style="display:flex;justify-content:space-between;align-items:center;">
            <span id="detail-bank-account-label" style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">No. Rekening</span>
            <span id="detail-bank-account" style="font-family:'IBM Plex Mono',monospace;font-weight:700;font-size:13px;color:#000;letter-spacing:0.06em;">-</span>
          </div>
          <div id="detail-bank-divider-2" style="height:1px;background:#EAEAEA;"></div>
          <div id="detail-bank-holder-row" style="display:flex;justify-content:space-between;align-items:center;">
            <span id="detail-bank-holder-label" style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Nama Pemilik</span>
            <span id="detail-bank-holder" style="font-family:'Outfit',sans-serif;font-weight:600;font-size:13px;color:#000;">-</span>
          </div>
        </div>
      </div>

      <!-- USER PROFILE -->
      <div>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 12px;">Profil Pembeli</p>
        <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:18px 20px;display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Nama Lengkap</span>
            <span id="detail-client-name" style="font-family:'Outfit',sans-serif;font-weight:700;font-size:13px;color:#000;">-</span>
          </div>
          <div style="height:1px;background:#EAEAEA;"></div>
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Email</span>
            <span id="detail-client-email" style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#333;">-</span>
          </div>
          <div style="height:1px;background:#EAEAEA;"></div>
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">No. Telepon</span>
            <span id="detail-client-phone" style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#333;">-</span>
          </div>
        </div>
      </div>

      <!-- METODE PENYERAHAN -->
      <div>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 12px;">Penyerahan Unit</p>
        <div style="background:#FAFAFA;border:1px solid #EAEAEA;border-radius:14px;padding:18px 20px;display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Metode Penyerahan</span>
            <span id="detail-delivery-type" style="font-family:'Outfit',sans-serif;font-weight:700;font-size:13px;color:#000;">-</span>
          </div>
          <div id="detail-delivery-address-row" style="display:none;flex-direction:column;gap:10px;">
            <div style="height:1px;background:#EAEAEA;"></div>
            <div style="display:flex;flex-direction:column;gap:4px;">
              <span style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;">Alamat Pengiriman</span>
              <span id="detail-delivery-address" style="font-family:'Outfit',sans-serif;font-size:12px;color:#333;line-height:1.4;">-</span>
            </div>
          </div>
        </div>
      </div>

      <!-- DOCUMENTS (KTP + Evidence) -->
      <div>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#999;margin:0 0 12px;">Dokumen</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <!-- KTP -->
          <div id="detail-ktp-wrap" style="border:1px solid #EAEAEA;border-radius:14px;overflow:hidden;background:#FAFAFA;">
            <div style="padding:10px 14px;border-bottom:1px solid #EAEAEA;">
              <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;color:#666;margin:0;text-transform:uppercase;letter-spacing:0.08em;">KTP Pembeli</p>
            </div>
            <div id="detail-ktp-body" style="padding:12px;">
              <div id="detail-ktp-empty" style="height:100px;display:flex;align-items:center;justify-content:center;">
                <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#BBBBBB;margin:0;">Belum diunggah</p>
              </div>
              <a id="detail-ktp-link" href="#" target="_blank" style="display:none;">
                <img id="detail-ktp-img" src="" alt="KTP" style="width:100%;border-radius:8px;cursor:pointer;">
              </a>
            </div>
          </div>
          <!-- Bukti Pembayaran -->
          <div id="detail-evidence-wrap" style="border:1px solid #EAEAEA;border-radius:14px;overflow:hidden;background:#FAFAFA;">
            <div style="padding:10px 14px;border-bottom:1px solid #EAEAEA;">
              <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;font-weight:700;color:#666;margin:0;text-transform:uppercase;letter-spacing:0.08em;">Bukti Transfer</p>
            </div>
            <div style="padding:12px;">
              <div id="detail-evidence-empty" style="height:100px;display:flex;align-items:center;justify-content:center;">
                <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#BBBBBB;margin:0;">Belum diunggah</p>
              </div>
              <a id="detail-evidence-link" href="#" target="_blank" style="display:none;">
                <img id="detail-evidence-img" src="" alt="Bukti" style="width:100%;border-radius:8px;cursor:pointer;">
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- DP / Sisa Pembayaran -->
      <div style="background:#F5F5F5;border-radius:14px;padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#999;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">DP / Booking Fee</p>
          <p id="detail-dp" style="font-family:'Outfit',sans-serif;font-weight:800;font-size:15px;color:#000;margin:0;">Rp -</p>
        </div>
        <div>
          <p style="font-family:'IBM Plex Mono',monospace;font-size:8px;color:#999;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.06em;">Sisa Pembayaran</p>
          <p id="detail-remaining" style="font-family:'Outfit',sans-serif;font-weight:800;font-size:15px;color:#000;margin:0;">Rp -</p>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Advanced SPA Tab Switcher & selected style optimization -->
<script>
  function switchAdminPanel(panelId) {
    // Save to localStorage
    localStorage.setItem('activeAdminPanel', panelId);

    // Hide all panel divs
    const divs = document.querySelectorAll('.admin-panel-div');
    divs.forEach(d => {
      d.classList.add('hidden');
    });

    // Show target panel div with dynamic Framer-like transition
    const targetDiv = document.getElementById('panel-' + panelId);
    if (targetDiv) {
      targetDiv.classList.remove('hidden');
      
      // Anime.js smooth reveal
      anime({
        targets: targetDiv,
        opacity: [0, 1],
        translateY: [15, 0],
        scale: [0.98, 1],
        easing: 'easeOutExpo',
        duration: 400
      });
    }

    // Define which ones are main menus and which are sub menus
    const mainMenus = ['dashboard', 'kelola-mobil', 'pelanggan', 'pengaturan', 'user'];
    const subMenus = ['transaksi', 'sourcing', 'pengiriman', 'laporan_penjualan', 'laporan_pembelian'];

    // Reset main menus
    mainMenus.forEach(m => {
      const el = document.getElementById('menu-' + m);
      if (el) {
        el.className = 'flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-[#F5F5F5] hover:text-black text-[#666666] transition-all mx-2';
      }
    });

    // Reset sub menus
    subMenus.forEach(m => {
      const el = document.getElementById('menu-' + m);
      if (el) {
        el.className = 'block text-xs text-[#999999] hover:text-black transition-all py-1.5';
      }
    });

    // Make current target menu active
    const activeEl = document.getElementById('menu-' + panelId);
    if (activeEl) {
      if (mainMenus.includes(panelId)) {
        activeEl.className = 'flex items-center gap-3 px-4 py-2.5 rounded-xl bg-black text-white transition-all mx-2 shadow-[0_4px_12px_rgba(0,0,0,0.1)]';
      } else if (subMenus.includes(panelId)) {
        // Efek selected garis bawah hitam
        activeEl.className = 'block w-max text-xs text-black font-bold border-b-2 border-black transition-all py-1';
        
        // Auto-expand parent dropdown
        const parentSub = activeEl.closest('div[id^="submenu-"]');
        if (parentSub) {
          parentSub.classList.remove('hidden');
        }
      }
    }
  }

  // Restore active panel on load
  document.addEventListener("DOMContentLoaded", function() {
    const activePanel = localStorage.getItem('activeAdminPanel') || 'dashboard';
    switchAdminPanel(activePanel);
  });

  function switchPelangganTab(tabId) {
    // Hide all sub-panels
    const subPanels = document.querySelectorAll('.pelanggan-sub-panel');
    subPanels.forEach(p => p.classList.add('hidden'));

    // Show target sub-panel
    const targetSub = document.getElementById('sub-panel-' + tabId);
    if (targetSub) {
      targetSub.classList.remove('hidden');
      anime({
        targets: targetSub,
        opacity: [0, 1],
        translateY: [10, 0],
        easing: 'easeOutExpo',
        duration: 300
      });
    }

    // Reset sub-tab buttons
    const btnBuyer = document.getElementById('tab-btn-buyer');
    const btnSeller = document.getElementById('tab-btn-seller');

    if (tabId === 'buyer') {
      btnBuyer.className = 'pb-3 border-b-2 border-black text-black font-bold uppercase transition-all flex items-center gap-2';
      btnSeller.className = 'pb-3 border-b-2 border-transparent text-[#999999] font-medium hover:text-black uppercase transition-all flex items-center gap-2';
    } else {
      btnSeller.className = 'pb-3 border-b-2 border-black text-black font-bold uppercase transition-all flex items-center gap-2';
      btnBuyer.className = 'pb-3 border-b-2 border-transparent text-[#999999] font-medium hover:text-black uppercase transition-all flex items-center gap-2';
    }
  }

  function saveSettings(e) {
    e.preventDefault();
    
    // Create elegant premium toast notify
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-8 right-8 bg-black text-white px-6 py-3.5 rounded-full border border-white/20 shadow-2xl font-mono text-xs z-50 blink-dot';
    toast.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i> PENGATURAN DRIVE.X BERHASIL DISIMPAN KE DATABASE!';
    document.body.appendChild(toast);
    
    setTimeout(() => {
      anime({
        targets: toast,
        opacity: 0,
        translateY: 20,
        easing: 'easeInQuad',
        duration: 300,
        complete: () => toast.remove()
      });
    }, 3000);
  }

  // ===== REJECT PAYMENT MODAL FUNCTIONS =====
  function openRejectModal(paymentId) {
    // Set the form action and payment ID
    document.getElementById('reject-payment-id').value = paymentId;
    document.getElementById('reject-modal-form').action = '<?php echo base_url("admin/reject_payment/"); ?>' + paymentId;
    document.getElementById('reject-reason-input').value = '';

    // Show overlay
    const overlay = document.getElementById('reject-modal-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Anime.js entrance animation
    anime({
      targets: '#reject-modal-box',
      opacity: [0, 1],
      scale: [0.88, 1],
      translateY: [-20, 0],
      easing: 'easeOutExpo',
      duration: 380
    });

    // Focus textarea after animation
    setTimeout(() => {
      document.getElementById('reject-reason-input').focus();
    }, 300);
  }

  function closeRejectModal() {
    const overlay = document.getElementById('reject-modal-overlay');
    const box = document.getElementById('reject-modal-box');

    anime({
      targets: box,
      opacity: [1, 0],
      scale: [1, 0.9],
      translateY: [0, 15],
      easing: 'easeInQuad',
      duration: 220,
      complete: () => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
      }
    });
  }

  function handleOverlayClick(event) {
    // Close only if clicking the dark backdrop, not the modal box itself
    if (event.target === document.getElementById('reject-modal-overlay')) {
      closeRejectModal();
    }
  }

  // Close modal on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const overlay = document.getElementById('reject-modal-overlay');
      if (overlay && overlay.style.display === 'flex') {
        closeRejectModal();
      }
    }
  });
  // ===== PAYMENT DETAIL MODAL =====
  function openPaymentDetail(data) {
    // -- Payment info --
    document.getElementById('detail-modal-title').textContent = data.payment_code || 'Detail Transaksi';
    document.getElementById('detail-payment-code').textContent = data.payment_code || '-';
    document.getElementById('detail-payment-type').textContent = data.payment_type || '-';
    document.getElementById('detail-amount').textContent = 'Rp ' + (data.amount || '-');
    document.getElementById('detail-booking-code').textContent = data.booking_code || '-';
    document.getElementById('detail-dp').textContent = 'Rp ' + (data.dp_amount || '-');
    document.getElementById('detail-remaining').textContent = 'Rp ' + (data.remaining || '-');

    // -- Bank / Payment Method --
    if (data.payment_method === 'cash') {
      document.getElementById('detail-bank-heading').textContent = 'Metode Pembayaran';
      document.getElementById('detail-bank-name-label').textContent = 'Tipe Pembayaran';
      document.getElementById('detail-bank-name').textContent = 'Tunai (Cash / COD)';
      
      document.getElementById('detail-bank-divider-1').style.display = 'block';
      document.getElementById('detail-bank-account-row').style.display = 'flex';
      document.getElementById('detail-bank-account-label').textContent = 'Keterangan';
      
      let ket = 'Bayar Cash di Showroom';
      if (data.delivery_type === 'delivery') {
        ket = 'Bayar di Rumah (COD)';
      }
      document.getElementById('detail-bank-account').textContent = ket;
      
      document.getElementById('detail-bank-divider-2').style.display = 'none';
      document.getElementById('detail-bank-holder-row').style.display = 'none';
    } else {
      document.getElementById('detail-bank-heading').textContent = 'Detail Transfer Bank';
      document.getElementById('detail-bank-name-label').textContent = 'Bank';
      document.getElementById('detail-bank-name').textContent = data.bank_name || '-';
      
      document.getElementById('detail-bank-divider-1').style.display = 'block';
      document.getElementById('detail-bank-account-row').style.display = 'flex';
      document.getElementById('detail-bank-account-label').textContent = 'No. Rekening';
      document.getElementById('detail-bank-account').textContent = data.bank_account || '-';
      
      document.getElementById('detail-bank-divider-2').style.display = 'block';
      document.getElementById('detail-bank-holder-row').style.display = 'flex';
      document.getElementById('detail-bank-holder-label').textContent = 'Nama Pemilik';
      document.getElementById('detail-bank-holder').textContent = data.bank_holder || '-';
    }

    // -- Delivery Type & Address --
    const devType = data.delivery_type || '';
    if (devType === 'pickup') {
      document.getElementById('detail-delivery-type').textContent = 'Ambil Sendiri di Showroom';
      document.getElementById('detail-delivery-address-row').style.display = 'none';
    } else if (devType === 'delivery') {
      document.getElementById('detail-delivery-type').textContent = 'Kirim ke Alamat';
      document.getElementById('detail-delivery-address-row').style.display = 'flex';
      document.getElementById('detail-delivery-address').textContent = data.delivery_address || '-';
    } else {
      document.getElementById('detail-delivery-type').textContent = 'Belum Dikonfigurasi';
      document.getElementById('detail-delivery-address-row').style.display = 'none';
    }

    // -- User --
    document.getElementById('detail-client-name').textContent = data.client_name || '-';
    document.getElementById('detail-client-email').textContent = data.client_email || '-';
    document.getElementById('detail-client-phone').textContent = data.client_phone || '-';

    // -- Car --
    const carName = [data.car_brand, data.car_model, data.car_year ? '(' + data.car_year + ')' : ''].filter(Boolean).join(' ');
    document.getElementById('detail-car-name').textContent = carName || 'Tidak diketahui';
    document.getElementById('detail-car-plate').innerHTML = '<i class="fa-solid fa-hashtag" style="font-size:8px;"></i> ' + (data.car_plate || '-');
    document.getElementById('detail-car-price').textContent = 'Rp ' + (data.car_price || '-');
    const carImgWrap = document.getElementById('detail-car-image-wrap');
    if (data.car_image) {
      document.getElementById('detail-car-image').src = data.car_image;
      carImgWrap.style.display = 'block';
    } else {
      carImgWrap.style.display = 'none';
    }

    // -- KTP --
    const ktpLink = document.getElementById('detail-ktp-link');
    const ktpEmpty = document.getElementById('detail-ktp-empty');
    if (data.ktp_image) {
      ktpLink.href = data.ktp_image;
      document.getElementById('detail-ktp-img').src = data.ktp_image;
      ktpLink.style.display = 'block';
      ktpEmpty.style.display = 'none';
    } else {
      ktpLink.style.display = 'none';
      ktpEmpty.style.display = 'flex';
    }

    // -- Bukti Transfer --
    const evLink = document.getElementById('detail-evidence-link');
    const evEmpty = document.getElementById('detail-evidence-empty');
    if (data.evidence) {
      evLink.href = data.evidence;
      document.getElementById('detail-evidence-img').src = data.evidence;
      evLink.style.display = 'block';
      evEmpty.style.display = 'none';
    } else {
      evLink.style.display = 'none';
      evEmpty.style.display = 'flex';
    }

    // Show overlay
    const overlay = document.getElementById('payment-detail-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Anime.js entrance
    anime({
      targets: '#payment-detail-box',
      opacity: [0, 1],
      scale: [0.90, 1],
      translateY: [-24, 0],
      easing: 'easeOutExpo',
      duration: 420
    });
  }

  function closePaymentDetail() {
    const overlay = document.getElementById('payment-detail-overlay');
    const box = document.getElementById('payment-detail-box');
    anime({
      targets: box,
      opacity: [1, 0],
      scale: [1, 0.92],
      translateY: [0, 16],
      easing: 'easeInQuad',
      duration: 220,
      complete: () => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
      }
    });
  }

  function handleDetailOverlayClick(event) {
    if (event.target === document.getElementById('payment-detail-overlay')) {
      closePaymentDetail();
    }
  }

  // Extend ESC key to also close detail modal
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const detailOverlay = document.getElementById('payment-detail-overlay');
      if (detailOverlay && detailOverlay.style.display === 'flex') {
        closePaymentDetail();
      }
    }
  }, true);
</script>

<!-- WALK-IN SOURCING MODAL -->
<div id="modal-walkin" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:480px; position:relative; margin:16px;" font-mono text-xs>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Tambah Penjualan (Walk-in)</h3>
      <button onclick="document.getElementById('modal-walkin').style.display='none'" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
    </div>
    <?php echo form_open('admin/tambah_walkin', ['class' => 'space-y-4 font-mono text-xs']); ?>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">Nama Pelanggan:</label>
          <input type="text" name="fullname" required class="cyber-input text-xs w-full py-2">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">No Telepon:</label>
          <input type="text" name="phone" required class="cyber-input text-xs w-full py-2">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">Merek Mobil:</label>
          <input type="text" name="brand" required placeholder="Toyota" class="cyber-input text-xs w-full py-2">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">Model / Tipe:</label>
          <input type="text" name="model" required placeholder="Avanza G" class="cyber-input text-xs w-full py-2">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">Tahun:</label>
          <input type="number" name="year" required min="1990" max="<?php echo date('Y'); ?>" class="cyber-input text-xs w-full py-2">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="font-bold text-black uppercase">Plat Nomor:</label>
          <input type="text" name="plate_number" required placeholder="B 1234 ABC" class="cyber-input text-xs w-full py-2">
        </div>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">Harga Jual Diminta (Rp):</label>
        <input type="number" name="price_expected" required class="cyber-input text-xs w-full py-2">
      </div>
      <div class="flex justify-end gap-2 pt-4">
        <button type="button" onclick="document.getElementById('modal-walkin').style.display='none'" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ROLE EDIT MODAL -->
<div id="modal-role" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:400px; position:relative; margin:16px;" font-mono text-xs>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Edit Hak Akses Role</h3>
      <button onclick="document.getElementById('modal-role').style.display='none'" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
    </div>
    <?php echo form_open('admin/update_user_role', ['class' => 'space-y-4 font-mono text-xs']); ?>
      <input type="hidden" name="user_id" id="role-user-id">
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">Role Baru:</label>
        <select name="role" id="role-select" required class="cyber-input text-xs w-full py-2 bg-white">
          <option value="client">Client</option>
          <option value="admin">Admin (Staff)</option>
          <option value="manager">Manager (Superadmin)</option>
        </select>
      </div>
      <div class="flex justify-end gap-2 pt-4">
        <button type="button" onclick="document.getElementById('modal-role').style.display='none'" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Update Role</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Real-time Notification Badge Polling
  function fetchPendingCounts() {
    fetch('<?php echo base_url("admin/get_pending_counts"); ?>?t=' + new Date().getTime(), { cache: 'no-store' })
      .then(res => res.json())
      .then(data => {
        const badgePesanan = document.getElementById('badge-pesanan');
        const badgeSourcing = document.getElementById('badge-sourcing');
        const badgeProgress = document.getElementById('badge-progress');
        
        if (data.pesanan > 0) {
          badgePesanan.textContent = data.pesanan;
          badgePesanan.classList.remove('hidden');
        } else {
          badgePesanan.classList.add('hidden');
        }

        if (data.sourcing > 0) {
          badgeSourcing.textContent = data.sourcing;
          badgeSourcing.classList.remove('hidden');
        } else {
          badgeSourcing.classList.add('hidden');
        }

        if (badgeProgress) {
          if (data.progress > 0) {
            badgeProgress.textContent = data.progress;
            badgeProgress.classList.remove('hidden');
          } else {
            badgeProgress.classList.add('hidden');
          }
        }
      })
      .catch(err => console.error('Error fetching pending counts:', err));
  }

  // Initial fetch and poll every 5 seconds
  fetchPendingCounts();
  setInterval(fetchPendingCounts, 5000);

function openRoleModal(userId, currentRole) {
  document.getElementById('role-user-id').value = userId;
  document.getElementById('role-select').value = currentRole;
  document.getElementById('modal-role').style.display = 'flex';
}
</script>
