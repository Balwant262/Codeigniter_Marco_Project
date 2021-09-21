<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Customer extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Customer_model');
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
    public function customerTable(){
        // echo "dadw";exit();
        is_login();
        if(CheckPermission("customer", "customer")){

            $this->load->view('include/header');
            $this->load->view('customer_table');                
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
	    $table = 'customers';
    	$primaryKey = 'customer_id';
    	$columns = array(
                    array( 'db' => 'customer_id', 'dt' => 0 ),
                    array( 'db' => 'DATE_FORMAT(customers.date_created, "%d/%m/%Y")', 'dt' => 1 ),
                       array( 'db' => 'co_name', 'dt' => 2 ),
					// array( 'db' => 'CONCAT(cust_fname," ",cust_mname," ",cust_lname)', 'dt' => 2),
                    array( 'db' => 'cust_phone', 'dt' => 3 ),
                    array( 'db' => 'cust_address1', 'dt' => 4 ),
					array( 'db' => 'customer_id', 'dt' => 5 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);


        $from='customers';

		// $where = array("user_type != 'admin'");
        $where = 'where customer_id!= "" ';

        $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission('customer', "all_update")){
        
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonCustomer mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            
			}else if(CheckPermission('customer', "own_update") && (CheckPermission('customer', "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonCustomer mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
			}
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonCustomerView mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
			if(CheckPermission('customer', "all_delete")){
            if($usertype=='Super admin' || $usertype=='admin'){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'customer\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
			else if(CheckPermission('customer', "own_delete") && (CheckPermission('customer', "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'customer\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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
            $data['customerData'] = getDataByid('customers',$this->input->post('id'),'customer_id'); 
            $data['customer_follow_up'] = $this->Customer_model->get_data_by('customer_contactperson',$this->input->post('id'),'custom_id');
            $data['customer_address'] = $this->Customer_model->get_data_by('customer_regd_address',$this->input->post('id'),'customer_id');
            $data['cities'] = $this->Customer_model->get_data_by('cities','','');
            $data['states'] = $this->Customer_model->get_data_by('states','','');
            $data['users'] = $this->Customer_model->get_data_by('users','Member','user_type');
            $data['customer_eqts'] = $this->Customer_model->get_data_by('customer_euipments',$this->input->post('id'),'customer_id');
            $data['customer_flts'] = $this->Customer_model->get_data_by('customer_fleets',$this->input->post('id'),'customer_id');
            $data['customer_photos'] = $this->Customer_model->get_data_by('customer_photos',$this->input->post('id'),'customer_id');
            $data['locations'] = $this->Customer_model->get_data_by('location','','');
            $data['models'] = $this->Customer_model->get_data_by('model','','');
            //var_dump($data['customer_photos']); die;
            echo $this->load->view('add_customer', $data, true);
        } else {
              $data['customer_follow_up'] = $this->Customer_model->get_data_by('customer_contactperson',$this->input->post('id'),'custom_id');
              $data['cities'] = $this->Customer_model->get_data_by('cities','','');
              $data['states'] = $this->Customer_model->get_data_by('states','','');
              $data['users'] = $this->Customer_model->get_data_by('users','Member','user_type');
              $data['locations'] = $this->Customer_model->get_data_by('location','','');
              $data['models'] = $this->Customer_model->get_data_by('model','','');
              //var_dump($data['cities']); die;
              echo $this->load->view('add_customer', $data, true);
        }
        exit;
    }

    public function get_modal_view() {
        is_login();
        if($this->input->post('id')){
            $data['customerData'] = getDataByid('customers',$this->input->post('id'),'customer_id');
             $data['customer_follow_up'] = $this->Customer_model->get_data_by('customer_contactperson',$this->input->post('id'),'custom_id');

            echo $this->load->view('view_customer', $data, true);
        } else {
            echo $this->load->view('view_customer', $data, true);
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
         unset($data['add']);
         unset($data['number']);
         unset($data['number_address']);
         unset($data['number_flt']);
         unset($data['number_eqt']);
         unset($data['number_photo']);
         
         // unset($data['count']);
        if($this->input->post('customer_id')) {
            $id = $this->input->post('customer_id');
            unset($data['customer_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'customerTable';
            }
        } else {
            $redirect = 'login';
        }
           $number = $this->input->post('number');
           $number_address = $this->input->post('number_address');
           $number_eqt = $this->input->post('number_eqt');
           $number_flt = $this->input->post('number_flt');
           $number_photo = $this->input->post('number_photo');
           
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
        $this->Customer_model->deleteRow('customer_contactperson', 'custom_id', $id);
        $this->Customer_model->deleteRow('customer_euipments ', 'customer_id', $id);
        $this->Customer_model->deleteRow('customer_fleets', 'customer_id', $id);
        
        $this->Customer_model->deleteRow('customer_regd_address', 'customer_id', $id);

            for($i=1;$i<=$number;$i++){
                $person_name = 'person_name'.$i;
                $person_email = 'person_email'.$i;
                $person_phone = 'person_phone'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
            }
            for($i=1;$i<=$number_address;$i++){
                $address_line_1 = 'address_line_1'.$i;
                $address_line_2 = 'address_line_2'.$i;
                $landmark = 'landmark'.$i;
                $city = 'city'.$i;
                $state = 'state'.$i;
                $country = 'country'.$i;
                $pin_code = 'pin_code'.$i;
                 unset($data[$address_line_1]);
                unset($data[$address_line_2]);
                unset($data[$landmark]);
                unset($data[$city]);
                unset($data[$state]);
                unset($data[$country]);
                unset($data[$pin_code]);
            }
            for($i=1;$i<=$number_eqt;$i++){
                $eqt_type = 'eqt_type'.$i;
                $eqt_make = 'eqt_make'.$i;
                $eqt_model = 'eqt_model'.$i;
                $eqt_quantity = 'eqt_quantity'.$i;
                unset($data[$eqt_type]);
                unset($data[$eqt_make]);
                unset($data[$eqt_model]);
                unset($data[$eqt_quantity]);
            }
            for($i=1;$i<=$number_flt;$i++){
                $flt_type = 'flt_type'.$i;
                $flt_dwt = 'flt_dwt'.$i;
                $flt_year = 'flt_year'.$i;
                $flt_potential = 'flt_potential'.$i;
                $flt_voyage = 'flt_voyage'.$i;
                unset($data[$flt_type]);
                unset($data[$flt_dwt]);
                unset($data[$flt_year]);
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
                if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    $person_name = 'person_name'.$i;
                    $person_email = 'person_email'.$i;
                    $person_phone = 'person_phone'.$i;
                    unset($data[$person_phone]);
                    unset($data[$person_email]);
                    unset($data[$person_name]);
                    if($this->input->post($person_name)){
                    $data_customer['person_name'] = $this->input->post($person_name);
                    $data_customer['person_email'] = $this->input->post($person_email);
                    $data_customer['person_phone'] = $this->input->post($person_phone);
                    $data_customer['custom_id'] = $id;

                      $this->Customer_model->insertRow('customer_contactperson', $data_customer);
                     }
                }
            }
            
            if($number_address > 0)  
                {
                    
                for($i=1;$i<=$number_address;$i++){
                    $address_line_1 = 'address_line_1'.$i;
                    $address_line_2 = 'address_line_2'.$i;
                    $landmark = 'landmark'.$i;
                    $city = 'city'.$i;
                    $state = 'state'.$i;
                    $country = 'country'.$i;
                    $pin_code = 'pin_code'.$i;
                    unset($data[$address_line_1]);
                    unset($data[$address_line_2]);
                    unset($data[$landmark]);
                    unset($data[$city]);
                    unset($data[$state]);
                    unset($data[$country]);
                    unset($data[$pin_code]);
                    if($this->input->post($address_line_1)){
                    $data_customer1['address_line_1'] = $this->input->post($address_line_1);
                    $data_customer1['address_line_2'] = $this->input->post($address_line_2);
                    $data_customer1['landmark'] = $this->input->post($landmark);
                    $data_customer1['city'] = $this->input->post($city);
                    $data_customer1['state'] = $this->input->post($state);
                    $data_customer1['country'] = $this->input->post($country);
                    $data_customer1['pin_code'] = $this->input->post($pin_code);
                    $data_customer1['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_regd_address', $data_customer1);
                     }
                }
            }
            
            if($number_eqt > 0)  
                {
                    
                for($i=1;$i<=$number_eqt;$i++){
                    $eqt_type = 'eqt_type'.$i;
                    $eqt_make = 'eqt_make'.$i;
                    $eqt_model = 'eqt_model'.$i;
                    $eqt_quantity = 'eqt_quantity'.$i;
                    unset($data[$eqt_type]);
                    unset($data[$eqt_make]);
                    unset($data[$eqt_model]);
                    unset($data[$eqt_quantity]);
                    if($this->input->post($eqt_type)){
                    $data_customer2['eqt_type'] = $this->input->post($eqt_type);
                    $data_customer2['eqt_make'] = $this->input->post($eqt_make);
                    $data_customer2['eqt_model'] = $this->input->post($eqt_model);
                    $data_customer2['eqt_quantity'] = $this->input->post($eqt_quantity);
                    $data_customer2['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_euipments', $data_customer2);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                    
                for($i=1;$i<=$number_flt;$i++){
                    $flt_type = 'flt_type'.$i;
                    $flt_dwt = 'flt_dwt'.$i;
                    $flt_year = 'flt_year'.$i;
                    $flt_potential = 'flt_potential'.$i;
                    $flt_voyage = 'flt_voyage'.$i;
                    unset($data[$flt_type]);
                    unset($data[$flt_dwt]);
                    unset($data[$flt_year]);
                    unset($data[$flt_potential]);
                    unset($data[$flt_voyage]);
                    if($this->input->post($flt_type)){
                    $data_customer3['flt_type'] = $this->input->post($flt_type);
                    $data_customer3['flt_dwt'] = $this->input->post($flt_dwt);
                    $data_customer3['flt_year'] = $this->input->post($flt_year);
                    $data_customer3['flt_potential'] = $this->input->post($flt_potential);
                    $data_customer3['flt_voyage'] = $this->input->post($flt_voyage);
                    $data_customer3['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_fleets', $data_customer3);
                     }
                }
            }
            
            if($number_photo > 0)  
                {
            for ($i=1; $i <=$number_photo ; $i++) {
                $old_media = 'old_media'.$i;
                $media_id = 'media_id'.$i;
                if($this->input->post($old_media) != '')
                {
                    if ( $this->upload->do_upload('media'.$i)){
                    $uplddata = array('upload_data' => $this->upload->data());
                    $imgname =  $uplddata['upload_data']['file_name'];
                    @unlink('assets/images/'.$this->input->post($old_media));

                    $datamu['media']=$imgname;
                    $this->Customer_model->updateRow('customer_photos', 'id', $this->input->post($media_id), $datamu);
                    }


                }else{
                    if ( $this->upload->do_upload('media'.$i))
                    {
                        
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data_customer4['image'] =  $uplddata['upload_data']['file_name'];
                        $data_customer4['customer_id'] = $id;
//var_dump($data_m); die;
                    $this->Customer_model->insertRow('customer_photos', $data_customer4);

                    }
                }
            }}
        
            $this->Customer_model->updateRow('customers', 'customer_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'customer/'.$redirect, 'refresh');
        }else{ 

            for($i=1;$i<=$number;$i++){
                $person_name = 'person_name'.$i;
                $person_email = 'person_email'.$i;
                $person_phone = 'person_phone'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
            }
            for($i=1;$i<=$number_address;$i++){
                $address_line_1 = 'address_line_1'.$i;
                $address_line_2 = 'address_line_2'.$i;
                $landmark = 'landmark'.$i;
                $city = 'city'.$i;
                $state = 'state'.$i;
                $country = 'country'.$i;
                $pin_code = 'pin_code'.$i;
                 unset($data[$address_line_1]);
                unset($data[$address_line_2]);
                unset($data[$landmark]);
                unset($data[$city]);
                unset($data[$state]);
                unset($data[$country]);
                unset($data[$pin_code]);
            }
            for($i=1;$i<=$number_eqt;$i++){
                $eqt_type = 'eqt_type'.$i;
                $eqt_make = 'eqt_make'.$i;
                $eqt_model = 'eqt_model'.$i;
                $eqt_quantity = 'eqt_quantity'.$i;
                unset($data[$eqt_type]);
                unset($data[$eqt_make]);
                unset($data[$eqt_model]);
                unset($data[$eqt_quantity]);
            }
            for($i=1;$i<=$number_flt;$i++){
                $flt_type = 'flt_type'.$i;
                $flt_dwt = 'flt_dwt'.$i;
                $flt_year = 'flt_year'.$i;
                $flt_potential = 'flt_potential'.$i;
                $flt_voyage = 'flt_voyage'.$i;
                unset($data[$flt_type]);
                unset($data[$flt_dwt]);
                unset($data[$flt_year]);
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
            for($i=1;$i<=$number_photo;$i++){
                $flt_type = 'media'.$i;
                unset($data[$flt_type]);
                
            }
                
                $data['date_created']=date("Y/m/d");
            $id =$this->Customer_model->insertRow('customers', $data);
            
             if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    $person_name = 'person_name'.$i;
                    $person_email = 'person_email'.$i;
                    $person_phone = 'person_phone'.$i;
                    unset($data[$person_phone]);
                    unset($data[$person_email]);
                    unset($data[$person_name]);
                    if($this->input->post($person_name)){
                    $data_customer['person_name'] = $this->input->post($person_name);
                    $data_customer['person_email'] = $this->input->post($person_email);
                    $data_customer['person_phone'] = $this->input->post($person_phone);
                    $data_customer['custom_id'] = $id;

                      $this->Customer_model->insertRow('customer_contactperson', $data_customer);
                     }
                }
            }
            
            if($number_address > 0)  
                {
                    
                for($i=1;$i<=$number_address;$i++){
                    $address_line_1 = 'address_line_1'.$i;
                    $address_line_2 = 'address_line_2'.$i;
                    $landmark = 'landmark'.$i;
                    $city = 'city'.$i;
                    $state = 'state'.$i;
                    $country = 'country'.$i;
                    $pin_code = 'pin_code'.$i;
                    unset($data[$address_line_1]);
                    unset($data[$address_line_2]);
                    unset($data[$landmark]);
                    unset($data[$city]);
                    unset($data[$state]);
                    unset($data[$country]);
                    unset($data[$pin_code]);
                    if($this->input->post($address_line_1)){
                    $data_customer1['address_line_1'] = $this->input->post($address_line_1);
                    $data_customer1['address_line_2'] = $this->input->post($address_line_2);
                    $data_customer1['landmark'] = $this->input->post($landmark);
                    $data_customer1['city'] = $this->input->post($city);
                    $data_customer1['state'] = $this->input->post($state);
                    $data_customer1['country'] = $this->input->post($country);
                    $data_customer1['pin_code'] = $this->input->post($pin_code);
                    $data_customer1['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_regd_address', $data_customer1);
                     }
                }
            }
            
            if($number_eqt > 0)  
                {
                    
                for($i=1;$i<=$number_eqt;$i++){
                    $eqt_type = 'eqt_type'.$i;
                    $eqt_make = 'eqt_make'.$i;
                    $eqt_model = 'eqt_model'.$i;
                    $eqt_quantity = 'eqt_quantity'.$i;
                    unset($data[$eqt_type]);
                    unset($data[$eqt_make]);
                    unset($data[$eqt_model]);
                    unset($data[$eqt_quantity]);
                    if($this->input->post($eqt_type)){
                    $data_customer2['eqt_type'] = $this->input->post($eqt_type);
                    $data_customer2['eqt_make'] = $this->input->post($eqt_make);
                    $data_customer2['eqt_model'] = $this->input->post($eqt_model);
                    $data_customer2['eqt_quantity'] = $this->input->post($eqt_quantity);
                    $data_customer2['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_euipments', $data_customer2);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                    
                for($i=1;$i<=$number_flt;$i++){
                    $flt_type = 'flt_type'.$i;
                    $flt_dwt = 'flt_dwt'.$i;
                    $flt_year = 'flt_year'.$i;
                    $flt_potential = 'flt_potential'.$i;
                    $flt_voyage = 'flt_voyage'.$i;
                    unset($data[$flt_type]);
                    unset($data[$flt_dwt]);
                    unset($data[$flt_year]);
                    unset($data[$flt_potential]);
                    unset($data[$flt_voyage]);
                    if($this->input->post($flt_type)){
                    $data_customer3['flt_type'] = $this->input->post($flt_type);
                    $data_customer3['flt_dwt'] = $this->input->post($flt_dwt);
                    $data_customer3['flt_year'] = $this->input->post($flt_year);
                    $data_customer3['flt_potential'] = $this->input->post($flt_potential);
                    $data_customer3['flt_voyage'] = $this->input->post($flt_voyage);
                    $data_customer3['customer_id'] = $id;

                      $this->Customer_model->insertRow('customer_fleets', $data_customer3);
                     }
                }
            }
            if($number_photo > 0) {
            for ($i=1; $i <=$number_photo ; $i++) {
                if ( $this->upload->do_upload('media'.$i))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data_m['image'] =  $uplddata['upload_data']['file_name'];
                    $data_m['customer_id'] = $id;
                    $this->Customer_model->insertRow('customer_photos', $data_m);

                }
            }}
            
            
           
            redirect( base_url().'customer/customerTable', 'refresh');
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
            $this->Customer_model->delete($id); 
        }
       redirect(base_url().'customer/customerTable', 'refresh');
    }

    public function getCities(){
        $state = $this->input->post('state');
        $data = $this->Customer_model->get_data_by('cities',$state,'state');
        echo json_encode($data); 

    }

    public function getProperties(){
        $ptype = $this->input->post('ptype');
        $data = $this->Customer_model->get_data_by('properties',$ptype,'property_type');
        echo json_encode($data); 

    }

    public function getPropertyCost(){
        $pid = $this->input->post('pid');
        $data = $this->Customer_model->get_data_by('properties',$pid,'property_id');
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

     public function getExistingCustomer(){
        $fname = $this->input->post('fname');
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->like('cust_fname', $fname, 'after');
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

     public function getExistingCustomerByPhone(){
        $phone = $this->input->post('phone');
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->like('cust_phone', $phone, 'after');
        $query = $this->db->get();
        echo json_encode($query->result()); 

    }

    public function get_book_amnt()
    {
        $mainid = $this->input->post('mainid');
         $iddata = $this->input->post('iddata');

         $query = $this->db->select('SUM(tot_amnt) as tot')->from('bookings')->where('Lead_id1',$iddata)->get();
         $resdata = $query->row();

         $val = $resdata->tot;

         $findata = array(
            'mainid'=>$mainid,
            'data'=>$val
         );
         echo json_encode($findata);
    }
}