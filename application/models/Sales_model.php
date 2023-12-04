<?php
class Sales_model extends CI_Model {

	public function __construct()
	{
		$this->sales = $this->load->database('default', TRUE);
	}

	public function AddPurchase($data) {
        $this->sales->insert('inventory', $data);
    }

	public function GetSales() {
		$this->sales = $this->load->database('default', TRUE);

        return $this->sales->get('sale_order');
	}
	
    public function deletePurchase($name) {
        $this->sales->where('inventory_name', $name);
        $this->sales->delete('inventory');
    }

    public function getLastPurchaseId() {
        $this->sales->select_max('inventory_id');
        $query = $this->sales->get('inventory');
        $result = $query->row_array();
        return $result['inventory_id'] ?? 0;
    }
}
