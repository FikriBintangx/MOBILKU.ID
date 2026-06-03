<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'DRIVE.X - Premium Car Marketplace'; ?></title>
  
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
  body {
    background-image: url('<?php echo base_url("assets/images/bg1.png"); ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  
  /* Overlay putih untuk membuat background sedikit lebih terang */
  body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.35); /* Agak memutih */
    pointer-events: none;
    z-index: -1;
  }
  
  /* Sempurnakan UI Landing Page dengan transparansi tipis (TANPA BLUR) */
  .bg-white {
    background-color: rgba(255, 255, 255, 0.95) !important;
  }
  .bg-\\[\\#F5F5F5\\] {
    background-color: rgba(245, 245, 245, 0.90) !important;
  }
</style>
<body class="min-h-screen text-[#111111] flex flex-col antialiased">

  <!-- DRIVE.X Decorative Dot Matrix & Thin Grid Background Pattern -->
  <div class="anime-grid-bg"></div>
  <div class="thin-grid-lines"></div>

  <!-- Sticky Top Bar & Glassmorphic Navigation (Floating Capsule) -->
  <div class="sticky top-4 z-50 w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Apple & Framer Inspired Minimalist Navigation Header -->
    <header class="border border-white/40 bg-white/30 backdrop-blur-xl rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full transition-all">
      <div class="h-16 px-6 sm:px-8 flex items-center justify-between">
      
        <!-- Brand Logo DRIVE.X -->
        <a href="<?php echo base_url(); ?>" class="flex items-center gap-3 group">
          <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-black border border-black p-0.5 overflow-hidden">
            <div class="font-display font-bold text-lg text-white">
              D
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-display font-bold text-lg tracking-tight text-black">DRIVE.X</span>
            <span class="text-[9px] font-mono tracking-widest text-[#666666] uppercase">Premium Marketplace</span>
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
