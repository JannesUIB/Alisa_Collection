<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesInvoice extends CI_Controller {

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
		$this->load->model('Sales_model');
		$this->load->model('Inventory_model');
		$this->load->model('Sales_Invoice_model');
    }

	// public function index()
	// {
	// 	$sales = $this->Sales_model->GetSales()->result();

	// 	$data['sales'] = $sales;
	// 	$this->load->view('/sales/index', $data);
	// }

	// public function form()
	// {
	// 	$inventory_record = $this->Inventory_model->GetInventory()->result();
	// 	$data['inventory_records'] = $inventory_record;
	// 	$this->load->view('/sales/form', $data);
		
	// }

	public function formselectedid($id){
		$sales_invoice = $this->Sales_Invoice_model->GetSalesInvoiceBasedOnID($id);

		$data['sale_invoice_record'] = $sales_invoice[0]->result();
		$data['sale_invoice_line_record'] = $sales_invoice[1]->result();
		// $data['inventory_records'] = $inventory_record;

		$this->load->view('/Sale_invoice/formid', $data);
	}

	public function CreateSaleInvoice($sale_id){
		$sale_data = $this->Sales_model->GetSalesBasedOnId($sale_id);
		$sol_total = 0;
		$lastId = $this->Sales_Invoice_model->getLastSalesInvoiceId();
		$id = ($lastId) ? $lastId + 1 : 1;
		foreach($sale_data[0]->result() as $sale_order){
			$sales_order_data = array(
				'ID' => $id,
				'Customer' => $sale_order->Customer_Name,
				'Status' => 'Unpaid',
				'Sale_ID' => $sale_order->ID,
	
			);
			$this->Sales_Invoice_model->AddSalesInvoice($sales_order_data);
		}
		foreach($sale_data[1]->result() as $sale_order_line){
			$lastsilId = $this->Sales_Invoice_model->getLastSiLId();
			$sil_id = ($lastsilId) ? $lastsilId + 1 : 1;
			$sales_order_data = array(
				'ID' => $sil_id,
				'Sale_Invoice_ID' => $id,
				'Account_Code' => 2,
				'Description' => $sale_order_line->Item_Name,
				'Debit' => 0,
				'Credit' => ($sale_order_line->Quantity * $sale_order_line->Price) - (($sale_order_line->Quantity * $sale_order_line->Price) * $sale_order_line->Discount / 100),
			);
			$sol_total += ($sale_order_line->Quantity * $sale_order_line->Price) - (($sale_order_line->Quantity * $sale_order_line->Price) * $sale_order_line->Discount / 100); 
			$this->Sales_Invoice_model->AddSalesInvoiceLine($sales_order_data);
		}
		$lastsilId = $this->Sales_Invoice_model->getLastSiLId();
		$sil_id = ($lastsilId) ? $lastsilId + 1 : 1;
		$sales_order_data = array(
			'ID' => $sil_id,
			'Sale_Invoice_ID' => $id,
			'Account_Code' => 1,
			'Description' => "Total Pendapatan",
			'Debit' => $sol_total,
			'Credit' => 0,
		);
		$this->Sales_Invoice_model->AddSalesInvoiceLine($sales_order_data);

		$sales_invoice = $this->Sales_Invoice_model->GetSalesInvoiceBasedOnID($id);

		$data['sale_invoice_record'] = $sales_invoice[0]->result();
		$data['sale_invoice_line_record'] = $sales_invoice[1]->result();
		// $data['inventory_records'] = $inventory_record;

		redirect('SalesInvoice/formselectedid/'. $id);
		// $sol_total += $sale_order_line->Quantity * $sale_order_line->Price;
		// $sale_invoice = $this->Sale_Invoice_model->AddSalesInvoice($sale_data[0]->result(), $sale_data[1]->result());
	}

    public function addSales() {
		$customer_name = $this->input->post('customer_name');
		$table_data = $this->input->post('tableData');
		$sale_subtotal = 0;
		$sale_discount = 0;
		$sale_total = 0;
		
		$lastId = $this->Sales_model->getLastSalesId();
		$id = ($lastId) ? $lastId + 1 : 1;

		$data = array(
			'id' => $id,
			'Customer_Name' => $customer_name,

		);

		$this->Sales_model->addSales($data);

		$table_array = json_decode($table_data, true);
		foreach ($table_array as $row) {
			// $row is now an array representing each row
			// You can access individual elements in the row using indexes
			$lastsolId = $this->Sales_model->getLastSoLId();
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
			$this->Sales_model->AddSalesOrderLine($sol_data);
		}
		$price_data = array (
			'Amount_Untaxed' => $sale_subtotal,
			'Tax' => $sale_discount,
			'Sale_Total' => $sale_total,
		);
		// Redirect or load view as needed
		$this->Sales_model->UpdateSales($price_data, $id);
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

		$this->Sales_model->UpdateSales($data, $id);

		$table_array = json_decode($table_data, true);
		foreach ($table_array as $row) {
			// echo '<pre>';
			// print_r($row);
			// echo '</pre>';
			// $row is now an array representing each row
			// You can access individual elements in the row using indexes
			if(!$row['SOl_ID']){
				$lastsolId = $this->Sales_model->getLastSoLId();
				$sol_id = ($lastsolId) ? $lastsolId + 1 : 1;
				$sol_data = array(
				'id' => $sol_id,
				'Sale_ID' => $id,
				'Item_ID' => $row['Item_ID'],
				'Quantity'=> $row['Quantity'],
				'Price'=> $row['Price'],
				'Discount'=> $row['Discount'],
				);
				$this->Sales_model->AddSalesOrderLine($sol_data);
			}
		}
		// Redirect or load view as needed
		redirect('Sales/formselectedid/'. $id);
    }

    public function delete($id) {
		$this->Sales_model->deleteSales($id);

		// $this->index();
		redirect('Sales/index');
        // Redirect or load view as needed
	}
	
	public function edit($id) {
		$sale_record = $this->Sales_model->GetSalesBasedOnId($id);
		$inventory_record = $this->Inventory_model->GetInventory()->result();

		$data['sale_record'] = $sale_record[0]->result();
		$data['sale_order_line_record'] = $sale_record[1]->result();
		$data['inventory_records'] = $inventory_record;


		$this->load->view('/Sales/formid_edit', $data);
		// $this->load->view('/inventory/formid_edit', $data);
        // Redirect or load view as needed
	}
	public function GoToSaleOrder($id){
		redirect('Sales/formselectedid/'. $id);
	}
}

