<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model');

        $userType = $this->session->userdata('user_type');
        if($userType == "Super Admin"){
            redirect("admin");
        }elseif($userType == "Admin"){
            redirect("admin");
        }elseif($userType == "Client"){
            redirect("client");
        }elseif($userType == "User"){
            redirect("client");
        }

    }

    public function index()
    {
        $data = array();
        $one = rand(0,9);
        $two = rand(0,9);
        $data['one'] = $one;
        $data['two'] = $two;
        $data['result'] = $one+$two;
        $data['word'] =$this->numbertowordconvertsconver->convert_number($one);
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/login_content', $data,true);
        $this->load->view('home/landing_page', $data);
    }

    public function user_access()
    {
        $username = trim($this->input->post('username'));
        $password = md5($this->input->post('password'));
        $numresult = $this->input->post('numresult');
        $cap = $this->input->post('cap');

        if($username && $password && $cap){

            $result = $this->inventory_model->check_user_exist($username);
            if($result){
                $user = $this->inventory_model->check_user_login($username, $password);
                if($user){
                    if($user->user_status == 1){
                        if($numresult == $cap){
                        $sdata = array();
                        $sdata['user_name'] = $user->user_name;
                        $sdata['user_id'] = $user->user_id;
                        $sdata['user_email'] = $user->user_email;
                        $sdata['user_type'] = $user->user_type;
                        $sdata['active_status'] = $user->user_status;
                        $sdata['client_code'] = $user->client_code;
                        $this->session->set_userdata($sdata);

                        $userType = $this->session->userdata('user_type');
                        if($userType == "Super Admin"){
                            redirect("admin");
                        }elseif($userType == "Admin"){
                            redirect("admin");
                        }elseif($userType == "Client"){
                            redirect("client");
                        }elseif($userType == "User"){
                            redirect("client");
                        }

                    }else{
                    $sdata = array();
                    $sdata['error_message'] = "<div class='alert alert-danger'>Answer is not Correct! Try again.</div>";
                    $this->session->set_userdata($sdata);
                    redirect("login");
                }
                    }else{
                        $sdata = array();
                        $sdata['error_message'] = "<div class='alert alert-danger'>Your account isn't Valid. Call help line.</div>";
                        $this->session->set_userdata($sdata);
                        redirect("login");
                    }
                }
                else{
                    $sdata = array();
                    $sdata['error_message'] = "<div class='alert alert-danger'>Your Username or Password not matched! Try again.</div>";
                    $this->session->set_userdata($sdata);
                    redirect("login");
                }

            }
            else{
                $sdata = array();
                $sdata['error_message'] = "<div class='alert alert-danger'>Sorry! You are not Registered or not approve yet. Call help line.</div>";
                $this->session->set_userdata($sdata);
                redirect("login");
            }
        }
        else{
            $sdata = array();
            $sdata['error_message'] = "<div class='alert alert-danger'>Please insert all information correctly!</div>";
            $this->session->set_userdata($sdata);
            redirect("login");
        }


    }

/////////Start stock//////////// 
//daily stock
    public function daily_stock_history()
    {
        $data = array();
        $data['main'] = true;
        $date = date('Y-m-d');
        $stock_info = $this->inventory_model->get_all_stock_info();
        if ($stock_info) {
        foreach ($stock_info as $stock) {
           $stock_info = array(
                'stock_history_id' => "SHI-".uniqid(),
                'product_id' => $stock->product_id,
                'stk_client_id' => $stock->client_id,
                'stock_qty' => $stock->product_stock,
                'stock_unit_price' => $stock->product_unit_price,
                //'stock_history_date' => date('Y-m-d',strtotime("-1 days")),
                'stock_history_date' => date('Y-m-d'),
                'stock_history_entry_date' => date('Y-m-d H:i:s'),
                'stock_history_created_at' => date('Y-m-d H:i:s'),
                'stock_history_status' => 1
            );
            $this->inventory_model->add_stock_histoy($stock_info);
        }
    }
        exit();


    }     
/////////End stock////////////


   

} 