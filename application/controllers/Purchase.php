<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
		$this->load->model('Purchase_model');
		$this->load->model('Inventory_model');
    }

	public function index()
	{
		$purchase = $this->Purchase_model->GetPurchase()->result();

		$data['purchase'] = $purchase;
		$this->load->view('/purchase/index', $data);
	}

	public function form()
	{
		$inventory_record = $this->Inventory_model->GetInventory()->result();
		$data['inventory_records'] = $inventory_record;
		$this->load->view('/purchase/form', $data);
		
	}

	public function formselectedid($id){
		$purchase_record = $this->Purchase_model->GetPurchaseBasedOnId($id);
		
		$data['purchase_record'] = $purchase_record[0]->result();
		$data['purchase_order_line_record'] = $purchase_record[1]->result();
		// $data['inventory_records'] = $inventory_record;

		$this->load->view('/purchase/formid', $data);
	}

    public function addPurchase() {
		$vendor_name = $this->input->post('vendor_name');
		$table_data = $this->input->post('tableData');
		$purchase_subtotal = 0;
		$purchase_discount = 0;
		$purchase_total = 0;
		
		$lastId = $this->Purchase_model->getLastPurchaseId();
		$id = ($lastId) ? $lastId + 1 : 1;

		$data = array(
			'id' => $id,
			'Customer_Name' => $vendor_name,

		);

		$this->Purchase_model->AddPurchase($data);

		$table_array = json_decode($table_data, true);
		foreach ($table_array as $row) {
			// $row is now an array representing each row
			// You can access individual elements in the row using indexes
			$lastsolId = $this->Purchase_model->getLastSoLId();
			$sol_id = ($lastsolId) ? $lastsolId + 1 : 1;
			$sol_data = array(
				'id' => $sol_id,
				'Sale_ID' => $id,
				'Item_ID' => $row['Item_ID'],
				'Quantity'=> $row['Quantity'],
				'Price'=> $row['Price'],
				'Discount'=> $row['Discount'],
			);
			$sale_subtotal += $row['Quantity'] * $row['Price'];
			$sale_discount += ($row['Quantity'] * $row['Price']) * $row['Discount'] / 100;
			$sale_total += $sale_subtotal - $sale_discount;
			$this->Purchase_model->AddSalesOrderLine($sol_data);
		}
		$price_data = array (
			'Amount_Untaxed' => $sale_subtotal,
			'Tax' => $sale_discount,
			'Sale_Total' => $sale_total,
		);
		// Redirect or load view as needed
		$this->Purchase_model->UpdateSales($data, $id);
		redirect('Sales/formselectedid/'. $id);
	}

	public function UpdateSales($id) {
		$customer_name = $this->input->post('customer_name');
		$table_data = $this->input->post('tableData');
		$sale_subtotal = 0;
		$sale_discount = 0;
		$sale_total = 0;
		
		$data = array(
			'Customer_Name' => $customer_name,
		);

		$this->Purchase_model->UpdateSales($data, $id);

		$table_array = json_decode($table_data, true);
		foreach ($table_array as $row) {
			// echo '<pre>';
			// print_r($row);
			// echo '</pre>';
			// $row is now an array representing each row
			// You can access individual elements in the row using indexes
			if(!$row['SOl_ID']){
				$lastsolId = $this->Purchase_model->getLastSoLId();
				$sol_id = ($lastsolId) ? $lastsolId + 1 : 1;
				$sol_data = array(
				'id' => $sol_id,
				'Sale_ID' => $id,
				'Item_ID' => 1,
				'Quantity'=> $row['Quantity'],
				'Price'=> $row['Price'],
				'Discount'=> $row['Discount'],
				);
				$this->Purchase_model->AddSalesOrderLine($sol_data);
			}
		}
		// Redirect or load view as needed
		redirect('Sales/formselectedid/'. $id);
    }

    public function delete($id) {
		$this->Purchase_model->deleteSales($id);

		// $this->index();
		redirect('Sales/index');
        // Redirect or load view as needed
	}
	
	public function edit($id) {
		$sale_record = $this->Purchase_model->GetSalesBasedOnId($id);

		$data['sale_record'] = $sale_record[0]->result();
		$data['sale_order_line_record'] = $sale_record[1]->result();


		$this->load->view('/Sales/formid_edit', $data);
		// $this->load->view('/inventory/formid_edit', $data);
        // Redirect or load view as needed
    }
}

