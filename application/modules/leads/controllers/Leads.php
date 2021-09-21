<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Leads extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        $this->load->model('Leads_model');
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
    public function leadsTable(){
        is_login();
        if(CheckPermission("leads", "leads")){
            
            $data['fromData'] =$this->input->post('from_date');
            $data['toData'] =$this->input->post('to_date');
            $data['user_id'] =$this->input->post('user_id'); 
                        
            $this->db->select('*');
            $this->db->from('leads');
            if($data['fromData']  != '' )
            {
                $this->db->where('date_created >=',$data['fromData']);
            }
            if($data['toData'] != ''){
                 $this->db->where('date_created <=',$data['toData']);
            }
           
            if($data['user_id']!=""){
                    $this->db->where('lead_managed_by =',$data['user_id']);
            }
            $query = $this->db->get();
            $data['leadData']= $query->result();
            $data['users'] = $this->Leads_model->get_data_by('users','Member','user_type');
            
            $this->load->view('include/header');
            $this->load->view('lead_table', $data);                
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
        $table = 'leads';
        $primaryKey = 'lead_id';
        $columns = array(
                    array( 'db' => 'lead_id', 'dt' => 0 ),
                    array( 'db' => 'DATE_FORMAT(date_created, "%d/%m/%Y")', 'dt' => 1 ),
                    array( 'db' => 'lead_id', 'dt' => 2 ),
                    array( 'db' => 'lead_coname', 'dt' => 3 ),
                    array( 'db' => 'lead_phone', 'dt' => 4 ),
                    array( 'db' => 'lead_id', 'dt' => 5)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );


        $from='leads';
        
        $where = 'where lead_id!= "" and is_customer=0  ';
        // $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
            if(CheckPermission('leads', "all_update")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonLead mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            }else if(CheckPermission('leads', "own_update") && (CheckPermission('leads', "all_update")!=true)){
             $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
             if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonLead mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
             }
            }
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonLeadView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
            if(CheckPermission('leads', "all_delete")){
            if($usertype=='Super admin' || $usertype=='admin'){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'leads\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
            else if(CheckPermission('leads', "own_delete") && (CheckPermission('leads', "all_delete")!=true)){
             $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
             if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'leads\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
             }
            }
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
        }
        echo json_encode($output_arr);
    }
}


    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function get_modal() {
        is_login();
        if($this->input->post('id')){
            $data['leadData'] = getDataByid('leads',$this->input->post('id'),'lead_id'); 
            $data['cities'] = $this->Leads_model->get_data_by('cities','','');
            $data['states'] = $this->Leads_model->get_data_by('states','','');
            $data['users'] = $this->Leads_model->get_data_by('users','Member','user_type');
            $data['a_statuss'] = $this->Leads_model->get_data_by('lead_action_status ',$this->input->post('id'),'lead_id');
            $data['lead_follows'] = $this->Leads_model->get_data_by('lead_follows',$this->input->post('id'),'lead_id');
            $data['lead_photos'] = $this->Leads_model->get_data_by('lead_photos',$this->input->post('id'),'lead_id');
            $data['lead_products'] = $this->Leads_model->get_data_by('lead_products',$this->input->post('id'),'lead_id');
            $data['products'] = $this->Leads_model->get_data_by('products','','');
            $data['locations'] = $this->Leads_model->get_data_by('location','','');
            $data['makes'] = $this->Leads_model->get_data_by('make','','');
            $data['models'] = $this->Leads_model->get_data_by('model','','');
            echo $this->load->view('add_lead', $data, true);
        } else {
            $data['cities'] = $this->Leads_model->get_data_by('cities','','');
            $data['states'] = $this->Leads_model->get_data_by('states','','');
            $data['users'] = $this->Leads_model->get_data_by('users','Member','user_type');
            $data['products'] = $this->Leads_model->get_data_by('products','','');
            $data['locations'] = $this->Leads_model->get_data_by('location','','');
            $data['makes'] = $this->Leads_model->get_data_by('make','','');
            $data['models'] = $this->Leads_model->get_data_by('model','','');
            echo $this->load->view('add_lead', $data, true);
        }
        exit;
    }

    public function get_modal_view() {
        is_login();
        if($this->input->post('id')){
            $data['leadData'] = getDataByid('leads',$this->input->post('id'),'lead_id');
            
            echo $this->load->view('view_lead', $data, true);
        } else {
            
            echo $this->load->view('view_lead', $data, true);
        }
        exit;
    }

    
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id='') {
        $config['upload_path']          ='assets/customer_gallery';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        $data = $this->input->post();

        unset($data['submit']);
        unset($data['number']);
        unset($data['number_flt']);
        unset($data['number_eqt']);
        unset($data['number_photo']);
        unset($data['number_product']);
        
        
        if($this->input->post('lead_id')) {
            $id = $this->input->post('lead_id');
            unset($data['lead_id']);
            
            $inquiry_received = $this->input->post('inquiry_received');
            $admin = $this->Leads_model->get_data_by('users','Admin','user_type');
            
            foreach($admin as $a){
                $recipient = $a->email;
                $subject = "Lead | Inquiry Received";
                $message = "Dear Admin,

First of all, we would like to express our thanks for your interest in our frozen mango puree product.

Regarding your inquiry, we are happy to provide you our Frozen mango puree product brochure and our Wholesale price list. Please note that the brochure included all the information you asked for. Both items are attached at the end of this email.

Regards,
Marco";
                if($inquiry_received)
                    mail($recipient, $subject, $message);
            }
            
            
        }
        unset($data['inquiry_received']);
        //var_dump("sent"); die;
        
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'leadsTable';
            }
        } else {
            $redirect = 'login';
        }
           $number = $this->input->post('number');
           $number_flt = $this->input->post('number_flt');
           $number_photo = $this->input->post('number_photo');
           $number_product = $this->input->post('number_product');
           
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
            
            $this->Leads_model->deleteRow('lead_action_status', 'lead_id', $id);
            $this->Leads_model->deleteRow('lead_follows ', 'lead_id', $id);
            $this->Leads_model->deleteRow('lead_photos', 'lead_id', $id);
            $this->Leads_model->deleteRow('lead_products', 'lead_id', $id);
            
            for($i=1;$i<=$number;$i++){
                $person_name = 'a_status'.$i;
                $person_email = 'a_date'.$i;
                $person_phone = 'a_remark'.$i;
                $users_id = 'users_id'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
                unset($data[$users_id]);
            }
            
            for($i=1;$i<=$number_flt;$i++){
                $flt_potential = 'fl_remark'.$i;
                $flt_voyage = 'fl_date'.$i;
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
            for($i=1;$i<=$number_photo;$i++){
                $flt_type = 'media'.$i;
                unset($data[$flt_type]);
                
            }
            
            for($i=1;$i<=$number_product;$i++){
                $flt_type = 'product'.$i;
                $flt_m = 'make'.$i;
                $flt_model = 'model'.$i;
                unset($data[$flt_type]);
                unset($data[$flt_m]);
                unset($data[$flt_model]);
            }
            
            if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    $a_status = 'a_status'.$i;
                    $a_date = 'a_date'.$i;
                    $a_remark = 'a_remark'.$i;
                    $users_id = 'users_id'.$i;
                    unset($data[$a_status]);
                    unset($data[$a_date]);
                    unset($data[$a_remark]);
                    unset($data[$users_id]);
                    if($this->input->post($a_status)){
                    $data_customer['a_status'] = $this->input->post($a_status);
                    $data_customer['a_date'] = $this->input->post($a_date);
                    $data_customer['a_remark'] = $this->input->post($a_remark);
                    $data_customer['users_id'] = $this->input->post($users_id);
                    $data_customer['lead_id'] = $id;

                      $this->Leads_model->insertRow('lead_action_status', $data_customer);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                    
                for($i=1;$i<=$number_flt;$i++){
                    
                    $fl_remark = 'fl_remark'.$i;
                    $fl_date = 'fl_date'.$i;
                    
                    unset($data[$fl_remark]);
                    unset($data[$fl_date]);
                    if($this->input->post($fl_remark)){
                    
                    $data_customer3['fl_remark'] = $this->input->post($fl_remark);
                    $data_customer3['fl_date'] = $this->input->post($fl_date);
                    $data_customer3['lead_id'] = $id;

                      $this->Leads_model->insertRow('lead_follows', $data_customer3);
                     }
                }
            }
            if($number_photo > 0) {
            for ($i=1; $i <=$number_photo ; $i++) {
                if ( $this->upload->do_upload('media'.$i))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data_m['image'] =  $uplddata['upload_data']['file_name'];
                    $data_m['lead_id'] = $id;
                    $this->Leads_model->insertRow('lead_photos', $data_m);

                }
            }}
            
            if($number_product > 0) {
            for ($i=1; $i <=$number_product ; $i++) {
                $fl_remark = 'product'.$i;
                $fl_make = 'make'.$i;
                $fl_model = 'model'.$i;
                unset($data[$fl_remark]);
                unset($data[$fl_make]);
                unset($data[$fl_model]);
                
                    if($this->input->post($fl_remark)){ 
                    $data_m['product'] =  $this->input->post($fl_remark);
                    $data_m['make_id'] =  $this->input->post($fl_make);
                    $data_m['model_id'] =  $this->input->post($fl_model);
                    $data_m['lead_id'] = $id;
                    $this->Leads_model->insertRow('lead_products', $data_m);

                }
            }}
            
            $this->Leads_model->updateRow('leads', 'lead_id', $id, $data);

            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'leads/'.$redirect, 'refresh');
        }else{
            
            for($i=1;$i<=$number;$i++){
                $person_name = 'a_status'.$i;
                $person_email = 'a_date'.$i;
                $person_phone = 'a_remark'.$i;
                $users_id = 'users_id'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
                unset($data[$users_id]);
            }
            
            for($i=1;$i<=$number_flt;$i++){
                $flt_potential = 'fl_remark'.$i;
                $flt_voyage = 'fl_date'.$i;
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
            for($i=1;$i<=$number_photo;$i++){
                $flt_type = 'media'.$i;
                unset($data[$flt_type]);
                
            }
            
            for($i=1;$i<=$number_product;$i++){
                $fl_remark = 'product'.$i;
                $fl_make = 'make'.$i;
                $fl_model = 'model'.$i;
                unset($data[$flt_type]);
                unset($data[$fl_make]);
                unset($data[$fl_model]);
                
            }

            unset($data['lead_id']);
 
            $id = $this->Leads_model->insertRow('leads', $data);
            
            if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    $a_status = 'a_status'.$i;
                    $a_date = 'a_date'.$i;
                    $a_remark = 'a_remark'.$i;
                    $users_id = 'users_id'.$i;
                    unset($data[$a_status]);
                    unset($data[$a_date]);
                    unset($data[$a_remark]);
                    unset($data[$users_id]);
                    if($this->input->post($a_status)){
                    $data_customer['a_status'] = $this->input->post($a_status);
                    $data_customer['a_date'] = $this->input->post($a_date);
                    $data_customer['a_remark'] = $this->input->post($a_remark);
                    $data_customer['users_id'] = $this->input->post($users_id);
                    $data_customer['lead_id'] = $id;

                      $this->Leads_model->insertRow('lead_action_status', $data_customer);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                    
                for($i=1;$i<=$number_flt;$i++){
                    
                    $fl_remark = 'fl_remark'.$i;
                    $fl_date = 'fl_date'.$i;
                    
                    unset($data[$fl_remark]);
                    unset($data[$fl_date]);
                    if($this->input->post($fl_remark)){
                    
                    $data_customer3['fl_remark'] = $this->input->post($fl_remark);
                    $data_customer3['fl_date'] = $this->input->post($fl_date);
                    $data_customer3['lead_id'] = $id;

                      $this->Leads_model->insertRow('lead_follows', $data_customer3);
                     }
                }
            }
            if($number_photo > 0) {
            for ($i=1; $i <=$number_photo ; $i++) {
                if ( $this->upload->do_upload('media'.$i))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data_m1['image'] =  $uplddata['upload_data']['file_name'];
                    $data_m1['lead_id'] = $id;
                    $this->Leads_model->insertRow('lead_photos', $data_m1);

                }
                
            }}
            
            if($number_product > 0) {
            for ($i=1; $i <=$number_product ; $i++) {
                $fl_remark = 'product'.$i;
                $fl_make = 'make'.$i;
                $fl_model = 'model'.$i;
                unset($data[$flt_type]);
                unset($data[$fl_make]);
                unset($data[$fl_model]);
                
                    if($this->input->post($fl_remark)){ 
                    $data_m['product'] =  $this->input->post($fl_remark);
                    $data_m['make_id'] =  $this->input->post($fl_make);
                    $data_m['model_id'] =  $this->input->post($fl_model);
                    $data_m['lead_id'] = $id;
                    $this->Leads_model->insertRow('lead_products', $data_m);

                }
            }}
           
            redirect( base_url().'leads/leadsTable', 'refresh');
            //}
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
            $this->Leads_model->delete($id); 
        }
       redirect(base_url().'leads/leadsTable', 'refresh');
    }

   

}