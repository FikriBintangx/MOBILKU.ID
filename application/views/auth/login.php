<!-- Premium Minimalist Login Card (Nothing OS & Framer Inspired) -->
<section class="max-w-md mx-auto px-4 pt-28 pb-20" data-aos="fade-up">
  <div class="bg-white border border-[#EAEAEA] rounded-[28px] p-8 relative overflow-hidden shadow-sm stagger-card">
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 14px 14px;"></div>

    <!-- Header info -->
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center gap-2">
        <div class="w-3.5 h-3.5 opacity-35" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 3px 3px;"></div>
        <span class="text-[9px] font-mono text-[#888888] tracking-[0.2em] uppercase">SYSTEM AUTH</span>
      </div>
      <span class="text-[9px] font-mono text-black dot-matrix font-bold blink-dot">● ONLINE</span>
    </div>

    <!-- Title -->
    <div class="mb-8">
      <h2 class="font-display font-extrabold text-3xl text-black leading-none mb-2">SIGN IN</h2>
      <p class="text-xs text-[#666666] font-sans">Akses portal kemudahan transaksi mobil premium Anda.</p>
    </div>

    <!-- Form -->
    <form action="<?php echo base_url('auth/login'); ?>" method="POST" class="space-y-6">
      
      <!-- Username -->
      <div class="flex flex-col gap-2">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Username</label>
        <div class="relative">
          <input type="text" name="username" required placeholder="Masukkan username Anda" 
                 class="w-full h-12 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-user absolute right-4 top-4 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Password -->
      <div class="flex flex-col gap-2">
        <label class="text-[9px] text-[#666666] font-mono tracking-wider uppercase font-semibold">Password</label>
        <div class="relative">
          <input type="password" name="password" required placeholder="Masukkan password Anda" 
                 class="w-full h-12 px-4 rounded-xl border border-[#DADADA] bg-white text-xs text-black focus:border-black focus:outline-none transition-colors font-sans">
          <i class="fa-solid fa-lock absolute right-4 top-4 text-[#999999] text-xs"></i>
        </div>
      </div>

      <!-- Action Button -->
      <button type="submit" 
              class="w-full h-14 rounded-full bg-black text-white hover:bg-neutral-800 transition-all flex items-center justify-center font-bold text-xs tracking-widest uppercase mt-6 shadow-sm">
        Masuk Ke Platform
      </button>

    </form>

    <!-- Footer Links -->
    <div class="mt-8 pt-6 border-t border-[#EAEAEA] text-center">
      <p class="text-xs text-[#666666] font-sans">
        Belum memiliki akun? 
        <a href="<?php echo base_url('auth/register'); ?>" class="text-black font-semibold hover:underline">Daftar Sekarang &rsaquo;</a>
      </p>
    </div>

    <!-- Quick Role Simulator Widget (Nothing OS Style) -->
    <div class="mt-8 pt-6 border-t border-dashed border-[#EAEAEA]">
      <span class="text-[9px] font-mono text-[#999999] tracking-[0.2em] uppercase block mb-4 text-center">Instan Simulator Peran</span>
      
      <form action="<?php echo base_url('mobil/login_sim'); ?>" method="POST" class="grid grid-cols-3 gap-2">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        
        <button type="submit" name="role" value="customer" class="py-2.5 px-3 rounded-xl border border-black bg-black text-white hover:bg-neutral-800 font-sans font-bold text-[9px] uppercase tracking-wider transition-all">
          <i class="fa-solid fa-user mr-1"></i> Customer
        </button>
        
        <button type="submit" name="role" value="admin" class="py-2.5 px-3 rounded-xl border border-[#DADADA] bg-white text-[#333] hover:bg-neutral-50 hover:border-black font-sans font-bold text-[9px] uppercase tracking-wider transition-all">
          <i class="fa-solid fa-user-gear mr-1"></i> Admin
        </button>

        <button type="submit" name="role" value="kurir" class="py-2.5 px-3 rounded-xl border border-[#DADADA] bg-white text-[#333] hover:bg-neutral-50 hover:border-black font-sans font-bold text-[9px] uppercase tracking-wider transition-all">
          <i class="fa-solid fa-truck-fast mr-1"></i> Kurir
        </button>
      </form>
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
