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

		$data['purchases'] = $purchase;
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
			$lastpolId = $this->Purchase_model->getLastPoLId();
			$pol_id = ($lastpolId) ? $lastpolId + 1 : 1;
			$pol_data = array(
				'id' => $pol_id,
				'Purchase_ID' => $id,
				'Item_ID' => $row['Item_ID'],
				'Quantity'=> $row['Quantity'],
				'Price'=> $row['Price'],
				'Discount'=> $row['Discount'],
			);
			$purchase_subtotal += $row['Quantity'] * $row['Price'];
			$purchase_discount += ($row['Quantity'] * $row['Price']) * $row['Discount'] / 100;
			$purchase_total += $purchase_subtotal - $purchase_subtotal;
			$this->Purchase_model->AddPurchaseOrderLine($pol_data);
		}
		$price_data = array (
			'Amount_Untaxed' => $purchase_subtotal,
			'Tax' => $purchase_discount,
			'Sale_Total' => $purchase_total,
		);
		// Redirect or load view as needed
		$this->Purchase_model->UpdatePurchase($price_data, $id);
		redirect('Purchase/formselectedid/'. $id);
	}

	public function UpdatePurchase($id) {
		$customer_name = $this->input->post('customer_name');
		$table_data = $this->input->post('tableData');
		$sale_subtotal = 0;
		$sale_discount = 0;
		$sale_total = 0;
		
		$data = array(
			'Customer_Name' => $customer_name,
		);

		$this->Purchase_model->UpdatePurchase($data, $id);

		$table_array = json_decode($table_data, true);
		foreach ($table_array as $row) {
			// echo '<pre>';
			// print_r($row);
			// echo '</pre>';
			// $row is now an array representing each row
			// You can access individual elements in the row using indexes
			if(!$row['POL_ID']){
				$lastsolId = $this->Purchase_model->getLastPoLId();
				$pol_id = ($lastsolId) ? $lastsolId + 1 : 1;
				$pol_data = array(
				'id' => $pol_id,
				'Purchase_ID' => $id,
				'Item_ID' => $row['Item_ID'],
				'Quantity'=> $row['Quantity'],
				'Price'=> $row['Price'],
				'Discount'=> $row['Discount'],
				);
				$this->Purchase_model->AddPurchaseOrderLine($pol_data);
			}
		}
		// Redirect or load view as needed
		redirect('Purchase/formselectedid/'. $id);
    }

    public function delete($id) {
		$this->Purchase_model->deletePurchase($id);

		// $this->index();
		redirect('Purchase/index');
        // Redirect or load view as needed
	}
	
	public function edit($id) {
		$purchase_record = $this->Purchase_model->GetPurchaseBasedOnId($id);
		$inventory_record = $this->Inventory_model->GetInventory()->result();

		$data['purchase_record'] = $purchase_record[0]->result();
		$data['purchase_order_line_record'] = $purchase_record[1]->result();
		$data['inventory_records'] = $inventory_record;


		$this->load->view('/purchase/formid_edit', $data);
		// $this->load->view('/inventory/formid_edit', $data);
        // Redirect or load view as needed
    }
}

