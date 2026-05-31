<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center" data-aos="fade-up">
  
  <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-black/10 bg-[#F5F5F5] text-xs text-black font-mono tracking-widest uppercase mb-6 stagger-card">
    <i class="fa-solid fa-tags"></i> PENYEDIAAN KENDARAAN (CAR SOURCING)
  </div>

  <h1 class="text-4xl sm:text-5xl font-display font-extrabold tracking-tight text-black mb-6 leading-tight stagger-card">
    Ingin Menjual Mobil Anda? <br class="hidden sm:inline">
    Kami Beli Secara <span class="text-black underline font-extrabold">LUNAS</span>
  </h1>

  <p class="max-w-2xl mx-auto text-sm text-[#666666] leading-relaxed mb-12 stagger-card">
    Tawarkan mobil bekas Anda ke showroom kami secara instan. Tim kami akan melakukan inspeksi langsung ke lokasi Anda dan membayar lunas baik secara tunai maupun bank transfer saat itu juga.
  </p>

  <!-- Animated Wrapper -->
  <div id="sourcingFormWrapper" class="max-w-4xl mx-auto transition-all duration-700 ease-in-out">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- Left Column: Main Form Container -->
      <div id="mainFormContainer" class="lg:col-span-12 bg-white border border-[#EAEAEA] rounded-[28px] p-8 sm:p-12 relative text-left shadow-sm transition-all duration-700 ease-in-out">
        <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(#000 1.2px, transparent 1.2px); background-size: 12px 12px;"></div>

        <h3 class="font-display font-bold text-lg text-black mb-8 border-b border-[#EAEAEA] pb-4 uppercase tracking-wider">
          <i class="fa-solid fa-clipboard-list text-black mr-2"></i> FORM PENAWARAN DOKUMEN MOBIL
        </h3>

        <?php if (in_array($this->session->userdata('role'), array('admin', 'staff', 'kurir'))): ?>
          <div class="text-center py-12 px-6 bg-[#FAFAFA] rounded-[24px] border border-[#EAEAEA] font-mono">
            <i class="fa-solid fa-shield-halved text-black text-4xl mb-4"></i>
            <h4 class="text-black font-display font-bold text-sm uppercase mb-2">AKSES DIBATASI UNTUK ADMINISTRATOR</h4>
            <p class="text-xs text-[#666666] max-w-md mx-auto leading-relaxed">
              Akun administratif (<span class="text-black font-bold"><?php echo strtoupper($this->session->userdata('role')); ?></span>) tidak diperbolehkan mengajukan unit mobil pribadi untuk dijual. Peran Anda bertugas untuk mengelola, inspeksi, dan menyetujui sourcing.
            </p>
          </div>
        <?php else: ?>
          
          <?php echo form_open_multipart('sourcing/submit', array('class' => 'grid grid-cols-1 md:grid-cols-12 gap-8 text-xs font-mono text-[#666666]')); ?>
            
            <!-- Left Side: Inputs Form (7 cols) -->
            <div class="md:col-span-7 space-y-5">
              
              <!-- Owner Details -->
              <div class="flex flex-col gap-2">
                <label class="text-black font-bold uppercase"><i class="fa-solid fa-user mr-1.5"></i>Nama Pemilik (Sesuai KTP):</label>
                <input type="text" name="owner_name" placeholder="Nama Lengkap Anda" required class="cyber-input text-xs w-full" value="<?php echo esc($this->session->userdata('fullname')); ?>">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase"><i class="fa-solid fa-phone mr-1.5"></i>No Telepon/WA:</label>
                  <input type="text" name="owner_phone" id="ownerPhoneInput" placeholder="Contoh: 0812xxxxxxxx" required class="cyber-input text-xs w-full">
                </div>
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Warna Kendaraan:</label>
                  <input type="text" name="car_color" placeholder="Contoh: Hitam Metalik" required class="cyber-input text-xs w-full">
                </div>
              </div>

              <div class="flex flex-col gap-2">
                <label class="text-black font-bold uppercase"><i class="fa-solid fa-truck-ramp-box mr-1.5"></i>Opsi Penyerahan / Survey:</label>
                <select name="sourcing_method" id="sourcingMethodSelect" required class="cyber-input text-xs w-full">
                  <option value="antar" selected>Saya Mengantar Mobil ke Showroom (Drive-In)</option>
                  <option value="jemput">Showroom Menjemput / Survey ke Rumah Saya (Pick-Up)</option>
                </select>
              </div>

              <div class="flex flex-col gap-2 transition-all duration-300" id="addressContainer" style="display: none;">
                <label class="text-black font-bold uppercase"><i class="fa-solid fa-location-dot mr-1.5"></i>Alamat Penjemputan / Inspeksi:</label>
                <textarea name="owner_address" id="ownerAddressTextarea" placeholder="Tulis alamat lengkap penjemputan/inspeksi..." class="cyber-input py-3 h-20 text-xs w-full rounded-2xl"></textarea>
              </div>

              <!-- Divider -->
              <div class="border-t border-[#EAEAEA] my-4"></div>

              <!-- Vehicle Specs -->
              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Merk Mobil:</label>
                  <input type="text" name="car_brand" placeholder="Contoh: Honda" required class="cyber-input text-xs w-full">
                </div>
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Model &amp; Varian:</label>
                  <input type="text" name="car_model" placeholder="Contoh: Civic Turbo Sedan" required class="cyber-input text-xs w-full">
                </div>
              </div>

              <div class="grid grid-cols-1 gap-4">
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Tahun Perakitan:</label>
                  <input type="number" name="car_year" id="carYearInput" placeholder="Contoh: 2021" required class="cyber-input text-xs w-full">
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Kilometer (Mileage):</label>
                  <input type="number" name="mileage" placeholder="Contoh: 45000" required class="cyber-input text-xs w-full">
                </div>
                <div class="flex flex-col gap-2">
                  <label class="text-black font-bold uppercase">Harga yang Diinginkan (Rp):</label>
                  <input type="text" name="price_desired" id="priceDesiredInput" placeholder="Contoh: 350.000.000" required class="cyber-input text-xs w-full">
                </div>
              </div>

              <div class="flex flex-col gap-2">
                <label class="text-black font-bold uppercase"><i class="fa-solid fa-align-left mr-1.5"></i>Deskripsi Kondisi Kendaraan:</label>
                <textarea name="description" placeholder="Ceritakan kondisi mobil Anda (cat lecet, mesin sehat, servis berkala, dll)..." required class="cyber-input py-3 h-24 text-xs w-full rounded-2xl"></textarea>
              </div>

            </div>

            <!-- Right Side: File Upload Dropzones (5 cols) -->
            <div class="md:col-span-5 flex flex-col justify-between gap-5">
              
              <div class="space-y-4">
                <h4 class="text-black font-bold uppercase tracking-wider border-b border-[#EAEAEA] pb-2">
                  <i class="fa-solid fa-file-arrow-up mr-2"></i>DOKUMEN &amp; FOTO UNIT
                </h4>
                
                <div class="flex flex-col gap-1.5">
                  <label class="text-black font-bold uppercase">1. Scan STNK (Wajib, PDF/JPG/PNG):</label>
                  <input type="file" name="stnk_doc" required class="w-full text-xs font-mono file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-neutral-800">
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-black font-bold uppercase">2. Scan BPKB (Opsional, PDF/JPG/PNG):</label>
                  <input type="file" name="bpkb_doc" class="w-full text-xs font-mono file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-neutral-800">
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-black font-bold uppercase">3. Foto Mobil Tampak Depan (Wajib):</label>
                  <input type="file" name="photo_front" required class="w-full text-xs font-mono file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-neutral-800">
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-black font-bold uppercase">4. Foto Mobil Tampak Belakang (Wajib):</label>
                  <input type="file" name="photo_back" required class="w-full text-xs font-mono file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-neutral-800">
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-black font-bold uppercase">5. Foto Interior Mobil (Wajib):</label>
                  <input type="file" name="photo_interior" required class="w-full text-xs font-mono file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-neutral-800">
                </div>
              </div>

              <div class="pt-6">
                <button type="submit" class="w-full text-center py-5 rounded-full bg-black text-white hover:bg-neutral-800 transition-all font-display uppercase tracking-wider text-xs font-bold shadow-sm">
                  Kirim Pengajuan Penjualan <i class="fa-solid fa-paper-plane ml-2"></i>
                </button>
              </div>
            </div>

          </form>
        <?php endif; ?>
      </div>

      <!-- Right Column: Document/Image Live Previews -->
      <div id="previewPanelContainer" class="lg:col-span-4 bg-white border border-[#EAEAEA] rounded-[28px] p-6 sm:p-8 shadow-sm transition-all duration-700 opacity-0 transform translate-x-10 hidden space-y-6 text-left">
        <h4 class="text-black font-bold uppercase tracking-wider border-b border-[#EAEAEA] pb-2 font-mono text-xs">
          <i class="fa-solid fa-images mr-2"></i>PRATINJAU DOKUMEN
        </h4>
        
        <div class="space-y-4 font-mono text-[10px]">
          
          <!-- STNK -->
          <div id="preview-stnk" class="hidden bg-[#FAFAFA] border border-[#EAEAEA] rounded-2xl p-3 space-y-2">
            <div class="flex justify-between font-bold text-black uppercase">
              <span>1. Scan STNK</span>
              <button type="button" class="text-neutral-400 hover:text-black" onclick="clearInput('stnk_doc')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="h-28 rounded-lg overflow-hidden bg-neutral-100 flex items-center justify-center border border-[#EAEAEA] text-neutral-400">
              <img id="img-stnk" class="w-full h-full object-cover hidden">
              <span id="txt-stnk" class="text-center px-4 leading-normal">PDF Document Loaded</span>
            </div>
          </div>

          <!-- BPKB -->
          <div id="preview-bpkb" class="hidden bg-[#FAFAFA] border border-[#EAEAEA] rounded-2xl p-3 space-y-2">
            <div class="flex justify-between font-bold text-black uppercase">
              <span>2. Scan BPKB</span>
              <button type="button" class="text-neutral-400 hover:text-black" onclick="clearInput('bpkb_doc')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="h-28 rounded-lg overflow-hidden bg-neutral-100 flex items-center justify-center border border-[#EAEAEA] text-neutral-400">
              <img id="img-bpkb" class="w-full h-full object-cover hidden">
              <span id="txt-bpkb" class="text-center px-4 leading-normal">PDF Document Loaded</span>
            </div>
          </div>

          <!-- Foto Depan -->
          <div id="preview-front" class="hidden bg-[#FAFAFA] border border-[#EAEAEA] rounded-2xl p-3 space-y-2">
            <div class="flex justify-between font-bold text-black uppercase">
              <span>3. Tampak Depan</span>
              <button type="button" class="text-neutral-400 hover:text-black" onclick="clearInput('photo_front')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="h-28 rounded-lg overflow-hidden bg-neutral-100 flex items-center justify-center border border-[#EAEAEA] text-neutral-400">
              <img id="img-front" class="w-full h-full object-cover hidden">
            </div>
          </div>

          <!-- Foto Belakang -->
          <div id="preview-back" class="hidden bg-[#FAFAFA] border border-[#EAEAEA] rounded-2xl p-3 space-y-2">
            <div class="flex justify-between font-bold text-black uppercase">
              <span>4. Tampak Belakang</span>
              <button type="button" class="text-neutral-400 hover:text-black" onclick="clearInput('photo_back')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="h-28 rounded-lg overflow-hidden bg-neutral-100 flex items-center justify-center border border-[#EAEAEA] text-neutral-400">
              <img id="img-back" class="w-full h-full object-cover hidden">
            </div>
          </div>

          <!-- Foto Interior -->
          <div id="preview-interior" class="hidden bg-[#FAFAFA] border border-[#EAEAEA] rounded-2xl p-3 space-y-2">
            <div class="flex justify-between font-bold text-black uppercase">
              <span>5. Interior Mobil</span>
              <button type="button" class="text-neutral-400 hover:text-black" onclick="clearInput('photo_interior')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="h-28 rounded-lg overflow-hidden bg-neutral-100 flex items-center justify-center border border-[#EAEAEA] text-neutral-400">
              <img id="img-interior" class="w-full h-full object-cover hidden">
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- Combined Scripts -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const ownerPhone = document.getElementById('ownerPhoneInput');
    const carYear = document.getElementById('carYearInput');
    const sourcingSelect = document.getElementById('sourcingMethodSelect');
    const addressContainer = document.getElementById('addressContainer');
    const addressTextarea = document.getElementById('ownerAddressTextarea');

    if (ownerPhone) {
      ownerPhone.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    }

    if (carYear) {
      carYear.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    }

    const priceDesired = document.getElementById('priceDesiredInput');
    if (priceDesired) {
      priceDesired.addEventListener('input', function() {
        let val = this.value.replace(/[^0-9]/g, '');
        if (val) {
          this.value = parseInt(val, 10).toLocaleString('id-ID');
        } else {
          this.value = '';
        }
      });
    }

    if (sourcingSelect && addressContainer && addressTextarea) {
      function toggleAddress() {
        if (sourcingSelect.value === 'jemput') {
          addressContainer.style.display = 'flex';
          addressTextarea.required = true;
        } else {
          addressContainer.style.display = 'none';
          addressTextarea.required = false;
          addressTextarea.value = ''; 
        }
      }
      sourcingSelect.addEventListener('change', toggleAddress);
      toggleAddress();
    }

    // File Preview Logic
    const fileInputs = {
      'stnk_doc': { input: document.querySelector('input[name="stnk_doc"]'), card: 'preview-stnk', img: 'img-stnk', txt: 'txt-stnk' },
      'bpkb_doc': { input: document.querySelector('input[name="bpkb_doc"]'), card: 'preview-bpkb', img: 'img-bpkb', txt: 'txt-bpkb' },
      'photo_front': { input: document.querySelector('input[name="photo_front"]'), card: 'preview-front', img: 'img-front' },
      'photo_back': { input: document.querySelector('input[name="photo_back"]'), card: 'preview-back', img: 'img-back' },
      'photo_interior': { input: document.querySelector('input[name="photo_interior"]'), card: 'preview-interior', img: 'img-interior' }
    };

    window.clearInput = function(name) {
      if (fileInputs[name] && fileInputs[name].input) {
        fileInputs[name].input.value = '';
        const card = document.getElementById(fileInputs[name].card);
        if (card) card.classList.add('hidden');
        updateLayout();
      }
    };

    function updateLayout() {
      let anyVisible = false;
      Object.keys(fileInputs).forEach(key => {
        const item = fileInputs[key];
        const card = document.getElementById(item.card);
        if (item.input && item.input.files && item.input.files[0]) {
          card.classList.remove('hidden');
          anyVisible = true;
          
          const file = item.input.files[0];
          const reader = new FileReader();
          reader.onload = function(e) {
            const imgEl = document.getElementById(item.img);
            const txtEl = item.txt ? document.getElementById(item.txt) : null;
            
            if (file.type.startsWith('image/')) {
              imgEl.src = e.target.result;
              imgEl.classList.remove('hidden');
              if (txtEl) txtEl.classList.add('hidden');
            } else {
              imgEl.classList.add('hidden');
              if (txtEl) {
                txtEl.textContent = file.name;
                txtEl.classList.remove('hidden');
              }
            }
          };
          reader.readAsDataURL(file);
        } else {
          if (card) card.classList.add('hidden');
        }
      });

      const wrapper = document.getElementById('sourcingFormWrapper');
      const mainForm = document.getElementById('mainFormContainer');
      const preview = document.getElementById('previewPanelContainer');

      if (anyVisible) {
        wrapper.classList.remove('max-w-4xl');
        wrapper.classList.add('max-w-7xl');
        mainForm.classList.remove('lg:col-span-12');
        mainForm.classList.add('lg:col-span-8');
        
        preview.classList.remove('hidden');
        setTimeout(() => {
          preview.classList.remove('opacity-0', 'translate-x-10');
          preview.classList.add('opacity-100', 'translate-x-0');
        }, 50);
      } else {
        preview.classList.add('opacity-0', 'translate-x-10');
        preview.classList.remove('opacity-100', 'translate-x-0');
        setTimeout(() => {
          preview.classList.add('hidden');
          mainForm.classList.remove('lg:col-span-8');
          mainForm.classList.add('lg:col-span-12');
          wrapper.classList.remove('max-w-7xl');
          wrapper.classList.add('max-w-4xl');
        }, 500);
      }
    }

    Object.keys(fileInputs).forEach(key => {
      const item = fileInputs[key];
      if (item.input) {
        item.input.addEventListener('change', updateLayout);
      }
    });

  });
</script>
