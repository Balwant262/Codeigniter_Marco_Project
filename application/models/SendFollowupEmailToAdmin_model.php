<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

class SendFollowupEmailToAdmin_model extends CI_Model 
{    	
    function send_followup_email($to_email,$subject_email,$msg_email)
    {
        // send email
        mail($to_email,$subject_email,$msg_email);			
    }
}
