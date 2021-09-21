<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Tags extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Tags_model');
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
    public function tagsTable(){
        is_login();
        if(CheckPermission("tags", "tags")){

            $this->load->view('include/header');
            $this->load->view('tags_table');                
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
	    $table = 'tags';
    	$primaryKey = 'tag_id';
    	$columns = array(
                    array( 'db' => 'tag_id', 'dt' => 0 ),
                    array( 'db' => 'tag_name', 'dt' => 1 ),
					array( 'db' => 'tag_id', 'dt' => 2 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);


        $from='tags';

		// $where = array("user_type != 'admin'");
        $where = 'where tag_id!= "" ';

        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission('tags', "all_update")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtontags mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            
			}else if(CheckPermission('tags', "own_update") && (CheckPermission('tags', "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtontags mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
			}
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtontagsView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';



			if(CheckPermission('tags', "all_delete")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'tags\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
           
			}else if(CheckPermission('tags', "own_delete") && (CheckPermission('tags', "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'tags\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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
            $data['tagsData'] = getDataByid('tags',$this->input->post('id'),'tag_id'); 

            echo $this->load->view('add_tags', $data, true);
        } else {
            echo $this->load->view('add_tags', '', true);
        }
        exit;
    }

    public function get_modal_view() {
        is_login();
        if($this->input->post('id')){
            $data['tagsData'] = getDataByid('tags',$this->input->post('id'),'tag_id');
            echo $this->load->view('view_tags', $data, true);
        } else {
            echo $this->load->view('view_tags', $data, true);
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
        if($this->input->post('tag_id')) {
            $id = $this->input->post('tag_id');
            unset($data['tag_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'tagsTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
                
                
            $this->Tags_model->updateRow('tags', 'tag_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'tags/'.$redirect, 'refresh');
        }else{ 

            $this->Tags_model->insertRow('tags', $data);

            redirect( base_url().'tags/tagsTable', 'refresh');
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
            $this->Tags_model->delete($id); 
        }
       redirect(base_url().'tags/tagsTable', 'refresh');
    }

    public function checktagname(){
        $tag_name = $this->input->post('tag_name');

        $querym = $this->db->query('SELECT * FROM `tags` where tag_name="'.$tag_name.'" ');
        $count= $querym->num_rows();

        if ($count>=1) {
            echo "block";
        }else{
            echo "none";
        }

    }
    
}