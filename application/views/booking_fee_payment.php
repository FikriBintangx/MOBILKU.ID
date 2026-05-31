<!-- Premium Booking Fee Payment Screen (Nothing OS & Framer Inspired) -->
<section class="max-w-2xl mx-auto px-4 py-16" data-aos="fade-up">
  <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 relative overflow-hidden shadow-sm stagger-card">
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>

    <!-- Header info -->
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center gap-2">
        <div class="w-3.5 h-3.5 opacity-35" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 3px 3px;"></div>
        <span class="text-[9px] font-mono text-[#888888] tracking-[0.2em] uppercase">SECURE PAYMENT</span>
      </div>
      <span class="text-[9px] font-mono text-black dot-matrix font-bold blink-dot">● BOOKING FEE</span>
    </div>

    <!-- Title & Car Info Summary -->
    <div class="mb-8 border-b border-[#EAEAEA] pb-6">
      <span class="text-[9px] font-mono text-[#999999] tracking-wider uppercase block mb-1">DETAIL KENDARAAN</span>
      <h2 class="font-display font-extrabold text-2xl text-black leading-none mb-4 uppercase">
        <?php echo $booking['brand']; ?> - <?php echo $booking['model']; ?>
      </h2>
      <div class="grid grid-cols-2 gap-4 text-xs font-mono text-[#666666] pt-2">
        <div>
          <span>KODE BOOKING:</span>
          <span class="text-black font-semibold uppercase block"><?php echo $booking['booking_code']; ?></span>
        </div>
        <div>
          <span>HARGA MOBIL (OTR):</span>
          <span class="text-black font-semibold block">Rp <?php echo number_format($booking['car_price'], 0, ',', '.'); ?>,-</span>
        </div>
      </div>
    </div>

    <!-- Payment Ticket Details -->
    <div class="bg-[#FAFAFA] border border-[#EAEAEA] rounded-[20px] p-6 mb-8">
      <div class="flex items-center gap-2.5 mb-4">
        <i class="fa-solid fa-receipt text-black"></i>
        <h3 class="text-xs font-mono tracking-widest text-black uppercase">Rincian Pembayaran Bukti Pesanan</h3>
      </div>
      <div class="flex justify-between items-center font-mono text-xs text-[#666666]">
        <span>JUMLAH BIAYA (FIXED):</span>
        <span class="text-black font-extrabold text-base">Rp 500.000,-</span>
      </div>
      <p class="text-[10px] text-[#999999] leading-relaxed mt-3 font-sans">
        *Booking fee ini diperlukan untuk mengunci ketersediaan unit mobil agar tidak dapat dipesan oleh pelanggan lain. Setelah diverifikasi, Anda memiliki waktu 1 minggu untuk melunasi Down Payment (DP) 30%.
      </p>
    </div>

    <!-- Form -->
    <form action="<?php echo base_url('booking/process_booking_fee/' . $booking['id']); ?>" method="POST" class="space-y-6">
      
      <!-- Payment Method -->
      <div class="flex flex-col gap-2">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Metode Pembayaran</label>
        <select name="method" required class="w-full h-12 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <option value="transfer">Transfer Bank (Verifikasi Instan)</option>
          <option value="ewallet">E-Wallet (QRIS / ShopeePay / GoPay)</option>
        </select>
      </div>

      <!-- Bank Details / Simulated Instruction -->
      <div onclick="window.copyTextToClipboard('8004567890', this)" class="copy-tooltip bg-[#F5F5F5] border border-[#EAEAEA] rounded-[20px] p-5 font-mono text-xs text-[#666666] space-y-2 hover:border-black transition-colors select-none">
        <span class="text-[9px] text-[#999999] tracking-wider uppercase font-semibold block mb-1">REKENING TUJUAN (KLIK UNTUK SALIN)</span>
        <div class="flex justify-between">
          <span>BANK / PROV:</span>
          <span class="text-black font-semibold">BANK CENTRAL ASIA (BCA)</span>
        </div>
        <div class="flex justify-between">
          <span>NOMOR REKENING:</span>
          <span class="text-black font-semibold"><i class="fa-solid fa-copy mr-1 text-xs text-neutral-400"></i> 800-456-7890</span>
        </div>
        <div class="flex justify-between">
          <span>ATAS NAMA:</span>
          <span class="text-black font-semibold">PT DRIVE X PLATFORM</span>
        </div>
      </div>

      <!-- Bank Sender Information Form -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="flex flex-col gap-2">
          <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Bank Pengirim</label>
          <input type="text" name="bank_name" id="bankNameInput" required placeholder="Contoh: BCA / Mandiri" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">No. Rekening Anda</label>
          <input type="text" name="bank_account" id="bankAccountInput" required placeholder="Nomor rekening Anda" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Nama Pemilik Rekening</label>
          <input type="text" name="bank_holder" id="bankHolderInput" required placeholder="Nama pengirim sesuai buku tabungan" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" id="paymentSubmitBtn" 
              class="w-full h-14 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center font-bold text-xs tracking-widest uppercase mt-6 gap-2 shadow-sm opacity-40 cursor-not-allowed pointer-events-none" disabled>
        <i class="fa-solid fa-lock text-[10px]"></i> Konfirmasi Pembayaran Instan
      </button>

    </form>

  </div>
</section>

<!-- Animation & Validation Script -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Entrance Animation
    anime({
      targets: '.stagger-card',
      scale: [0.97, 1],
      opacity: [0, 1],
      translateY: [20, 0],
      duration: 800,
      easing: 'easeOutExpo'
    });

    // Form inputs monitoring logic
    const bankName = document.getElementById('bankNameInput');
    const bankAccount = document.getElementById('bankAccountInput');
    const bankHolder = document.getElementById('bankHolderInput');
    const submitBtn = document.getElementById('paymentSubmitBtn');

    function validateForm() {
      const isNameFilled = bankName.value.trim() !== "";
      const isAccountFilled = bankAccount.value.trim() !== "";
      const isHolderFilled = bankHolder.value.trim() !== "";

      if (isNameFilled && isAccountFilled && isHolderFilled) {
        submitBtn.removeAttribute('disabled');
        submitBtn.classList.remove('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
      } else {
        submitBtn.setAttribute('disabled', 'true');
        submitBtn.classList.add('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
      }
    }

    // Restrict bank account field to digits only
    if (bankAccount) {
      bankAccount.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    }

    [bankName, bankAccount, bankHolder].forEach(input => {
      if (input) {
        input.addEventListener('input', validateForm);
      }
    });

    // Run once on load
    validateForm();
  });
</script>
