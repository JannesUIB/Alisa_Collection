<?php
class Sales_model extends CI_Model {

	public function __construct()
	{
		$this->sale_order = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function addSales($data) {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->insert('sale_order', $data);
	}
	public function AddSalesOrderLine($data) {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->insert('sale_order_line', $data);
	}
	public function UpdateSales($data, $id) {
		$this->sale_order = $this->load->database('default', TRUE);
		
		$this->sale_order->where('id', $id);
		$this->sale_order->update('sale_order', $data);

		return TRUE;
    }

	public function GetSales() {
		$this->sale_order = $this->load->database('default', TRUE);

        return $this->sale_order->get('sale_order');
	}

	public function GetSalesBasedOnId($id) {
		$this->sale_order = $this->load->database('default', TRUE);

		$query = $this->sale_order->get_where('sale_order', array('id' => $id));

        return $query;
        // return $this->sale_order->get('sale_order');
	}
	
    public function deleteSales($id) {
		$this->sale_order = $this->load->database('default', TRUE);
		
        $this->sale_order->where('id', $id);
		$this->sale_order->delete('sale_order');
		
		return TRUE;
    }

    public function getLastSalesId() {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->select_max('id');
        $query = $this->sale_order->get('sale_order');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}
	public function getLastSoLId() {
		$this->sale_order = $this->load->database('default', TRUE);

        $this->sale_order->select_max('id');
        $query = $this->sale_order->get('sale_order_line');
        $result = $query->row_array();
        return $result['id'] ?? 0;
    }
}
