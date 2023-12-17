<?php
class Sales_Invoice_model extends CI_Model {

	public function __construct()
	{
		$this->sale_invoice = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function AddSalesInvoice($sale_record) {
		$this->sale_invoice = $this->load->database('default', TRUE);
	
        $this->sale_invoice->insert('sale_invoice', $sale_record);
	}
	public function AddSalesInvoiceLine($data) {
		$this->sale_invoice = $this->load->database('default', TRUE);

        $this->sale_invoice->insert('sale_invoice_line', $data);
	}

	public function GetSales() {
		$this->sale_invoice = $this->load->database('default', TRUE);

        return $this->sale_invoice->get('sale_invoice');
	}

	public function GetSalesInvoiceBasedOnID($id) {
		$this->sale_invoice = $this->load->database('default', TRUE);
		$this->load->model('Inventory_model', 'inventory');

		$query = $this->sale_invoice->get_where('sale_invoice', array('id' => $id));
		$secondQuery = $this->sale_invoice->get_where('sale_invoice_line', array('Sale_Invoice_ID' =>$id));
		foreach($secondQuery->result() as $sil){
			$account_code = $this->inventory->GetAccountCodeBasedOnID($sil->Account_Code)->row();
			$sil->Account_Name = $account_code->Account_Name;
			$sil->Account_Codes = $account_code->Account_Code;
		}
		
        return [$query, $secondQuery];
        // return $this->sale_invoice->get('sale_invoice');
	}
	
    public function deleteSalesInvoice($id) {
		$this->sale_invoice = $this->load->database('default', TRUE);
		
		$this->sale_invoice->delete('sale_invoice_line', array('Sale_Invoice_ID' => $id));
		$this->sale_invoice->delete('sale_invoice', array('ID' => $id));
		// $this->sale_invoice->where('Sale_ID', $id);
		// $this->sale_invoice->delete('sale_invoice_line');

        // $this->sale_invoice->where('id', $id);
		// $this->sale_invoice->delete('sale_invoice');
		
		return TRUE;
    }

    public function getLastSalesInvoiceId() {
		$this->sale_invoice = $this->load->database('default', TRUE);
		$query = $this->sale_invoice->select_max('id')->get('sale_invoice');

		$result = $query->row_array();
        return $result['id'] ?? 0;
	}
	public function getLastSiLId() {
		$this->sale_invoice = $this->load->database('default', TRUE);

        $this->sale_invoice->select_max('id');
        $query = $this->sale_invoice->get('sale_invoice_line');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}
	
	public function UpdateSales($data, $id) {
		$this->sale_invoice = $this->load->database('default', TRUE);
		
		$this->sale_invoice->where('id', $id);
		$this->sale_invoice->update('sale_invoice', $data);

		return TRUE;
    }
}
