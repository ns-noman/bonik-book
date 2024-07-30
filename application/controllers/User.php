<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  
  public function __construct()
    {
        parent::__construct();
    
    $this->load->model('inventory_model');
    }
  
  
  //User Page
  public function index()
  {
      $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/front_end_content', $data,true);
        $this->load->view('home/front_end', $data);
  }
  
  
  


    
}
