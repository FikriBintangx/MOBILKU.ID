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
  
  /* Custom map styling */
  #admin-map {
    height: 600px;
    border-radius: 24px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }
  
  /* Leaflet custom map color styling - Light Premium Map */
  .light-premium-map .leaflet-tile {
    filter: grayscale(1) contrast(1.15) brightness(0.98) opacity(0.92);
  }

  .courier-list-item {
    transition: all 0.2s ease;
  }
  .courier-list-item:hover {
    border-color: #000000 !important;
    background-color: #FAFAFA;
  }
  .active-badge {
    animation: pulse-green 2s infinite;
  }
  @keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
    70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
  }
</style>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 nothing-dot-bg">
  
  <!-- Header & Back to Dashboard -->
  <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
      <a href="<?php echo base_url('admin'); ?>" class="inline-flex items-center gap-2 text-xs font-mono font-bold text-neutral-500 hover:text-black transition-colors mb-2">
        <i class="fa-solid fa-arrow-left"></i> KEMBALI KELOLA TRANSAKSI
      </a>
      <h2 class="font-display font-extrabold text-2xl tracking-tight text-black flex items-center gap-2">
        <i class="fa-solid fa-earth-asia text-black"></i> MONITORING PENGIRIMAN UNIT
      </h2>
      <p class="text-[10px] font-mono text-neutral-500 uppercase tracking-widest mt-1">PETA AKTIVITAS LOGISTIK DAN KURIR REALTIME</p>
    </div>
    
    <div class="glass-panel px-4 py-2.5 rounded-2xl flex items-center gap-3">
      <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 active-badge"></span>
      <span class="font-mono text-xs font-bold text-black uppercase tracking-wider">LIVE RADAR AKTIF</span>
    </div>
  </div>

  <!-- Row 1: Dashboard Widgets -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-shadow">
      <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Total Pengiriman Hari Ini</span>
      <span class="text-black font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['total_hari_ini']; ?></span>
    </div>
    <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-shadow">
      <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Dalam Perjalanan</span>
      <span class="text-black font-display font-extrabold text-2xl mt-1 block text-blue-600"><?php echo $stats['perjalanan']; ?></span>
    </div>
    <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-shadow">
      <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Pengiriman Selesai</span>
      <span class="text-emerald-600 font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['selesai']; ?></span>
    </div>
    <div class="bg-white border border-[#EAEAEA] rounded-[20px] p-5 shadow-sm framer-shadow">
      <span class="text-[#666666] block text-[9px] uppercase font-mono tracking-wider">Gagal / Tertunda</span>
      <span class="text-amber-600 font-display font-extrabold text-2xl mt-1 block"><?php echo $stats['tertunda']; ?></span>
    </div>
  </div>

  <!-- Main Split Layout -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- LEFT SIDEBAR: LIST OF ACTIVE COURIERS & DETAILS -->
    <div class="lg:col-span-4 flex flex-col gap-6">
      
      <!-- List of active courier deliveries -->
      <div class="glass-panel rounded-[24px] p-6 framer-shadow flex-grow flex flex-col" style="max-height: 600px;">
        <h3 class="font-display font-extrabold text-sm uppercase tracking-wider text-black mb-4 flex items-center gap-1.5 border-b border-[#EAEAEA] pb-3">
          <i class="fa-solid fa-truck-fast text-xs"></i> KURIR AKTIF DI JALAN
        </h3>
        
        <div class="overflow-y-auto space-y-3 flex-grow pr-1" id="active-couriers-list">
          <div class="text-center py-12 text-neutral-400 font-mono text-xs">
            Mencari data kurir aktif...
          </div>
        </div>
      </div>
      
    </div>

    <!-- RIGHT SIDE: THE LIVE MAP -->
    <div class="lg:col-span-8">
      <div class="relative bg-white rounded-[24px] overflow-hidden border border-black/8 framer-shadow">
        
        <!-- Floating Info Card ala Framer (Hidden by default, shown on marker click) -->
        <div id="info-card" class="absolute bottom-6 left-6 right-6 lg:right-auto lg:w-96 z-[999] glass-panel p-6 rounded-3xl shadow-xl border border-black/10 font-mono text-xs hidden transition-all duration-300">
          <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-3 mb-3">
            <span class="font-bold text-black text-sm uppercase" id="card-driver-name">NAMA DRIVER</span>
            <button onclick="closeInfoCard()" class="text-neutral-400 hover:text-black text-sm"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-neutral-500">Mobil:</span>
              <span class="text-black font-bold uppercase" id="card-car-name">-</span>
            </div>
            <div class="flex justify-between">
              <span class="text-neutral-500">Plat Nomor:</span>
              <span class="text-black font-bold" id="card-plate-number">-</span>
            </div>
            <div class="flex justify-between">
              <span class="text-neutral-500">Penerima:</span>
              <span class="text-black font-bold" id="card-client-name">-</span>
            </div>
            <div class="flex justify-between">
              <span class="text-neutral-500">Nomor SJ:</span>
              <span class="text-black font-bold" id="card-sj-number">-</span>
            </div>
            <div class="flex justify-between">
              <span class="text-neutral-500">Status:</span>
              <span class="px-2 py-0.5 rounded-full border border-black/10 bg-black text-white text-[9px] font-bold uppercase" id="card-status">-</span>
            </div>
            <div class="flex justify-between pt-2 border-t border-[#EAEAEA]">
              <span class="text-neutral-500">Estimasi Tiba:</span>
              <span class="text-black font-extrabold" id="card-eta">Menghitung...</span>
            </div>
          </div>
        </div>

        <div id="admin-map" class="light-premium-map"></div>
      </div>
    </div>

  </div>
</section>

<!-- ADMIN MONITORING REALTIME LOGIC -->
<script>
  let map;
  let markers = {};
  let currentActiveDeliveries = [];
  
  // Showroom center point (DRIVE.X headquarter)
  const headquarterCoords = [-6.200000, 106.816666];

  document.addEventListener("DOMContentLoaded", function() {
    
    // Inisialisasi map
    map = L.map('admin-map').setView(headquarterCoords, 11);

    // CartoDB Positron style (Light premium monochrome map)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
      subdomains: 'abcd',
      maxZoom: 20
    }).addTo(map);

    // Marker Icon Showroom / Headquarter
    const showroomIcon = L.divIcon({
      html: `<div style="width:34px;height:34px;background:#000000;border:2.5px solid #ffffff;border-radius:10px;box-shadow:0 6px 16px rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:center;">
              <i class="fa-solid fa-building-flag" style="color:#ffffff;font-size:13px;"></i>
             </div>`,
      className: '',
      iconSize: [34, 34],
      iconAnchor: [17, 17]
    });

    // Tambah marker Showroom
    L.marker(headquarterCoords, {icon: showroomIcon}).addTo(map)
      .bindPopup("<b>DRIVE.X Showroom Utama</b><br>Pusat Distribusi Kendaraan.");

    // Load radar update loop
    fetchActiveLocations();
    setInterval(fetchActiveLocations, 4000);
  });

  // Fetch coordinates of all active dispatches
  function fetchActiveLocations() {
    fetch('<?php echo base_url("admin/get_active_locations_api"); ?>')
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          currentActiveDeliveries = res.data;
          renderCourierList(res.data);
          updateMapMarkers(res.data);
        }
      })
      .catch(err => console.error("Error updating radar:", err));
  }

  // Render left sidebar list dynamically
  function renderCourierList(list) {
    const container = document.getElementById('active-couriers-list');
    if (list.length === 0) {
      container.innerHTML = `
        <div class="text-center py-16 text-neutral-400 font-mono text-xs">
          <i class="fa-solid fa-satellite text-3xl mb-3 text-black/10 block"></i>
          Tidak ada kurir aktif di jalan saat ini.
        </div>
      `;
      return;
    }

    let html = '';
    list.forEach(item => {
      html += `
        <div onclick="focusCourier(${item.id_pengiriman})" class="courier-list-item p-4 bg-white border border-[#EAEAEA] rounded-2xl cursor-pointer font-mono text-xs framer-shadow flex justify-between items-center gap-3">
          <div>
            <strong class="text-black uppercase block text-sm">${item.courier_name || 'Kurir'}</strong>
            <span class="text-[10px] text-neutral-500 mt-0.5 block">${item.brand} ${item.model} &bull; ${item.plate_number}</span>
            <span class="text-[9px] text-[#FF3B30] uppercase font-bold mt-1 inline-block">● ${item.status_pengiriman}</span>
          </div>
          <button class="w-8 h-8 rounded-full bg-[#FAFAFA] border border-[#EAEAEA] flex items-center justify-center hover:bg-black hover:text-white transition-all">
            <i class="fa-solid fa-location-crosshairs text-xs"></i>
          </button>
        </div>
      `;
    });
    container.innerHTML = html;
  }

  // Update markers on the map
  function updateMapMarkers(list) {
    // Custom Premium Courier Icon (Black car)
    const activeCarIcon = L.divIcon({
      html: `<div style="width:38px;height:38px;background:#000000;border:2px solid #ffffff;border-radius:50%;box-shadow:0 8px 24px rgba(0,0,0,0.18);display:flex;align-items:center;justify-content:center;">
              <i class="fa-solid fa-car-side" style="color:#ffffff;font-size:14px;"></i>
             </div>`,
      className: '',
      iconSize: [38, 38],
      iconAnchor: [19, 19]
    });

    // Simpan list ID yang baru di-radar
    let newIds = new Set();

    list.forEach(item => {
      const id = item.id_pengiriman;
      newIds.add(id);

      if (item.latest_location) {
        const lat = parseFloat(item.latest_location.latitude);
        const lng = parseFloat(item.latest_location.longitude);
        const coord = [lat, lng];

        if (markers[id]) {
          // Pindahkan marker yang ada secara smooth
          markers[id].setLatLng(coord);
        } else {
          // Buat marker baru jika belum ada
          const marker = L.marker(coord, {icon: activeCarIcon}).addTo(map);
          marker.on('click', () => showInfoCard(item));
          markers[id] = marker;
        }
      }
    });

    // Bersihkan marker kurir yang sudah tidak aktif (selesai/batal)
    for (let id in markers) {
      if (!newIds.has(parseInt(id))) {
        map.removeLayer(markers[id]);
        delete markers[id];
      }
    }
  }

  // Focus Map view onto selected courier
  function focusCourier(id) {
    const item = currentActiveDeliveries.find(d => d.id_pengiriman === id);
    if (item && item.latest_location) {
      const lat = parseFloat(item.latest_location.latitude);
      const lng = parseFloat(item.latest_location.longitude);
      map.setView([lat, lng], 14);
      showInfoCard(item);
    }
  }

  // Show detailed info card for a clicked courier
  function showInfoCard(item) {
    document.getElementById('card-driver-name').innerText = item.courier_name || 'Driver';
    document.getElementById('card-car-name').innerText = `${item.brand} ${item.model}`;
    document.getElementById('card-plate-number').innerText = item.plate_number;
    document.getElementById('card-client-name').innerText = item.client_name;
    document.getElementById('card-sj-number').innerText = item.nomor_surat || '-';
    document.getElementById('card-status').innerText = item.status_pengiriman;

    // Calculate simulated ETA based on headquarter coordinates
    let dist = 12.5; // fallback
    if (item.latest_location) {
      // Dummy destination coordinate hash
      const clientAddress = item.alamat_tujuan;
      let hash = 0;
      for (let i = 0; i < clientAddress.length; i++) {
        hash = clientAddress.charCodeAt(i) + ((hash << 5) - hash);
      }
      const latOffset = (hash % 100) / 1500;
      const lngOffset = ((hash >> 2) % 100) / 1500;
      const customerLocation = [headquarterCoords[0] + latOffset, headquarterCoords[1] + lngOffset];
      
      dist = getDistance(
        parseFloat(item.latest_location.latitude), 
        parseFloat(item.latest_location.longitude), 
        customerLocation[0], 
        customerLocation[1]
      );
    }

    const etaMins = Math.round((dist / 35) * 60);
    document.getElementById('card-eta').innerHTML = `${dist.toFixed(1)} KM &bull; ~${etaMins} Menit`;

    const card = document.getElementById('info-card');
    card.classList.remove('hidden');

    // Trigger elegant Framer-style spring entrance with Anime.js
    anime({
      targets: '#info-card',
      translateY: [20, 0],
      opacity: [0, 1],
      scale: [0.95, 1],
      duration: 350,
      easing: 'easeOutQuad'
    });
  }

  function closeInfoCard() {
    document.getElementById('info-card').classList.add('hidden');
  }

  // Hitung Jarak Geografis
  function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = degToRad(lat2 - lat1);
    const dLon = degToRad(lon2 - lon1);
    const a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(degToRad(lat1)) * Math.cos(degToRad(lat2)) * 
      Math.sin(dLon/2) * Math.sin(dLon/2); 
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    return R * c;
  }

  function degToRad(deg) {
    return deg * (Math.PI/180);
  }
</script>
