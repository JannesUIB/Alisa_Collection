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

	public function generateselectedid($id){
		$sales_invoice = $this->Sales_Invoice_model->GetSalesInvoiceBasedOnID($id);

		$data['sale_invoice_record'] = $sales_invoice[0]->result();
		$data['sale_invoice_line_record'] = $sales_invoice[1]->result();
		// $data['inventory_records'] = $inventory_record;

		$this->load->view('/Sale_invoice/formid_report', $data);
	}

    public function delete($id, $sale_id) {
		$this->Sales_Invoice_model->deleteSalesInvoice($id);

		// $this->index();
		redirect('Sales/formselectedid/' . $sale_id);
        // Redirect or load view as needed
	}
	
	public function GoToSaleOrder($id){
		redirect('Sales/formselectedid/'. $id);
	}
}

