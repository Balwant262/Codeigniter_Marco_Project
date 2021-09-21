<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Products extends CI_Controller {

    function __construct() { 
        parent::__construct(); 
		$this->load->model('Products_model');
        
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
    public function productsTable(){
        is_login();
	
		
        if(CheckPermission("products", "products")){
            
            
            $data['vendor'] =$this->input->post('vendor');
            
            
            $this->db->select('*');
            $this->db->from('products');
            $vendor_id =$data['vendor'];
            if($data['vendor']  != '' )
            {
                $this->db->where("find_in_set($vendor_id, supplier_id)");
            }
            
            $query = $this->db->get();
            $data['ordersData']= $query->result();
            $data['vendorData'] = $this->Products_model->get_data_by('suppliers');
		
            $this->load->view('include/header');
            $this->load->view('products_table', $data);                
            $this->load->view('include/footer');            
        } else {
			
           $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
        }
    }

    public function dataTable2 (){
        is_login();
        $table = 'categories';
        $primaryKey = 'category_id';
        $columns = array(
           array( 'db' => 'category_id', 'dt' => 0 ),
		    // array( 'db' => 'id', 'dt' => 1 ),
           array( 'db' => 'category_name', 'dt' => 1 ),
           array( 'db' => 'category_id', 'dt' => 2 )
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
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="categoryModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            }else if(CheckPermission('products_edit', "products") && (CheckPermission('products', "products")!=true)){
                $user_id =getRowByTableColomId($table,$id,'id','id');
                if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="categoryModalButton1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
                }
            }
            
            
            
            if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){
            if(CheckPermission('products', "products")){
                
                
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'products\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
            else if(CheckPermission('products_view', "products") && (CheckPermission('products', "products")!=true)){
                $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
                if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'products\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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
	    $table = 'products';
    	$primaryKey = 'product_id';
    	$columns = array(
           array( 'db' => 'product_id',   'dt' => 0 ),
		   array( 'db' => 'part_no', 'dt' => 1 ),	 
		   // array('db'=> 'weight_per_piece','dt'=> 2),
            // array( 'db' => 'unit', 'dt' => 3),   
            array('db'=> 'category_name','dt'=> 2),
		   //array('db'=> 'parent_id','dt'=> 4),
		   // array('db'=> 'pcs','dt'=> 5),
		   array( 'db' => 'product_id', 'dt' => 3 )
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
		$from='products';
		$tables[0]['name']='categories';
		$tables[0]['col1']='products.category';
		$tables[0]['col2']='categories.category_id';
	
	
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
			
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="productsModalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				// }
			// }
			
			// if(CheckPermission('contact', "products")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonproducts1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-eye" data-id=""></i></a>';
			//}else if(CheckPermission('products', "products")!=true){
			//	$user_id =getRowByTableColomId($table,$id,'products_id','products_id');
			//	if($user_id==$this->user_id){
			
//			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="productsModalButton1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
				// }
			// }
			
           


			// if(CheckPermission('serviceprovider', "serviceprovider")){
			// $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'serviceprovider\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
			// else if(CheckPermission('serviceprovider', "serviceprovider") && (CheckPermission('serviceprovider', "serviceprovider")!=true)){
				// $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
				// if($user_id==$this->user_id){
			 $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'products\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
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
@return Voidw */
    public function getmodal() {
        is_login();
        // print_r($_POST);
        if($this->input->post('product_id')){
            $data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id');
			$data['categoryData'] = $this->Products_model->get_data_by('categories');
            // $data['rawmData'] = $this->Products_model->get_data_by('raw_material');	
            // $data['product_tagsData'] = $this->Products_model->get_data_by('product_tags',$this->input->post('id') ,'product_id');
            $data['tagsData'] = $this->Products_model->get_data_by('tags');	
            $data['supplierData'] = $this->Products_model->get_data_by('suppliers');
            $data['makeData'] = $this->Products_model->get_data_by('make');
            $data['modelData'] = $this->Products_model->get_data_by('model');
            echo $this->load->view('add_products', $data, true);
        } else {
            $data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id'); 
			$data['categoryData'] = $this->Products_model->get_data_by('categories');
            // $data['rawmData'] = $this->Products_model->get_data_by('raw_material'); 
            $data['tagsData'] = $this->Products_model->get_data_by('tags');
            $data['supplierData'] = $this->Products_model->get_data_by('suppliers');
            $data['makeData'] = $this->Products_model->get_data_by('make');
            $data['modelData'] = $this->Products_model->get_data_by('model');
            echo $this->load->view('add_products', $data, true);
        }
        exit;
    }
	public function getmodal1(){
		is_login();
		if($this->input->post('product_id')){
		$data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id'); 
        $data['supplierData'] = $this->Products_model->get_data_by('suppliers'); 
             // $data['productsData'] = $this->Products_model->get_data_by('products');
			echo $this->load->view('view_products',$data,true);
		}else{
       $data['productsData'] = getDataByid('products',$this->input->post('id'),'product_id'); 
       $data['supplierData'] = $this->Products_model->get_data_by('suppliers'); 
             // $data['productsData'] = $this->Products_model->get_data_by('products');
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
    public function getmodalcategory() {
        is_login();
      
        if($this->input->post('id')){
			 $data['category1Data'] = $this->Products_model->get_data_by('categories');
			$data['categoryData'] = getDataByid('categories',$this->input->post('id'),'category_id');
            echo $this->load->view('category', $data, true);
        } else {
            $data['category1Data'] = $this->Products_model->get_data_by('categories');
		$data['categoryData'] = $this->Products_model->get_data_by('categories');			
            echo $this->load->view('category', $data, true);
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
	     $this->Products_model->insertRow('products', $data);
    }
   }
   
   // $this->Products_model->insert($data);

    redirect( base_url().'products/productsTable', 'refresh');
  
  
 } 
 }
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add($id='') {  
   
		$config['upload_path']          ='assets/images';
        $config['allowed_types']        = 'gif|jpg|png|wmv|mp4|avi|mov';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
         $data = $this->input->post();
         $number = $this->input->post('number');
         $number1 = $this->input->post('number1');
         $numberm = $this->input->post('numberm');
         $numberm1 = $this->input->post('numberm1');
         $numbermm =$this->input->post('numbermm');
         $numbermm1 = $this->input->post('numbermm1');
		 unset($data['submit']);
         unset($data['number']);
         unset($data['number1']);
         unset($data['numberm']);
         unset($data['numberm1']);
         unset($data['numbermm']);
         unset($data['numbermm1']);
		 
		 if($this->input->post('product_id')) {
            $id = $this->input->post('product_id');
			unset($data['product_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'products';
            }
        } else {
            $redirect = 'login';
        }
		
		//$partnames['inventory_id']='';
        
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
			}

			$old_video=$data['oldvideo'];
            $old_pic=$data['oldpic'];
			unset($data['oldvideo']);
            unset($data['oldpic']);

            $this->Products_model->deleteRow('product_tags', 'product_id', $id);
            $this->Products_model->deleteRow('product_makemodel', 'product_id', $id);

             for ($i=1; $i <=$number1 ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
                }
            for ($i=1; $i <=$number1 ; $i++) {
                $tag_id = 'tag_id'.$i;
                    if($this->input->post($tag_id)){
                        $data_tag['tag_id'] = $this->input->post($tag_id);
                        $data_tag['product_id'] = $id;

                        $this->Products_model->insertRow('product_tags', $data_tag);
                        
                    }
            }

              for ($i=1; $i <=$numbermm1 ; $i++) { 
                    $make_id = 'make_id'.$i;
                    unset($data[$make_id]);
                    $model_id = 'model_id'.$i;
                    unset($data[$model_id]);
                }
            for ($i=1; $i <=$numbermm1 ; $i++) {
                $make_id = 'make_id'.$i;
                $model_id = 'model_id'.$i;
                    if($this->input->post($model_id)!='' && $this->input->post($make_id)!=''){
                        $data_mm['make_id'] = $this->input->post($make_id);
                        $data_mm['model_id'] = $this->input->post($model_id);
                        $data_mm['product_id'] = $id;

                        $this->Products_model->insertRow('product_makemodel', $data_mm);
                        
                    }
            }

            $mediaData = $this->Products_model->get_data_by('products_media',$id,'product_id');

            $a=array();
            for ($i=1; $i <=$numberm1 ; $i++) { 
                $old_media = 'old_media'.$i;
                unset($data[$old_media]);
                $media_id = 'media_id'.$i;
                unset($data[$media_id]);
                array_push($a,$this->input->post($media_id));
            }
            foreach ($mediaData as $value) {
                if(!in_array($value->id, $a)){
                    $this->Products_model->deleteRow('products_media', 'id', $value->id);
                }
            }

            // exit();
            for ($i=1; $i <=$numberm1 ; $i++) {
                $old_media = 'old_media'.$i;
                $media_id = 'media_id'.$i;
                if($this->input->post($old_media) != '')
                {
                    if ( $this->upload->do_upload('media'.$i)){
                    $uplddata = array('upload_data' => $this->upload->data());
                    $imgname =  $uplddata['upload_data']['file_name'];
                    @unlink('assets/images/'.$this->input->post($old_media));

                    $datamu['media']=$imgname;
                    $this->Products_model->updateRow('products_media', 'id', $this->input->post($media_id), $datamu);
                    }


                }else{
                    if ( $this->upload->do_upload('media'.$i))
                    {
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data_m['media'] =  $uplddata['upload_data']['file_name'];
                        $data_m['product_id'] = $id;

                    $this->Products_model->insertRow('products_media', $data_m);

                    }
                }
            }

            if($this->input->post('oldvideo') != '')
                {
                    if ( $this->upload->do_upload('video')){
                    $uplddata = array('upload_data' => $this->upload->data());
                    $vname =  $uplddata['upload_data']['file_name'];
                    @unlink('assets/images/'.$this->input->post('oldvideo'));

                    $data['video']=$vname;
                	}

                }else{
                    if ( $this->upload->do_upload('video'))
                    {
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data['video'] =  $uplddata['upload_data']['file_name'];

                    }
                }


            if($this->input->post('oldpic') != '')
                {
                    if ( $this->upload->do_upload('profile_pic')){
                    $uplddata1 = array('upload_data1' => $this->upload->data());
                    $vname1 =  $uplddata1['upload_data1']['file_name'];
                    @unlink('assets/images/'.$this->input->post('profile_pic'));

                    $data['profile_pic']=$vname1;
                    }

                }else{
                    if ( $this->upload->do_upload('profile_pic'))
                    {
                        $uplddata1 = array('upload_data1' => $this->upload->data());
                        $data['profile_pic'] =  $uplddata1['upload_data1']['file_name'];

                    }
                }

                 $allsuppliers=implode(',',$_POST['suppliers']);
                unset($data['suppliers']);
               
               $data['supplier_id']=$allsuppliers;

            $this->Products_model->updateRow('products', 'product_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'products/productsTable', 'refresh');
        } else { 
                unset($data['product_id']);
                 unset($data['oldvideo']);
                 unset($data['oldpic']);
                for ($i=1; $i <=$number ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
                }
                for ($i=1; $i <=$numberm ; $i++) { 
                    $media = 'media'.$i;
                    unset($data[$media]);
                }
                for ($i=1; $i <=$numbermm ; $i++) { 
                    $make_id = 'make_id'.$i;
                    unset($data[$make_id]);
                    $model_id = 'model_id'.$i;
                    unset($data[$model_id]);
                }
                if ( $this->upload->do_upload('video'))
                {
                    $uplddata = array('upload_data' => $this->upload->data());
                    $data['video'] =  $uplddata['upload_data']['file_name'];
                      
                }
                  if ( $this->upload->do_upload('profile_pic'))
                {
                    
                    $uplddata1 = array('upload_data1' => $this->upload->data());

                    $data['profile_pic'] =  $uplddata1['upload_data1']['file_name'];
                      
                }
                $allsuppliers=implode(',',$_POST['suppliers']);
                unset($data['suppliers']);
               
               $data['supplier_id']=$allsuppliers;

             //echo "<pre>";print_r($data);exit();
				$id = $this->Products_model->insertRow('products', $data);
                // echo $id; 
                // print_r($this->db->last_query());exit();
                // $partnames['part_names'] = $id;
                // $partnames['part_type'] = 1;
                // $product_id= $this->Products_model->insertRow('inventory', $partnames);
                for ($i=1; $i <=$number ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    if($this->input->post($tag_id)){

                    $data_tag['tag_id'] = $this->input->post($tag_id);
                    $data_tag['product_id'] = $id;

                    $this->Products_model->insertRow('product_tags', $data_tag);
                    }
                }

                for ($i=1; $i <=$numbermm ; $i++) {
                        $make_id = 'make_id'.$i;
                        $model_id = 'model_id'.$i;
                    if($this->input->post($model_id)!='' && $this->input->post($make_id)!=''){
                        $data_mm['make_id'] = $this->input->post($make_id);
                        $data_mm['model_id'] = $this->input->post($model_id);
                        $data_mm['product_id'] = $id;

                        $this->Products_model->insertRow('product_makemodel', $data_mm);
                        
                    }
                }
                

                for ($i=1; $i <=$numberm ; $i++) { 
                    // $media = 'media'.$i;
                    // unset($data[$media]);

                if ( $this->upload->do_upload('media'.$i))
                {
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data_m['media'] =  $uplddata['upload_data']['file_name'];
                        $data_m['product_id'] = $id;

                    $this->Products_model->insertRow('products_media', $data_m);

                }


                }


                  
				redirect( base_url().'products/productsTable', 'refresh');	
            }
    }

public function category($id='') {   
         
         $data = $this->input->post();
         unset($data['submit']);
          if($this->input->post('category_id')) {
            $id = $this->input->post('category_id');
            unset($data['category_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'productsTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }

            $this->Products_model->updateRow('categories', 'category_id', $id, $data);
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'products/'.$redirect, 'refresh');
        }else{ 
        
        $this->Products_model->insertRow('categories', $data);
        redirect( base_url().'products/productsTable', 'refresh');
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
            $this->Products_model->delete($id); 
        }
       redirect(base_url().'products/productsTable', 'refresh');
    }

    
    
    public function getModels(){
        $make_id = $this->input->post('make_id');

        $query = $this->db->select('*')->from('model')->where('make_id',$make_id)->get();
        $data = $query->result();

        echo json_encode($data); 

    }
}