<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');

    function getUserId()
    {	
      $CI = & get_instance();
      $uid = $CI->session->userdata('uid'); 
      return $uid;
    }

    function isFacebookUser(){
      $CI = & get_instance();      
      $fb_data = $CI->session->userdata('fb_data');
      if($fb_data['uid'])
        return true;
      else
        return false;
    } 

    function getUserName(){
      $CI = & get_instance();      
      $name = $CI->session->userdata('name');
      return $name;
    }    
   



?>
