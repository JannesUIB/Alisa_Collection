<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseBill extends CI_Controller {

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
		$this->load->model('Purchase_model');
		$this->load->model('Purchase_Bill_model');
		$this->load->model('Inventory_model');
		$this->load->model('Sales_Invoice_model');
    }

	public function formselectedid($id){
		$sales_invoice = $this->Purchase_Bill_model->GetPurchaseBillBasedOnID($id);

		$data['purchase_bill_record'] = $sales_invoice[0]->result();
		$data['purchase_bill_line_record'] = $sales_invoice[1]->result();
		// $data['inventory_records'] = $inventory_record;

		$this->load->view('Purchase_Bill/formid', $data);
	}

	public function generateselectedid($id){
		$sales_invoice = $this->Purchase_Bill_model->GetPurchaseBillBasedOnID($id);

		$data['purchase_bill_record'] = $sales_invoice[0]->result();
		$data['purchase_bill_line_record'] = $sales_invoice[1]->result();
		// $data['inventory_records'] = $inventory_record;

		$this->load->view('Purchase_Bill/formid_report', $data);
	}

	public function delete($id, $purchase_id) {
		$this->Purchase_Bill_model->deletePurchaseBill($id);

		// $this->index();
		redirect('Purchase/formselectedid/' . $purchase_id);
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
	public function GoToPurchaseOrder($id){
		redirect('Purchase/formselectedid/'. $id);
	}
}

