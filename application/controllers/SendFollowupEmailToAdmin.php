<?php defined("BASEPATH") OR exit("No direct script access allowed");
class SendFollowupEmailToAdmin extends CI_Controller { 
    public function __construct() {
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library("pagination");
            
    }
    function send_followup_email_to_admin()
    {
        $this->load->model('Inquiry_model');
        $admin_email = $this->Inquiry_model->get_admin_email_address();
        $to_email = $this->object_to_string($admin_email, $field='email');
        
        
        $data = $this->Inquiry_model->get_lead_follow_data_by();
       
        foreach ($data as $d){
            
            $subject_email = 'Lead | Follow up Reminder Email';
            $msg_email = $d->lead_coperson.', I’m writing to thank you for giving me the opportunity to speak to you on [day]
I have checked with our accounting department/my boss/our warehouse and they would be very happy to arrange special request
Please let me know how you would like to proceed from here

Details:
Contact Person Name: '.$d->lead_coperson.' 
Contact Person Email: '.$d->lead_copersemail.'
Contact Person Phone: '.$d->lead_phone.'
Contact Person Address: '.$d->address1.','.$d->address2.','.$d->landmark.'
    
Regards,
Marco';
            $user_email = $this->Inquiry_model->get_email_id_from_user_id($d->lead_managed_by);
            $to_email = $to_email.",".$this->object_to_string($user_email, $field='email');
            
           
            $this->load->model('SendFollowupEmailToAdmin_model');
            $this->SendFollowupEmailToAdmin_model->send_followup_email($to_email,$subject_email,$msg_email); 
        }
        
        
        $data2 = $this->Inquiry_model->get_inquery_follow_data_by();
        
        foreach ($data2 as $d){
            
            $subject_email = 'Inquiry | Follow up Reminder Email';
            $msg_email = $d->marco_inqrefno.', I’m writing to thank you for giving me the opportunity to speak to you on [day]
I have checked with our accounting department/my boss/our warehouse and they would be very happy to arrange special request
Please let me know how you would like to proceed from here

<b>Details:</b>
Marco Reference No. : '.$d->marco_inqrefno.' 
Inquiry Reference No. : '.$d->inqrefno.'
Client Contact Number : '.$d->client_contact.'
Cellphone Number : '.$d->cellphone_number.'
    
Regards,
Marco';
            $user_email = $this->Inquiry_model->get_email_id_from_user_id($d->user_id);
            $to_email = $to_email.",".$this->object_to_string($user_email, $field='email');
            $this->load->model('SendFollowupEmailToAdmin_model');
            $this->SendFollowupEmailToAdmin_model->send_followup_email($to_email,$subject_email,$msg_email); 
        }
        
        
        
        print_r($to_email);
        
        
   

    }
            
         function object_to_string($objects, $field='name', $glue=', ') {
  $output = array();
  if(!empty($objects) && count($objects) > 0) {
    foreach($objects as $object) {
      if(is_array($object) && isset($object[$field])) {
        $output[] = $object[$field];
      } else  if(is_object($object) && isset($object->$field)) {
        $output[] = $object->$field;
      } else {
        // TODO: homework assignment =)
      }
    }
  }
  return join($glue, $output);
}

}
