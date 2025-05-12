<?php
class Domain_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_domains() {
        return $this->db->get('domains')->result();
    }

    public function get_domain($id) {
        return $this->db->get_where('domains', array('id' => $id))->row();
    }

    public function add_domain($data) {
        $this->db->insert('domains', $data);
        return $this->db->insert_id();
    }

    public function update_domain($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('domains', $data);
    }

    public function delete_domain($id) {
        return $this->db->delete('domains', array('id' => $id));
    }

    public function get_expiring_domains($days = 30) {
        $this->db->where('expiration_date >=', date('Y-m-d'));
        $this->db->where('expiration_date <=', date('Y-m-d', strtotime("+$days days")));
        return $this->db->get('domains')->result();
    }
}