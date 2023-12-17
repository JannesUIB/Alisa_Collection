<?php
class Purchase_Bill_model extends CI_Model {

	public function __construct()
	{
		$this->purchase_bill = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function AddPurchaseBill($sale_record) {
		$this->purchase_bill = $this->load->database('default', TRUE);
	
        $this->purchase_bill->insert('purchase_bill', $sale_record);
	}
	public function AddPurchaseBillLine($data) {
		$this->purchase_bill = $this->load->database('default', TRUE);

        $this->purchase_bill->insert('purchase_bill_line', $data);
	}

	public function GetPurchaseBillBasedOnID($id) {
		$this->purchase_bill = $this->load->database('default', TRUE);
		$this->load->model('Inventory_model', 'inventory');

		$query = $this->purchase_bill->get_where('purchase_bill', array('id' => $id));
		$secondQuery = $this->purchase_bill->get_where('purchase_bill_line', array('Purchase_Bill_ID' =>$id));
		foreach($secondQuery->result() as $sil){
			$account_code = $this->inventory->GetAccountCodeBasedOnID($sil->Account_Code)->row();
			$sil->Account_Name = $account_code->Account_Name;
			$sil->Account_Codes = $account_code->Account_Code;
		}
		
        return [$query, $secondQuery];
        // return $this->purchase_bill->get('purchase_bill');
	}
	
    public function deletePurchaseBill($id) {
		$this->purchase_bill = $this->load->database('default', TRUE);
		
		$this->purchase_bill->delete('purchase_bill_line', array('Purchase_Bill_ID' => $id));
		$this->purchase_bill->delete('purchase_bill', array('ID' => $id));
		// $this->purchase_bill->where('Sale_ID', $id);
		// $this->purchase_bill->delete('purchase_bill_line');

        // $this->purchase_bill->where('id', $id);
		// $this->purchase_bill->delete('purchase_bill');
		
		return TRUE;
    }

    public function getLastPurchaseBillId() {
		$this->purchase_bill = $this->load->database('default', TRUE);
		$query = $this->purchase_bill->select_max('id')->get('purchase_bill');

		$result = $query->row_array();
        return $result['id'] ?? 0;
	}
	public function getLastPBLId() {
		$this->purchase_bill = $this->load->database('default', TRUE);

        $this->purchase_bill->select_max('id');
        $query = $this->purchase_bill->get('purchase_bill_line');
        $result = $query->row_array();
        return $result['id'] ?? 0;
	}
}
