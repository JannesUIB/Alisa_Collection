<?php
class Accounting_model extends CI_Model {

	public function __construct()
	{
		$this->accounting = $this->load->database('default', TRUE);
		$this->load->helper('url');
	}

	public function GetAccountCodeBasedOnID($id){
		$this->accounting = $this->load->database('default', TRUE);

		$query = $this->accounting->get_where('account_code', array('id' => $id));

        return $query;
	}

	public function UpdateAccountCode($data, $id){
		$this->accounting - $this->load->database('default', TRUE);
		
		$this->accounting->where('id', $id);
		$this->accounting->update('account_code', $data);

		return TRUE;
	}
}
