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
		$this->load->model('Accounting_model');
		$this->load->model('Stock_Transaction_model');
		$this->load->model('Inventory_model');
		$this->load->model('Purchase_Bill_model');
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

	public function CreatePurchaseBill($purchase_id){
		$purchase_data = $this->Purchase_model->GetPurchaseBasedOnId($purchase_id);
		$pol_total = 0;
		$purchase_bill_line_array = array();
		$lastId = $this->Purchase_Bill_model->getLastPurchaseBillId();
		$id = ($lastId) ? $lastId + 1 : 1;
		foreach($purchase_data[0]->result() as $purchase_order){
			$purchase_bill_data = array(
				'ID' => $id,
				'Vendor' => $purchase_order->Customer_Name,
				'Purchase_Bill_Name' => "Purchase Bill-" . $purchase_order->Purchase_Name,
				'Purchase_ID' => $purchase_order->ID,
				'Create_Date' => date("Y-m-d")
			);
			$this->Purchase_Bill_model->AddPurchaseBill($purchase_bill_data);
		}
		foreach($purchase_data[1]->result() as $purchase_order_line){
			$laststId = $this->Stock_Transaction_model->getLaststId();
			$st_id = ($laststId) ? $laststId + 1 : 1;
			$stock_transaction_data = array(
				'ID' => $st_id,
				'Item_ID' => $purchase_order_line->Item_ID,
				'Ref' => $purchase_order_line->Purchase_ID,
				'Stock_To_Add' => $purchase_order_line->Quantity,
				'Stock_To_Deduce' => 0,
			);
			$pol_total += ($purchase_order_line->Quantity * $purchase_order_line->Price) - (($purchase_order_line->Quantity * $purchase_order_line->Price) * $purchase_order_line->Discount / 100); 
			// $this->Purchase_Bill_model->AddSalesInvoiceLine($sales_order_data);
			$this->Stock_Transaction_model->addStockTransaction($stock_transaction_data);
			$result = $this->Inventory_model->GetInventoryBasedOnId($purchase_order_line->Item_ID)->row();
			$inventory_data = array(
				'Onhand_Qty' => $result->Onhand_Qty + $purchase_order_line->Quantity,
			);
			$this->Inventory_model->UpdateInventory($inventory_data, $purchase_order_line->Item_ID);
		}
		$lastpblId = $this->Purchase_Bill_model->getLastPBLId();
		$pbl_id = ($lastpblId) ? $lastpblId + 1 : 1;
		$purchase_bill_line_data = array(
			'ID' => $pbl_id,
			'Purchase_Bill_ID' => $id,
			'Account_Code' => 1,
			'Description' => "Total Pengeluaran Kas",
			'Credit' => $pol_total,
			'Debit' => 0,
			'Create_Date' => date("Y-m-d")
		);
		$this->Purchase_Bill_model->AddPurchaseBillLine($purchase_bill_line_data);

		foreach($purchase_data[1]->result() as $purchase_order_line){
			$lastsilId = $this->Purchase_Bill_model->getLastPBLId();
			$sil_id = ($lastsilId) ? $lastsilId + 1 : 1;
			$purchase_bill_line = array(
				'ID' => $sil_id,
				'Purchase_Bill_ID' => $id,
				'Account_Code' => 2,
				'Description' => $purchase_order_line->Item_Name,
				'Debit' => ($purchase_order_line->Quantity * $purchase_order_line->Price) - (($purchase_order_line->Quantity * $purchase_order_line->Price) * $purchase_order_line->Discount / 100),
				'Credit' => 0,
				'Create_Date' => date("Y-m-d")
			);
			$this->Purchase_Bill_model->AddPurchaseBillLine($purchase_bill_line);
		}
		$sale_to_update = array(
			'Status' => 'Purchase_Order',
		);

		$result_accounting_debit = $this->Accounting_model->GetAccountCodeBasedOnID(1)->row();
		$result_accounting_credit = $this->Accounting_model->GetAccountCodeBasedOnID(2)->row();

		$account_code_debit_data = array(
			'Kredit' => $result_accounting_debit->Kredit + $pol_total,
		);
		$account_code_credit_data = array(
			'Debit' => $result_accounting_credit->Debit + $pol_total,
		);
		
		$this->Accounting_model->UpdateAccountCode($account_code_debit_data, 1);
		$this->Accounting_model->UpdateAccountCode($account_code_credit_data, 2);
		$this->Purchase_model->UpdatePurchase($sale_to_update, $purchase_id);

		// $data['inventory_records'] = $inventory_record;

		redirect('PurchaseBill/formselectedid/'. $id);
		// $sol_total += $sale_order_line->Quantity * $sale_order_line->Price;
		// $sale_invoice = $this->Sale_Invoice_model->AddSalesInvoice($sale_data[0]->result(), $sale_data[1]->result());
	}

    public function addPurchase() {
		$vendor_name = $this->input->post('vendor_name');
		$purchase_name = $this->input->post('purchase_name');
		$table_data = $this->input->post('tableData');
		$purchase_subtotal = 0;
		$purchase_discount = 0;
		$purchase_total = 0;
		
		$lastId = $this->Purchase_model->getLastPurchaseId();
		$id = ($lastId) ? $lastId + 1 : 1;

		$data = array(
			'id' => $id,
			'Purchase_Name' => $purchase_name,
			'Customer_Name' => $vendor_name,
			'Create_Date' => date("Y-m-d"),
			'Status' => 'RFQ',
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
				'Create_Date' => date("Y-m-d")
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

	public function GoToPurchaseBill($id){
		redirect('PurchaseBill/formselectedid/'. $id);
		
	}
}

