<?php   
defined('BASEPATH') OR exit('No direct script access allowed ');
class Assemble extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    $this->load->model('Assemble_model');
    //$this->load->library('excel');
          // $this->load->library('pdf');
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
    public function assembleTable(){
        is_login();
        
        $data['vendor'] =$this->input->post('vendor');
    
        if(CheckPermission("assemble", "assemble")){
    
            $data['vendorData'] = $this->Assemble_model->get_data_by('suppliers');
            
            $this->load->view('include/header');
            $this->load->view('assemble_table', $data);                
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
      $vendor_id =  $this->uri->segment(3);
  
        $table = 'assemble';
    	$primaryKey = 'assemble_id';
    	$columns = array(
          // array( 'sdb' => 'inquiry_id',   'dt' => 0 ),
          array( 'db' => 'assemble_id', 'dt' => 0),
            array( 'db' => 'part_name', 'dt' => 1),
           //array( 'db' => 'CONCAT(co_name," ",inq_coname)', 'dt' => 1),
          // array( 'db' => 'CONCAT("lead_coname,inq_coname")', 'dt' => 1),
            array( 'db' => 'assemble_id', 'dt' => 2),
		  
		);

        $sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);
		$from='assemble';
        $where = 'where assemble_id != "" ';

        $tables[0]['name']='suppliers';
        $tables[0]['col1']='assemble.supplier_id';
        $tables[0]['col2']='suppliers.supplier_id';
       
         
        if( $vendor_id != '')
        {
         $where .=" and assemble.supplier_id ='".$vendor_id."'";
        }
         $where .=' group by assemble_id';

       $output_arr = SSP::innerJoin( $_GET, $sql_details, $from,$tables, $primaryKey, $columns, $where, $col_name,$order,$order_type);
    
   //$output_arr = SSP::innerJoin($_GET, $sql_details, $from, $table, $primaryKey, $columns, $where='');
   //$output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where='');
    foreach ($output_arr['data'] as $key => $value) {
      $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
    if(CheckPermission("assemble_edit", "assemble")){ 
      
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="assmblemodalbutton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
      }
       if(CheckPermission("assemble_view", "assemble")){ 
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="assmblemodalviewbutton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
           }
            if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){ 
       $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'assemble\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
      }
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
    public function getmodal() {
        is_login();
       
        if($this->input->post('id')){
    $data['assembleData'] = getDataByid('assemble',$this->input->post('id'),'assemble_id');
       $data['productsData'] = $this->Assemble_model->get_data_by('products');
      $data['assemble_followupData'] = $this->Assemble_model->get_data_by('assemble_product',$this->input->post('id'),'asemble_id');
            $data['tagsData'] = $this->Assemble_model->get_data_by('tags');  
            $data['supplierData'] = $this->Assemble_model->get_data_by('suppliers');
            $data['makeData'] = $this->Assemble_model->get_data_by('make');
            $data['modelData'] = $this->Assemble_model->get_data_by('model'); 
          echo $this->load->view('add_assemble',$data,true);
        } else {
         
            $data['assembleData'] = getDataByid('assemble',$this->input->post('assemble_id'),'assemble_id'); 
             $data['productsData'] = $this->Assemble_model->get_data_by('products');
             $data['assemble_followupData'] = getDataByid('assemble_product',$this->input->post('assemble_id'),'asemble_id');
            $data['tagsData'] = $this->Assemble_model->get_data_by('tags');  
            $data['supplierData'] = $this->Assemble_model->get_data_by('suppliers');
            $data['makeData'] = $this->Assemble_model->get_data_by('make');
            $data['modelData'] = $this->Assemble_model->get_data_by('model'); 
           echo $this->load->view('add_assemble',$data, true);
        }
        exit;
    }
  public function getmodal1() {
        is_login();
       
        if($this->input->post('id')){
         
             $data['assembleData'] = getDataByid('assemble',$this->input->post('id'),'assemble_id');
     
              $data['productsData'] = $this->Assemble_model->get_data_by('products');
             
            $data['assemble_followupData'] = $this->Assemble_model->get_data_by('assemble_product',$this->input->post('id'),'asemble_id');
            $data['supplierData'] = $this->Assemble_model->get_data_by('suppliers');
          echo $this->load->view('view_assemble',$data,true);
        } else {
          
            $data['assembleData'] = getDataByid('assemble',$this->input->post('assemble_id'),'assemble_id'); 
            $data['productsData'] = $this->Assemble_model->get_data_by('products');
            $data['assemble_followupData'] = $this->Assemble_model->get_data_by('assemble_product',$this->input->post('assemble_id'),'assemble_id');
            $data['supplierData'] = $this->Assemble_model->get_data_by('suppliers');
           echo $this->load->view('view_assemble',$data, true);
           
        }
        exit;
    }
  
  
  
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add($id='') {   
    // $data =array();
        $config['upload_path']          ='assets/images';
        $config['allowed_types']        = 'gif|jpg|png|wmv|mp4|avi|mov';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
    $data = $this->input->post();
        
        $number = $this->input->post('number');
        //$count = $this->input->post('count');
         $number_t = $this->input->post('number_t');
         $number_t1 = $this->input->post('number_t1');
         $numberm = $this->input->post('numberm');
         $numberm1 = $this->input->post('numberm1');
         $numbermm =$this->input->post('numbermm');
         $numbermm1 = $this->input->post('numbermm1');
     unset($data['submit']);
         unset($data['submit']);
         unset($data['add']);
         unset($data['number']);
         unset($data['number_t']);
         unset($data['number_t1']);
         unset($data['count']);
         unset($data['numberm']);
         unset($data['numberm1']);
         unset($data['numbermm']);
         unset($data['numbermm1']);
         $config['upload_path']          ='assets/images';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
         
          if($this->input->post('assemble_id')) {
            $id = $this->input->post('assemble_id');
            unset($data['assemble_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'assemble';
            }
        } else {
            $redirect = 'login';
        }
        


        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
            $old_video=$data['oldvideo'];
            $old_pic=$data['oldpic'];
            unset($data['oldvideo']);
            unset($data['oldpic']);
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


             $this->Assemble_model->deleteRow('assemble_product', 'asemble_id', $id);
              //print_r($this->db->last_query());
             $this->Assemble_model->deleteRow('assemble_makemodel', 'asemble_id', $id);
             for ($i=1; $i <=$numbermm1 ; $i++) { 
                    $make_id = 'make_id'.$i;
                    unset($data[$make_id]);
                    $model_id = 'model_id'.$i;
                    unset($data[$model_id]);
                }
             for ($i=1; $i <=$number_t1 ; $i++) {
               $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
             }

            for ($i=1; $i <=$numbermm1 ; $i++) {
                $make_id = 'make_id'.$i;
                $model_id = 'model_id'.$i;
                    if($this->input->post($model_id)!='' && $this->input->post($make_id)!=''){
                        $data_mm['make_id'] = $this->input->post($make_id);
                        $data_mm['model_id'] = $this->input->post($model_id);
                        $data_mm['asemble_id'] = $id;

                        $this->Assemble_model->insertRow('assemble_makemodel', $data_mm);
                          print_r($this->db->last_query());  
                    }
            }

             $total_weight=0;
                for($i=1;$i<=$number;$i++){
                    
                    
                    $product = 'product_name'.$i;
                    $qty = 'product_wght'.$i;
                   
                    unset($data[$product]);
                    unset($data[$qty]);
                  
                  $query = $this->db->select('*')->from('products')->where('product_id',$this->input->post($product))->get();
            $result=$query->row();   
                if($result->unit=='g'){
      $total_weight =($result->weight_per_piece*$this->input->post($qty)/1000)+$total_weight;
            }   else{
       $total_weight =($result->weight_per_piece*$this->input->post($qty))+$total_weight; 
              } 
                }
             // exit();
              if($number > 0)  
                {
                    
                for($i=1;$i<=$number;$i++){
                    

                    $product = 'product_name'.$i;
                    $qty = 'product_wght'.$i;
                   

                    unset($data[$product]);
                    unset($data[$qty]);
                 
                if($this->input->post($product)){
                   
                $data_customer['product_name'] = $this->input->post($product);
                $data_customer['product_wght'] = $this->input->post($qty);
                    
                    $data_customer['asemble_id'] = $id;
               
                $this->Assemble_model->insertRow('assemble_product', $data_customer);
                  //print_r($this->db->last_query());
                }

            } 


                $data_customer['product_name'] = $this->input->post('product_name');
                $data_customer['product_wght'] = $this->input->post('product_wght');
              
                $data_customer['asemble_id'] = $id;
                }

            $mediaData = $this->Assemble_model->get_data_by('assemble_media',$id,'assemble_id');

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
                    $this->Assemble_model->deleteRow('assemble_media', 'id', $value->id);
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
                    $this->Assemble_model->updateRow('assemble_media', 'id', $this->input->post($media_id), $datamu);
                    }


                }else{
                    if ( $this->upload->do_upload('media'.$i))
                    {
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data_m['media'] =  $uplddata['upload_data']['file_name'];
                        $data_m['assemble_id'] = $id;

                    $this->Assemble_model->insertRow('assemble_media', $data_m);

                    }
                }
            }





           $data['total_weight']=$total_weight;
            $this->Assemble_model->updateRow('assemble', 'assemble_id', $id, $data);
               // print_r($this->db->last_query());
            $this->Assemble_model->deleteRow('asseble_product_tags', 'assemble_id', $id);
             for ($i=1; $i <=$number_t1 ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
                }
            for ($i=1; $i <=$number_t1 ; $i++) {
                $tag_id = 'tag_id'.$i;
                    if($this->input->post($tag_id)){
                        $data_tag['tag_id'] = $this->input->post($tag_id);
                        $data_tag['assemble_id'] = $id;

                        $this->Assemble_model->insertRow('asseble_product_tags', $data_tag);
                        
                    }
            }


            //print_r($this->db->last_query());exit();
            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'assemble/assembleTable', 'refresh');
        }else{ 
       // print_r($data);
      // $partnames['part_names'] = $data['part_no'];
        unset($data['assemble_id']);
         unset($data['oldvideo']);
                 unset($data['oldpic']);
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


        $total_weight=0;
        for ($i=1; $i <=$number_t ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
                }
          for ($i=1; $i <=$numberm ; $i++) { 
                    $media = 'media'.$i;
                    unset($data[$media]);
                }
                for ($i=1; $i <=$numbermm ; $i++) { 
                    $make_id = 'make_id'.$i;
                    unset($data[$tag_id]);
                    $model_id = 'model_id'.$i;
                    unset($data[$model_id]);
                }
              // $data['total_weight']='';
        for($i=1;$i<=$number;$i++){
                      
                    $product = 'product_name'.$i;
                     $qty = 'product_wght'.$i;
                     
                    unset($data[$product]);
                    unset($data[$qty]);
            $query = $this->db->select('*')->from('products')->where('product_id',$this->input->post($product))->get();
            $result=$query->row();
           
            if($result->unit=='g'){
              $total_weight =($result->weight_per_piece*$this->input->post($qty)/1000)+$total_weight;
                    }   else{
               $total_weight =($result->weight_per_piece*$this->input->post($qty))+$total_weight; 
                      } 
                }

              $data['total_weight']=$total_weight;

                $id = $this->Assemble_model->insertRow('assemble', $data);
                    $partnames['part_names'] = $id;
                     $partnames['part_type'] = 2;
             $this->Assemble_model->insertRow('inventory', $partnames);
              if($number > 0)  
                {  
        
                for($i=1;$i<=$number;$i++){
                    $product = 'product_name'.$i;
                    $qty = 'product_wght'.$i;
                  
            
                if($this->input->post($product)){
       
                $data_customer['product_name'] = $this->input->post($product);
                $data_customer['product_wght'] = $this->input->post($qty);
               
                    
                }
                if($i==1){
                    $data_customer['asemble_id'] = $id;
                }
                
              $this->Assemble_model->insertRow('assemble_product', $data_customer);
                
            }   
                $data_customer['product'] = $this->input->post('product');
                $data_customer['product_wght'] = $this->input->post('product_wght');
                $data_customer['id'] = $this->input->post('id');
                }


                for ($i=1; $i <=$number_t ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    unset($data[$tag_id]);
                }
                for ($i=1; $i <=$number_t ; $i++) { 
                    $tag_id = 'tag_id'.$i;
                    if($this->input->post($tag_id)){

                    $data_tag['tag_id'] = $this->input->post($tag_id);
                    $data_tag['assemble_id'] = $id;

                    $this->Assemble_model->insertRow('asseble_product_tags', $data_tag);
                    }
                }

                for ($i=1; $i <=$numberm ; $i++) { 

                if ( $this->upload->do_upload('media'.$i))
                {
                        $uplddata = array('upload_data' => $this->upload->data());
                        $data_m['media'] =  $uplddata['upload_data']['file_name'];
                        $data_m['assemble_id'] = $id;

                    $this->Assemble_model->insertRow('assemble_media', $data_m);

                }
                }

                for ($i=1; $i <=$numbermm ; $i++) {
                        $make_id = 'make_id'.$i;
                        $model_id = 'model_id'.$i;
                    if($this->input->post($model_id)!='' && $this->input->post($make_id)!=''){
                        $data_mm['make_id'] = $this->input->post($make_id);
                        $data_mm['model_id'] = $this->input->post($model_id);
                        $data_mm['assemble_id'] = $id;

                        $this->Assemble_model->insertRow('assemble_makemodel', $data_mm);
                        
                    }
                }
                

        redirect( base_url().'assemble/assembleTable', 'refresh');
    
        
        }
    }

    /**
     * This function is used to delete users
     * @return Void
     */
   public function delete($id){
        is_login(); 
        $ids = explode('-', $id);
        // print_r($ids);
        // exit();
        foreach ($ids as $id) {
            $this->Assemble_model->delete($id);

        }
       redirect(base_url().'assemble/assembleTable', 'refresh');
    }
    

    public function getModels(){
        $make_id = $this->input->post('make_id');

        $query = $this->db->select('*')->from('model')->where('make_id',$make_id)->get();
        $data = $query->result();

        echo json_encode($data); 

    }
    
    

}