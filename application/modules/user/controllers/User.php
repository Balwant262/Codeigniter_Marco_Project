<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class User extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    $this->load->model('User_model');
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
      * This function is used to load login view page
      * @return Void
      */
    public function login(){
      if(isset($_SESSION['user_details'])){
        redirect( base_url().'user/profile', 'refresh');
      }   
      $this->load->view('include/script');
        $this->load->view('login'); 
    }

    /**
      * This function is used to logout user
      * @return Void
      */
    public function logout(){
        is_login();
        $this->session->unset_userdata('user_details');               
        redirect( base_url().'user/login', 'refresh');
    }

    /**
     * This function is used to registr user
     * @return Void
     */
    public function registration(){
      if(isset($_SESSION['user_details'])){
        redirect( base_url().'user/profile', 'refresh');
      }
        //Check if admin allow to registration for user
    if(setting_all('register_allowed')==1){
      if($this->input->post()) {
        $this->add_edit();
        $this->session->set_flashdata('messagePr', 'Successfully Registered..');
      } else {
        $this->load->view('include/script');
        $this->load->view('register');
      }
    }
    else {
      $this->session->set_flashdata('messagePr', 'Registration Not allowed..');
      redirect( base_url().'user/login', 'refresh');
    }
    }
    
    /**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
  public function auth_user($page =''){ 
    $return = $this->User_model->auth_user();
    if(empty($return)) { 
      $this->session->set_flashdata('messagePr', 'Invalid details Or Your Account Is Not Active!');  
            redirect( base_url().'user/login', 'refresh');  
        } else { 
      if($return == 'not_varified') {
        $this->session->set_flashdata('messagePr', 'This accout is not varified. Please contact to your admin..');
                redirect( base_url().'user/login', 'refresh');
      } else {
        $this->session->set_userdata('user_details',$return);
      }
            redirect( base_url().'leads/leadsTable', 'refresh');
        }
    }

    /**
     * This function is used send mail in forget password
     * @return Void
     */
    public function forgetpassword(){
        $page['title'] = 'Forgot Password';
        if($this->input->post()){
            $setting = settings();
            $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email',1);
            if(isset($res[0]->users_id) && $res[0]->users_id != '') { 
                $var_key = $this->getVarificationCode(); 
                $this->User_model->updateRow('users', 'users_id', $res[0]->users_id, array('var_key' => $var_key));
                $sub = "Reset password";
                $email = $this->input->post('email');      
                $data = array(
                    'user_name' => $res[0]->name,
                    'action_url' =>base_url(),
                    'sender_name' => $setting['company_name'],
                    'website_name' => $setting['website'],
                    'varification_link' => base_url().'user/mail_varify?code='.$var_key,
                    'url_link' => base_url().'user/mail_varify?code='.$var_key,
                    );
                $body = $this->User_model->get_template('forgot_password');
                $body = $body->html;
                foreach ($data as $key => $value) {
                    $body = str_replace('{var_'.$key.'}', $value, $body);
                }
                if($setting['mail_setting'] == 'php_mailer') {
                    $this->load->library("send_mail");         
                    $emm = $this->send_mail->email($sub, $body, $email, $setting);
                } else {
                    // content-type is required when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
                    $emm = mail($email,$sub,$body,$headers);
                }
                if($emm) {
                    $this->session->set_flashdata('messagePr', 'To reset your password, link has been sent to your email');
                    redirect( base_url().'user/login','refresh');
                }
            } else {    
                $this->session->set_flashdata('forgotpassword', 'This account does not exist');//die;
                redirect( base_url()."user/forgetpassword");
            }
        } else {
            $this->load->view('include/script');
            $this->load->view('forget_password');
        }
    }

    /**
      * This function is used to load view of reset password and varify user too 
      * @return : void
      */
    public function mail_varify(){
        $return = $this->User_model->mail_varify();         
        $this->load->view('include/script');
        if($return){          
          $data['email'] = $return;
          $this->load->view('set_password', $data);        
        } else { 
        $data['email'] = 'allredyUsed';
          $this->load->view('set_password', $data);
      } 
    }
  
    /**
      * This function is used to reset password in forget password process
      * @return : void
      */
    public function reset_password(){
        $return = $this->User_model->ResetPpassword();
        if($return){
          $this->session->set_flashdata('messagePr', 'Password Changed Successfully..');
            redirect( base_url().'user/login', 'refresh');
        } else {
          $this->session->set_flashdata('messagePr', 'Unable to update password');
            redirect( base_url().'user/login', 'refresh');
        }
    }

    /**
     * This function is generate hash code for random string
     * @return string
     */
    public function getVarificationCode(){        
        $pw = $this->randomString();   
        return $varificat_key = password_hash($pw, PASSWORD_DEFAULT); 
    }

    

    /**
     * This function is used for show users list
     * @return Void
     */
    public function userTable(){
        is_login();
        if(CheckPermission("user", "own_read")){
          if($this->input->post())
          {
            $data['designation'] = $this->input->post('designation');
            $data['user_name'] = $this->input->post('user_name');
            $data['tr_status'] = $this->input->post('tr_status');
             $this->load->view('include/header');
            $this->load->view('user_table',$data);                
            $this->load->view('include/footer'); 
          }else
          {
             $this->load->view('include/header');
            $this->load->view('user_table');                
            $this->load->view('include/footer'); 
          }

                      
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'dashboard/dashboardTable', 'refresh');
        }
    }

    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
    public function dataTable (){
        is_login();
        $designation = $this->uri->segment(3);
        $user_name = $this->uri->segment(4);
        $tr_status = $this->uri->segment(5);

      $table = 'users';
      $primaryKey = 'users_id';
    $columns = array(
           array( 'db' => 'users_id', 'dt' => 0 ),
       array( 'db' => 'fname', 'dt' => 1 ),
         array( 'db' => 'lname', 'dt' => 2 ),
       array( 'db' => 'ud_name', 'dt' => 3 ),
       array( 'db' => 'rphone', 'dt' => 4 ),
         // array( 'db' => 'users_id', 'dt' => 5 ),
         array( 'db' => 'is_deleted', 'dt' => 5 ),
       array( 'db' => 'users_id', 'dt' => 6 )
    );
    //var_dump($columns);
      // $columns = array(
           // array( 'db' => 'users_id', 'dt' => 0 ),array( 'db' => 'status', 'dt' => 1 ),
          // array( 'db' => 'name', 'dt' => 2 ),
          // array( 'db' => 'email', 'dt' => 3 ),
          // array( 'db' => 'users_id', 'dt' => 4 )
    // );

        $sql_details = array(
      'user' => $this->db->username,
      'pass' => $this->db->password,
      'db'   => $this->db->database,
      'host' => $this->db->hostname
    );

          $from='users';
    $tables[0]['name']='user_designation';
    $tables[0]['col1']='users.designation';
    $tables[0]['col2']='user_designation.ud_id';
 
    //$where = array("user_type != 'admin'");
      $where = "where user_type != 'admin' ";

      // if($designation != 'designation' && $user_name != 'user_name')
      // {
      //   $where .= 'and users.designation = '.$designation.' and users.name LIKE "%'.$user_name.'%" ';
      // }elseif ($designation != 'designation') {
      //   $where .= 'and users.designation = '.$designation.' ';
      // }elseif ($user_name != 'user_name') {
      //    $where .= 'and users.name LIKE "%'.$user_name.'%" ';
      // }else
      // {
        
      // }

      // if($tr_status != 'tr_status')
      // {
      //    $query = $this->db->select('user_id')->from('users_training')->where('tr_status',$tr_status)->get();
      //     if($query->num_rows()>0)
      //     {
      //       $ii = 0;
      //       foreach ($query->result() as $key => $value_data) {
      //         if($ii != 0)
      //         {
      //           $where .= ' or users_id = '.$value_data->user_id.' ';
      //         }
      //         else
      //         {
      //           $where .= ' and users_id = '.$value_data->user_id.' ';
      //         }
      //         $ii++;
      //       }
      //     }
      // }



    $output_arr = SSP::innerJoin($_GET, $sql_details, $from, $tables, $primaryKey, $columns, $where,'fname','ASC');
//    $output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);
    foreach ($output_arr['data'] as $key => $value) {
      $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
      if(CheckPermission('user', "all_update")){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass edt_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
      }else if(CheckPermission('user', "own_update") && (CheckPermission('user', "all_update")!=true)){
        $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
        if($user_id==$this->user_id){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
        }
      }
      
      if(CheckPermission('user', "user")){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonUser1 mClass view_btn"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
      }else if(CheckPermission('user', "user")!=true){
        $user_id =getRowByTableColomId($table,$id,'users_id','users_id');
        if($user_id==$this->user_id){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="modalButtonUser1 mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="View"><i class="fa fa-eye" data-id=""></i></a>';
        }
      }

      if(CheckPermission('user', "user")){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="" target="_blank" href="'.base_url().'/user/get_train_excel/'.$id.'" type="button" data-src="'.$id.'" title="Excel"><i class="fa fa-file-excel-o" data-id=""></i></a>';
      }else if(CheckPermission('user', "user")!=true){
        $user_id =getRowByTableColomId($table,$id,'users_id','users_id');
        if($user_id==$this->user_id){
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnViewRow" class="" target="_blank"  href="'.base_url().'/user/get_train_excel/'.$id.'" type="button" data-src="'.$id.'" title="Excel"><i class="fa fa-file-excel-o" data-id=""></i></a>';
        }
      }
      
      if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){
      if(CheckPermission('user', "all_delete")){
         if($this->session->get_userdata()['user_details'][0]->user_type == 'admin'){ 
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}}
      else if(CheckPermission('user', "own_delete") && (CheckPermission('user', "all_delete")!=true)){
        $user_id =getRowByTableColomId($table,$id,'users_id','user_id');
        if($user_id==$this->user_id){
           if($this->session->get_userdata()['user_details'][0]->user_type == 'admin'){ 
      $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('.$id.', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';}
        }
      }
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
        
        if($output_arr['data'][$key][5])
        {
          $selected = '';
        }
        else
        {
          $selected = 'checked';
        }

            $output_arr['data'][$key][5] = '<input type="checkbox" name="checkdata" '.$selected.' class="user_act" value="'.$id.'">';
      }
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
    public function get_modal() {
        is_login();
        if($this->input->post('id')){
            
      $data['userData'] = getDataByid('users',$this->input->post('id'),'users_id'); 
      $data['alluserData'] = $this->User_model->get_data_by('users');
            echo $this->load->view('add_user', $data, true);
        } else {
          $data['alluserData'] = $this->User_model->get_data_by('users');
            echo $this->load->view('add_user', $data, true);
        }
        exit;
    }

   public function get_modal1() {
        is_login();
        if($this->input->post('id')){
            $data['userData'] = getDataByid('users',$this->input->post('id'),'users_id'); 
      //$data['productData'] = getproductDataByid('products',$this->input->post('id'),'product_id');      
            echo $this->load->view('view_user', $data, true);
        } else {
            echo $this->load->view('view_user', '', true);
        }
        exit;
    }

      public function get_modal_designation() {
        is_login();
        if($this->input->post('id')){
            
      $data['userData'] = getDataByid('user_designation',$this->input->post('id'),'ud_id'); 
            echo $this->load->view('add_designation', $data, true);
        } else {
    
            echo $this->load->view('add_designation', $data, true);
        }
        exit;
    }
    /**
     * This function is used to upload file
     * @return Void
     */
    function upload() {
        foreach($_FILES as $name => $fileInfo)
        {
            $filename=$_FILES[$name]['name'];
            $tmpname=$_FILES[$name]['tmp_name'];
            $exp=explode('.', $filename);
            $ext=end($exp);
            $newname=  $exp[0].'_'.time().".".$ext; 
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] =  base_url().'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000'; 
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname,"assets/images/".$newname);
            return $newname;
        }
    }
  
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id='') {   
        $data = $this->input->post();
    // print_r($_POST);
    // exit();
    $jrequisite = $this->input->post('jrequisite');
    $data['jrequisite'] = implode(',',$jrequisite);
    $lrequisite = $this->input->post('lrequisite');
    $data['lrequisite'] = implode(',',$lrequisite);
    $roles = $this->input->post('roles');
    $data['roles'] = implode(',',$roles);
//    $data['user_type']= "Member";
    unset($data['submit']);
    if($data['password']==''){
        unset($data['password']);
    }
    else{
      $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
      $data['password'] = $password;
    }
      //unset($data['users_id']);
      
        if($this->input->post('users_id')) {
            $id = $this->input->post('users_id');
      unset($data['users_id']);
        }
        if(isset($this->session->userdata ('user_details')[0]->users_id)) {
            if($this->input->post('users_id') == $this->session->userdata ('user_details')[0]->users_id){
                $redirect = 'profile';
            } else {
                $redirect = 'userTable';
            }
        } else {
            $redirect = 'login';
        }
        if($id != '') {
            if(isset($data['edit'])){
                unset($data['edit']);
            }
             
             $tr_topics = $this->input->post('tr_topics');
             $tr_period = $this->input->post('tr_period');
             $tr_basedon = $this->input->post('tr_basedon');
             $tr_date = $this->input->post('tr_date');
              $tr_doneby = $this->input->post('tr_doneby');
              $tr_Status = $this->input->post('tr_Status');
              $tr_comments = $this->input->post('tr_comments');
              $tr_other = $this->input->post('tr_other');
              $tr_id = $this->input->post('tr_id');

              unset($data['tr_topics']);
              unset($data['tr_period']);
              unset($data['tr_basedon']);
              unset($data['tr_date']);
              unset($data['tr_doneby']);
              unset($data['tr_Status']);
              unset($data['tr_comments']);
              unset($data['tr_other']);
              unset($data['tr_id']);


            $this->User_model->updateRow('users', 'users_id', $id, $data);
            $tr_i = 0;
            foreach ($tr_topics as $key => $tr_data) {
              if($tr_id[$tr_i]!='')
              {
                $tr_insert = array(
                  'tr_topic'=>$tr_topics[$tr_i],
                  'tr_period'=>$tr_period[$tr_i],
                  'tr_basedon'=>$tr_basedon[$tr_i],
                  'tr_date'=>$tr_date[$tr_i],
                  'tr_doneby'=>$tr_doneby[$tr_i],
                  'tr_status'=>$tr_Status[$tr_i],
                  'tr_comments'=>$tr_comments[$tr_i],
                  'tr_other'=>$tr_other[$tr_i]
                );
                  $this->User_model->updateRow('users_training', 'tr_id', $tr_id[$tr_i], $tr_insert);
              }
              else
              {
                $tr_insert = array(
                  'user_id'=>$id,
                  'tr_topic'=>$tr_topics[$tr_i],
                  'tr_period'=>$tr_period[$tr_i],
                  'tr_basedon'=>$tr_basedon[$tr_i],
                  'tr_date'=>$tr_date[$tr_i],
                  'tr_doneby'=>$tr_doneby[$tr_i],
                  'tr_status'=>$tr_Status[$tr_i],
                  'tr_comments'=>$tr_comments[$tr_i],
                  'tr_other'=>$tr_other[$tr_i],
                  'created_by'=>$this->session->get_userdata()['user_details'][0]->users_id,
                  'created_on'=>date("y-m-d H:i:s")
                );
                  $this->User_model->insertRow('users_training', $tr_insert);
              }
              $tr_i++;
            }

            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'user/'.$redirect, 'refresh');
        } else{

            $tr_topics = $this->input->post('tr_topics');
             $tr_period = $this->input->post('tr_period');
             $tr_basedon = $this->input->post('tr_basedon');
             $tr_date = $this->input->post('tr_date');
              $tr_doneby = $this->input->post('tr_doneby');
              $tr_Status = $this->input->post('tr_Status');
              $tr_comments = $this->input->post('tr_comments');
              $tr_other = $this->input->post('tr_other');
              $tr_id = $this->input->post('tr_id');

              unset($data['tr_topics']);
              unset($data['tr_period']);
              unset($data['tr_basedon']);
              unset($data['tr_date']);
              unset($data['tr_doneby']);
              unset($data['tr_Status']);
              unset($data['tr_comments']);
              unset($data['tr_other']);
              unset($data['tr_id']);

        $this->User_model->insertRow('users', $data);
        $insert_id = $this->db->insert_id();

          $tr_i = 0;
            foreach ($tr_topics as $key => $tr_data) {
              if($tr_id[$tr_i]!='')
              {
                $tr_insert = array(
                  'tr_topic'=>$tr_topics[$tr_i],
                  'tr_period'=>$tr_period[$tr_i],
                  'tr_basedon'=>$tr_basedon[$tr_i],
                  'tr_date'=>$tr_date[$tr_i],
                  'tr_doneby'=>$tr_doneby[$tr_i],
                  'tr_status'=>$tr_Status[$tr_i],
                  'tr_comments'=>$tr_comments[$tr_i],
                  'tr_other'=>$tr_other[$tr_i]
                );
                  $this->User_model->updateRow('users_training', 'tr_id', $tr_id[$tr_i], $tr_insert);
              }
              else
              {
                $tr_insert = array(
                  'user_id'=>$insert_id,
                  'tr_topic'=>$tr_topics[$tr_i],
                  'tr_period'=>$tr_period[$tr_i],
                  'tr_basedon'=>$tr_basedon[$tr_i],
                  'tr_date'=>$tr_date[$tr_i],
                  'tr_doneby'=>$tr_doneby[$tr_i],
                  'tr_status'=>$tr_Status[$tr_i],
                  'tr_comments'=>$tr_comments[$tr_i],
                  'tr_other'=>$tr_other[$tr_i],
                  'created_by'=>$this->session->get_userdata()['user_details'][0]->users_id,
                  'created_on'=>date("y-m-d H:i:s")
                );
                  $this->User_model->insertRow('users_training', $tr_insert);
              }
              $tr_i++;
            }

                redirect( base_url().'user/'.$redirect, 'refresh');
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
            $this->User_model->delete($id); 
        }
       redirect(base_url().'user/userTable', 'refresh');
    }

    /**
     * This function is used to send invitation mail to users for registration
     * @return Void
     */
    public function InvitePeople() {
        is_login();
      if($this->input->post('emails')){
            $setting = settings();
      $var_key = $this->randomString();
        $emailArray = explode(',', $this->input->post('emails'));
        $emailArray = array_map('trim', $emailArray);
        $body = $this->User_model->get_template('invitation');
            $result['existCount'] = 0;
            $result['seccessCount'] = 0;
            $result['invalidEmailCount'] = 0;
            $result['noTemplate'] = 0;
        if(isset($body->html) && $body->html != '') {
                $body = $body->html;
          foreach ($emailArray as $mailKey => $mailValue) {
            if(filter_var($mailValue, FILTER_VALIDATE_EMAIL)) {
              $res = $this->User_model->get_data_by('users', $mailValue, 'email');
              if(is_array($res) && empty($res)) {
                $link = (string) '<a href="'.base_url().'user/registration?invited='.$var_key.'">Click here</a>';
                $data = array('var_user_email' => $mailValue, 'var_inviation_link' => $link);
                    foreach ($data as $key => $value) {
                      $body = str_replace('{'.$key.'}', $value, $body);
                    }
                            if($setting['mail_setting'] == 'php_mailer') {
                                $this->load->library("send_mail");
                    $emm = $this->send_mail->email('Invitation for registration', $body, $mailValue, $setting);
                            } else {
                                // content-type is required when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
                                $emm = mail($mailValue,'Invitation for registration',$body,$headers);
                            }
                if($emm) {
                  $darr = array('email' => $mailValue, 'var_key' => $var_key);
                  $this->User_model->insertRow('users', $darr);
                  $result['seccessCount'] += 1;;
                }
              } else {
                $result['existCount'] += 1;
              }
            } else {
              $result['invalidEmailCount'] += 1;
            }
          }
        } else {
          $result['noTemplate'] = 'No Email Template Availabale.';
        }
      }
      echo json_encode($result);
      exit;
    }

    /**
     * This function is used to Check invitation code for user registration
     * @return TRUE/FALSE
     */
    public function chekInvitation() {
      if($this->input->post('code') && $this->input->post('code') != '') {
        $res = $this->User_model->get_data_by('users', $this->input->post('code'), 'var_key');
        $result = array();
        if(is_array($res) && !empty($res)) {
          $result['email'] = $res[0]->email;
          $result['users_id'] = $res[0]->users_id;
          $result['result'] = 'success';
        } else {
          $this->session->set_flashdata('messagePr', 'This code is not valid..');
          $result['result'] = 'error';
        }
      }
      echo json_encode($result);
      exit;
    }

    /**
     * This function is used to registr invited user
     * @return Void
     */
    public function register_invited($id){
        $data = $this->input->post();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $password;
        $data['var_key'] = NULL;
        $data['is_deleted'] = 0;
        $data['status'] = 'active';
        $data['user_id'] = 1;
        if(isset($data['password_confirmation'])) {
            unset($data['password_confirmation']);
        }
        if(isset($data['call_from'])) {
            unset($data['call_from']);
        }
        if(isset($data['submit'])) {
            unset($data['submit']);
        }
        $this->User_model->updateRow('users', 'users_id', $id, $data);
        $this->session->set_flashdata('messagePr', 'Successfully Registered..');
        redirect( base_url().'user/login', 'refresh');
    }

    /**
     * This function is used to check email is alredy exist or not
     * @return TRUE/FALSE
     */
    public function checEmailExist() {
        $result = 1;
        $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email');
        if(!empty($res)){
          if($res[0]->users_id != $this->input->post('uId')){
            $result = 0;
          }
        }
        echo $result;
        exit;
    }

    /**
     * This function is used to Generate a token for varification
     * @return String
     */
    public function generate_token(){
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric ;            
        $token = '';  
        $up_lp_char = $alpha . $alpha_upper .$special;
        $chars = str_shuffle($chars);
        $token = substr($chars, 10,10).strtotime("now").substr($up_lp_char, 8,8) ;
        return $token;
    }

    /**
     * This function is used to Generate a random string
     * @return String
     */
    public function randomString(){
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;            
        $pw = '';    
        $chars = str_shuffle($chars);
        $pw = substr($chars, 8,8);
        return $pw;
    }

    public function del_user_training()
    {
      $tr_id = $this->input->post('id');
      $this->db->where('tr_id', $tr_id);  
  $query = $this->db->delete('users_training'); 
    if($query)
    {
      echo '1';
    }
    else
    {
      echo '0';
    }
    }

    public function add_edit_designation()
    {
      //print_r($_POST);
      $data = $this->input->post();
      unset($data['submit']);
      if($data['ud_id'] != '')
      {
         $this->User_model->updateRow('user_designation', 'ud_id', $data['ud_id'], $data);
         $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect( base_url().'user/userTable', 'refresh');
      }
      else
      {
         $this->User_model->insertRow('user_designation', $data);
         $this->session->set_flashdata('messagePr', 'Your data Added Successfully..');
            redirect( base_url().'user/userTable', 'refresh');
      }
    }

    public function delete_des($id)
    {
        $this->db->where('ud_id', $id);  
    $this->db->delete('user_designation'); 
    $this->session->set_flashdata('messagePr', 'Your data Deleted Successfully..');
            redirect( base_url().'user/userTable', 'refresh');
    }

    public function get_train_excel($user_id)
    {
      if (class_exists('PHPExcel')) 
      {
        //echo 'yes';
        //$filepath = base_url()."assets/docs/traineval.xlsx";
        $query = $this->db->select('*')->from('users_training')->where('user_id',$user_id)->get();
        if($query->num_rows()>0)
        {

        $result = $query->result();

        $done_by = '';
        foreach ($result as $key => $for_done_by) {
          // print_r($for_done_by);
        //  echo $for_done_by->tr_doneby;
          $query2 = $this->db->query('select name from users where users_id = '.$for_done_by->tr_doneby.' ');
          $res2 = $query2->row();
         // echo $res2->name;
          $done_by .= $res2->name.' /';
          $done_by1 .= $res2->name.',';
        }
        $done_by = rtrim($done_by, '/');
        $done_by1 = rtrim($done_by1, ',');

         foreach ($result as $key => $f) { 
            $ot .= $f->tr_other.',';
            //$ot1 .= $f->tr_doneby.',';
            $date .= date('d/m/Y',strtotime($f->tr_date)).',';
            $based .=$f->tr_basedon.',';
         }
         $date =rtrim($date,',');
         // $date1 = rtrim($date,',');
         $ot = rtrim($ot,',');
         $ot1 = rtrim($done_by1,',');
         $based = rtrim($based,',');

         
       // echo $done_by;
//exit();
        $objTpl = PHPExcel_IOFactory::load('assets/docs/traineval.xlsx');
$objTpl->getActiveSheet()->setCellValue('C12',stripslashes($ot));
$objTpl->getActiveSheet()->setCellValue('C13',stripslashes($ot1));
        $datadata = "Evaluation done by :   ".$done_by."                                                                                                                          On Date : ".$date."                                                                                                                                                     Based on : ".$based." ";

$objTpl->getActiveSheet()->setCellValue('A3',stripslashes($datadata));
  $objTpl->getActiveSheet()->mergeCells('A3:F3');
$i=1;
$ex = 5;
foreach ($result as $key => $finaldata) {

  $query3 = $this->db->query('select name,designation from users where users_id = '.$finaldata->user_id.' ');
          $res3 = $query3->row();

           $query4 = $this->db->query('select ud_name from user_designation where ud_id = '.$res3->designation.' ');
          $res4 = $query4->row();
  
        $objTpl->getActiveSheet()->setCellValue('A'.$ex,stripslashes($i));
        $objTpl->getActiveSheet()->setCellValue('B'.$ex,stripslashes($res3->name));
        $objTpl->getActiveSheet()->setCellValue('C'.$ex,stripslashes($res4->ud_name));
        $objTpl->getActiveSheet()->setCellValue('D'.$ex,stripslashes($finaldata->tr_topic));
         $objTpl->getActiveSheet()->setCellValue('E'.$ex,stripslashes($finaldata->tr_period));
             $objTpl->getActiveSheet()->setCellValue('F'.$ex,stripslashes($finaldata->tr_comments));

             $i++;
             $ex++;
           }


           


  // /$objTpl->getActiveSheet()->mergeCells('C6:H6');

        header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="TrainingEvaluation.xls"');
header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
        // echo '<pre>';
        // print_r($objTpl);
        // echo '</pre>';
        //  $this->library->myMethod();
      }
      else
      {
         $this->session->set_flashdata('messagePr', 'No Training Record Found..');
            redirect( base_url().'user/userTable', 'refresh');
      }
      }
    }

    public function get_user_eval()
    {
        $user_id = $this->input->post('main_data');
        $main_id = $this->input->post('mainid');

        $query = $this->db->select('*')->from('users_training')->where('user_id',$user_id)->get();
        $finaldata = '';
        if($query->num_rows()>0)
        {
          $res = $query->result();
          foreach ($res as $key => $value) {
            $finaldata .= ' '.$value->tr_topic.' ( '.$value->tr_status.' ) ,';
          }

          $finaldata = rtrim($finaldata, ',');
        }

        $confirm = array(
          'mainid'=>$main_id,
          'data'=>$finaldata
        );
        echo json_encode($confirm);

    }
    public function user_act()
    {
      $user_id = $this->input->post('id');
      $query = $this->db->select('*')->from('users')->where('users_id',$user_id)->get();
      $result = $query->row();
      $check_if_user_active = $result->is_deleted;
      if($check_if_user_active == '0')
      {
        $data['is_deleted'] = 1;
        $this->User_model->updateRow('users', 'users_id', $user_id, $data);
        echo 'deactive';
      }
      else
      {
        $data['is_deleted'] = 0;
        $this->User_model->updateRow('users', 'users_id', $user_id, $data);
        echo 'active';
      }

    }

    
    public function edit_profile()
    {
      // print_r($_POST);
      // print_r($_SESSION);
      // exit();
   $config = [
            'upload_path' => 'assets/images/',
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => 5120,
            'encrypt_name'  =>  true
            ];
          //print_r($config);
            $this->load->library('upload', $config);

            if($this->upload->do_upload('profile_pic'))
             {
              $uploaded_data1 =  $this->upload->data(); 
              @unlink('assets/images/'.$this->input->post('fileOld'));
               if($uploaded_data1['file_name'])
               {
                 $thumbnail = $uploaded_data1['file_name'];
                }
             }
             else
             {
               $thumbnail = $this->input->post('fileOld');
             }
             $data = array();
               $data['profile_pic'] = $thumbnail;
               $data['users_id'] = $this->input->post('users_id');
               if($this->session->userdata('user_details')[0]->user_type == 'admin'){
               $data['status'] = $this->input->post('status');
               $data['name'] = $this->input->post('name');
               $data['email'] = $this->input->post('email');
               
               $currentpassword= $this->input->post('currentpassword');
               if($currentpassword != '' && $this->input->post('password') != '' && $this->input->post('confirmPassword') != ''){
                if (password_verify($currentpassword, $this->session->userdata('user_details')[0]->password)) {       
                    $this->session->set_flashdata('messagePr', 'Current Password Is Wrong..');
              redirect( base_url().'user/profile', 'refresh');      
      }

          if($this->input->post('password') != $this->input->post('confirmPassword')){
            $this->session->set_flashdata('messagePr', 'Confirm Password Dont Match With Password..');
              redirect( base_url().'user/profile', 'refresh');      
          }
          $data['password'] = $this->input->post('confirmPassword');
        }


             }

                  $this->User_model->updateRow('users', 'users_id', $data['users_id'], $data);
               //  print_r($this->db->last_query());
                // / print_r($this->db->last_query());
            $this->session->set_flashdata('messagePr', 'Your Profile updated Successfully..');
              redirect( base_url().'user/profile', 'refresh');

    }

}

