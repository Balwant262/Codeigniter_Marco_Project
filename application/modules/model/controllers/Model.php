<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Model extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Model_model');
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
    public function modelTable(){
        is_login();
        if(CheckPermission("model", "model")){

            $this->load->view('include/header');
            $this->load->view('model_table');                
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
	    $table = 'model';
    	$primaryKey = 'model_id';
    	$columns = array(
                    array( 'db' => 'model_id', 'dt' => 0 ),
                    array( 'db' => 'model_name', 'dt' => 1 ),
					array( 'db' => 'model_id', 'dt' => 3 ),
                    array( 'db' => 'make_name', 'dt' => 2 )

		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);


        $from='model';
         $tables[0]['name']='make';
        $tables[0]['col1']='model.make_id';
        $tables[0]['col2']='make.make_id';

		// $where = array("user_type != 'admin'");
        $where = 'where model_id!= "" ';

        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission('model', "all_update")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonmodel mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            
			}else if(CheckPermission('model', "own_update") && (CheckPermission('model', "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonmodel mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
			}
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonmodelView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';



			if(CheckPermission('model', "all_delete")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'model\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
           
			}else if(CheckPermission('model', "own_delete") && (CheckPermission('model', "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'model\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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
            $data['modelData'] = getDataByid('model',$this->input->post('id'),'model_id'); 
            $data['makeData'] = $this->Model_model->get_data_by('make');

            echo $this->load->view('add_model', $data, true);
        } else {
            $data['makeData'] = $this->Model_model->get_data_by('make');

            echo $this->load->view('add_model', $data, true);
        }
        exit;
    }

    public function get_modal_view() {
        is_login();
        if($this->input->post('id')){
            $data['modelData'] = getDataByid('model',$this->input->post('id'),'model_id');
            echo $this->load->view('view_model', $data, true);
        } else {
            echo $this->load->view('view_model', $data, true);
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
        if($this->input->post('model_id')) {
            $id = $this->input->post('model_id');
            unset($data['model_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'modelTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
                
                
            $this->Model_model->updateRow('model', 'model_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'model/'.$redirect, 'refresh');
        }else{ 

            $this->Model_model->insertRow('model', $data);

            redirect( base_url().'model/modelTable', 'refresh');
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
            $this->model_model->delete($id); 
        }
       redirect(base_url().'model/modelTable', 'refresh');
    }

    public function checkmodelname(){
        $model_name = $this->input->post('model_name');

        $querym = $this->db->query('SELECT * FROM `model` where model_name="'.$model_name.'" ');
        $count= $querym->num_rows();

        if ($count>=1) {
            echo "block";
        }else{
            echo "none";
        }

    }
    
}