<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class order extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		$this->load->model('Order_model');
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
     * )This function is used for show users list
     * @return Void
     */
    public function OrderTable(){
        is_login();
	
		// var_dump($_SESSION->user_details);
        if(CheckPermission("order", "order")){
           // $data['clientData'] = $this->Order_model->get_data_by('client');
            // if($this->input->post()){
	        $data['fromData'] =$this->input->post('from_date');
                $data['toData'] =$this->input->post('to_date');
                $data['status'] =$this->input->post('status');
                $data['proData'] =$this->input->post('products');
                $data['assemblyprodData'] =$this->input->post('assemblyprod');
                $data['customerData'] =$this->input->post('customer');
                $data['make'] =$this->input->post('make');
                $data['model'] =$this->input->post('model');
                $data['payment'] =$this->input->post('payment');
            
            // }
            $this->db->select('*');
            $this->db->from('orders');
            if($data['fromData']  != '' )
            {
                $this->db->where('ord_date >=',$data['fromData']);
            }
            if($data['toData'] != ''){
                 $this->db->where('ord_date <=',$data['toData']);
            }
            if($data['status']!=""){
               $this->db->where('ord_status =',$data['status']);
            }
            if($data['proData']!=""){
                    $this->db->join('inquiry_products as i', 'i.inq_id=orders.inq')->where('i.products =',$data['proData']);
            }
            if($data['assemblyprodData']!=""){
                    $this->db->join('inquiry_products as p', 'p.inq_id=orders.inq')->where('p.assemblyprod =',$data['assemblyprodData']);
            }
            if($data['customerData']!=""){
                    $this->db->join('inquiry as q', 'q.inquiry_id=orders.inq')->where('q.exist_cust =',$data['customerData']);
            }
            if($data['make']!=""){
                    $this->db->join('inquiry_products as p1', 'p1.inq_id=orders.inq')->where('p1.make_id =',$data['make']);
            }
            if($data['model']!=""){
                    $this->db->join('inquiry_products as p2', 'p2.inq_id=orders.inq')->where('p2.model_id =',$data['model']);
            }
            if($data['payment']!=""){
                    $this->db->where('pending_amount >=','1');
            }
             

            $query = $this->db->get();
            //print_r($this->db->last_query());
            $data['ordersData']= $query->result();
            
            $data['productsData'] = $this->Order_model->get_data_by('products');  
            $data['assembleData'] = $this->Order_model->get_data_by('assemble'); 
            $data['userdatas'] = $this->Order_model->get_data_by('customers');
            $data['makes'] = $this->Order_model->get_data_by('make','','');
            $data['models'] = $this->Order_model->get_data_by('model','','');
            
                $this->load->view('include/header');
                $this->load->view('order_table',$data);                
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
        $from =  $this->uri->segment(3);
        $to =  $this->uri->segment(4);
        $status =  $this->uri->segment(6);
        $client =  $this->uri->segment(5);
	    $table = 'orders';
    	$primaryKey = 'order_id';
    	$columns = array(
           array( 'db' => 'order_id',   'dt' => 0 ),
		   array( 'db' => 'inq', 'dt' => 1 ),	 
		  // array( 'db' => '', 'dt' => 2 ),
		   // array('db'=> 'blank_used','dt'=> 3),
		  
		   array( 'db' => 'order_id', 'dt' => 2)
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
    		$from='orders';
    		// $tables[0]['name']='category';
    		// $tables[0]['col1']='order.category';
    		// $tables[0]['col2']='category.id';
	       $where = ' where order_id != "" ';
	       if($from != '' )
            {
                $where .= " and order_date >= '".$from."' ";
            }
            if($to != ''){
                $where .= " and order_date <= '".$to."' ";
            }
            if($client!=""){
                $where .= " and client = '$client' ";
            }
            if($status!=""){
                if($status=="Pending"){
                    $where .= " and order_status != 'Delivery' ";
                }else{
                    $where .= " and order_status == 'Delivery' ";
                }
            }
	       $output_arr = SSP::innerJoin( $_GET, $sql_details, $from,$tables, $primaryKey, $columns, $where, $col_name,$order,$order_type);
		  // $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
           // $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$where);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			// if(CheckPermission('contacts', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonServiceprovider mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
			// }else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'id','id');
				// if($user_id==$this->user_id){
			if(CheckPermission('order_edit',"order")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="orderModalButtonadd mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';}
				// }
			// }
			
			// if(CheckPermission('contact', "order")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonorder1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-eye" data-id=""></i></a>';
			//}else if(CheckPermission('order', "order")!=true){
			//	$user_id =getRowByTableColomId($table,$id,'order_id','order_id');
			//	if($user_id==$this->user_id){
			
			
				// }
			// }
			
           


			// if(CheckPermission('serviceprovider', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'serviceprovider\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
			// else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				// if($user_id==$this->user_id){
             if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){
			 $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'order\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
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
            //echo "ASds";
            $data['orderData'] = getDataByid('orders',$this->input->post('id'),'order_id');
            //$data['order_follow_up'] = $this->Order_model->get_data_by('order_products',$this->input->post('id'),'batch_no');
            $data['categoryData'] = $this->Order_model->get_data_by('categories');   
            $data['productsData'] = $this->Order_model->get_data_by('products');  
           $data['assembleData'] = $this->Order_model->get_data_by('assemble'); 
           $data['rawData'] = $this->Order_model->get_data_by('raw_material');  
           $data['userdatas'] = $this->Order_model->get_data_by('customers');
           $data['supplierdata'] = $this->Order_model->get_data_by('suppliers');
           
        echo $this->load->view('new_add_order', $data, true);
        } else { 
           // $data['order_follow_up'] = $this->Order_model->get_data_by('order_products',$this->input->post('id'),'batch_no');
            $data['orderData'] = getDataByid('orders',$this->input->post('id'),'order_id'); 
             $data['productsData'] = $this->Order_model->get_data_by('products');  
			$data['categoryData'] = $this->Order_model->get_data_by('categories');
            $data['assembleData'] = $this->Order_model->get_data_by('assemble');
            $data['rawData'] = $this->Order_model->get_data_by('raw_material'); 
            $data['userdatas'] = $this->Order_model->get_data_by('customers'); 
            $data['supplierdata'] = $this->Order_model->get_data_by('suppliers');
            echo $this->load->view('add_order', $data, true);
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
       // $number = $this->input->post('number');
		 // var_dump($data);
		 // exit;
		unset($data['submit']);
         
		 
		 if($this->input->post('order_id')) {

            $id = $this->input->post('order_id');
            $quotation_id = $this->input->post('quotation_id');
			unset($data['order_id']);
                        unset($data['quotation_id']);

        }
        // print_r($_POST);
        // exit();
        
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'order';
            }
        } else {
            $redirect = 'login';
        }
		
		
		
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
			}
            unset($data['ref']);
           
            $this->Order_model->updateRow('orders', 'order_id', $id, $data);
            
            $status = $this->input->post('ord_status');
            
            if($status == 4 || $status == '4'){

                $quotfollow=$this->db->Select('*')->from('quotaion_products')->where('quot_id',$quotation_id)->get();
                $quotfollow=$quotfollow->result();
                
                foreach ($quotfollow as $key => $value) {
                    if($value->product != '0' || $value->product != 0){
                        $produc_id = $value->product;
                        $produc_key = 'product';
                        $quantity = $this->db->Select('pieces')->from('inventory')->where('product',$value->product)->get();
                        $quantity=$quantity->result(); 
                    }else{
                        $produc_id = $value->product;
                        $produc_key = 'assembleproduct';
                        $quantity = $this->db->Select('pieces')->from('inventory')->where('product',$value->product)->get();
                        $quantity=$quantity->result();
                    }
                                       
                    //var_dump($value->product); die;
                    $update_data = array('pieces' => $quantity[0]->pieces - $value->quot_qty);                  
                    $this->Order_model->updateRow('inventory', $produc_key, $produc_id, $update_data);
                }
            }
                
            
          // print_r($this->db->last_query());
          // exit();
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'order/orderTable', 'refresh');
        } else { 
               
					  $total_weight=0;
        unset($data['order_id']);
                $prodarray = array();
                 $assemble_prodarray=array();
        for($i=1;$i<=$number;$i++){
                      
                    $part_nm = 'part_nm'.$i;
                    $assemble_prod = 'assemble_prod'.$i;
                    
                    $prod_pcs = 'prod_pcs'.$i;
                   
                    unset($data[$part_nm]);
                    unset($data[$assemble_prod]);
                    
                    unset($data[$prod_pcs]);
                  
                   //$total_weight =$this->input->post($product_wght)+$total_weight; 
       //             $querie=$this->db->select('*')->from('raw_material')->where('rm_id',$this->input->post($raw_name))->get();
       //             $result=$querie->row();
       //             $rm_wght['inventory']= $result->inventory-$this->input->post($product_wght);

       // $this->Order_model->updateRow('raw_material', 'rm_id', $result->rm_id, $rm_wght);
       
              if($this->input->post($part_nm)!=''){
                        if (array_key_exists($this->input->post($part_nm),$prodarray)){
                           $pcs = $prodarray[$this->input->post($part_nm)];
                           $prodarray[$this->input->post($part_nm)] = $pcs + $this->input->post($prod_pcs);
                        }else{
                        $prodarray[$this->input->post($part_nm)] = $this->input->post($prod_pcs);
                        }
                    }


                     if($this->input->post($assemble_prod)!=''){
                 if (array_key_exists($this->input->post($assemble_prod),$assemble_prodarray)){
                           $pcs = $assemble_prodarray[$this->input->post($assemble_prod)];
                           $assemble_prodarray[$this->input->post($assemble_prod)] = $pcs + $this->input->post($prod_pcs);
                        }else{
                        $assemble_prodarray[$this->input->post($assemble_prod)] = $this->input->post($prod_pcs);
                        }
                    }
                    
                }
                       
           //      if($prodarray!=''){
           //          $hold_pcs=0;
           //     foreach ($prodarray as $key => $value) {
           //      $pcs_hold['part_names']=$key;
           //        $pcs_hold['hold_pcs']=$value;
           //          $pcs_hold['part_type']=1;
           //        $query= $this->db->select('*')->from('inventory')->where('part_type',1)->where('part_names',$key)->get();
           //         $result=$query->row();
           //        if($query->num_rows()==0){
           //          $this->Order_model->insertRow('inventory', $pcs_hold);    
           //        }
           //        else{
           //            $hold_pcs=$value + $result->hold_pcs;
           //             $pcs_hold1['hold_pcs']=$hold_pcs;
           //      $this->Order_model->updateRow('inventory', 'part_names', $key, $pcs_hold1);
              
           //        }
           //     }
              
           // }
           
          // if($assemble_prodarray!=''){
           //          $hold_pcs1=0;
           //     foreach ($assemble_prodarray as $key => $value) {
           //      $pcs_hold['part_names']=$key;
           //        $pcs_hold['hold_pcs']=$value;
           //          $pcs_hold['part_type']=2;
           //        $query= $this->db->select('*')->from('inventory')->where('part_type',2)->where('part_names',$key)->get();
                 
           //        $result=$query->row();
           //        if($query->num_rows()==0){
           //          $this->Order_model->insertRow('inventory', $pcs_hold);
           //        }
           //        else{
           //          $hold_pcs1=$value + $result->hold_pcs;
           //           $pcs_hold1['hold_pcs']=$hold_pcs;
           //      $this->Order_model->updateRow('inventory', 'part_names', $key, $pcs_hold1);
               
           //        }
           //     }
           // }
                
       
                  $this->db->select_max('order_id');
                    $this->db->from('orders');
                    $query = $this->db->get();
                    $r=$query->result();
                   
                    $data['gadget_id']=$r[0]->order_id+1;
                // $data['order_total_weight']=$total_weight;
                $id = $this->Order_model->insertRow('orders', $data); 
              
              if($number > 0)  
                {  
        
                for($i=1;$i<=$number;$i++){
                    $part_nm = 'part_nm'.$i;
                    $assemble_prod = 'assemble_prod'.$i;
                    // $raw_name = 'raw_name'.$i;
                    // $product_wght = 'product_wght'.$i;
                    // $unit1 = 'unit1'.$i;
                    $prod_pcs = 'prod_pcs'.$i;
            
                if($this->input->post($prod_pcs)!=''){
                        // echo "2343 pro FOR";
       
                $data_customer['part_nm'] = $this->input->post($part_nm);
                $data_customer['assemble_prod'] = $this->input->post($assemble_prod);
                //  $data_customer['raw_name'] = $this->input->post($raw_name);
                // $data_customer['product_wght'] = $this->input->post($product_wght);
                //  $data_customer['unit1'] = $this->input->post($unit1);
                $data_customer['prod_pcs'] = $this->input->post($prod_pcs);
                    
                    
                
                if($i==1){
                    $data_customer['batch_no'] = $id;
                }
                
              $this->Order_model->insertRow('order_products', $data_customer);
               } 
                // print_r($this->db->last_query());
            }   
                $data_customer['part_nm'] = $this->input->post('part_nm');
                $data_customer['assemble_prod'] = $this->input->post('assemble_prod');
                // $data_customer['raw_name'] = $this->input->post('raw_name');
                // $data_customer['product_wght'] = $this->input->post('product_wght');
                // $data_customer['unit1'] = $this->input->post('unit1');
                $data_customer['prod_pcs'] = $this->input->post('prod_pcs');
              
                $data_customer['batch_no'] = $id;
                }   
                    // print_r($this->db->last_query());
                    // exit();
					redirect( base_url().'order/orderTable', 'refresh');	
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
            $this->Order_model->delete($id); 
        }
       redirect(base_url().'order/orderTable', 'refresh');
    }


    public function get_pcs(){
      $id=$this->input->post('id');
       $prodweight=$this->input->post('prodweight');
        $unit=$this->input->post('unit');
       $data = getDataByid('products',$id,'product_id');

       $pcs= $prodweight /  $data->weight_per_piece ;
            if($data->unit=='g'){
              echo floor($pcs)*1000;
            }else{
              echo floor($pcs);  
            }
                }
     

    public function get_pcs_ass(){
      $id=$this->input->post('id');
       $prodweight=$this->input->post('prodweight');

       $data = getDataByid('assemble',$id,'assemble_id');

       $pcs= $prodweight /  $data->total_weight ;
    //  echo round($pcs,0);
      if($unit=='g'){
              echo floor($pcs)*1000;
            }else{
              echo floor($pcs);  
            }
                
            }
    public function get_wght(){
      $id=$this->input->post('id');
       $prodweight=$this->input->post('prodweight');
        $unit=$this->input->post('unit');
       $data = getDataByid('products',$id,'product_id');

       $pcs= $prodweight  *  $data->weight_per_piece ;


            if($unit=='g'){
              echo round($pcs,0)*1000;
            }else{
              echo round($pcs,0);  
            }
                }



    public function get_wght_ass(){
      $id=$this->input->post('id');
       $prodweight=$this->input->post('prodweight');
        $unit=$this->input->post('unit');
       $data = getDataByid('assemble',$id,'assemble_id');

       $pcs= $prodweight  *  $data->total_weight ;


        if($unit=='g'){
          echo round($pcs,0)*1000;
        }else{
          echo round($pcs,0);  
        }
    }

    public function get_blank_used(){
        $id=$this->input->post('id');
        $blank= $this->input->post('blank_scrap');
        $data=getDataByid('orders',$id,'order_id');
        echo $blank_used =$data->order_total_weight - $blank;

    }
    public function get_pack_used(){
        $id=$this->input->post('id');
        $blank= $this->input->post('pack_scrap');
        $data=getDataByid('orders',$id,'order_id');
        echo $blank_used =$data->plate_used - $blank;

    }
    public function get_plat_used(){
        $id=$this->input->post('id');
        $blank= $this->input->post('plate_scrap');
        $data=getDataByid('orders',$id,'order_id');
        echo $blank_used =$data->blank_used - $blank;

    }
    public function findinventory(){
        $id=$this->input->post('id');
         $status= $this->input->post('status');
         $product= $this->input->post('product');
        $assembprod= $this->input->post('assembprod');
        if($product!=''){
            $part_type=1;
            $prodct=$product;
        }else{
            $part_type=2;
            $prodct=$assembprod;
        }
        $query=$this->db->select('*')->from('inventory')->where('part_type',$part_type)->where('part_names',$prodct)->get();
        $result=$query->row();
        if($status==2){
            echo $result->blanking_pieces;
        }else if($status==3){
            echo $result->plating_pieces;
        }else if($status==4){
            echo $result->packing_pieces;
        }else if($status==5){
            echo $result->finished_pieces;
        }

        
        //print_r($this->db->last_query());
        exit();
    }
    public function addblanktostatus(){
        $data['order_no']=$this->input->post('id');
        $data['ord_products']= $this->input->post('products');
        $data['ord_ass_products']= $this->input->post('assembprod');
        $data['ord_description']= $this->input->post('descrip');
        $data['ord_date']= $this->input->post('date');
        $data['ord_pcs']= $this->input->post('pcs');
        $data['order_stat']= $this->input->post('status')+1;
       
        $this->Order_model->insertRow('order_status',$data);
        print_r($this->db->last_query());
        
        }
 
     
    public function senttostatus(){
        

        $data['ord_batch_no']=$this->input->post('id');
        $data['ord_prodnam']= $this->input->post('product');
       
        $data['ord_asspronam']= $this->input->post('assembprod');

        $data['date']= $this->input->post('date');
        $data['pcs']= $this->input->post('pcs');
        $data['order_status']= $this->input->post('status');
        $data['comments']="sent to Plating";
        // $this->Order_model->insertRow('order_status',$data);

        if($data['ord_prodnam']==''){
          // echo "string1";exit();
         echo $this->Order_model->getremassprodpcs($data['ord_batch_no'],$data['ord_asspronam']);
         // $query=$this->db->select('*')->from('order_products')->where('batch_no',$data['ord_batch_no'])->where('assemble_prod',$data['ord_asspronam'])->get();
        // $res = $query->row();
        // print_r($this->db->last_query());
        // echo $res->prod_pcs;
        }else if($data['ord_asspronam']==''){
          echo $this->Order_model->getremprodpcs($data['ord_batch_no'],$data['ord_prodnam']);
           // echo "string2";exit();
          // $query=$this->db->select('*')->from('order_products')->where('batch_no',$data['ord_batch_no'])->where('part_nm',$data['ord_prodnam'])->get();
    
        // $res = $query->row();
        // print_r($this->db->last_query());
        // echo $res->prod_pcs;
            
        }
        exit();
    }
    
    public function download_productData($id){
        $quotfollow=$this->db->Select('*')->from('quotaion_products')->where('quot_id',$id)->get();
        $quotfollow=$quotfollow->result();
        
        $ad=$this->db->Select('inq')->from('orders')->where('quotation',$id)->get();
        $inq=$ad->result();
        $inquery_id = $inq[0]->inq;
        //print_r($id); die; 
        // file name
        $filename = 'Product_'.date('dmY').'.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
 
        // file creation
        $file = fopen('php://output', 'w');
 
        $header = array("Products", "Make", "Model", "Quantity");
        fputcsv($file, $header);
        $product_name = "";
        foreach ($quotfollow as $key => $value) {
            
            if($value->product!=0){
                 
                    $product_name = $this->Order_model->getproductName($value->product); 
                    
                    }elseif ($value->assem_prof!=0){
                    
                      $product_name= $this->Order_model->getassproductName($value->assem_prof);
                      
                    }else{
                         $product_name= $value->desc;
                      }
            
            fputcsv($file,array($product_name,
                $line->make_name,
                $line->model_name,
                $value->quot_qty));
        }
 
        fclose($file);
        exit;  
    }

}