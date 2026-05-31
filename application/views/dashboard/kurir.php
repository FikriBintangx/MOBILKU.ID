<!-- 07. PORTAL KURIR LOGISTIK (Nothing OS Monochrome Aesthetic) -->
<style>
  :root {
    --bg-color: #ffffff;
    --text-main: #111111;
    --text-muted: #666666;
    --border-color: #eaeaea;
  }
  .framer-card {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .framer-card:hover {
    border-color: #000000 !important;
  }
  .cyber-input {
    background: #ffffff;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    padding: 10px 14px;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11px;
    color: #111111;
    outline: none;
    transition: border-color 0.2s ease;
  }
  .cyber-input:focus {
    border-color: #000000;
  }
  /* Tab switcher classes */
  .kurir-tab-panel {
    display: none;
  }
  .kurir-tab-panel.active {
    display: block;
  }
</style>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" data-aos="fade-up" data-aos-duration="700">

  <!-- Main Grid Box -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white border border-[#EAEAEA] rounded-[28px] overflow-hidden shadow-sm min-h-[680px]">
    
    <!-- LEFT SIDEBAR NAVIGATION -->
    <div class="lg:col-span-3 border-r border-[#EAEAEA] p-8 flex flex-col justify-between bg-white">
      <div class="space-y-10">
        <div>
          <h2 class="font-display font-extrabold text-2xl text-black tracking-tight leading-none mb-1">Logistics</h2>
          <span class="text-[10px] font-mono text-[#999999] uppercase tracking-wider">Portal Kurir</span>
        </div>

        <nav class="flex flex-col gap-2 font-sans text-sm font-medium text-[#666666]" id="kurir-nav">
          <a href="javascript:void(0)" onclick="switchKurirTab('dashboard')" id="nav-dashboard" class="flex items-center gap-3 px-4 py-3 rounded-full bg-black text-white transition-all shadow-sm">
            <i class="fa-solid fa-chart-pie text-xs"></i>
            <span>Dashboard</span>
          </a>
          <a href="javascript:void(0)" onclick="switchKurirTab('deliveries')" id="nav-deliveries" class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-[#F5F5F5] hover:text-black transition-all">
            <i class="fa-solid fa-truck-ramp-box text-xs"></i>
            <span>Pengiriman Saya</span>
          </a>
          <a href="javascript:void(0)" onclick="switchKurirTab('history')" id="nav-history" class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-[#F5F5F5] hover:text-black transition-all">
            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
            <span>Riwayat Kirim</span>
          </a>
          <a href="javascript:void(0)" onclick="switchKurirTab('profile')" id="nav-profile" class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-[#F5F5F5] hover:text-black transition-all">
            <i class="fa-solid fa-user-check text-xs"></i>
            <span>Profil Saya</span>
          </a>
          <a href="<?php echo base_url('mobil/logout'); ?>" class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-red-50 hover:text-red-600 transition-all font-mono text-xs mt-4">
            <i class="fa-solid fa-power-off text-xs"></i>
            <span>Logout</span>
          </a>
        </nav>
      </div>

      <div class="pt-6 border-t border-[#EAEAEA] text-[8px] font-mono text-[#999999]">
        <span>DRIVER ACTIVE</span>
        <div class="dot-matrix text-emerald-600 mt-1 uppercase blink-dot">● <?php echo esc($courier['nama']); ?></div>
      </div>
    </div>

    <!-- RIGHT CONTAINER PANELS -->
    <div class="lg:col-span-9 p-8 bg-[#FAFAFA] space-y-8 overflow-y-auto">
      
      <!-- 1. DASHBOARD PANEL -->
      <div id="panel-dashboard" class="kurir-tab-panel active space-y-8">
        
        <!-- Welcome banner -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 shadow-sm flex items-center justify-between">
          <div>
            <h3 class="font-display font-extrabold text-lg text-black">Halo, <?php echo esc($courier['nama']); ?>!</h3>
            <p class="text-xs text-[#666666] font-mono mt-0.5">Pantau dan update status pengantaran mobil pesanan pembeli hari ini.</p>
          </div>
          <div class="text-right font-mono text-[10px] text-[#999999]">
            <?php echo date('d M Y'); ?>
          </div>
        </div>

        <!-- 4 Clean Statistical Counter Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Kirim Hari Ini</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['hari_ini']; ?></span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Kirim Selesai</span>
            <span class="text-emerald-600 font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['selesai']; ?></span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Sedang Jalan</span>
            <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['berjalan']; ?></span>
          </div>
          <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-card">
            <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Gagal/Ditunda</span>
            <span class="text-amber-600 font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['ditunda']; ?></span>
          </div>
        </div>

        <!-- Active Tasks Summary -->
        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 shadow-sm">
          <h4 class="font-display font-bold text-xs uppercase tracking-wider text-black mb-4">Tugas Berjalan Saat Ini</h4>
          
          <?php 
            $active_deliveries = array_filter($deliveries, function($d) {
              return $d['status_pengiriman'] !== 'Selesai' && $d['status_pengiriman'] !== 'Dibatalkan';
            });
          ?>

          <?php if (empty($active_deliveries)): ?>
            <div class="text-center py-12 text-neutral-400 font-mono text-xs">
              <i class="fa-solid fa-truck-fast text-2xl mb-2 text-black/10 block"></i>
              Tidak ada tugas pengiriman aktif hari ini.
            </div>
          <?php else: ?>
            <div class="divide-y divide-[#EAEAEA] font-mono text-[11px]">
              <?php foreach ($active_deliveries as $del): ?>
                <div class="py-4 flex justify-between items-center gap-4">
                  <div>
                    <span class="font-bold text-black text-xs uppercase"><?php echo esc($del['brand'] . ' ' . $del['model']); ?></span>
                    <span class="text-[9px] text-[#999999] block"><?php echo esc($del['nomor_surat'] ? $del['nomor_surat'] : 'SJ/TEMP'); ?> &bull; <?php echo esc($del['client_name']); ?></span>
                  </div>
                  <div class="flex items-center gap-3">
                    <span class="px-2.5 py-0.5 rounded-full border border-black/10 text-[9px] bg-black text-white font-bold uppercase"><?php echo esc($del['status_pengiriman']); ?></span>
                    <button onclick="switchKurirTab('deliveries')" class="px-3 py-1 rounded-xl border border-black text-black text-[9px] font-bold uppercase hover:bg-neutral-50">Kelola</button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

      </div>

      <!-- 2. DELIVERIES PANEL -->
      <div id="panel-deliveries" class="kurir-tab-panel space-y-6">
        <div class="pb-3 border-b border-[#EAEAEA]">
          <h3 class="font-display font-extrabold text-xl text-black">Daftar Tugas Pengiriman Saya</h3>
          <p class="text-xs text-[#666666] font-mono">Kelola pengantaran aktif, cetak Surat Jalan, dan unggah berkas bukti serah terima.</p>
        </div>

        <?php 
          $active_list = array_filter($deliveries, function($d) {
            return $d['status_pengiriman'] !== 'Selesai' && $d['status_pengiriman'] !== 'Dibatalkan';
          });
        ?>

        <?php if (empty($active_list)): ?>
          <div class="text-center py-16 border border-dashed border-[#DADADA] bg-white rounded-[24px] font-mono text-xs text-[#999999]">
            <i class="fa-solid fa-truck-ramp-box text-4xl text-black/10 mb-3 block"></i>
            Semua tugas pengiriman telah diselesaikan.
          </div>
        <?php else: ?>
          <div class="space-y-6">
            <?php foreach ($active_list as $del): ?>
              <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 shadow-sm relative overflow-hidden flex flex-col justify-between">
                <div>
                  <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-3 mb-4 font-mono text-[10px]">
                    <span class="font-bold text-black"><?php echo esc($del['nomor_surat'] ? $del['nomor_surat'] : 'SJ/TEMP'); ?></span>
                    <span class="px-2.5 py-0.5 rounded-full border border-black/10 bg-black text-white font-bold uppercase"><?php echo esc($del['status_pengiriman']); ?></span>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="font-mono text-xs text-[#666666] space-y-1">
                      <h4 class="text-black font-bold uppercase mb-2"><i class="fa-solid fa-user mr-1.5"></i>Data Pembeli</h4>
                      <p>Nama: <strong class="text-black"><?php echo esc($del['client_name']); ?></strong></p>
                      <p>No HP: <strong class="text-black"><?php echo esc($del['client_phone']); ?></strong></p>
                      <p>Alamat Tujuan: <br><strong class="text-black italic"><?php echo esc($del['alamat_tujuan']); ?></strong></p>
                    </div>

                    <div class="font-mono text-xs text-[#666666] space-y-1">
                      <h4 class="text-black font-bold uppercase mb-2"><i class="fa-solid fa-car mr-1.5"></i>Detail Kendaraan</h4>
                      <p>Mobil: <strong class="text-black uppercase"><?php echo esc($del['brand'] . ' ' . $del['model']); ?></strong></p>
                      <p>No Polisi: <strong class="text-black"><?php echo esc($del['plate_number']); ?></strong></p>
                      <p>Booking Code: <strong class="text-black"><?php echo esc($del['booking_code']); ?></strong></p>
                    </div>
                  </div>
                </div>

                <div class="border-t border-[#EAEAEA] pt-4 flex flex-wrap items-center justify-between gap-3">
                  <!-- Print link -->
                  <a href="<?php echo base_url('admin/surat_jalan/' . $del['id_transaksi']); ?>" target="_blank" class="px-4 py-2 rounded-xl border border-[#DADADA] text-black hover:border-black font-mono text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-print"></i> Lihat Surat Jalan
                  </a>

                  <div class="flex items-center gap-2">
                    <!-- Update Status Button -->
                    <button onclick="openStatusModal(<?php echo $del['id_pengiriman']; ?>, '<?php echo esc($del['status_pengiriman']); ?>')" class="px-4 py-2 rounded-xl border border-black text-black hover:bg-neutral-50 font-mono text-[10px] font-bold uppercase tracking-wider">
                      Update Status
                    </button>

                    <!-- Upload Proof Button -->
                    <button onclick="openProofModal(<?php echo $del['id_pengiriman']; ?>)" class="px-4 py-2 rounded-xl bg-black text-white hover:bg-neutral-800 font-mono text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                      <i class="fa-solid fa-upload"></i> Upload Bukti
                    </button>
                  </div>
                </div>

              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- 3. HISTORY PANEL -->
      <div id="panel-history" class="kurir-tab-panel space-y-6">
        <div class="pb-3 border-b border-[#EAEAEA]">
          <h3 class="font-display font-extrabold text-xl text-black">Riwayat Pengiriman Selesai</h3>
          <p class="text-xs text-[#666666] font-mono">Daftar seluruh kendaraan yang telah berhasil diserahterimakan kepada pembeli.</p>
        </div>

        <?php 
          $history_list = array_filter($deliveries, function($d) {
            return $d['status_pengiriman'] === 'Selesai' || $d['status_pengiriman'] === 'Dibatalkan';
          });
        ?>

        <?php if (empty($history_list)): ?>
          <div class="text-center py-16 border border-dashed border-[#DADADA] bg-white rounded-[24px] font-mono text-xs text-[#999999]">
            <i class="fa-solid fa-clock-rotate-left text-4xl text-black/10 mb-3 block"></i>
            Belum ada riwayat pengiriman selesai.
          </div>
        <?php else: ?>
          <div class="space-y-4 font-mono text-xs">
            <?php foreach ($history_list as $del): ?>
              <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm flex items-center justify-between gap-4">
                <div>
                  <strong class="text-black uppercase"><?php echo esc($del['brand'] . ' ' . $del['model']); ?></strong>
                  <span class="text-[9px] text-[#999999] block"><?php echo esc($del['nomor_surat'] ? $del['nomor_surat'] : 'SJ/TEMP'); ?> &bull; <?php echo esc($del['client_name']); ?></span>
                </div>
                <div class="text-right">
                  <span class="px-2.5 py-0.5 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-800 font-bold uppercase text-[9px]">Selesai</span>
                  <a href="<?php echo base_url('admin/surat_jalan/' . $del['id_transaksi']); ?>" target="_blank" class="text-[10px] text-neutral-500 hover:text-black block mt-1 underline">Cetak Arsip SJ</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- 4. PROFILE PANEL -->
      <div id="panel-profile" class="kurir-tab-panel space-y-6">
        <div class="pb-3 border-b border-[#EAEAEA]">
          <h3 class="font-display font-extrabold text-xl text-black">Profil &amp; Keamanan Kurir</h3>
          <p class="text-xs text-[#666666] font-mono">Kelola informasi data diri Anda dan perbarui kata sandi akun secara berkala.</p>
        </div>

        <div class="bg-white border border-[#EAEAEA] rounded-[24px] p-6 sm:p-8 shadow-sm space-y-6">
          <div class="font-mono text-xs text-[#666666] space-y-3">
            <h4 class="text-black font-bold uppercase border-b border-[#EAEAEA] pb-2 mb-2">Informasi Akun Kurir</h4>
            <p>Nama Lengkap: <strong class="text-black"><?php echo esc($courier['nama']); ?></strong></p>
            <p>Email Terdaftar: <strong class="text-black"><?php echo esc($courier['email']); ?></strong></p>
            <p>Nomor Telepon: <strong class="text-black"><?php echo esc($courier['no_hp']); ?></strong></p>
            <p>Alamat Kantor: <strong class="text-black italic"><?php echo esc($courier['alamat']); ?></strong></p>
          </div>

          <div class="border-t border-[#EAEAEA] pt-6">
            <h4 class="text-black font-bold uppercase font-mono text-xs mb-4"><i class="fa-solid fa-lock mr-2"></i>Ubah Password</h4>
            
            <?php echo form_open('admin/change_kurir_password', ['class' => 'grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono text-[#666666]']); ?>
              <div class="flex flex-col gap-2">
                <label class="font-bold text-black uppercase">Password Baru:</label>
                <input type="password" name="new_password" required placeholder="Masukkan password baru..." class="cyber-input text-xs w-full">
              </div>
              <div class="flex items-end">
                <button type="submit" class="px-6 py-2.5 rounded-full bg-black text-white hover:bg-neutral-800 font-bold uppercase transition-all">
                  Perbarui Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== MODAL UPDATE STATUS ===== -->
<div id="status-modal-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:440px; position:relative; margin:16px;" font-mono text-xs>
    <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
      <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Update Status Pengiriman</h3>
      <button type="button" onclick="closeStatusModal()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
    </div>
    
    <?php echo form_open('', ['id' => 'status-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">Status Pengiriman:</label>
        <select name="status_pengiriman" id="status-select" required class="cyber-input text-xs w-full">
          <option value="Kendaraan Dipersiapkan">Kendaraan Dipersiapkan</option>
          <option value="Dalam Perjalanan">Dalam Perjalanan</option>
          <option value="Tiba di Lokasi">Tiba di Lokasi</option>
          <option value="Diserahkan ke Pembeli">Diserahkan ke Pembeli</option>
          <option value="Selesai">Selesai (Serah Terima Selesai)</option>
          <option value="Gagal Kirim">Gagal Kirim (Ditunda)</option>
          <option value="Dibatalkan">Dibatalkan</option>
        </select>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">Catatan Kurir (Opsional):</label>
        <textarea name="catatan" placeholder="Catatan pengiriman..." class="cyber-input py-2 h-16 text-xs w-full rounded-xl"></textarea>
      </div>

      <div class="flex justify-end gap-2 pt-4">
        <button type="button" onclick="closeStatusModal()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Simpan Status</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== MODAL UPLOAD PROOF ===== -->
<div id="proof-modal-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:28px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18); padding:32px; width:100%; max-width:480px; position:relative; margin:16px;" font-mono text-xs>
    <div style="display:flex; align-items:center; justify-content:between; margin-bottom:20px;">
      <h3 style="font-family:'Outfit',sans-serif; font-weight:800; font-size:16px; color:#000; margin:0; text-transform:uppercase;">Unggah Bukti Serah Terima</h3>
      <button type="button" onclick="closeProofModal()" style="border:none;background:none;cursor:pointer;font-size:18px;"><i class="fa-solid fa-xmark text-neutral-400"></i></button>
    </div>

    <?php echo form_open_multipart('', ['id' => 'proof-form', 'class' => 'space-y-4 font-mono text-xs']); ?>
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">1. Foto Serah Terima (Wajib):</label>
        <input type="file" name="foto_serah_terima" required class="text-xs">
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">2. Tanda Tangan Penerima / Digital (Wajib):</label>
        <input type="file" name="tanda_tangan_penerima" required class="text-xs">
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-bold text-black uppercase">3. Foto Kondisi Fisik Mobil (Wajib):</label>
        <input type="file" name="foto_kendaraan" required class="text-xs">
      </div>

      <div class="flex justify-end gap-2 pt-4">
        <button type="button" onclick="closeProofModal()" class="px-5 py-2 rounded-xl border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-black text-white font-bold uppercase">Unggah Bukti</button>
      </div>
    </form>
  </div>
</div>

<script>
  function switchKurirTab(tabId) {
    // Hide all tab panels
    const panels = document.querySelectorAll('.kurir-tab-panel');
    panels.forEach(p => p.classList.remove('active'));

    // Show target panel
    const target = document.getElementById('panel-' + tabId);
    if (target) {
      target.classList.add('active');
    }

    // Reset navigation active styles
    const navs = ['dashboard', 'deliveries', 'history', 'profile'];
    navs.forEach(n => {
      const el = document.getElementById('nav-' + n);
      if (el) {
        el.className = 'flex items-center gap-3 px-4 py-3 rounded-full hover:bg-[#F5F5F5] hover:text-black transition-all';
      }
    });

    // Make target active
    const activeNav = document.getElementById('nav-' + tabId);
    if (activeNav) {
      activeNav.className = 'flex items-center gap-3 px-4 py-3 rounded-full bg-black text-white transition-all shadow-sm';
    }
  }

  function openStatusModal(id, currentStatus) {
    const overlay = document.getElementById('status-modal-overlay');
    overlay.style.display = 'flex';
    document.getElementById('status-form').action = '<?php echo base_url("admin/update_delivery_status_p/"); ?>' + id;
    document.getElementById('status-select').value = currentStatus;
  }

  function closeStatusModal() {
    document.getElementById('status-modal-overlay').style.display = 'none';
  }

  function openProofModal(id) {
    const overlay = document.getElementById('proof-modal-overlay');
    overlay.style.display = 'flex';
    document.getElementById('proof-form').action = '<?php echo base_url("admin/upload_delivery_proof_p/"); ?>' + id;
  }

  function closeProofModal() {
    document.getElementById('proof-modal-overlay').style.display = 'none';
  }
</script>
