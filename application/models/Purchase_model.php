<?php
class Purchase_model extends CI_Model {

	public function __construct()
	{
		$this->purchase = $this->load->database('default', TRUE);
	}

	public function AddPurchase($data) {
        $this->purchase->insert('inventory', $data);
    }

	public function GetPurchase() {
		$this->purchase = $this->load->database('default', TRUE);

        return $this->purchase->get('inventory');
	}
	
    public function deletePurchase($name) {
        $this->purchase->where('inventory_name', $name);
        $this->purchase->delete('inventory');
    }

    public function getLastPurchaseId() {
        $this->purchase->select_max('inventory_id');
        $query = $this->purchase->get('inventory');
        $result = $query->row_array();
        return $result['inventory_id'] ?? 0;
    }
}
