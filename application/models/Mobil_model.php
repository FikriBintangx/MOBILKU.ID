<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Dynamic DB Migrator: Ensure 'stock' column exists in 'cars'
        if (!$this->db->field_exists('stock', 'cars')) {
            $this->db->query("ALTER TABLE cars ADD COLUMN stock INT NOT NULL DEFAULT 5");
        }
    }

    /**
     * Get all cars that are available or filters by standard status.
     */
    public function get_all_cars($status = 'available') {
        $this->db->select('*');
        $this->db->from('cars');
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get unique brands in stock for filters.
     */
    public function get_unique_brands() {
        $this->db->select('DISTINCT(brand) as brand');
        $this->db->from('cars');
        $this->db->order_by('brand', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Get unique car types.
     */
    public function get_unique_types() {
        $this->db->select('DISTINCT(type) as type');
        $this->db->from('cars');
        $this->db->order_by('type', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Advanced filter query matching user dashboard inputs.
     */
    public function filter_cars($brand = '', $type = '', $min_price = 0, $max_price = 0, $search = '') {
        $this->db->select('*');
        $this->db->from('cars');
        $this->db->where_in('status', array('available', 'booked'));

        if (!empty($brand)) {
            $this->db->where('brand', $brand);
        }
        if (!empty($type)) {
            $this->db->where('type', $type);
        }
        if ($min_price > 0) {
            $this->db->where('price >=', $min_price);
        }
        if ($max_price > 0) {
            $this->db->where('price <=', $max_price);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('brand', $search);
            $this->db->or_like('model', $search);
            $this->db->or_like('plate_number', $search);
            $this->db->group_end();
        }

        $this->db->order_by('price', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Fetch single vehicle by ID.
     */
    public function get_car_by_id($id) {
        return $this->db->get_where('cars', array('id' => $id))->row_array();
    }

    /**
     * Modify car catalog status.
     */
    public function update_car_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('cars', array('status' => $status));
    }

    /**
     * Update car stock count.
     */
    public function update_car_stock($id, $stock) {
        $this->db->where('id', $id);
        $this->db->update('cars', array('stock' => $stock));
        // If stock hits 0, auto-change status to booked/sold, otherwise make sure it is available!
        if ($stock <= 0) {
            $this->update_car_status($id, 'booked');
        } else {
            $this->update_car_status($id, 'available');
        }
        return true;
    }

    /**
     * Log a new car into catalog database.
     */
    public function insert_car($data) {
        $this->db->insert('cars', $data);
        return $this->db->insert_id();
    }
}
