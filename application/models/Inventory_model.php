<?php
class Inventory_model extends CI_Model {

	public function __construct()
	{
		$this->inventory = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function addInventory($data) {
		$this->inventory = $this->load->database('default', TRUE);

        $this->inventory->insert('inventory', $data);
	}
	
	public function UpdateInventory($data, $id) {
		$this->inventory = $this->load->database('default', TRUE);
		
		$this->inventory->where('id', $id);
		$this->inventory->update('inventory', $data);

		return TRUE;
    }

	public function GetInventory() {
		$this->inventory = $this->load->database('default', TRUE);

        return $this->inventory->get('inventory');
	}

	public function GetInventoryBasedOnId($id) {
		$this->inventory = $this->load->database('default', TRUE);

		$query = $this->inventory->get_where('inventory', array('id' => $id));

        return $query;
        // return $this->inventory->get('inventory');
	}
	
    public function deleteInventory($id) {
		$this->inventory = $this->load->database('default', TRUE);
		
        $this->inventory->where('id', $id);
		$this->inventory->delete('inventory');
		
		return TRUE;
    }

    public function getLastInventoryId() {
		$this->inventory = $this->load->database('default', TRUE);

        $this->inventory->select_max('id');
        $query = $this->inventory->get('inventory');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}
	
	public function GetAccountCodeBasedOnID($id){
		$this->inventory = $this->load->database('default', TRUE);

		$query = $this->inventory->get_where('account_code', array('id' => $id));

        return $query;
	}
}
