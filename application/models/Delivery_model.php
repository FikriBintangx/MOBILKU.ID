<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Create initial delivery request from buyer checkout/config
     */
    public function create_delivery($booking_id, $address) {
        // Check if delivery request already exists
        $existing = $this->db->get_where('pengiriman', array('id_transaksi' => $booking_id))->row_array();
        if ($existing) {
            return $existing['id_pengiriman'];
        }

        $data = array(
            'id_transaksi' => $booking_id,
            'alamat_tujuan' => $address,
            'status_pengiriman' => 'Menunggu Penugasan',
            'tanggal_pengiriman' => date('Y-m-d H:i:s')
        );

        $this->db->insert('pengiriman', $data);
        $id_pengiriman = $this->db->insert_id();

        // Log status history
        $this->add_status_history($id_pengiriman, 'Menunggu Penugasan');

        // Update booking delivery status
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', array('delivery_status' => 'pending'));

        return $id_pengiriman;
    }

    /**
     * Admin assigns courier to a delivery ticket
     */
    public function assign_courier($id_pengiriman, $id_kurir) {
        $this->db->where('id_pengiriman', $id_pengiriman);
        $this->db->update('pengiriman', array(
            'id_kurir' => $id_kurir,
            'status_pengiriman' => 'Kurir Ditugaskan'
        ));

        // Log status history
        $this->add_status_history($id_pengiriman, 'Kurir Ditugaskan');

        // Generate Surat Jalan if not exists
        $this->generate_surat_jalan($id_pengiriman);

        // Update bookings status
        $delivery = $this->get_delivery_by_id($id_pengiriman);
        if ($delivery) {
            $this->db->where('id', $delivery['id_transaksi']);
            $this->db->update('bookings', array('delivery_status' => 'shipping'));
        }

        return true;
    }

    /**
     * Generate unique Surat Jalan number
     */
    public function generate_surat_jalan($id_pengiriman) {
        $existing = $this->db->get_where('surat_jalan', array('id_pengiriman' => $id_pengiriman))->row_array();
        if ($existing) {
            return $existing['id_surat_jalan'];
        }

        $nomor_surat = 'SJ/' . date('Ymd') . '/' . str_pad($id_pengiriman, 5, '0', STR_PAD_LEFT);
        $data = array(
            'id_pengiriman' => $id_pengiriman,
            'nomor_surat' => $nomor_surat,
            'tanggal' => date('Y-m-d')
        );

        $this->db->insert('surat_jalan', $data);
        return $this->db->insert_id();
    }

    /**
     * Update delivery progress status
     */
    public function update_delivery_status($id_pengiriman, $status, $catatan = '') {
        $data = array('status_pengiriman' => $status);
        if (!empty($catatan)) {
            $data['catatan'] = $catatan;
        }

        $this->db->where('id_pengiriman', $id_pengiriman);
        $this->db->update('pengiriman', $data);

        // Log status history
        $this->add_status_history($id_pengiriman, $status);

        // Sync with bookings status
        $delivery = $this->get_delivery_by_id($id_pengiriman);
        if ($delivery) {
            $booking_status = 'shipping';
            if ($status === 'Selesai') {
                $booking_status = 'delivered';
                
                // If delivery is completed, auto-complete the booking
                $this->db->where('id', $delivery['id_transaksi']);
                $this->db->update('bookings', array(
                    'delivery_status' => 'delivered',
                    'status' => 'completed'
                ));
            } elseif ($status === 'Dibatalkan') {
                $booking_status = 'none';
            }
            
            $this->db->where('id', $delivery['id_transaksi']);
            $this->db->update('bookings', array('delivery_status' => $booking_status));
        }

        return true;
    }

    /**
     * Upload photos & signatures for delivery verification
     */
    public function upload_delivery_proof($id_pengiriman, $proof_data) {
        $existing = $this->db->get_where('bukti_pengiriman', array('id_pengiriman' => $id_pengiriman))->row_array();
        
        $data = array(
            'id_pengiriman' => $id_pengiriman,
            'foto_serah_terima' => $proof_data['foto_serah_terima'] ?? null,
            'tanda_tangan_penerima' => $proof_data['tanda_tangan_penerima'] ?? null,
            'foto_kendaraan' => $proof_data['foto_kendaraan'] ?? null,
            'waktu_upload' => date('Y-m-d H:i:s')
        );

        if ($existing) {
            $this->db->where('id_pengiriman', $id_pengiriman);
            $this->db->update('bukti_pengiriman', array_filter($data));
        } else {
            $this->db->insert('bukti_pengiriman', $data);
        }

        return true;
    }

    /**
     * Retrieve single delivery with related transaction, car, customer, and courier details
     */
    public function get_delivery_by_id($id_pengiriman) {
        $this->db->select('p.*, b.booking_code, b.stnk_status, b.bpkb_status, b.pelunasan_status, b.status as booking_overall_status, u.fullname as client_name, u.phone as client_phone, c.brand, c.model, c.year, c.plate_number, c.color, c.engine_number, c.frame_number, c.price as car_price, k.nama as courier_name, k.no_hp as courier_phone, sj.nomor_surat, sj.tanggal as sj_date, bp.foto_serah_terima, bp.tanda_tangan_penerima, bp.foto_kendaraan, bp.waktu_upload');
        $this->db->from('pengiriman p');
        $this->db->join('bookings b', 'p.id_transaksi = b.id');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->join('kurir k', 'p.id_kurir = k.id_kurir', 'left');
        $this->db->join('surat_jalan sj', 'p.id_pengiriman = sj.id_pengiriman', 'left');
        $this->db->join('bukti_pengiriman bp', 'p.id_pengiriman = bp.id_pengiriman', 'left');
        $this->db->where('p.id_pengiriman', $id_pengiriman);
        return $this->db->get()->row_array();
    }

    /**
     * Retrieve all delivery requests (for Admin dashboard)
     */
    public function get_all_deliveries() {
        $this->db->select('p.*, b.booking_code, u.fullname as client_name, c.brand, c.model, c.plate_number, k.nama as courier_name, sj.nomor_surat');
        $this->db->from('pengiriman p');
        $this->db->join('bookings b', 'p.id_transaksi = b.id');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->join('kurir k', 'p.id_kurir = k.id_kurir', 'left');
        $this->db->join('surat_jalan sj', 'p.id_pengiriman = sj.id_pengiriman', 'left');
        $this->db->order_by('p.id_pengiriman', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get deliveries assigned to a specific courier
     */
    public function get_courier_deliveries($id_kurir) {
        $this->db->select('p.*, b.booking_code, u.fullname as client_name, u.phone as client_phone, c.brand, c.model, c.plate_number, sj.nomor_surat');
        $this->db->from('pengiriman p');
        $this->db->join('bookings b', 'p.id_transaksi = b.id');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->join('surat_jalan sj', 'p.id_pengiriman = sj.id_pengiriman', 'left');
        $this->db->where('p.id_kurir', $id_kurir);
        $this->db->order_by('p.id_pengiriman', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get summary metrics for a courier
     */
    public function get_courier_stats($id_kurir) {
        $stats = array(
            'hari_ini' => 0,
            'selesai' => 0,
            'berjalan' => 0,
            'ditunda' => 0
        );

        $this->db->where('id_kurir', $id_kurir);
        $deliveries = $this->db->get('pengiriman')->result_array();

        $today = date('Y-m-d');
        foreach ($deliveries as $d) {
            $d_date = date('Y-m-d', strtotime($d['tanggal_pengiriman'] ?? ''));
            if ($d_date === $today) {
                $stats['hari_ini']++;
            }

            if ($d['status_pengiriman'] === 'Selesai') {
                $stats['selesai']++;
            } elseif (in_array($d['status_pengiriman'], array('Kurir Ditugaskan', 'Kendaraan Dipersiapkan', 'Dalam Perjalanan', 'Tiba di Lokasi', 'Diserahkan ke Pembeli'))) {
                $stats['berjalan']++;
            } elseif ($d['status_pengiriman'] === 'Gagal Kirim') {
                $stats['ditunda']++;
            }
        }

        return $stats;
    }

    /**
     * Update/insert tracking koordinat baru kurir
     */
    public function update_tracking($id_pengiriman, $lat, $lng, $speed = 0.0) {
        $data = array(
            'id_pengiriman' => $id_pengiriman,
            'latitude' => $lat,
            'longitude' => $lng,
            'speed' => $speed,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tracking_lokasi', $data);
        return $this->db->insert_id();
    }

    /**
     * Ambil koordinat tracking terbaru
     */
    public function get_latest_tracking($id_pengiriman) {
        $this->db->where('id_pengiriman', $id_pengiriman);
        $this->db->order_by('id_tracking', 'DESC');
        $this->db->limit(1);
        return $this->db->get('tracking_lokasi')->row_array();
    }

    /**
     * Ambil riwayat koordinat tracking (untuk rute garis)
     */
    public function get_tracking_history($id_pengiriman) {
        $this->db->where('id_pengiriman', $id_pengiriman);
        $this->db->order_by('id_tracking', 'ASC');
        return $this->db->get('tracking_lokasi')->result_array();
    }

    /**
     * Catat riwayat status pengiriman
     */
    public function add_status_history($id_pengiriman, $status) {
        $data = array(
            'id_pengiriman' => $id_pengiriman,
            'status' => $status,
            'waktu' => date('Y-m-d H:i:s')
        );
        $this->db->insert('riwayat_status', $data);
        return $this->db->insert_id();
    }

    /**
     * Ambil seluruh riwayat status untuk timeline
     */
    public function get_status_history($id_pengiriman) {
        $this->db->where('id_pengiriman', $id_pengiriman);
        $this->db->order_by('waktu', 'ASC');
        return $this->db->get('riwayat_status')->result_array();
    }
}

