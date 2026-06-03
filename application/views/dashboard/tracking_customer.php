<!-- Leaflet JS & CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
  /* Premium Glassmorphic Minimalist Design (Nothing OS style) */
  .glass-panel {
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.04);
  }
  .nothing-dot-bg {
    background-image: radial-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px);
    background-size: 16px 16px;
  }
  .framer-shadow {
    box-shadow: 0 20px 40px -15px rgba(0,0,0,0.06);
  }
  
  /* Timeline styling */
  .tracking-timeline-track {
    position: relative;
    border-left: 2px dashed #EAEAEA;
    padding-left: 1.75rem;
  }
  .tracking-timeline-dot {
    position: absolute;
    left: -7px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #FFFFFF;
    border: 2px solid #DADADA;
    transition: all 0.3s ease;
  }
  .tracking-timeline-dot.active {
    background-color: #000000;
    border-color: #000000;
    box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.12);
  }
  .tracking-timeline-dot.completed {
    background-color: #000000;
    border-color: #000000;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M11.5 5.5L6.5 10.5 4.5 8.5' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E");
    background-size: 8px;
    background-position: center;
    background-repeat: no-repeat;
  }

  /* Custom map styling */
  #map-container {
    height: 480px;
    border-radius: 24px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }
  
  /* Leaflet custom map color styling - Light Premium Map */
  .light-premium-map .leaflet-tile {
    filter: grayscale(1) contrast(1.1) brightness(0.98) opacity(0.9);
  }
  
  /* Route line glow style */
  .route-glow {
    filter: drop-shadow(0 0 3px rgba(0,0,0,0.2));
  }
</style>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 nothing-dot-bg">
  
  <!-- Back navigation and Header -->
  <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
      <a href="<?php echo base_url('booking/detail/' . $booking['id']); ?>" class="inline-flex items-center gap-2 text-xs font-mono font-bold text-neutral-500 hover:text-black transition-colors mb-2">
        <i class="fa-solid fa-arrow-left"></i> KEMBALI KE DETAIL PESANAN
      </a>
      <h2 class="font-display font-extrabold text-2xl tracking-tight text-black flex items-center gap-2">
        <i class="fa-solid fa-location-crosshairs text-black animate-pulse"></i> LIVE TRACKING PENGIRIMAN
      </h2>
      <p class="text-[10px] font-mono text-neutral-500 uppercase tracking-widest mt-1">Kode Transaksi: <?php echo $booking['booking_code']; ?></p>
    </div>
    
    <div class="glass-panel px-4 py-2.5 rounded-2xl flex items-center gap-3">
      <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
      <span class="font-mono text-xs font-bold text-black uppercase tracking-wider">SINKRONISASI AKTIF (REALTIME)</span>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- LEFT SIDE: VEHICLE INFO AND MAP -->
    <div class="lg:col-span-8 flex flex-col gap-6">
      
      <!-- VEHICLE & COURIER CARD (Floating Card ala Framer) -->
      <div class="glass-panel rounded-[24px] p-6 framer-shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5">
          <div class="w-16 h-16 rounded-[18px] bg-neutral-100 flex items-center justify-center border border-black/5 flex-shrink-0">
            <i class="fa-solid fa-car text-black text-2xl"></i>
          </div>
          <div>
            <span class="text-[9px] font-mono text-neutral-500 uppercase tracking-wider block">KENDARAAN DIKIRIM</span>
            <h3 class="font-display font-bold text-lg text-black leading-tight"><?php echo esc($booking['brand'] . ' ' . $booking['model']); ?></h3>
            <div class="flex items-center gap-2 mt-1 font-mono text-[10px] text-neutral-600">
              <span class="px-2 py-0.5 rounded border border-black/10 bg-black/5 text-black font-extrabold"><?php echo esc($booking['plate_number']); ?></span>
              <span>&bull;</span>
              <span><?php echo esc($booking['color']); ?></span>
            </div>
          </div>
        </div>

        <div class="w-full sm:w-auto border-t sm:border-t-0 sm:border-l border-[#EAEAEA] pt-4 sm:pt-0 sm:pl-6 flex items-center gap-4 justify-between">
          <div class="font-mono text-xs text-left">
            <span class="text-[9px] text-[#999999] block uppercase">KURIR PENGIRIM</span>
            <strong class="text-black text-sm block mt-0.5"><?php echo esc($delivery['courier_name'] ? $delivery['courier_name'] : 'Kurir Ditugaskan'); ?></strong>
            <span class="text-[10px] text-[#666666]"><?php echo esc($delivery['courier_phone'] ? $delivery['courier_phone'] : '-'); ?></span>
          </div>
          <?php if (!empty($delivery['courier_phone'])): ?>
            <a href="tel:<?php echo $delivery['courier_phone']; ?>" class="w-10 h-10 rounded-full border border-black bg-black text-white hover:bg-neutral-800 flex items-center justify-center transition-all">
              <i class="fa-solid fa-phone text-xs"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- LIVE MAP VIEW -->
      <div class="relative bg-white rounded-[24px] overflow-hidden border border-black/8 framer-shadow">
        <!-- Floating overlay with instructions or ETA -->
        <div class="absolute top-4 left-4 z-[999] glass-panel px-4 py-3 rounded-2xl text-xs font-mono font-medium max-w-xs shadow-md">
          <span class="text-[9px] text-neutral-500 uppercase tracking-widest block">ESTIMASI TIBA</span>
          <span id="eta-text" class="text-black font-extrabold text-sm block mt-0.5">Menghitung rute...</span>
        </div>

        <!-- The Leaflet map -->
        <div id="map-container" class="light-premium-map"></div>
      </div>
      
    </div>

    <!-- RIGHT SIDE: TIMELINE PENGIRIMAN -->
    <div class="lg:col-span-4 flex flex-col gap-6">
      
      <!-- BUTTON: MOBIL SUDAH SAMPAI (Hanya jika belum selesai) -->
      <?php 
        $current_status = $delivery['status_pengiriman'];
      ?>
      <?php if ($current_status !== 'Selesai'): ?>
        <button onclick="openRatingModal()" class="w-full py-4 rounded-[20px] bg-black text-white hover:bg-neutral-800 font-sans font-bold uppercase text-xs tracking-wider transition-all duration-300 shadow-sm flex items-center justify-center gap-2 transform hover:scale-[1.02]">
          <i class="fa-solid fa-circle-check text-sm animate-pulse"></i> Mobil Sudah Sampai
        </button>
      <?php else: ?>
        <!-- Jika sudah selesai, tampilkan info rating jika ada atau keterangan sukses -->
        <?php 
          $rating_exist = $this->db->get_where('ratings', array('booking_id' => $booking['id']))->row_array();
        ?>
        <div class="w-full p-4 rounded-[20px] bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-mono text-center">
          <i class="fa-solid fa-circle-check text-emerald-600 text-lg block mb-1"></i>
          <strong>KENDARAAN SUDAH DITERIMA</strong>
          <?php if ($rating_exist): ?>
            <div class="mt-2 pt-2 border-t border-emerald-200/50 flex justify-center gap-4 text-[10px]">
              <span>Showroom: <?php echo str_repeat('★', $rating_exist['rating_showroom']); ?></span>
              <span>Kurir: <?php echo str_repeat('★', $rating_exist['rating_kurir']); ?></span>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- DELIVERY TIMELINE (Nothing OS Dot Style) -->
      <div class="glass-panel rounded-[24px] p-6 sm:p-8 framer-shadow">
        <h3 class="font-display font-extrabold text-sm uppercase tracking-wider text-black mb-6 flex items-center gap-2 border-b border-[#EAEAEA] pb-3">
          <i class="fa-solid fa-clock-rotate-left text-xs"></i> TIMELINE PENGIRIMAN
        </h3>

        <div class="tracking-timeline-track space-y-8 relative">
          
          <?php
            // Timeline mapping logic based on statuses:
            // Pesanan Dikonfirmasi, Pembayaran Lunas, STNK Selesai, Kurir Ditugaskan, Dalam Perjalanan, Tiba di Lokasi, Kendaraan Diserahkan, Selesai
            
            $current_status = $delivery['status_pengiriman'];
            $stnk_done = ($booking['stnk_status'] === 'completed');
            $lunas = ($booking['pelunasan_status'] === 'paid');
            $active_status = ($booking['status'] === 'active' || $booking['status'] === 'completed');

            // Set state variables
            $step_confirmed = $active_status;
            $step_lunas = $lunas;
            $step_stnk = $stnk_done;
            $step_assigned = in_array($current_status, array('Kurir Ditugaskan', 'Menunggu Penjemputan', 'Kendaraan Dipersiapkan', 'Dalam Perjalanan', 'Tiba di Lokasi', 'Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai'));
            $step_prepped = in_array($current_status, array('Kendaraan Dipersiapkan', 'Dalam Perjalanan', 'Tiba di Lokasi', 'Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai'));
            $step_transit = in_array($current_status, array('Dalam Perjalanan', 'Tiba di Lokasi', 'Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai'));
            $step_arrived = in_array($current_status, array('Tiba di Lokasi', 'Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai'));
            $step_handover = in_array($current_status, array('Kendaraan Diserahkan', 'Diserahkan ke Pembeli', 'Selesai'));
            $step_complete = ($current_status === 'Selesai');
          ?>

          <!-- 1. Pesanan Dikonfirmasi -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_confirmed ? 'completed' : 'active'; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_confirmed ? 'text-black' : 'text-neutral-400'; ?>">Pesanan Dikonfirmasi</span>
            <span class="text-[9px] font-mono text-neutral-500">Unit kendaraan telah di-booking secara sah</span>
          </div>

          <!-- 2. Pembayaran Lunas -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_lunas ? ($step_stnk ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_lunas ? 'text-black' : 'text-neutral-400'; ?>">Pembayaran OTR Lunas</span>
            <span class="text-[9px] font-mono text-neutral-500">Pelunasan sisa 70% OTR terverifikasi</span>
          </div>

          <!-- 3. STNK Selesai -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_stnk ? ($step_assigned ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_stnk ? 'text-black' : 'text-neutral-400'; ?>">STNK & Plat Nomor Selesai</span>
            <span class="text-[9px] font-mono text-neutral-500">Dokumen jalan kepolisian selesai diproses</span>
          </div>

          <!-- 4. Kurir Ditugaskan -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_assigned ? ($step_prepped ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_assigned ? 'text-black' : 'text-neutral-400'; ?>">Kurir Ditugaskan</span>
            <span class="text-[9px] font-mono text-neutral-500">Surat Jalan <?php echo esc($delivery['nomor_surat'] ? $delivery['nomor_surat'] : 'SJ/...'); ?> dibuat</span>
          </div>

          <!-- 5. Dalam Perjalanan -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_transit ? ($step_arrived ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_transit ? 'text-black' : 'text-neutral-400'; ?>">Dalam Perjalanan</span>
            <span class="text-[9px] font-mono text-neutral-500">Kendaraan sedang diantar ke alamat rumah</span>
          </div>

          <!-- 6. Tiba di Lokasi -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_arrived ? ($step_handover ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_arrived ? 'text-black' : 'text-neutral-400'; ?>">Tiba di Lokasi Tujuan</span>
            <span class="text-[9px] font-mono text-neutral-500">Kurir telah sampai di depan rumah tujuan</span>
          </div>

          <!-- 7. Serah Terima Unit -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_handover ? ($step_complete ? 'completed' : 'active') : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_handover ? 'text-black' : 'text-neutral-400'; ?>">Kendaraan Diserahkan</span>
            <span class="text-[9px] font-mono text-neutral-500">Penandatanganan berkas & verifikasi foto fisik</span>
          </div>

          <!-- 8. Selesai -->
          <div class="relative flex flex-col gap-1 pl-2">
            <div class="tracking-timeline-dot <?php echo $step_complete ? 'completed' : ''; ?>"></div>
            <span class="font-display font-bold text-xs <?php echo $step_complete ? 'text-black' : 'text-neutral-400'; ?>">Selesai</span>
            <span class="text-[9px] font-mono text-neutral-500">Seluruh rangkaian pengiriman dan administrasi selesai</span>
          </div>

        </div>

      </div>

      <!-- DELIVERY LOCATION SUMMARY CARD -->
      <div class="glass-panel rounded-[24px] p-6 text-xs font-mono framer-shadow">
        <h4 class="font-display font-bold text-[10px] text-neutral-400 uppercase tracking-widest mb-3 block">INFORMASI TUJUAN</h4>
        <div class="space-y-3">
          <div class="flex flex-col gap-0.5">
            <span class="text-[#999] text-[9px] uppercase">Alamat Penerima:</span>
            <strong class="text-black font-sans text-xs leading-normal"><?php echo esc($delivery['alamat_tujuan']); ?></strong>
          </div>
          <div class="flex flex-col gap-0.5 pt-2 border-t border-[#EAEAEA]">
            <span class="text-[#999] text-[9px] uppercase">Nomor Surat Jalan:</span>
            <strong class="text-black font-bold"><?php echo esc($delivery['nomor_surat'] ? $delivery['nomor_surat'] : 'Belum Terbit'); ?></strong>
          </div>
        </div>
      </div>
      
    </div>

  </div>
</section>

<!-- REALTIME LOCATION SCRIPT USING LEAFLET JS -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    
    // Alamat tujuan koordinat default (Jakarta/Depok area untuk simulasi)
    // Gunakan sebaran geocode statis atau fallback jika tidak ada tracking
    const clientAddress = "<?php echo esc(str_replace('"', '', $delivery['alamat_tujuan'])); ?>";
    
    // Pusat showroom DRIVE.X (Start point)
    const startPoint = [-6.200000, 106.816666]; // Jakarta Pusat
    
    // Dummy target koordinat berdasarkan hash alamat tujuan agar konsisten
    let hash = 0;
    for (let i = 0; i < clientAddress.length; i++) {
      hash = clientAddress.charCodeAt(i) + ((hash << 5) - hash);
    }
    const latOffset = (hash % 100) / 1500;
    const lngOffset = ((hash >> 2) % 100) / 1500;
    
    // Koordinat Rumah Pelanggan
    const customerLocation = [startPoint[0] + latOffset, startPoint[1] + lngOffset];

    // Inisialisasi Peta Leaflet (Light Premium Style)
    const map = L.map('map-container').setView(startPoint, 13);
    
    // Tile CartoDB Positron (Premium Light Monochrome Map)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
      subdomains: 'abcd',
      maxZoom: 20
    }).addTo(map);

    // Custom Icon Marker Premium Nothing OS
    // Marker Rumah Customer
    const homeIcon = L.divIcon({
      html: `<div style="width:36px;height:36px;background:#ffffff;border:2px solid #000000;border-radius:50%;box-shadow:0 6px 16px rgba(0,0,0,0.12);display:flex;align-items:center;justify-content:center;">
              <i class="fa-solid fa-house" style="color:#000000;font-size:14px;"></i>
             </div>`,
      className: '',
      iconSize: [36, 36],
      iconAnchor: [18, 18]
    });

    // Marker Kurir (Mobil Hitam Premium)
    const carIcon = L.divIcon({
      html: `<div style="width:40px;height:40px;background:#000000;border:2.5px solid #ffffff;border-radius:50%;box-shadow:0 8px 24px rgba(0,0,0,0.22);display:flex;align-items:center;justify-content:center;transition: transform 0.3s ease;">
              <i class="fa-solid fa-car-side" style="color:#ffffff;font-size:15px;"></i>
             </div>`,
      className: '',
      iconSize: [40, 40],
      iconAnchor: [20, 20]
    });

    // Tambahkan Marker Rumah
    const customerMarker = L.marker(customerLocation, {icon: homeIcon}).addTo(map)
      .bindPopup("<b>Alamat Pengiriman Tujuan</b><br>" + clientAddress);

    // Variabel untuk Marker Kurir dan Rute Jalan
    let courierMarker = null;
    let routeLine = null;
    
    // Gambar garis rute awal dari showroom ke rumah
    const initialRoute = [startPoint, customerLocation];
    routeLine = L.polyline(initialRoute, {
      color: '#000000',
      weight: 3,
      opacity: 0.75,
      className: 'route-glow'
    }).addTo(map);
    
    // Fit map bounds to show both initially
    map.fitBounds(routeLine.getBounds(), {padding: [50, 50]});

    // Fungsi Fetch Real-time data dari API
    function fetchTracking() {
      fetch('<?php echo base_url("booking/get_tracking_data_api/" . $delivery["id_pengiriman"]); ?>')
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            let currentCoord = startPoint;
            let speed = 0;
            let statusText = "Kurir sedang bersiap.";
            
            if (res.latest) {
              const lat = parseFloat(res.latest.latitude);
              const lng = parseFloat(res.latest.longitude);
              speed = parseFloat(res.latest.speed);
              currentCoord = [lat, lng];
              statusText = "Kurir sedang dalam perjalanan.";
            }

            // 1. Pindahkan / buat marker kurir
            if (!courierMarker) {
              courierMarker = L.marker(currentCoord, {icon: carIcon}).addTo(map)
                .bindPopup(`<b>Mobil Pengiriman DRIVE.X</b><br>${statusText}`);
            } else {
              courierMarker.setLatLng(currentCoord);
              courierMarker.setPopupContent(`<b>Mobil Pengiriman DRIVE.X</b><br>${statusText}`);
            }

            // 2. Perbarui route path dari lokasi kurir saat ini ke rumah customer
            if (routeLine) {
              map.removeLayer(routeLine);
            }
            routeLine = L.polyline([currentCoord, customerLocation], {
              color: '#000000',
              weight: 3.5,
              opacity: 0.85,
              className: 'route-glow',
              dashArray: '8, 8'
            }).addTo(map);

            // 3. Update ETA secara logis berdasarkan jarak (Haversine Formula)
            const distance = getDistance(currentCoord[0], currentCoord[1], customerLocation[0], customerLocation[1]); // dalam km
            const speedKmh = speed > 5 ? speed : 35; // Kecepatan rata-rata default 35 km/jam jika diam
            const timeHours = distance / speedKmh;
            const timeMinutes = Math.round(timeHours * 60);
            
            document.getElementById('eta-text').innerHTML = `${distance.toFixed(1)} KM &bull; ~${timeMinutes} Menit`;
            
            // Auto pan/zoom map agar fokus ke pergerakan kurir
            const group = new L.featureGroup([courierMarker, customerMarker]);
            map.fitBounds(group.getBounds(), {padding: [50, 50], maxZoom: 16});
          }
        })
        .catch(err => console.error('Error fetching tracking api:', err));
    }

    // Hitung Jarak Geografis antara dua titik
    function getDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // Radius of the earth in km
      const dLat = deg2rad(lat2 - lat1);
      const dLon = deg2rad(lon2 - lon1);
      const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
        Math.sin(dLon/2) * Math.sin(dLon/2); 
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      const d = R * c; // Distance in km
      return d;
    }

    function deg2rad(deg) {
      return deg * (Math.PI/180);
    }

    // Jalankan polling API setiap 4 detik
    fetchTracking();
    setInterval(fetchTracking, 4000);
  });

  // Rating Modal controllers
  function openRatingModal() {
    const overlay = document.getElementById('rating-modal-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Set default stars to 5
    setRating('showroom', 5);
    setRating('kurir', 5);
  }

  function closeRatingModal() {
    const overlay = document.getElementById('rating-modal-overlay');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
  }

  function setRating(target, val) {
    document.getElementById(`input-rating-${target}`).value = val;
    const starContainer = document.getElementById(`stars-${target}`);
    const stars = starContainer.querySelectorAll('i');
    
    stars.forEach(star => {
      const starVal = parseInt(star.getAttribute('data-value'));
      if (starVal <= val) {
        star.classList.remove('fa-regular', 'text-neutral-300');
        star.classList.add('fa-solid', 'text-black');
      } else {
        star.classList.remove('fa-solid', 'text-black');
        star.classList.add('fa-regular', 'text-neutral-300');
      }
    });
  }
</script>

<!-- RATING MODAL OVERLAY -->
<div id="rating-modal-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); backdrop-filter:blur(8px); align-items:center; justify-content:center; padding:16px;">
  <div id="rating-modal-box" class="glass-panel" style="background:#fff; border-radius:28px; width:100%; max-width:480px; padding:32px; border:1px solid #EAEAEA; box-shadow:0 32px 80px rgba(0,0,0,0.18);">
    
    <!-- Header -->
    <div class="flex justify-between items-center border-b border-[#EAEAEA] pb-4 mb-6">
      <h3 class="font-display font-extrabold text-base text-black uppercase tracking-wider">Konfirmasi &amp; Penilaian</h3>
      <button onclick="closeRatingModal()" class="text-neutral-400 hover:text-black transition-colors"><i class="fa-solid fa-xmark text-lg"></i></button>
    </div>

    <!-- Rating Form -->
    <?php echo form_open('booking/confirm_delivery_arrival/' . $booking['id'], ['id' => 'ratingForm', 'class' => 'space-y-6']); ?>
      
      <p class="text-xs text-neutral-600 leading-relaxed font-sans">
        Dengan mengklik konfirmasi, Anda menyatakan bahwa unit mobil bekas premium Anda telah diterima dengan kondisi baik.
      </p>

      <!-- Rating Showroom -->
      <div class="space-y-2">
        <label class="text-[10px] text-neutral-500 font-mono uppercase tracking-wider font-semibold block">Beri Nilai Showroom (DRIVE.X)</label>
        <div class="flex gap-2 text-2xl" id="stars-showroom">
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="1" onclick="setRating('showroom', 1)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="2" onclick="setRating('showroom', 2)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="3" onclick="setRating('showroom', 3)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="4" onclick="setRating('showroom', 4)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="5" onclick="setRating('showroom', 5)"></i>
        </div>
        <input type="hidden" name="rating_showroom" id="input-rating-showroom" value="5">
      </div>

      <!-- Rating Kurir -->
      <div class="space-y-2">
        <label class="text-[10px] text-neutral-500 font-mono uppercase tracking-wider font-semibold block">Beri Nilai Kurir Pengirim</label>
        <div class="flex gap-2 text-2xl" id="stars-kurir">
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="1" onclick="setRating('kurir', 1)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="2" onclick="setRating('kurir', 2)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="3" onclick="setRating('kurir', 3)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="4" onclick="setRating('kurir', 4)"></i>
          <i class="fa-star fa-regular cursor-pointer transition-colors" data-value="5" onclick="setRating('kurir', 5)"></i>
        </div>
        <input type="hidden" name="rating_kurir" id="input-rating-kurir" value="5">
      </div>

      <!-- Catatan Ulasan -->
      <div class="space-y-2">
        <label class="text-[10px] text-neutral-500 font-mono uppercase tracking-wider font-semibold block">Ulasan / Kritik &amp; Saran (Opsional)</label>
        <textarea name="review_text" placeholder="Tuliskan ulasan pengalaman Anda..." class="w-full bg-neutral-50 border border-[#DADADA] focus:border-black text-black font-sans p-3 rounded-xl h-20 outline-none resize-none transition-all text-xs"></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full py-4 rounded-full bg-black text-white hover:bg-neutral-800 font-sans font-bold uppercase text-xs tracking-wider transition-all duration-300">
        Selesaikan &amp; Kirim Ulasan
      </button>

    </form>

  </div>
</div>
