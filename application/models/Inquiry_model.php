<?php 
class Inquiry_model extends CI_Model {       
	function __construct(){            
	  	parent::__construct();
		
	}
	

  	/**
      * This function is used to select data form table  
      */
	function get_lead_follow_data_by() {	
		$this->db->select('*');
		$this->db->from('lead_follows');
                $this->db->join('leads', 'leads.lead_id = lead_follows.lead_id');
                $this->db->where('DATE_ADD(lead_follows.fl_date, INTERVAL YEAR(CURDATE())-YEAR(lead_follows.fl_date) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(lead_follows.fl_date),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
		$query = $this->db->get();
		return $query->result();
  	}
        
        function get_inquery_follow_data_by() {	
		$this->db->select('*');
		$this->db->from('inquiry_follows');
                $this->db->join('inquiry', 'inquiry.inquiry_id = inquiry_follows.inquiry_id');
                $this->db->where('DATE_ADD(inquiry_follows.fl_date, INTERVAL YEAR(CURDATE())-YEAR(inquiry_follows.fl_date) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(inquiry_follows.fl_date),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
		$query = $this->db->get();
		return $query->result();
  	}
        
        function get_admin_email_address() {	
		$this->db->select('email');
		$this->db->from('users');
                $this->db->where('user_type=','admin');
		$query = $this->db->get();
		return $query->result();
  	}
        
          function get_email_id_from_user_id($id){
              $this->db->select('email');
              $this->db->from('users');
              $this->db->where('user_id=',$id);
	      $query = $this->db->get();
	      return $query->result();
          }

}