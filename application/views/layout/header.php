<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'DRIVE.X - Premium Car Marketplace'; ?></title>
  <link rel="icon" type="image/webp" href="<?php echo base_url('uploads/images/logo.webp'); ?>">
  
  <!-- Tailwind CSS & Custom Theme Styling -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            display: ['Space Grotesk', 'sans-serif'],
            matrix: ['DotGothic16', 'monospace']
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/anime-theme.css'); ?>">
  
  <!-- Anime.js & AOS CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>
<style>
  :root {
    --glass-blur: 16px;
  }

  html {
    background-image: url('<?php echo base_url("assets/images/bg1.png"); ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    scroll-behavior: smooth;
  }
  
  /* Overlay putih untuk membuat background sedikit lebih terang */
  html::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.35);
    pointer-events: none;
    z-index: -1;
  }

  /* ===== Progressive Background Blur (Bottom Clear → Top Blurry) ===== */
  /* Layer 1: light blur covering top 50% */
  #bg-blur-layer-1 {
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    /* Mask: opaque at top, fades to transparent at middle */
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.7) 30%, rgba(0,0,0,0) 55%);
    mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.7) 30%, rgba(0,0,0,0) 55%);
  }
  /* Layer 2: medium blur, top 35% */
  #bg-blur-layer-2 {
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.6) 18%, rgba(0,0,0,0) 38%);
    mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.6) 18%, rgba(0,0,0,0) 38%);
  }
  /* Layer 3: strong blur, top 20% */
  #bg-blur-layer-3 {
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.4) 10%, rgba(0,0,0,0) 22%);
    mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.4) 10%, rgba(0,0,0,0) 22%);
  }
  /* Layer 4: max blur, very top */
  #bg-blur-layer-4 {
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0) 12%);
    mask-image: linear-gradient(to bottom, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0) 12%);
  }

  body {
    zoom: 0.8 !important;
    background-color: transparent !important;
  }
  
  /* Sempurnakan UI Landing Page dengan transparansi tipis */
  .bg-white {
    background-color: rgba(255, 255, 255, 0.95) !important;
  }
  .bg-\\[\\#F5F5F5\\] {
    background-color: rgba(245, 245, 245, 0.90) !important;
  }

  /* Apply dynamic glass blur globally to glassy elements */
  .backdrop-blur-xl, .backdrop-blur-md, .backdrop-blur-sm, 
  .glass-panel, .framer-card, .booking-card, .card,
  header.backdrop-blur-xl {
    backdrop-filter: blur(var(--glass-blur)) !important;
    -webkit-backdrop-filter: blur(var(--glass-blur)) !important;
    transition: backdrop-filter 0.3s ease, -webkit-backdrop-filter 0.3s ease;
  }

  .writing-mode-vertical {
    writing-mode: vertical-lr;
    text-orientation: mixed;
  }
</style>
<body class="min-h-screen text-[#111111] flex flex-col antialiased">

  <!-- Floating Blur Leveler Widget (Nothing OS Style) -->
  <div id="blur-leveler-widget" class="fixed right-6 top-1/2 -translate-y-1/2 z-[10000] flex flex-col items-center gap-3 bg-white/70 backdrop-blur-md border border-[#EAEAEA] rounded-full py-5 px-3 shadow-[0_16px_48px_rgba(0,0,0,0.06)] group transition-all duration-300 hover:border-black/30 hover:bg-white/80">
    <span class="text-[7px] font-mono font-bold text-neutral-400 uppercase tracking-widest writing-mode-vertical rotate-180 select-none">BLUR LEVEL</span>
    
    <!-- Visualizer stack representing the requested equalizer layout -->
    <div class="flex flex-col gap-1 items-center cursor-pointer py-1" id="blur-level-bars">
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 4px;" data-blur="0"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 6px;" data-blur="3"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 8px;" data-blur="6"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 10px;" data-blur="9"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 12px;" data-blur="12"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 16px;" data-blur="15"></div>
      <div class="blur-bar h-1 rounded-full bg-black transition-all" style="width: 20px;" data-blur="18"></div> <!-- Default peak -->
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 16px;" data-blur="21"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 12px;" data-blur="24"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 10px;" data-blur="27"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 8px;" data-blur="30"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 6px;" data-blur="33"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 4px;" data-blur="36"></div>
      <div class="blur-bar h-1 rounded-full bg-neutral-300 transition-all hover:bg-black" style="width: 3px;" data-blur="40"></div>
    </div>
    
    <span id="blur-val-indicator" class="text-[8px] font-mono font-bold text-black select-none">18px</span>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const bars = document.querySelectorAll('.blur-bar');
      const indicator = document.getElementById('blur-val-indicator');
      
      // Set initial values
      document.documentElement.style.setProperty('--glass-blur', '18px');
      
      bars.forEach(bar => {
        bar.addEventListener('click', function() {
          const val = this.getAttribute('data-blur');
          document.documentElement.style.setProperty('--glass-blur', val + 'px');
          
          // Reset all bars to inactive
          bars.forEach(b => {
            b.classList.remove('bg-black');
            b.classList.add('bg-neutral-300');
          });
          
          // Highlight current
          this.classList.remove('bg-neutral-300');
          this.classList.add('bg-black');
          
          if (indicator) {
            indicator.textContent = val + 'px';
          }
        });
      });
    });
  </script>

  <!-- Progressive Background Blur Layers (Bottom=Sharp, Top=Blurry) -->
  <div id="bg-blur-layer-1"></div>
  <div id="bg-blur-layer-2"></div>
  <div id="bg-blur-layer-3"></div>
  <div id="bg-blur-layer-4"></div>

  <!-- DRIVE.X Decorative Dot Matrix & Thin Grid Background Pattern -->
  <div class="anime-grid-bg"></div>
  <div class="thin-grid-lines"></div>

  <!-- Sticky Top Bar & Glassmorphic Navigation (Floating Capsule) -->
  <div class="sticky top-4 z-50 w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Apple & Framer Inspired Minimalist Navigation Header -->
    <header class="border border-white/40 bg-white/30 backdrop-blur-xl rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full transition-all">
      <div class="h-16 px-6 sm:px-8 flex items-center justify-between">
      
        <!-- Brand Logo DRIVE.X -->
        <a href="<?php echo base_url(); ?>" id="navbarLogoLink" class="flex items-center gap-3 group">
          <div id="navbarLogoContainer" class="relative flex items-center justify-center w-10 h-10 rounded-lg overflow-hidden border border-[#EAEAEA] bg-white p-0.5 transition-transform duration-300 hover:scale-105">
            <img src="<?php echo base_url('uploads/images/logo.webp'); ?>" alt="DRIVE.X Logo" class="w-full h-full object-contain">
          </div>
          <div class="flex flex-col">
            <span class="font-display font-bold text-lg tracking-tight text-black">DRIVE.X</span>
            <span class="text-[9px] font-mono tracking-widest text-[#666666] uppercase">[ Double Click to Zoom ]</span>
          </div>
        </a>

        <!-- Navigation Links (Monochrome & Framer Minimalist) -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
          <a href="<?php echo base_url('#beranda'); ?>" class="text-[#666666] hover:text-black tracking-tight transition-colors"><i class="fa-solid fa-house mr-1.5 text-xs text-[#999999]"></i>Beranda</a>
          <a href="<?php echo base_url('#katalog'); ?>" class="text-[#666666] hover:text-black tracking-tight transition-colors"><i class="fa-solid fa-car mr-1.5 text-xs text-[#999999]"></i>Beli Mobil</a>
          <a href="<?php echo base_url('#filter'); ?>" class="text-[#666666] hover:text-black tracking-tight transition-colors"><i class="fa-solid fa-filter mr-1.5 text-xs text-[#999999]"></i>Cari Mobil</a>
          <a href="<?php echo base_url('sourcing'); ?>" class="text-[#666666] hover:text-black tracking-tight transition-colors"><i class="fa-solid fa-tags mr-1.5 text-xs text-[#999999]"></i>Jual Mobil</a>
          
          <!-- Web Tour Trigger Button -->
          <button onclick="startWebTour()" class="text-[#666666] hover:text-black tracking-tight transition-colors outline-none cursor-pointer">
            <i class="fa-solid fa-circle-play mr-1.5 text-xs text-black blink-dot"></i>[ Start Tour ]
          </button>
          
          <?php if ($this->session->userdata('role') === 'client'): ?>
            <a href="<?php echo base_url('booking/dashboard'); ?>" class="text-black hover:text-black font-semibold tracking-tight transition-colors"><i class="fa-solid fa-gauge mr-2"></i>My Dashboard</a>
          <?php elseif (in_array($this->session->userdata('role'), array('admin', 'staff', 'manager'))): ?>
            <a href="<?php echo base_url('admin'); ?>" class="text-black hover:text-black font-semibold tracking-tight transition-colors"><i class="fa-solid fa-circle-nodes mr-2"></i>Admin Panel</a>
          <?php elseif ($this->session->userdata('role') === 'kurir'): ?>
            <a href="<?php echo base_url('admin/kurir'); ?>" class="text-black hover:text-black font-semibold tracking-tight transition-colors"><i class="fa-solid fa-truck-fast mr-2"></i>Portal Kurir</a>
          <?php endif; ?>
        </nav>

        <!-- CTA User Menu -->
        <div class="flex items-center gap-4">
          <?php if ($this->session->userdata('user_id')): ?>
            <div class="flex items-center gap-4">
              <div class="hidden sm:flex flex-col text-right">
                <span class="text-[10px] text-[#666666] font-mono leading-none mb-1">WELCOME,</span>
                <span class="text-xs font-semibold text-black leading-none"><?php echo $this->session->userdata('fullname'); ?></span>
              </div>
              <div class="w-9 h-9 rounded-full bg-[#F5F5F5] border border-[#EAEAEA] flex items-center justify-center text-black font-display font-bold text-xs">
                <?php echo strtoupper(substr($this->session->userdata('username'), 0, 1)); ?>
              </div>
              <a href="<?php echo base_url('auth/logout'); ?>" class="text-xs font-mono text-[#FF3B30] hover:text-red-700 tracking-tight font-semibold">
                [ LOGOUT ]
              </a>
            </div>
          <?php else: ?>
            <a href="<?php echo base_url('auth/login'); ?>" class="px-5 py-2.5 rounded-full border border-black bg-black text-white hover:bg-neutral-800 transition-all font-semibold text-xs tracking-tight uppercase">
              SIGN IN
            </a>
          <?php endif; ?>
        </div>

      </div>
    </header>
  </div>

  <!-- Main Workspace Wrapper -->
  <main class="flex-grow">
    
    <!-- Flash Messages Container -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-emerald-500/10 backdrop-blur-md border border-emerald-500/30 text-emerald-800 px-4 py-3.5 rounded-xl text-sm flex items-center gap-3 font-mono shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
          <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
          <span><?php echo $this->session->flashdata('success'); ?></span>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-red-500/10 backdrop-blur-md border border-red-500/30 text-red-800 px-4 py-3.5 rounded-xl text-sm flex items-center gap-3 font-mono shadow-[0_4px_15px_rgb(0,0,0,0.05)]">
          <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
          <span><?php echo $this->session->flashdata('error'); ?></span>
        </div>
      </div>
    <?php endif; ?>

  <!-- Logo Zoom Overlay -->
  <div id="logoZoomOverlay" class="fixed inset-0 z-[9999] bg-black/75 backdrop-blur-2xl opacity-0 pointer-events-none transition-all duration-500 flex items-center justify-center">
    <div class="relative max-w-sm sm:max-w-md p-6 bg-white/5 border border-white/10 rounded-[32px] shadow-[0_24px_50px_rgba(0,0,0,0.4)] scale-75 opacity-0 transition-all duration-500 ease-out" id="logoZoomCard">
      <button onclick="closeLogoZoom()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 border border-white/10 text-white flex items-center justify-center transition-all duration-300">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
      <div class="w-64 h-64 sm:w-80 sm:h-80 bg-white border border-white/20 rounded-2xl p-4 overflow-hidden flex items-center justify-center shadow-inner">
        <img src="<?php echo base_url('uploads/images/logo.webp'); ?>" alt="DRIVE.X Logo Zoomed" class="w-full h-full object-contain">
      </div>
      <div class="text-center mt-6">
        <h3 class="font-display font-bold text-xl text-white tracking-tight">DRIVE.X</h3>
        <p class="text-[9px] font-mono text-white/50 mt-1 uppercase tracking-widest">Premium Used Car Marketplace</p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const logoLink = document.getElementById('navbarLogoLink');
      const logoContainer = document.getElementById('navbarLogoContainer');
      let clickTimeout;

      if (logoLink && logoContainer) {
        logoLink.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          if (e.detail === 2) {
            // Double click: zoom in
            clearTimeout(clickTimeout);
            openLogoZoom();
          } else if (e.detail === 1) {
            // Single click: standard navigation after delay
            clickTimeout = setTimeout(function() {
              window.location.href = logoLink.getAttribute('href');
            }, 250);
          }
        });
      }

      // Close zoom overlay on background click
      const overlay = document.getElementById('logoZoomOverlay');
      if (overlay) {
        overlay.addEventListener('click', function(e) {
          if (e.target === this) {
            closeLogoZoom();
          }
        });
      }
    });

    function openLogoZoom() {
      const overlay = document.getElementById('logoZoomOverlay');
      const card = document.getElementById('logoZoomCard');
      if (overlay && card) {
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100');
        
        card.classList.remove('scale-75', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
      }
    }

    function closeLogoZoom() {
      const overlay = document.getElementById('logoZoomOverlay');
      const card = document.getElementById('logoZoomCard');
      if (overlay && card) {
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100');
        
        card.classList.add('scale-75', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
      }
    }

    // Escape key listener to close overlay
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeLogoZoom();
      }
    });
  </script>
