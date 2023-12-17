<?php
class Stock_Transaction_model extends CI_Model {

	public function __construct()
        {
			$this->stock_transaction = $this->load->database('default', TRUE);
			$this->load->helper('url');$this->load->database();
	}

	public function addStockTransaction($data) {
		$this->stock_transaction = $this->load->database('default', TRUE);

        $this->stock_transaction->insert('stock_transaction', $data);
	}

	public function getLaststId() {
		$this->stock_transaction = $this->load->database('default', TRUE);
		$query = $this->stock_transaction->select_max('id')->get('stock_transaction');
    
		// Debugging statements
		// echo $this->stock_transaction->last_query(); // Print the generated SQL query
		$result = $query->row_array();
		// ;print_r($result) // Print the result
        return $result['id'] ?? 0;
	}
}
