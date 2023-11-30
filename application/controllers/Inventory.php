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
	public function index()
	{
		$this->load->view('/inventory/index');
	}

	public function form()
	{
		$this->load->view('/inventory/form');
	}
	public function __construct() {
        parent::__construct();
        $this->load->model('Inventory_model');
    }

    public function add() {
        if ($this->input->post('button_add')) {
            $inventory_name = $this->input->post('inventory_name');
            $inventory_price = $this->input->post('inventory_price');
            $inventory_stock = $this->input->post('inventory_stock');
            $inventory_barcode = $this->input->post('inventory_barcode');
            
            $lastId = $this->Inventory_model->getLastInventoryId();
            $id = ($lastId) ? $lastId + 1 : 1;

            $data = array(
                'inventory_id' => $id,
                'inventory_name' => $inventory_name,
                'inventory_price' => $inventory_price,
                'inventory_stock' => $inventory_stock,
                'inventory_barcode' => $inventory_barcode
            );

            $this->Inventory_model->addInventory($data);
        }
        // Redirect or load view as needed
    }

    public function delete() {
        if ($this->input->post('button_delete')) {
            $inventory_name = $this->input->post('inventory_name');
            $this->Inventory_model->deleteInventory($inventory_name);
        }
        // Redirect or load view as needed
    }
}

