<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
	}

	public function addInventory($data) {
        $this->db->insert('inventory', $data);
    }

    public function deleteInventory($name) {
        $this->db->where('inventory_name', $name);
        $this->db->delete('inventory');
    }

    public function getLastInventoryId() {
        $this->db->select_max('inventory_id');
        $query = $this->db->get('inventory');
        $result = $query->row_array();
        return $result['inventory_id'] ?? 0;
    }
}
