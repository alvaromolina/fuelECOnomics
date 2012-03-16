<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Index extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->helper('session_helper');
        $this->load->model('Car_m');
        $this->load->model('Car_m');
        $this->load->model('Data_m');
        
    }
 
    function index($section='problem')
    {
      $years = $this->Car_m->getYears();
      $countries = $this->Data_m->getCountries();
      rsort($years);      
      $data = array('years'=>$years,'countries'=>$countries);
      $this->load->view('index',$data);
    }  

    function fuelPrice()
    {
      $volumeunit = $_POST['volumeunit'];
      $country = $_POST['country'];
      
      $country = $this->Data_m->getCountry($country);
      $data = array('country'=>$country[0],'volumeunit'=>$volumeunit);      
      $this->load->view('countrydata',$data);

    }    

    function routeData()
    {
      $volumeunit = $_POST['volumeunit'];
      $distanceunit = $_POST['distanceunit'];
      $route = $_POST['route'];
      $combined1 = $_POST['combined1'];
      $price = $_POST['price'];
      
      $data = array('route'=>$route,'volumeunit' =>$volumeunit,'distanceunit'=>$distanceunit,'combined1'=>$combined1,'price'=>$price);      
      $this->load->view('routedata',$data);

    }  

    function logout(){
      $fb_data = $this->session->userdata('fb_data');  
      $logoutUrl = "";
      if(isset($fb_data['logoutUrl']) and $fb_data['logoutUrl']!="")
        $logoutUrl = $fb_data['logoutUrl'];
      $this->session->sess_destroy();
      //if($logoutUrl!="")
        //echo $logoutUrl;
      //redirect($logoutUrl,'location');
    }   
    


  }
?>
