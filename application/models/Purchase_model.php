<?php
class Purchase_model extends CI_Model {

	public function __construct()
	{
		$this->purchase = $this->load->database('default', TRUE);
	}

	public function AddPurchase($data) {
        $this->purchase->insert('purchase_order', $data);
    }

	public function GetPurchase() {
		$this->purchase = $this->load->database('default', TRUE);

        return $this->purchase->get('purchase_order');
	}
	
    public function deletePurchase($id) {
        $this->purchase->where('ID', $id);
        $this->purchase->delete('puchase_order');
    }

    public function getLastPurchaseId() {
        $this->purchase->select_max('ID');
        $query = $this->purchase->get('purchase_order');
        $result = $query->row_array();
        return $result['ID'] ?? 0;
    }
}
