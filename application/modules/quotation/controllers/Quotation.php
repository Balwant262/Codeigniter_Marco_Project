<?php
//error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed ');
class Quotation extends CI_Controller {

    function __construct() { 
        parent::__construct(); 
		$this->load->model('Quotation_model');
          $this->load->library('pdf');

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
    public function quotationTable(){
        is_login();

		
        if(CheckPermission("quotation", "quotation")){
		
            $this->load->view('include/header');
            $this->load->view('quotation_table');                
            $this->load->view('include/footer');            
        } else {
			
           $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function dataTable2 (){
        is_login();
        $table = 'terms';
        $primaryKey = 'terms_id';
        $columns = array(
           array( 'db' => 'terms_id', 'dt' => 0 ),
		    // array( 'db' => 'id', 'dt' => 1 ),
           array( 'db' => 'terms_descr', 'dt' => 1 ),
           array( 'db' => 'terms_id', 'dt' => 2 )
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns);
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
            if(CheckPermission('products',"products")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="termsModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            }else if(CheckPermission('products_edit', "products") && (CheckPermission('products', "products")!=true)){
                $user_id =getRowByTableColomId($table,$id,'id','id');
                if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="termsModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
                }
            }
            
            
            
            if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){
            if(CheckPermission('products', "products")){
                
                
           // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'terms\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            }
            else if(CheckPermission('products_view', "products") && (CheckPermission('products', "products")!=true)){
                $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
                if($user_id==$this->user_id){
           // $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'terms\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
                }
            }
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
            }
        }
        echo json_encode($output_arr);
    }
    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
     public function dataTable (){
        is_login();
	    $table = 'quotation';
    	$primaryKey = 'quotation_id';
    	$columns = array(
           array( 'db' => 'quotation_id',   'dt' => 0 ),
		   array( 'db' => 'inquiry', 'dt' => 1 ),	 
		   // array('db'=> 'weight_per_piece','dt'=> 2),
            // array( 'db' => 'unit', 'dt' => 3),   
            array('db'=> 'terms_descr','dt'=> 2),
		   //array('db'=> 'parent_id','dt'=> 4),
		   // array('db'=> 'pcs','dt'=> 5),
		   array( 'db' => 'quotation_id', 'dt' => 3 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
		$from='quotation';
		$tables[0]['name']='terms';
		$tables[0]['col1']='quotation.term';
		$tables[0]['col2']='terms.terms_id';
	
	
	$output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where);
		// $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns);
		foreach ($output_arr['data'] as $key => $value) {
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			// if(CheckPermission('contacts', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonServiceprovider mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
			// }else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'id','id');
				// if($user_id==$this->user_id){
			
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a href="'.base_url().'quotation/getmodal/'.$id.'" type="button"  title="edit" class="btn-sm  btn "><i class="fa fa-pencil" data-id=""></i></a>';     
				// }
			// }
			
			// if(CheckPermission('contact', "products")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonproducts1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-eye" data-id=""></i></a>';
			//}else if(CheckPermission('products', "products")!=true){
			//	$user_id =getRowByTableColomId($table,$id,'products_id','products_id');
			//	if($user_id==$this->user_id){
			
			//$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="quotationModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class=" " target="_blank" href="'.base_url().'quotation/download/'.$id.'" type="button" data-src="'.$id.'" title="Download"><i class="fa fa-download" data-id=""></i></a>';
                $query= $this->db->select('*')->from('orders')->where('quotation',$id)->get();
            
                 if($query->num_rows() < 1){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '&nbsp;&nbsp;<a id="btnViewRow" class=" " href="'.base_url().'quotation/approved/'.$id.'" type="button" data-src="'.$id.'" title="Quotation Approve"><i class="fa fa-check-circle" data-id=""></i></a>'; }
				// }
			// }
			
           


			// if(CheckPermission('serviceprovider', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'serviceprovider\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
			// else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				// if($user_id==$this->user_id){
			 $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'quotation\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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

    /** * This function is used to show popup of user to add and update *
@return Voidw 
*/
    public function getmodal() {
        is_login();
        $id = $this->uri->segment(3);

        // print_r($_POST);
        if($id!='0'){
            
             $data['quotationData'] = getDataByid('quotation',$id,'quotation_id'); 
            $data['termsData'] = $this->Quotation_model->get_data_by('terms');
             $data['inquireData'] = $this->Quotation_model->get_data_by('inquiry');
             $data['productsData'] = $this->Quotation_model->get_data_by('products');
             $data['assproductsData'] = $this->Quotation_model->get_data_by('assemble');
            echo $this->load->view('add_quotation', $data, true);
        } else {
           
			$data['termsData'] = $this->Quotation_model->get_data_by('terms');
            $data['inquireData'] = $this->Quotation_model->get_data_by('inquiry');
            $data['productsData'] = $this->Quotation_model->get_data_by('products');
             $data['assproductsData'] = $this->Quotation_model->get_data_by('assemble');
         
            echo $this->load->view('add_quotation', $data, true);
        }
        exit;
    }
	public function getmodal1(){
		is_login();
		if($this->input->post('product_id')){
		$data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id'); 
        $data['supplierData'] = $this->Quotation_model->get_data_by('suppliers'); 
             // $data['productsData'] = $this->Quotation_model->get_data_by('products');
			echo $this->load->view('view_products',$data,true);
		}else{
       $data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id'); 
       $data['supplierData'] = $this->Quotation_model->get_data_by('suppliers'); 
             // $data['productsData'] = $this->Quotation_model->get_data_by('products');
			echo $this->load->view('view_products',$data,true);
		}
		exit;
	}	
	
	public function getmodalimport(){
		is_login();
		if($this->input->post('product_id')){
			
			//$data['productsData'] = getDataByid('products',$this->input->post('id'),'id');
			echo $this->load->view('importfile','',true);
		}else{
			echo $this->load->view('importfile','',true);
		}
		exit;
	}
    
    public function get_parent_cats(){


        $mainid = $this->input->post('mainid');
         $iddata = $this->input->post('iddata');

         if($iddata == 0){
            
          $name="";
         }else{
         $query = $this->db->select('*')->from('categories')->where('category_id',$iddata)->get();
          $result = $query->row();

         $name=$result->category_name;
         $iddata= $result->parent_id;


          while($iddata > 0){
            $query2 = $this->db->select('*')->from('categories')->where('category_id',$iddata)->get();
            $result2 = $query2->row();
            $name = $result2->category_name." => ".$name;
            $iddata = $result2->parent_id;
          }
        }
      

         $findata = array(
            'mainid'=>$mainid,
            'data'=>$name
         );
         echo json_encode($findata);


    }
    public function getmodalterms() {
        is_login();
      
        if($this->input->post('id')){
			 $data['category1Data'] = $this->Quotation_model->get_data_by('terms');
			$data['termsData'] = getDataByid('terms',$this->input->post('id'),'terms_id');
            echo $this->load->view('terms', $data, true);
        } else {
            $data['category1Data'] = $this->Quotation_model->get_data_by('terms');
		$data['termsData'] = $this->Quotation_model->get_data_by('terms');			
            echo $this->load->view('terms', $data, true);
        }
        exit;
    }
    
    
    public function getmodalterms2() {
        is_login();
      
        if($this->input->post('id')){
           $data['category1Data'] = $this->Quotation_model->get_data_by('terms');
           $data['termsData'] = getDataByid('terms',$this->input->post('id'),'terms_id');
           $data['quot_id'] = $this->input->post('quot_id');
            echo $this->load->view('terms2', $data, true);
        } else {
            $data['category1Data'] = $this->Quotation_model->get_data_by('terms');
            $data['termsData'] = $this->Quotation_model->get_data_by('terms');			
            echo $this->load->view('terms2', $data, true);
        }
        exit;
    }
    
   public function import()
 {
	 $this->load->library('excel');
	 
  if(isset($_FILES["file"]["name"]))
  { 
   $path = $_FILES["file"]["tmp_name"];
   
   $object = PHPExcel_IOFactory::load($path);
 
   foreach($object->getWorksheetIterator() as $worksheet)
   { 
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    for($row=2; $row<=$highestRow; $row++)
    {
     $prod_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
     $price = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
     $sku = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
     $category = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
    
     $data = array(
      'prod_name'  => $prod_name,
      'price'   => $price,
      'sku'    => $sku,
      'category'  => $category,
    
     );
	// print_r($data);
	     $this->Quotation_model->insertRow('products', $data);
    }
   }
   
   // $this->Quotation_model->insert($data);

    redirect( base_url().'products/productsTable', 'refresh');
  
  
 } 
 }

 public function getdetail(){
    $id=$this->input->post('val');
    $query = $this->db->Select('*')->from('inquiry')->where('inquiry_id',$id)->get();
    $result =$query->row();
    if($result->exist_cust=='0'){
        $vals= json_encode($result);
    }else{
          $query = $this->db->Select('*')->from('customers')->where('customer_id',$result->exist_cust)->get();
          $results=$query->row();
          $vals= json_encode($results);
    }   
    
    print_r($vals);

 }
 public function getproductdetail(){
    $id=$this->input->post('val');
     $query = $this->db->Select('*')->from('inquiry_products')->where('inq_id',$id)->get();
     $result= $query->result();
     $valse= json_encode($result);
     print_r($valse);
 }
    /**
     * This function is used to add and update users
     * @return Void
     */

public function addquotation($id='') {   
         
         $data = $this->input->post();

         unset($data['submit']);
         unset($data['allprod']);
          if($this->input->post('quotation_id')) {
            $id = $this->input->post('quotation_id');
            unset($data['quotation_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'quotationTable';
            }
        } else {
            $redirect = 'login';
        }
         $number = $this->input->post('allprod');
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
             unset($data['terms']);
            $check='';
        foreach ($_POST['terms'] as $key => $value) {
           $check .= $value.",";
        }
       
        $data['term']=$check;
         $this->Quotation_model->deleteRow('quotaion_products', 'quot_id', $id);
          for($i=1;$i<=$number;$i++){
                    
                    
                    $product = 'product'.$i;
                    $assem_prof = 'assem_prof'.$i;
                    $qtys = 'qtys'.$i;
                     $desc = 'desc'.$i;
                     $prics = 'prics'.$i;
                    $quot_amt = 'quot_amt'.$i;
                    $disctype = 'disctype'.$i;
                    $indidisc = 'indidisc'.$i;
                    $quot_total = 'totaftdisc'.$i;
                     unset($data[$product]);
                    unset($data[$assem_prof]);
                    unset($data[$qtys]);
                      unset($data[$desc]);
                     unset($data[$prics]);
                    unset($data[$quot_amt]);
                    unset($data[$disctype]);
                    unset($data[$indidisc]);
                    unset($data[$quot_total]);
                }

            if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                     $product = 'product'.$i;
                    $assem_prof = 'assem_prof'.$i;
                    $desc = 'desc'.$i;
                    $qtys = 'qtys'.$i;
                     $prics = 'prics'.$i;
                    $quot_amt = 'quot_amt'.$i;
                    $disctype = 'disctype'.$i;
                    $indidisc = 'indidisc'.$i;
                    $quot_total = 'totaftdisc'.$i;
                     unset($data[$product]);
                    unset($data[$assem_prof]);
                    unset($data[$qtys]);
                    unset($data[$desc]);
                     unset($data[$prics]);
                    unset($data[$quot_amt]);
                    unset($data[$disctype]);
                    unset($data[$indidisc]);
                    unset($data[$quot_total]);
                   
              $data_customer['product'] = $this->input->post($product);
              
            if(empty($data_customer['product'])){
                
                 $data_customer['product']=0;
            }
                
                $data_customer['assem_prof'] = $this->input->post($assem_prof);
                if(empty($data_customer['assem_prof'])){
                
                 $data_customer['assem_prof']=0;
            }
                  $data_customer['desc'] = $this->input->post($desc);
                $data_customer['quot_qty'] = $this->input->post($qtys);
                $data_customer['quot_price'] = $this->input->post($prics);
                $data_customer['quot_amt'] = $this->input->post($quot_amt);
                $data_customer['quot_disc_typ'] = $this->input->post($disctype);
                $data_customer['quot_disc'] = $this->input->post($indidisc);
                $data_customer['quot_total'] = $this->input->post($quot_total);
               
                if(empty($data_customer['quot_disc'])){
                $data_customer['quot_disc_typ']=2;
                 $data_customer['quot_disc']=0;
                 $data_customer['quot_total']=$data_customer['quot_amt'];
            }
                 $data_customer['quot_id'] = $id;
               
                $this->Quotation_model->insertRow('quotaion_products', $data_customer);
                   // print_r($this->db->last_query());  
                     
                }}
                if($data['discount']==0){
                    $data['alltotaftdisc']=$data['grandtotal'];
                }
            $this->Quotation_model->updateRow('quotation', 'quotation_id', $id, $data); 
            // print_r($this->db->last_query());
            // exit();
            
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'quotation/'.$redirect, 'refresh');
        }else{ 
           unset($data['terms']);
           unset($data['totaftdisc1']);
           
            $check='';
        foreach ($_POST['terms'] as $key => $value) {
           $check .= $value.",";
        }
        $data['term']=$check;

         for($i=1;$i<=$number;$i++){                    
                    $product = 'product'.$i;
                    $assem_prof = 'assem_prof'.$i;
                    $qtys = 'qtys'.$i;
                      $desc = 'desc'.$i;
                     $prics = 'prics'.$i;
                    $quot_amt = 'quot_amt'.$i;
                    $disctype = 'disctype'.$i;
                    $indidisc = 'indidisc'.$i;
                    $quot_total = 'totaftdisc'.$i;
                     unset($data[$product]);
                    unset($data[$assem_prof]);
                    unset($data[$qtys]);
                    unset($data[$desc]);
                     unset($data[$prics]);
                    unset($data[$quot_amt]);
                    unset($data[$disctype]);
                    unset($data[$indidisc]);
                    unset($data[$quot_total]);
                }
                if($data['discount']==0){
                    $data['alltotaftdisc']=$data['grandtotal'];
                }

       $id = $this->Quotation_model->insertRow('quotation', $data);
      //print_r($this->db->last_query());

                
            if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                     $product = 'product'.$i;
                    $assem_prof = 'assem_prof'.$i;
                        $desc = 'desc'.$i;
                    $qtys = 'qtys'.$i;
                    $prics = 'prics'.$i;
                    $quot_amt = 'quot_amt'.$i;
                    $disctype = 'disctype'.$i;
                    $indidisc = 'indidisc'.$i;
                    $quot_total = 'totaftdisc'.$i;
                     unset($data[$product]);
                     unset($data[$assem_prof]);
                     unset($data[$qtys]);
                     unset($data[$desc]);
                     unset($data[$prics]);
                     unset($data[$quot_amt]);
                     unset($data[$disctype]);
                     unset($data[$indidisc]);
                     unset($data[$quot_total]);
                   
              $data_customer['product'] = $this->input->post($product);
              if(empty($data_customer['product'])){
                
                 $data_customer['product']=0;
            }
                $data_customer['assem_prof'] = $this->input->post($assem_prof);
                if(empty($data_customer['assem_prof'])){
                
                 $data_customer['assem_prof']=0;
            }
                 $data_customer['desc'] = $this->input->post($desc);
                $data_customer['quot_qty'] = $this->input->post($qtys);
                $data_customer['quot_price'] = $this->input->post($prics);
                $data_customer['quot_amt'] = $this->input->post($quot_amt);
                $data_customer['quot_disc_typ'] = $this->input->post($disctype);
                $data_customer['quot_disc'] = $this->input->post($indidisc);
                $data_customer['quot_total'] = $this->input->post($quot_total);
                if(empty($data_customer['quot_disc'])){
                $data_customer['quot_disc_typ']=2;
                 $data_customer['quot_disc']=0;
                 $data_customer['quot_total']=$data_customer['quot_amt'];
            }
                 $data_customer['quot_id'] = $id;
               
                $this->Quotation_model->insertRow('quotaion_products', $data_customer);
                 //print_r($this->db->last_query());
                     
                }}
           
      //  exit();
        
        redirect( base_url().'quotation/quotationTable', 'refresh');
        }
    }

public function terms($id='') {   
         
         $data = $this->input->post();
         unset($data['submit']);
          if($this->input->post('terms_id')) {
            $id = $this->input->post('terms_id');
            unset($data['terms_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'quotationTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }

            $this->Quotation_model->updateRow('terms', 'terms_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'quotation/'.$redirect, 'refresh');
        }else{ 
        
        $this->Quotation_model->insertRow('terms', $data);
        redirect( base_url().'quotation/quotationTable', 'refresh');
        }
    }

    
public function terms2($id='') {   
         
         $data = $this->input->post();
         unset($data['submit']);
          if($this->input->post('terms_id')) {
            $id = $this->input->post('terms_id');
            $quot_id = $this->input->post('quot_id');
            unset($data['terms_id']);
            unset($data['quot_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'getmodal/'.$quot_id;
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }

            $this->Quotation_model->updateRow('terms', 'terms_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'quotation/'.$redirect, 'refresh');
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
            $this->Quotation_model->delete($id); 
        }
       redirect(base_url().'quotation/quotationTable', 'refresh');
    }


     public function approved($id){
         if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'quotationTable';
            }
        } else {
            $redirect = 'login';
        }
        $data['quotation_id']=$id;
        $data['status']="approved";
        $datas['quotation']=$id;
         $quotationData = getDataByid('quotation',$id,'quotation_id');
         $datas['inq']=$quotationData->inquiry;
        $datas['ord_date']=date("Y/m/d");
        $datas['ord_status']=1;
         $this->Quotation_model->updateRow('quotation', 'quotation_id', $id, $data);
         $this->Quotation_model->insertRow('orders',$datas);
     redirect( base_url().'quotation/'.$redirect, 'refresh');
    }

      public function download($id) {   

         
         $data['quotationData'] = getDataByid('quotation',$id,'quotation_id');
            
           $data['quotation_followupData'] = $this->Quotation_model->   get_data_by('quotaion_products',$id,'quot_id');

         
         
    $id2 = $this->load->view('download1',$data,true);
    // print_r($id);
        
         $this->pdf->loadHtml($id2);
   $this->pdf->render();
   $this->pdf->stream("".$id.".pdf", array("Attachment"=>0));
    

    }

    
    
    
}