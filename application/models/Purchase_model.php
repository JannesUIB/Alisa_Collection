<?php
class Purchase_model extends CI_Model {

	public function __construct()
	{
		$this->purchase = $this->load->database('default', TRUE);
	}

	public function AddPurchase($data) {
        $this->purchase->insert('purchase_order', $data);
	}
	
	public function GetPurchaseOnlyBasedOnId($id) {
		$this->purchase = $this->load->database('default', TRUE);
		$query = $this->purchase->get_where('purchase_order', array('id' => $id));

        return $query;
	}

	public function AddPurchaseOrderLine($data) {
		$this->purchase = $this->load->database('default', TRUE);

        $this->purchase->insert('purchase_order_line', $data);
	}

	public function GetPurchase() {
		$this->purchase = $this->load->database('default', TRUE);

        return $this->purchase->get('purchase_order');
	}

	public function GetPurchaseBasedOnId($id) {
		$this->purchase_order = $this->load->database('default', TRUE);
		$this->load->model('Inventory_model', 'inventory');

		$query = $this->purchase_order->get_where('purchase_order', array('ID' => $id));
		$purchase_bill_query = $this->purchase_order->get_where('purchase_bill', array('Purchase_ID' => $id));
		if(count($purchase_bill_query->result()) >= 1){
			foreach($query->result() as $purchase){
				$purchase->Purchase_Bill_ID = $purchase_bill_query->row()->ID;
			}
		}
		else{
			foreach($query->result() as $purchase){
				$purchase->Purchase_Bill_ID = FALSE;
			}
		}
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
	
	public function GetDailyPurchaseReport() {
		$this->purchase_order = $this->load->database('default', TRUE);
		$this->load->model('Sales_model', 'inventory');

		$query = $this->purchase_order->get_where('purchase_order', array('Create_Date' => date("Y-m-d")));
		// $sale_invoice_query = $this->sale_order->get_where('sale_invoice', array('Sale_ID' => $id));
		// if(count($sale_invoice_query->result()) >= 1){
		// 	foreach($query->result() as $sale){
		// 		$sale->Sale_Invoice_ID = $sale_invoice_query->row()->ID;
		// 	}
		// }
		// else{
		// 	foreach($query->result() as $sale){
		// 		$sale->Sale_Invoice_ID = FALSE;
		// 	}
		// }
		// $secondQuery = $this->sale_order->get_where('sale_order_line', array('Sale_ID' =>$id));
		// foreach($secondQuery->result() as $sol){
		// 	$item = $this->inventory->GetInventoryBasedOnId($sol->Item_ID)->row();
		// 	$sol->Item_Name = $item->Item_Name;
		// }
		
        return $query;
        // return $this->sale_order->get('sale_order');
	}

	public function GetMonthlyPurchaseReport() {
		$this->purchase_order = $this->load->database('default', TRUE);
		$this->load->model('Sales_model', 'inventory');

		// Get the first day of the current month
		$firstDay = date("Y-m-01");

		// Get the last day of the current month
		$lastDay = date("Y-m-t");

		// Use the BETWEEN clause in your query
		$query = $this->purchase_order->get_where('purchase_order', array(
			'Create_Date >=' => $firstDay,
			'Create_Date <=' => $lastDay
		));
		
        return $query;
        // return $this->sale_order->get('sale_order');
	}

	public function GetMonthlyPurchaseItemsReport(){
		$this->purchase_order = $this->load->database('default', TRUE);
		// $this->load->model('Sales_model', 'Sales');
		$this->load->model('Inventory_model', 'inventory');
		$this->load->model('Purchase_model', 'Purchase');


		// Get the first day of the current month
		$firstDay = date("Y-m-01");

		// Get the last day of the current month
		$lastDay = date("Y-m-t");

		// Use the BETWEEN clause in your query
		$query = $this->purchase_order->get_where('purchase_order_line', array(
			'Create_Date >=' => $firstDay,
			'Create_Date <=' => $lastDay
		));
		foreach($query->result() as $pol){
			$item = $this->inventory->GetInventoryBasedOnId($pol->Item_ID)->row();
			$purchase = $this->Purchase->GetPurchaseOnlyBasedOnId($pol->Purchase_ID)->row();
			$pol->Item_Name = $item->Item_Name;
			$pol->Purchase_Ref = $purchase->Purchase_Name;
		}
        return $query;
	}
}
