<?php 
class Inquiry_model extends CI_Model {       
	function __construct(){            
	  	parent::__construct();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	}


  	/**
     * This function is used to delete user
     * @param: $id - id of user table
     */
	function delete($id='') {
		$this->db->where('inquiry_id', $id);  
		$this->db->delete('inquiry'); 
		
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

  	public function deleteRow($table, $col, $colVal) {
  		$this->db->where($col,$colVal);
		$this->db->delete($table);
		return true;
  	}

  	public function get_brand_name($id)
	{
		$query = $this->db->select('brand_name')->from('brand')->where('brand_id',$id)->get();
		$result = $query->row();
		$name = $result->brand_name;
		return $name;
	}
	public function get_collection_name($id)
	{
		$query = $this->db->select('collection_name')->from('collection')->where('collection_id',$id)->get();
		$result = $query->row();
		$name = $result->collection_name;
		return $name;
	}
	public function get_material_name($id)
	{
		$query = $this->db->select('material_name')->from('material')->where('material_id',$id)->get();
		$result = $query->row();
		$name = $result->material_name;
		return $name;
	}

	public function get_client_name($id)
	{
		$query = $this->db->select('*')->from('customers')->where('customer_id',$id)->get();
	
		return $result = $query->row();
		
		
		
	}

	public function get_product_name($id)
	{
		$query = $this->db->select('*')->from('products')->where('product_id',$id)->get();
		$result = $query->row();
		$name = $result->part_no;
		return $name;
	}
	public function get_assproduct_name($id)
	{
		$query = $this->db->select('*')->from('assemble')->where('assemble_id',$id)->get();
		$result = $query->row();
		$name = $result->part_name;
		return $name;
	}

	function get_categories() {	
		
		$this->db->select('*');
		$this->db->from('category');
		// $this->db->where('parent_id !=', '0');
		$query = $this->db->get();
		return $query->result();
  	}
  	
	function getParent($id) {	
		
		// $this->db->select('*');
		// $this->db->from('category');
		// $this->db->where('category_id', $id);
		// $query = $this->db->get();
		// return $query->result();

		$query = $this->db->select('*')->from('category')->where('category_id',$id)->get();
		$result = $query->row();
		// $name = $result->category_name;
		// return $result;
		$name=$result->category_name;
		$id= $result->parent_id;


		while($id > 0){
			$query2 = $this->db->select('*')->from('category')->where('category_id',$id)->get();
			$result2 = $query2->row();
			$name = $result2->category_name." => ".$name;
			$id = $result2->parent_id;
		}

		return $name;
  	}

  	public function get_cat_name($id)
	{
		$query = $this->db->select('*')->from('category')->where('category_id',$id)->get();
		$result = $query->row();
		// $name = $result->category_name;
		// return $result;
		$name=$result->category_name;
		$id= $result->parent_id;


		while($id > 0){
			$query2 = $this->db->select('*')->from('category')->where('category_id',$id)->get();
			$result2 = $query2->row();
			$name = $result2->category_name." => ".$name;
			$id = $result2->parent_id;
		}

		return $name;
	}
}