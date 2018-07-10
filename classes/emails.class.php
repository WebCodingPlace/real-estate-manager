<?php
/**
* Real Estate Management Main Class - Since 1.0.0
*/

class REM_Emails_Management
{
    
    function __construct(){
        add_action( 'rem_new_agent_register', array($this, 'new_agent_registered' ), 10, 1 );
        add_action( 'rem_new_agent_approved', array($this, 'new_agent_approved' ), 10, 1 );
        add_action( 'rem_new_agent_rejected', array($this, 'new_agent_rejected' ), 10, 1 );
        add_action( 'rem_new_property_submitted', array($this, 'new_property_submitted' ), 10, 1 );
        add_action( 'rem_new_property_approved', array($this, 'new_property_approved' ), 10, 1 );
    }

    function send_email($to, $subject, $message){
        $site_title = get_bloginfo();
        $admin_email = get_bloginfo('admin_email');

        $from_title = apply_filters( 'rem_email_sender_title', $site_title );
        $from_email = apply_filters( 'rem_email_sender_email', $site_title );

        $headers = array();
        $headers[] = "From: {$from_title} <{$from_email}>";
        $headers[] = "Content-Type: text/html";
        $headers[] = "MIME-Version: 1.0\r\n";
    	
    	wp_mail( $to, $subject, $message, $headers );
    }

    function new_agent_registered($new_agent){
        $site_title = get_bloginfo();
        // Sending Email to Admin
        $admin_email = get_bloginfo('admin_email');
        $subject = __( 'New Agent Registered ', 'real-estate-manager' ). $site_title;
        $message = (rem_get_option('email_admin_register_agent') != '') ? rem_get_option('email_admin_register_agent') : 'New agent is registered...' ;

        $message = str_replace("%first_name%", $new_agent['first_name'], $message);
        $message = str_replace("%last_name%", $new_agent['last_name'], $message);
        $message = str_replace("%username%", $new_agent['username'], $message);
        $message = str_replace("%email%", $new_agent['useremail'], $message);

        $this->send_email($admin_email, $subject, $message);

        // Sending Email to Agent
        $subject_agent = __( 'Registration Successfull ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_pending_agent') != '') ? rem_get_option('email_pending_agent') : 'Please wait for approval' ;
        
        $message_for_agent = str_replace("%first_name%", $new_agent['first_name'], $message_for_agent);
        $message_for_agent = str_replace("%last_name%", $new_agent['last_name'], $message_for_agent);
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        $this->send_email($new_agent['useremail'], $subject_agent, $message_for_agent);
    }

    function new_agent_approved($new_agent){

        $site_title = get_bloginfo();
        
        $subject = __( 'Approved ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_approved_agent') != '') ? rem_get_option('email_approved_agent') : 'You are Approved' ;
        
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%first_name%", $new_agent['first_name'], $message_for_agent);
        $message_for_agent = str_replace("%last_name%", $new_agent['last_name'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        $this->send_email($new_agent['useremail'], $subject, $message_for_agent);
    }

    function new_agent_rejected($new_agent){

        $site_title = get_bloginfo();

        $subject = __( 'Rejected ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_reject_agent') != '') ? rem_get_option('email_reject_agent') : 'You are Approved' ;
        
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%first_name%", $new_agent['first_name'], $message_for_agent);
        $message_for_agent = str_replace("%last_name%", $new_agent['last_name'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        $this->send_email($new_agent['useremail'], $subject, $message_for_agent);
    }

    function new_property_submitted($property){

        $site_title = get_bloginfo();

        $current_user_data = wp_get_current_user();

        $approve_url = admin_url( 'edit.php?post_status=pending&post_type=rem_property' );

        $admin_email = get_bloginfo('admin_email');
        
        $subject = __( 'New Property Submitted ', 'real-estate-manager' ). $site_title;
        $message = (rem_get_option('email_property_submission') != '') ? rem_get_option('email_property_submission') : 'New Property is created. Approve here '.$approve_url ;
        $message = str_replace("%username%", $current_user_data->user_login, $message);
        $message = str_replace("%email%", $current_user_data->user_email, $message);
        $message = str_replace("%approve_url%", $approve_url, $message);

        $subject_agent = __( 'Property Submitted ', 'real-estate-manager' ). $site_title;
        $this->send_email($admin_email, $subject, $message);

        $message_agent = (rem_get_option('email_property_submission_agent') != '') ? rem_get_option('email_property_submission_agent') : 'New Property is submitted. Please wait until admin approves.' ;
        $this->send_email($current_user_data->user_email, $subject_agent, $message_agent);
    }

    function new_property_approved($property){
        $site_title = get_bloginfo();
        
        $agent_id = $property->post_author;
        $agent_info = get_userdata($agent_id);
        $agent_email = $agent_info->user_email;
        $subject_agent = __( 'Property Approved ', 'real-estate-manager' ). $site_title;

        $message_agent = (rem_get_option('email_property_approved_agent') != '') ? rem_get_option('email_property_approved_agent') : 'Your Property is approved.' ;
        $this->send_email($agent_email, $subject_agent, $message_agent);
    }

}
?>