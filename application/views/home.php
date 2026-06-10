<?php
// DRIVE.X Home View - Premium Car Marketplace
// Hero with dynamic product card slider from DB + filter + catalog grid
?>
<!-- DRIVE.X Hero Section with Dynamic Product Card Slider -->
<section id="beranda" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative" data-aos="fade-down">

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative py-8">

    <!-- LEFT: Typography + CTAs -->
    <div class="lg:col-span-5 lg:col-start-1 space-y-6 stagger-item z-10 bg-white/30 backdrop-blur-xl border border-white/50 rounded-[32px] p-6 lg:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-md mx-auto lg:mx-0 -translate-y-4 lg:-translate-y-8">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-black/20 bg-white/60 backdrop-blur-md text-[9px] font-mono tracking-wider text-black font-semibold">
        <i class="fa-solid fa-dot-circle blink-dot text-[7px] text-black"></i> DRIVE.X PLATFORM
      </div>

      <h1 class="text-4xl sm:text-6xl font-display font-extrabold tracking-tighter text-black leading-[0.95]" id="heroTitle">
        Find The Next<br>
        Generation Car
      </h1>

      <p class="text-xs sm:text-sm text-black/80 font-medium leading-relaxed font-sans">
        Eksplorasi koleksi mobil premium pilihan dengan pengalaman transaksi digital kelas dunia. Rasakan kemudahan, keamanan, dan eksklusivitas dalam satu platform terintegrasi.
      </p>

      <div class="flex flex-wrap items-center gap-3 pt-1">
        <a href="#katalog" class="btn-premium px-6 py-3 text-xs uppercase tracking-wider font-semibold rounded-full bg-black text-white hover:bg-neutral-800 transition-all shadow-lg">
          [ Browse Cars ]
        </a>
        <a href="#filter" class="btn-secondary-premium px-6 py-3 text-xs uppercase tracking-wider font-bold rounded-full bg-white/50 backdrop-blur-md border border-black text-black hover:bg-white/80 transition-all">
          Filter Search
        </a>
      </div>

      <!-- Live stats ticker -->
      <div class="flex items-center gap-6 pt-3 border-t border-black/10">
        <div>
          <span class="text-black font-display font-bold text-xl block leading-none"><?php echo count($cars); ?></span>
          <span class="text-[8px] font-mono text-black font-bold uppercase tracking-widest">Unit Tersedia</span>
        </div>
        <div class="w-px h-8 bg-black/10"></div>
        <div>
          <span class="text-black font-display font-bold text-xl block leading-none"><?php echo count($brands); ?></span>
          <span class="text-[8px] font-mono text-black font-bold uppercase tracking-widest">Brand</span>
        </div>
        <div class="w-px h-8 bg-black/10"></div>
        <div>
          <span class="text-black font-display font-bold text-xl block leading-none dot-matrix blink-dot">●</span>
          <span class="text-[8px] font-mono text-black font-bold uppercase tracking-widest">Live</span>
        </div>
      </div>
    </div>

    <!-- RIGHT: Dynamic Product Card Slider from Database -->
    <div class="lg:col-span-7 flex flex-col items-center lg:items-end justify-center stagger-item z-10" id="heroVisualizer">
      <div class="relative w-full max-w-[340px]" id="carSliderWrapper">

        <!-- Slide Track -->
        <div id="carSliderTrack" class="relative" style="min-height: 470px;">
          <?php
            $sliderCars = array_slice($cars, 0, 6);
            if (empty($sliderCars)) {
              $sliderCars = [
                ['id'=>0,'brand'=>'Toyota','model'=>'Fortuner VRZ 2.4','type'=>'SUV','year'=>2022,'price'=>520000000,'color'=>'Putih Pearl','plate_number'=>'B 1234 ABC','status'=>'available','image_url'=>''],
                ['id'=>0,'brand'=>'Honda','model'=>'Civic RS Turbo','type'=>'Sedan','year'=>2023,'price'=>395000000,'color'=>'Hitam Metalik','plate_number'=>'B 5678 DEF','status'=>'available','image_url'=>''],
                ['id'=>0,'brand'=>'Mitsubishi','model'=>'Xpander Cross','type'=>'MPV','year'=>2022,'price'=>285000000,'color'=>'Silver','plate_number'=>'B 7777 GHI','status'=>'available','image_url'=>''],
              ];
            }
          ?>

          <?php foreach ($sliderCars as $si => $sc):
            $priceM      = floatval($sc['price']) / 1000000;
            $mockPower   = round(150 + ($priceM * 0.35));
            $mockSpeed   = round(180 + ($priceM * 0.12));
            $mock0100    = number_format(max(3.2, 11.5 - ($priceM * 0.008)), 1);
            $typeLC      = strtolower($sc['type']);
          ?>
          <div class="car-slide" data-index="<?php echo $si; ?>"
               style="position: absolute; top:0; left:0; width:100%; opacity: <?php echo $si===0 ? '1' : '0'; ?>; pointer-events: <?php echo $si===0 ? 'auto' : 'none'; ?>; z-index: <?php echo $si===0 ? '10' : '1'; ?>;">

            <!-- Premium Product Card (Frosted Glass) -->
            <div class="bg-white/40 backdrop-blur-xl border border-white/60 rounded-[32px] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative group">
              <!-- Dot matrix overlay -->
              <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(#000 0.7px, transparent 0.7px); background-size: 13px 13px; opacity: 0.022;"></div>

              <!-- HEADER: Brand · Year -->
              <div class="flex justify-between items-center px-5 pt-5 pb-3">
                <div class="flex items-center gap-2">
                  <div class="w-3 h-3 opacity-40" style="background-image: radial-gradient(#555 1px, transparent 1px); background-size: 3.5px 3.5px;"></div>
                  <span class="text-[9px] font-mono text-[#888] uppercase tracking-[0.18em]"><?php echo strtoupper($sc['brand']); ?></span>
                </div>
                <span class="text-[9px] font-mono text-black dot-matrix font-semibold blink-dot">● <?php echo $sc['year']; ?></span>
              </div>

              <!-- SUBHEADER: Model Name + OTR Price -->
              <div class="grid grid-cols-2 items-start px-5 pb-3">
                <div>
                  <p class="text-[7px] font-mono text-[#AAAAAA] tracking-[0.18em] uppercase mb-0.5">MODEL</p>
                  <h3 class="font-display font-extrabold text-[18px] text-black leading-none tracking-tight uppercase"><?php echo strtoupper($sc['brand']); ?>-<?php echo strtoupper(strtok($sc['model'], ' ')); ?></h3>
                  <p class="text-[8px] font-mono text-[#AAAAAA] mt-1 uppercase tracking-widest"><?php echo strtoupper($sc['type']); ?></p>
                </div>
                <div class="text-right">
                  <p class="text-[7px] font-mono text-[#AAAAAA] tracking-[0.18em] uppercase mb-0.5">OTR PRICE</p>
                  <span class="font-matrix font-bold text-[22px] text-black tracking-wider">Rp <?php echo number_format($sc['price']/1000000, 0, ',', '.'); ?>M</span>
                </div>
              </div>

              <!-- CAR VISUAL with matrix column right side -->
              <div class="relative mx-4 mb-3 h-[168px] rounded-[18px] overflow-hidden flex items-center justify-center">
                <!-- Dot column right decoration -->
                <div class="absolute right-3 inset-y-0 flex flex-col justify-center gap-[6px] pointer-events-none">
                  <?php for($d=0;$d<9;$d++): $op=0.15+($d*0.07); if($op>0.8)$op=0.8; ?>
                  <div style="width:6px;height:6px;border-radius:50%;background:#CCCCCC;opacity:<?php echo $op; ?>;"></div>
                  <?php endfor; ?>
                </div>

                <?php if (!empty($sc['image_url'])): ?>
                  <img src="<?php echo base_url('uploads/'.$sc['image_url']); ?>"
                       alt="<?php echo $sc['brand'].' '.$sc['model']; ?>"
                       class="h-32 w-auto object-contain transform group-hover:scale-105 transition-transform duration-700 drop-shadow-2xl mix-blend-darken">
                <?php elseif (strpos($typeLC,'suv')!==false || strpos($typeLC,'mpv')!==false || strpos($typeLC,'multi')!==false): ?>
                  <!-- SUV / MPV: higher roofline -->
                  <svg viewBox="0 0 220 110" class="w-52 h-28 transform group-hover:scale-105 transition-transform duration-700 drop-shadow-sm">
                    <path d="M 18,80 L 30,80 A 14,14 0 0,1 58,80 L 162,80 A 14,14 0 0,1 190,80 L 200,80 L 198,70 C 193,56 182,40 164,33 L 118,28 C 98,25 76,27 58,34 C 40,41 28,57 20,68 Z" fill="none" stroke="#111" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round"/>
                    <rect x="64" y="30" width="90" height="36" rx="6" fill="none" stroke="rgba(0,0,0,0.1)" stroke-width="1"/>
                    <circle cx="44" cy="80" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="44" cy="80" r="5" fill="#111"/>
                    <circle cx="176" cy="80" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="176" cy="80" r="5" fill="#111"/>
                    <line x1="20" y1="65" x2="200" y2="65" stroke="rgba(0,0,0,0.07)" stroke-width="1.2" stroke-dasharray="3 5"/>
                  </svg>
                <?php elseif (strpos($typeLC,'sport')!==false || strpos($typeLC,'coupe')!==false || strpos($typeLC,'cabrio')!==false): ?>
                  <!-- Sports / Coupe: low sleek roofline -->
                  <svg viewBox="0 0 220 110" class="w-52 h-28 transform group-hover:scale-105 transition-transform duration-700 drop-shadow-sm">
                    <path d="M 12,80 L 26,80 A 14,14 0 0,1 54,80 L 166,80 A 14,14 0 0,1 194,80 L 208,80 L 204,70 C 198,54 184,42 164,36 C 140,28 106,26 86,32 C 66,38 50,52 32,66 L 16,78 Z" fill="none" stroke="#111" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round"/>
                    <circle cx="40" cy="80" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="40" cy="80" r="5" fill="#111"/>
                    <circle cx="180" cy="80" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="180" cy="80" r="5" fill="#111"/>
                    <line x1="14" y1="68" x2="208" y2="68" stroke="rgba(0,0,0,0.07)" stroke-width="1.2" stroke-dasharray="2 5"/>
                  </svg>
                <?php else: ?>
                  <!-- Sedan / Hatchback: standard proportions -->
                  <svg viewBox="0 0 220 110" class="w-52 h-28 transform group-hover:scale-105 transition-transform duration-700 drop-shadow-sm">
                    <path d="M 14,78 L 28,78 A 13,13 0 0,1 54,78 L 166,78 A 13,13 0 0,1 192,78 L 206,78 L 204,69 C 200,57 190,45 174,38 C 154,30 126,28 106,30 C 82,32 62,40 46,54 C 34,64 22,72 16,76 Z" fill="none" stroke="#111" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round"/>
                    <rect x="58" y="31" width="96" height="32" rx="6" fill="none" stroke="rgba(0,0,0,0.1)" stroke-width="1.1"/>
                    <circle cx="41" cy="78" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="41" cy="78" r="5" fill="#111"/>
                    <circle cx="179" cy="78" r="13" fill="none" stroke="#111" stroke-width="1.6"/>
                    <circle cx="179" cy="78" r="5" fill="#111"/>
                    <line x1="16" y1="66" x2="206" y2="66" stroke="rgba(0,0,0,0.07)" stroke-width="1.2" stroke-dasharray="2 5"/>
                  </svg>
                <?php endif; ?>
              </div>

              <!-- SPECS ROW: 3 columns -->
              <div class="grid grid-cols-3 border-t border-[#F0F0F0]">
                <div class="px-4 py-3 border-r border-[#F0F0F0]">
                  <p class="text-[7px] font-mono text-[#AAAAAA] tracking-[0.15em] uppercase mb-1">POWER</p>
                  <div class="flex items-baseline gap-1">
                    <span class="font-matrix font-bold text-[18px] text-black leading-none"><?php echo $mockPower; ?></span>
                    <span class="text-[8px] font-mono text-[#AAAAAA]">HP</span>
                  </div>
                </div>
                <div class="px-4 py-3 border-r border-[#F0F0F0]">
                  <p class="text-[7px] font-mono text-[#AAAAAA] tracking-[0.15em] uppercase mb-1">TOP SPEED</p>
                  <div class="flex items-baseline gap-1">
                    <span class="font-matrix font-bold text-[18px] text-black leading-none"><?php echo $mockSpeed; ?></span>
                    <span class="text-[8px] font-mono text-[#AAAAAA]">KM/H</span>
                  </div>
                </div>
                <div class="px-4 py-3">
                  <p class="text-[7px] font-mono text-[#AAAAAA] tracking-[0.15em] uppercase mb-1">0-100 KM/H</p>
                  <div class="flex items-baseline gap-1">
                    <span class="font-matrix font-bold text-[18px] text-black leading-none"><?php echo $mock0100; ?></span>
                    <span class="text-[8px] font-mono text-[#AAAAAA]">SEC</span>
                  </div>
                </div>
              </div>

              <!-- FOOTER: Status + Dial Track -->
              <div class="flex items-center justify-between px-5 py-4 border-t border-[#F0F0F0]">
                <div>
                  <div class="flex items-center gap-1 mb-1">
                    <div class="w-3 h-px bg-[#CCCCCC]"></div>
                    <span class="text-[7px] font-mono text-[#AAAAAA] uppercase tracking-[0.15em]">STATUS</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <?php if ($sc['status'] === 'booked'): ?>
                      <span class="w-2 h-2 rounded-full bg-blue-500 inline-block blink-dot"></span>
                      <span class="font-mono font-bold text-blue-600 text-[10px] tracking-widest uppercase">BOOKED</span>
                    <?php else: ?>
                      <span class="w-2 h-2 rounded-full bg-black inline-block blink-dot"></span>
                      <span class="font-mono font-bold text-black text-[10px] tracking-widest uppercase">AVAILABLE</span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-1.5">
                  <span class="text-[7px] font-mono text-[#AAAAAA] uppercase tracking-[0.15em]">DIAL TRACK</span>
                  <div class="flex gap-1.5">
                    <?php for($d=0;$d<count($sliderCars);$d++): ?>
                    <span class="w-2 h-2 rounded-full <?php echo $d===$si ? 'bg-black' : 'bg-[#DDDDDD]'; ?> transition-all duration-300"></span>
                    <?php endfor; ?>
                    <?php for($d=count($sliderCars);$d<10;$d++): ?>
                    <span class="w-2 h-2 rounded-full bg-[#EEEEEE] opacity-50"></span>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>



            </div>
          </div>
          <?php endforeach; ?>
        </div><!-- end sliderTrack -->

        <!-- Navigation Controls (Frosted Glass) -->
        <div class="flex items-center justify-center gap-3 -mt-6 px-1 relative z-20">
          <button onclick="changeSlide(-1)" class="w-8 h-8 rounded-full border border-white/60 text-black bg-white/40 backdrop-blur-xl hover:bg-white/60 hover:scale-105 transition-all flex items-center justify-center shadow-[0_4px_20px_rgb(0,0,0,0.08)]">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
          </button>
          <div class="flex items-center gap-1.5 bg-white/30 backdrop-blur-xl border border-white/50 px-2.5 py-1.5 rounded-full shadow-[0_4px_20px_rgb(0,0,0,0.08)]" id="globalDotNav">
            <?php foreach ($sliderCars as $si => $sc): ?>
            <button onclick="goToSlide(<?php echo $si; ?>)" class="slide-nav-dot rounded-full transition-all duration-300 h-1 <?php echo $si===0 ? 'bg-black' : 'bg-white/70 hover:bg-black/50'; ?>" style="width: <?php echo $si===0 ? '16px' : '4px'; ?>"></button>
            <?php endforeach; ?>
          </div>
          <button onclick="changeSlide(1)" class="w-8 h-8 rounded-full border border-white/60 text-black bg-white/40 backdrop-blur-xl hover:bg-white/60 hover:scale-105 transition-all flex items-center justify-center shadow-[0_4px_20px_rgb(0,0,0,0.08)]">
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
          </button>
        </div>

      </div><!-- end sliderWrapper -->
    </div><!-- end heroVisualizer -->
  </div>
</section>

<!-- Car Product Slider Script -->
<script>
(function(){
  const slides = document.querySelectorAll('.car-slide');
  const navDots = document.querySelectorAll('.slide-nav-dot');
  let current = 0;
  let autoTimer = null;
  const total = slides.length;
  if (!total) return;

  function showSlide(idx, direction = 1, instant = false) {
    current = idx;
    const prevIdx = (idx - 1 + total) % total;
    const nextIdx = (idx + 1) % total;

    navDots.forEach(function(dot, i) {
      if (i === idx) {
        dot.classList.remove('bg-white/70', 'hover:bg-black/50');
        dot.classList.add('bg-black');
        dot.style.width = '24px';
      } else {
        dot.classList.remove('bg-black');
        dot.classList.add('bg-white/70', 'hover:bg-black/50');
        dot.style.width = '8px';
      }
    });

    slides.forEach(function(s, i) {
      const card = s.firstElementChild;
      anime.remove(s);
      anime.remove(card);
      
      const isHidden = s.style.display === 'none' || card.style.opacity === '0' || s.style.opacity === '0';
      const dur = instant ? 0 : 800;
      const ease = 'easeOutExpo';

      // Wrapper must not have opacity or transform to preserve blur
      s.style.opacity = '1';
      s.style.transform = 'none';

      if (i === idx) {
        // Active Slide (Center)
        if (isHidden) card.style.transform = `translateX(${direction > 0 ? '60%' : '-60%'}) scale(0.85)`;
        s.style.display = 'block';
        s.style.zIndex = '10';
        s.style.pointerEvents = 'auto';
        
        anime({
          targets: card,
          translateX: '0%',
          scale: 1,
          opacity: 1,
          duration: dur,
          easing: ease
        });

        // Stagger inner elements only on active slide
        if (!instant) {
          const title = s.querySelector('h3');
          const visual = s.querySelector('.relative.mx-4.mb-3');
          if (title) anime({ targets: title, opacity: [0, 1], translateY: [8, 0], duration: 400, delay: 100, easing: 'easeOutQuad' });
          if (visual) anime({ targets: visual, opacity: [0, 1], scale: [0.9, 1], duration: 600, delay: 150, easing: 'easeOutExpo' });
        }
      } else if (i === prevIdx) {
        // Prev Slide (Left)
        if (isHidden) card.style.transform = `translateX(-100%) scale(0.7)`;
        s.style.display = 'block';
        s.style.zIndex = '5';
        s.style.pointerEvents = 'none';
        
        anime({
          targets: card,
          translateX: '-70%',
          scale: 0.72,
          opacity: 1, // Keep opacity 1 to preserve blur
          duration: dur,
          easing: ease
        });
      } else if (i === nextIdx) {
        // Next Slide (Right)
        if (isHidden) card.style.transform = `translateX(100%) scale(0.7)`;
        s.style.display = 'block';
        s.style.zIndex = '5';
        s.style.pointerEvents = 'none';
        
        anime({
          targets: card,
          translateX: '70%',
          scale: 0.72,
          opacity: 1, // Keep opacity 1 to preserve blur
          duration: dur,
          easing: ease
        });
      } else {
        // Hidden Slides
        s.style.zIndex = '1';
        s.style.pointerEvents = 'none';
        
        anime({
          targets: card,
          opacity: 0,
          scale: 0.7,
          duration: dur,
          easing: ease,
          complete: function() {
            if (current !== i && i !== prevIdx && i !== nextIdx) {
              s.style.display = 'none';
            }
          }
        });
      }
    });

    // Animate Dot navigation indicator width & background beautifully
    navDots.forEach(function(d, i) {
      anime.remove(d);
      if (i === idx) {
        anime({
          targets: d,
          width: ['4px', '16px'],
          backgroundColor: '#000000',
          duration: 350,
          easing: 'easeOutQuad'
        });
      } else if (d.style.width === '16px' || d.classList.contains('bg-black')) {
        anime({
          targets: d,
          width: ['16px', '4px'],
          backgroundColor: '#DADADA',
          duration: 350,
          easing: 'easeOutQuad'
        });
      } else {
        d.style.width = '4px';
        d.style.backgroundColor = '#DADADA';
      }
    });
  }

  window.changeSlide = function(dir) {
    clearInterval(autoTimer);
    const nextIdx = (current + dir + total) % total;
    showSlide(nextIdx, dir);
    startAuto();
  };
  
  window.goToSlide = function(idx) {
    if (idx === current) return;
    clearInterval(autoTimer);
    const dir = idx > current ? 1 : -1;
    showSlide(idx, dir);
    startAuto();
  };
  
  function startAuto() {
    autoTimer = setInterval(function() {
      const nextIdx = (current + 1) % total;
      showSlide(nextIdx, 1);
    }, 120000); // 2 menit
  }
  
  // Initialize first slide on load with CoverFlow effect
  showSlide(0, 1, true);

  // Restart auto on hover out
  const wrapper = document.getElementById('carSliderWrapper');
  if(wrapper) {
      wrapper.addEventListener('mouseenter', () => clearInterval(autoTimer));
      wrapper.addEventListener('mouseleave', () => startAuto());
  }
  
  if (total > 1) startAuto();

  // Hero title and visualizer entry animations
  anime({
    targets: '#heroTitle',
    translateY: [50, 0],
    opacity: [0, 1],
    filter: ['blur(8px)', 'blur(0px)'],
    duration: 1000,
    easing: 'easeOutExpo',
    delay: 200
  });
  
  anime({
    targets: '#heroVisualizer',
    scale: [0.93, 1],
    opacity: [0, 1],
    duration: 1000,
    easing: 'easeOutExpo',
    delay: 400
  });
})();
</script>

<!-- Advanced Framer Style Filter Control -->
<section id="filter" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" data-aos="fade-up">
  <div class="bg-[#F5F5F5] border border-[#EAEAEA] rounded-[28px] p-6 sm:p-8">
    <div class="flex items-center gap-2.5 mb-6">
      <i class="fa-solid fa-sliders text-black"></i>
      <h3 class="text-xs font-mono tracking-widest text-black uppercase">Filter Kriteria Kendaraan</h3>
    </div>

    <form id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
      <!-- Brand Selection -->
      <div class="flex flex-col gap-2">
        <label class="text-[10px] text-[#666666] font-mono tracking-wider uppercase">Merk Mobil</label>
        <select id="filterBrand" class="cyber-input text-xs">
          <option value="">Semua Merk</option>
          <?php foreach ($brands as $b): ?>
            <option value="<?php echo $b['brand']; ?>"><?php echo $b['brand']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Type Selection -->
      <div class="flex flex-col gap-2">
        <label class="text-[10px] text-[#666666] font-mono tracking-wider uppercase">Tipe Bodi</label>
        <select id="filterType" class="cyber-input text-xs">
          <option value="">Semua Tipe</option>
          <?php foreach ($types as $t): ?>
            <option value="<?php echo $t['type']; ?>"><?php echo $t['type']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Maximum Price -->
      <div class="flex flex-col gap-2">
        <label class="text-[10px] text-[#666666] font-mono tracking-wider uppercase">Harga Maksimum</label>
        <select id="filterPrice" class="cyber-input text-xs">
          <option value="0">Semua Harga</option>
          <option value="250000000">Di bawah 250 Juta</option>
          <option value="350000000">Di bawah 350 Juta</option>
          <option value="500000000">Di bawah 500 Juta</option>
        </select>
      </div>

      <!-- Keyword Search -->
      <div class="flex flex-col gap-2 lg:col-span-2">
        <label class="text-[10px] text-[#666666] font-mono tracking-wider uppercase">Cari Kata Kunci</label>
        <div class="relative search-bar-container group">
          <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass search-icon text-[#999999] text-xs transition-colors duration-300"></i>
          </div>
          <input type="text" id="filterSearch" placeholder="Cari Civic, Avanza, Fortuner..." class="w-full cyber-input text-xs pl-10 pr-10 transition-all duration-300 focus:shadow-[0_8px_30px_rgba(0,0,0,0.06)]" autocomplete="off">
          <button type="button" id="clearSearchBtn" class="absolute inset-y-0 right-4 flex items-center text-[#999999] hover:text-black opacity-0 pointer-events-none transition-all duration-200">
            <i class="fa-solid fa-circle-xmark text-xs"></i>
          </button>
          
          <!-- Floating Suggestions Box -->
          <div id="searchSuggestions" class="absolute left-0 right-0 mt-2 bg-white/95 backdrop-blur-md border border-[#EAEAEA] rounded-2xl shadow-[0_12px_40px_rgba(0,0,0,0.08)] overflow-hidden hidden z-50 transition-all duration-300">
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- Cars Catalog Grid Section (Framer & Nothing OS 3-Column layout) -->
<section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32" data-aos="fade-up">
  <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#EAEAEA]">
    <div class="flex items-center gap-3 flex-wrap">
      <i class="fa-solid fa-cube text-black"></i>
      <h3 class="font-display font-bold text-lg text-black">DAFTAR KATALOG AKTIF</h3>
      <span class="text-[10px] font-mono text-[#666666] bg-white border border-[#EAEAEA] px-3 py-1 rounded-full shadow-[0_2px_10px_rgba(0,0,0,0.02)]" id="carsCount">Menampilkan <?php echo count($cars); ?> unit</span>
    </div>
  </div>

  <!-- Responsive grid layout -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="catalogGrid">
    <?php foreach ($cars as $car): ?>

      <!-- Premium Framer-style card with 28px radius -->
      <div class="framer-card overflow-hidden flex flex-col justify-between stagger-card relative group p-6">

        <!-- Subtle scan overlay -->
        <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>

        <!-- Header: Year & Type in Dot Matrix Font -->
        <div class="flex justify-between items-center mb-6 text-xs font-mono">
          <span class="text-black dot-matrix font-semibold"><?php echo $car['year']; ?></span>
          <span class="px-2.5 py-0.5 rounded-full bg-[#F5F5F5] text-[9px] text-[#666666] tracking-wider uppercase font-semibold"><?php echo $car['type']; ?></span>
        </div>

        <!-- Middle: Car Image or Wireframe Visualizer -->
        <div class="relative w-full h-40 bg-[#F5F5F5] rounded-[18px] flex items-center justify-center overflow-hidden border border-[#EAEAEA] mb-6">
          <?php if (!empty($car['image_url'])): ?>
            <img src="<?php echo base_url('uploads/'.$car['image_url']); ?>" alt="<?php echo $car['brand'].' '.$car['model']; ?>" class="h-32 w-auto object-contain transform group-hover:scale-105 transition-transform duration-500 drop-shadow-sm">
          <?php else: ?>
            <i class="fa-solid fa-car-side text-black/10 text-7xl transform group-hover:scale-105 transition-transform duration-500"></i>
          <?php endif; ?>
        </div>

        <!-- Footer specs info -->
        <div class="flex-grow space-y-4">
          <div>
            <span class="text-[9px] font-mono text-[#999999] uppercase tracking-wider block mb-1"><?php echo $car['brand']; ?></span>
            <h4 class="font-display font-bold text-base text-black leading-tight"><?php echo $car['model']; ?></h4>
          </div>

          <div class="grid grid-cols-2 gap-4 border-t border-[#EAEAEA] pt-4 text-[10px] font-mono">
            <div>
              <span class="text-[#999999] block text-[8px] uppercase">NOPOL</span>
              <span class="text-black font-semibold uppercase"><?php echo $car['plate_number']; ?></span>
            </div>
            <div>
              <span class="text-[#999999] block text-[8px] uppercase">STATUS</span>
              <?php if ($car['status'] === 'booked'): ?>
                <span class="text-blue-600 font-semibold dot-matrix blink-dot">● BOOKED</span>
              <?php else: ?>
                <span class="text-black font-semibold dot-matrix blink-dot">● AVAILABLE</span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Buy / Details trigger block -->
        <div class="mt-6 pt-4 border-t border-[#EAEAEA] flex items-center justify-between">
          <div class="flex flex-col">
            <span class="text-[8px] font-mono text-[#999999] uppercase">OTR PRICE</span>
            <span class="font-display font-bold text-sm text-black">Rp <?php echo number_format($car['price'], 0, ',', '.'); ?>,-</span>
          </div>
          <a href="<?php echo base_url('mobil/detail/' . $car['id']); ?>" class="px-5 py-2.5 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-semibold text-xs tracking-tight uppercase">
            Detail
          </a>
        </div>

      </div>

    <?php endforeach; ?>
  </div>
</section>

<!-- Homepage Animation & Filter Scripts -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Setup AJAX grid filtering
    const filterBrand  = document.getElementById('filterBrand');
    const filterType   = document.getElementById('filterType');
    const filterPrice  = document.getElementById('filterPrice');
    const filterSearch = document.getElementById('filterSearch');
    const catalogGrid  = document.getElementById('catalogGrid');
    const carsCount    = document.getElementById('carsCount');

    [filterBrand, filterType, filterPrice].forEach(el => el && el.addEventListener('change', runFilter));
    
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    if (filterSearch) {
      filterSearch.addEventListener('input', debounce(runFilter, 300));
      filterSearch.addEventListener('input', function() {
        if (this.value.length > 0) {
          clearSearchBtn.classList.remove('opacity-0', 'pointer-events-none');
          clearSearchBtn.classList.add('opacity-100', 'pointer-events-auto');
        } else {
          clearSearchBtn.classList.remove('opacity-100', 'pointer-events-auto');
          clearSearchBtn.classList.add('opacity-0', 'pointer-events-none');
        }
      });
    }
    const searchSuggestions = document.getElementById('searchSuggestions');
    if (filterSearch && searchSuggestions) {
      filterSearch.addEventListener('input', debounce(function() {
        const query = filterSearch.value.trim();
        if (query.length === 0) {
          searchSuggestions.innerHTML = '';
          searchSuggestions.classList.add('hidden');
          return;
        }

        fetch(`<?php echo base_url('mobil/filter'); ?>?search=${encodeURIComponent(query)}`)
          .then(res => res.json())
          .then(data => {
            if (data.length === 0) {
              searchSuggestions.innerHTML = `
                <div class="p-5 text-center text-xs text-[#999999]">
                  <i class="fa-solid fa-car-burst mb-2 text-base block text-neutral-400"></i>
                  Tidak ada unit mobil ditemukan
                </div>
              `;
              searchSuggestions.classList.remove('hidden');
              return;
            }

            const suggestions = data.slice(0, 5);
            let html = `
              <div class="px-4 py-2.5 border-b border-[#F0F0F0] bg-[#FAFAFA]/80 flex items-center justify-between">
                <span class="text-[9px] font-mono font-bold tracking-widest text-[#999999]">REKOMENDASI MOBIL</span>
                <span class="text-[8px] font-mono text-[#999999]">${data.length} unit</span>
              </div>
              <div class="flex flex-col p-2 gap-1.5">
            `;
            
            suggestions.forEach(car => {
              const formattedPrice = new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0
              }).format(car.price).replace("Rp", "Rp ") + ",-";

              const imgHtml = car.image_url
                ? `<img src="<?php echo base_url('uploads/'); ?>${car.image_url}" alt="${car.brand} ${car.model}" class="h-10 w-auto object-contain">`
                : `<i class="fa-solid fa-car-side text-black/20 text-xl"></i>`;

              html += `
                <div class="flex items-center justify-between p-2.5 rounded-xl hover:bg-neutral-50 border border-transparent hover:border-[#EAEAEA] transition-all duration-300">
                  <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-16 h-12 bg-[#F5F5F5] rounded-lg overflow-hidden flex items-center justify-center border border-[#EAEAEA] flex-shrink-0">
                      ${imgHtml}
                    </div>
                    <div class="min-w-0">
                      <span class="text-[8px] font-mono text-[#999999] uppercase tracking-wider block mb-0.5">${car.brand}</span>
                      <h5 class="text-xs font-bold text-black truncate leading-tight">${car.model}</h5>
                      <span class="text-[10px] font-mono font-semibold text-black/75 mt-0.5 block">${formattedPrice}</span>
                    </div>
                  </div>
                  <a href="<?php echo base_url('mobil/detail/'); ?>${car.id}" class="flex-shrink-0 ml-3 px-4 py-2 rounded-full bg-black text-white hover:bg-neutral-800 text-[9px] font-mono font-bold tracking-wider uppercase transition-all duration-200 shadow-sm flex items-center gap-1.5">
                    <span>Detail</span>
                    <i class="fa-solid fa-arrow-right text-[7px]"></i>
                  </a>
                </div>
              `;
            });
            
            html += `</div>`;
            
            searchSuggestions.innerHTML = html;
            searchSuggestions.classList.remove('hidden');
          })
          .catch(() => {});
      }, 250));

      document.addEventListener('click', function(e) {
        if (!filterSearch.contains(e.target) && !searchSuggestions.contains(e.target)) {
          searchSuggestions.classList.add('hidden');
        }
      });

      filterSearch.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
          searchSuggestions.classList.remove('hidden');
        }
      });
    }

    if (clearSearchBtn && filterSearch) {
      clearSearchBtn.addEventListener('click', function() {
        filterSearch.value = '';
        clearSearchBtn.classList.remove('opacity-100', 'pointer-events-auto');
        clearSearchBtn.classList.add('opacity-0', 'pointer-events-none');
        if (searchSuggestions) {
          searchSuggestions.innerHTML = '';
          searchSuggestions.classList.add('hidden');
        }
        filterSearch.focus();
        runFilter();
      });
    }

    function runFilter() {
      const brand     = filterBrand ? filterBrand.value : '';
      const type      = filterType ? filterType.value : '';
      const max_price = filterPrice ? filterPrice.value : '0';
      const search    = filterSearch ? filterSearch.value : '';

      anime({
        targets: '#catalogGrid .stagger-card',
        opacity: 0, scale: 0.98, translateY: 15,
        delay: anime.stagger(20), duration: 200, easing: 'easeInQuad',
        complete: function() {
          fetch(`<?php echo base_url('mobil/filter'); ?>?brand=${brand}&type=${type}&max_price=${max_price}&search=${search}`)
            .then(res => res.json())
            .then(data => renderGrid(data))
            .catch(() => {});
        }
      });
    }

    function renderGrid(cars) {
      catalogGrid.innerHTML = '';
      carsCount.textContent = `Menampilkan ${cars.length} unit`;

      if (cars.length === 0) {
        catalogGrid.innerHTML = `
          <div class="col-span-full py-16 text-center border border-dashed border-[#EAEAEA] rounded-[28px] bg-[#F5F5F5]">
            <i class="fa-solid fa-car-burst text-black/20 text-3xl mb-4"></i>
            <h4 class="font-display font-semibold text-base text-black mb-1">Unit Tidak Ditemukan</h4>
            <p class="text-xs text-[#999999]">Coba ganti filter kriteria pencarian Anda.</p>
          </div>
        `;
        return;
      }

      cars.forEach(car => {
        const formattedPrice = new Intl.NumberFormat('id-ID', {
          style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0
        }).format(car.price).replace("Rp", "Rp ") + ",-";

        const imgHtml = car.image_url
          ? `<img src="<?php echo base_url('uploads/'); ?>${car.image_url}" alt="${car.brand} ${car.model}" class="h-32 w-auto object-contain transform group-hover:scale-105 transition-transform duration-500 drop-shadow-sm">`
          : `<i class="fa-solid fa-car-side text-black/10 text-7xl transform group-hover:scale-105 transition-transform duration-500"></i>`;

        const cardHtml = `
          <div class="framer-card overflow-hidden flex flex-col justify-between stagger-card relative group p-6">
            <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>
            <div class="flex justify-between items-center mb-6 text-xs font-mono">
              <span class="text-black dot-matrix font-semibold">${car.year}</span>
              <span class="px-2.5 py-0.5 rounded-full bg-[#F5F5F5] text-[9px] text-[#666666] tracking-wider uppercase font-semibold">${car.type}</span>
            </div>
            <div class="relative w-full h-40 bg-[#F5F5F5] rounded-[18px] flex items-center justify-center overflow-hidden border border-[#EAEAEA] mb-6">
              ${imgHtml}
            </div>
            <div class="flex-grow space-y-4">
              <div>
                <span class="text-[9px] font-mono text-[#999999] uppercase tracking-wider block mb-1">${car.brand}</span>
                <h4 class="font-display font-bold text-base text-black leading-tight">${car.model}</h4>
              </div>
              <div class="grid grid-cols-2 gap-4 border-t border-[#EAEAEA] pt-4 text-[10px] font-mono">
                <div>
                  <span class="text-[#999999] block text-[8px] uppercase">NOPOL</span>
                  <span class="text-black font-semibold uppercase">${car.plate_number}</span>
                </div>
                <div>
                  <span class="text-[#999999] block text-[8px] uppercase">STATUS</span>
                  ${car.status === 'booked' 
                    ? `<span class="text-blue-600 font-semibold dot-matrix blink-dot">● BOOKED</span>` 
                    : `<span class="text-black font-semibold dot-matrix blink-dot">● AVAILABLE</span>`}
                </div>
              </div>
            </div>
            <div class="mt-6 pt-4 border-t border-[#EAEAEA] flex items-center justify-between">
              <div class="flex flex-col">
                <span class="text-[8px] font-mono text-[#999999] uppercase">OTR PRICE</span>
                <span class="font-display font-bold text-sm text-black">${formattedPrice}</span>
              </div>
              <a href="<?php echo base_url('mobil/detail/'); ?>${car.id}" class="px-5 py-2.5 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-semibold text-xs tracking-tight uppercase">
                Detail
              </a>
            </div>
          </div>
        `;
        catalogGrid.insertAdjacentHTML('beforeend', cardHtml);
      });

      anime({
        targets: '#catalogGrid .stagger-card',
        opacity: [0, 1], scale: [0.98, 1], translateY: [15, 0],
        delay: anime.stagger(50), easing: 'easeOutExpo', duration: 800
      });
    }

    function debounce(func, wait) {
      let timeout;
      return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    }
  });
</script>
