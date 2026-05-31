<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sourcing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mobil_model');
        // Ensure sourcing_method column exists in car_sourcing
        if (!$this->db->field_exists('sourcing_method', 'car_sourcing')) {
            $this->db->query("ALTER TABLE car_sourcing ADD COLUMN sourcing_method VARCHAR(20) NOT NULL DEFAULT 'antar'");
        }
    }

    /**
     * Get all sourcing requests
     */
    public function get_all_sourcing() {
        $this->db->select('*');
        $this->db->from('car_sourcing');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get single sourcing ticket
     */
    public function get_sourcing_by_id($id) {
        return $this->db->get_where('car_sourcing', array('id' => $id))->row_array();
    }

    /**
     * Get all sourcing requests for a user
     */
    public function get_sourcing_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('car_sourcing');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Create Sourcing Request from Seller (Web Portal or Lead Form)
     */
    public function create_sourcing_request($data) {
        $insert_data = array(
            'user_id' => $data['user_id'] ?? null,
            'owner_name' => $data['owner_name'],
            'owner_phone' => $data['owner_phone'],
            'owner_address' => $data['owner_address'],
            'car_brand' => $data['car_brand'],
            'car_model' => $data['car_model'],
            'car_year' => $data['car_year'],
            'car_plate' => $data['car_plate'],
            'car_color' => $data['car_color'] ?? null,
            'mileage' => $data['mileage'] ?? 0,
            'price_desired' => $data['price_desired'] ?? null,
            'description' => $data['description'] ?? null,
            'stnk_doc' => $data['stnk_doc'] ?? null,
            'bpkb_doc' => $data['bpkb_doc'] ?? null,
            'photo_front' => $data['photo_front'] ?? null,
            'photo_back' => $data['photo_back'] ?? null,
            'photo_interior' => $data['photo_interior'] ?? null,
            'engine_number' => $data['engine_number'],
            'frame_number' => $data['frame_number'],
            'sourcing_method' => $data['sourcing_method'] ?? 'antar',
            'status' => 'pending'
        );

        $this->db->insert('car_sourcing', $insert_data);
        return $this->db->insert_id();
    }

    /**
     * Update Sourcing Request (e.g. for revision)
     */
    public function update_sourcing_request($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('car_sourcing', $data);
    }

    /**
     * Record Inspection findings by Staff
     */
    public function record_inspection($id, $notes, $price_offered, $status = 'inspected') {
        $update_data = array(
            'inspection_date' => date('Y-m-d H:i:s'),
            'inspection_notes' => $notes,
            'price_offered' => $price_offered,
            'status' => $status
        );

        $this->db->where('id', $id);
        return $this->db->update('car_sourcing', $update_data);
    }

    /**
     * Approve and record payout details
     */
    public function record_payout($id, $method, $bank_name = '', $account = '', $holder = '', $receipt = '') {
        $sourcing = $this->get_sourcing_by_id($id);
        if (!$sourcing) return false;

        $payment_code = 'PAY-SRC-' . strtoupper(substr(uniqid(), 7, 5)) . '-' . date('Ymd');
        
        // Log to payment logs
        $payment_data = array(
            'payment_code' => $payment_code,
            'sourcing_id' => $id,
            'amount' => $sourcing['price_offered'],
            'payment_type' => 'purchase_payout',
            'payment_method' => $method,
            'bank_name' => $bank_name,
            'bank_account' => $account,
            'bank_holder' => $holder,
            'evidence_image' => $receipt,
            'status' => ($method === 'cash') ? 'verified' : 'pending' // Cash is instantly verified, transfer needs bank confirmation
        );

        $this->db->insert('payments', $payment_data);
        $payment_id = $this->db->insert_id();

        // Update sourcing status
        $sourcing_update = array(
            'payment_method' => $method,
            'bank_name' => $bank_name,
            'bank_account' => $account,
            'bank_holder' => $holder,
            'status' => 'purchased'
        );

        if ($method === 'cash') {
            $sourcing_update['payment_status'] = 'paid';
            $sourcing_update['payment_date'] = date('Y-m-d H:i:s');
            $sourcing_update['receipt_number'] = 'KW-SRC-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
            
            // Auto-ingest newly bought car into MAIN catalog as 'available'!
            $this->ingest_car_to_catalog($sourcing);
        }

        $this->db->where('id', $id);
        $this->db->update('car_sourcing', $sourcing_update);

        return $payment_id;
    }

    /**
     * Verify Sourcing bank transfer payments
     */
    public function verify_sourcing_payout($payment_id) {
        $payment = $this->db->get_where('payments', array('id' => $payment_id))->row_array();
        if (!$payment || $payment['status'] !== 'pending' || empty($payment['sourcing_id'])) {
            return false;
        }

        $sourcing_id = $payment['sourcing_id'];
        $sourcing = $this->get_sourcing_by_id($sourcing_id);

        $receipt_number = 'KW-SRC-' . date('Ymd') . '-' . str_pad($sourcing_id, 4, '0', STR_PAD_LEFT);

        // Verify payment
        $this->db->where('id', $payment_id);
        $this->db->update('payments', array(
            'status' => 'verified',
            'receipt_number' => $receipt_number
        ));

        // Update sourcing ticket
        $this->db->where('id', $sourcing_id);
        $this->db->update('car_sourcing', array(
            'payment_status' => 'paid',
            'payment_date' => date('Y-m-d H:i:s'),
            'receipt_number' => $receipt_number
        ));

        // Ingest into inventory catalog
        $this->ingest_car_to_catalog($sourcing);

        return true;
    }

    /**
     * Helper to automatically convert an acquired vehicle to the catalog list
     */
    private function ingest_car_to_catalog($sourcing) {
        $car_data = array(
            'brand' => $sourcing['car_brand'],
            'model' => $sourcing['car_model'],
            'type' => 'Second-Hand',
            'year' => $sourcing['car_year'],
            'price' => $sourcing['price_offered'] * 1.15, // Auto-mark up 15% for business profit margin!
            'color' => $sourcing['car_color'] ? $sourcing['car_color'] : 'Default Color',
            'plate_number' => $sourcing['car_plate'],
            'engine_number' => $sourcing['engine_number'],
            'frame_number' => $sourcing['frame_number'],
            'image_url' => $sourcing['photo_front'] ? $sourcing['photo_front'] : 'generic_car.png',
            'status' => 'available',
            'description' => $sourcing['description'] ? $sourcing['description'] : 'Mobil bekas terawat hasil sourcing individu owner ' . $sourcing['owner_name'] . '. Lolos inspeksi kelayakan fisik dan mesin.'
        );

        $this->Mobil_model->insert_car($car_data);
    }
}
