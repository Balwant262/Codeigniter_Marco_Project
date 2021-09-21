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
        // echo "dadw";exit();
        is_login();
        // if(CheckPermission("leads", "leads")){
            $this->load->view('include/header');
            $this->load->view('lead_table');                
            $this->load->view('include/footer');            
        // } else {
        //     $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
        //     redirect( base_url().'user/profile', 'refresh');
        // }
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
                    array( 'db' => 'lead_id', 'dt' => 1 ),
                    array( 'db' => 'lead_fname', 'dt' => 2 ),
                    array( 'db' => 'lead_lname', 'dt' => 3 ),
                    array( 'db' => 'lead_phone', 'dt' => 4 ),
                    array( 'db' => 'name', 'dt' => 5 ),
                    array( 'db' => 'property_title', 'dt' => 6 ),
     //                array( 'db' => 'city_name', 'dt' => 6 ),
                    // array( 'db' => 'lead_country', 'dt' => 7 ),
                    array( 'db' => 'lead_id', 'dt' => 7)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );


        $from='leads';
        $tables[0]['name']='cities';
        $tables[0]['col1']='leads.lead_city';
        $tables[0]['col2']='cities.city_id';

        $tables[1]['name']='properties';
        $tables[1]['col1']='leads.property_id';
        $tables[1]['col2']='properties.property_id';

        $tables[2]['name']='users';
        $tables[2]['col1']='leads.assigned_to';
        $tables[2]['col2']='users.users_id';

        // $where = array("user_type != 'admin'");
        $where = 'where lead_id!= "" and is_customer=0  ';

        $usertype =$this->session->get_userdata()['user_details'][0]->user_type;
        $useroff=$this->session->get_userdata()['user_details'][0]->office_id;
        if($usertype!='Super admin'){

            // $query = $this->db->select('office_city')->from('offices')->where('office_id',$useroff)->get();
            // $result = $query->row();
            // $office_city = $result->office_city;    
  
            $where .= ' and leads.office_id='.$useroff.' ';     
        }




        $where .= " group by unique_id";
        // $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
            // if(CheckPermission('user', "all_update")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonLead mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            // }else if(CheckPermission('user', "own_update") && (CheckPermission('user', "all_update")!=true)){
            //  $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
            //  if($user_id==$this->user_id){
            // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            //  }
            // }
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonLeadView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
            // if(CheckPermission('user', "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'leads\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            // else if(CheckPermission('user', "own_delete") && (CheckPermission('user', "all_delete")!=true)){
            //  $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
            //  if($user_id==$this->user_id){
            // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            //  }
            // }
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
            $data['leadData'] = getDataByid('leads',$this->input->post('id'),'lead_id'); 
            $data['stateData']  = $this->Leads_model->get_state_data();
            $data['userData']  = $this->Leads_model->get_data_by('users');
            $data['leads_followupData']  = $this->Leads_model->get_data_by('communications',$this->input->post('id'),'lead_id');
            $data['propertyData']  = $this->Leads_model->get_data_by('properties');
            $data['SVOdetails']  = $this->Leads_model->get_data_by('svo_details',$this->input->post('id'),'lead_id');
            echo $this->load->view('add_lead', $data, true);
        } else {
            $data['stateData']  = $this->Leads_model->get_state_data();
            $data['userData']  = $this->Leads_model->get_data_by('users');
            $data['propertyData']  = $this->Leads_model->get_data_by('properties');
         //   $data['leads_followupData']  = $this->Leads_model->get_data_by('communications',$this->input->post('id'),'lead_id');
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

    public function get_modal_view_inquiry() {
        is_login();
        if($this->input->post('id')){
            $data['leadData1'] = getDataByid('leads',$this->input->post('id'),'unique_id');
            $data['stateData']  = $this->Leads_model->get_state_data();
            $data['userData']  = $this->Leads_model->get_data_by('users');
            $data['propertyData']  = $this->Leads_model->get_data_by('properties');
            echo $this->load->view('add_inquiry', $data, true);
        } else {
            echo $this->load->view('add_inquiry', $data, true);
        }
        exit;
    }
    
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id='') {   
        $data = $this->input->post();
        $phoneno = $data['lead_phone'];
        $number = $this->input->post('number');
        $number2 = $this->input->post('number2');
          unset($data['submit']);
         unset($data['add']);
         unset($data['number']);
         unset($data['count']);
         unset($data['number2']);
        if($this->input->post('lead_id')) {
            $id = $this->input->post('lead_id');
            unset($data['lead_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'leadsTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
            $this->Leads_model->deleteRow('communications', 'lead_id', $id);
            $this->Leads_model->deleteRow('svo_details', 'lead_id', $id);

            for($i=1;$i<=$number;$i++){
                    $message = 'message'.$i;
                    $entry_by = 'entry_by'.$i;
                     $next_followup = 'next_followup'.$i;
                    $date_created = 'date_created'.$i;
                    unset($data[$message]);
                    unset($data[$entry_by]);
                     unset($data[$next_followup]);
                    unset($data[$date_created]);
            }
            for($i=1;$i<=$number2;$i++){
            
                     $svo_name = 'svo_name'.$i;
                    $svo_date = 'svo_date'.$i;
                     $svo_remark = 'svo_remark'.$i;
                    $svo_property = 'svo_property'.$i;
                    unset($data[$svo_name]);
                    unset($data[$svo_date]);
                    unset($data[$svo_remark]);
                    unset($data[$svo_property]);                
            }
                if($number > 0)  
                {  
                    for($i=1;$i<=$number;$i++){
                    $message = 'message'.$i;
                    $entry_by = 'entry_by'.$i;
                    $next_followup = 'next_followup'.$i;
                    $date_created = 'date_created'.$i;
                        if($this->input->post($message)){
                        $data_followup['message'] = $this->input->post($message);
                        $data_followup['entry_by'] = $this->input->post($entry_by);
                         $data_followup['next_followup'] = $this->input->post($next_followup);
                        $data_followup['date_created'] = $this->input->post($date_created);
                        
                        // if($i==1){
                            $data_followup['lead_id'] = $id;
                        // }
                        $this->Leads_model->insertRow('communications', $data_followup);
                        }
                    }
                }

                if($number2 > 0)  
                {  
                for($i=1;$i<=$number2;$i++){
                    $svo_name = 'svo_name'.$i;
                    $svo_date = 'svo_date'.$i;
                     $svo_remark = 'svo_remark'.$i;
                    $svo_property = 'svo_property'.$i;
            
                    if($this->input->post($svo_name)){
                            $data_svo['svo_name'] = $this->input->post($svo_name);
                            $data_svo['svo_date'] = $this->input->post($svo_date);
                            $data_svo['svo_remark'] = $this->input->post($svo_remark);
                            $data_svo['svo_property'] = $this->input->post($svo_property);
                         
                        $data_svo['lead_id'] = $id;
                        
                        $this->Leads_model->insertRow('svo_details', $data_svo);
                        }
                    }   
                } 

            $this->Leads_model->updateRow('leads', 'lead_id', $id, $data);
            if($data['is_customer']==1){
                $data['lead_id']=$id;
                unset($data['is_customer']);
                $data['cust_fname']=$data['lead_fname'];
                $data['cust_lname']=$data['lead_lname'];
                $data['cust_country']=$data['lead_country'];
                $data['cust_state']=$data['lead_state'];
                $data['cust_city']=$data['lead_city'];
                $data['cust_phone']=$data['lead_phone'];
                unset($data['lead_fname']);
                unset($data['lead_lname']);
                unset($data['lead_country']);
                unset($data['lead_state']);
                unset($data['lead_city']);
                unset($data['unique_id']);
                unset($data['lead_phone']);
                unset($data['closing_by']);
                unset($data['business_assoc']);
                unset($data['budget']);
                unset($data['reference']);
                unset($data['social']);
                $this->Leads_model->insertRow('customers', $data);
            }
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'leads/'.$redirect, 'refresh');
        }else{ 

            $useroff=$this->session->get_userdata()['user_details'][0]->office_id;

            $data['office_id'] = $useroff;

            $maxid = $this->db->query('SELECT MAX(lead_id) AS `lead_id` FROM `leads`')->row()->lead_id;
            
            $data['unique_id']=$maxid+1;
            
            // $query = $this->db->query("select * from leads where (lead_fname='$data[lead_fname]' and lead_lname='$data[lead_lname]') OR phone='$data[phone]' ");

            // $a = $query->result_array();

            // if(count($a) > 0){
            //     $this->session->set_flashdata('messagePr', 'Lead already exist..');
            //     redirect( base_url().'leads/leadsTable', 'refresh');
            // }else{

           unset($data['lead_id']);

           for($i=1;$i<=$number;$i++){
            
                     $message = 'message'.$i;
                    $entry_by = 'entry_by'.$i;
                     $next_followup = 'next_followup'.$i;
                    $date_created = 'date_created'.$i;
                    unset($data[$message]);
                    unset($data[$entry_by]);
                    unset($data[$next_followup]);
                    unset($data[$date_created]);                
                }
            for($i=1;$i<=$number2;$i++){
            
                     $svo_name = 'svo_name'.$i;
                    $svo_date = 'svo_date'.$i;
                     $svo_remark = 'svo_remark'.$i;
                    $svo_property = 'svo_property'.$i;
                    unset($data[$svo_name]);
                    unset($data[$svo_date]);
                    unset($data[$svo_remark]);
                    unset($data[$svo_property]);                
                }
               
            $id = $this->Leads_model->insertRow('leads', $data); 
           
            if($number > 0)  
                {  
        
                for($i=1;$i<=$number;$i++){
                    $message = 'message'.$i;
                    $entry_by = 'entry_by'.$i;
                     $next_followup = 'next_followup'.$i;
                    $date_created = 'date_created'.$i;
            
                if($this->input->post($message)){
                        // echo "2343 pro FOR";
       
              $data_followup['message'] = $this->input->post($message);
                $data_followup['entry_by'] = $this->input->post($entry_by);
                 $data_followup['next_followup'] = $this->input->post($next_followup);
                $data_followup['date_created'] = $this->input->post($date_created);
                    
                    
                }
                if($i==1){
                    
                    
                    $data_followup['lead_id'] = $id;
                    // var_dump($data);
                    // exit;
                }
                
                $this->Leads_model->insertRow('communications', $data_followup);
                // print_r($this->db->last_query());
                // exit();
                
            }   
               
                } 

             if($number2 > 0)  
                {  
        
                for($i=1;$i<=$number2;$i++){
                    $svo_name = 'svo_name'.$i;
                    $svo_date = 'svo_date'.$i;
                     $svo_remark = 'svo_remark'.$i;
                    $svo_property = 'svo_property'.$i;
            
                if($this->input->post($svo_name)){
                        // echo "2343 pro FOR";
       
              $data_svo['svo_name'] = $this->input->post($svo_name);
                $data_svo['svo_date'] = $this->input->post($svo_date);
                 $data_svo['svo_remark'] = $this->input->post($svo_remark);
                $data_svo['svo_property'] = $this->input->post($svo_property);
                    
                    
                }
                if($i==1){
                    
                    
                    $data_svo['lead_id'] = $id;
                    // var_dump($data);
                    // exit;
                }
                
                $this->Leads_model->insertRow('svo_details', $data_svo);
                // print_r($this->db->last_query());
                // exit();
                
                }   
                } 



            // $insert_id = $this->db->insert_id();

            if($data['is_customer']==1){
                $data['lead_id']=$id;
                unset($data['is_customer']);
                $data['cust_fname']=$data['lead_fname'];
                $data['cust_lname']=$data['lead_lname'];
                $data['cust_country']=$data['lead_country'];
                $data['cust_state']=$data['lead_state'];
                $data['cust_city']=$data['lead_city'];
                $data['cust_phone']=$data['lead_phone'];
                unset($data['lead_fname']);
                unset($data['lead_lname']);
                unset($data['lead_country']);
                unset($data['lead_state']);
                unset($data['lead_city']);
                unset($data['unique_id']);
                unset($data['lead_phone']);
                unset($data['closing_by']);
                unset($data['business_assoc']);
                unset($data['budget']);
                unset($data['reference']);
                unset($data['social']);
                // echo "<pre>";print_r($data);exit;
                $maxid2 = $this->db->query('SELECT MAX(customer_id) AS `customer_id` FROM `customers`')->row()->customer_id;

                $data['cust_code']='SC-'.($maxid2+1);
                $this->Leads_model->insertRow('customers', $data);
            }


            
            // $message = 'Welcome To Sealinkcitymumbai. Your information has been added Successfully.';

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => "https://sms.cell24x7.in/otpReceiver/sendSMS?user=usertech&pwd=apiusertech&sender=INFRAA&mobile=".$phoneno."&msg=".urlencode($message)."&mt=0",
            //   CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_ENCODING => "",
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 0,
            //   CURLOPT_FOLLOWLOCATION => true,
            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //   CURLOPT_CUSTOMREQUEST => "GET",
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);

            

            // exit();

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

    public function getCities(){
        $state = $this->input->post('state');
        $data = $this->Leads_model->get_data_by('cities',$state,'state');
        echo json_encode($data); 

    }


    public function add_inquiry($id='') {   
        $data = $this->input->post();
        unset($data['submit']);

        $get = $this->Leads_model->get_data_by('leads',$data[unique_id],'unique_id');

        $data['status']=$get[0]->status;
        $data['is_customer']=$get[0]->is_customer;
        
        $this->Leads_model->insertRow('leads', $data);

        $this->session->set_flashdata('messagePr', 'Inquiry added..');
        redirect( base_url().'leads/leadsTable', 'refresh');
        
    }

    public function getProperties(){
        $ptype = $this->input->post('ptype');
        $data = $this->Leads_model->get_data_by('properties',$ptype,'property_type');
        echo json_encode($data); 

    }

     public function getPropertyCost(){
        $pid = $this->input->post('pid');
        $data = $this->Leads_model->get_data_by('properties',$pid,'property_id');
        echo json_encode($data); 

    }
    
    public function getExistingLead(){
        $fname = $this->input->post('fname');    
        $this->db->select('*');
        $this->db->from('leads');
        $this->db->like('lead_fname', $fname, 'after');
        $this->db->group_by('unique_id');
        $query = $this->db->get();
        echo json_encode($query->result()); 

    }

    public function getExistingLeadByPhone(){
        $phone = $this->input->post('phone');    
        $this->db->select('*');
        $this->db->from('leads');
        $this->db->like('lead_phone', $phone, 'after');
        $this->db->group_by('unique_id');
        $query = $this->db->get();
        echo json_encode($query->result()); 

    }

}