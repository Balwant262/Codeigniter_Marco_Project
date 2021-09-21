<?php

class Make_model extends CI_Model {       

	function __construct(){            

	  	parent::__construct();

		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';

	}

	

  	/**

     * This function is used to delete user

     * @param: $id - id of user table

     */

	function delete($id='') {

		$this->db->where('make_id', $id);  

		$this->db->delete('make'); 

	}

 

  	/**

      * This function is used to select data form table  

      */

	function get_data_by($tableName='', $value='', $colum='',$condition='') {	

		if((!empty($value)) && (!empty($colum))) { 

			$this->db->where($colum, $value);

		}

		$this->db->select('*');

		$this->db->from($tableName);

		$query = $this->db->get();

		return $query->result();

  	}



	/**

      * This function is used to Insert record in table  

      */

  	public function insertRow($table, $data){

	  	$this->db->insert($table, $data);

	  	return  $this->db->insert_id();

	}



	/**

      * This function is used to Update record in table  

      */

  	public function updateRow($table, $col, $colVal, $data) {

  		$this->db->where($col,$colVal);

		$this->db->update($table,$data);

		return true;

  	}



  	



}