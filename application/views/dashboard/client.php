<style>
  body {
    background-image: url('<?php echo base_url("assets/images/bg1.png"); ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  /* Panel utama tanpa blur */
  .bg-white {
    background-color: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
  }

  /* Pastikan hanya card sungguhan yang mendapat style, JANGAN .stagger-card karena itu class animasi */
  .framer-card, .card, .booking-card {
    background-color: rgba(255, 255, 255, 0.75) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
    border: 1px solid #EAEAEA !important;
  }
  
  /* Tombol biarkan solid */
  button.bg-black, .btn-black, .bg-black {
    background-color: #000 !important;
    color: #fff !important;
  }

  /* ===== Multi-select Delete Mode Styles ===== */
  .booking-card {
    position: relative;
    transition: all 0.25s ease;
  }
  .booking-card.selected {
    border-color: #000 !important;
    box-shadow: 0 0 0 2px rgba(0,0,0,0.12);
  }
  .booking-card.selected .card-inner {
    background: #F9F9F9;
  }

  /* Checkbox */
  .booking-checkbox-wrap {
    display: none;
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
  }
  .select-mode-active .booking-checkbox-wrap {
    display: flex;
  }
  .booking-checkbox {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid #DADADA;
    background: #fff;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    transition: all 0.15s ease;
    flex-shrink: 0;
  }
  .booking-checkbox:checked {
    background: #000;
    border-color: #000;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M13.5 3.5L6 11 2.5 7.5' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E");
    background-size: 14px;
    background-repeat: no-repeat;
    background-position: center;
  }

  /* Only deletable cards show checkbox */
  .booking-card.not-deletable .booking-checkbox-wrap {
    display: none !important;
  }

  /* Slide-in select mode when active */
  .select-mode-active .booking-card:not(.not-deletable) {
    padding-left: 3rem !important;
  }
  @media (max-width: 640px) {
    .select-mode-active .booking-card:not(.not-deletable) {
      padding-left: 3rem !important;
    }
  }

  /* Delete action bar */
  #delete-action-bar {
    position: fixed;
    bottom: -100px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 999;
    transition: bottom 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    width: calc(100% - 48px);
    max-width: 600px;
  }
  #delete-action-bar.visible {
    bottom: 28px;
  }

  /* Delete confirmation modal */
  #delete-confirm-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  #delete-confirm-modal.open {
    display: flex;
  }

  /* Not-deletable overlay hint */
  .select-mode-active .booking-card.not-deletable::after {
    content: 'Hanya transaksi CANCELLED / COMPLETED yang bisa dihapus';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(4px);
    border-radius: 0 0 28px 28px;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 9px;
    color: #999;
    text-align: center;
    padding: 6px;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s;
  }
  .select-mode-active .booking-card.not-deletable:hover::after {
    opacity: 1;
  }
</style>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  

  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-12 stagger-card">
    <div>
      <h2 class="font-display font-extrabold text-3xl text-black mb-2">Portal Pelanggan</h2>
      <p class="text-xs text-neutral-600 font-mono font-medium">Kelola transaksi pembelian mobil bekas Anda secara terkomputerisasi.</p>
    </div>
    <div class="flex gap-3 flex-wrap">
      <?php
        $shipping_booking = null;
        if (!empty($bookings)) {
            foreach ($bookings as $bk) {
                if ($bk['delivery_type'] === 'delivery' && in_array($bk['delivery_status'], array('pending', 'shipping'))) {
                    $shipping_booking = $bk;
                    break;
                }
            }
        }
      ?>
      <?php if ($shipping_booking): ?>
        <a href="<?php echo base_url('booking/tracking/' . $shipping_booking['id']); ?>" class="px-4 py-2.5 rounded-xl border border-white/60 bg-white/40 backdrop-blur-md text-black hover:bg-white/60 font-mono text-xs font-bold transition-all flex items-center gap-2 shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
          <i class="fa-solid fa-location-crosshairs text-black animate-pulse"></i> Tracking Pengiriman
        </a>
      <?php endif; ?>
      <?php if (!empty($bookings)): ?>
        <!-- Select mode toggle button -->
        <button id="btn-toggle-select" onclick="toggleSelectMode()"
          class="px-4 py-2.5 rounded-xl border border-white/60 bg-white/40 backdrop-blur-md text-black hover:bg-white/60 font-mono text-xs font-bold transition-all flex items-center gap-2 shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
          <i class="fa-solid fa-trash-can"></i> Hapus Transaksi
        </button>
      <?php endif; ?>
      <a href="<?php echo base_url('sourcing'); ?>" class="px-4 py-2.5 rounded-xl border border-white/60 bg-white/40 backdrop-blur-md text-black hover:bg-white/60 font-mono text-xs font-bold transition-all flex items-center gap-2 shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
        <i class="fa-solid fa-tags"></i> Tawarkan Mobil Saya
      </a>
      <a href="<?php echo base_url(); ?>" class="px-4 py-2.5 rounded-xl border border-white/60 bg-white/40 backdrop-blur-md text-black hover:bg-white/60 font-mono text-xs font-bold transition-all flex items-center gap-2 shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
        <i class="fa-solid fa-car"></i> Cari Mobil Lain
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-8">
    
    <!-- Header row with select-all (only visible in select mode) -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <!-- Select All (hidden by default, shown in select mode) -->
        <div id="select-all-wrap" class="hidden items-center gap-2">
          <input type="checkbox" id="select-all-cb" onchange="toggleSelectAll(this)"
            class="w-5 h-5 rounded border-2 border-[#DADADA] cursor-pointer accent-black">
          <label for="select-all-cb" class="text-xs font-mono font-bold text-black cursor-pointer">Pilih Semua</label>
          <span id="selected-count-badge" class="px-2 py-0.5 bg-black text-white text-[9px] font-mono font-bold rounded-full hidden">0 dipilih</span>
        </div>
        <div id="heading-label" class="flex items-center gap-2 font-display font-extrabold text-sm tracking-wider text-black uppercase stagger-card">
          <i class="fa-solid fa-clock-rotate-left"></i> DAFTAR TRANSAKSI AKTIF
        </div>
      </div>
      <!-- Cancel select mode button -->
      <button id="btn-cancel-select" onclick="toggleSelectMode()" class="hidden text-xs font-mono font-bold text-neutral-500 hover:text-black transition-colors flex items-center gap-1.5">
        <i class="fa-solid fa-xmark"></i> Batal
      </button>
    </div>

    <!-- Bookings loop -->
    <?php if (empty($bookings)): ?>
      <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-12 text-center shadow-[0_4px_30px_rgba(0,0,0,0.02)] stagger-card">
        <i class="fa-solid fa-folder-open text-neutral-400 text-4xl mb-4"></i>
        <h4 class="font-display font-bold text-black mb-2 text-lg">Belum Ada Transaksi</h4>
        <p class="text-xs text-neutral-500 mb-6 font-medium">Anda belum memesan mobil apa pun saat ini.</p>
        <a href="<?php echo base_url(); ?>" class="px-5 py-3 rounded-xl bg-black text-white hover:bg-neutral-800 text-xs font-bold font-mono transition-all">Cari Unit Sekarang</a>
      </div>
    <?php else: ?>
      <form id="delete-form" action="<?php echo base_url('booking/delete_bookings'); ?>" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        
        <div class="space-y-6" id="bookingsList">
          <?php foreach ($bookings as $b): ?>
            <?php
              $isDeletable = in_array($b['status'], ['cancelled', 'completed']);
            ?>
            
            <!-- Individual Booking Card -->
            <div 
              id="card-<?php echo $b['id']; ?>"
              class="booking-card <?php echo !$isDeletable ? 'not-deletable' : ''; ?> bg-white border border-[#EAEAEA] hover:border-black rounded-[28px] p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 stagger-card relative overflow-hidden group shadow-[0_4px_30px_rgba(0,0,0,0.02)] transition-all duration-300 cursor-pointer"
              onclick="handleCardClick(event, <?php echo $b['id']; ?>, <?php echo $isDeletable ? 'true' : 'false'; ?>)"
            >
              <!-- Checkbox (only shown in select mode for deletable cards) -->
              <?php if ($isDeletable): ?>
              <div class="booking-checkbox-wrap">
                <input 
                  type="checkbox" 
                  name="booking_ids[]" 
                  value="<?php echo $b['id']; ?>"
                  id="cb-<?php echo $b['id']; ?>"
                  class="booking-checkbox"
                  onchange="updateSelectedCount()"
                  onclick="event.stopPropagation()"
                >
              </div>
              <?php endif; ?>

              <div class="card-inner w-full flex flex-col md:flex-row items-start md:items-center justify-between gap-6 rounded-[20px] transition-colors">
              
                <!-- Booking code & Car name -->
                <div class="flex flex-col gap-2">
                  <div class="flex items-center gap-3">
                    <span class="font-mono text-xs text-neutral-500 font-extrabold tracking-wider"><?php echo $b['booking_code']; ?></span>
                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-mono font-bold uppercase border <?php 
                      if ($b['status'] === 'ordered') echo 'bg-blue-50 text-blue-800 border-blue-200';
                      elseif ($b['status'] === 'active') echo 'bg-purple-50 text-purple-800 border-purple-200';
                      elseif ($b['status'] === 'completed') echo 'bg-emerald-50 text-emerald-800 border-emerald-200';
                      else echo 'bg-red-50 text-red-800 border-red-200';
                    ?>"><?php echo strtoupper($b['status']); ?></span>
                  </div>
                  <h3 class="font-display font-extrabold text-xl text-black transition-colors">
                    <?php echo $b['brand'] . ' ' . $b['model']; ?>
                  </h3>
                  <span class="text-[10px] font-mono text-neutral-500 font-semibold">Dipesan pada: <?php echo date('d M Y - H:i', strtotime($b['booking_date'])); ?> WIB</span>
                </div>

                <!-- Pricing overview -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 font-mono text-xs border-y md:border-y-0 md:border-x border-[#EAEAEA] py-4 md:py-0 md:px-8 flex-grow max-w-xl text-left">
                  <div>
                    <span class="text-neutral-500 block text-[9px] uppercase font-bold">Harga OTR</span>
                    <span class="text-black font-extrabold text-sm">Rp <?php echo number_format($b['car_price'], 0, ',', '.'); ?></span>
                  </div>
                  <div>
                    <span class="text-neutral-500 block text-[9px] uppercase font-bold">DP 30%</span>
                    <span class="<?php echo ($b['dp_status'] === 'paid') ? 'text-emerald-700' : 'text-red-600'; ?> font-extrabold text-sm">
                      <?php echo ($b['dp_status'] === 'paid') ? 'LUNAS' : 'PENDING'; ?>
                    </span>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <span class="text-neutral-500 block text-[9px] uppercase font-bold">STNK & BPKB</span>
                    <span class="text-black font-extrabold text-sm">
                      <?php echo ($b['stnk_status'] === 'completed' && $b['bpkb_status'] === 'completed') ? 'Selesai' : 'Pengurusan'; ?>
                    </span>
                  </div>
                </div>

                <!-- Actions button -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto" id="actions-<?php echo $b['id']; ?>">
                  <?php if ($b['status'] === 'completed'): ?>
                    <!-- Invoice button for completed -->
                    <a href="<?php echo base_url('booking/invoice/' . $b['id']); ?>" onclick="event.stopPropagation()" target="_blank"
                      class="text-center px-5 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-mono text-xs font-bold flex items-center justify-center gap-2 transition-all duration-200 shadow-sm">
                      <i class="fa-solid fa-file-invoice"></i> Lihat Invoice
                    </a>
                    <a href="<?php echo base_url('booking/detail/' . $b['id']); ?>" onclick="event.stopPropagation()"
                      class="text-center px-4 py-3 rounded-xl border border-[#DADADA] bg-white text-black hover:border-black font-mono text-xs font-bold flex items-center justify-center gap-2 transition-all duration-200">
                      <i class="fa-solid fa-route"></i> Detail
                    </a>
                  <?php else: ?>
                    <a href="<?php echo base_url('booking/detail/' . $b['id']); ?>" onclick="event.stopPropagation()" class="text-center px-5 py-3 rounded-xl bg-black text-white hover:bg-neutral-800 font-mono text-xs font-bold flex items-center justify-center gap-2 transition-all duration-200">
                      <i class="fa-solid fa-route"></i> Lacak Proses
                    </a>
                  <?php endif; ?>
                </div>


              </div>
            </div>

          <?php endforeach; ?>
        </div>
      </form>
    <?php endif; ?>

    <!-- ================= CAR SOURCING SECTION ================= -->
    <div class="mt-16 border-t border-[#EAEAEA] pt-12 stagger-card">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h3 class="font-display font-extrabold text-2xl text-black mb-1">Penjualan Mobil Saya</h3>
          <p class="text-xs text-neutral-600 font-mono">Daftar penawaran unit mobil pribadi Anda yang diajukan ke showroom.</p>
        </div>
      </div>

      <?php if (empty($sourcing)): ?>
        <div class="text-center py-12 px-6 border border-dashed border-[#DADADA] bg-[#FAFAFA] rounded-[24px] font-mono text-xs text-[#999999]">
          <i class="fa-solid fa-tags text-4xl text-black/10 mb-3 block"></i>
          Belum ada pengajuan penjualan mobil dari Anda.
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <?php foreach ($sourcing as $s): ?>
            <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-6 relative flex flex-col justify-between" style="min-height: 280px;">
              <div>
                
                <!-- Status Header -->
                <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-3 mb-4 font-mono text-[10px]">
                  <span class="text-[#999999]">#SRC-<?php echo str_pad($s['id'], 5, '0', STR_PAD_LEFT); ?></span>
                  <div>
                    <?php if ($s['status'] === 'pending'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-neutral-100 text-neutral-800 font-bold uppercase"><i class="fa-regular fa-clock mr-1"></i>Menunggu Review</span>
                    <?php elseif ($s['status'] === 'revision_required'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 font-bold uppercase"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Perlu Perbaikan</span>
                    <?php elseif ($s['status'] === 'inspected'): ?>
                      <?php if ($s['customer_approved']): ?>
                        <span class="px-2.5 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 font-bold uppercase"><i class="fa-solid fa-circle-check mr-1"></i>Harga Disetujui (Proses Bayar)</span>
                      <?php else: ?>
                        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-900 font-bold uppercase"><i class="fa-solid fa-magnifying-glass mr-1"></i>Survey Selesai / Menunggu Approval Anda</span>
                      <?php endif; ?>
                    <?php elseif ($s['status'] === 'purchased'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold uppercase"><i class="fa-solid fa-circle-check mr-1"></i>Selesai (Terbeli)</span>
                    <?php elseif ($s['status'] === 'rejected'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-red-50 border border-red-200 text-red-800 font-bold uppercase"><i class="fa-solid fa-circle-xmark mr-1"></i>Ditolak</span>
                    <?php elseif ($s['status'] === 'cancelled'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-neutral-200 text-neutral-600 font-bold uppercase"><i class="fa-solid fa-ban mr-1"></i>Batal</span>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Info Grid -->
                <div class="flex gap-4 mb-4">
                  <?php if ($s['photo_front']): ?>
                    <img src="<?php echo base_url('uploads/' . $s['photo_front']); ?>" alt="Mobil" class="w-20 h-20 object-cover rounded-[18px] border border-[#EAEAEA] flex-shrink-0">
                  <?php else: ?>
                    <div class="w-20 h-20 bg-neutral-50 border border-[#EAEAEA] rounded-[18px] flex items-center justify-center flex-shrink-0">
                      <i class="fa-solid fa-car text-neutral-300 text-2xl"></i>
                    </div>
                  <?php endif; ?>
                  
                  <div class="font-mono">
                    <h4 class="font-display font-extrabold text-sm text-black uppercase mb-0.5"><?php echo esc($s['car_brand'] . ' ' . $s['car_model']); ?></h4>
                    <p class="text-[10px] text-neutral-600 uppercase mb-1">
                      Tahun <?php echo $s['car_year']; ?> &bull; Nopol <?php echo esc($s['car_plate']); ?> &bull; <?php echo esc($s['car_color']); ?>
                    </p>
                    <p class="text-[10px] text-neutral-500">
                      Kilometer: <strong class="text-black"><?php echo number_format($s['mileage'], 0, ',', '.'); ?> KM</strong>
                    </p>
                    <p class="text-[10px] text-neutral-500">
                      Harga Penawaran Anda: <strong class="text-black">Rp <?php echo number_format($s['price_desired'], 0, ',', '.'); ?></strong>
                    </p>
                  </div>
                </div>

                <!-- Warning notes / Revisions info -->
                <?php if ($s['status'] === 'revision_required' && $s['revisions_required']): ?>
                  <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4 font-mono text-[10px] text-amber-900">
                    <strong>Catatan Perbaikan Dokumen:</strong><br>
                    <?php echo esc($s['revisions_required']); ?>
                  </div>
                <?php elseif ($s['status'] === 'rejected' && $s['rejection_reason']): ?>
                  <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-4 font-mono text-[10px] text-red-900">
                    <strong>Alasan Penolakan:</strong><br>
                    <?php echo esc($s['rejection_reason']); ?>
                  </div>
                <?php elseif ($s['status'] === 'inspected'): ?>
                  <div class="bg-[#FAFAFA] border border-[#EAEAEA] rounded-xl p-3.5 mb-4 font-mono text-[10px]">
                    <div class="flex justify-between border-b border-[#EAEAEA] pb-1.5 mb-1.5">
                      <span>Harga Ditaksir Showroom:</span>
                      <strong class="text-black text-xs">Rp <?php echo number_format($s['price_offered'], 0, ',', '.'); ?></strong>
                    </div>
                    <strong>Hasil Survey Fisik:</strong><br>
                    <span class="text-neutral-600"><?php echo esc($s['inspection_notes'] ?? 'Survey fisik dan dokumen selesai.'); ?></span>
                  </div>
                <?php endif; ?>

              </div>

              <!-- Action button area -->
              <div class="border-t border-[#EAEAEA] pt-3 mt-4 flex items-center justify-between gap-3">
                
                <?php if ($s['status'] === 'revision_required'): ?>
                  <button onclick="toggleRevisionForm(<?php echo $s['id']; ?>)" class="w-full text-center py-2 px-4 rounded-xl border border-black text-black hover:bg-neutral-50 transition-all font-mono text-[10px] font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-pen-to-square"></i> Perbaiki Dokumen &amp; Kirim Ulang
                  </button>
                <?php elseif ($s['status'] === 'inspected' && !$s['customer_approved']): ?>
                  <a href="<?php echo base_url('sourcing/reject_offer/' . $s['id']); ?>" class="flex-1 text-center py-2 px-4 rounded-xl border border-red-200 text-red-700 hover:bg-red-50 transition-all font-mono text-[10px] font-bold uppercase tracking-wider" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                    Tolak / Batal
                  </a>
                  <a href="<?php echo base_url('sourcing/accept_offer/' . $s['id']); ?>" class="flex-1 text-center py-2 px-4 rounded-xl bg-black text-white hover:bg-neutral-800 transition-all font-mono text-[10px] font-bold uppercase tracking-wider">
                    Setujui Harga <i class="fa-solid fa-circle-check ml-1"></i>
                  </a>
                <?php elseif ($s['status'] === 'purchased'): ?>
                  <?php 
                    $payout = $this->db->get_where('payments', array('sourcing_id' => $s['id'], 'status' => 'verified'))->row_array();
                    if ($payout):
                  ?>
                    <a href="<?php echo base_url('admin/kwitansi/' . $payout['id']); ?>" target="_blank" class="w-full text-center py-2 px-4 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition-all font-mono text-[10px] font-bold uppercase tracking-wider flex items-center justify-center gap-1.5">
                      <i class="fa-solid fa-file-invoice-dollar"></i> Lihat Kwitansi Payout Lunas
                    </a>
                  <?php else: ?>
                    <span class="w-full text-center py-2 px-4 rounded-xl bg-neutral-100 text-neutral-500 font-mono text-[10px]">Menunggu Pembuatan Kwitansi Payout</span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="w-full text-center py-2 text-neutral-400 font-mono text-[10px] uppercase">
                    <?php 
                      if ($s['status'] === 'pending') echo 'Menunggu peninjauan berkas';
                      elseif ($s['status'] === 'rejected') echo 'Pengajuan Ditolak';
                      elseif ($s['status'] === 'cancelled') echo 'Pengajuan Dibatalkan';
                      else echo 'Proses Transaksi Sourcing';
                    ?>
                  </span>
                <?php endif; ?>
                
              </div>
            </div>

            <!-- HIDDEN MODAL REVISION FORM FOR EACH TICKET -->
            <?php if ($s['status'] === 'revision_required'): ?>
              <div id="revision-modal-<?php echo $s['id']; ?>" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-md hidden items-center justify-center p-4">
                <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto relative shadow-2xl font-mono text-xs">
                  <h3 class="font-display font-extrabold text-lg text-black mb-4 uppercase">PERBAIKI PENGAJUAN #SRC-<?php echo str_pad($s['id'], 5, '0', STR_PAD_LEFT); ?></h3>
                  <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-6 text-amber-900 text-[10px]">
                    <strong>Catatan Revisi Admin:</strong> <?php echo esc($s['revisions_required']); ?>
                  </div>

                  <?php echo form_open_multipart('sourcing/resubmit/' . $s['id'], ['class' => 'space-y-4 text-left']); ?>
                    
                    <div class="grid grid-cols-2 gap-4">
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Nama Pemilik:</label>
                        <input type="text" name="owner_name" value="<?php echo esc($s['owner_name']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Telepon:</label>
                        <input type="text" name="owner_phone" value="<?php echo esc($s['owner_phone']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Merk:</label>
                        <input type="text" name="car_brand" value="<?php echo esc($s['car_brand']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Model:</label>
                        <input type="text" name="car_model" value="<?php echo esc($s['car_model']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Warna:</label>
                        <input type="text" name="car_color" value="<?php echo esc($s['car_color']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Tahun:</label>
                        <input type="number" name="car_year" value="<?php echo esc($s['car_year']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Nopol:</label>
                        <input type="text" name="car_plate" value="<?php echo esc($s['car_plate']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">KM:</label>
                        <input type="number" name="mileage" value="<?php echo esc($s['mileage']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Harga Diinginkan:</label>
                        <input type="number" name="price_desired" value="<?php echo intval($s['price_desired']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                      <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-black uppercase">Alamat:</label>
                        <input type="text" name="owner_address" value="<?php echo esc($s['owner_address']); ?>" required class="cyber-input text-xs w-full">
                      </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                      <label class="font-bold text-black uppercase">Deskripsi Kondisi:</label>
                      <textarea name="description" required class="cyber-input py-2 h-16 text-xs w-full rounded-xl"><?php echo esc($s['description']); ?></textarea>
                    </div>

                    <div class="border-t border-[#EAEAEA] pt-4 mt-2 space-y-3">
                      <p class="text-[10px] text-neutral-500 uppercase font-bold mb-2">Upload Ulang File/Dokumen (Kosongkan jika tidak ingin diubah):</p>
                      
                      <div class="grid grid-cols-2 gap-4 text-[10px]">
                        <div class="flex flex-col gap-1">
                          <span class="font-bold text-black">Scan STNK:</span>
                          <input type="file" name="stnk_doc" class="text-[10px]">
                        </div>
                        <div class="flex flex-col gap-1">
                          <span class="font-bold text-black">Scan BPKB:</span>
                          <input type="file" name="bpkb_doc" class="text-[10px]">
                        </div>
                      </div>

                      <div class="grid grid-cols-3 gap-2 text-[10px] pt-2">
                        <div class="flex flex-col gap-1">
                          <span class="font-bold text-black">Foto Depan:</span>
                          <input type="file" name="photo_front" class="text-[10px]">
                        </div>
                        <div class="flex flex-col gap-1">
                          <span class="font-bold text-black">Foto Belakang:</span>
                          <input type="file" name="photo_back" class="text-[10px]">
                        </div>
                        <div class="flex flex-col gap-1">
                          <span class="font-bold text-black">Foto Interior:</span>
                          <input type="file" name="photo_interior" class="text-[10px]">
                        </div>
                      </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-[#EAEAEA] mt-6">
                      <button type="button" onclick="toggleRevisionForm(<?php echo $s['id']; ?>)" class="px-5 py-2.5 rounded-full border border-[#EAEAEA] text-neutral-500 font-bold uppercase">Batal</button>
                      <button type="submit" class="px-6 py-2.5 rounded-full bg-black text-white hover:bg-neutral-800 font-bold uppercase">Kirim Perbaikan</button>
                    </div>
                  </form>
                </div>
              </div>
            <?php endif; ?>

          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- Additional helper script for revision modals -->
<script>
  function toggleRevisionForm(id) {
    const modal = document.getElementById('revision-modal-' + id);
    if (modal) {
      if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
      }
    }
  }
</script>


<!-- ===== FLOATING DELETE ACTION BAR ===== -->
<div id="delete-action-bar">
  <div style="background:#000;border-radius:20px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:16px;box-shadow:0 16px 48px rgba(0,0,0,0.3);">
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-trash-can" style="color:#fff;font-size:13px;"></i>
      </div>
      <div>
        <p id="bar-count-text" style="font-family:'Outfit',sans-serif;font-weight:700;font-size:13px;color:#fff;margin:0;">0 transaksi dipilih</p>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:rgba(255,255,255,0.5);margin:0;text-transform:uppercase;letter-spacing:0.08em;">Hanya cancelled &amp; completed</p>
      </div>
    </div>
    <button onclick="openDeleteConfirm()" id="btn-confirm-delete"
      style="padding:10px 20px;border-radius:50px;background:#EF4444;border:none;color:#fff;font-family:'Outfit',sans-serif;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:0.06em;cursor:pointer;display:flex;align-items:center;gap:6px;transition:background 0.2s;opacity:0.5;pointer-events:none;"
      onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#EF4444'">
      <i class="fa-solid fa-trash-can"></i> Hapus
    </button>
  </div>
</div>

<!-- ===== DELETE CONFIRM MODAL ===== -->
<div id="delete-confirm-overlay" style="display:none;position:fixed;inset:0;background:rgba(255,255,255,0.3);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(16px);">
  <div style="background:rgba(255,255,255,0.6);backdrop-filter:blur(32px);width:90%;max-width:380px;border-radius:32px;padding:28px;box-shadow:0 12px 40px rgba(0,0,0,0.08);border:1px solid rgba(255,255,255,0.5);position:relative;transform:translateY(20px);opacity:0;transition:all 0.4s cubic-bezier(0.16, 1, 0.3, 1);" id="delete-confirm-modal">
    
    <!-- Dot matrix decoration -->
    <div style="position:absolute;inset:0;border-radius:32px;overflow:hidden;pointer-events:none;opacity:0.025;background-image:radial-gradient(#000 1.2px, transparent 1.2px);background-size:14px 14px;"></div>
    
    <!-- Icon + Title -->
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
      <div style="width:44px;height:44px;border-radius:50%;background:rgba(239,68,68,0.1);border:1.5px solid rgba(239,68,68,0.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-trash-can" style="color:#EF4444;font-size:17px;"></i>
      </div>
      <div>
        <h3 style="font-family:'Outfit',sans-serif;font-weight:800;font-size:17px;color:#000;margin:0;letter-spacing:-0.3px;">Hapus Transaksi?</h3>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#999;margin:0;text-transform:uppercase;letter-spacing:0.08em;">Aksi ini tidak dapat dibatalkan</p>
      </div>
    </div>

    <div style="height:1px;background:rgba(0,0,0,0.05);margin-bottom:20px;"></div>

    <!-- Warning -->
    <div style="background:rgba(254,242,242,0.5);border:1px solid rgba(254,202,202,0.5);border-radius:18px;padding:12px 16px;margin-bottom:24px;display:flex;align-items:flex-start;gap:10px;backdrop-filter:blur(8px);">
      <i class="fa-solid fa-triangle-exclamation" style="color:#EF4444;font-size:13px;flex-shrink:0;margin-top:1px;"></i>
      <div>
        <p id="modal-count-text" style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#b91c1c;margin:0 0 4px;font-weight:700;">0 transaksi akan dihapus</p>
        <p style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:#b91c1c;margin:0;line-height:1.6;">Semua riwayat pembayaran dan dokumen terkait akan ikut terhapus secara permanen.</p>
      </div>
    </div>

    <!-- Action buttons -->
    <div style="display:flex;gap:10px;">
      <button onclick="closeDeleteConfirm()" style="flex:1;padding:13px;border-radius:50px;border:1.5px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.4);backdrop-filter:blur(10px);font-family:'Outfit',sans-serif;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:0.06em;color:#333;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.8)'" onmouseout="this.style.background='rgba(255,255,255,0.4)'">
        Batal
      </button>
      <button onclick="submitDelete()" style="flex:1.5;padding:13px;border-radius:50px;border:none;background:rgba(239,68,68,0.9);backdrop-filter:blur(10px);font-family:'Outfit',sans-serif;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:0.06em;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background 0.2s;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='rgba(239,68,68,0.9)'">
        <i class="fa-solid fa-trash-can"></i> Ya, Hapus Sekarang
      </button>
    </div>
  </div>
</div>

<script>
  let selectModeActive = false;

  function toggleSelectMode() {
    selectModeActive = !selectModeActive;
    const list = document.getElementById('bookingsList');
    const selectAllWrap = document.getElementById('select-all-wrap');
    const headingLabel = document.getElementById('heading-label');
    const btnCancel = document.getElementById('btn-cancel-select');
    const btnToggle = document.getElementById('btn-toggle-select');

    if (selectModeActive) {
      list?.classList.add('select-mode-active');
      selectAllWrap?.classList.remove('hidden');
      selectAllWrap?.classList.add('flex');
      headingLabel?.classList.add('hidden');
      btnCancel?.classList.remove('hidden');
      btnCancel?.classList.add('flex');
      btnToggle?.classList.add('hidden');
      showActionBar();
    } else {
      list?.classList.remove('select-mode-active');
      selectAllWrap?.classList.add('hidden');
      selectAllWrap?.classList.remove('flex');
      headingLabel?.classList.remove('hidden');
      btnCancel?.classList.add('hidden');
      btnCancel?.classList.remove('flex');
      btnToggle?.classList.remove('hidden');
      hideActionBar();
      // Uncheck all
      document.querySelectorAll('.booking-checkbox').forEach(cb => cb.checked = false);
      document.querySelectorAll('.booking-card').forEach(c => c.classList.remove('selected'));
      document.getElementById('select-all-cb').checked = false;
      updateSelectedCount();
    }
  }

  function handleCardClick(event, bookingId, isDeletable) {
    if (!selectModeActive) return; // Normal mode: let default link handle it
    if (!isDeletable) return; // Can't select non-deletable

    const cb = document.getElementById('cb-' + bookingId);
    if (!cb) return;
    if (event.target === cb) return; // Let checkbox handle itself

    cb.checked = !cb.checked;
    updateSelectedCount();
  }

  function toggleSelectAll(masterCb) {
    const checkboxes = document.querySelectorAll('.booking-checkbox');
    checkboxes.forEach(cb => {
      cb.checked = masterCb.checked;
    });
    updateSelectedCount();
  }

  function updateSelectedCount() {
    const checked = document.querySelectorAll('.booking-checkbox:checked');
    const count = checked.length;
    const badge = document.getElementById('selected-count-badge');
    const barText = document.getElementById('bar-count-text');
    const modalText = document.getElementById('modal-count-text');
    const confirmBtn = document.getElementById('btn-confirm-delete');

    // Update badge
    if (count > 0) {
      badge?.classList.remove('hidden');
      badge.textContent = count + ' dipilih';
    } else {
      badge?.classList.add('hidden');
    }

    // Update bar text
    if (barText) barText.textContent = count + ' transaksi dipilih';
    if (modalText) modalText.textContent = count + ' transaksi akan dihapus';

    // Enable/disable delete button
    if (confirmBtn) {
      if (count > 0) {
        confirmBtn.style.opacity = '1';
        confirmBtn.style.pointerEvents = 'auto';
      } else {
        confirmBtn.style.opacity = '0.5';
        confirmBtn.style.pointerEvents = 'none';
      }
    }

    // Update card selected state
    document.querySelectorAll('.booking-checkbox').forEach(cb => {
      const card = document.getElementById('card-' + cb.value);
      if (card) {
        if (cb.checked) card.classList.add('selected');
        else card.classList.remove('selected');
      }
    });

    // Update master checkbox state
    const allCbs = document.querySelectorAll('.booking-checkbox');
    const masterCb = document.getElementById('select-all-cb');
    if (masterCb) {
      masterCb.checked = allCbs.length > 0 && checked.length === allCbs.length;
      masterCb.indeterminate = checked.length > 0 && checked.length < allCbs.length;
    }
  }

  function showActionBar() {
    const bar = document.getElementById('delete-action-bar');
    bar?.classList.add('visible');
  }

  function hideActionBar() {
    const bar = document.getElementById('delete-action-bar');
    bar?.classList.remove('visible');
  }

  function openDeleteConfirm() {
    const count = document.querySelectorAll('.booking-checkbox:checked').length;
    if (count === 0) return;
    updateSelectedCount();

    const modal = document.getElementById('delete-confirm-modal');
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';

    if (typeof anime !== 'undefined') {
      anime({
        targets: '#delete-confirm-box',
        opacity: [0, 1],
        scale: [0.88, 1],
        translateY: [-20, 0],
        easing: 'easeOutExpo',
        duration: 380
      });
    }
  }

  function closeDeleteConfirm() {
    const modal = document.getElementById('delete-confirm-modal');
    const box = document.getElementById('delete-confirm-box');
    if (typeof anime !== 'undefined') {
      anime({
        targets: box,
        opacity: [1, 0],
        scale: [1, 0.92],
        easing: 'easeInQuad',
        duration: 220,
        complete: () => {
          modal.classList.remove('open');
          document.body.style.overflow = '';
        }
      });
    } else {
      modal.classList.remove('open');
      document.body.style.overflow = '';
    }
  }

  function handleModalBackdropClick(event) {
    if (event.target === document.getElementById('delete-confirm-modal')) {
      closeDeleteConfirm();
    }
  }

  function submitDelete() {
    document.getElementById('delete-form').submit();
  }

  // ESC closes confirm modal
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const modal = document.getElementById('delete-confirm-modal');
      if (modal?.classList.contains('open')) closeDeleteConfirm();
      else if (selectModeActive) toggleSelectMode();
    }
  });
</script>
