<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Inventory extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Inventory_model');
		//$this->load->library('excel');
		$this->user_id = isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
    }

    /**
      * This function is redirect to users profile page
      * @return Void
      */
    public function index() {
    	if(is_login()){
    		redirect( base_url().'user/profile', 'refresh');
    	} 
    }

    
    

    /**
     * This function is used for show users list
     * @return Void
     */
    public function inventoryTable(){
        is_login();
	 
        if(CheckPermission("inventory", "inventory")){
		
            $this->load->view('include/header');
            $this->load->view('inventory_table');                
            $this->load->view('include/footer');            
        } else {
			
           $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    
    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
     public function dataTable (){
        is_login();
	    $table = 'inventory';
    	$primaryKey = 'inventory_id';
    	$columns = array(
           array( 'db' => 'inventory_id',   'dt' => 0 ),
		   array( 'db' => 'part_names', 'dt' => 1 ),	 
		  array( 'db' => 'pieces', 'dt' => 2 ),
           array( 'db' => 'hold_pcs', 'dt' => 3),
		   array('db'=> 'date','dt'=> 4),
		  
		   array( 'db' => 'inventory_id', 'dt' => 5)
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
    		// $from='inventory';
    		// $tables[0]['name']='category';
    		// $tables[0]['col1']='inventory.category';
    		// $tables[0]['col2']='category.id';
	
	
	// $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns);
		$output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			// if(CheckPermission('contacts', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonServiceprovider mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
			// }else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'id','id');
				// if($user_id==$this->user_id){
			if(CheckPermission("inventory_edit", "inventory")){ 
        if($this->session->get_userdata()['user_details'][0]->users_id==1){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="inventoryModalButtonadd mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
        }
				}

          if(CheckPermission("inventory_view", "inventory")){ 
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="inventoryModalButtonview mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View Hold Pcs"><i class="fa fa-eye" data-id=""></i></a>';
                }
			// }
			
			// if(CheckPermission('contact', "inventory")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtoninventory1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-eye" data-id=""></i></a>';
			//}else if(CheckPermission('inventory', "inventory")!=true){
			//	$user_id =getRowByTableColomId($table,$id,'inventory_id','inventory_id');
			//	if($user_id==$this->user_id){
			
			
				// }
			// }
			
           


			// if(CheckPermission('serviceprovider', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'serviceprovider\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
			// else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				// if($user_id==$this->user_id){
    //             if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){
			 // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'inventory\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
				// }
			// }
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
		}
		
		echo json_encode($output_arr);
    }
	
	

    /**
     * This function is Showing users profile
     * @return Void
     */
    public function profile($id='') {   
        is_login();
        if(!isset($id) || $id == '') {
            $id = $this->session->userdata ('user_details')[0]->users_id;
        }
        $data['user_data'] = $this->User_model->get_users($id);
        $this->load->view('include/header'); 
        $this->load->view('profile', $data);
        $this->load->view('include/footer');
    }

    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function getmodaladd() {
        is_login();
        if($this->input->post('id')){ 
            $data['inventoryData'] = getDataByid('inventory',$this->input->post('id'),'inventory_id');
            $data['productsData'] = $this->Inventory_model->get_data_by('products');
            $data['assembleData'] = $this->Inventory_model->get_data_by('assemble');
				 $data['orderData'] = $this->Inventory_model->get_data_by('orders'); 
            echo $this->load->view('add_inventory', $data, true);
        } else { 
            $data['inventoryData'] = getDataByid('inventory',$this->input->post('id'),'inventory_id');
			$data['productsData'] = $this->Inventory_model->get_data_by('products');
            $data['assembleData'] = $this->Inventory_model->get_data_by('assemble');
             $data['orderData'] = $this->Inventory_model->get_data_by('orders'); 
            echo $this->load->view('add_inventory', $data, true);
        }
        exit;
    }
	public function getmodalview(){
        is_login();
        if($this->input->post('id')){ 
            $data['inventoryData'] = getDataByid('inventory',$this->input->post('id'),'inventory_id');
            $data['productsData'] = $this->Inventory_model->get_data_by('products');
            $data['assembleData'] = $this->Inventory_model->get_data_by('assemble');
            $data['orderData'] = $this->Inventory_model->get_data_by('orders'); 
            echo $this->load->view('view_inventory', $data, true);
        } else { 
            $data['inventoryData'] = getDataByid('inventory',$this->input->post('id'),'inventory_id');
            $data['productsData'] = $this->Inventory_model->get_data_by('products');
            $data['assembleData'] = $this->Inventory_model->get_data_by('assemble');
            $data['orderData'] = $this->Inventory_model->get_data_by('orders');
            echo $this->load->view('view_inventory', $data, true);
        }
        exit;

    }
	
    
    
   
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add($id='') {   
		// $data =array();
         $data = $this->input->post();

		 // var_dump($data);
		 // exit;
		 unset($data['submit']);
		 
		 if($this->input->post('inventory_id')) {

            $id = $this->input->post('inventory_id');
			unset($data['inventory_id']);

        }
        
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'inventory';
            }
        } else {
            $redirect = 'login';
        }
		
		
		
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
			       }
             if($data['product']!= 0){
          $query=$this->db->select('*')->from('products')->where(
            'product_id',$data['product'])->get();
          $this->Inventory_model->updateRow('inventory', 'inventory_id', $id, $data);
          $result=$query->row();
            $data['pieces'] += $result->pieces;
          }
        else if($data['assembleproduct']!= 0){
          $query=$this->db->select('*')->from('assemble')->where(
            'assemble_id',$data['assembleproduct'])->get(); 
          $result=$query->row();
          $data['pieces'] += $result->pieces;
          $this->Inventory_model->updateRow('inventory', 'inventory_id', $id, $data);
            
            }
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'inventory/inventoryTable', 'refresh');
        } else { 
                 if($data['product']!= 0){
          $query=$this->db->select('*')->from('inventory')->where(
            'product',$data['product'])->get();
           
          $result=$query->row();

           if($query->num_rows()==1){
             unset($data['inventory_id']);
            $data['pieces'] += $result->pieces;
            $id=$result->inventory_id;
          $this->Inventory_model->updateRow('inventory', 'inventory_id', $id, $data);
        }else{
            $this->Inventory_model->insertRow('inventory', $data);
          
        }
            
          }
        else if($data['assembleproduct']!= 0){
          $query=$this->db->select('*')->from('inventory')->where(
            'assembleproduct',$data['assembleproduct'])->get();
           //  print_r($this->db->last_query());  
          $result=$query->row();
          //print_r($result);
           if($query->num_rows()==1){
            unset($data['inventory_id']);
            $data['pieces'] += $result->pieces;
            $id=$result->inventory_id;
          $this->Inventory_model->updateRow('inventory', 'inventory_id', $id, $data);
        }else{         
            $this->Inventory_model->insertRow('inventory', $data);
            }
        }
          // print_r($this->db->last_query());
           //
					
					redirect( base_url().'inventory/inventoryTable', 'refresh');	
            }
    }



    /**
     * This function is used to delete users
     * @return Void
     */
   public function delete($id){
        is_login(); 
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->Inventory_model->delete($id); 
        }
       redirect(base_url().'inventory/inventoryTable', 'refresh');
    }

    
    

}