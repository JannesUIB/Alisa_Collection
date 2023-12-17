<?php
class Notification_model extends CI_Model {

	public function __construct()
        {
			$this->notifications = $this->load->database('default', TRUE);
			$this->load->helper('url');$this->load->database();
	}

	public function addNotifications($data) {
		$this->notifications = $this->load->database('default', TRUE);

        $this->notifications->insert('notifications', $data);
	}

	public function getLastNotifId() {
		$this->notifications = $this->load->database('default', TRUE);
		$query = $this->notifications->select_max('id')->get('notifications');
    
		// Debugging statements
		// echo $this->notifications->last_query(); // Print the generated SQL query
		$result = $query->row_array();
		// ;print_r($result) // Print the result
        return $result['id'] ?? 0;
	}
}
