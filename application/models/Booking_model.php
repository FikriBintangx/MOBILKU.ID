<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mobil_model');
        
        // Ensure rejection_reason column exists in payments table
        if (!$this->db->field_exists('rejection_reason', 'payments')) {
            $this->db->query("ALTER TABLE payments ADD COLUMN rejection_reason VARCHAR(255) DEFAULT NULL");
        }
    }

    /**
     * Fetch all bookings for administrative dashboards.
     */
    public function get_all_bookings() {
        $this->db->select('b.*, u.fullname, u.phone, u.email, c.brand, c.model, c.plate_number, c.price as car_price');
        $this->db->from('bookings b');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->order_by('b.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Fetch user-specific bookings.
     */
    public function get_user_bookings($user_id) {
        $this->db->select('b.*, c.brand, c.model, c.plate_number, c.price as car_price, c.image_url');
        $this->db->from('bookings b');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('b.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Delete multiple bookings by array of IDs.
     * Security: only allows deleting own bookings with status cancelled/completed.
     */
    public function delete_bookings($booking_ids, $user_id) {
        if (empty($booking_ids) || !is_array($booking_ids)) return 0;
        
        // Sanitize: cast all IDs to int to prevent injection
        $safe_ids = array_map('intval', $booking_ids);
        
        // Only delete bookings that:
        // 1. Belong to this user
        // 2. Are in a terminal state (cancelled or completed)
        $this->db->where_in('id', $safe_ids);
        $this->db->where('user_id', $user_id);
        $this->db->where_in('status', ['cancelled', 'completed']);
        $valid = $this->db->get('bookings')->result_array();
        
        if (empty($valid)) return 0;
        
        $valid_ids = array_column($valid, 'id');
        
        // Delete associated payments first (FK constraint safety)
        $this->db->where_in('booking_id', $valid_ids);
        $this->db->delete('payments');
        
        // Delete associated documents
        $this->db->where_in('booking_id', $valid_ids);
        $this->db->delete('documents');
        
        // Delete the bookings
        $this->db->where_in('id', $valid_ids);
        $this->db->delete('bookings');
        
        return count($valid_ids);
    }

    /**
     * Retrieve single booking with complete associations.
     */
    public function get_booking_by_id($booking_id) {
        $this->db->select('b.*, u.fullname, u.phone, u.email, c.brand, c.model, c.type, c.year, c.color, c.plate_number, c.engine_number, c.frame_number, c.price as car_price, c.image_url');
        $this->db->from('bookings b');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->where('b.id', $booking_id);
        return $this->db->get()->row_array();
    }

    /**
     * Start Booking process ("Bukti Pesanan")
     */
    public function create_booking($user_id, $car_id) {
        $car = $this->Mobil_model->get_car_by_id($car_id);
        if (!$car || $car['status'] !== 'available') {
            return false;
        }

        $booking_code = 'BKG-' . strtoupper(substr(uniqid(), 7, 5)) . '-' . date('Y');
        $price = $car['price'];
        
        // Strict Business Rule calculations:
        $dp_amount = $price * 0.30; // 30% of price
        $remaining_payment = $price - $dp_amount; // Remaining 70%

        $booking_date = date('Y-m-d H:i:s');
        $dp_deadline = date('Y-m-d H:i:s', strtotime('+7 days')); // Strictly 1 week to pay DP

        $data = array(
            'booking_code' => $booking_code,
            'user_id' => $user_id,
            'car_id' => $car_id,
            'booking_fee' => 500000.00, // Strictly Rp 500.000
            'booking_fee_status' => 'unpaid',
            'booking_date' => $booking_date,
            'dp_deadline' => $dp_deadline,
            'dp_amount' => $dp_amount,
            'dp_status' => 'unpaid',
            'remaining_payment' => $remaining_payment,
            'pelunasan_status' => 'unpaid',
            'stnk_status' => 'processing',
            'bpkb_status' => 'processing',
            'delivery_status' => 'none',
            'status' => 'ordered' // Initial ordered state
        );

        $this->db->insert('bookings', $data);
        $booking_id = $this->db->insert_id();

        // Lock the car instantly: set stock to 0 which automatically marks status as 'booked'
        $this->Mobil_model->update_car_stock($car_id, 0);

        return $booking_id;
    }

    /**
     * Log and verify Payment tickets
     */
    public function log_payment($booking_id, $amount, $payment_type, $method, $bank_name = '', $account = '', $holder = '', $evidence = '') {
        $payment_code = 'PAY-' . strtoupper(substr(uniqid(), 7, 5)) . '-' . date('Ymd');
        
        $data = array(
            'payment_code' => $payment_code,
            'booking_id' => $booking_id,
            'amount' => $amount,
            'payment_type' => $payment_type,
            'payment_method' => $method,
            'bank_name' => $bank_name,
            'bank_account' => $account,
            'bank_holder' => $holder,
            'evidence_image' => $evidence,
            'status' => 'pending' // Admin needs to verify
        );

        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }

    /**
     * Admin verification of payments
     */
    public function verify_payment($payment_id) {
        $payment = $this->db->get_where('payments', array('id' => $payment_id))->row_array();
        if (!$payment || $payment['status'] !== 'pending') {
            return false;
        }

        $booking_id = $payment['booking_id'];
        $type = $payment['payment_type'];
        $receipt_number = 'KW-' . date('Ymd') . '-' . str_pad($payment_id, 4, '0', STR_PAD_LEFT);

        // Update payment ticket
        $this->db->where('id', $payment_id);
        $this->db->update('payments', array(
            'status' => 'verified',
            'receipt_number' => $receipt_number
        ));

        // Update relevant booking state
        $booking_update = array();
        if ($type === 'booking_fee') {
            $booking_update['booking_fee_status'] = 'paid';
            $booking_update['status'] = 'active'; // Becomes fully active
        } elseif ($type === 'dp') {
            $booking_update['dp_status'] = 'paid';
            $booking_update['dp_date'] = date('Y-m-d H:i:s');
            
            // Log KTP document record automatically from uploaded evidence if present
            $booking = $this->get_booking_by_id($booking_id);
            if (!empty($booking['ktp_image'])) {
                $this->db->insert('documents', array(
                    'booking_id' => $booking_id,
                    'document_type' => 'ktp',
                    'file_path' => $booking['ktp_image']
                ));
            }
        } elseif ($type === 'pelunasan') {
            $booking_update['pelunasan_status'] = 'paid';
            $booking_update['pelunasan_date'] = date('Y-m-d H:i:s');
        }

        if (!empty($booking_update)) {
            $this->db->where('id', $booking_id);
            $this->db->update('bookings', $booking_update);
        }

        return true;
    }

    /**
     * Admin rejection of payments with a custom reason
     */
    public function reject_payment($payment_id, $reason) {
        $payment = $this->db->get_where('payments', array('id' => $payment_id))->row_array();
        if (!$payment || $payment['status'] !== 'pending') {
            return false;
        }

        // Update payment ticket
        $this->db->where('id', $payment_id);
        $this->db->update('payments', array(
            'status' => 'rejected',
            'rejection_reason' => $reason
        ));

        return true;
    }

    /**
     * Upload DP & scan copy of KTP
     */
    public function upload_dp_ktp($booking_id, $ktp_file, $evidence_file, $method, $bank_name = '', $account = '', $holder = '') {
        $booking = $this->get_booking_by_id($booking_id);
        if (!$booking) return false;

        // Update KTP file in booking
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', array('ktp_image' => $ktp_file));

        // Log payment ticket for the DP amount
        return $this->log_payment($booking_id, $booking['dp_amount'], 'dp', $method, $bank_name, $account, $holder, $evidence_file);
    }

    /**
     * STNK / BPKB status updates
     */
    public function update_doc_progress($booking_id, $doc_type, $status) {
        $data = array();
        $date_field = ($doc_type === 'stnk') ? 'stnk_completed_date' : 'bpkb_completed_date';
        
        $data[$doc_type . '_status'] = $status;
        $data[$date_field] = ($status === 'completed') ? date('Y-m-d H:i:s') : null;

        $this->db->where('id', $booking_id);
        $this->db->update('bookings', $data);

        // If completed, register standard system document
        if ($status === 'completed') {
            $doc_number = ($doc_type === 'stnk') ? 'STNK-' . strtoupper(substr(uniqid(), 8, 4)) : 'BPKB-' . strtoupper(substr(uniqid(), 8, 4));
            $this->db->insert('documents', array(
                'booking_id' => $booking_id,
                'document_type' => $doc_type,
                'document_number' => $doc_number,
                'file_path' => $doc_type . '_mock.pdf'
            ));
        }
        return true;
    }

    /**
     * Configure car fulfillment options (Pickup or Delivery)
     */
    public function set_fulfillment($booking_id, $type, $address = '') {
        $booking = $this->get_booking_by_id($booking_id);
        if (!$booking || $booking['stnk_status'] !== 'completed' || $booking['pelunasan_status'] !== 'paid') {
            return false; // Can only dispatch/deliver once STNK is finished AND paid in full
        }

        $data = array(
            'delivery_type' => $type,
            'delivery_address' => ($type === 'delivery') ? $address : null,
            'delivery_status' => ($type === 'delivery') ? 'pending' : 'none'
        );

        $this->db->where('id', $booking_id);
        $this->db->update('bookings', $data);

        // If delivery, Admin creates Surat Jalan
        if ($type === 'delivery') {
            $sj_number = 'SJ-' . date('Ymd') . '-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT);
            $this->db->insert('documents', array(
                'booking_id' => $booking_id,
                'document_type' => 'surat_jalan',
                'document_number' => $sj_number,
                'file_path' => 'surat_jalan_' . $booking_id . '.pdf'
            ));
        }

        return true;
    }

    /**
     * Update delivery statuses by Kurir
     */
    public function update_delivery_status($booking_id, $status) {
        $this->db->where('id', $booking_id);
        return $this->db->update('bookings', array('delivery_status' => $status));
    }

    /**
     * Handover BPKB & Complete booking
     */
    public function complete_booking($booking_id) {
        $booking = $this->get_booking_by_id($booking_id);
        if (!$booking || $booking['bpkb_status'] !== 'completed') {
            return false;
        }

        // Finalize transaction
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', array('status' => 'completed'));

        // Change car to fully sold
        $this->Mobil_model->update_car_status($booking['car_id'], 'sold');

        // Document status update
        $this->db->where(array('booking_id' => $booking_id, 'document_type' => 'bpkb'));
        $this->db->update('documents', array('status' => 'delivered'));

        return true;
    }

    /**
     * Cancellation: strictly checking the 1-week booking fee timeline
     */
    public function cancel_booking($booking_id) {
        $booking = $this->get_booking_by_id($booking_id);
        if (!$booking || in_array($booking['status'], array('cancelled', 'completed'))) {
            return false;
        }

        $booking_time = strtotime($booking['booking_date']);
        $current_time = time();
        $seconds_diff = $current_time - $booking_time;
        $one_week_seconds = 7 * 24 * 60 * 60; // 7 days

        $refund_eligible = ($seconds_diff <= $one_week_seconds);

        $this->db->where('id', $booking_id);
        $this->db->update('bookings', array('status' => 'cancelled'));

        // Increase stock count of the car by 1
        $car = $this->Mobil_model->get_car_by_id($booking['car_id']);
        if ($car) {
            $new_stock = $car['stock'] + 1;
            $this->Mobil_model->update_car_stock($booking['car_id'], $new_stock);
        }

        return array(
            'refund_eligible' => $refund_eligible,
            'message' => $refund_eligible 
                ? 'Pesanan dibatalkan. Pembayaran Bukti Pesanan (Rp 500.000) dapat dikembalikan.' 
                : 'Pesanan dibatalkan. Pembayaran Bukti Pesanan hangus (melebihi batas 1 minggu).'
        );
    }

    /**
     * Auto-overdue checks: Automatically cancels bookings that missed the 7-day DP deadline
     */
    public function auto_cancel_overdue_bookings() {
        $now = date('Y-m-d H:i:s');
        $this->db->select('id, car_id');
        $this->db->from('bookings');
        $this->db->where('dp_status', 'unpaid');
        $this->db->where('dp_deadline <', $now);
        $this->db->where_in('status', array('ordered', 'active'));
        $overdue = $this->db->get()->result_array();

        $cancelled_count = 0;
        foreach ($overdue as $b) {
            $this->db->where('id', $b['id']);
            $this->db->update('bookings', array('status' => 'cancelled'));
            
            // Increase stock count of the car by 1
            $car = $this->Mobil_model->get_car_by_id($b['car_id']);
            if ($car) {
                $new_stock = $car['stock'] + 1;
                $this->Mobil_model->update_car_stock($b['car_id'], $new_stock);
            }
            $cancelled_count++;
        }
        return $cancelled_count;
    }
}
