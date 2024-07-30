<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->model('inventory_model');
        $userType = $this->session->userdata('user_type');
        if($userType != "Super Admin" && $userType != "Admin" && $userType != "Employee"){
            redirect("/");
        }
    }
	
	// Admin Log Out
	public function admin_log_out() {
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('active_status');
        $this->session->unset_userdata('client_code');
		$this->session->sess_destroy();
        redirect("/", "refresh");
    }

	//Admin Dashboard
	public function index()
	{
        if($this->session->userdata('active_status') == 1)
        {
			$date = date('Y-m-d');
            $data = array();
            $data['main'] = true;
			$data['expire_client'] = $this->inventory_model->get_expired_client_in_one_month($date);
            $data['main_content'] = $this->load->view('home/admin_home_content', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
			redirect('/', 'refresh');
        }
	}

/////Start User Module/////
    
    //password validation
    public function password_check($s)
    {

        $string = str_split($s);
        if (in_array('=', $string) ||in_array('(-)', $string) ||in_array('*', $string) ||in_array('&', $string) ||in_array('^', $string) ||in_array('!', $string) ||in_array('#', $string) || in_array('@', $string ) || in_array('_', $string ) || in_array('$', $string)) {
            return TRUE;
        }else{
            $this->form_validation->set_message('password_check', 'Special Characters (e.g : #, $, @, _) required for strong password!');
            return FALSE;
        }

    }

/////Start vendor package/////
    //package List
    public function package_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['package'] = $this->inventory_model->get_package();
        $data['main_content'] = $this->load->view('home/package_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    // Save package Entry
    public function add_vendor_package()
    {
        $package = array(
            'package_id' => "VPI-".uniqid(),
            'package_name' => $this->input->post('package_name'),
            'package_price' => $this->input->post('package_price'),
            'package_duration' => $this->input->post('package_duration'),
            'package_unit' => "Bill",
            'package_entry_by' => $this->session->userdata('user_id'),
            'package_entry_date' => date('Y-m-d'),
            'package_created_at' => date('Y-m-d H:i:s'),
            'package_status' => 1
        );

        $this->form_validation->set_rules('package_name', 'Package Name', 'required|is_unique[vendor_package.package_name]');
        $this->form_validation->set_rules('package_price', 'Price', 'required');
        $this->form_validation->set_rules('package_duration', 'Duration', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['package'] = $this->inventory_model->get_package();
            $data['main_content'] = $this->load->view('home/package_list', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
                $this->inventory_model->save_package($package);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success '>New Package Created Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("package-list");
            }
    }

    //package edit Form
    public function edit_package($package_id)
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_package_by_id($package_id);
        $data['package'] = $this->inventory_model->get_package();
        $data['main_content'] = $this->load->view('home/package_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    // Update package info
    public function update_vendor_package($package_id)
    {
        $package = array(
            'package_name' => $this->input->post('package_name'),
            'package_price' => $this->input->post('package_price'),
            'package_duration' => $this->input->post('package_duration'),
            'package_updated_by' => ($this->session->userdata('user_id')),
            'package_updated_at' => date('Y-m-d H:i:s'),
        );

        $this->form_validation->set_rules('package_name', 'Package Name', 'required');
        $this->form_validation->set_rules('package_price', 'Price', 'required');
        $this->form_validation->set_rules('package_duration', 'Duration', 'required');

       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = $this->inventory_model->get_package_by_id($package_id);
            $data['package'] = $this->inventory_model->get_package();
            $data['main_content'] = $this->load->view('home/package_list', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
                
                $this->inventory_model->update_package($package, $package_id);
            
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success '> Package Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("package-list");
            }
    }

///////////end vendor package //////////

///////////Start Client //////////
    //Client Entry Form
    public function new_client()
    {
        $data = array();
        $data['main'] = true;
        $data['package'] = $this->inventory_model->get_package();
        $data['main_content'] = $this->load->view('home/client_entry_form', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    // Save Client Entry
    public function save_client()
    {
        $config['upload_path'] = 'uploads/client_logo';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        
        if($_FILES['logo']['name'] != ""){
            if (!$this->upload->do_upload('logo')) {
                        $sdata = array();
                        $sdata['error'] = "<div class='alert alert-error '>Please use a png, jpg or jpeg File. Max File size 2MB.</div>";
                        $this->session->set_userdata($sdata);
                        redirect('/');
                    }else{
            $data_upload_files_other = $this->upload->data();
            $pdata = array('upload_data' => $this->upload->data());
            $logo = "uploads/client_logo/" . $pdata['upload_data']['file_name'];
            } 
        }else{$logo = "";}

        $client_id = "CID-".uniqid();
        $client_code = "CLT-".uniqid();
        $client_name = $this->input->post('client_name');
        $client_email = $this->input->post('client_email');
        $entry_by = $this->session->userdata('user_id');
        $status = 1;
        $password = md5(1234);
        $entry_date = date('Y-m-d');
        $created_at = date('Y-m-d H:i:s');
        
        $client = array(
            'client_id' => $client_id,
            'client_code' => $client_code,
            'client_name' => $client_name,
            'business_name' => $this->input->post('business_name'),
            'client_email' => $this->input->post('client_email'),
            'client_mobile' => $this->input->post('client_mobile'),
            'client_address' => $this->input->post('client_address'),
            'package_id' => $this->input->post('package_id'),
            'registration_date' => $this->input->post('reg_date'),
            'expire_date' => $this->input->post('exp_date'),
            'header_image' => $logo,
            'client_entry_by' => $entry_by,
            'client_entry_date' => $entry_date,
            'client_created_at' => $created_at,
            'client_status' => $status
        );

        $this->form_validation->set_rules('client_name', 'Client Name', 'required');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required');
        $this->form_validation->set_rules('client_mobile', 'Mobile No.', 'required');
        $this->form_validation->set_rules('client_email', 'Email Address', 'valid_email|is_unique[clients.client_email]');
        $this->form_validation->set_rules('reg_date', 'Start Date', 'required');

       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['package'] = $this->inventory_model->get_package();
            $data['main_content'] = $this->load->view('home/client_entry_form', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
            $this->inventory_model->save_client($client);
            $data = array(
                'user_id' => $client_id,
                'client_code' => $client_code,
                'user_name' => $client_name,
                'user_designation' => "Client",
                'user_email' => $client_email,
                'user_password' => $password,
                'user_type' => "Client",
                'user_entry_by' => $entry_by,
                'user_entry_date' => $entry_date,
                'user_created_at' => $created_at,
                'user_status' =>$status    
            );
            $this->inventory_model->insert_user($data);

             // $customer_info = array(
             //        'customer_id' => "CUS-".uniqid(),
             //        'client_id' => $client_code,
             //        'customer_name' => "Walking Customer",
             //        'customer_type' => "Default",
             //        //'customer_mobile' => "",
             //        'customer_created_by' => $entry_by,
             //        'customer_create_date' => $entry_date,
             //        'customer_created_at' => $created_at,
             //        'customer_status' => 1
             //    );
             //    $this->inventory_model->save_customer($customer_info);

            /*  $last_invoice = $this->prescription_model->get_sales_invoice_no();
            if($last_invoice){
                    $bill_no = $last_invoice->bill_no+1;
                }else{
                    $bill_no = 100001;
                }
                $bill_id = "PBI-".uniqid();
                $sales_date = $this->input->post('reg_date');
                $service_rate_info = $this->prescription_model->get_company_service($branch_id, $service_id);
                $service_info = $this->prescription_model->get_service_id($service_id);
                $service_rate = $service_rate_info->company_rate;
                $service_discount = 0;
                
                $invoice_discount = 0;
                $paid_amount = 0;
                $sum = 0;
                $total_discount = 0;

                  $bill_item = array(
                    'bill_item_id' => "BII-".uniqid(),
                    'branch_id' => $branch_id,
                    'patient_id' => $patient_id,
                    'bill_id' => $bill_id,
                    'bill_no' => $bill_no,
                    'service_id' => $service_id,
                    'bill_item_rate' => $service_rate,
                    'bill_item_discount' => $service_discount,
                    'bill_item_date' => $sales_date,
                    'bill_item_entry_by' => $this->session->userdata('user_id'),
                    'bill_item_entry_date' => date('Y-m-d'),
                    'bill_item_created_at' => date('Y-m-d H:i:s'),
                    'bill_item_status' => 1
                    
                );

                $this->prescription_model->add_bill_item($bill_item);
                  
               
                $bill_info = array(
                    'bill_id' => $bill_id,
                    'bill_no' => $bill_no,
                    'branch_id' => $branch_id,
                    'patient_id' => $patient_id,
                    'bill_date' => $sales_date,
                    'bill_amount' => $service_rate,
                    'bill_item_discount' => $total_discount,
                    'bill_discount' => $invoice_discount,
                    'bill_paid' => $paid_amount,
                    'bill_due' => $service_rate,
                    'bill_detail' => $service_info->service_name,
                    'bill_entry_by' => $this->session->userdata('user_id'),
                    'bill_entry_date' => date('Y-m-d'),
                    'bill_created_at' => date('Y-m-d H:i:s'),
                    'bill_status' => 1
                );
                $this->prescription_model->add_bill_invoice($bill_info);

                $payment_info = array(
                    'bill_payment_id' => "BIP-".uniqid(),
                    'bill_id' => $bill_id,
                    'bill_no' => $bill_no,
                    'branch_id' => $branch_id,
                    'patient_id' => $patient_id,
                    'bill_payment_date' => $sales_date,
                    'bill_payment_amount' => $paid_amount,
                    'bill_payment_entry_by' => $this->session->userdata('user_id'),
                    'bill_payment_entry_date' => date('Y-m-d'),
                    'bill_payment_created_at' => date('Y-m-d H:i:s'),
                    'bill_payment_status' => 1
                );
                $this->prescription_model->add_bill_payment($payment_info);*/
            
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>New Client Created Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("client-list");
            }
    }

    //Client List
    public function active_client_list()
    {
        $data = array();
        $data['main'] = true;
        $data['clients'] = $this->inventory_model->get_active_clients();
        $data['main_content'] = $this->load->view('home/active_client_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

	public function expired_client_list()
    {
        $data = array();
        $data['main'] = true;
        $data['clients'] = $this->inventory_model->get_expired_clients();
        $data['main_content'] = $this->load->view('home/expired_client_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    //Client edit Form
    public function edit_client($client_id)
    {
        $data = array();
        $data['main'] = true;
        $data['clients_info'] = $this->inventory_model->get_client_id($client_id);
        $data['package'] = $this->inventory_model->get_package();
        $data['main_content'] = $this->load->view('home/client_edit_form', $data,true);
        $this->load->view('home/admin_home', $data);
    }
    
    // Update Client Info
    public function update_client($client_id)
    {
        $config['upload_path'] = 'uploads/client_logo';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        
        if($_FILES['logo']['name'] != ""){
            if (!$this->upload->do_upload('logo')) {
                        $sdata = array();
                        $sdata['error'] = "<div class='alert alert-error'>Please use a png, jpg or jpeg File. Max File size 2MB.</div>";
                        $this->session->set_userdata($sdata);
                        redirect('/');
                    }else{
            $data_upload_files_other = $this->upload->data();
            $pdata = array('upload_data' => $this->upload->data());
            $logo = "uploads/client_logo/" . $pdata['upload_data']['file_name'];
            unlink( FCPATH . $this->input->post('old_logo'));
            } 
        }else{$logo = $this->input->post('old_logo');}

        //$client_email = ($this->input->post('client_email'));
        $client = array(
            'client_name' => $this->input->post('client_name'),
            'business_name' => $this->input->post('business_name'),
            //'client_email' => $client_email,
            'client_mobile' => $this->input->post('client_mobile'),
            'client_address' => $this->input->post('client_address'),
            'package_id' => $this->input->post('package_id'),
			'registration_date' => $this->input->post('reg_date'),
            'expire_date' => $this->input->post('exp_date'),
            'header_image' => $logo,
            'client_updated_at' => date('Y-m-d H:i:s'),
            'client_updated_by' => $this->session->userdata('user_id')
        );

        $this->form_validation->set_rules('client_name', 'Client Name', 'required');
        $this->form_validation->set_rules('client_email', 'Email Address', 'valid_email');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required');
        $this->form_validation->set_rules('client_mobile', 'Mobile No.', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['package'] = $this->inventory_model->get_package();
            $data['clients_info'] = $this->inventory_model->get_client_id($client_id);
            $data['main_content'] = $this->load->view('home/client_edit_form', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
                $this->inventory_model->update_client($client, $client_id);

                //$user_data['user_email'] = $client_email;
                $user_data['user_name'] = $this->input->post('client_name');
                $this->inventory_model->update_user_id($user_data, $client_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Client Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("edit-client/".$client_id);
            }
        
    }

	//Client reniew Form
    public function reniew_client($client_id)
    {
        $data = array();
        $data['main'] = true;
        $data['clients_info'] = $this->inventory_model->get_client_id($client_id);
        $data['package'] = $this->inventory_model->get_package();
        $data['main_content'] = $this->load->view('home/client_reniew_form', $data,true);
        $this->load->view('home/admin_home', $data);
    }

	// Update reniew client Info
    public function update_reniew_client($client_id)
    {
        redirect("reniew-client/".$client_id);
    }

    //deactivate client status
    public function deactivate_client_id($client_id)
    {
        $user_data['user_status'] = 0;
        $this->inventory_model->update_user_id($user_data, $client_id);
        $client['client_status'] = 0;
        $this->inventory_model->update_client($client, $client_id);
        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success '>Client Deactivated!</div>";
        $this->session->set_userdata($sdata);
        redirect("client-list");
    }

    //activate client status
    public function activate_client_id($client_id)
    {
        $user_data['user_status'] = 1;
        $this->inventory_model->update_user_id($user_data, $client_id);
        $client['client_status'] = 1;
        $this->inventory_model->update_client($client, $client_id);
        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success '>Client Activated!</div>";
        $this->session->set_userdata($sdata);
        redirect("client-list");
    }

    // client password re-set form
    public function reset_client_password($client_id)
        {
            $data = array();
            $data['main'] = true;
            $data['client_info'] = $this->inventory_model->get_client_id($client_id);
            $data['main_content'] = $this->load->view('home/client_password_reset_form', $data,true);
            $this->load->view('home/admin_home', $data);
        }

    //Update client Password
    public function update_client_password()
        {
        $client_id = $this->input->post('client_id');
        $password = md5($this->input->post('password'));
        $repassword = md5($this->input->post('repassword'));
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = ($this->session->userdata('user_id'));
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|callback_password_check');
        $this->form_validation->set_rules('repassword', 'Password Retype', 'trim|required|matches[password]|min_length[6]');
        
            if ($this->form_validation->run() == FALSE)
            {
                $data = array();
                $data['main'] = true;
                $data['client_info'] = $this->inventory_model->get_client_id($client_id);
                $data['main_content'] = $this->load->view('home/client_password_reset_form', $data,true);
                $this->load->view('home/admin_home', $data);
            
            }else{
                $user_data = array(
                'user_password' => $password,
                'user_updated_by' => $updated_by,
                'user_updated_at' => $updated_at
        );
    
                $this->inventory_model->update_user_id($user_data, $client_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Client Password Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("client-list");
        }
    }
   

///////////end Client //////////


//menu List
    public function menu_setup()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['menus'] = $this->inventory_model->get_menu();
        $data['main_content'] = $this->load->view('home/menu_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    // Save menu Entry
    public function menu_entry()
    {

        $this->form_validation->set_rules('menu_name', 'Menue Name', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['menus'] = $this->inventory_model->get_menu();
            $data['main_content'] = $this->load->view('home/menu_list', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{
            $sub =$this->inventory_model->get_sub_menu($this->input->post('parent_menue'));
            $order = count($sub)+1;
            $menu = array(
            'menu_id' => uniqid(),
            'parent_menu_id' => $this->input->post('parent_menue'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_order' => $order,
            'menu_entry_by' => $this->session->userdata('user_id'),
            'menu_entry_date' => date('Y-m-d'),
            'menu_created_at' => date('Y-m-d H:i:s')
        );
            $this->inventory_model->save_menu($menu);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>New Menu Created Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("menu-setup");
            }
    }

    //menu List
    public function edit_menu($menu_id)
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_menu_by_id($menu_id);
        $data['menus'] = $this->inventory_model->get_menu();
        $data['main_content'] = $this->load->view('home/menu_list', $data,true);
        $this->load->view('home/admin_home', $data);
    }

    // Save menu Entry
    public function update_menu($menu_id)
    {

        $this->form_validation->set_rules('menu_name', 'Menue Name', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = $this->inventory_model->get_menu_by_id($menu_id);
            $data['menus'] = $this->inventory_model->get_menu();
            $data['main_content'] = $this->load->view('home/menu_list', $data,true);
            $this->load->view('home/admin_home', $data);
        }else{

            $menu = array(
            'parent_menu_id' => $this->input->post('parent_menue'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_updated_by' => $this->session->userdata('user_id'),
            'menu_updated_at' => date('Y-m-d H:i:s')
        );
            $this->inventory_model->update_menu($menu, $menu_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'> Menu Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("menu-setup");
            }
    }

    public function get_member_type()
    {
        $package_id = $this->input->post('member_type');
        $start_date = $this->input->post('start_date');
        $package = $this->inventory_model->get_package_by_id($package_id);
            
            if($package){
                $duration = $package->package_duration;
                echo date('Y-m-d', strtotime('+'.$duration.' months',  strtotime($start_date)));
            }
    }

    public function get_package_price()
    {
        $package_id = $this->input->post('member_type');
        $package = $this->inventory_model->get_package_by_id($package_id);
            
            if($package){
                $price = $package->package_price;
                echo $price;
            }
    }
}
