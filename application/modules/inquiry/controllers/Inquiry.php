<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Inquiry extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Inquiry_model');
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
    public function inquiryTable(){
        is_login();
	
		
        if(CheckPermission("inquiry", "inquiry")){
            $data['fromData'] =$this->input->post('from_date');
            $data['toData'] =$this->input->post('to_date');
            $data['inqstatuss'] =$this->input->post('inqstatuss'); 
            $data['reason'] =$this->input->post('lostreasont'); 
            $data['prod'] =$this->input->post('products'); 
            $data['assemblyprod'] =$this->input->post('assemblyprod');
            $data['user_id'] =$this->input->post('user_id');
            
            $this->db->select('*');
            $this->db->from('inquiry');
            if($data['fromData']  != '' )
            {
                $this->db->where('inq_date_created >=',$data['fromData']);
            }
            if($data['toData'] != ''){
                 $this->db->where('inq_date_created <=',$data['toData']);
            }
           
            if($data['inqstatuss']!=""){
                    $this->db->where('inqstatus =',$data['inqstatus']);
            }
            if($data['reason']!=""){
                    $this->db->where('lostreason =',$data['lostreason']);
            }
            if($data['prod']!=""){
                    $this->db->join('inquiry_products p', 'p.inq_id=inquiry.inquiry_id')->where('p.products =',$data['prod']);
            }
            if($data['assemblyprod']!=""){
                    $this->db->join('inquiry_products a', 'a.inq_id=inquiry.inquiry_id')->where('a.assemblyprod =',$data['assemblyprod']);
            }
            if($data['user_id']!=""){
                    $this->db->join('inquiry_follows a', 'a.inquiry_id=inquiry.inquiry_id')->where('a.user_id =',$data['user_id']);
            }
             

            $query = $this->db->get();
            $data['ordersData']= $query->result();
            $data['productData'] = $this->Inquiry_model->get_data_by('products');
            $data['assembleData'] = $this->Inquiry_model->get_data_by('assemble');
            $data['users'] = $this->Inquiry_model->get_data_by('users','Member','user_type');
            $this->load->view('include/header');
            $this->load->view('inquiry_table',$data);                
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
        $from1 =  $this->uri->segment(3);
        $to1 =  $this->uri->segment(4); 
         $status =  $this->uri->segment(5); 

        is_login();
	    $table = 'inquiry';
    	$primaryKey = 'inquiry_id';
    	$columns = array(
          // array( 'sdb' => 'inquiry_id',   'dt' => 0 ),
          array( 'db' => 'inqrefno', 'dt' => 0),
          array( 'db' => 'marco_inqrefno', 'dt' => 1),
          array( 'db' => 'inq_coname', 'dt' => 2),
          array( 'db' => 'inq_coemail', 'dt' => 3),
          array( 'db' => 'inq_coperson', 'dt' => 4),
          array( 'db' => 'inq_address', 'dt' => 5),
          array( 'db' => 'DATE_FORMAT(inq_date_created, "%d/%m/%Y")', 'dt' => 6),
          array( 'db' => 'inquiry_id', 'dt' => 7) 
		  
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
		$from='inquiry';
        $where = 'where inquiry_id != "" ';
        // $tables[0]['name']='product';
        // $tables[0]['col1']='inquiry.product_id';
        // $tables[0]['col2']='product.product_id';

        // $tables[0]['name']='leads';
        // $tables[0]['col1']='inquiry.exist_lead';
        // $tables[0]['col2']='leads.inquiry_id';
        $tables[0]['name']='customers';
        $tables[0]['col1']='inquiry.exist_cust';
        $tables[0]['col2']='customers.customer_id';
       
         if($from1 != '' )
        {
         $where .=" and inquiry.inq_date_created >= '".$from1."' ";
        }
        if( $to1 != '')
        {
         $where .=" and inquiry.inq_date_created <=  '".$to1."'";
        }
        if( $status != '')
        {
         $where .=" and inquiry.inqstatus ='".$status."'";
        }
         $where .=' group by inquiry_id';

       $output_arr = SSP::innerJoin( $_GET, $sql_details, $from,$tables, $primaryKey, $columns, $where, $col_name,$order,$order_type);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			
			$usertype =$this->session->get_userdata()['user_details'][0]->user_type; 
                  // if($usertype=='admin' || $usertype=='Manager'){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="inquiryModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
			 // }
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="inquiryModalButtonView mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
			
			$usertype =$this->session->get_userdata()['user_details'][0]->user_type; 
                  // if($usertype=='admin' || $usertype=='Manager'){
            // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="inquiryModalButtonConfirm mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Confirm Order"><i class="fa fa-check-circle-o" data-id=""></i></a>';
            // }

           // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id=""  class=" mClass"  href="'.base_url().'inquiry/Confirm/'.$id.'" type="button" data-src="'.$id.'" title="Confirm"><i class="fa  fa-check-circle-o " data-id=""></i></a>';

			
			 $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'inquiry\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
			
            // $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
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
            
            $data['inquiryData'] = getDataByid('inquiry',$this->input->post('id'),'inquiry_id');
        
          $data['inquiry_follow_up'] = $this->Inquiry_model->get_data_by('inquiry_products',$this->input->post('id'),'inq_id');
            $data['leadsData'] = $this->Inquiry_model->get_data_by('leads');
            $data['custData'] = $this->Inquiry_model->get_data_by('customers');
            $data['productData'] = $this->Inquiry_model->get_data_by('products');
            $data['assembleData'] = $this->Inquiry_model->get_data_by('assemble');
            $data['users'] = $this->Inquiry_model->get_data_by('users','Member','user_type');
            $data['a_statuss'] = $this->Inquiry_model->get_data_by('inquiry_action_status ',$this->input->post('id'),'inquiry_id');
            $data['lead_follows'] = $this->Inquiry_model->get_data_by('inquiry_follows',$this->input->post('id'),'inquiry_id');
            $data['lead_photos'] = $this->Inquiry_model->get_data_by('inquiry_photos',$this->input->post('id'),'inquiry_id');
            $data['makes'] = $this->Inquiry_model->get_data_by('make','','');
            $data['models'] = $this->Inquiry_model->get_data_by('model','','');
            echo $this->load->view('add_inquiry', $data, true);
        } else {
            $data['custData'] = $this->Inquiry_model->get_data_by('customers');
            $data['leadsData'] = $this->Inquiry_model->get_data_by('leads');
            $data['inquiry_follow_up'] = $this->Inquiry_model->get_data_by('inquiry_products',$this->input->post('id'),'inq_id');
            $data['productData'] = $this->Inquiry_model->get_data_by('products');
            $data['assembleData'] = $this->Inquiry_model->get_data_by('assemble');
            $data['inquiry_follow_up'] = $this->Inquiry_model->get_data_by('inquiry_products');
            $data['users'] = $this->Inquiry_model->get_data_by('users','Member','user_type');
            $data['makes'] = $this->Inquiry_model->get_data_by('make','','');
            $data['models'] = $this->Inquiry_model->get_data_by('model','','');
            echo $this->load->view('add_inquiry', $data, true);
        }
        exit;
    }
	public function get_modalView(){
		 is_login();
        if($this->input->post('id')){
            $data['inquiryData'] = getDataByid('inquiry',$this->input->post('id'),'inquiry_id');
               $data['inquiry_follow_up'] = $this->Inquiry_model->get_data_by('inquiry_products',$this->input->post('id'),'inq_id');
            // $data['itemsData'] = $this->Inquiry_model->get_data_by('inquiry',$data['inquiryData']->inquiry_number ,'inquiry_number');
           
            //$data['productData'] = $this->Inquiry_model->get_data_by('products');
            
            echo $this->load->view('view_inquiry', $data, true);
        } else {
            //$data['productData'] = $this->Inquiry_model->get_data_by('products');
            
             $this->load->view('view_inquiry', $data, true);
        }
        exit;
	}	
	
    public function get_modalConfirm(){
         is_login();
        if($this->input->post('id')){
            $inquiryData = getDataByid('inquiry',$this->input->post('id'),'inquiry_id');
            $data['inquiryData'] = $this->Inquiry_model->get_data_by('inquiry',$inquiryData->inquiry_number,'inquiry_number');
            $data['clientData'] = $this->Inquiry_model->get_data_by('client');
            echo $this->load->view('confirm_order', $data, true);
        } else {

            $data['clientData'] = $this->Inquiry_model->get_data_by('client'); 
             $this->load->view('confirm_order', $data, true);
        }
        exit;
    }   

    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add($id='') {   
		// $data =array();
        $config['upload_path']          ='assets/customer_gallery';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        
         $data = $this->input->post();
         
         unset($data['submit']);
         unset($data['number']);
         unset($data['number2']);
         unset($data['number_flt']);
         unset($data['number_eqt']);
         unset($data['number_photo']);
         unset($data['number_product']);
         unset($data['add']);
		 
		 if($this->input->post('inquiry_id')) {

            $id = $this->input->post('inquiry_id');
			unset($data['id']);

        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'inquiry';
            }
        } else {
            $redirect = 'login';
        }
	
        $number = $this->input->post('number');
        $number2 = $this->input->post('number2');
        $number_flt = $this->input->post('number_flt');
        $number_photo = $this->input->post('number_photo');
		
		
        if($id != '') {
  
            if(isset($data['edit'])){
                unset($data['edit']);
			}
                        
          $this->Inquiry_model->deleteRow('inquiry_products', 'inq_id', $id);
          
          $this->Inquiry_model->deleteRow('inquiry_action_status', 'inquiry_id', $id);
          $this->Inquiry_model->deleteRow('inquiry_follows ', 'inquiry_id', $id);
          $this->Inquiry_model->deleteRow('inquiry_photos', 'inquiry_id', $id);
          
          
            
            for($i=1;$i<=$number2;$i++){
                $person_name = 'a_status'.$i;
                $person_email = 'a_date'.$i;
                $person_phone = 'a_remark'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
            }
            
            for($i=1;$i<=$number_flt;$i++){
                $flt_potential = 'fl_remark'.$i;
                $flt_voyage = 'fl_date'.$i;
                $flt_user = 'user_id'.$i;
                unset($data[$flt_user]);
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
            for($i=1;$i<=$number_photo;$i++){
                $flt_type = 'media'.$i;
                unset($data[$flt_type]);
                
            }
            
            if($number2 > 0)  
                {
                    
                for($i=1;$i<=$number2;$i++){
                    $a_status = 'a_status'.$i;
                    $a_date = 'a_date'.$i;
                    $a_remark = 'a_remark'.$i;
                    unset($data[$a_status]);
                    unset($data[$a_date]);
                    unset($data[$a_remark]);
                    if($this->input->post($a_status)){
                    $data_customer['a_status'] = $this->input->post($a_status);
                    $data_customer['a_date'] = $this->input->post($a_date);
                    $data_customer['a_remark'] = $this->input->post($a_remark);
                    $data_customer['inquiry_id'] = $id;

                      $this->Inquiry_model->insertRow('inquiry_action_status', $data_customer);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                for($i=1;$i<=$number_flt;$i++){
                    
                    $fl_remark = 'fl_remark'.$i;
                    $fl_date = 'fl_date'.$i;
                    $fl_user = 'user_id'.$i;
                    unset($data[$fl_user]);
                    unset($data[$fl_remark]);
                    unset($data[$fl_date]);
                    if($this->input->post($fl_remark)){
                    $data_customer3['fl_remark'] = $this->input->post($fl_remark);
                    $data_customer3['fl_date'] = $this->input->post($fl_date);
                    $data_customer3['user_id'] = $this->input->post($fl_user);
                    $data_customer3['inquiry_id'] = $id;
                      $this->Inquiry_model->insertRow('inquiry_follows', $data_customer3);
                     }
                }
            }
            if($number_photo > 0) {
            for ($i=1; $i <=$number_photo ; $i++) {
                if ( $this->upload->do_upload('media'.$i))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data_m['image'] =  $uplddata['upload_data']['file_name'];
                    $data_m['inquiry_id'] = $id;
                    $this->Inquiry_model->insertRow('inquiry_photos', $data_m);

                }
            }}
            
            for($i=1;$i<=$number;$i++){                  
               $products = 'products'.$i;
               $assemblyprod = 'assemblyprod'.$i;
                $qty = 'qty'.$i;
                 $description = 'description'.$i;
               $price = 'price'.$i;
               $flt_m = 'make'.$i;
               $flt_model = 'model'.$i;
               unset($data[$flt_m]);
               unset($data[$flt_model]);
                unset($data[$products]);
                    unset($data[$assemblyprod]);
                       unset($data[$qty]);
                        unset($data[$description]);
                    unset($data[$price]);
            }
            if($number > 0)  
                {
                    
              for($i=1;$i<=$number;$i++){
                    $data_customer=array();
                   $products = 'products'.$i;
                   $assemblyprod = 'assemblyprod'.$i;
                    $qty = 'qty'.$i;
                     $description = 'description'.$i;
                   $price = 'price'.$i;
                unset($data[$products]);
                unset($data[$assemblyprod]);
                  unset($data[$qty]);
                      unset($data[$description]);
                unset($data[$price]);
               $flt_m = 'make'.$i;
               $flt_model = 'model'.$i;
               unset($data[$flt_m]);
               unset($data[$flt_model]);
               
                $data_customer['inq_id'] = $id;
                if($this->input->post($products) ){
                   
                $data_customer['products'] = $this->input->post($products);
                $data_customer['make_id'] =  $this->input->post($flt_m);
                $data_customer['model_id'] =  $this->input->post($flt_model);
                $data_customer['qty'] = $this->input->post($qty);
                $data_customer['price'] = $this->input->post($price);
                $data_customer['description'] = $this->input->post($description);
                $this->Inquiry_model->insertRow('inquiry_products', $data_customer);
                }
                if( $this->input->post($assemblyprod)){
                $data_customer['assemblyprod'] = $this->input->post($assemblyprod);
                $data_customer['make_id'] =  $this->input->post($flt_m);
                $data_customer['model_id'] =  $this->input->post($flt_model);
                $data_customer['qty'] = $this->input->post($qty);
                $data_customer['price'] = $this->input->post($price);
                $data_customer['description'] = $this->input->post($description);
                $this->Inquiry_model->insertRow('inquiry_products', $data_customer);
                }
                 
               // print_r($this->db->last_query());
                
              }
            }
            
            
            
            
            
            
            if($data['inqstatus']==3){
            	$datas['inq']=$id;
                $datas['ord_date']=date("m-d-Y");
                  $datas['ord_status']=1;
              $q=$this->db->Select('*')->from('orders')->where('inq',$id)->get();
              $results=$q->row();
            
              if($q->num_rows()>0){
                  $this->Inquiry_model->updateRow('orders','order_id', $results->order_id,$datas);
            	//print_r($this->db->last_query());
              }else{
            $this->Inquiry_model->insertRow('orders', $datas);
              }
            }
            $log['ref']=$data['inqrefno'];
            $log['status']=$data['inqstatus'];
             $this->Inquiry_model->insertRow('inquiry_log', $log);
            $this->Inquiry_model->updateRow('inquiry', 'inquiry_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'inquiry/inquiryTable', 'refresh');
        } else { 
          $log['ref']=$data['inqrefno'];
            $log['status']=$data['inqstatus'];
            $this->Inquiry_model->insertRow('inquiry_log', $log);
            unset($data['inquiry_id']);
              
             for($i=1;$i<=$number;$i++){                  
               $products = 'products'.$i;
               $assemblyprod = 'assemblyprod'.$i;
               $qty = 'qty'.$i;
               $price = 'price'.$i;
               $description = 'description'.$i;
               unset($data[$products]);
               unset($data[$assemblyprod]);
               unset($data[$qty]);
               unset($data[$description]);
               unset($data[$price]);
               $fl_make = 'make'.$i;
               $fl_model = 'model'.$i;
               unset($data[$fl_make]);
               unset($data[$fl_model]);
            }
            
            for($i=1;$i<=$number2;$i++){
                $person_name = 'a_status'.$i;
                $person_email = 'a_date'.$i;
                $person_phone = 'a_remark'.$i;
                 unset($data[$person_phone]);
                unset($data[$person_email]);
                unset($data[$person_name]);
            }
            
            for($i=1;$i<=$number_flt;$i++){
                $flt_potential = 'fl_remark'.$i;
                $flt_voyage = 'fl_date'.$i;
                $flt_user = 'user_id'.$i;
                unset($data[$flt_user]);
                unset($data[$flt_potential]);
                unset($data[$flt_voyage]);
            }
            for($i=1;$i<=$number_photo;$i++){
                $flt_type = 'media'.$i;
                unset($data[$flt_type]);
                
            }

            if ( $this->upload->do_upload('catalog_scan'))
                {
                $uplddata = array('upload_data' => $this->upload->data());
                $data['catalog_scan'] =  $uplddata['upload_data']['file_name'];
                }else{
                    $data['catalog_scan'] = '';
                }
                
                if ( $this->upload->do_upload('catalog_scan2'))
                {
                $uplddata = array('upload_data' => $this->upload->data());
                $data['catalog_scan2'] =  $uplddata['upload_data']['file_name'];
                }else{
                    $data['catalog_scan2'] = '';
                }
                
            if ( $this->upload->do_upload('technical_data'))
                {
                $uplddata = array('upload_data' => $this->upload->data());
                $data['technical_data'] =  $uplddata['upload_data']['file_name'];
                }else{
                    $data['technical_data'] = '';
                }
                if ( $this->upload->do_upload('technical_data2'))
                {
                $uplddata = array('upload_data' => $this->upload->data());
                $data['technical_data2'] =  $uplddata['upload_data']['file_name'];
                }else{
                    $data['technical_data2'] = '';
                }
                
                
            $id= $this->Inquiry_model->insertRow('inquiry', $data);

       // print_r($this->db->last_query());
            
            if($number2 > 0)  
                {
                    
                for($i=1;$i<=$number2;$i++){
                    $a_status = 'a_status'.$i;
                    $a_date = 'a_date'.$i;
                    $a_remark = 'a_remark'.$i;
                    unset($data[$a_status]);
                    unset($data[$a_date]);
                    unset($data[$a_remark]);
                    if($this->input->post($a_status)){
                    $data_customer['a_status'] = $this->input->post($a_status);
                    $data_customer['a_date'] = $this->input->post($a_date);
                    $data_customer['a_remark'] = $this->input->post($a_remark);
                    $data_customer['inquiry_id'] = $id;

                      $this->Inquiry_model->insertRow('inquiry_action_status', $data_customer);
                     }
                }
            }
            
            if($number_flt > 0)  
                {
                    
                for($i=1;$i<=$number_flt;$i++){
                    
                    $fl_remark = 'fl_remark'.$i;
                    $fl_date = 'fl_date'.$i;
                    $fl_user = 'user_id'.$i;
                    unset($data[$fl_remark]);
                    unset($data[$fl_date]);
                    unset($data[$fl_user]);
                    if($this->input->post($fl_remark)){
                    
                    $data_customer3['fl_remark'] = $this->input->post($fl_remark);
                    $data_customer3['fl_date'] = $this->input->post($fl_date);
                    $data_customer3['user_id'] = $this->input->post($fl_user);
                    $data_customer3['inquiry_id'] = $id;

                      $this->Inquiry_model->insertRow('inquiry_follows', $data_customer3);
                     }
                }
            }
            if($number_photo > 0) {
            for ($i=1; $i <=$number_photo ; $i++) {
                if ( $this->upload->do_upload('media'.$i))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data_m['image'] =  $uplddata['upload_data']['file_name'];
                    $data_m['inquiry_id'] = $id;
                    $this->Inquiry_model->insertRow('inquiry_photos', $data_m);

                }
            }}
         
            if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    $data_customer=array();
                   $products = 'products'.$i;
                   $assemblyprod = 'assemblyprod'.$i;
                    $qty = 'qty'.$i;
                     $description = 'description'.$i;
               $price = 'price'.$i;
                unset($data[$products]);
                unset($data[$assemblyprod]);
                unset($data[$qty]);
                unset($data[$price]);
                unset($data[$description]);
                $fl_make = 'make'.$i;
                $fl_model = 'model'.$i;
                unset($data[$fl_make]);
                unset($data[$fl_model]);
                $data_customer['inq_id'] = $id;
                if($this->input->post($products) ){
                   
                $data_customer['products'] = $this->input->post($products);
                 $data_customer['qty'] = $this->input->post($qty);
                 $data_customer['price'] = $this->input->post($price);
                 $data_customer['description'] = $this->input->post($description);
                 $data_customer['make_id'] =  $this->input->post($fl_make);
                 $data_customer['model_id'] =  $this->input->post($fl_model);
                $this->Inquiry_model->insertRow('inquiry_products', $data_customer);
                }
                if( $this->input->post($assemblyprod)){
                $data_customer['assemblyprod'] = $this->input->post($assemblyprod);
                $data_customer['qty'] = $this->input->post($qty);
                $data_customer['price'] = $this->input->post($price);
                $data_customer['description'] = $this->input->post($description);
                $data_customer['make_id'] =  $this->input->post($fl_make);
                $data_customer['model_id'] =  $this->input->post($fl_model);
                $this->Inquiry_model->insertRow('inquiry_products', $data_customer);
                }
                 
                   
               
                
               // print_r($this->db->last_query());
                
              }
              
            }
            
            //var_dump($data_customer); die;
            
            
               // exit();
				redirect( base_url().'inquiry/inquiryTable', 'refresh');	
        }
    }


    public function edit(){

        $data = $this->input->post();
        $number = $data['number'];
        // echo "<pre>";print_r($data);exit();
        for($i=1;$i<=$number;$i++){

            if ($this->input->post('item_name'.$i) !='' ) {
                if ($this->input->post('row_id'.$i) !='' ) {
                    $datau['item_name']=$this->input->post('item_name'.$i);
                    $datau['uom']=$this->input->post('new_uom'.$i);
                    $datau['quantity']=$this->input->post('quantity'.$i);
                    $datau['client_id']=$data['client_id'];

                    $this->Inquiry_model->updateRow('inquiry', 'inquiry_id', $this->input->post('row_id'.$i) , $datau);
                }else{

                    $datain['item_name']=$this->input->post('item_name'.$i);
                    $datain['uom']=$this->input->post('new_uom'.$i);
                    $datain['quantity']=$this->input->post('quantity'.$i);
                    $datain['client_id']=$data['client_id'];
                    $datain['inquiry_number']=$data['inquiry_number'];

                    $this->Inquiry_model->insertRow('inquiry', $datain);

                }
            }

        }

        redirect( base_url().'inquiry/inquiryTable', 'refresh');    

    }



    /**
     * This function is used to delete users
     * @return Void
     */
   public function delete($id){
        is_login(); 
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->Inquiry_model->delete($id); 
        }
       redirect(base_url().'inquiry/inquiryTable', 'refresh');
    }

     public function get_parent_cats(){


        $mainid = $this->input->post('mainid');
         $iddata = $this->input->post('iddata');

         // $query = $this->db->select('*')->from('bookings')->where('book_id',$iddata)->get();
         // $resdata = $query->row();

         // $val = $resdata->tot_amnt;
         // $pen = $resdata->tot_amnt-$resdata->paid_amnt;
         if($iddata == 0){
          $name="Main Category";
         }else{
         $query = $this->db->select('*')->from('category')->where('order_id',$iddata)->get();
          $result = $query->row();

         $name=$result->category_name;
         $iddata= $result->parent_id;


          while($iddata > 0){
            $query2 = $this->db->select('*')->from('category')->where('order_id',$iddata)->get();
            $result2 = $query2->row();
            $name = $result2->category_name." => ".$name;
            $iddata = $result2->parent_id;
          }
        }
        // return $name;




         $findata = array(
            'mainid'=>$mainid,
            'data'=>$name
         );
         echo json_encode($findata);


    }

    // public function getItems(){
    //     $id = $this->input->post('id');
    //     // $data = $this->Inquiry_model->get_data_by('inventory',$id,'prod_id','group by item_name');

    //     $query = $this->db->select('*')->from('inventory')->where('prod_id',$id)->group_by('item_name')->get();
    //     $data = $query->result();
    //     echo json_encode($data); 

    // }


     public function getUOM(){
        $item_name = $this->input->post('item_name');
        // $data = $this->Inquiry_model->get_data_by('inventory',$item_name,'item_name');

        $query = $this->db->select('*')->from('inventory')->where('item_name',$item_name)->get();
        $data = $query->result();

        echo json_encode($data); 

    }

     public function getUnits(){


        $id = $this->input->post('id');
         // $productData = getDataByid('product',$id,'product_id');
         // $cat =$productData->category_id;
        
         $query = $this->db->select('*')->from('inventory')->where('item_name', $id)->group_by('item_name')->get();
          $result = $query->row();


        $primary_unit_data = getDataByid('unit',$result->punitid,'unit_id');
        $secondary_unit_data = getDataByid('unit',$result->sunitid,'unit_id');

        $primary_unit_name = $primary_unit_data->unit_name;
        $secondary_unit_name = $secondary_unit_data->unit_name;

         $findata = array(
            'primary_unit_name' => $primary_unit_name,
            'secondary_unit_name' => $secondary_unit_name
         );


         // echo '<tr><td>'.$primary_unit.'</td><td>'.$secondary_unit.' - '.$secondary_unit2.'</td></tr>';
         echo json_encode($findata);
         exit();

    }
    

    // public function Confirm($id){
    //     // echo "<pre>";

    //     $data = getDataByid('inquiry',$id,'inquiry_id');

    //     $inquiry_id = $data->inquiry_id;
    //     unset($data->inquiry_id);
    //      // print_r($data);


    //     // exit();

    //         $gainon=$data->is_gain;
    //         $loss=$data->is_loss;


    //         // echo "<pre>";   
    //         // print_r($data);
    //         unset($data->gain);
    //         unset($data->loss);

    //         // unset($data->is_gain);
    //         // unset($data->is_loss);

            
    //         $quantity = $data->quantity;

    //          // $newUOM = $data->uom'] - $data->new_uom'];
    //         // $uomdata = getDataByid('inventory',$data->inventory_id,'inventory_id');
    //         $query2 = $this->db->select('*')->from('inventory')->where('item_name',$data->item_name)->where('uom1', $data->selected_uom)->get();
    //         $uomdata = $query2->row();


    //         $data_invPcs1['on_hold'] = $quantity;
    //             $this->Inquiry_model->updateRow('inventory', 'inventory_id', $data->inventory_id, $data_invPcs1);

    //         $newQty = $uomdata->pcs - $data->quantity;

    //         $data->new_uom = $data->uom;
    //         $data->uom = $data->selected_uom;


    //         // print_r($data);
    //         // exit();
    //         if ($data->split==1) {          
    //           unset($data->split);


    //           // if($data['uom'] >= $data['new_uom']){


    //               $remainder = $data->uom % $data->new_uom; 
    //             // echo "<br>";
    //               $quotient = ($data->uom - $remainder) / $data->new_uom;
    //             // echo "<br>";
    //              $splitpcs = ($data->quantity) / $quotient;
    //             // echo "<br>";

    //              $newsplitQauntity = $uomdata->pcs - $splitpcs;


    //             $data_invPcs['pcs'] = $newsplitQauntity;
    //             $data_invPcs['total'] = $newsplitQauntity * $data->uom;
    //             $data_invPcs['on_hold'] = 0;
    //             // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $data->inventory_id, $data_invPcs);
    //             // echo "<br>";
    //              $pcsforRemainder = $uomdata->pcs - $newsplitQauntity;
    //              // echo "<br>";

    //             if($remainder > 0){


    //               $query2 = $this->db->select('*')->from('inventory')->where('item_name',$data->item_name)->where('uom1',$remainder)->get();
    //               $result2 = $query2->row();

    //               if($query2->num_rows()>0){
    //                 // echo $result2->pcs;

    //                 $data_invRm['pcs'] = $pcsforRemainder + $result2->pcs;
    //                 $data_invRm['total'] = ($pcsforRemainder + $result2->pcs) * $remainder;


    //               // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $result2->inventory_id, $data_invRm);

    //               }
    //               else{
    //                  $data_invNew1 = array(
    //                     // 'prod_id'=>$data->product_id,
    //                     'item_name'=>$data->item_name,
    //                     'uom1'=>$remainder,
    //                     'unitid'=>$uomdata->unitid,
    //                     'pcs'=>$pcsforRemainder,
    //                     'total'=>($pcsforRemainder*$remainder)
                    
    //                 );
    //                 // $this->Inquiry_model->insertRow('inventory', $data_invNew1);
    //                }
    //             }


    //             // exit();

    //         unset($data->uom);
    //         $data->uom=$data->new_uom;
    //         unset($data->new_uom);
    //         // print_r($data);exit();

    //         unset($data->split);
    //         $this->Inquiry_model->insertRow('orders', $data);

            



    //         }else{



    //         $data_invPcs['pcs'] = $newQty;
    //         $data_invPcs['total'] = $newQty * $data->uom;
    //         $data_invPcs['on_hold'] = 0;
    //         // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $data->inventory_id, $data_invPcs);


    //           unset($data->split);
              
    //         if($data->uom >= $data->new_uom){


    //             $newUOM = $data->uom - $data->new_uom;
    //             if ($loss!=1) {
                  
                 
    //             // exit();

    //               $query2 = $this->db->select('*')->from('inventory')->where('item_name',$data->item_name)->where('uom1',$newUOM)->get();
    //               $result2 = $query2->row();
    //               if($query2->num_rows()>0){
    //                 // echo $result2->pcs;

    //                 $data_invRm['pcs'] = $data->quantity + $result2->pcs;
    //                 $data_invRm['total'] = ($data->quantity + $result2->pcs) * $newUOM;


    //                // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $result2->inventory_id, $data_invRm);

    //               }
    //               else{
    //                 $data_invNew = array(
    //                     // 'prod_id'=>$data->product_id,
    //                     'item_name'=>$data->item_name,
    //                     'uom1'=>$newUOM,
    //                     'unitid'=>$uomdata->unitid,
    //                     'pcs'=>$data->quantity,
    //                     'total'=>($data->quantity*$newUOM)
    //                 );
    //                 // $this->Inquiry_model->insertRow('inventory', $data_invNew);
    //               }

    //               unset($data->uom);
    //               $data->uom=$data->new_uom;
    //               unset($data->new_uom);
              
    //               $this->Inquiry_model->insertRow('orders', $data);

    //              }else{

    //               unset($data->uom);
    //               $data->uom=$data->new_uom;
    //               unset($data->new_uom);
    //               $data->loss=$newUOM;
              
    //               $this->Inquiry_model->insertRow('orders', $data);


    //              }

    //         }else{



    //                 $gain = $data->new_uom - $data->uom;

    //                if($gainon==1){
    //                 $data->gain=$gain;
    //                }
    //                // exit();
    //                       $newUOM = $data->uom;


    //                    unset($data->uom);
    //                   $data->uom=$data->new_uom;
    //                   unset($data->new_uom);
                      
                      
    //                   $this->Inquiry_model->insertRow('orders', $data);



    //             }




    //       }

    //       $this->Inquiry_model->delete($inquiry_id);

    //       $this->session->set_flashdata('messagePr', 'Order added successfully..');
    //       redirect( base_url().'inquiry/inquiryTable', 'refresh');

    //       // exit();




    // }

    public function getItems(){
        $id = $this->input->post('id');
        // $data = $this->Order_model->get_data_by('inventory',$id,'prod_id','group by item_name');

        $query = $this->db->select('*')->from('inventory')->where('category_id',$id)->group_by('item_name')->get();
        $data = $query->result();
        echo json_encode($data); 

    }

    public function getprice(){
        $id=$this->input->post('val1');
        $query = $this->db->select('*')->from('products')->where('product_id',$id)->get();
        $result=$query->row();
        echo $result->price;
        exit();
    }
     public function getpriceass(){
        $id=$this->input->post('val1');
        $query = $this->db->select('*')->from('assemble')->where('assemble_id',$id)->get();
        $result=$query->row();
        echo $result->price;
        exit();
    }



    public function confirm_order(){
         $data = $this->input->post();
         $number = $data['number'];
        
         unset($data['submit']);
         unset($data['number']);

          for($i=1;$i<=$number;$i++){
            
                     $item_name = 'item_name'.$i;
                     $split = 'split'.$i;
                     $uom = 'uom'.$i;
                     $new_uom = 'new_uom'.$i;
                    $gain = 'gain'.$i;
                    $loss = 'loss'.$i;
                    $quantity = 'quantity'.$i;                   
              
                     
                    unset($data[$item_name]);
                    unset($data[$split]);
                      unset($data[$uom]);
                    unset($data[$new_uom]);
                    unset($data[$gain]);

                    unset($data[$loss]);
                    unset($data[$quantity]);

                 }

        $row2 = $this->db->query('SELECT MAX(order_id) AS `maxid` FROM `orders`')->row();
        if ($row2->maxid !='') {
            $maxid2 = $row2->maxid + 1; 
        }else{
            $maxid2 = 1;
        }

        $this->Inquiry_model->deleteRow('inquiry', 'inquiry_number', $data['inquiry_number']);
        unset($data['inquiry_number']);
        
        for ($i=1; $i <=$number ; $i++) { 
            

            $gainon=$this->input->post('gain'.$i);
            $loss=$this->input->post('loss'.$i);

            
            $quantity = $this->input->post('quantity'.$i);

            $query2 = $this->db->select('*')->from('inventory')->where('item_name',$this->input->post('item_name'.$i))->where('uom1', $this->input->post('uom'.$i))->get();
                $uomdata = $query2->row();


            $data_invPcs1['on_hold'] = $quantity;
                $this->Inquiry_model->updateRow('inventory', 'inventory_id', $uomdata->inventory_id, $data_invPcs1);

            $newQty = $uomdata->pcs - $quantity;


            $data['inventory_id'] = $uomdata->inventory_id;
            if ($this->input->post('split'.$i)==1) {          
              
                  $remainder = $this->input->post('uom'.$i) % $this->input->post('new_uom'.$i); 
                
                  $quotient = ($this->input->post('uom'.$i) - $remainder) / $this->input->post('new_uom'.$i);
                
                 $splitpcs = ($quantity) / $quotient;
              

                 $newsplitQauntity = $uomdata->pcs - $splitpcs;


                $data_invPcs['pcs'] = $newsplitQauntity;
                $data_invPcs['total'] = $newsplitQauntity * $data->uom;
                $data_invPcs['on_hold'] = 0;
                
                 $pcsforRemainder = $uomdata->pcs - $newsplitQauntity;

                if($remainder > 0){


                  $query2 = $this->db->select('*')->from('inventory')->where('item_name',$this->input->post('item_name'.$i))->where('uom1',$remainder)->get();
                  $result2 = $query2->row();

                  if($query2->num_rows()>0){

                    $data_invRm['pcs'] = $pcsforRemainder + $result2->pcs;
                    $data_invRm['total'] = ($pcsforRemainder + $result2->pcs) * $remainder;


                  }
                  else{
                     $data_invNew1 = array(
                        // 'prod_id'=>$data->product_id,
                        'item_name'=>$this->input->post('item_name'.$i),
                        'uom1'=>$remainder,
                        'unitid'=>$uomdata->unitid,
                        'pcs'=>$pcsforRemainder,
                        'total'=>($pcsforRemainder*$remainder)
                    
                    );
                    // $this->Inquiry_model->insertRow('inventory', $data_invNew1);
                   }
                }


            unset($data->uom);
            $data['uom']=$this->input->post('new_uom'.$i);
            unset($data->new_uom);

            unset($data->split);
                $data['item_name']=$this->input->post('item_name'.$i);
                $data['split']=$this->input->post('split'.$i);
                 $data['quantity']=$this->input->post('quantity'.$i);
                 $data['order_number']=$maxid2;

            $this->Inquiry_model->insertRow('orders', $data);


            }else{

                 

            $data_invPcs['pcs'] = $newQty;
            $data_invPcs['total'] = $newQty * (int)$this->input->post('uom'.$i);


            $data_invPcs['on_hold'] = 0;
            // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $data->inventory_id, $data_invPcs);

            if($this->input->post('uom'.$i) >= $this->input->post('new_uom'.$i)){


                $newUOM = $this->input->post('uom'.$i) - $this->input->post('new_uom'.$i);

                if ($loss!=1) {
                  
                  $query2 = $this->db->select('*')->from('inventory')->where('item_name',$this->input->post('item_name'.$i))->where('uom1',$newUOM)->get();
                  $result2 = $query2->row();
                  if($query2->num_rows()>0){

                    $data_invRm['pcs'] = $quantity + $result2->pcs;
                    $data_invRm['total'] = ($quantity + $result2->pcs) * $newUOM;


                   // $this->Inquiry_model->updateRow('inventory', 'inventory_id', $result2->inventory_id, $data_invRm);

                  }
                  else{
                    $data_invNew = array(
                        'item_name'=>$this->input->post('item_name'.$i),
                        'uom1'=>$newUOM,
                        'unitid'=>$uomdata->unitid,
                        'pcs'=>$data->quantity,
                        'total'=>($data->quantity*$newUOM)
                    );
                    // $this->Inquiry_model->insertRow('inventory', $data_invNew);
                  }

                  unset($data->uom);
                  $data['uom']=$this->input->post('new_uom'.$i);
                  unset($data->new_uom);
              // $data['category_id']=$this->input->post('category_id'.$i);
                        $data['item_name']=$this->input->post('item_name'.$i);
                        $data['split']=$this->input->post('split'.$i);
                         $data['quantity']=$this->input->post('quantity'.$i);
                          // $data['new_uom']=$this->input->post('new_uom'.$i);
                         // $data['uom']=$this->input->post('new_uom'.$i);
                          $data['order_number']=$maxid2;

                  $this->Inquiry_model->insertRow('orders', $data);
                  // exit();
                 }else{

                  unset($data->uom);
                  $data['uom']=$data->new_uom;
                  unset($data->new_uom);
                  $data['loss']=$newUOM;
              // $data['category_id']=$this->input->post('category_id'.$i);
                        $data['item_name']=$this->input->post('item_name'.$i);
                        $data['split']=$this->input->post('split'.$i);
                         $data['quantity']=$this->input->post('quantity'.$i);
                         $data['uom']=$this->input->post('new_uom'.$i);
                          $data['order_number']=$maxid2;

                  $this->Inquiry_model->insertRow('orders', $data);


                 }

            }else{


                    $gain =$this->input->post('new_uom'.$i) - (int)$this->input->post('uom'.$i);

                   if($gainon==1){
                    $data['gain']=$gain;
                   }
                          $newUOM = $this->input->post('uom'.$i);


                       unset($data->uom);
                      $data['uom']=$data->new_uom;
                      unset($data->new_uom);
                      
                      // $data['category_id']=$this->input->post('category_id'.$i);
                        $data['item_name']=$this->input->post('item_name'.$i);
                        $data['split']=$this->input->post('split'.$i);
                         $data['quantity']=$this->input->post('quantity'.$i);
                          $data['uom']=$this->input->post('new_uom'.$i);
                          $data['order_number']=$maxid2;
                     
                      $this->Inquiry_model->insertRow('orders', $data);



                }




        }

    }

    redirect( base_url().'inquiry/inquiryTable', 'refresh');

    }

   
    public function checkref(){
        $tag_name = $this->input->post('ref');

        $querym = $this->db->query('SELECT * FROM `inquiry` where inqrefno="'.$tag_name.'" ');
        echo $count= $querym->num_rows();

       

    }
    
    public function get_customer_address(){
        $customer_id=$this->input->post('customer_id');
        $query = $this->db->select('*')->from('customer_regd_address')->where('customer_id',$customer_id)->get();
        $result=$query->result();
        echo json_encode($result);
        
    }

}