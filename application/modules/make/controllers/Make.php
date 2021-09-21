<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Make extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Make_model');
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
    public function makeTable(){
        is_login();
        if(CheckPermission("make", "make")){

            $this->load->view('include/header');
            $this->load->view('make_table');                
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
	    $table = 'make';
    	$primaryKey = 'make_id';
    	$columns = array(
                    array( 'db' => 'make_id', 'dt' => 0 ),
                    array( 'db' => 'make_name', 'dt' => 1 ),
					array( 'db' => 'make_id', 'dt' => 2 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);


        $from='make';

		// $where = array("user_type != 'admin'");
        $where = 'where make_id!= "" ';

        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission('make', "all_update")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonmake mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            
			}else if(CheckPermission('make', "own_update") && (CheckPermission('make', "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonmake mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
			}
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonmakeView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';



			if(CheckPermission('make', "all_delete")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'make\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
           
			}else if(CheckPermission('make', "own_delete") && (CheckPermission('make', "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'make\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
				}
			}
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
		}
		echo json_encode($output_arr);
    }



    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function get_modal() {
        is_login();
        if($this->input->post('id')){
            $data['makeData'] = getDataByid('make',$this->input->post('id'),'make_id'); 

            echo $this->load->view('add_make', $data, true);
        } else {
            echo $this->load->view('add_make', '', true);
        }
        exit;
    }

    public function get_modal_view() {
        is_login();
        if($this->input->post('id')){
            $data['makeData'] = getDataByid('make',$this->input->post('id'),'make_id');
            echo $this->load->view('view_make', $data, true);
        } else {
            echo $this->load->view('view_make', $data, true);
        }
        exit;
    }
	
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id='') {   
        
        $data = $this->input->post();
        unset($data['submit']);
        if($this->input->post('make_id')) {
            $id = $this->input->post('make_id');
            unset($data['make_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'makeTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
                
                
            $this->Make_model->updateRow('make', 'make_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'make/'.$redirect, 'refresh');
        }else{ 

            $this->Make_model->insertRow('make', $data);

            redirect( base_url().'make/makeTable', 'refresh');
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
            $this->Make_model->delete($id); 
        }
       redirect(base_url().'make/makeTable', 'refresh');
    }

    public function checkmakename(){
        $make_name = $this->input->post('make_name');

        $querym = $this->db->query('SELECT * FROM `make` where make_name="'.$make_name.'" ');
        $count= $querym->num_rows();

        if ($count>=1) {
            echo "block";
        }else{
            echo "none";
        }

    }
    
}