  </main>

  <!-- Floating Matrix Dots Parallax Scroll Background Accents -->
  <div class="fixed left-6 top-[20%] w-32 h-32 opacity-10 pointer-events-none z-[-1] hidden md:block" id="parallaxDot1" style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 10px 10px;"></div>
  <div class="fixed right-10 top-[60%] w-40 h-40 opacity-15 pointer-events-none z-[-1] hidden md:block" id="parallaxDot2" style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 12px 12px;"></div>
  <div class="fixed left-1/3 top-[45%] w-24 h-24 opacity-5 pointer-events-none z-[-1] hidden md:block" id="parallaxDot3" style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 8px 8px;"></div>
  <div class="fixed left-12 top-[75%] w-36 h-36 opacity-10 pointer-events-none z-[-1] hidden md:block" id="parallaxDot4" style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 14px 14px;"></div>
  <div class="fixed right-[20%] top-[15%] w-28 h-28 opacity-10 pointer-events-none z-[-1] hidden md:block" id="parallaxDot5" style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>

  <!-- Premium Minimalist Footer (Framer × Nothing OS) -->
  <footer class="border-t border-[#EAEAEA] bg-white mt-32 py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        
        <!-- Brand Info -->
        <div class="md:col-span-2 flex flex-col gap-5">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-black border border-black p-0.5 flex items-center justify-center">
              <span class="font-display font-bold text-white text-xs">D</span>
            </div>
            <span class="font-display font-bold text-lg text-black tracking-tight">DRIVE.X</span>
          </div>
          <p class="text-xs text-[#666666] max-w-sm leading-relaxed font-sans">
            Platform digital modern dengan visual futuristik, minimalis, dan interaktivitas premium terinspirasi dari Nothing OS dan Framer.
          </p>
          <div class="text-[10px] font-mono text-[#999999] tracking-wider uppercase">
            PROJECT ACADEMIC DATABASE & WEB INOVATIF &copy; <?php echo date('Y'); ?>
          </div>
        </div>

        <!-- Sourcing Info -->
        <div class="flex flex-col gap-4">
          <h4 class="font-display font-semibold text-xs tracking-wider text-black uppercase">PENYEDIAAN MOBIL</h4>
          <ul class="text-xs text-[#666666] space-y-2.5">
            <li><a href="<?php echo base_url('sourcing'); ?>" class="hover:text-black transition-colors">Jual Mobil Ke Showroom</a></li>
            <li><a href="#" class="hover:text-black transition-colors">Jadwal Inspeksi Gratis</a></li>
            <li><a href="#" class="hover:text-black transition-colors">Sourcing Kriteria Mobil</a></li>
          </ul>
        </div>

        <!-- Contact Support -->
        <div class="flex flex-col gap-4">
          <h4 class="font-display font-semibold text-xs tracking-wider text-black uppercase">HUBUNGI KAMI</h4>
          <ul class="text-xs text-[#666666] space-y-2.5 font-mono">
            <li><i class="fa-solid fa-location-dot text-black mr-2"></i>Jl. Kampus Raya No. 4, Jakarta</li>
            <li><i class="fa-solid fa-envelope text-black mr-2"></i>info@drivex.com</li>
            <li><i class="fa-solid fa-phone text-black mr-2"></i>+62 21 555 1234</li>
          </ul>
        </div>

      </div>
    </div>
  </footer>

  <!-- AOS (Animate On Scroll) Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Initialize AOS
      AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
      });

      // Parallax Scrolling Matrix Dots Animation
      window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const dot1 = document.getElementById('parallaxDot1');
        const dot2 = document.getElementById('parallaxDot2');
        const dot3 = document.getElementById('parallaxDot3');
        const dot4 = document.getElementById('parallaxDot4');
        const dot5 = document.getElementById('parallaxDot5');
        
        if (dot1) dot1.style.transform = `translateY(${scrolled * 0.18}px)`;
        if (dot2) dot2.style.transform = `translateY(${scrolled * -0.12}px)`;
        if (dot3) dot3.style.transform = `translateY(${scrolled * 0.08}px)`;
        if (dot4) dot4.style.transform = `translateY(${scrolled * -0.16}px)`;
        if (dot5) dot5.style.transform = `translateY(${scrolled * 0.22}px)`;
      });

      // Staggered Entrance Animations using Anime.js
      const staggerCards = document.querySelectorAll('.stagger-card');
      if (staggerCards.length > 0) {
        anime({
          targets: '.stagger-card',
          opacity: [0, 1],
          translateY: [30, 0],
          delay: anime.stagger(100),
          easing: 'easeOutExpo',
          duration: 1000
        });
      }
    });

    // Custom Interactive Web Tour Implementation (Nothing OS / Framer Theme)
    let tourCurrentStep = 0;
    const tourSteps = [
      {
        target: '#heroTitle',
        title: 'STEP 01 // DRIVE.X WELCOME',
        text: 'Selamat datang di DRIVE.X! Temukan pengalaman komparasi & transaksi mobil premium digital termutakhir di Indonesia.',
        pos: 'bottom'
      },
      {
        target: '#carSliderWrapper',
        title: 'STEP 02 // PREMIUM CAR SLIDER',
        text: 'Eksplorasi unit-unit unggulan kami melalui slider berputar otomatis dengan data dinamis, spesifikasi performa instan, dan kontrol dial track Nothing OS.',
        pos: 'left'
      },
      {
        target: '#filter',
        title: 'STEP 03 // SMART FILTERING',
        text: 'Cari mobil impian Anda secara presisi berdasarkan Brand, Tipe Bodi, Harga Maksimum, atau kata kunci pencarian menggunakan filter bergaya Framer CMS.',
        pos: 'top'
      },
      {
        target: '#katalog',
        title: 'STEP 04 // ACTIVE CATALOG GRID',
        text: 'Jelajahi detail spesifikasi lengkap tiap mobil, lihat estimasi pembiayaan Apple-style, atau ajukan transaksi beli instan secara aman.',
        pos: 'top'
      }
    ];

    window.startWebTour = function() {
      // If not on homepage, redirect to homepage first
      if (!document.querySelector('#heroTitle')) {
        window.location.href = "<?php echo base_url(); ?>?startTour=true";
        return;
      }
      
      tourCurrentStep = 0;
      createTourOverlay();
      showTourStep();
    };

    function createTourOverlay() {
      if (document.getElementById('webTourOverlay')) return;

      const overlay = document.createElement('div');
      overlay.id = 'webTourOverlay';
      overlay.className = 'fixed inset-0 bg-black/10 z-[99998] pointer-events-none transition-opacity duration-300 opacity-0';
      document.body.appendChild(overlay);
      
      // Force repaint
      overlay.offsetWidth;
      overlay.style.opacity = '1';
      overlay.style.pointerEvents = 'auto';

      // Highlight Box
      const highlight = document.createElement('div');
      highlight.id = 'webTourHighlight';
      highlight.className = 'absolute border-[2px] border-black rounded-[20px] shadow-[0_0_0_9999px_rgba(0,0,0,0.5)] z-[99998] pointer-events-none transition-all duration-500 ease-out';
      document.body.appendChild(highlight);

      // Card Modal
      const card = document.createElement('div');
      card.id = 'webTourCard';
      card.className = 'absolute bg-white border border-[#EAEAEA] rounded-[24px] p-6 max-w-sm shadow-[0_10px_30px_rgba(0,0,0,0.15)] z-[99999] transition-all duration-500 ease-out stagger-card';
      card.innerHTML = `
        <div class="flex justify-between items-center mb-4">
          <span id="webTourTitle" class="text-[9px] font-mono text-black font-bold dot-matrix tracking-widest blink-dot">● STEP 01</span>
          <button onclick="closeWebTour()" class="text-[10px] font-mono text-[#999999] hover:text-black uppercase font-semibold">[ SKIP ]</button>
        </div>
        <p id="webTourText" class="text-xs text-[#666666] leading-relaxed font-sans mb-6"></p>
        <div class="flex items-center justify-between border-t border-[#EAEAEA] pt-4 font-mono text-xs">
          <button id="webTourPrevBtn" onclick="prevTourStep()" class="text-black hover:underline disabled:opacity-40 disabled:no-underline" disabled>&lsaquo; Back</button>
          <span id="webTourStepNum" class="text-[10px] text-[#999999]">1/4</span>
          <button id="webTourNextBtn" onclick="nextTourStep()" class="font-bold text-black hover:underline">Next &rsaquo;</button>
        </div>
      `;
      document.body.appendChild(card);
    }

    function showTourStep() {
      const step = tourSteps[tourCurrentStep];
      const el = document.querySelector(step.target);
      if (!el) {
        closeWebTour();
        return;
      }

      // Smooth scroll to target
      el.scrollIntoView({ behavior: 'smooth', block: 'center' });

      setTimeout(() => {
        const rect = el.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        // Position highlight box
        const hl = document.getElementById('webTourHighlight');
        hl.style.top = `${rect.top + scrollTop - 8}px`;
        hl.style.left = `${rect.left + scrollLeft - 8}px`;
        hl.style.width = `${rect.width + 16}px`;
        hl.style.height = `${rect.height + 16}px`;

        // Position Card Modal relative to target
        const card = document.getElementById('webTourCard');
        document.getElementById('webTourTitle').textContent = `● ${step.title}`;
        document.getElementById('webTourText').textContent = step.text;
        document.getElementById('webTourStepNum').textContent = `${tourCurrentStep + 1}/${tourSteps.length}`;

        // Enable/Disable buttons
        document.getElementById('webTourPrevBtn').disabled = (tourCurrentStep === 0);
        document.getElementById('webTourNextBtn').textContent = (tourCurrentStep === tourSteps.length - 1) ? 'Finish ✓' : 'Next ›';

        // Calculate card positioning based on layout rect
        let cardTop = 0;
        let cardLeft = 0;

        if (step.pos === 'bottom') {
          cardTop = rect.bottom + scrollTop + 15;
          cardLeft = rect.left + scrollLeft + (rect.width / 2) - (card.offsetWidth / 2);
        } else if (step.pos === 'top') {
          cardTop = rect.top + scrollTop - card.offsetHeight - 15;
          cardLeft = rect.left + scrollLeft + (rect.width / 2) - (card.offsetWidth / 2);
        } else if (step.pos === 'left') {
          cardTop = rect.top + scrollTop + (rect.height / 2) - (card.offsetHeight / 2);
          cardLeft = rect.left + scrollLeft - card.offsetWidth - 15;
        } else { // right
          cardTop = rect.top + scrollTop + (rect.height / 2) - (card.offsetHeight / 2);
          cardLeft = rect.right + scrollLeft + 15;
        }

        // Keep inside screen boundaries
        if (cardLeft < 10) cardLeft = 10;
        if (cardLeft + 360 > window.innerWidth) cardLeft = window.innerWidth - 380;
        if (cardTop < 10) cardTop = rect.bottom + scrollTop + 20; // fallback below

        card.style.top = `${cardTop}px`;
        card.style.left = `${cardLeft}px`;

        anime.remove(card);
        anime({
          targets: card,
          scale: [0.95, 1],
          opacity: [0, 1],
          duration: 400,
          easing: 'easeOutExpo'
        });

      }, 500); // delay to let scroll finish
    }

    window.nextTourStep = function() {
      if (tourCurrentStep < tourSteps.length - 1) {
        tourCurrentStep++;
        showTourStep();
      } else {
        closeWebTour();
      }
    };

    window.prevTourStep = function() {
      if (tourCurrentStep > 0) {
        tourCurrentStep--;
        showTourStep();
      }
    };

    window.closeWebTour = function() {
      const overlay = document.getElementById('webTourOverlay');
      const hl = document.getElementById('webTourHighlight');
      const card = document.getElementById('webTourCard');

      if (overlay) {
        overlay.style.opacity = '0';
        setTimeout(() => overlay.remove(), 300);
      }
      if (hl) hl.remove();
      if (card) card.remove();
    };

    // Auto-start tour if redirected with query param
    if (window.location.search.includes('startTour=true')) {
      setTimeout(() => {
        window.startWebTour();
        // clean URL parameter cleanly
        window.history.replaceState({}, document.title, window.location.pathname);
      }, 800);
    }

    // Global copy to clipboard helper
    window.copyTextToClipboard = function(text, element) {
      if (!navigator.clipboard) {
        // Fallback
        const textarea = document.createElement("textarea");
        textarea.value = text;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        try {
          document.execCommand('copy');
          triggerCopySuccess(element);
        } catch (err) {}
        document.body.removeChild(textarea);
        return;
      }
      navigator.clipboard.writeText(text).then(function() {
        triggerCopySuccess(element);
      }, function(err) {});
    };

    function triggerCopySuccess(element) {
      if (!element) return;
      element.classList.add('copied');
      
      // Dynamic Toast Notify
      showPremiumToast('INFORMASI REKENING SALIN KE CLIPBOARD!');

      setTimeout(() => {
        element.classList.remove('copied');
      }, 2000);
    }

    window.showPremiumToast = function(message, isSuccess = true) {
      const toast = document.createElement('div');
      toast.className = 'fixed bottom-8 right-8 text-white px-6 py-3.5 rounded-full border shadow-2xl font-mono text-[10px] z-[99999] tracking-wider uppercase flex items-center gap-2 select-none';
      if (isSuccess) {
        toast.className += ' bg-black border-white/20';
        toast.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 blink-dot"></span> ' + message;
      } else {
        toast.className += ' bg-red-600 border-red-500/20';
        toast.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-white blink-dot"></span> ' + message;
      }
      document.body.appendChild(toast);
      
      // Animation entry
      anime({
        targets: toast,
        opacity: [0, 1],
        translateY: [20, 0],
        scale: [0.9, 1],
        easing: 'easeOutExpo',
        duration: 350
      });
      
      setTimeout(() => {
        anime({
          targets: toast,
          opacity: 0,
          translateY: 20,
          easing: 'easeInQuad',
          duration: 300,
          complete: () => toast.remove()
        });
      }, 3500);
    };
  </script>
</body>
</html>
