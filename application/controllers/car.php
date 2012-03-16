<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Car extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->helper('session_helper');
        $this->load->model('Car_m');
    }
 
    function getMakes($year)
    {
      $makes = $this->Car_m->getMakes($year);
      $makes = $makes['values'];
      sort($makes);
      echo '<option value="">Select make</option>';
      foreach($makes as $make){
        echo '<option value="'.$make.'">'.$make.'</option>';
      }
    }    

    function getModels($year)
    {
      $make = $_POST['make'];
      $models = $this->Car_m->getModels($year,$make);
      sort($models);
      echo '<option value="">Select model</option>';
      foreach($models as $model){
        echo '<option value="'.$model['_id'].'">'.$model['model'].'-'.$model['description'].'</option>';
      }
    }   
    
    function showCar($num,$model)
    {
      $distanceunit = $_POST['distanceunit'];
      $volumeunit = $_POST['volumeunit'];     
      if( isset( $_POST['price']))
        $price = $_POST['price'];
      else 
        $price = 0;
      $model = $this->Car_m->getModel($model);
      $data = array('num'=>$num,'model'=>$model,'distanceunit'=>$distanceunit,'volumeunit'=>$volumeunit,'price'=>$price);      
      $this->load->view('car',$data);
    } 

    function compareCar()
    {
      $years = $this->Car_m->getYears();
      rsort($years);      
      $data = array('years'=>$years);
      $this->load->view('comparecar',$data);
    } 

  }
?>
