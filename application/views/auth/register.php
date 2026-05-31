<!-- Premium Minimalist Register Card (Nothing OS & Framer Inspired) -->
<section class="max-w-md mx-auto px-4 py-16" data-aos="fade-up">
  <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 relative overflow-hidden shadow-sm stagger-card">
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>

    <!-- Header info -->
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center gap-2">
        <div class="w-3.5 h-3.5 opacity-35" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 3px 3px;"></div>
        <span class="text-[9px] font-mono text-[#888888] tracking-[0.2em] uppercase">CREATE ACCOUNT</span>
      </div>
      <span class="text-[9px] font-mono text-black dot-matrix font-bold blink-dot">● SIGN UP</span>
    </div>

    <!-- Title -->
    <div class="mb-8">
      <h2 class="font-display font-extrabold text-3xl text-black leading-none mb-2">REGISTER</h2>
      <p class="text-xs text-[#666666] font-sans">Buat akun untuk memulai pencarian dan pembelian unit mobil impian.</p>
    </div>

    <!-- Form -->
    <form action="<?php echo base_url('auth/register'); ?>" method="POST" class="space-y-5">
      
      <!-- Username -->
      <div class="flex flex-col gap-1.5">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Username</label>
        <div class="relative">
          <input type="text" name="username" required placeholder="Pilih username" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-at absolute right-4 top-3.5 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Full Name -->
      <div class="flex flex-col gap-1.5">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Nama Lengkap</label>
        <div class="relative">
          <input type="text" name="fullname" required placeholder="Nama sesuai KTP" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-signature absolute right-4 top-3.5 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Email -->
      <div class="flex flex-col gap-1.5">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Alamat Email</label>
        <div class="relative">
          <input type="email" name="email" required placeholder="contoh@domain.com" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-envelope absolute right-4 top-3.5 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Phone Number -->
      <div class="flex flex-col gap-1.5">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Nomor HP</label>
        <div class="relative">
          <input type="tel" name="phone" required placeholder="08xxxxxxxxxx" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-phone absolute right-4 top-3.5 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Password -->
      <div class="flex flex-col gap-1.5">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Password</label>
        <div class="relative">
          <input type="password" name="password" required placeholder="Buat password aman" 
                 class="w-full h-11 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-lock absolute right-4 top-3.5 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Action Button -->
      <button type="submit" 
              class="w-full h-14 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center font-bold text-xs tracking-widest uppercase mt-6 shadow-sm">
        Daftar Akun Baru
      </button>

    </form>

    <!-- Footer Links -->
    <div class="mt-8 pt-6 border-t border-[#EAEAEA] text-center">
      <p class="text-xs text-[#666666] font-sans">
        Sudah memiliki akun? 
        <a href="<?php echo base_url('auth/login'); ?>" class="text-black font-semibold hover:underline">Masuk &rsaquo;</a>
      </p>
    </div>

  </div>
</section>

<!-- Animation Script -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    anime({
      targets: '.stagger-card',
      scale: [0.96, 1],
      opacity: [0, 1],
      translateY: [20, 0],
      duration: 800,
      easing: 'easeOutExpo'
    });
  });
</script>
