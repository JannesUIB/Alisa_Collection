<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

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
        $this->load->model('Inventory_model');
    }

	public function index()
	{
		$inventories = $this->Inventory_model->GetInventory()->result();

		$data['invetories'] = $inventories;
		$this->load->view('/inventory/index', $data);
	}

	public function form()
	{
		$this->load->view('/inventory/form');
	}

	public function formselectedid($id){
		$record = $this->Inventory_model->GetInventoryBasedOnId($id)->result();

		$data['record'] = $record;
		$this->load->view('/inventory/formid', $data);
	}

    public function addInventory() {
		$inventory_name = $this->input->post('inventory_name');
		$inventory_category = $this->input->post('inventory_category');
		$inventory_type = $this->input->post('inventory_type');
		$inventory_internal_references = $this->input->post('inventory_internal_references');
		$inventory_barcode = $this->input->post('inventory_barcode');
		$inventory_price = $this->input->post('inventory_price');
		$inventory_description = $this->input->post('inventory_description');
		
		$lastId = $this->Inventory_model->getLastInventoryId();
		$id = ($lastId) ? $lastId + 1 : 1;

		$data = array(
			'id' => $id,
			'Item_Name' => $inventory_name,
			'Internal_Ref' => $inventory_internal_references,
			'Barcode' => $inventory_barcode,
			'Item_Category' => $inventory_category,
			'Item_Type' => $inventory_type,
			'Sales_Prices' => $inventory_price,
			'description' => $inventory_description,
		);

		$this->Inventory_model->addInventory($data);
		// Redirect or load view as needed
		redirect('Inventory/formselectedid/'. $id);
	}
	
	public function UpdateInventory($id) {
		$inventory_name = $this->input->post('inventory_name');
		$inventory_category = $this->input->post('inventory_category');
		$inventory_type = $this->input->post('inventory_type');
		$inventory_internal_references = $this->input->post('inventory_internal_references');
		$inventory_barcode = $this->input->post('inventory_barcode');
		$inventory_price = $this->input->post('inventory_price');
		$inventory_description = $this->input->post('inventory_description');
		
		$data = array(
			// 'id' => $id,
			'Item_Name' => $inventory_name,
			'Internal_Ref' => $inventory_internal_references,
			'Barcode' => $inventory_barcode,
			'Item_Category' => $inventory_category,
			'Item_Type' => $inventory_type,
			'Sales_Prices' => $inventory_price,
			'description' => $inventory_description,
		);

		$this->Inventory_model->UpdateInventory($data, $id);
		redirect('Inventory/formselectedid/'. $id);
    }

    public function delete($id) {
		$this->Inventory_model->deleteInventory($id);

		$inventories = $this->Inventory_model->GetInventory()->result();

		$data['invetories'] = $inventories;
		// $this->index();
		redirect('Inventory/index');
        // Redirect or load view as needed
	}
	
	public function edit($id) {
		$record = $this->Inventory_model->GetInventoryBasedOnId($id)->result();

		$data['record'] = $record;
		$this->load->view('/inventory/formid_edit', $data);
        // Redirect or load view as needed
    }
}

