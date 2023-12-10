<?php
class Purchase_model extends CI_Model {

	public function __construct()
	{
		$this->purchase = $this->load->database('default', TRUE);
	}

	public function AddPurchase($data) {
        $this->purchase->insert('purchase_order', $data);
	}
	
	public function AddPurchaseOrderLine($data) {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->insert('purchase_order_line', $data);
	}

	public function GetPurchase() {
		$this->purchase = $this->load->database('default', TRUE);

        return $this->purchase->get('purchase_order');
	}

	public function GetPurchaseBasedOnId($id) {
		$this->purchase_order = $this->load->database('default', TRUE);
		$this->load->model('Inventory_model', 'inventory');

		$query = $this->purchase_order->get_where('purchase_order', array('ID' => $id));
		$secondQuery = $this->purchase_order->get_where('purchase_order_line', array('Purchase_ID' =>$id));
		foreach($secondQuery->result() as $sol){
			$item = $this->inventory->GetInventoryBasedOnId($sol->Item_ID)->row();
			$sol->Item_Name = $item->Item_Name;
		}
		
        return [$query, $secondQuery];
        // return $this->sale_order->get('sale_order');
	}
	
    public function deletePurchase($id) {
        $this->purchase_order = $this->load->database('default', TRUE);
		
		$this->purchase_order->delete('purchase_order_line', array('Purchase_ID' => $id));
		$this->purchase_order->delete('purchase_order', array('ID' => $id));
		// $this->sale_order->where('Sale_ID', $id);
    }

    public function getLastPurchaseId() {
        $this->purchase->select_max('ID');
        $query = $this->purchase->get('purchase_order');
        $result = $query->row_array();
        return $result['ID'] ?? 0;
	}

	public function getLastPoLId() {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->select_max('id');
        $query = $this->sale_order->get('purchase_order_line');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}

	public function UpdatePurchase($data, $id) {
		$this->sale_order = $this->load->database('default', TRUE);
		
		$this->sale_order->where('id', $id);
		$this->sale_order->update('purchase_order', $data);

		return TRUE;
    }
}
