<?php
class Sales_model extends CI_Model {

	public function __construct()
	{
		$this->sale_order = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function addSales($data) {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->insert('sale_order', $data);
	}
	public function AddSalesOrderLine($data) {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->insert('sale_order_line', $data);
	}

	public function GetSales() {
		$this->sale_order = $this->load->database('default', TRUE);

        return $this->sale_order->get('sale_order');
	}

	public function GetSalesOnlyBasedOnId($id) {
		$this->sale_order = $this->load->database('default', TRUE);
		$query = $this->sale_order->get_where('sale_order', array('id' => $id));

        return $query;
	}
	
	public function GetSalesBasedOnId($id) {
		$this->sale_order = $this->load->database('default', TRUE);
		$this->load->model('Inventory_model', 'inventory');
		$this->load->model('Sales_model', 'inventory');

		$query = $this->sale_order->get_where('sale_order', array('id' => $id));
		$sale_invoice_query = $this->sale_order->get_where('sale_invoice', array('Sale_ID' => $id));
		if(count($sale_invoice_query->result()) >= 1){
			foreach($query->result() as $sale){
				$sale->Sale_Invoice_ID = $sale_invoice_query->row()->ID;
			}
		}
		else{
			foreach($query->result() as $sale){
				$sale->Sale_Invoice_ID = FALSE;
			}
		}
		$secondQuery = $this->sale_order->get_where('sale_order_line', array('Sale_ID' =>$id));
		foreach($secondQuery->result() as $sol){
			$item = $this->inventory->GetInventoryBasedOnId($sol->Item_ID)->row();
			$sol->Item_Name = $item->Item_Name;
		}
		
        return [$query, $secondQuery];
        // return $this->sale_order->get('sale_order');
	}

	public function GetDailySalesReport() {
		$this->sale_order = $this->load->database('default', TRUE);
		$this->load->model('Sales_model', 'inventory');

		$query = $this->sale_order->get_where('sale_order', array('Create_Date' => date("Y-m-d")));
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

	public function GetMonthlySalesReport() {
		$this->sale_order = $this->load->database('default', TRUE);
		$this->load->model('Sales_model', 'inventory');

		// Get the first day of the current month
		$firstDay = date("Y-m-01");

		// Get the last day of the current month
		$lastDay = date("Y-m-t");

		// Use the BETWEEN clause in your query
		$query = $this->sale_order->get_where('sale_order', array(
			'Create_Date >=' => $firstDay,
			'Create_Date <=' => $lastDay
		));
		
        return $query;
        // return $this->sale_order->get('sale_order');
	}

	public function GetMonthlySalesItemsReport(){
		$this->sale_order = $this->load->database('default', TRUE);
		// $this->load->model('Sales_model', 'Sales');
		$this->load->model('Inventory_model', 'inventory');
		$this->load->model('Sales_model', 'sales');


		// Get the first day of the current month
		$firstDay = date("Y-m-01");

		// Get the last day of the current month
		$lastDay = date("Y-m-t");

		// Use the BETWEEN clause in your query
		$query = $this->sale_order->get_where('sale_order_line', array(
			'Create_Date >=' => $firstDay,
			'Create_Date <=' => $lastDay
		));
		foreach($query->result() as $sol){
			$item = $this->inventory->GetInventoryBasedOnId($sol->Item_ID)->row();
			$sales = $this->sales->GetSalesOnlyBasedOnId($sol->Sale_ID)->row();
			$sol->Item_Name = $item->Item_Name;
			$sol->Sales_Ref = $sales->Sale_Name;
		}
        return $query;
	}
	
    public function deleteSales($id) {
		$this->sale_order = $this->load->database('default', TRUE);
		
		$this->sale_order->delete('sale_order_line', array('Sale_ID' => $id));
		$this->sale_order->delete('sale_order', array('ID' => $id));
		// $this->sale_order->where('Sale_ID', $id);
		// $this->sale_order->delete('sale_order_line');

        // $this->sale_order->where('id', $id);
		// $this->sale_order->delete('sale_order');
		
		return TRUE;
    }

    public function getLastSalesId() {
		$this->sale_order = $this->load->database('default', TRUE);
		$query = $this->sale_order->select_max('id')->get('sale_order');
    
		// Debugging statements
		echo $this->sale_order->last_query(); // Print the generated SQL query
		$result = $query->row_array();
		print_r($result); // Print the result
        return $result['id'] ?? 0;
	}
	public function getLastSoLId() {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->select_max('id');
        $query = $this->sale_order->get('sale_order_line');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}
	
	public function UpdateSales($data, $id) {
		$this->sale_order = $this->load->database('default', TRUE);
		
		$this->sale_order->where('id', $id);
		$this->sale_order->update('sale_order', $data);

		return TRUE;
    }
}
