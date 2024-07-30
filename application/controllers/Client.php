<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('inventory_model');
        $userType = $this->session->userdata('user_type');
        if($userType != "Super Admin" && $userType != "Admin" && $userType != "Client" && $userType != "User"){
            redirect("/");
        }
    }

    public function index()
    {
        $date = date('Y-m-d');
        //$data = array();
       // $data['main'] = true;
        $data = $this->cash_flow_statement_report($date);
        $client_id = ($this->session->userdata('client_code'));
        $purchase = $this->inventory_model->get_purchase_total($date);
        $cash_purchase = $this->inventory_model->get_cash_purchase_total($date);
        $sales = $this->inventory_model->get_sales_total($date);
        $cash_sales = $this->inventory_model->get_cash_sales_total($date);
        $purchase_payment = $this->inventory_model->get_purchase_payment_total($date);
        $sales_collection = $this->inventory_model->get_sales_collection_total($date);
        //$customer_payment = $this->inventory_model->get_customer_collection_total($date);
        //$supplier_payment = $this->inventory_model->get_supplier_payment_total($date);

        $supplier_due_payment = $this->inventory_model->supplier_due_payment($date);
        $customer_due_payment = $this->inventory_model->customer_due_payment($date);
        //$expense = $this->inventory_model->get_expense_total($date);
        $expense = $this->inventory_model->get_expense_total_cash($date);

        $purchase_total = $purchase->purchase_total_amount-($purchase->purchase_invoice_discount+$purchase->purchase_total_discount+$purchase->purchase_invoice_return_total);
        $purchase_payment = $purchase_payment->purchase_payment_amount-$purchase->purchase_invoice_return_amount;
        $data['purchase_total'] = $purchase_total;
        //$data['purchase_due'] = $purchase_total-$purchase_payment-$purchase->purchase_advance_payment;
        $data['purchase_due'] = $purchase_total-$purchase->purchase_amount_paid-$purchase->purchase_advance_payment;
        $data['purchase_payment'] = $purchase_payment;

        $sales_total = $sales->sales_total_amount+$sales->sales_total_vat-($sales->sales_invoice_discount+$sales->sales_total_discount+$sales->sales_invoice_return_total);
        $sales_collection = $sales_collection->sales_payment_amount-$sales->sales_invoice_return_amount;
        $data['sales_total'] = $sales_total;
        //$data['sales_due'] = $sales_total-$sales_collection-$sales->sales_advance_payment;
        $data['sales_due'] = $sales_total-$sales->sales_amount_paid-$sales->sales_advance_payment;
        $data['sales_collection'] = $sales_collection;

        $data['total_expense'] = $expense->expense_transaction_amount;
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['low_stock'] = $this->inventory_model->get_low_stock();
        $data['cash_sales'] = $cash_sales->sales_amount_paid-$cash_sales->sales_invoice_return_amount;
        $data['cash_purchase'] = $cash_purchase->purchase_amount_paid-$cash_purchase->purchase_invoice_return_amount;
        //$data['customer_payment'] = $customer_payment->customer_payment_amount;
        //$data['supplier_payment'] = $supplier_payment->supplier_payment_amount;
        $data['customer_payment'] = $customer_due_payment->sales_payment_amount;
        $data['supplier_payment'] = $supplier_due_payment->purchase_payment_amount;


        $data['chart'] = $this->chart($date);

        $data['main_content'] = $this->load->view('home/client_home_content', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //chart
    public function chart($date)
    {
        $previous_seventh_day = date("Y-m-d", strtotime(' -6 day', strtotime($date)));
        $statement = array();
        $statement['statement_title_one'] = 'Sales & Purchase of Last Seven Days('.date("d/m/Y", strtotime($previous_seventh_day)).' to '.date("d/m/Y", strtotime($date));
        $statement['statement_title_three'] = 'Collection Payment of Last Seven Days('.date("d/m/Y", strtotime($previous_seventh_day)).' to '.date("d/m/Y", strtotime($date));

        for($i=0; $i<=6; $i++)
        {
            $repeat = strtotime("+$i day",strtotime($previous_seventh_day));
            $statement['visit_label'][] = date('d/m',$repeat);
            $revenue_date =  date('Y-m-d',$repeat);
            $sales_today = $this->inventory_model->datewise_sales($revenue_date);
            $purchase_today = $this->inventory_model->datewise_purchase($revenue_date);
            if ($sales_today) {
                $sales_total = $sales_today->sales_total_amount+$sales_today->sales_total_vat-($sales_today->sales_invoice_discount+$sales_today->sales_total_discount)-$sales_today->sales_invoice_return_total;
                $statement['sales_total'][] = number_format((float)$sales_total, 2, '.', '');
            }else{
                $statement['sales_total'][] = 0.00;
            }

            if ($purchase_today) {
                 $purchase_total = $purchase_today->purchase_total_amount-($purchase_today->purchase_invoice_discount+$purchase_today->purchase_total_discount)-$purchase_today->purchase_invoice_return_total;
                $statement['purchase_total'][] = number_format((float)$purchase_total, 2, '.', '');
            }else{
                $statement['purchase_total'][] = 0.00;
            }

            $collection_today = $this->inventory_model->datewise_collection($revenue_date);
            $payment_today = $this->inventory_model->datewise_payment($revenue_date);
            if ($collection_today) {
                $statement['customer_collection'][] = number_format((float)$collection_today->customer_payment_amount, 2, '.', '');
            }else{
                $statement['customer_collection'][] = 0.00;
            }

            if ($payment_today) {
                $statement['supplier_payment'][] = number_format((float)$payment_today->supplier_payment_amount, 2, '.', '');
            }else{
                $statement['supplier_payment'][] = 0.00;
            }

        }

        $statement['statement_title_two'] = 'Total Sales of Last 6 Month';
        for ($m = 0; $m < 6; $m++) {
            $month =  date('F', strtotime("-$m month"));
            $first_day =  date('Y-m-1', strtotime("-$m month"));
            $last_day =  date('Y-m-t', strtotime("-$m month"));
            //$first_day = date('Y-'.$month.'-01');
            //$last_day = date('Y-'.$month.'-t');
             $statement['month_label'][] = $month;
            $monthly_sales = $this->inventory_model->sales_by_daterange($first_day, $last_day); 

            if ($monthly_sales) {
                $monthly_sales_amount = $monthly_sales->sales_total_amount+$monthly_sales->sales_total_vat-($monthly_sales->sales_invoice_discount+$monthly_sales->sales_total_discount)-$monthly_sales->sales_invoice_return_total;
                $statement['monthly_sales_amount'][] =  number_format((float)$monthly_sales_amount, 2, '.', '');

               
            }else{
                $statement['monthly_sales_amount'][] = 0.00;
            }

            }
        

        $fdata = json_encode($statement);
        return $fdata;
    }

    // client Log Out
    public function client_log_out() {
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('active_status');
        $this->session->unset_userdata('client_code');
        $this->session->sess_destroy();
        redirect("/", "refresh");
    }

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

    //barcode validation
    public function barcode_check($b)
    {
        $code = $this->inventory_model->check_barcode($b);
         if ($b !== "" && $code) {   
            $this->form_validation->set_message('barcode_check', 'Barcode Must be Unique.');
            return FALSE;
        }else{
            
            return TRUE; 
        }

    }

    // User password re-set form
    public function client_password($user_id)
        {
            $data = array();
            $data['main'] = true;
            $data['update_user'] = $this->inventory_model->show_user_by_id($user_id);
            $data['main_content'] = $this->load->view('home/client_password_update_form', $data,true);
            $this->load->view('home/client_home', $data);
        }
        
//Update User Password
    public function update_client_password ($user_id)
    {
        $password = md5($this->input->post('password'));
        $repassword = md5($this->input->post('repassword'));
        $updated_at = date('Y-m-d H:i:s');
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|callback_password_check');
        $this->form_validation->set_rules('repassword', 'Password Retype', 'trim|required|matches[password]|min_length[6]');
        
            if ($this->form_validation->run() == FALSE)
            {
                $data = array();
                $data['main'] = true;
                $data['update_user'] = $this->inventory_model->show_user_by_id($user_id);
                $data['main_content'] = $this->load->view('home/client_password_update_form', $data,true);
                $this->load->view('home/client_home', $data); 
            
            }else{
                $user_data = array(
                'user_password' => $password,
                'user_updated_at' => $updated_at,
                'user_updated_by' => $this->session->userdata('user_id')
            );
    
                $this->inventory_model->update_user_id($user_data, $user_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>User Password Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("/");
        }
    }

///////////Start Manufacturer //////////
    //manufacturar List
    public function manufacturer_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
        $data['main_content'] = $this->load->view('home/manufacturer_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save Manufacturar Entry
    public function save_manufacturer()
    {
        $manufacturer_info = array(
            'man_id' => "MAN-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'man_name' => $this->input->post('man_name'),
            'man_email' => $this->input->post('man_email'),
            'man_mobile' => $this->input->post('man_mobile'),
            'man_address' => $this->input->post('man_address'),
            'man_entry_by' => $this->session->userdata('user_id'),
            'man_entry_date' => date('Y-m-d'),
            'man_created_at' => date('Y-m-d H:i:s'),
            'man_status' => 1
        );

        $this->form_validation->set_rules('man_name', 'Name', 'required');
        $this->form_validation->set_rules('man_email', 'Email Address', 'valid_email');
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['main_content'] = $this->load->view('home/manufacturer_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_manufacturer($manufacturer_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Manufacturer Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("manufacturer-list");
            }
    }

    

    //Client edit Form
    public function edit_manufacturer($man_id)
    {
        $data = array();
        $data['main'] = true;
        $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
        $data['edit_info'] = $this->inventory_model->get_manufacturer_by_id($man_id);
        $data['main_content'] = $this->load->view('home/manufacturer_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update Manufacturar Entry
    public function update_manufacturer($man_id)
    {
        $manufacturer_info = array(
            'man_name' => $this->input->post('man_name'),
            'man_email' => $this->input->post('man_email'),
            'man_mobile' => $this->input->post('man_mobile'),
            'man_address' => $this->input->post('man_address'),
            'man_updated_by' => $this->session->userdata('user_id'),
            'man_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('man_name', 'Name', 'required');
        $this->form_validation->set_rules('man_email', 'Email Address', 'valid_email');
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['edit_info'] = $this->inventory_model->get_manufacturer_by_id($man_id);
            $data['main_content'] = $this->load->view('home/manufacturer_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_manufacturer($manufacturer_info, $man_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Manufacturer Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("manufacturer-list");
            }
    }

///////////End manufacturar //////////

///////////Start supplier //////////

    //supplier List
    public function supplier_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['supplier_info'] = $this->inventory_model->get_supplier();
        $data['main_content'] = $this->load->view('home/supplier_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //supplier List
    public function new_supplier()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['main_content'] = $this->load->view('home/supplier_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save supplier Entry
    public function save_supplier()
    {
        $supplier_info = array(
            'supplier_id' => "MAN-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'supplier_name' => $this->input->post('supplier_name'),
            'supplier_org' => $this->input->post('supplier_org'),
            'supplier_email' => $this->input->post('supplier_email'),
            'supplier_mobile' => $this->input->post('supplier_mobile'),
            'supplier_address' => $this->input->post('supplier_address'),
            //'supplier_balance' => $this->input->post('supplier_balance'),
            'supplier_entry_by' => $this->session->userdata('user_id'),
            'supplier_entry_date' => date('Y-m-d'),
            'supplier_created_at' => date('Y-m-d H:i:s'),
            'supplier_status' => 1
        );

        $this->form_validation->set_rules('supplier_name', 'Name', 'required');
        $this->form_validation->set_rules('supplier_org', 'Organization', 'required');
        $this->form_validation->set_rules('supplier_mobile', 'Mobile No.', 'required');
        $this->form_validation->set_rules('supplier_email', 'Email Address', 'valid_email');
       
        if ($this->form_validation->run() == FALSE)
        {
           $this->new_supplier();
        }else{
            $this->inventory_model->save_supplier($supplier_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New supplier Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("supplier-list");
            }
    }

  

    //supplier edit Form
    public function edit_supplier($supplier_id)
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_supplier_by_id($supplier_id);
        $data['main_content'] = $this->load->view('home/supplier_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update supplier Entry
    public function update_supplier($supplier_id)
    {
        $supplier_info = array(
            'supplier_name' => $this->input->post('supplier_name'),
            'supplier_org' => $this->input->post('supplier_org'),
            'supplier_email' => $this->input->post('supplier_email'),
            'supplier_mobile' => $this->input->post('supplier_mobile'),
            'supplier_address' => $this->input->post('supplier_address'),
            'supplier_updated_by' => $this->session->userdata('user_id'),
            'supplier_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('supplier_name', 'Name', 'required');
        $this->form_validation->set_rules('supplier_email', 'Email Address', 'valid_email');
        $this->form_validation->set_rules('supplier_org', 'Organization', 'required');
        $this->form_validation->set_rules('supplier_mobile', 'Mobile No.', 'required');
       
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_supplier($supplier_id);
        }else{
            $this->inventory_model->update_supplier($supplier_info, $supplier_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Supplier Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("supplier-list");
            }
    }

///////////End supplier //////////

///////////Start customer //////////
     //customer List
    public function customer_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['customer_info'] = $this->inventory_model->get_customer();
        $data['main_content'] = $this->load->view('home/customer_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //walking customer List
    public function walking_customer_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['customer_info'] = $this->inventory_model->get_walking_customer();
        $data['main_content'] = $this->load->view('home/walking_customer_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

     //customer List
    public function new_customer()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['main_content'] = $this->load->view('home/customer_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }


    // Save customer Entry
    public function save_customer()
    {
        $customer_info = array(
            'customer_id' => "CUS-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'customer_name' => $this->input->post('customer_name'),
            'customer_organization' => $this->input->post('customer_organization'),
            'customer_email' => $this->input->post('customer_email'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'customer_address' => $this->input->post('customer_address'),
            'customer_created_by' => $this->session->userdata('user_id'),
            'customer_create_date' => date('Y-m-d'),
            'customer_created_at' => date('Y-m-d H:i:s'),
            'customer_status' => 1
        );

        $this->form_validation->set_rules('customer_name', 'Name', 'required');
        $this->form_validation->set_rules('customer_organization', 'Organization', 'required');
        $this->form_validation->set_rules('customer_mobile', 'Mobile', 'required|is_unique[setup_customers.customer_mobile]');
        $this->form_validation->set_rules('customer_email', 'Email Address', 'valid_email');
       
        if ($this->form_validation->run() == FALSE)
        {
            $this->new_customer();
        }else{
            $this->inventory_model->save_customer($customer_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New customer Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("customer-list");
            }
    }

  

    //customer edit Form
    public function edit_customer($customer_id)
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_customer_by_id($customer_id);
        $data['main_content'] = $this->load->view('home/customer_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update customer Entry
    public function update_customer($customer_id)
    {
        $customer_info = array(
            'customer_name' => $this->input->post('customer_name'),
            'customer_organization' => $this->input->post('customer_organization'),
            'customer_email' => $this->input->post('customer_email'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'customer_address' => $this->input->post('customer_address'),
            'customer_updated_by' => $this->session->userdata('user_id'),
            'customer_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('customer_name', 'Name', 'required');
        $this->form_validation->set_rules('customer_email', 'Email Address', 'valid_email');
        $this->form_validation->set_rules('customer_organization', 'Organization', 'required');
        $this->form_validation->set_rules('customer_mobile', 'Mobile', 'required');
       
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_customer($customer_id);
        }else{
            $this->inventory_model->update_customer($customer_info, $customer_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> customer Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("customer-list");
            }
    }

///////////End customer //////////

///////////Start location //////////
     //location List
    public function location_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['location_info'] = $this->inventory_model->get_location();
        $data['main_content'] = $this->load->view('home/location_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save location Entry
    public function save_location()
    {
        $location_info = array(
            'location_id' => "BAR-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'location_name' => $this->input->post('location_name'),
            'location_entry_by' => $this->session->userdata('user_id'),
            'location_entry_date' => date('Y-m-d'),
            'location_created_at' => date('Y-m-d H:i:s'),
            'location_status' => 1
        );

        $this->form_validation->set_rules('location_name', 'location', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['location_info'] = $this->inventory_model->get_location();
            $data['main_content'] = $this->load->view('home/location_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_location($location_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New location Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("location-list");
            }
    }

  

    //location edit Form
    public function edit_location($location_id)
    {
        $data = array();
        $data['main'] = true;
        $data['location_info'] = $this->inventory_model->get_location();
        $data['edit_info'] = $this->inventory_model->get_location_by_id($location_id);
        $data['main_content'] = $this->load->view('home/location_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update location Entry
    public function update_location($location_id)
    {
        $location_info = array(
            'location_name' => $this->input->post('location_name'),
            'location_updated_by' => $this->session->userdata('user_id'),
            'location_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('location_name', 'location', 'required');
       
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
           $data['location_info'] = $this->inventory_model->get_location();
            $data['edit_info'] = $this->inventory_model->get_location_by_id($location_id);
            $data['main_content'] = $this->load->view('home/location_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_location($location_info, $location_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> location Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("location-list");
            }
    }

///////////End location //////////

///////////Start expense type //////////
     //expense type List
    public function expense_type_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['expense_type_info'] = $this->inventory_model->get_expense_type();
        $data['main_content'] = $this->load->view('home/expense_type_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save expense type Entry
    public function save_expense_type()
    {
        $expense_type_info = array(
            'expense_type_id' => "BAR-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'expense_type_name' => $this->input->post('expense_type_name'),
            'expense_type_entry_by' => $this->session->userdata('user_id'),
            'expense_type_entry_by' => date('Y-m-d'),
            'expense_type_created_at' => date('Y-m-d H:i:s'),
            'expense_type_status' => 1
        );

        $this->form_validation->set_rules('expense_type_name', 'Expense Type', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['expense_type_info'] = $this->inventory_model->get_expense_type();
            $data['main_content'] = $this->load->view('home/expense_type_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_expense_type($expense_type_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("expense-type-list");
            }
    }

  

    //expense type edit Form
    public function edit_expense_type($expense_type_id)
    {
        $data = array();
        $data['main'] = true;
        $data['expense_type_info'] = $this->inventory_model->get_expense_type();
        $data['edit_info'] = $this->inventory_model->get_expense_type_by_id($expense_type_id);
        $data['main_content'] = $this->load->view('home/expense_type_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update expense_type Entry
    public function update_expense_type($expense_type_id)
    {
        $expense_type_info = array(
            'expense_type_name' => $this->input->post('expense_type_name'),
            'expense_type_updated_by' => $this->session->userdata('user_id'),
            'expense_type_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('expense_type_name', 'Expense Type', 'required');
       
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
           $data['expense_type_info'] = $this->inventory_model->get_expense_type();
            $data['edit_info'] = $this->inventory_model->get_expense_type_by_id($expense_type_id);
            $data['main_content'] = $this->load->view('home/expense_type_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_expense_type($expense_type_info, $expense_type_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Entry Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("expense-type-list");
            }
    }


    //expense ledger form
    public function expense_ledger_form()
    {
        $data = array();
        $data['main'] = true;
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $client_id = $this->session->userdata('client_code');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['expense_ledger'] = $this->inventory_model->get_expense_ledger_by_date($from_date, $to_date);
        $data['main_content'] = $this->load->view('home/report_expense_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //ledger report
    public function datewise_expense_ledger_report()
    {
        $data = array();
        $data['main'] = true;
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $expense = $this->input->post('expense');
        $name_mobile = $this->input->post('name_mobile');
        $client_id = $this->session->userdata('client_code');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        if ($expense) {
            $data['expense_ledger'] = $this->inventory_model->get_expense_ledger_by_head($from_date, $to_date, $expense);

        }else if ($name_mobile){
           $data['expense_ledger'] = $this->inventory_model->get_expense_ledger_by_name($from_date, $to_date, $name_mobile); 
        }else{
           $data['expense_ledger'] = $this->inventory_model->get_expense_ledger_by_date($from_date, $to_date); 
        }
        
    
        $data['main_content'] = $this->load->view('home/report_expense_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }



///////////End expense type //////////

///////////Start expense head //////////
    //expense head List
    public function expense_head_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['main_content'] = $this->load->view('home/expense_head_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save expense head Entry
    public function save_expense_head()
    {
        $expense_head_info = array(
            'expense_head_id' => "BAR-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'expense_head_name' => $this->input->post('expense_head_name'),
            'expense_head_entry_by' => $this->session->userdata('user_id'),
            'expense_head_entry_date' => date('Y-m-d'),
            'expense_head_created_at' => date('Y-m-d H:i:s'),
            'expense_head_status' => 1
        );

        $this->form_validation->set_rules('expense_head_name', 'Expense Head', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['expense_head_info'] = $this->inventory_model->get_expense_head();
            $data['main_content'] = $this->load->view('home/expense_head_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_expense_head($expense_head_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("expense-head-list");
            }
    }

  

    //expense head edit Form
    public function edit_expense_head($expense_head_id)
    {
        $data = array();
        $data['main'] = true;
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['edit_info'] = $this->inventory_model->get_expense_head_by_id($expense_head_id);
        $data['main_content'] = $this->load->view('home/expense_head_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update expense head Entry
    public function update_expense_head($expense_head_id)
    {
        $expense_head_info = array(
            'expense_head_name' => $this->input->post('expense_head_name'),
            'expense_head_updated_by' => $this->session->userdata('user_id'),
            'expense_head_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('expense_head_name', 'Expense Head', 'required');
       
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
           $data['expense_head_info'] = $this->inventory_model->get_expense_head();
            $data['edit_info'] = $this->inventory_model->get_expense_head_by_id($expense_head_id);
            $data['main_content'] = $this->load->view('home/expense_head_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_expense_head($expense_head_info, $expense_head_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Entry Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("expense-head-list");
            }
    }

    //expense head List
    public function expense_entry_form()
    {
         $date = date('Y-m-d');
        //$data = array();
       // $data['main'] = true;
        $data = $this->cash_flow_statement_report($date);
        $data['expense_head_info'] = $this->inventory_model->get_expense_head();
        $data['main_content'] = $this->load->view('home/expense_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save expense head Entry
    public function save_expense_entry()
    {
         
        $last_voucher = $this->inventory_model->get_voucher_no();
        if($last_voucher){
                $expense_voucher_no = $last_voucher->expense_voucher_no+1;
            }else{
                $expense_voucher_no = 100001;
            }   
         $payment_method = $this->input->post('payment_method');
         $expense_id = "ETI-".uniqid();
        $expense_info = array(
            'expense_transaction_id' => $expense_id,
            'expense_voucher_no' => $expense_voucher_no,
            'client_id' => $this->session->userdata('client_code'),
            'expense_head_id' => $this->input->post('expense_type'),
            'expense_transaction_date' => $this->input->post('tdate'),
            'expense_transaction_amount' => $this->input->post('amount'),
            'expense_payment_method' => $payment_method,
            'expense_transaction_description' => $this->input->post('description'),
            'expense_transaction_contact' => $this->input->post('mobile'),
            'expense_transaction_entry_by' => $this->session->userdata('user_id'),
            'expense_transaction_entry_date' => date('Y-m-d'),
            'expense_transaction_created_at' => date('Y-m-d H:i:s'),
            'expense_transaction_status' => 1
        );

        $this->form_validation->set_rules('tdate', 'Date', 'required');
        $this->form_validation->set_rules('description', 'Expense To', 'required');
        $this->form_validation->set_rules('expense_type', 'Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['expense_head_info'] = $this->inventory_model->get_expense_head();
            $data['main_content'] = $this->load->view('home/expense_entry_form', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_expense($expense_info);

            $expense_info = $this->inventory_model->get_expense_head_by_id($this->input->post('expense_type'));
           
            if($payment_method == "Bank"){
                    $transaction_info = array(
                        'bank_transaction_id' => "BTI-".uniqid(),
                        'client_id' =>  $this->session->userdata('client_code'),
                        'bank_id' => "Default",
                        'bank_transaction_date' => $this->input->post('tdate'),
                        'bank_transaction_type' => "Credit(-)",
                        //'withdraw_deposit_id' => "",
                        'bank_transaction_amount' => $this->input->post('amount'),
                        'bank_transaction_description' => "Expense of ".$expense_info->expense_head_name,
                        'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                        'bank_transaction_entry_date' => date('Y-m-d'),
                        'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                        'bank_transaction_status' => 1
                    );
                    $this->inventory_model->save_bank_transaction($transaction_info);
                
                }else{
                    $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' =>  $this->session->userdata('client_code'),
                    'cash_transaction_date' => $this->input->post('tdate'),
                    'cash_transaction_type' => "Credit(-)",
                    'cash_transaction_amount' => $this->input->post('amount'),
                    'cash_transaction_description' => "Expense of ".$expense_info->expense_head_name,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);
                }
            

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("expense-voucher/". $expense_id);
            }
    }

     public function expense_voucher_detail($expense_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['expense'] = $this->inventory_model->get_expense_detail($expense_id);
        $data['main_content'] = $this->load->view('home/expense_voucher_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

///////////End expense head //////////

///////////start product Category //////////
    // product category list
    public function product_category_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['product_cat_info'] = $this->inventory_model->get_product_category();
        $data['main_content'] = $this->load->view('home/product_category_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save product category Entry
    public function save_product_category()
    {
        $category_info = array(
            'product_category_id' => "PCI-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'product_category_name' => $this->input->post('cat_name'),
            'product_category_entry_by' => $this->session->userdata('user_id'),
            'product_category_entry_date' => date('Y-m-d'),
            'product_category_created_at' => date('Y-m-d H:i:s'),
            'product_category_status' => 1
        );

        $this->form_validation->set_rules('cat_name', 'Category', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['product_cat_info'] = $this->inventory_model->get_product_category();
            $data['main_content'] = $this->load->view('home/product_category_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{

            $this->inventory_model->save_product_category($category_info);

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("product-category");
            }
    }

    // product category edit form 
    public function edit_product_category($product_category_id)
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_product_category_by_id($product_category_id);
        $data['product_cat_info'] = $this->inventory_model->get_product_category();
        $data['main_content'] = $this->load->view('home/product_category_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update category
    public function update_product_category($product_category_id)
    {
        $category_info = array(
            'product_category_name' => $this->input->post('cat_name'),
            'product_category_updated_by' => $this->session->userdata('user_id'),
            'product_category_updated_at' => date('Y-m-d H:i:s'),
        );

        $this->form_validation->set_rules('cat_name', 'Category', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = $this->inventory_model->get_product_category_by_id($product_category_id);
        $data['product_cat_info'] = $this->inventory_model->get_product_category();
        $data['main_content'] = $this->load->view('home/product_category_list', $data,true);
        $this->load->view('home/client_home', $data);
        }else{

        $this->inventory_model->update_product_category($category_info, $product_category_id);

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Entry Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("product-category");
            }
    }
///////////End product Category//////////

///////////Start unit //////////
     //unit List
    public function unit_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['unit_info'] = $this->inventory_model->get_unit();
        $data['main_content'] = $this->load->view('home/unit_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save unit Entry
    public function save_unit()
    {
        $unit_info = array(
            'unit_id' => "BAR-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'unit_name' => $this->input->post('unit_name'),
            'unit_entry_by' => $this->session->userdata('user_id'),
            'unit_entry_date' => date('Y-m-d'),
            'unit_created_at' => date('Y-m-d H:i:s'),
            'unit_status' => 1
        );

        $this->form_validation->set_rules('unit_name', 'Unit', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['unit_info'] = $this->inventory_model->get_unit();
            $data['main_content'] = $this->load->view('home/unit_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_unit($unit_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("unit-list");
            }
    }

  

    //unit edit Form
    public function edit_unit($unit_id)
    {
        $data = array();
        $data['main'] = true;
        $data['unit_info'] = $this->inventory_model->get_unit();
        $data['edit_info'] = $this->inventory_model->get_unit_by_id($unit_id);
        $data['main_content'] = $this->load->view('home/unit_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update unit Entry
    public function update_unit($unit_id)
    {
        $unit_info = array(
            'unit_name' => $this->input->post('unit_name'),
            'unit_updated_by' => $this->session->userdata('user_id'),
            'unit_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('unit_name', 'Unit', 'required');
       
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
           $data['unit_info'] = $this->inventory_model->get_unit();
            $data['edit_info'] = $this->inventory_model->get_unit_by_id($unit_id);
            $data['main_content'] = $this->load->view('home/unit_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_unit($unit_info, $unit_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Entry Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("unit-list");
            }
    }

///////////End unit //////////

///////////Start product//////////
    //New product form
    public function new_product()
    {
        $data = array();
        $data['main'] = true;
        $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
        $data['product_category_info'] = $this->inventory_model->get_product_category();
        $data['unit_info'] = $this->inventory_model->get_unit();
        $data['main_content'] = $this->load->view('home/product_entry_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //product information save
    public function add_product()
    {
        $product_id = "pro-".uniqid();
        $Entry_by = $this->session->userdata('user_id');
        $client_id = $this->session->userdata('client_code');
        $Entry_date = date('Y-m-d');
        $created_at = date('Y-m-d H:i:s');

        $config['upload_path'] = 'uploads/product/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['max_width'] = '1000';
        $config['min_width'] = '50';
        $config['max_height'] = '1000';
        $config['min_height'] = '50';
        $this->load->library('upload', $config);
        $product_image ="";
        
        if($_FILES['product_image']['name'] != ""){
        if (!$this->upload->do_upload('product_image')) {
                    $sdata = array();
                    $sdata['error'] = "<div class='alert alert-error'>Please use a correct Image - .jpg, .jpeg, .png - Max Size[2MB][600 X 600 px]</div>";
                    $this->session->set_userdata($sdata);
                    redirect("new-product");
                }else{
        $data_upload_files = $this->upload->data();
        $udata = array('upload_data' => $this->upload->data());
        $product_image = "uploads/product/" . $udata['upload_data']['file_name'];
        } 
        }
    
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('category_id', 'Product category', 'required');
        $this->form_validation->set_rules('measurement_unit', 'Measurement Unit', 'required');
        $this->form_validation->set_rules('unit_price', 'Unit Trade Price', 'required');
        $this->form_validation->set_rules('unit_mrp', 'Unit MRP', 'required');
        $this->form_validation->set_rules('barcode', 'Barcode', 'callback_barcode_check');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['product_category_info'] = $this->inventory_model->get_product_category();
            $data['unit_info'] = $this->inventory_model->get_unit();
            $data['main_content'] = $this->load->view('home/product_entry_form', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            
            $product = array(
                'client_id' => $client_id,
                'product_id' => $product_id,
                'product_code' => $this->input->post('barcode'),
                'product_name' => $this->input->post('product_name'),
                'product_sn' => $this->input->post('serial_no'),
                'manufacturer_id' => $this->input->post('manufacturer_id'),
                'category_id' => $this->input->post('category_id'),
                'product_model' => $this->input->post('product_model'),
                'product_description' => $this->input->post('product_description'),
                'measurement_unit' => $this->input->post('measurement_unit'),
                'product_unit_price' => $this->input->post('unit_price'),
                'product_unit_mrp' => $this->input->post('unit_mrp'),
                'product_vat_per' => $this->input->post('vat'),
                'product_reorder_level' => $this->input->post('reorder_level'),
                'product_image' => $product_image,
                'product_status' => 1,
                'product_entry_by' => $Entry_by,
                'product_entry_date' => $Entry_date,
                'product_created_at' => $created_at
        );
        
            $this->inventory_model->add_product($product);
            
            $stock = array(
                'client_id' => $client_id,
                'product_stock_id' => "stk-".uniqid(),
                'product_id' => $product_id,
                'product_stock' => 0,
                'unit_price' => $this->input->post('unit_price'),
                'stock_entry_by' => $Entry_by,
                'stock_entry_date' => $Entry_date,
                'stock_created_at' => $created_at,
                'stock_status' => 1
        );
        
        $this->inventory_model->add_stock($stock);
            
            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Product Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("view-product/".$product_id);
        }
    }

    //view Selected product
    public function view_product($product_id)
    {
        $data = array();
        $data['main'] = true;
        $product_info = $this->inventory_model->get_product_by_id($product_id);
        $data['product_info'] = $product_info;
        $data['main_content'] = $this->load->view('home/product_info', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Edit Selected product
    public function edit_product_id($product_id)
    {
        $data = array();
        $data['main'] = true;
        $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
        $data['product_category_info'] = $this->inventory_model->get_product_category();
        $data['unit_info'] = $this->inventory_model->get_unit();
        $update_product = $this->inventory_model->get_product_by_id($product_id);
        $data['update_product'] = $update_product;
        $data['main_content'] = $this->load->view('home/product_edit_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Update Selected product
    public function update_product_id($product_id)
    {
        $old_image = $this->input->post('old_image');
        
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('category_id', 'Product category', 'required');
        $this->form_validation->set_rules('measurement_unit', 'Measurement Unit', 'required');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'required');
        $this->form_validation->set_rules('unit_mrp', 'Unit MRP', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['product_category_info'] = $this->inventory_model->get_product_category();
            $data['unit_info'] = $this->inventory_model->get_unit();
            $update_product = $this->inventory_model->get_product_by_id($product_id);
            $data['update_product'] = $update_product;
            $data['main_content'] = $this->load->view('home/product_edit_form', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
        //     if($_FILES['product_image']['size'] > 0) {
        
        // $config['upload_path'] = 'uploads/product';
        // $config['allowed_types'] = 'gif|jpg|png|jpeg';
        // $config['max_size'] = '2000';
        // $config['max_width'] = '1000';
        // $config['min_width'] = '50';
        // $config['max_height'] = '1000';
        // $config['min_height'] = '50';
        // $this->load->library('upload', $config);
        
        // if($_FILES['product_image']['name'] != ""){
        // if (!$this->upload->do_upload('product_image')) {
        //             $sdata = array();
        //             $sdata['error'] = "<div class='alert alert-error'>Please use a correct Image - .jpg, .jpeg, .png - Max Size[2M] - Max Width[1000px] - Max Height[1000px]</div>";
        //             $this->session->set_userdata($sdata);
        //             redirect("edit-product/".$product_id,'refresh');
                    
        //         }else{
        // $data_upload_files = $this->upload->data();
        // $udata = array('upload_data' => $this->upload->data());
        // $product_image = "uploads/product/" . $udata['upload_data']['file_name'];
        // unlink(FCPATH .$old_image);
        // } 
        // }
        // }else{
        //     $product_image = $old_image;
        // }

        $config['upload_path'] = 'uploads/product';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '2024';
        $config['max_width'] = '1000';
        $config['min_width'] = '50';
        $config['max_height'] = '1000';
        $config['min_height'] = '50';
        $this->load->library('upload', $config);
        
        if($_FILES['product_image']['name'] != ""){
            if (!$this->upload->do_upload('product_image')) {
                        $sdata = array();
                        $sdata['error'] = "<div class='alert alert-error'>Please use a png, jpg or jpeg File. Max File size 2MB.</div>";
                        $this->session->set_userdata($sdata);
                        redirect("edit-product/".$product_id,'refresh');
                    }else{
            $data_upload_files_other = $this->upload->data();
            $pdata = array('upload_data' => $this->upload->data());
            $product_image = "uploads/product/" . $pdata['upload_data']['file_name'];
            unlink( FCPATH . $old_image);
            } 
        }else{$product_image = $old_image;}
    
        $product = array(
                'product_code' => $this->input->post('barcode'),
                'product_name' => $this->input->post('product_name'),
                'product_sn' => $this->input->post('serial_no'),
                'manufacturer_id' => $this->input->post('manufacturer_id'),
                'category_id' => $this->input->post('category_id'),
                'product_model' => $this->input->post('product_model'),
                'product_description' => $this->input->post('product_description'),
                'measurement_unit' => $this->input->post('measurement_unit'),
                'product_unit_price' => $this->input->post('unit_price'),
                'product_unit_mrp' => $this->input->post('unit_mrp'),
                'product_vat_per' => $this->input->post('vat'),
                'product_reorder_level' => $this->input->post('reorder_level'),
                'product_image' => $product_image,
                'product_updated_by' => $this->session->userdata('user_id'),
                'product_updated_at' => date('Y-m-d H:i:s')
        );
        
            $this->inventory_model->update_product_id($product, $product_id);

            $stock_item = array(
                'unit_price' => $this->input->post('unit_price'),
                'stock_updated_by' => $this->session->userdata('user_id'),
                'stock_updated_at' => date('Y-m-d H:i:s')
            );

            $this->inventory_model->update_product_stock($stock_item, $product_id);
            
            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>Product Updated Successfully.</div>";
            $this->session->set_userdata($sdata);
            redirect("view-product/".$product_id);
        }
    }

    //activate product status
    public function activate_product_id($product_id)
    {
        $product_data['product_status'] = 1;
        $this->inventory_model->update_product_id($product_data, $product_id);
        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Product Activated!</div>";
        $this->session->set_userdata($sdata);
        redirect("product-list");
    }
    
    //deactivate product status
    public function deactivate_product_id($product_id)
    {
        $product_data['product_status'] = 0;
        $this->inventory_model->update_product_id($product_data, $product_id);
        $sdata = array();
        $sdata['success'] = "<div class='alert alert-error fade in'>Product Deactivated!</div>";
        $this->session->set_userdata($sdata);
        redirect("product-list");
    }

    //product list
    public function product_list()
    {
        $data = array();
        $data['main'] = true;
        $data['products'] = $this->inventory_model->get_product();
        $data['main_content'] = $this->load->view('home/product_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //product barcode
    public function product_barcode_print($product_id)
    {
        $data = array();
        $data['main'] = true;
        $product = $this->inventory_model->get_product_by_id($product_id);
        $client = $this->inventory_model->get_user_client($product->client_id);
        
        $num = $product->product_code;
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode'); 
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $num, 'barHeight' => 50, 'drawText' => TRUE), array());
        $store_image = imagepng($file,FCPATH."uploads/barcodes/{$product_id}.png");

        /*$barcode = '<table class="table-bordered" width="150">
                        <tbody>
                            <tr>
                                <td class="barcode-toptd">
                                    <div class="barcode-inner barcode-innerdiv">
                                        <div class="product-name barcode-productname">
                                            '.$client->business_name.'
                                        </div>
                                        <img class="img-responsive center-block barcode-image" alt="" src="'.base_url().'uploads/barcodes/'.$product_id.'.png" >
                                        <div class="product-name-details barcode-productdetails">
                                            '.$product->product_name.'
                                        </div>
                                        <div class="price barcode-price">
                                            ৳'.$product->product_unit_mrp.'/=
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>';*/

                    $barcode = '<table>
                        <tbody>
                            <tr>
                                <td class="barcode-toptd">
                                    <div class="barcode-inner barcode-innerdiv">
                                        <div class="product-name barcode-productname">
                                            '.$client->business_name.'
                                        </div>
                                        <img class="img-responsive center-block barcode-image" alt="" src="'.base_url().'uploads/barcodes/'.$product_id.'.png" >
                                        <div class="product-name-details barcode-productdetails">
                                            '.$product->product_name.'
                                        </div>
                                        <div class="product-name barcode-productname">
                                            ৳'.$product->product_unit_mrp.'/=
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>';

        $data['barcode'] = $barcode;
        $data['product'] = $product;
        $data['main_content'] = $this->load->view('home/product_barcode_print', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //product barcode
    public function barcode_print()
    {
        $barcode_qty = $this->input->post('barcode_qty');
        $col_qty = $this->input->post('col_qty');
        $row_qty = $barcode_qty/$col_qty;
        $product_id = $this->input->post('product_no');
        $product = $this->inventory_model->get_product_by_id($product_id);
        $client = $this->inventory_model->get_user_client($product->client_id);
        $num = $product->product_code;
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode'); 
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $num, 'barHeight' => 50, 'drawText' => TRUE), array());
        $store_image = imagepng($file,FCPATH."uploads/barcodes/{$product_id}.png");

        $barcode = '<table style="margin-bottom:30px;">
                        <tbody>
                            <tr>
                                <td class="barcode-toptd" align="center">
                                    <div class="barcode-inner barcode-innerdiv">
                                        <div class="product-name barcode-productname">
                                            '.$client->business_name.'
                                        </div>
                                        <img class="img-responsive center-block barcode-image" alt="" src="'.base_url().'uploads/barcodes/'.$product_id.'.png" >
                                        <div class="product-name-details barcode-productdetails">
                                            '.$product->product_name.'
                                        </div>
                                        <div class="product-name barcode-productname">
                                            ৳'.$product->product_unit_mrp.'/=
                                        </div>

                                        
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>';
        //echo "success";
        echo "<table cellpadding='5'>";
        for($i=0; $i<$row_qty;$i++){
            echo "<tr>";
            for($c=0; $c<$col_qty;$c++){
                echo "<td width='300'>".$barcode."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        
    }

    //product barcode
    public function product_barcode_generate_form()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/product_barcode_generate_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

///////////End product//////////

///////////Start purchase//////////
    //new purchase form
    public function new_purchase_form()
    {
        //data = array();
        //$data['main'] = true;;
        $data = $this->cash_flow_statement_report(date('Y-m-d'));
        $data['supplier_info'] = $this->inventory_model->get_supplier();
        $data['main_content'] = $this->load->view('home/purchase_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //purchase product list auto complete
    public function get_purchase_product_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->purchase_product_search($postData);
    echo json_encode($data);
    }

    //purchase Entry save
    public function save_purchase()
        {
            $client_id = $this->session->userdata('client_code');
            $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));

            $last_invoice = $this->inventory_model->get_purchase_invoice_no();
            if($last_invoice){
                    $purchase_invoice_no = $last_invoice->purchase_invoice_no+1;
                }else{
                    $purchase_invoice_no = 100001;
                }

            if($temp != 0){
                $purchase_invoice_id = "PUR-".uniqid();
                $supplier_payment_id = "SPI-".uniqid();
                //$customer_id = "CUS-".uniqid();
                $supplier_id = $this->input->post('supplier_name');
                $purchase_date = $this->input->post('purchase_date');
                $purchase_challan_no = $this->input->post('challan_no');
                $unit_price = $this->input->post('unit_price');
                $purchase_qty = $this->input->post('purchase_qty');
                $purchase_discount = $this->input->post('purchase_discount');
                $purchase_details = $this->input->post('purchase_details');
                $invoice_discount = $this->input->post('invoice_discount');
                $paid_amount = $this->input->post('paid_amount');
                $balance_payment = $this->input->post('pbalance_payment');
               
                $sum = 0;
                $total_discount = 0;

                $paytype = $this->input->post('paytype');
                if($paytype == "Bank"){
                    $payment_info = $this->input->post('purchase_bank');
                    
                $transaction_info = array(
                            'bank_transaction_id' => "BTI-".uniqid(),
                            'client_id' => $client_id,
                            'bank_id' => "Default",
                            'bank_transaction_date' => $purchase_date,
                            'bank_transaction_type' => "Credit(-)",
                            'withdraw_deposit_id' => $purchase_invoice_no,
                            'bank_transaction_amount' => $paid_amount,
                            'bank_transaction_description' => "Purchase Payment of Invoice# ".$purchase_invoice_no,
                            'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                            'bank_transaction_entry_date' => date('Y-m-d'),
                            'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                            'bank_transaction_status' => 1
                        );
                $this->inventory_model->save_bank_transaction($transaction_info);
                }else if($paytype == "Mobile"){
                    $payment_info = $this->input->post('purchase_bkash');
                }else if($paytype == "Card"){
                    $payment_info = $this->input->post('purchase_card');
                }else{
                    $payment_info = "N/A";
                    $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' => $this->session->userdata('client_code'),
                    'cash_transaction_date' => $purchase_date,
                    'cash_transaction_type' => "Credit(-)",
                    'cash_transaction_amount' => $paid_amount,
                    'cash_transaction_description' => "Purchase Payment of Invoice# ".$purchase_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);
                }
                
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                    $sum += $unit_price[$i]*$purchase_qty[$i];
                    $total_discount += $purchase_discount[$i];
                  $purchase_item = array(
                    'purchase_item_id' => "PII-".uniqid(),
                    'client_id' => $client_id,
                    'supplier_id' => $supplier_id,
                    'purchase_invoice_id' => $purchase_invoice_id,
                    'purchase_invoice_no' => $purchase_invoice_no,
                    'product_id' => $product_id[$i],
                    'purchase_item_quantity' => $purchase_qty[$i],
                    'purchase_item_rate' => $unit_price[$i],
                    'purchase_item_discount' => $purchase_discount[$i],
                    'purchase_item_amount' => $unit_price[$i]*$purchase_qty[$i],
                    'purchase_item_date' => $purchase_date,
                    'purchase_item_entry_by' => $this->session->userdata('user_id'),
                    'purchase_item_entry_date' => date('Y-m-d'),
                    'purchase_item_created_at' => date('Y-m-d H:i:s'),
                    'purchase_item_status' => 1
                );

                $this->inventory_model->add_purchase_item($purchase_item);
                //$this->inventory_model->delete_purchase_item($purchase_invoice_id);

                $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                    $product_stock = $stock_info->product_stock+$purchase_qty[$i];
                    $stock_item = array(
                    'product_stock' => $product_stock,
                    'unit_price' => $unit_price[$i],
                    'stock_updated_by' => $this->session->userdata('user_id'),
                    'stock_updated_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);

                $product = array(
                'product_unit_price' => $unit_price[$i],
                'product_updated_by' => $this->session->userdata('user_id'),
                'product_updated_at' => date('Y-m-d H:i:s')
        );
        
            $this->inventory_model->update_product_id($product, $product_id[$i]);

                  }

                $invoice_info = array(
                    'purchase_invoice_id' => $purchase_invoice_id,
                    'purchase_invoice_no' => $purchase_invoice_no,
                    'client_id' => $client_id,
                    'supplier_id' => $supplier_id,
                    'purchase_challan_no' => $purchase_challan_no,
                    'purchase_invoice_date' => $purchase_date,
                    'purchase_total_amount' => $sum,
                    'purchase_invoice_discount' => $invoice_discount,
                    'purchase_total_discount' => $total_discount,
                    'purchase_amount_paid' => $paid_amount,
                    'purchase_advance_payment' => $balance_payment,
                    'purchase_invoice_detail' => $purchase_details,
                    'purchase_payment_type' => $paytype,
                    'purchase_payment_info' => $payment_info,
                    'purchase_invoice_entry_by' => $this->session->userdata('user_id'),
                    'purchase_invoice_entry_date' => date('Y-m-d'),
                    'purchase_invoice_created_at' => date('Y-m-d H:i:s'),
                    'purchase_invoice_status' => 1
                );
                $this->inventory_model->add_purchase_invoice($invoice_info);

                
                //$previous_balance = $this->input->post('pprevious_balance');
                
                 $payable = $sum-($invoice_discount+$total_discount);
                 $due = $payable- $paid_amount-$balance_payment;
                 if ($balance_payment > 0) {
                   
                 $cr_check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
                 if ($cr_check_balance) {
                        $cr_current_balance = $cr_check_balance->supplier_transaction_balance-$balance_payment;
                    }else{
                        $cr_current_balance = -$balance_payment;
                    }

                    $cr_transaction_info = array(
                        'supplier_ledger_id' => "CTI-".uniqid(),
                        'client_id' => $this->session->userdata('client_code'),
                        'supplier_transaction_date' => $purchase_date,
                        'supplier_id' => $supplier_id,
                        'supplier_transaction_type' => "Credit(-)",
                        'supplier_transaction_amount' => $balance_payment,
                        'supplier_transaction_balance' => $cr_current_balance,
                        'supplier_transaction_description' => "Purchase Payment Adjustment of Invoice# ".$purchase_invoice_no,
                        'supplier_transaction_entry_by' => $this->session->userdata('user_id'),
                        'supplier_transaction_entry_date' => date('Y-m-d'),
                        'supplier_transaction_created_at' => date('Y-m-d H:i:s'),
                        'supplier_transaction_status' => 1
                    );
                    $this->inventory_model->save_supplier_transaction($cr_transaction_info);
                }

                $payment_info = array(
                    'purchase_payment_id' => "PPI-".uniqid(),
                    'purchase_invoice_id' => $purchase_invoice_id,
                    'supplier_payment_id' => $supplier_payment_id,
                    'purchase_invoice_no' => $purchase_invoice_no,
                    'client_id' => $client_id,
                    'supplier_id' => $supplier_id,
                    'purchase_challan_no' => $purchase_challan_no,
                    'purchase_payment_date' => $purchase_date,
                    'purchase_payment_amount' => $paid_amount,
                    'purchase_payment_entry_by' => $this->session->userdata('user_id'),
                    'purchase_payment_entry_date' => date('Y-m-d'),
                    'purchase_payment_entry_date' => date('Y-m-d H:i:s'),
                    'purchase_payment_status' => 1
                );
                $this->inventory_model->add_purchase_payment($payment_info);

                $supplyer_payment = array(
                'supplier_payment_id' => $supplier_payment_id,
                'client_id' => $client_id,
                'supplier_id' => $supplier_id,
                'supplier_payment_date' => $purchase_date,
                'supplier_payment_amount' => $paid_amount,
                'supplier_payment_entry_by' => $this->session->userdata('user_id'),
                'supplier_payment_entry_date' => date('Y-m-d'),
                'supplier_payment_created_at' => date('Y-m-d H:i:s'),
                'supplier_payment_status' => 1
            );
            $this->inventory_model->add_supplyer_payment($supplyer_payment);
                    



                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Product purchase Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("purchase-detail/".$purchase_invoice_id);
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger fade in'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
               redirect("new-purchase"); 
            }
        
    }

    //Purchase detail
    public function purchase_invoice_detail($purchase_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $discount = $purchase_info->purchase_invoice_discount+$purchase_info->purchase_total_discount;
        $total = $purchase_info->purchase_total_amount-$discount;

        $data['total'] = $total;
        $data['paid_amount'] = $purchase_info->purchase_amount_paid;
        $data['due'] = $total-$purchase_info->purchase_amount_paid-$purchase_info->purchase_advance_payment;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['purchase_info'] = $purchase_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['purchase_item'] = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $data['main_content'] = $this->load->view('home/purchase_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Purchase detail print
    public function purchase_invoice_print($purchase_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $discount = $purchase_info->purchase_invoice_discount+$purchase_info->purchase_total_discount;
        $total = $purchase_info->purchase_total_amount-$discount;
        $paid_amount = $purchase_info->purchase_amount_paid+$purchase_info->purchase_advance_payment;
        $due = $total-$paid_amount;

        $data['total'] = $total;
        $data['paid_amount'] = $paid_amount;
        $data['due'] = $due;
        $data['discount'] = $discount;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['purchase_info'] = $purchase_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['purchase_item'] = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $data['main_content'] = $this->load->view('home/purchase_invoice_pdf', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Purchase detail print
    public function purchase_challan_print($purchase_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $data['purchase_info'] = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['purchase_item'] = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $data['main_content'] = $this->load->view('home/purchase_challan_pdf', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // purchase list
    public function purchase_invoice_list()
    {
            $data = array();
            $data['main'] = true;
            $data['purchase_info'] = $this->inventory_model->get_purchase_list();
            $data['main_content'] = $this->load->view('home/purchase_invoice_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

    //Purchase edit form
    public function purchase_edit_form($purchase_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $discount = $purchase_info->purchase_invoice_discount+$purchase_info->purchase_total_discount;
        $total = $purchase_info->purchase_total_amount-$discount;
        $balance = $total-$purchase_info->purchase_amount_paid;
        if ($balance >= 0) {
          $due = $balance;
        }else {$due = 0;}
        $paid_amount = $total-$due;

        $data['total'] = $total;
        $data['paid_amount'] = $paid_amount;
        $data['due'] = $due;
        $data['purchase_info'] = $purchase_info;
        $data['purchase_item'] = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $data['supplier_info'] = $this->inventory_model->get_supplier();
        $data['main_content'] = $this->load->view('home/purchase_edit_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //purchase Entry update
    public function save_purchase_edit($purchase_invoice_id)
    {
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $purchase_item = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $purchase_payment = $this->inventory_model->get_purchase_payment($purchase_invoice_id);

        foreach ($purchase_item as $item) {
            $stock = $this->inventory_model->get_stock_product($item->product_id);
            $new_stock = $stock->product_stock-$item->purchase_item_quantity;
            $update_stock = array(
            'product_stock' => $new_stock,
            'stock_updated_by' => $this->session->userdata('user_id'),
            'stock_updated_at' => date('Y-m-d H:i:s')
        );
        $this->inventory_model->update_product_stock($update_stock, $item->product_id);
        }
        $this->inventory_model->delete_purchase_item($purchase_info->purchase_invoice_id);
        $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));
            if($temp != 0){
                $client_id = $this->session->userdata('client_code');
                $supplier_id = $this->input->post('supplier_name');
                $purchase_date = $this->input->post('purchase_date');
                $purchase_challan_no = $this->input->post('challan_no');
                $paytype = $this->input->post('paytype');
                if($paytype == "Bank"){
                    $payment_info = $this->input->post('purchase_bank');
                }else if($paytype == "Mobile"){
                    $payment_info = $this->input->post('purchase_bkash');
                }else if($paytype == "Card"){
                    $payment_info = $this->input->post('purchase_card');
                }else{
                    $payment_info = "N/A";
                }
                $unit_price = $this->input->post('unit_price');
                $purchase_qty = $this->input->post('purchase_qty');
                $purchase_discount = $this->input->post('purchase_discount');
                $purchase_details = $this->input->post('purchase_details');
                $invoice_discount = $this->input->post('invoice_discount');
                $paid_amount = $this->input->post('paid_amount');
                $sum = 0;
                $total_discount = 0;
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                  $sum += $unit_price[$i]*$purchase_qty[$i];
                  $total_discount += $purchase_discount[$i];
                  $purchase_item = array(
                    'purchase_item_id' => "PII-".uniqid(),
                    'client_id' => $client_id,
                    'supplier_id' => $supplier_id,
                    'purchase_invoice_id' => $purchase_invoice_id,
                    'purchase_invoice_no' => $purchase_info->purchase_invoice_no,
                    'product_id' => $product_id[$i],
                    'purchase_item_quantity' => $purchase_qty[$i],
                    'purchase_item_rate' => $unit_price[$i],
                    'purchase_item_discount' => $purchase_discount[$i],
                    'purchase_item_amount' => $unit_price[$i]*$purchase_qty[$i],
                    'purchase_item_date' => $purchase_date,
                    'purchase_item_entry_by' => $this->session->userdata('user_id'),
                    'purchase_item_entry_date' => date('Y-m-d'),
                    'purchase_item_created_at' => date('Y-m-d H:i:s'),
                    'purchase_item_status' => 1
                );
                $this->inventory_model->add_purchase_item($purchase_item);
                
                $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                    $product_stock = $stock_info->product_stock+$purchase_qty[$i];
                    $stock_item = array(
                    'product_stock' => $product_stock,
                    'stock_updated_by' => $this->session->userdata('user_id'),
                    'stock_updated_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
                }

                $invoice_info = array(
                    'supplier_id' => $supplier_id,
                    'purchase_challan_no' => $purchase_challan_no,
                    'purchase_invoice_date' => $purchase_date,
                    'purchase_total_amount' => $sum,
                    'purchase_invoice_discount' => $invoice_discount,
                    'purchase_total_discount' => $total_discount,
                    'purchase_amount_paid' => $paid_amount,
                    'purchase_invoice_detail' => $purchase_details,
                    'purchase_payment_type' => $paytype,
                    'purchase_payment_info' => $payment_info,
                    'purchase_invoice_updated_by' => $this->session->userdata('user_id'),
                    'purchase_invoice_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_purchase_invoice($invoice_info, $purchase_info->purchase_invoice_id);

                $payment_info = array(
                    'supplier_id' => $supplier_id,
                    'purchase_challan_no' => $purchase_challan_no,
                    'purchase_payment_date' => $purchase_date,
                    'purchase_payment_amount' => $paid_amount,
                    'purchase_payment_updated_by' => $this->session->userdata('user_id'),
                    'purchase_payment_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_purchase_payment($payment_info, $purchase_payment->purchase_payment_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'> Purchase Update Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("purchase-detail/".$purchase_info->purchase_invoice_id);
            }else{
                 $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
               redirect("purchase-edit/".$purchase_info->purchase_invoice_id); 
            }
    }

    // purchase list
    public function purchase_return_search()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/purchase_return_search', $data,true);
        $this->load->view('home/client_home', $data);    
    }

   

    //done voucher search
    public function purchase_return_search_list()
     {
      $output = '';
       $query = $this->input->post('query');
     

      $data = $this->inventory_model->fetch_purchase_return_search_list($query);
      
      $output .= '
      <table class="table table-bordered table-striped table-hover" id="example1">
        <thead>
            <tr>
              <th width="30">SL.</th>
              <th>Date</th>
              <th>Invoice#</th>
              <th>Supplier</th>
              <th>Contact No.</th>
              <th>Payable</th>
              <th>Paid</th>
              <th>Balance</th>
              <th>Action</th>
            </tr>
            </thead>
        <tbody>
      ';
      if($query != "" && $data->num_rows() > 0)
      {
        $x=1;
       foreach($data->result() as $info)
       {
        $discount = $info->purchase_invoice_discount+$info->purchase_total_discount;
        $total = $info->purchase_total_amount-$discount;
        $balance = $total-$info->purchase_amount_paid-$info->purchase_advance_payment;
            $output .= '
              <tr>
               <td>'.$x++.'</td>
               <td>'.date('d/m/Y', strtotime($info->purchase_invoice_date)).'</td>
               <td>'.$info->purchase_invoice_no.'</td>
               <td>'.$info->supplier_name.'</td>
               <td>'.$info->supplier_mobile.'</td>
               <td>'.number_format((float)$total, 2, '.', '').'</td>
               <td>'.number_format((float)$info->purchase_amount_paid+$info->purchase_advance_payment, 2, '.', '').'</td>
               <td>'.number_format((float)$balance, 2, '.', '').'</td>
               <td>
                <a class="btn btn-primary btn-xs" href="'.base_url() . "purchase-return-entry/" .$info->purchase_invoice_id.'">Return</a>
               </td>
              </tr>
            ';
            }
      }
      
      else
      {
       $output .= '<tr>
           <td colspan="9">No Data Found</td>
          </tr>';
      }
      $output .= '</tbody></table>';
      echo $output;
     }

     //Purchase return form
    public function purchase_return_form($purchase_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $discount = $purchase_info->purchase_invoice_discount+$purchase_info->purchase_total_discount;
        $total = $purchase_info->purchase_total_amount-$discount-$purchase_info->purchase_invoice_return_total;
        $paid = $purchase_info->purchase_amount_paid+$purchase_info->purchase_advance_payment-$purchase_info->purchase_invoice_return_amount;
        $data['total'] = $total;
        $data['paid_amount'] = $purchase_info->purchase_amount_paid+$purchase_info->purchase_advance_payment-$purchase_info->purchase_invoice_return_amount;
        $data['due'] = $total-$paid;
        $data['purchase_info'] = $purchase_info;
        $data['purchase_item'] = $this->inventory_model->get_purchase_item($purchase_invoice_id);
        $data['supplier_info'] = $this->inventory_model->get_supplier();
        $data['main_content'] = $this->load->view('home/purchase_return_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //purchase return save
    public function save_purchase_return($purchase_invoice_id)
    {
        $purchase_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id);
        $discount_percent = ($purchase_info->purchase_invoice_discount/($purchase_info->purchase_total_amount-$purchase_info->purchase_total_discount))*100;
        
        $return_total = 0;
        $purchase_return_id = "PRI-".uniqid();
        $client_id = $this->session->userdata('client_code');
        $product_id = $this->input->post('product_id');
        $purchase_item_id = $this->input->post('purchase_item');
        $return_qty = $this->input->post('return_qty');
        $return_rate = $this->input->post('purchase_return_rate');
        $return_payment = $this->input->post('return_payment');
        $return_date = $this->input->post('return_date');
        
        $temp =count(array_filter($return_qty));


        if($temp != 0){
            $qty =count($purchase_item_id);
            for($i=0; $i<$qty;$i++){
            $return_sum = $return_rate[$i]*$return_qty[$i];
            $return_total += $return_sum;
            $item = $this->inventory_model->get_purchase_item_id($purchase_item_id[$i]);

            $purchase_item = array(
                'purchase_return_item_quantity' => $item->purchase_return_item_quantity+$return_qty[$i],
                'purchase_item_updated_by' => $this->session->userdata('user_id'),
                'purchase_item_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_purchase_item($purchase_item, $item->purchase_item_id);

            $return_item = array(
                'purchase_return_item_id' => "PRII-".uniqid(),
                'client_id' => $client_id,
                'supplier_id' => $item->supplier_id,
                'purchase_invoice_id' => $purchase_info->purchase_invoice_id,
                'purchase_invoice_no' => $purchase_info->purchase_invoice_no,
                'purchase_item_id' => $item->purchase_item_id,
                'purchase_return_id' => $purchase_return_id,
                'product_id' => $product_id[$i],
                'purchase_return_quantity' => $return_qty[$i],
                'purchase_return_rate' => $return_rate[$i],
                'purchase_return_amount' => $return_rate[$i]*$return_qty[$i],
                'purchase_return_date' => $return_date,
                'purchase_return_entry_by' => $this->session->userdata('user_id'),
                'purchase_return_entry_date' => date('Y-m-d'),
                'purchase_return_created_at' => date('Y-m-d H:i:s'),
                'purchase_return_status' => 1
            );
            $this->inventory_model->add_purchase_return_item($return_item);
            $this->inventory_model->delete_purchase_return_item();

            $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                $product_stock = $stock_info->product_stock-$return_qty[$i];
                $stock_item = array(
                'product_stock' => $product_stock,
                'stock_updated_by' => $this->session->userdata('user_id'),
                'stock_updated_at' => date('Y-m-d H:i:s')
            );

            $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
              }

              $invoice_discount_amount = ($discount_percent / 100) * $return_total;
             $return_net_total = $return_total-$invoice_discount_amount;
             

              $invoice_info = array(
                'purchase_invoice_return_total' => $purchase_info->purchase_invoice_return_total+$return_net_total,
                'purchase_invoice_return_amount' => $purchase_info->purchase_invoice_return_amount+$return_payment,
                'purchase_invoice_updated_by' => $this->session->userdata('user_id'),
                'purchase_invoice_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_purchase_invoice($invoice_info, $purchase_info->purchase_invoice_id);

            
            $paytype = $this->input->post('paytype');
        if ($return_payment > 0) {
         
        if($paytype == "Cash"){
            $payment_info = "N/A";
            $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' =>  $client_id,
                    'cash_transaction_date' => $return_date,
                    'cash_transaction_type' => "Debit(+)",
                    'cash_transaction_amount' => $return_payment,
                    'cash_transaction_description' => "Purchase Return Payment of Invoice# ".$purchase_info->purchase_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);

        }else if($paytype == "Bank"){
            $payment_info = $this->input->post('purchase_bank');
            $transaction_info = array(
                'bank_transaction_id' => "BTI-".uniqid(),
                'client_id' => $client_id,
                'bank_id' => "Default",
                'bank_transaction_date' => $return_date,
                'bank_transaction_type' => "Debit(+)",
                'withdraw_deposit_id' => $purchase_info->purchase_invoice_no,
                'bank_transaction_amount' => $return_payment,
                'bank_transaction_description' => "Purchase Return Payment of Invoice# ".$purchase_info->purchase_invoice_no,
                'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                'bank_transaction_entry_date' => date('Y-m-d'),
                'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                'bank_transaction_status' => 1
            );
            $this->inventory_model->save_bank_transaction($transaction_info);

        }
    }else{$payment_info = "N/A";}

    $return_invoice_info = array(
        'purchase_return_id' => $purchase_return_id,
        'purchase_invoice_id' => $purchase_info->purchase_invoice_id,
        'purchase_invoice_no' => $purchase_info->purchase_invoice_no,
        'client_id' => $client_id,
        'supplier_id' => $purchase_info->supplier_id,
        'purchase_return_date' => $return_date,
        'purchase_return_total' => $return_net_total,
        'purchase_return_amount' => $return_payment,
        'purchase_return_payment_type' => $paytype,
        'purchase_return_payment_info' => $payment_info,
        'purchase_invoice_entry_by' => $this->session->userdata('user_id'),
        'purchase_invoice_entry_date' => date('Y-m-d'),
        'purchase_invoice_created_at' => date('Y-m-d H:i:s'),
        'purchase_invoice_status' => 1,
    );
    $this->inventory_model->add_purchase_return_invoice($return_invoice_info);
            
            
            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>Product Return Successfull!</div>";
            $this->session->set_userdata($sdata);
           redirect("purchase-return-detail/".$purchase_return_id);    
        
        }else{
             $sdata = array();
            $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Qty!</div>";
            $this->session->set_userdata($sdata);
           redirect("purchase-return-entry/".$purchase_invoice_id); 
       }
    
    }

    // purchase return list
    public function purchase_return_list()
    {
            $data = array();
            $data['main'] = true;
            $data['purchase_return_info'] = $this->inventory_model->get_purchase_return();
            $data['main_content'] = $this->load->view('home/purchase_return_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

      //Purchase return detail
    public function purchase_return_detail($purchase_return_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $purchase_info = $this->inventory_model->get_purchase_return_invoice($purchase_return_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($purchase_info->purchase_return_total);
        $data['purchase_info'] = $purchase_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['purchase_item'] = $this->inventory_model->get_purchase_return_item($purchase_return_id);
        $data['main_content'] = $this->load->view('home/purchase_return_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }
///////////End purchase//////////

/////////Start Sales////////////
    //new sales form
    public function new_sales_form()
    {
        $data = array();
        $data['main'] = true;
        $client = $this->session->userdata('user_id');
        $data['main_content'] = $this->load->view('home/sales_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales customer auto complete
    public function get_customer_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->sales_customer_search($postData);
    echo json_encode($data);
    }

    // supplier auto complete
    public function get_supplier_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->sales_supplier_search($postData);
    echo json_encode($data);
    }

     // supplier auto complete
    public function ledger_supplier_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->ledger_supplier_search($postData);
    echo json_encode($data);
    }

    //sales product list auto complete
    public function get_sales_product_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->sales_product_search($postData);
    echo json_encode($data);
    }

    //sales Entry save
    public function sales_invoice_entry()
        {
            $client_id = $this->session->userdata('client_code');
            $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));
            $last_invoice = $this->inventory_model->get_sales_invoice_no();
            if($last_invoice){
                    $sales_invoice_no = $last_invoice->sales_invoice_no+1;
                }else{
                    $sales_invoice_no = 100001;
                }

            if($temp != 0){
                $sales_invoice_id = "SAL-".uniqid();
                $customer_payment_id = "CPI-".uniqid();
                $customer_code = $this->input->post('customer_id');
                $customer_org = $this->input->post('customer_org');
                $customer_name = $this->input->post('customer_name');
                $customer_mobile = $this->input->post('customer_mobile');
                $sales_date = $this->input->post('sales_date');
                $mrp = $this->input->post('mrp');
                $sales_qty = $this->input->post('sales_qty');
                $sales_vat = $this->input->post('sales_vat');
                $sales_discount = $this->input->post('sales_discount');
                $sales_details = $this->input->post('sales_details');
                $invoice_discount = $this->input->post('invoice_discount');
                $paid_amount = $this->input->post('paid_amount');
                $balance_payment = $this->input->post('pbalance_payment');
                $sum = 0;
                $total_vat = 0;
                $total_discount = 0;
                $paytype = $this->input->post('paytype');
                if($paytype == "Bank"){
                    $payment_info = $this->input->post('sales_bank');
                    $transaction_info = array(
                        'bank_transaction_id' => "BTI-".uniqid(),
                        'client_id' => $client_id,
                        'bank_id' => "Default",
                        'bank_transaction_date' => $sales_date,
                        'bank_transaction_type' => "Debit(+)",
                        'withdraw_deposit_id' => $sales_invoice_no,
                        'bank_transaction_amount' => $paid_amount,
                        'bank_transaction_description' => "Sales Receive of Invoice# ".$sales_invoice_no,
                        'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                        'bank_transaction_entry_date' => date('Y-m-d'),
                        'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                        'bank_transaction_status' => 1
                    );
                    $this->inventory_model->save_bank_transaction($transaction_info);
                }else if($paytype == "Mobile"){
                    $payment_info = $this->input->post('sales_bkash');
                }else if($paytype == "Card"){
                    $payment_info = $this->input->post('sales_card');
                }else{
                    $payment_info = "N/A";
                    $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' => $client_id,
                    'cash_transaction_date' => $sales_date,
                    'cash_transaction_type' => "Debit(+)",
                    'cash_transaction_amount' => $paid_amount,
                    'cash_transaction_description' => "Sales Receive of Invoice# ".$sales_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);
                }
                
                

                if ($customer_code) {
                    $customer_id = $customer_code;
                }else{
                    $customer_id = "CUS-".uniqid();
                    $customer_info = array(
                    'customer_id' => $customer_id,
                    'client_id' => $client_id,
                    'customer_name' => $customer_name,
                    'customer_mobile' => $customer_mobile,
                    'customer_created_by' => $this->session->userdata('user_id'),
                    'customer_create_date' => date('Y-m-d'),
                    'customer_created_at' => date('Y-m-d H:i:s'),
                    'customer_status' => 1
                );
                $this->inventory_model->save_customer($customer_info);
                }
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                    $sum += $mrp[$i]*$sales_qty[$i];
                    $vat = ($sales_vat[$i] / 100) * ($mrp[$i]*$sales_qty[$i]);
                    $total_vat += $vat;
                    $total_discount += $sales_discount[$i];
                    $last_purchase = $this->inventory_model->get_last_purchase($product_id[$i]);
                    if ($last_purchase) {
                        $sales_item_tp = $last_purchase->purchase_item_rate;
                    }else{
                        $sales_item_tp = 0;
                    }

                  $sales_item = array(
                    'sales_item_id' => "SII-".uniqid(),
                    'client_id' => $client_id,
                    'customer_id' => $customer_id,
                    'sales_invoice_id' => $sales_invoice_id,
                    'sales_invoice_no' => $sales_invoice_no,
                    'product_id' => $product_id[$i],
                    'sales_item_quantity' => $sales_qty[$i],
                    'sales_item_rate' => $mrp[$i],
                    'sales_item_tp' => $sales_item_tp,
                    'sales_item_vat_per' => $sales_vat[$i],
                    'sales_item_discount' => $sales_discount[$i],
                    'sales_item_amount' => $mrp[$i]*$sales_qty[$i],
                    'sales_item_date' => $sales_date,
                    'sales_item_entry_by' => $this->session->userdata('user_id'),
                    'sales_item_entry_date' => date('Y-m-d'),
                    'sales_item_created_at' => date('Y-m-d H:i:s'),
                    'sales_item_status' => 1
                );

                $this->inventory_model->add_sales_item($sales_item);

                $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                    $product_stock = $stock_info->product_stock-$sales_qty[$i];
                    $stock_item = array(
                    'product_stock' => $product_stock,
                    'stock_updated_by' => $this->session->userdata('user_id'),
                    'stock_updated_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
                  }
                //$this->inventory_model->delete_sales_item($sales_invoice_id);

                $invoice_info = array(
                    'sales_invoice_id' => $sales_invoice_id,
                    'sales_invoice_no' => $sales_invoice_no,
                    'client_id' => $client_id,
                    'customer_id' => $customer_id,
                    'sales_invoice_date' => $sales_date,
                    'sales_total_amount' => $sum,
                    'sales_total_vat' => $total_vat,
                    'sales_invoice_discount' => $invoice_discount,
                    'sales_total_discount' => $total_discount,
                    'sales_amount_paid' => $paid_amount,
                    'sales_advance_payment' => $balance_payment,
                    'sales_invoice_detail' => $sales_details,
                    'sales_payment_type' => $paytype,
                    'sales_payment_info' => $payment_info,
                    'sales_invoice_entry_by' => $this->session->userdata('user_id'),
                    'sales_invoice_entry_date' => date('Y-m-d'),
                    'sales_invoice_created_at' => date('Y-m-d H:i:s'),
                    'sales_invoice_status' => 1
                );
                $this->inventory_model->add_sales_invoice($invoice_info);


                 //$previous_balance = $this->input->post('pprevious_balance');
                
                 $payable = $sum-($invoice_discount+$total_discount);
                 //$due = $payable- $paid_amount;
                 if ($balance_payment > 0) {
                   
                 $cr_check_balance = $this->inventory_model->get_customer_transaction($customer_id);
                 if ($cr_check_balance) {
                        $cr_current_balance = $cr_check_balance->customer_transaction_balance-$balance_payment;
                    }else{
                        $cr_current_balance = -$balance_payment;
                    }

                    $cr_transaction_info = array(
                        'customer_ledger_id' => "CTI-".uniqid(),
                        'client_id' => $this->session->userdata('client_code'),
                        'customer_transaction_date' => $sales_date,
                        'customer_id' => $customer_id,
                        'customer_transaction_type' => "Credit(-)",
                        'customer_transaction_amount' => $balance_payment,
                        'customer_transaction_balance' => $cr_current_balance,
                        'customer_transaction_description' => "Sales Payment Adjustment of Invoice# ".$sales_invoice_no,
                        'customer_transaction_entry_by' => $this->session->userdata('user_id'),
                        'customer_transaction_entry_date' => date('Y-m-d'),
                        'customer_transaction_created_at' => date('Y-m-d H:i:s'),
                        'customer_transaction_status' => 1
                    );
                    if ($customer_org) {
                    $this->inventory_model->save_customer_transaction($cr_transaction_info);
                    }

                

                
                }

                $customer_payment = array(
                'customer_payment_id' => $customer_payment_id ,
                'client_id' => $client_id,
                'customer_id' => $customer_id,
                'customer_payment_date' => $sales_date,
                'customer_payment_amount' => $paid_amount,
                'customer_payment_entry_by' => $this->session->userdata('user_id'),
                'customer_payment_entry_date' => date('Y-m-d'),
                'customer_payment_created_at' => date('Y-m-d H:i:s'),
                'customer_payment_status' => 1
            );
            $this->inventory_model->add_customer_payment($customer_payment);

            $payment_info = array(
                    'sales_payment_id' => "SIP-".uniqid(),
                    'customer_payment_id' => $customer_payment_id,
                    'sales_invoice_id' => $sales_invoice_id,
                    'sales_invoice_no' => $sales_invoice_no,
                    'client_id' => $client_id,
                    'customer_id' => $customer_id,
                    'sales_payment_date' => $sales_date,
                    'sales_payment_amount' => $paid_amount,
                    'sales_payment_entry_by' => $this->session->userdata('user_id'),
                    'sales_payment_entry_date' => date('Y-m-d'),
                    'sales_payment_created_at' => date('Y-m-d H:i:s'),
                    'sales_payment_status' => 1
                );
                $this->inventory_model->add_sales_payment($payment_info);

                

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Product Sales Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("sales-detail/".$sales_invoice_id);
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
               redirect("new-sales"); 
            }
    }

    //Sales detail
    public function sales_detail($sales_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $discount = $sales_info->sales_invoice_discount+$sales_info->sales_total_discount;
        $total = $sales_info->sales_total_amount+$sales_info->sales_total_vat-$discount;
        
        
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->sales_total_vat;
        $data['paid_amount'] = $sales_info->sales_amount_paid;
        $data['due'] = $total-$sales_info->sales_amount_paid-$sales_info->sales_advance_payment;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_sales_item($sales_invoice_id);
        $data['main_content'] = $this->load->view('home/sales_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Sales detail print
    public function sales_detail_print($sales_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
         $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $discount = $sales_info->sales_invoice_discount+$sales_info->sales_total_discount;
        $total = $sales_info->sales_total_amount+$sales_info->sales_total_vat-$discount;
        
        $paid_amount = $sales_info->sales_amount_paid+$sales_info->sales_advance_payment;
        $due = $total-$paid_amount;
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->sales_total_vat;
        $data['paid_amount'] = $paid_amount;
        $data['due'] = $due;
        $data['discount'] = $discount;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_sales_item($sales_invoice_id);
        $data['main_content'] = $this->load->view('home/sales_invoice_pdf', $data,true);
        $this->load->view('home/client_home', $data);
    }

        //Sales challan print
    public function sales_challan_print($sales_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $data['sales_info'] =  $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_sales_item($sales_invoice_id);
        $data['main_content'] = $this->load->view('home/sales_challan_pdf', $data,true);
        $this->load->view('home/client_home', $data);
    }


    //Sales edit
    public function sales_edit_form($sales_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $discount = $sales_info->sales_invoice_discount+$sales_info->sales_total_discount;
        $total = $sales_info->sales_total_amount+$sales_info->sales_total_vat-$discount;
        $balance = $total-$sales_info->sales_amount_paid;
        if ($balance >= 0) {
          $due = $balance;
        }else {$due = 0;}
        $paid_amount = $total-$due;
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->sales_total_vat;
        $data['paid_amount'] = $paid_amount;
        $data['due'] = $due;
        $data['sales_info'] = $sales_info;
        $data['sales_item'] = $this->inventory_model->get_sales_item($sales_invoice_id);
        $data['main_content'] = $this->load->view('home/sales_edit_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales Entry save
    public function save_sales_edit($sales_invoice_id)
        {
            $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
            $sales_item = $this->inventory_model->get_sales_item($sales_invoice_id);
            $sales_payment = $this->inventory_model->get_sales_payment($sales_invoice_id);

            foreach ($sales_item as $sitem) {
                $item_stock = $this->inventory_model->get_stock_product($sitem->product_id);
                $inventory_stock = $item_stock->product_stock+$sitem->sales_item_quantity;
                $stock_info = array(
                'product_stock' => $inventory_stock,
                'stock_updated_by' => $this->session->userdata('user_id'),
                'stock_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_product_stock($stock_info, $sitem->product_id);
            }
            $this->inventory_model->delete_sales_item($sales_invoice_id);

            $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));
            if($temp != 0){
                
                $customer_name = $this->input->post('customer_name');
                $customer_mobile = $this->input->post('customer_mobile');
                $sales_date = $this->input->post('sales_date');
                $paytype = $this->input->post('paytype');
                if($paytype == "Bank"){
                    $payment_info = $this->input->post('sales_bank');
                }else if($paytype == "Mobile"){
                    $payment_info = $this->input->post('sales_bkash');
                }else if($paytype == "Card"){
                    $payment_info = $this->input->post('sales_card');
                }else{
                    $payment_info = "N/A";
                }
                
                $mrp = $this->input->post('mrp');
                $sales_qty = $this->input->post('sales_qty');
                $sales_vat = $this->input->post('sales_vat');
                $sales_discount = $this->input->post('sales_discount');
                $sales_details = $this->input->post('sales_details');
                $invoice_discount = $this->input->post('invoice_discount');
                $paid_amount = $this->input->post('paid_amount');
                $sum = 0;
                $total_vat = 0;
                $total_discount = 0;
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                    $sum += $mrp[$i]*$sales_qty[$i];
                    $vat = ($sales_vat[$i] / 100) * ($mrp[$i]*$sales_qty[$i]);
                    $total_vat += $vat;
                    $total_discount += $sales_discount[$i];
                    $last_purchase = $this->inventory_model->get_last_purchase($product_id[$i]);
                    if ($last_purchase) {
                        $sales_item_tp = $last_purchase->purchase_item_rate;
                    }else{
                        $sales_item_tp = 0;
                    }

                  $sales_item = array(
                    'sales_item_id' => "SII-".uniqid(),
                    'customer_id' => $sales_info->customer_id,
                    'sales_invoice_id' => $sales_invoice_id,
                    'sales_invoice_no' => $sales_info->sales_invoice_no,
                    'product_id' => $product_id[$i],
                    'sales_item_quantity' => $sales_qty[$i],
                    'sales_item_rate' => $mrp[$i],
                    'sales_item_tp' => $sales_item_tp,
                    'sales_item_vat_per' => $sales_vat[$i],
                    'sales_item_discount' => $sales_discount[$i],
                    'sales_item_amount' => $mrp[$i]*$sales_qty[$i],
                    'sales_item_date' => $sales_date,
                    'sales_item_entry_by' => $this->session->userdata('user_id'),
                    'sales_item_entry_date' => date('Y-m-d'),
                    'sales_item_created_at' => date('Y-m-d H:i:s'),
                    'sales_item_status' => 1
                );

                $this->inventory_model->add_sales_item($sales_item);

                $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                    $product_stock = $stock_info->product_stock-$sales_qty[$i];
                    $stock_item = array(
                    'product_stock' => $product_stock,
                    'stock_updated_by' => $this->session->userdata('user_id'),
                    'stock_updated_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
                  }

                $invoice_info = array(
                    'sales_invoice_date' => $sales_date,
                    'sales_total_amount' => $sum,
                    'sales_total_vat' => $total_vat,
                    'sales_invoice_discount' => $invoice_discount,
                    'sales_total_discount' => $total_discount,
                    'sales_amount_paid' => $paid_amount,
                    'sales_invoice_detail' => $sales_details,
                    'sales_payment_type' => $paytype,
                    'sales_payment_info' => $payment_info,
                    'sales_invoice_updated_by' => $this->session->userdata('user_id'),
                    'sales_invoice_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_sales_invoice($invoice_info, $sales_invoice_id);

                $payment_info = array(
                    'sales_payment_date' => $sales_date,
                    'sales_payment_amount' => $paid_amount,
                    'sales_payment_updated_by' => $this->session->userdata('user_id'),
                    'sales_payment_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_sales_payment($payment_info, $sales_payment->sales_payment_id);

                $customer_info = array(
                    'customer_name' => $customer_name,
                    'customer_mobile' => $customer_mobile,
                    'customer_updated_by' => $this->session->userdata('user_id'),
                    'customer_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_customer($customer_info, $sales_info->customer_id);

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Sales Update Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("sales-detail/".$sales_invoice_id);
            }else{
               $invoice_info = array(
                    'sales_invoice_status' => 0,
                    'sales_invoice_updated_by' => $this->session->userdata('user_id'),
                    'sales_invoice_updated_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->update_sales_invoice($invoice_info, $sales_invoice_id);

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Sales Update Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("manage-sales");

               //  $sdata = array();
               //  $sdata['error'] = "<div class='alert alert-danger fade in'>Fill up at least one Product!</div>";
               //  $this->session->set_userdata($sdata);
               // redirect("sales-edit/".$sales_invoice_id); 
            }
    }



    // sales list
    public function sales_invoice_list()
    {
            $data = array();
            $data['main'] = true;
            $data['sales_info'] = $this->inventory_model->get_sales_list();
            $data['main_content'] = $this->load->view('home/sales_invoice_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

    // sales search
    public function sales_return_search()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/sales_return_search', $data,true);
        $this->load->view('home/client_home', $data);    
    }

    //sales search
    public function sales_return_search_list()
     {
      $output = '';
     $query = $this->input->post('query');
     

      $data = $this->inventory_model->fetch_sales_return_search_list($query);
         
      $output .= '
      <table class="table table-bordered table-striped table-hover" id="example1">
        <thead>
            <tr>
              <th width="30">SL.</th>
              <th>Date</th>
              <th>Invoice#</th>
              <th>Customer</th>
              <th>Contact No.</th>
              <th>Payable</th>
              <th>Paid</th>
              <th>Balance</th>
              <th>Action</th>
            </tr>
            </thead>
        <tbody>
      ';
      if($query != "" && $data->num_rows() > 0)
      {
        $x=1;
       foreach($data->result() as $info)
       {
        $discount = $info->sales_invoice_discount+$info->sales_total_discount;
        $total = $info->sales_total_amount-$discount+$info->sales_total_vat;
        
        $sales_amount_paid = $info->sales_amount_paid+$info->sales_advance_payment;
        $balance = $total-$sales_amount_paid;
         
            $output .= '
              <tr>
               <td>'.$x++.'</td>
               <td>'.date('d/m/Y', strtotime($info->sales_invoice_date)).'</td>
               <td>'.$info->sales_invoice_no.'</td>
               <td>'.$info->customer_name.'</td>
               <td>'.$info->customer_mobile.'</td>
               <td>'.number_format((float)$total, 2, '.', '').'</td>
               <td>'.number_format((float)$sales_amount_paid, 2, '.', '').'</td>
               <td>'.number_format((float)$balance, 2, '.', '').'</td>
               <td>
                <a class="btn btn-primary btn-xs" href="'.base_url() . "sales-return-entry/" .$info->sales_invoice_id.'">Return</a>
               </td>
              </tr>
            ';
            }
      }
      
      else
      {
       $output .= '<tr>
           <td colspan="9">No Data Found</td>
          </tr>';
      }
      $output .= '</tbody></table>';
      echo $output;
     }

     //sales return form
    public function sales_return_form($sales_invoice_id)
    {
        $data = array();
        $data['main'] = true;
        $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $discount = $sales_info->sales_invoice_discount+$sales_info->sales_total_discount;
        $total = $sales_info->sales_total_amount+$sales_info->sales_total_vat-$discount-$sales_info->sales_invoice_return_total;
        $paid = $sales_info->sales_amount_paid+$sales_info->sales_advance_payment-$sales_info->sales_invoice_return_amount;
        $data['total'] = $total;

        $discount_rate = $sales_info->sales_invoice_discount/($sales_info->sales_total_amount+$sales_info->sales_total_vat-$sales_info->sales_total_discount)*100;
        $data['paid_amount'] = $sales_info->sales_amount_paid+$sales_info->sales_advance_payment-$sales_info->sales_invoice_return_amount;
        $data['due'] = $total-$paid;
        $data['discount'] = $discount;
        $data['discount_rate'] = $discount_rate;
        $data['sales_info'] = $sales_info;
        $data['sales_item'] = $this->inventory_model->get_sales_item($sales_invoice_id);
        $data['supplier_info'] = $this->inventory_model->get_supplier();
        $data['main_content'] = $this->load->view('home/sales_return_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales return save
    public function save_sales_return($sales_invoice_id)
    {
        $sales_info = $this->inventory_model->get_sales_invoice($sales_invoice_id);
        $discount_percent = ($sales_info->sales_invoice_discount/($sales_info->sales_total_amount+$sales_info->sales_total_vat-$sales_info->sales_total_discount))*100;
        
        $return_total = 0;
        $sales_return_id = "SRI-".uniqid();
        $client_id = $this->session->userdata('client_code');
        $product_id = $this->input->post('product_id');
        $sales_item_id = $this->input->post('sales_item');
        $return_qty = $this->input->post('return_qty');
        $return_rate = $this->input->post('sales_return_rate');
        $return_payment = $this->input->post('return_payment');
        $return_date = $this->input->post('return_date');
        $temp =count(array_filter($return_qty));


        if($temp != 0){
            $qty =count($sales_item_id);
            for($i=0; $i<$qty;$i++){
            $return_total += $return_rate[$i]*$return_qty[$i];
            $item = $this->inventory_model->get_sales_item_id($sales_item_id[$i]);

            $sales_item = array(
                'sales_return_item_quantity' => $item->sales_return_item_quantity+$return_qty[$i],
                'sales_item_updated_by' => $this->session->userdata('user_id'),
                'sales_item_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_sales_item($sales_item, $item->sales_item_id);

            $return_item = array(
                'sales_return_item_id' => "PRII-".uniqid(),
                'client_id' => $client_id,
                'customer_id' => $item->customer_id,
                'sales_invoice_id' => $sales_info->sales_invoice_id,
                'sales_invoice_no' => $sales_info->sales_invoice_no,
                'sales_item_id' => $item->sales_item_id,
                'sales_return_id' => $sales_return_id,
                'product_id' => $product_id[$i],
                'sales_return_quantity' => $return_qty[$i],
                'sales_return_rate' => $return_rate[$i],
                'sales_return_amount' => $return_rate[$i]*$return_qty[$i],
                'sales_return_date' => $return_date,
                'sales_return_entry_by' => $this->session->userdata('user_id'),
                'sales_return_entry_date' => date('Y-m-d'),
                'sales_return_created_at' => date('Y-m-d H:i:s'),
                'sales_return_status' => 1
            );
            $this->inventory_model->add_sales_return_item($return_item);
            $this->inventory_model->delete_sales_return_item();

            $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);

                $product_stock = $stock_info->product_stock+$return_qty[$i];
                $stock_item = array(
                'product_stock' => $product_stock,
                'stock_updated_by' => $this->session->userdata('user_id'),
                'stock_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
        }

          $invoice_discount_amount = ($discount_percent / 100) * $return_total;
          $return_net_total = $return_total-$invoice_discount_amount;
          $invoice_info = array(
            'sales_invoice_return_total' => $sales_info->sales_invoice_return_total+$return_net_total,
            'sales_invoice_return_amount' => $sales_info->sales_invoice_return_amount+$return_payment,
            'sales_invoice_updated_by' => $this->session->userdata('user_id'),
            'sales_invoice_updated_at' => date('Y-m-d H:i:s')
        );
        $this->inventory_model->update_sales_invoice($invoice_info, $sales_info->sales_invoice_id);

        
        $paytype = $this->input->post('paytype');

        if ($return_payment > 0) {
        if($paytype == "Cash"){
            $payment_info = "N/A";
            $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' =>  $client_id,
                    'cash_transaction_date' => $return_date,
                    'cash_transaction_type' => "Credit(-)",
                    'cash_transaction_amount' => $return_payment,
                    'cash_transaction_description' => "Sales Return Payment of Invoice# ".$sales_info->sales_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);

        }else if($paytype == "Bank"){
            $payment_info = $this->input->post('sales_bank');
            $transaction_info = array(
                'bank_transaction_id' => "BTI-".uniqid(),
                'client_id' => $client_id,
                'bank_id' => "Default",
                'bank_transaction_date' => $return_date,
                'bank_transaction_type' => "Credit(-)",
                'withdraw_deposit_id' => $sales_info->sales_invoice_no,
                'bank_transaction_amount' => $return_payment,
                'bank_transaction_description' => "Sales Return Payment of Invoice# ".$sales_info->sales_invoice_no,
                'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                'bank_transaction_entry_date' => date('Y-m-d'),
                'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                'bank_transaction_status' => 1
            );
            $this->inventory_model->save_bank_transaction($transaction_info);

        }
    }else{$payment_info = "N/A";}

    $return_invoice_info = array(
            'sales_return_id' => $sales_return_id,
            'sales_invoice_id' => $sales_info->sales_invoice_id,
            'sales_invoice_no' => $sales_info->sales_invoice_no,
            'client_id' => $client_id,
            'customer_id' => $sales_info->customer_id,
            'sales_return_date' => $return_date,
            'sales_return_total' => $return_net_total,
            'sales_return_amount' => $return_payment,
            'sales_return_payment_type' => $paytype,
            'sales_return_payment_info' => $payment_info,
            'sales_return_entry_by' => $this->session->userdata('user_id'),
            'sales_return_entry_date' => date('Y-m-d'),
            'sales_return_created_at' => date('Y-m-d H:i:s'),
            'sales_return_status' => 1,
        );
        $this->inventory_model->add_sales_return_invoice($return_invoice_info);
        
        
        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Product Return Successfull!</div>";
        $this->session->set_userdata($sdata);
       redirect("sales-return-detail/".$sales_return_id);    
        
        }else{
             $sdata = array();
            $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Qty!</div>";
            $this->session->set_userdata($sdata);
           redirect("sales-return-entry/".$sales_invoice_id); 
       }
    
    }

    // sales return list
    public function sales_return_list()
    {
            $data = array();
            $data['main'] = true;
            $data['sales_return_info'] = $this->inventory_model->get_sales_return();
            $data['main_content'] = $this->load->view('home/sales_return_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

      //sales return detail
    public function sales_return_detail($sales_return_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_return_detail($sales_return_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($sales_info->sales_return_total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_sales_return_item($sales_return_id);
        $data['main_content'] = $this->load->view('home/sales_return_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }
    
/////////End Sales////////////


/////////Start Supplier Payment////////////
  //suppiler due payment search
  public function supplier_invoice_payment()
  {
    $data = array();
    $data['main'] = true;
    $data['supplier_info'] = $this->inventory_model->get_supplier();
    $data['main_content'] = $this->load->view('home/supplier_invoice_payment_search', $data,true);
    $this->load->view('home/client_home', $data);    
  }

   //suppiler due payment
  public function supplier_invoice_payment_form()
  {
    // $data = array();
    // $data['main'] = true;
    $date = date('Y-m-d');
    $data = $this->cash_flow_statement_report($date);
    $supplier_id = $this->input->post('supplier_name');
    //$from_date = $this->input->post('from_date');
    //$to_date = $this->input->post('to_date');
    //$data['from_date'] = $from_date;
    //$data['to_date'] = $to_date;
    $supplier_info = $this->inventory_model->get_supplier_by_id($supplier_id);
    $data['supplier_info'] = $supplier_info;
    //$data['bill_info'] = $this->inventory_model->suppilerwise_service_bill($from_date, $to_date, $supplier_id);
    $data['bill_info'] = $this->inventory_model->suppilerwise_due_payment($supplier_id);
    $data['title'] = "Due Payments of ".$supplier_info->supplier_name;
    $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
    if ($check_balance) {
       $data['balance'] = $check_balance->supplier_transaction_balance;
    }else{
        $data['balance'] = 0;
    }
    
    $data['main_content'] = $this->load->view('home/supplier_invoice_payment_form', $data,true);
    $this->load->view('home/client_home', $data);    
  }

  //supplier payment Entry save
    public function supplier_invoice_payment_entry()
    {
        $supplier_id = $this->input->post('supplier_id');
        $purchase_invoice_id = $this->input->post('bill_id');
        $payment_amount = $this->input->post('payment_amount');
        $payment_date = $this->input->post('payment_date');
        $balance_due = $this->input->post('balance_due');
        $payment_method = $this->input->post('payment_method');
        $balance_payment = $this->input->post('advance_amount');
       
        //$payment_total = $this->input->post('payment_total');
        $payment_total = 0;
        $client_id = $this->session->userdata('client_code');

        $payment_id = "SPI-".uniqid();
          
            $qty =count($purchase_invoice_id);
            for($i=0; $i<$qty;$i++){
              $invoice_info = $this->inventory_model->get_purchase_invoice($purchase_invoice_id[$i]);
               $payment_total += $payment_amount[$i];
              $payment_info = array(
                'purchase_payment_id' => "PPI-".uniqid(),
                'supplier_payment_id' => $payment_id,
                'purchase_invoice_id' => $invoice_info->purchase_invoice_id,
                'purchase_invoice_no' => $invoice_info->purchase_invoice_no,
                'client_id' => $client_id,
                'supplier_id' => $invoice_info->supplier_id,
                'purchase_challan_no' => $invoice_info->purchase_challan_no,
                'purchase_payment_date' => $payment_date,
                'purchase_payment_amount' => $payment_amount[$i],
                'purchase_payment_entry_by' => $this->session->userdata('user_id'),
                'purchase_payment_entry_date' => date('Y-m-d'),
                'purchase_payment_created_at' => date('Y-m-d H:i:s'),
                'purchase_payment_status' => 1
            );
            $this->inventory_model->add_purchase_payment($payment_info);

            $total_paid = $invoice_info->purchase_amount_paid+$payment_amount[$i];
            $advance_paid = $invoice_info->purchase_advance_payment+$balance_payment[$i];

            //$net_payable = $invoice_info->purchase_total_amount-$invoice_info->purchase_total_amount-$invoice_info->purchase_total_discount;
            if($balance_due[$i] == 0){
                $status = 1;
            }else{
               $status = 0; 
            }


           $invoice = array(
                'purchase_amount_paid' => $total_paid,
                'purchase_advance_payment' => $advance_paid,
                'purchase_invoice_bill_status' => $status,
                'purchase_invoice_updated_by' => $this->session->userdata('user_id'),
                'purchase_invoice_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_purchase_invoice($invoice, $invoice_info->purchase_invoice_id);

            if($payment_amount[$i] != 0){
            if($payment_method[$i] == "Bank"){
                    $transaction_info = array(
                        'bank_transaction_id' => "BTI-".uniqid(),
                        'client_id' => $client_id,
                        'bank_id' => "Default",
                        'bank_transaction_date' => $payment_date,
                        'bank_transaction_type' => "Credit(-)",
                        'withdraw_deposit_id' => $invoice_info->purchase_invoice_no,
                        'bank_transaction_amount' => $payment_amount[$i],
                        'bank_transaction_description' => "Supplier Due Payment of Invoice# ".$invoice_info->purchase_invoice_no,
                        'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                        'bank_transaction_entry_date' => date('Y-m-d'),
                        'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                        'bank_transaction_status' => 1
                    );
                    $this->inventory_model->save_bank_transaction($transaction_info);
                
                }else{
                    $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' => $client_id,
                    'cash_transaction_date' => $payment_date,
                    'cash_transaction_type' => "Credit(-)",
                    'cash_transaction_amount' => $payment_amount[$i],
                    'cash_transaction_description' => "Supplier Due Payment of Invoice# ".$invoice_info->purchase_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);
                }

                 if ($balance_payment[$i] > 0) {
        
                    $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
                    if ($check_balance) {
                            $current_balance = $check_balance->supplier_transaction_balance-$balance_payment[$i];
                    }else{
                       
                            $current_balance = -$balance_payment[$i];
                    }

                    $transaction_info = array(
                        'supplier_ledger_id' => "CTI-".uniqid(),
                        'client_id' => $this->session->userdata('client_code'),
                        'supplier_transaction_date' => $payment_date,
                        'supplier_id' => $supplier_id,
                        'supplier_transaction_type' => "Credit(-)",
                        'supplier_transaction_amount' => $balance_payment[$i],
                        'supplier_transaction_balance' => $current_balance,
                        'supplier_transaction_description' => "Due Payment Adjustment Invoice# ".$invoice_info->purchase_invoice_no,
                        'supplier_transaction_entry_by' => $this->session->userdata('user_id'),
                        'supplier_transaction_entry_date' => date('Y-m-d'),
                        'supplier_transaction_created_at' => date('Y-m-d H:i:s'),
                        'supplier_transaction_status' => 1
                    );
                    $this->inventory_model->save_supplier_transaction($transaction_info);

                }


            }

        }

         $supplyer_payment = array(
                'supplier_payment_id' => $payment_id,
                'client_id' => $client_id,
                'supplier_id' => $supplier_id,
                'supplier_payment_date' => $payment_date,
                'supplier_payment_amount' => $payment_total,
                'supplier_payment_entry_by' => $this->session->userdata('user_id'),
                'supplier_payment_entry_date' => date('Y-m-d'),
                'supplier_payment_created_at' => date('Y-m-d H:i:s'),
                'supplier_payment_status' => 1
            );
            $this->inventory_model->add_supplyer_payment($supplyer_payment);

        
       

        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Entry Successfull!</div>";
        $this->session->set_userdata($sdata);
        redirect("supplier-payment-detail/".$payment_id);
        
    }


/////////End Supplier Payment////////////

/////////Start Cutomer Payment////////////
    //customer due payment search
  public function customer_invoice_payment()
  {
    $data = array();
    $data['main'] = true;
    $data['customer_info'] = $this->inventory_model->get_customer();
    $data['main_content'] = $this->load->view('home/customer_invoice_payment_search', $data,true);
    $this->load->view('home/client_home', $data);    
  }

  //customer due payment
  public function customer_invoice_payment_form()
  {
    $data = array();
    $data['main'] = true;
    $customer_id = $this->input->post('customer_id');
    //$from_date = $this->input->post('from_date');
    //$to_date = $this->input->post('to_date');
    //$data['from_date'] = $from_date;
    //$data['to_date'] = $to_date;
    $customer_info = $this->inventory_model->get_customer_by_id($customer_id);
    $data['customer_info'] = $customer_info;
    //$data['bill_info'] = $this->inventory_model->customerwise_service_bill($from_date, $to_date, $customer_id);
    $data['bill_info'] = $this->inventory_model->customerwise_due_payment($customer_id);
    $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
    if ($check_balance) {
       $data['balance'] = $check_balance->customer_transaction_balance;
    }else{
        $data['balance'] = 0;
    }

    $data['title'] = "Due Collection of ".$customer_info->customer_name;
    $data['main_content'] = $this->load->view('home/customer_invoice_payment_form', $data,true);
    $this->load->view('home/client_home', $data);    
  }

  //customer payment Entry save
    // public function customer_invoice_payment_entry()
    // {
    //     $sales_invoice_id = $this->input->post('bill_id');
    //     $payment_amount = $this->input->post('payment_amount');
    //     $payment_date = $this->input->post('payment_date');
    //     $balance_due = $this->input->post('balance_due');
    //     $client_id = $this->session->userdata('client_code');  
          
    //         $qty =count($sales_invoice_id);
    //         for($i=0; $i<$qty;$i++){
    //           $invoice_info = $this->inventory_model->get_sales_invoice($sales_invoice_id[$i]);
    //           $payment_info = array(
    //             'sales_payment_id' => "PPI-".uniqid(),
    //             'sales_invoice_id' => $invoice_info->sales_invoice_id,
    //             'sales_invoice_no' => $invoice_info->sales_invoice_no,
    //             'client_id' => $client_id,
    //             'customer_id' => $invoice_info->customer_id,
    //             'sales_payment_date' => $payment_date,
    //             'sales_payment_amount' => $payment_amount[$i],
    //             'sales_payment_entry_by' => $this->session->userdata('user_id'),
    //             'sales_payment_entry_date' => date('Y-m-d'),
    //             'sales_payment_entry_date' => date('Y-m-d H:i:s'),
    //             'sales_payment_status' => 1
    //         );
    //         $this->inventory_model->add_sales_payment($payment_info);

    //         $total_paid = $invoice_info->sales_amount_paid+$payment_amount[$i];

    //         //$net_payable = $invoice_info->sales_total_amount-$invoice_info->sales_total_amount-$invoice_info->sales_total_discount;
    //         if($balance_due[$i] == 0){
    //             $status = 1;
    //         }else{
    //            $status = 0; 
    //         }
            
    //        $invoice = array(
    //             'sales_amount_paid' => $total_paid,
    //             'sales_invoice_bill_status' => $status,
    //             'sales_invoice_updated_by' => $this->session->userdata('user_id'),
    //             'sales_invoice_updated_at' => date('Y-m-d H:i:s')
    //         );
    //         $this->inventory_model->update_sales_invoice($invoice, $invoice_info->sales_invoice_id);
    //     }

    //     $sdata = array();
    //     $sdata['success'] = "<div class='alert alert-success'>Entry Successfull!</div>";
    //     $this->session->set_userdata($sdata);
    //     redirect("customer-invoice-payment");
        
    // }

  //customer payment Entry save
    public function customer_invoice_payment_entry()
    {
        $customer_id = $this->input->post('customer_id');
        $sales_invoice_id = $this->input->post('bill_id');
        $payment_amount = $this->input->post('payment_amount');
        $payment_date = $this->input->post('payment_date');
        $balance_due = $this->input->post('balance_due');
        //$payment_total = $this->input->post('payment_total');
        $payment_total = 0;
        $payment_method = $this->input->post('payment_method');
        $client_id = $this->session->userdata('client_code');
        $balance_payment = $this->input->post('advance_amount');

        $payment_id = "CPI-".uniqid();

        
          
            $qty =count($sales_invoice_id);
            for($i=0; $i<$qty;$i++){
              $invoice_info = $this->inventory_model->get_sales_invoice($sales_invoice_id[$i]);
              $payment_total += $payment_amount[$i];
              $payment_info = array(
                'sales_payment_id' => "PPI-".uniqid(),
                'customer_payment_id' => $payment_id,
                'sales_invoice_id' => $invoice_info->sales_invoice_id,
                'sales_invoice_no' => $invoice_info->sales_invoice_no,
                'client_id' => $client_id,
                'customer_id' => $invoice_info->customer_id,
                'sales_payment_date' => $payment_date,
                'sales_payment_amount' => $payment_amount[$i],
                'sales_payment_entry_by' => $this->session->userdata('user_id'),
                'sales_payment_entry_date' => date('Y-m-d'),
                'sales_payment_created_at' => date('Y-m-d H:i:s'),
                'sales_payment_status' => 1
            );
            $this->inventory_model->add_sales_payment($payment_info);

            $total_paid = $invoice_info->sales_amount_paid+$payment_amount[$i];

            //$net_payable = $invoice_info->sales_total_amount-$invoice_info->sales_total_amount-$invoice_info->sales_total_discount;
            if($balance_due[$i] == 0){
                $status = 1;
            }else{
               $status = 0; 
            }


           $invoice = array(
                'sales_amount_paid' => $total_paid,
                'sales_invoice_bill_status' => $status,
                'sales_advance_payment' => $invoice_info->sales_advance_payment+$balance_payment[$i],
                'sales_invoice_updated_by' => $this->session->userdata('user_id'),
                'sales_invoice_updated_at' => date('Y-m-d H:i:s')
            );
            $this->inventory_model->update_sales_invoice($invoice, $invoice_info->sales_invoice_id);

            if($payment_amount[$i] != 0){
            if($payment_method[$i] == "Bank"){
                    $transaction_info = array(
                        'bank_transaction_id' => "BTI-".uniqid(),
                        'client_id' => $client_id,
                        'bank_id' => "Default",
                        'bank_transaction_date' => $payment_date,
                        'bank_transaction_type' => "Debit(+)",
                        'withdraw_deposit_id' => $invoice_info->sales_invoice_no,
                        'bank_transaction_amount' => $payment_amount[$i],
                        'bank_transaction_description' => "Customer Due Collection of Invoice# ".$invoice_info->sales_invoice_no,
                        'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                        'bank_transaction_entry_date' => date('Y-m-d'),
                        'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                        'bank_transaction_status' => 1
                    );
                    $this->inventory_model->save_bank_transaction($transaction_info);
                
                }else{
                    $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' => $client_id,
                    'cash_transaction_date' => $payment_date,
                    'cash_transaction_type' => "Debit(+)",
                    'cash_transaction_amount' => $payment_amount[$i],
                    'cash_transaction_description' => "Customer Due Collection of Invoice# ".$invoice_info->sales_invoice_no,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);
                }

                if ($balance_payment[$i] > 0) {
        
        $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
        if ($check_balance) {
                $current_balance = $check_balance->customer_transaction_balance-$balance_payment[$i];
            
        }else{
           
                $current_balance = -$balance_payment[$i];
        }

        $transaction_info = array(
            'customer_ledger_id' => "CTI-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'customer_transaction_date' => $payment_date,
            'customer_id' => $customer_id,
            'customer_transaction_type' => "Credit(-)",
            'customer_transaction_amount' => $balance_payment[$i],
            'customer_transaction_balance' => $current_balance,
            'customer_transaction_description' => "Due Payment Adjustment of Invoice# ".$invoice_info->sales_invoice_no,
            'customer_transaction_entry_by' => $this->session->userdata('user_id'),
            'customer_transaction_entry_date' => date('Y-m-d'),
            'customer_transaction_created_at' => date('Y-m-d H:i:s'),
            'customer_transaction_status' => 1
        );
        $this->inventory_model->save_customer_transaction($transaction_info);

    }
            }

        }

        $customer_payment = array(
                'customer_payment_id' => $payment_id,
                'client_id' => $client_id,
                'customer_id' => $customer_id,
                'customer_payment_date' => $payment_date,
                'customer_payment_amount' => $payment_total,
                'customer_payment_entry_by' => $this->session->userdata('user_id'),
                'customer_payment_entry_date' => date('Y-m-d'),
                'customer_payment_created_at' => date('Y-m-d H:i:s'),
                'customer_payment_status' => 1
            );
            $this->inventory_model->add_customer_payment($customer_payment);

            
     
        

        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Entry Successfull!</div>";
        $this->session->set_userdata($sdata);
        redirect("customer-payment-detail/".$payment_id);
        
    }


/////////End Cutomer Payment////////////


/////////Start inventory adjustment/////////
public function product_inventory_adjustment()
{
    $data = array();
    $data['main'] = true;
    $data['products'] = $this->inventory_model->get_product();
    $data['main_content'] = $this->load->view('home/product_inventory_adjustment_form', $data,true);
    $this->load->view('home/client_home', $data);
}

public function product_inventory_adjustment_entry()
    {
        $data = array();
        $data['main'] = true;
        $product_id = $this->input->post('product_id');
        $new_stock = $this->input->post('new_stock');
       

        
        $qty =count($product_id);
        for($i=0; $i<$qty;$i++){
             $stock_info = $this->inventory_model->get_stock_product($product_id[$i]);
        if ($stock_info) {
           $stock_info = array(
                'stock_history_id' => "SHI-".uniqid(),
                'stk_client_id' => $this->session->userdata('client_code'),
                'product_id' => $stock_info->product_id,
                'old_stock_qty' => $stock_info->product_stock,
                'new_stock_qty' => $new_stock[$i],
                'stock_unit_price' => $stock_info->product_unit_price,
                'stock_history_date' => date('Y-m-d'),
                'stock_history_entry_date' => date('Y-m-d H:i:s'),
                'stock_history_created_at' => date('Y-m-d H:i:s'),
                'stock_history_status' => 1
            );
            $this->inventory_model->add_stock_adjustment($stock_info);
        
    }

            $stock_item = array(
            'product_stock' => $new_stock[$i],
            'stock_updated_by' => $this->session->userdata('user_id'),
            'stock_updated_at' => date('Y-m-d H:i:s')
        );

        $this->inventory_model->update_product_stock($stock_item, $product_id[$i]);
          }

        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Inventory Adjustment Successfull!</div>";
        $this->session->set_userdata($sdata);
        redirect("inventory-adjustment");

    } 

    public function product_inventory_adjustment_entry_single()
    {
        $data = array();
        $data['main'] = true;
    //     $stock_info = $this->inventory_model->get_stock_info();
    //     if ($stock_info) {
    //     foreach ($stock_info as $stock) {
    //        $stock_info = array(
    //             'stock_history_id' => "SHI-".uniqid(),
    //             'stk_client_id' => $this->session->userdata('client_code'),
    //             'product_id' => $stock->product_id,
    //             'stock_qty' => $stock->product_stock,
    //             'stock_unit_price' => $stock->product_unit_price,
    //             'stock_history_date' => date('Y-m-d'),
    //             'stock_history_entry_date' => date('Y-m-d H:i:s'),
    //             'stock_history_created_at' => date('Y-m-d H:i:s'),
    //             'stock_history_status' => 1
    //         );
    //         $this->inventory_model->add_stock_histoy($stock_info);
    //     }
    // }
        $product_id = $this->input->post('product_id');
        $new_stock = $this->input->post('new_stock');
        $stock_info = $this->inventory_model->get_stock_product($product_id);
        if ($stock_info) {
           $stock_info = array(
                'stock_history_id' => "SHI-".uniqid(),
                'stk_client_id' => $this->session->userdata('client_code'),
                'product_id' => $stock_info->product_id,
                'old_stock_qty' => $stock_info->product_stock,
                'new_stock_qty' => $new_stock,
                'stock_unit_price' => $stock_info->product_unit_price,
                'stock_history_date' => date('Y-m-d'),
                'stock_history_entry_date' => date('Y-m-d H:i:s'),
                'stock_history_created_at' => date('Y-m-d H:i:s'),
                'stock_history_status' => 1
            );
            $this->inventory_model->add_stock_adjustment($stock_info);
        }
    
        $stock_item = array(
            'product_stock' => $new_stock,
            'stock_updated_by' => $this->session->userdata('user_id'),
            'stock_updated_at' => date('Y-m-d H:i:s')
        );

        $this->inventory_model->update_product_stock($stock_item, $product_id);
          

        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'>Inventory Adjustment Successfull!</div>";
        $this->session->set_userdata($sdata);
        redirect("inventory-adjustment");

    } 
/////////End inventory adjustment/////////

///////////Start bank //////////
     //bank List
    public function bank_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['bank_info'] = $this->inventory_model->get_bank();
        $data['main_content'] = $this->load->view('home/bank_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save bank Entry
    public function save_bank()
    {
        $bank_info = array(
            'bank_id' => "BNK-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'bank_name' => $this->input->post('bank_name'),
            'bank_ac_name' => $this->input->post('ac_name'),
            'bank_ac_number' => $this->input->post('ac_number'),
            'bank_branch' => $this->input->post('bank_branch'),
            'bank_entry_by' => $this->session->userdata('user_id'),
            'bank_entry_date' => date('Y-m-d'),
            'bank_created_at' => date('Y-m-d H:i:s'),
            'bank_status' => 1
        );

        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
        $this->form_validation->set_rules('ac_name', 'A/C Name', 'required');
        $this->form_validation->set_rules('ac_number', 'A/C Number', 'required');
        $this->form_validation->set_rules('bank_branch', 'Branch', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['bank_info'] = $this->inventory_model->get_bank();
            $data['main_content'] = $this->load->view('home/bank_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_bank($bank_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("bank-list");
            }
    }

  

    //bank edit Form
    public function edit_bank($bank_id)
    {
        $data = array();
        $data['main'] = true;
        $data['bank_info'] = $this->inventory_model->get_bank();
        $data['edit_info'] = $this->inventory_model->get_bank_by_id($bank_id);
        $data['main_content'] = $this->load->view('home/bank_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update bank Entry
    public function update_bank($bank_id)
    {
        $bank_info = array(
            'bank_name' => $this->input->post('bank_name'),
            'bank_ac_name' => $this->input->post('ac_name'),
            'bank_ac_number' => $this->input->post('ac_number'),
            'bank_branch' => $this->input->post('bank_branch'),
            'bank_updated_by' => $this->session->userdata('user_id'),
            'bank_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
        $this->form_validation->set_rules('ac_name', 'A/C Name', 'required');
        $this->form_validation->set_rules('ac_number', 'A/C Number', 'required');
        $this->form_validation->set_rules('bank_branch', 'Branch', 'required');
       
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['bank_info'] = $this->inventory_model->get_bank();
            $data['edit_info'] = $this->inventory_model->get_bank_by_id($bank_id);
            $data['main_content'] = $this->load->view('home/bank_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_bank($bank_info, $bank_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> Entry Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("bank-list");
            }
    }

    //bank transaction form
    public function bank_transaction_form()
    {
        $data = array();
        $data['main'] = true;
        $data['bank_info'] = $this->inventory_model->get_bank();
        $data['main_content'] = $this->load->view('home/bank_transaction_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save bank transaction
    public function bank_transaction_entry()
    {
        $transaction_info = array(
            'bank_transaction_id' => "BTI-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'bank_id' => $this->input->post('bank_ac'),
            'bank_transaction_date' => $this->input->post('tdate'),
            'bank_transaction_type' => $this->input->post('ac_type'),
            'withdraw_deposit_id' => $this->input->post('withdraw_deposit_id'),
            'bank_transaction_amount' => $this->input->post('amount'),
            'bank_transaction_description' => $this->input->post('description'),
            'bank_transaction_entry_by' => $this->session->userdata('user_id'),
            'bank_transaction_entry_date' => date('Y-m-d'),
            'bank_transaction_created_at' => date('Y-m-d H:i:s'),
            'bank_transaction_status' => 1
        );

        $this->form_validation->set_rules('tdate', 'Date', 'required');
        $this->form_validation->set_rules('ac_type', 'Account Type', 'required');
        $this->form_validation->set_rules('bank_ac', 'Bank A/C', 'required');
        $this->form_validation->set_rules('withdraw_deposit_id', 'Withdraw / Deposite ID', 'required');
        $this->form_validation->set_rules('amount', 'Amount ', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['bank_info'] = $this->inventory_model->get_bank();
            $data['main_content'] = $this->load->view('home/bank_transaction_form', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_bank_transaction($transaction_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("bank-transaction");
            }
    }

    //bank ledger form
    public function bank_ledger_form()
    {
        $data = array();
        $data['main'] = true;
        $data['bank_info'] = $this->inventory_model->get_bank();
        $data['bank_ledger'] = "";
        $data['main_content'] = $this->load->view('home/report_bank_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //ledger report
    public function datewise_bank_ledger_report()
    {
        $data = array();
        $data['main'] = true;
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $bank_id = $this->input->post('bank_ac');
        $client_id = $this->session->userdata('client_code');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['bank_info'] = $this->inventory_model->get_bank();
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['bank_data'] = $this->inventory_model->get_bank_by_id($bank_id);
        $pre_date = date("Y-m-d", strtotime(' -1 day', strtotime($from_date)));
        $opening_bank_debit = $this->inventory_model->opening_debit_bank_by_date($pre_date);
        $opening_bank_credit = $this->inventory_model->opening_credit_bank_by_date($pre_date);
        $opening_bank_balance = $opening_bank_debit->bank_transaction_amount-$opening_bank_credit->bank_transaction_amount;
        $data['bank_ledger'] = $this->inventory_model->get_bank_ledger_by_date($from_date, $to_date, $bank_id);
        $data['opening_bank_balance'] = $opening_bank_balance;
        $data['main_content'] = $this->load->view('home/report_bank_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }

///////////End bank //////////
  

/////////Start Report//////////// 
   //all report toady
        public function purchase_sales_report_today()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['sales_info'] = $this->inventory_model->get_sales_invoice_by_date($from_date, $to_date);
            $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_purchase_sales_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //all report toady
        public function datewise_purchase_sales()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['sales_info'] = $this->inventory_model->get_sales_invoice_by_date($from_date, $to_date);
            $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_purchase_sales_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        public function purchase_report()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['title'] = "Purchase Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_purchase_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }


        public function datewise_purchase()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $supplier_id = $this->input->post('supplier_id');
            $product_id = $this->input->post('product_id');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
             if ($supplier_id) {
                $supplier = $this->inventory_model->get_supplier_by_id($supplier_id);
                $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_supplier($from_date, $to_date, $supplier_id);
                $data['title'] = "Purchase Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date))." for ". $supplier->supplier_name;
                $data['main_content'] = $this->load->view('home/report_purchase_datewise', $data,true);
              }else if($product_id){
                $data['purchase_info'] = $this->inventory_model->get_purchase_product_by_id($from_date, $to_date, $product_id);
                $product = $this->inventory_model->get_product_by_id($product_id);
                $data['title'] = $product->product_name." <br>Purchase Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
                $data['main_content'] = $this->load->view('home/report_purchase_productwise', $data,true);
            }else{
            $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['title'] = "Purchase Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['main_content'] = $this->load->view('home/report_purchase_datewise', $data,true);
            }
            
            $this->load->view('home/client_home', $data);
        }

        public function sales_report()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['title'] = "Sales Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['sales_info'] = $this->inventory_model->get_sales_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_sales_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }


        public function datewise_sales()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $customer_id = $this->input->post('customer_id');
            $client_id = $this->session->userdata('client_code');
            $product_id = $this->input->post('product_id');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if ($customer_id) {
                $customer = $this->inventory_model->get_customer_by_id($customer_id);
                $data['sales_info'] = $this->inventory_model->get_purchase_invoice_by_customer($from_date, $to_date, $customer_id);
                $data['title'] = "Sales Report : "."Fromm ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date))." for ". $customer->customer_name;
                $data['main_content'] = $this->load->view('home/report_sales_datewise', $data,true);
            }else if($product_id){
                $data['sales_info'] = $this->inventory_model->get_sales_product_by_id($from_date, $to_date, $product_id);
                $product = $this->inventory_model->get_product_by_id($product_id);
                $data['title'] = $product->product_name." <br>sales Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
                $data['main_content'] = $this->load->view('home/report_sales_productwise', $data,true);    
            }else{
            $data['title'] = "Sales Report : "."From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['sales_info'] = $this->inventory_model->get_sales_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_sales_datewise', $data,true);
        }
            
            $this->load->view('home/client_home', $data);
        }

        //profit loss report toady
        public function profit_loss_report_today()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data['product_info'] = "";
            $data['customer_info'] = "";
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['sales_info'] = $this->inventory_model->get_sales_item_by_date($from_date, $to_date);
            $sales_invoice = $this->inventory_model->get_sales_sum_by_date($from_date, $to_date);
            $purchase_discount = $this->inventory_model->get_purchase_discount_by_date($from_date, $to_date);
            $data['invoice_discount'] = $sales_invoice->sales_invoice_discount;
            $data['purchase_discount'] = $purchase_discount->purchase_invoice_discount+$purchase_discount->purchase_total_discount;
            $data['expense_ledger'] = $this->inventory_model->get_expense_total_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_profit_loss_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //profit loss report toady
        public function profit_loss_report_datewise()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $product_id = $this->input->post('product_id');
            $customer_id = $this->input->post('customer_id');
            $client_id = $this->session->userdata('client_code');

            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if($product_id){
                $data['product_info'] = $this->inventory_model->get_product_by_id($product_id);
                $data['customer_info'] = "";
                $data['sales_info'] = $this->inventory_model->get_sales_item_by_product($from_date, $to_date, $product_id);
                $data['invoice_discount'] = 0;
            }else if ($customer_id) {
                $data['product_info'] = "";
                $data['customer_info'] = $this->inventory_model->get_customer_by_id($customer_id);
                $data['sales_info'] = $this->inventory_model->get_sales_item_by_customer($from_date, $to_date, $customer_id);
                $sales_invoice = $this->inventory_model->get_sales_sum_by_customer($from_date, $to_date, $customer_id);
                $data['invoice_discount'] = $sales_invoice->sales_invoice_discount;
            }else{
            $sales_invoice = $this->inventory_model->get_sales_sum_by_date($from_date, $to_date);
            $purchase_discount = $this->inventory_model->get_purchase_discount_by_date($from_date, $to_date);
            $data['invoice_discount'] = $sales_invoice->sales_invoice_discount;
            $data['purchase_discount'] = $purchase_discount->purchase_invoice_discount+$purchase_discount->purchase_total_discount;
            $data['expense_ledger'] = $this->inventory_model->get_expense_total_by_date($from_date, $to_date);
            $data['product_info'] = "";
            $data['customer_info'] = "";
            $data['sales_info'] = $this->inventory_model->get_sales_item_by_date($from_date, $to_date);
            }
            
            $data['main_content'] = $this->load->view('home/report_profit_loss_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //purchase report toady
        public function purchase_report_today()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data['product_info'] = "";
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['purchase_info'] = $this->inventory_model->get_purchase_item_by_date($from_date, $to_date);
            $purchase_invoice = $this->inventory_model->get_purchase_sum_by_date($from_date, $to_date);
            $data['invoice_discount'] = $purchase_invoice->purchase_invoice_discount;
            $data['main_content'] = $this->load->view('home/report_purchase_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //purchase report toady
        public function purchase_report_datewise()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $product_id = $this->input->post('product_id');
            $client_id = $this->session->userdata('client_code');

            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if($product_id){
                $data['product_info'] = $this->inventory_model->get_product_by_id($product_id);
                $data['purchase_info'] = $this->inventory_model->get_purchase_item_by_product($from_date, $to_date, $product_id);
                $data['invoice_discount'] = 0;
            }else{
            $purchase_invoice = $this->inventory_model->get_purchase_sum_by_date($from_date, $to_date);
            $data['invoice_discount'] = $purchase_invoice->purchase_invoice_discount;
            $data['product_info'] = "";
            $data['purchase_info'] = $this->inventory_model->get_purchase_item_by_date($from_date, $to_date);
            }
            
            $data['main_content'] = $this->load->view('home/report_purchase_datewise', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //purchase report toady
        public function datewise_purchase_report()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
             $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_purchase_invoice', $data,true);
            $this->load->view('home/client_home', $data);
        }

        public function datewise_purchase_report_search()
        {
            $data = array();
            $data['main'] = true;
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
             $data['purchase_info'] = $this->inventory_model->get_purchase_invoice_by_date($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_purchase_invoice', $data,true);
            $this->load->view('home/client_home', $data);
        }


        //supplier ledger
         public function supplier_ledger()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Supplier Advance Ledger";
            $data['supplier_info'] = $this->inventory_model->get_supplier();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['purchase_info'] = $this->inventory_model->get_purchase_list();
            //$data['ledger'] = $this->inventory_model->get_supplier_ledger();
            $data['ledger'] = $this->inventory_model->get_supplier_ledger_datewise($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_supplier_ledger', $data,true);
            $this->load->view('home/client_home', $data);
        } 

        //supplier ledger
         public function supplierwise_ledger()
        {
            $data = array();
            $data['main'] = true;
            $supplier_id = $this->input->post('supplier_id');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if ($supplier_id && $from_date =="" && $to_date =="") {
               $supplier =$this->inventory_model->get_supplier_by_id($supplier_id);
               $data['title'] = "Supplier Advance Ledger of ".$supplier->supplier_name ." | ".$supplier->supplier_mobile;
                //$data['purchase_info'] = $this->inventory_model->get_purchase_list_by_supplier($supplier_id);
               $data['ledger'] = $this->inventory_model->get_supplier_ledger_by_supplier($supplier_id);
                $data['main_content'] = $this->load->view('home/report_supplierwise_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }else if ($supplier_id && $from_date && $to_date) {
               $supplier =$this->inventory_model->get_supplier_by_id($supplier_id);
               $data['title'] = "Supplier Advance Ledger of ".$supplier->supplier_name." | ".$supplier->supplier_mobile." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                //$data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list_by_supplier($supplier_id, $from_date, $to_date);
               $data['ledger'] = $this->inventory_model->get_supplier_ledger_by_date($supplier_id, $from_date, $to_date);

                $data['main_content'] = $this->load->view('home/report_supplierwise_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }else{
                //redirect('supplier-ledger');
                $data['ledger'] = $this->inventory_model->get_supplier_ledger_datewise($from_date, $to_date);
                $data['title'] = "Supplier Ledger From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
            $data['main_content'] = $this->load->view('home/report_supplier_ledger', $data,true);
            $this->load->view('home/client_home', $data);
            }
            
        } 


        //customer ledger
         public function customer_ledger()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Customer Ledger";
            $data['customer_info'] = $this->inventory_model->get_customer();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['sales_info'] = $this->inventory_model->get_sales_list();
            //$data['ledger'] = $this->inventory_model->get_customer_ledger();
            $data['ledger'] = $this->inventory_model->get_customer_ledger_datewise($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_customer_ledger', $data,true);
            $this->load->view('home/client_home', $data);
        }

       //customer ledger
        //  public function customerwise_ledger()
        // {
        //     $data = array();
        //     $data['main'] = true;
        //     $customer_id = $this->input->post('customer_id');
        //     $from_date = $this->input->post('from_date');
        //     $to_date = $this->input->post('to_date');
        //     $client_id = $this->session->userdata('client_code');
        //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //     if ($customer_id && $from_date =="" && $to_date =="") {
        //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
        //        $data['title'] = "Customer Ledger of ".$customer->customer_name ;
        //         $data['sales_info'] = $this->inventory_model->get_sales_list_by_customer($customer_id);
        //         $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else if ($customer_id && $from_date && $to_date) {
        //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
        //        $data['title'] = "Customer Ledger of ".$customer->customer_name." Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
        //         $data['sales_info'] = $this->inventory_model->get_datwise_sales_list_by_customer($customer_id, $from_date, $to_date);
        //         $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else{
        //         redirect('customer-ledger');
        //     }
            
        // } 

        //  public function customerwise_ledger()
        // {
        //     $data = array();
        //     $data['main'] = true;
        //     $customer_id = $this->input->post('customer_id');
        //     $from_date = $this->input->post('from_date');
        //     $to_date = $this->input->post('to_date');
        //     $client_id = $this->session->userdata('client_code');
        //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //     if ($customer_id && $from_date =="" && $to_date =="") {
        //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
        //        $data['title'] = "Customer Ledger of ".$customer->customer_name ;
        //         $data['sales_info'] = $this->inventory_model->get_sales_list_by_customer($customer_id);
        //         $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else if ($customer_id && $from_date && $to_date) {
        //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
        //        $data['title'] = "Customer Ledger of ".$customer->customer_name." Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
        //         $data['sales_info'] = $this->inventory_model->get_datwise_sales_list_by_customer($customer_id, $from_date, $to_date);
        //         $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else{
        //         redirect('customer-ledger');
        //     }
            
        // } 

             //customer ledger
         public function customerwise_ledger()
        {
            $data = array();
            $data['main'] = true;
            $customer_id = $this->input->post('customer_id');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if ($customer_id && $from_date =="" && $to_date =="") {
               $customer =$this->inventory_model->get_customer_by_id($customer_id);
               $data['title'] = "Customer Ledger of ".$customer->customer_name ." | ".$customer->customer_mobile;
                //$data['purchase_info'] = $this->inventory_model->get_purchase_list_by_customer($customer_id);
               $data['ledger'] = $this->inventory_model->get_customer_ledger_by_customer($customer_id);
                $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }else if ($customer_id && $from_date && $to_date) {
               $customer =$this->inventory_model->get_customer_by_id($customer_id);
               $data['title'] = "customer Ledger of ".$customer->customer_name." | ".$customer->customer_mobile." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                //$data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list_by_customer($customer_id, $from_date, $to_date);
               $data['ledger'] = $this->inventory_model->get_customer_ledger_by_date($customer_id, $from_date, $to_date);

                $data['main_content'] = $this->load->view('home/report_customerwise_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }else{
                //redirect('customer-ledger');
                 $data['title'] = "Customer Ledger From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['ledger'] = $this->inventory_model->get_customer_ledger_datewise($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_customer_ledger', $data,true);
            $this->load->view('home/client_home', $data);
            }
            
        } 

        //supplier due
         public function supplier_due_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Supplier Due Report";
            $data['supplier_info'] = $this->inventory_model->get_supplier();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['main_content'] = $this->load->view('home/report_supplier_due', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //supplier due
         public function supplierwise_due()
        {
            $data = array();
            $data['main'] = true;
            $supplier_id = $this->input->post('supplier_id');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if ($supplier_id && $from_date =="" && $to_date =="") {
                $supplier = $this->inventory_model->get_supplier_by_id($supplier_id);
                $data['title'] = "Supplier Due Report of ".$supplier->supplier_name;
                $data['supplier_info'] =  $supplier;
                $data['due'] =  $this->inventory_model->get_supplier_due($supplier_id);
                $data['main_content'] = $this->load->view('home/report_supplierwise_due', $data,true);
                $this->load->view('home/client_home', $data);
            }else if ($supplier_id && $from_date && $to_date) {
                $supplier = $this->inventory_model->get_supplier_by_id($supplier_id);
                $data['title'] = "Supplier Due Report of ".$supplier->supplier_name." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['supplier_info'] =  $supplier;
                $data['due'] =  $this->inventory_model->get_datewise_supplier_due($supplier_id, $from_date, $to_date);
                $data['main_content'] = $this->load->view('home/report_supplierwise_due', $data,true);
                $this->load->view('home/client_home', $data);

            }else if ($supplier_id == "" && $from_date && $to_date) {
                
                $data['title'] = "Supplier Due Report From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['supplier_info'] = $this->inventory_model->get_supplier();
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
                $data['main_content'] = $this->load->view('home/report_datesupplierwise_due', $data,true);
                $this->load->view('home/client_home', $data);
            }else{
                redirect('supplier-due-report');
            }
            
            
            
        }

        //customer due
         public function customer_due_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Customer Due Report";
            $data['customer_info'] = $this->inventory_model->get_customer();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['main_content'] = $this->load->view('home/report_customer_due', $data,true);
            $this->load->view('home/client_home', $data);
        }

        //customer due
         public function customerwise_due()
        {
            $data = array();
            $data['main'] = true;
            $customer_id = $this->input->post('customer_id');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            if ($customer_id && $from_date =="" && $to_date =="") {
                $customer = $this->inventory_model->get_customer_by_id($customer_id);
                $data['title'] = "Customer Due Report of ".$customer->customer_name;
                $data['customer_info'] =  $customer;
                $data['due'] =  $this->inventory_model->get_customer_due($customer_id);
                $data['main_content'] = $this->load->view('home/report_customerwise_due', $data,true);
                $this->load->view('home/client_home', $data);
            }else if ($customer_id && $from_date && $to_date) {
                $customer = $this->inventory_model->get_customer_by_id($customer_id);
                $data['title'] = "Customer Due Report of ".$customer->customer_name." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['customer_info'] =  $customer;
                $data['due'] =  $this->inventory_model->get_datewise_customer_due($customer_id, $from_date, $to_date);
                $data['main_content'] = $this->load->view('home/report_customerwise_due', $data,true);
                $this->load->view('home/client_home', $data);

            }else if ($customer_id == "" && $from_date && $to_date) {
                
                $data['title'] = "Customer Due Report From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['customer_info'] = $this->inventory_model->get_customer();
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
                $data['main_content'] = $this->load->view('home/report_datecustomerwise_due', $data,true);
                $this->load->view('home/client_home', $data);
            }else{
                redirect('customer-due-report');
            }
        }

        //stock
        public function stock_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $data['product_cat_info'] = $this->inventory_model->get_product_category();
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['title'] = "Total Stock Report of ".date("d/m/Y");
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['products'] = $this->inventory_model->get_product();
            $data['main_content'] = $this->load->view('home/report_current_stock', $data,true);
            $this->load->view('home/client_home', $data);
        }  

        //stock
        public function stock_search()
        {
            $data = array();
            $data['main'] = true;
            $category = $this->input->post('category');
            $product_id = $this->input->post('product_id');
            $brand = $this->input->post('brand');
            $client_id = $this->session->userdata('client_code');
            $data['product_cat_info'] = $this->inventory_model->get_product_category();
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            
            if ($category) {
                $category_info = $this->inventory_model->get_product_category_by_id($category);
               $data['title'] = "Stock Report of ". $category_info->product_category_name." Category. " .date("d/m/Y");;
               $data['products'] = $this->inventory_model->get_product_by_category($category);
            }else if ($product_id) {
                $product = $this->inventory_model->get_product_by_id($product_id);
                 $data['title'] = "Stock Report of ". $product->product_name." Product. ".date("d/m/Y");;
               $data['products'] = $this->inventory_model->get_product_by_priduct($product_id);
            }else if ($brand) {
                $brand_info = $this->inventory_model->get_manufacturer_by_id($brand);
                $data['title'] = "Stock Report of ". $brand_info->man_name." Brand/Manufacturer. ".date("d/m/Y");;
               $data['products'] = $this->inventory_model->get_product_by_manufacturer($brand);
            }else{
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-danger'>Select Category, Brand or Product.</div>";
                $this->session->set_userdata($sdata);
                redirect("stock-report");
            }
            
            $data['main_content'] = $this->load->view('home/report_current_stock', $data,true);
            $this->load->view('home/client_home', $data);
        } 

        //stock
        public function stock_history_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $data['product_cat_info'] = $this->inventory_model->get_product_category();
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['title'] = "Stock History on ". date('d-m-Y');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['products'] = $this->inventory_model->get_product();
            $data['date'] = date('Y-m-d');
            $data['main_content'] = $this->load->view('home/report_stock_history', $data,true);
            $this->load->view('home/client_home', $data);
        }  

        //stock
        public function stock_history_search_report()
        {
            $data = array();
            $data['main'] = true;
            $history_date = $this->input->post('history_date');
            $category = $this->input->post('category');
            $product_id = $this->input->post('product_id');
            $brand = $this->input->post('brand');
            $client_id = $this->session->userdata('client_code');
            $data['product_cat_info'] = $this->inventory_model->get_product_category();
            $data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['date'] = $history_date;
            
            if ($category) {
                $category_info = $this->inventory_model->get_product_category_by_id($category);
               $data['title'] = "Stock History on ". $category_info->product_category_name." Category.";
               $data['products'] = $this->inventory_model->get_product_by_category($category);
            }else if ($product_id) {
                $product = $this->inventory_model->get_product_by_id($product_id);
                 $data['title'] = "Stock History on ". $product->product_name." Product.";
               $data['products'] = $this->inventory_model->get_product_by_priduct($product_id);
            }else if ($brand) {
                $brand_info = $this->inventory_model->get_manufacturer_by_id($brand);
                $data['title'] = "Stock History on ". $brand_info->man_name." Brand/Manufacturer.";
               $data['products'] = $this->inventory_model->get_product_by_manufacturer($brand);
            }else{
                // $sdata = array();
                // $sdata['success'] = "<div class='alert alert-danger'>Select Category, Brand or Product.</div>";erdata($sdata);
                // redirect("stock-history-report
                // $this->session->set_us");
                 $data['title'] = "Stock History on ".$history_date;
                 $data['products'] = $this->inventory_model->get_product();
                
            }
            
            $data['main_content'] = $this->load->view('home/report_stock_history', $data,true);
            $this->load->view('home/client_home', $data);
        } 

        //low stock
        public function low_stock_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            //$data['product_cat_info'] = $this->inventory_model->get_product_category();
            //$data['manufacturer_info'] = $this->inventory_model->get_manufacturer();
            $data['title'] = "Low Stock Report";
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['products'] = $this->inventory_model->get_product();
             $data['products'] = $this->inventory_model->get_low_stock();
            $data['main_content'] = $this->load->view('home/report_low_stock', $data,true);
            $this->load->view('home/client_home', $data);
        }

         //user List
    public function user_collection_payment()
    {
        $data = array();
        $data['main'] = true;
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $user_id = $this->input->post('user');
        //$from_date = date('Y-m-d');
        //$to_date = date('Y-m-d');
        if ($from_date && $to_date) {
            $data['title'] = "User Collection & Payment from ". date("d/m/Y", strtotime($from_date))." to ". date("d/m/Y", strtotime($to_date));
        }else{
           $data['title'] = "User Collection & Payment of ". date('d-m-Y'); 
        }
        $client_id = $this->session->userdata('client_code');
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['user_id'] = $user_id;
        $data['user_info'] = $this->inventory_model->get_all_user();
        $data['main_content'] = $this->load->view('home/report_user_collection_payment', $data,true);
        $this->load->view('home/client_home', $data);
    }       
/////////End Report////////////


    //supplier patment list
    public function supplier_payment_list()
    {
        $data = array();
        $data['main'] = true;
        $data['payment_info'] = $this->inventory_model->get_supplier_payment();
        $data['main_content'] = $this->load->view('home/supplier_payment_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Sales detail
    public function supplier_payment_detail($payment_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $payment_info = $this->inventory_model->get_supplier_payment_info($payment_id);
        
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($payment_info->supplier_payment_amount);
        $data['payment_info'] = $payment_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['payment_item'] = $this->inventory_model->get_supplier_item($payment_id);
        $data['main_content'] = $this->load->view('home/supplier_payment_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //customer patment list
    public function customer_payment_list()
    {
        $data = array();
        $data['main'] = true;
        $data['payment_info'] = $this->inventory_model->get_customer_payment();
        $data['main_content'] = $this->load->view('home/customer_payment_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //Sales detail
    public function customer_payment_detail($payment_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $payment_info = $this->inventory_model->get_customer_payment_info($payment_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($payment_info->customer_payment_amount);
        $data['payment_info'] = $payment_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['payment_item'] = $this->inventory_model->get_customer_item($payment_id);
        $data['main_content'] = $this->load->view('home/customer_payment_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //cash transaction form
    public function cash_transaction_form()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/cash_transaction_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save cash transaction
    public function cash_transaction_entry()
    {
        $transaction_info = array(
            'cash_transaction_id' => "CTI-".uniqid(),
            'client_id' => $this->session->userdata('client_code'),
            'cash_transaction_date' => $this->input->post('tdate'),
            'cash_transaction_type' => $this->input->post('ac_type'),
            'cash_transaction_amount' => $this->input->post('amount'),
            'cash_transaction_description' => $this->input->post('description'),
            'cash_transaction_entry_by' => $this->session->userdata('user_id'),
            'cash_transaction_entry_date' => date('Y-m-d'),
            'cash_transaction_created_at' => date('Y-m-d H:i:s'),
            'cash_transaction_status' => 1
        );

        $this->form_validation->set_rules('tdate', 'Date', 'required');
        $this->form_validation->set_rules('ac_type', 'Account Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount ', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['main_content'] = $this->load->view('home/cash_transaction_form', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_cash_transaction($transaction_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("cash-transaction");
            }
    }

    //cash ledger 
    public function cash_ledger_form()
    {
        $data = array();
        $data['main'] = true;
        $data['cash_ledger'] = "";
        $data['main_content'] = $this->load->view('home/report_cash_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //ledger report
    public function datewise_cash_ledger_report()
    {
        $data = array();
        $data['main'] = true;
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $client_id = $this->session->userdata('client_code');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['cash_ledger'] = $this->inventory_model->get_cash_ledger_by_date($from_date, $to_date);
        $pre_date = date("Y-m-d", strtotime(' -1 day', strtotime($from_date)));
        $opening_cash_debit = $this->inventory_model->opening_debit_cash_by_date($pre_date);
        $opening_cash_credit = $this->inventory_model->opening_credit_cash_by_date($pre_date);
        $opening_cash_balance = $opening_cash_debit->cash_transaction_amount-$opening_cash_credit->cash_transaction_amount;
        $data['opening_cash_balance'] = $opening_cash_balance;
        $data['main_content'] = $this->load->view('home/report_cash_ledger', $data,true);
        $this->load->view('home/client_home', $data);
    }

///////////End cash //////////


    public function financial_statement()
    {
        $data = array();
        $data['main'] = true;
        $date = date('Y-m-d');
        $data = $this->financial_statement_data($date);
        $data['main_content'] = $this->load->view('home/report_financial_statement', $data,true);
        $this->load->view('home/client_home', $data);
    }

    public function financial_statement_search()
    {
        $data = array();
        $data['main'] = true;
        $date = $this->input->post('from_date');
        $data = $this->financial_statement_data($date);
        $data['main_content'] = $this->load->view('home/report_financial_statement', $data,true);
        $this->load->view('home/client_home', $data);
    }

    public function financial_statement_data($date)
    {
        $data = array();
        $data['main'] = true;
        //$date = date('Y-m-d');
        $client_id = $this->session->userdata('client_code');
        $data['title'] = "Financial Statement till " .date("d/m/Y", strtotime($date));
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);

        $debit_cash = $this->inventory_model->get_debit_cash();
        $credit_cash = $this->inventory_model->get_credit_cash();

        $debit_bank = $this->inventory_model->get_debit_bank();
        $credit_bank = $this->inventory_model->get_credit_bank();

        $sdue = $this->inventory_model->get_sales_due();
        $sales_total = $sdue->sales_total_amount-($sdue->sales_invoice_discount+$sdue->sales_total_discount)
                                                -$sdue->sales_invoice_return_total;
        $spaid_total = $sdue->sales_amount_paid-$sdue->sales_invoice_return_amount;
        $sdue_total = $sales_total- $spaid_total; 

          $pdue = $this->inventory_model->get_purchase_due();
        $purchase_total = $pdue->purchase_total_amount-($pdue->purchase_invoice_discount+$pdue->purchase_total_discount)
                                                -$pdue->purchase_invoice_return_total;
          $ppaid_total = $pdue->purchase_amount_paid-$pdue->purchase_invoice_return_amount;
          $pdue_total = $purchase_total- $ppaid_total;

          $stock = $this->inventory_model->get_product();
          $stock_value = 0;
          foreach ($stock as $svalue) {
              $total_value =$svalue->product_stock*$svalue->product_unit_price;
              $stock_value += $total_value;
          }

            $supplier_ledger = $this->inventory_model->get_supplier_ledger();
            $supplier_debit_total = 0;
            $supplier_credit_total = 0;
            
            foreach ($supplier_ledger as $sledger) {
            if ($sledger->supplier_transaction_type == "Debit(+)") {
                    $supplier_debit_amount = $sledger->supplier_transaction_amount;
                    $supplier_credit_amount = 0;
                }else if ($sledger->supplier_transaction_type == "Credit(-)"){
                    $supplier_debit_amount = 0;
                    $supplier_credit_amount = $sledger->supplier_transaction_amount;
                }
                $supplier_debit_total += $supplier_debit_amount;
                $supplier_credit_total += $supplier_credit_amount;
            }
                
            $customer_ledger = $this->inventory_model->get_customer_ledger();
            $customer_debit_total = 0;
            $customer_credit_total = 0;
            
            foreach ($customer_ledger as $cledger) {
            if ($cledger->customer_transaction_type == "Debit(+)") {
                    $customer_debit_amount = $cledger->customer_transaction_amount;
                    $customer_credit_amount = 0;
                }else if ($cledger->customer_transaction_type == "Credit(-)"){
                    $customer_debit_amount = 0;
                    $customer_credit_amount = $cledger->customer_transaction_amount;
                }
                $customer_debit_total += $customer_debit_amount;
                $customer_credit_total += $customer_credit_amount;
            }

        $data['cash_balance'] = $debit_cash->cash_transaction_amount-$credit_cash->cash_transaction_amount;
        $data['bank_balance'] = $debit_bank->bank_transaction_amount-$credit_bank->bank_transaction_amount;
        $data['receivable'] = $sdue_total;
        $data['payable'] = $pdue_total;
        $data['stock'] = $stock_value;
        $data['supplier_advance'] = $supplier_debit_total-$supplier_credit_total;
        $data['customer_advance'] = $customer_debit_total-$customer_credit_total;
        return $data;
    }

     public function cash_flow_statement()
    {
        
        $date = date('Y-m-d');
        $data = $this->cash_flow_statement_report($date);
        $data['main_content'] = $this->load->view('home/report_cash_flow_statement', $data,true);
        $this->load->view('home/client_home', $data);
    }

    public function cash_flow_statement_search()
    {
        $date = date('Y-m-d');
        $date = $this->input->post('from_date');
        $data = $this->cash_flow_statement_report($date);
        $data['main_content'] = $this->load->view('home/report_cash_flow_statement', $data,true);
        $this->load->view('home/client_home', $data);
    }

    public function cash_flow_statement_report($date)
    {
        $data = array();
        $data['main'] = true;
        //$date = date('Y-m-d');
        $pre_date = date("Y-m-d", strtotime(' -1 day', strtotime($date)));
        $client_id = $this->session->userdata('client_code');
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['title'] = "Cash Flow Statement of " .date("d/m/Y", strtotime($date));

        $opening_cash_debit = $this->inventory_model->opening_debit_cash_by_date($pre_date);
        $opening_cash_credit = $this->inventory_model->opening_credit_cash_by_date($pre_date);
        $opening_cash_balance = $opening_cash_debit->cash_transaction_amount-$opening_cash_credit->cash_transaction_amount;
        $current_cash_debit = $this->inventory_model->current_debit_cash_by_date($date);
        $current_cash_credit = $this->inventory_model->current_credit_cash_by_date($date);
        $current_cash_balance = $current_cash_debit->cash_transaction_amount-$current_cash_credit->cash_transaction_amount;

        $opening_bank_debit = $this->inventory_model->opening_debit_bank_by_date($pre_date);
        $opening_bank_credit = $this->inventory_model->opening_credit_bank_by_date($pre_date);
        $opening_bank_balance = $opening_bank_debit->bank_transaction_amount-$opening_bank_credit->bank_transaction_amount;
        $current_bank_debit = $this->inventory_model->current_debit_bank_by_date($date);
        $current_bank_credit = $this->inventory_model->current_credit_bank_by_date($date);
        $current_bank_balance = $current_bank_debit->bank_transaction_amount-$current_bank_credit->bank_transaction_amount;

        $total_opening_balance = $opening_cash_balance+$opening_bank_balance;
        $total_receive = $current_cash_debit->cash_transaction_amount+$current_bank_debit->bank_transaction_amount;
        $total_payment = $current_cash_credit->cash_transaction_amount+$current_bank_credit->bank_transaction_amount;

        $closing_cash = $opening_cash_balance+$current_cash_balance;
        $closing_bank = $opening_bank_balance+$current_bank_balance;
        $total_closing_balance = $closing_cash+$closing_bank;

        $purchase_return = 0;
        $sales_return = 0;



        $data['opening_cash_balance'] = $opening_cash_balance;
        $data['opening_bank_balance'] = $opening_bank_balance;
        $data['total_opening_balance'] = $total_opening_balance;
        $data['current_cash_debit'] = $current_cash_debit->cash_transaction_amount;
        $data['current_cash_credit'] = $current_cash_credit->cash_transaction_amount;
        $data['current_bank_debit'] = $current_bank_debit->bank_transaction_amount;
        $data['current_bank_credit'] = $current_bank_credit->bank_transaction_amount;
        $data['total_receive'] = $total_receive;
        $data['total_payment'] = $total_payment;
        $data['closing_cash'] = $closing_cash;
        $data['closing_bank'] = $closing_bank;
        $data['total_closing_balance'] = $total_closing_balance;
        
        return $data;
    }

    //Client edit Form
    public function client_profile()
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $data['clients_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['main_content'] = $this->load->view('home/client_profile', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Update Client Info
    public function update_profile($client_id)
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
            $client_id = $this->session->userdata('client_code');
            $data['clients_info'] = $this->inventory_model->get_client_by_id($client_id);
            $data['main_content'] = $this->load->view('home/client_profile', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
                $this->inventory_model->update_client($client, $client_id);

                //$user_data['user_email'] = $client_email;
                $user_data['user_name'] = $this->input->post('client_name');
                $this->inventory_model->update_user_id($user_data, $client_id);
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Profile Updated Successfully!</div>";
                $this->session->set_userdata($sdata);
                redirect("profile-setup");
            }
        
    }

    //new sales form
    public function sales_requisition_form()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/sales_requisition_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales Entry save
    public function save_sales_requisition()
        {
            $client_id = $this->session->userdata('client_code');
            $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));
            $last_invoice = $this->inventory_model->get_sales_req_no();
            if($last_invoice){
                    $sales_req_no = $last_invoice->sales_req_no+1;
                }else{
                    $sales_req_no = 100001;
                }

            if($temp != 0){
                $sales_req_id = "SQR-".uniqid();
                $customer_code = $this->input->post('customer_id');
                $customer_name = $this->input->post('customer_name');
                $customer_mobile = $this->input->post('customer_mobile');
                $sales_date = $this->input->post('sales_date');
                $mrp = $this->input->post('mrp');
                $sales_qty = $this->input->post('sales_qty');
                $sales_vat = $this->input->post('sales_vat');
                $sales_details = $this->input->post('sales_details');
                $sum = 0;
                $total_vat = 0;
                       

                if ($customer_code) {
                    $customer_id = $customer_code;
                }else{
                    $customer_id = "CUS-".uniqid();
                    $customer_info = array(
                    'customer_id' => $customer_id,
                    'client_id' => $client_id,
                    'customer_name' => $customer_name,
                    'customer_mobile' => $customer_mobile,
                    'customer_created_by' => $this->session->userdata('user_id'),
                    'customer_create_date' => date('Y-m-d'),
                    'customer_created_at' => date('Y-m-d H:i:s'),
                    'customer_status' => 1
                );
                $this->inventory_model->save_customer($customer_info);
                }
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                    $sum += $mrp[$i]*$sales_qty[$i];
                    $vat = ($sales_vat[$i] / 100) * ($mrp[$i]*$sales_qty[$i]);
                    $total_vat += $vat;
                    

                  $sales_item = array(
                    'req_item_id' => "RQI-".uniqid(),
                    'client_id' => $client_id,
                    'customer_id' => $customer_id,
                    'sales_req_id' => $sales_req_id,
                    'sales_req_no' => $sales_req_no,
                    'product_id' => $product_id[$i],
                    'req_item_quantity' => $sales_qty[$i],
                    'req_item_rate' => $mrp[$i],
                    'req_item_vat_per' => $sales_vat[$i],
                    'req_item_amount' => $mrp[$i]*$sales_qty[$i],
                    'req_item_date' => $sales_date,
                    'req_item_entry_by' => $this->session->userdata('user_id'),
                    'req_item_entry_date' => date('Y-m-d'),
                    'req_item_created_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->add_req_item($sales_item);
                }

                $invoice_info = array(
                    'sales_req_id' => $sales_req_id,
                    'sales_req_no' => $sales_req_no,
                    'client_id' => $client_id,
                    'customer_id' => $customer_id,
                    'req_issue_date' => $sales_date,
                    'req_total_amount' => $sum,
                    'req_total_vat' => $total_vat,
                    'sales_req_detail' => $sales_details,
                    'sales_req_entry_by' => $this->session->userdata('user_id'),
                    'sales_req_entry_date' => date('Y-m-d'),
                    'sales_req_created_at' => date('Y-m-d H:i:s')
                );
                $this->inventory_model->add_sales_req($invoice_info);

                

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Sales Requisition Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("sales-requisition-detail/".$sales_req_id);
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
               redirect("new-sales-requisition"); 
            }
    }

    //Sales detail
    public function sales_requisition_detail($sales_req_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_req($sales_req_id);
       
        $total = $sales_info->req_total_amount+$sales_info->req_total_vat;
        
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->req_total_vat;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_req_item($sales_req_id);
        $data['main_content'] = $this->load->view('home/sales_requisition_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // sales req list
    public function pending_sales_requisition()
    {
            $data = array();
            $data['main'] = true;
            $data['sales_info'] = $this->inventory_model->pending_sales_req_list();
            $data['main_content'] = $this->load->view('home/sales_requisition_pending_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

    //Sales detail
    public function sales_requisition_approval($sales_req_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_req($sales_req_id);
       
        $total = $sales_info->req_total_amount+$sales_info->req_total_vat;
        
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->req_total_vat;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_req_item($sales_req_id);
        $data['main_content'] = $this->load->view('home/sales_requisition_approval_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales Entry save
    public function save_sales_requisition_approval($sales_req_id)
        {
            $sales_info = $this->inventory_model->get_sales_req($sales_req_id);
            $client_id = $this->session->userdata('client_code');
            $product_id = $this->input->post('product_id');
            $temp =count(array_filter($product_id));
            

            if($temp != 0){
                $mrp = $this->input->post('mrp');
                $sales_qty = $this->input->post('sales_qty');
                $sales_vat = $this->input->post('sales_vat');
                $sum = 0;
                $total_vat = 0;
                       
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){
                    $sum += $mrp[$i]*$sales_qty[$i];
                    $vat = ($sales_vat[$i] / 100) * ($mrp[$i]*$sales_qty[$i]);
                    $total_vat += $vat;
                    

                  $sales_item = array(
                    'req_app_item_id' => "RQI-".uniqid(),
                    'client_id' => $client_id,
                    'customer_id' => $sales_info->customer_id,
                    'sales_req_id' => $sales_req_id,
                    'sales_req_no' => $sales_info->sales_req_no,
                    'product_id' => $product_id[$i],
                    'req_app_item_quantity' => $sales_qty[$i],
                    'req_app_item_rate' => $mrp[$i],
                    'req_app_item_vat_per' => $sales_vat[$i],
                    'req_app_item_amount' => $mrp[$i]*$sales_qty[$i],
                    'req_app_item_date' => date('Y-m-d'),
                    'req_app_item_entry_by' => $this->session->userdata('user_id'),
                    'req_app_item_entry_date' => date('Y-m-d'),
                    'req_app_item_created_at' => date('Y-m-d H:i:s')
                );

                $this->inventory_model->add_req_approve_item($sales_item);
                }

                $invoice_info = array(
                    'req_total_amount' => $sum,
                    'req_total_vat' => $total_vat,
                    'req_approval_date' => date('Y-m-d'),
                    'req_approved_by' => $this->session->userdata('user_id'),
                    'sales_req_updated_at' => date('Y-m-d H:i:s'),
                    'sales_req_status' => 2
                );
                $this->inventory_model->update_sales_req($invoice_info, $sales_req_id);

                

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Sales Requisition Approved!</div>";
                $this->session->set_userdata($sdata);
                redirect("sales-requisition-approve-detail/".$sales_req_id);
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
              redirect("approve-sales-requisition/".$sales_req_id);
            }
    }

    //Sales detail
    public function sales_requisition_approve_detail($sales_req_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_req($sales_req_id);
       
        $total = $sales_info->req_total_amount+$sales_info->req_total_vat;
        
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->req_total_vat;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_app_req_item($sales_req_id);
        $data['main_content'] = $this->load->view('home/sales_requisition_approve_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //sales Entry save
    public function cancel_sales_requisition($sales_req_id)
        {
            
                $invoice_info = array(
                    'req_cancel_date' => date('Y-m-d'),
                    'req_cancel_by' => $this->session->userdata('user_id'),
                    'sales_req_updated_at' => date('Y-m-d H:i:s'),
                    'sales_req_status' => 3
                );
                $this->inventory_model->update_sales_req($invoice_info, $sales_req_id);

                

                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Sales Requisition Canceled!</div>";
                $this->session->set_userdata($sdata);
                redirect("new-sales-requisition");
           
    }

    // sales req list
    public function approved_sales_requisition()
    {
            $data = array();
            $data['main'] = true;
            $data['sales_info'] = $this->inventory_model->approve_sales_req_list();
            $data['main_content'] = $this->load->view('home/sales_requisition_approve_list', $data,true);
            $this->load->view('home/client_home', $data);    
    }

    //Sales detail
    public function sales_requisition_bill($sales_req_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $sales_info = $this->inventory_model->get_sales_req($sales_req_id);
        $check_balance = $this->inventory_model->get_customer_transaction($sales_info->customer_id);
         if ($check_balance) {
           $customer_balance = $check_balance->customer_transaction_balance;
         }else{$customer_balance = 0;}
       
        $total = $sales_info->req_total_amount+$sales_info->req_total_vat;
        
        $data['total'] = $total;
        $data['total_vat'] = $sales_info->req_total_vat;
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($total);
        $data['sales_info'] = $sales_info;
        $data['customer_balance'] = $customer_balance;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['sales_item'] = $this->inventory_model->get_app_req_item($sales_req_id);
        $data['main_content'] = $this->load->view('home/sales_requisition_bill_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    ///////////Start user //////////
     //user List
    public function user_list()
    {
        $data = array();
        $data['main'] = true;
        $data['edit_info'] = "";
        $data['user_info'] = $this->inventory_model->get_user();
        $data['main_content'] = $this->load->view('home/user_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save user Entry
    public function save_user()
    {
        $user_info = array(
            'user_id' => "CUI-".uniqid(),
            'client_code' => $this->session->userdata('client_code'),
            'user_name' => $this->input->post('user_name'),
            'user_email' => $this->input->post('user_email'),
            'user_mobile' => $this->input->post('user_mobile'),
            'user_password' => md5($this->input->post('password')),
            'user_type' => "User",
            'user_entry_by' => $this->session->userdata('user_id'),
            'user_entry_date' => date('Y-m-d'),
            'user_created_at' => date('Y-m-d H:i:s'),
            'user_status' => 1
        );

        $this->form_validation->set_rules('user_name', 'Name', 'required');
        $this->form_validation->set_rules('user_email', 'Email Address', 'valid_email|is_unique[users.user_email]');
        $this->form_validation->set_rules('user_mobile', 'Mobile No.', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|callback_password_check');
        $this->form_validation->set_rules('repassword', 'Password Re-Type', 'trim|required|matches[password]|min_length[6]');
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
            $data['edit_info'] = "";
            $data['user_info'] = $this->inventory_model->get_user();
            $data['main_content'] = $this->load->view('home/user_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->save_user($user_info);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New User Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("user-list");
            }
    }

  

    //user edit Form
    public function edit_user($user_id)
    {
        $data = array();
        $data['main'] = true;
        $data['user_info'] = $this->inventory_model->get_user();
        $data['edit_info'] = $this->inventory_model->get_user_by_id($user_id);
        $data['main_content'] = $this->load->view('home/user_list', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // update user Entry
    public function update_user($user_id)
    {
        $user_info = array(
            'user_name' => $this->input->post('user_name'),
            'user_email' => $this->input->post('user_email'),
            'user_mobile' => $this->input->post('user_mobile'),
            'user_updated_by' => $this->session->userdata('user_id'),
            'user_updated_at' => date('Y-m-d H:i:s')
        );

        $this->form_validation->set_rules('user_name', 'Name', 'required');
        $this->form_validation->set_rules('user_email', 'Email Address', 'valid_email');
        $this->form_validation->set_rules('user_mobile', 'Mobile No.', 'required');
       
        if ($this->form_validation->run() == FALSE)
        {
            $data = array();
            $data['main'] = true;
           $data['user_info'] = $this->inventory_model->get_user();
            $data['edit_info'] = $this->inventory_model->get_user_by_id($user_id);
            $data['main_content'] = $this->load->view('home/user_list', $data,true);
            $this->load->view('home/client_home', $data);
        }else{
            $this->inventory_model->update_user_id($user_info, $user_id);

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'> User Updated Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("user-list");
            }
    }

    // update user Entry
    public function user_status_update($status, $user_id)
    {
        $user_info = array(
            'user_status' => $status,
            'user_updated_by' => $this->session->userdata('user_id'),
            'user_updated_at' => date('Y-m-d H:i:s')
        );
        $this->inventory_model->update_user_id($user_info, $user_id);

        $sdata = array();
        $sdata['success'] = "<div class='alert alert-success'> User Updated Successfully!</div>";
        $this->session->set_userdata($sdata);
        redirect("user-list");
            
    }

    //user privilege Form
    public function user_privilege_form($user_id)
    {
        $data = array();
        $data['main'] = true;
        $data['menus'] = $this->inventory_model->get_parent_menu();
        $data['user_info'] = $this->inventory_model->get_user_by_id($user_id);
        $data['user_privilege'] = $this->inventory_model->get_user_privilege($user_id);
        $data['main_content'] = $this->load->view('home/user_privilege_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //user privilege Form
    public function user_privilege_entry($user_id)
    {
         
        $menu_id = $this->input->post('menu_id');
        if ($menu_id) {
        $this->inventory_model->delete_user_privilege($user_id);
        $qty = count($menu_id);
        for($m=0; $m<$qty; $m++)
                {
                    $privilege = array(
                        'privilege_id' => "PRI-".uniqid(),
                        'menu_id' => $menu_id[$m],
                        'user_id' => $user_id,
                        'privilege_entry_by' => $this->session->userdata('user_id'),
                        'privilege_entry_date' =>  date('Y-m-d'),
                        'privilege_created_at' =>  date('Y-m-d H:i:s'),
                        'privilege_status' => 1
                      );
                $this->inventory_model->save_user_privilege($privilege);
                  
                }
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Successfully Privilege Added!</div>";
                $this->session->set_userdata($sdata);
                redirect("set-user-privilege/".$user_id); 
            }else{
               $sdata = array();
                $sdata['success'] = "<div class='alert alert-danger'>Please select privilege.</div>";
                $this->session->set_userdata($sdata);
                redirect("set-user-privilege/".$user_id); 
            }
            
    }

    

///////////End user //////////


//product ledger
 public function product_ledger()
{
    $data = array();
    $data['main'] = true;
    $date = date('Y-m-d');
    $client_id = $this->session->userdata('client_code');
    $data['title'] = "Product Ledger of ".date("d/m/Y", strtotime($date));
    $data['from_date'] = $date;
    $data['to_date'] = $date;
    $data['previous_date'] = date("Y-m-d", strtotime(' -1 day', strtotime($date)));

    $data['product_info'] = $this->inventory_model->get_active_product();
    $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
    $data['stock_info'] = "1";
    $data['main_content'] = $this->load->view('home/report_product_ledger', $data,true);
    $this->load->view('home/client_home', $data);
}

 
    //supplier ledger
    public function supplier_advance_form()
    {
        
        // $data = array();
        // $data['main'] = true;
        $date = date('Y-m-d');
        $data = $this->cash_flow_statement_report($date);
        $data['main_content'] = $this->load->view('home/supplier_advance_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // Save supplier transaction
    public function supplier_transaction_entry()
    {
        $supplier_ledger_id = "CTI-".uniqid();
        $client_id = $this->session->userdata('client_code');
        $date = $this->input->post('tdate');
        $supplier_id = $this->input->post('supplier_id');
        $ac_type = $this->input->post('ac_type');
        $amount = $this->input->post('amount');
        $payment_method = $this->input->post('payment_method');
        $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
        if ($check_balance) {
            if ($ac_type == "Debit(+)") {
                $current_balance = $check_balance->supplier_transaction_balance+$amount;
                $disc = "Supplier Advance Deposite";
                $cash_ac = "Credit(-)";
                $bank_ac = "Credit(-)";
            }else if ($ac_type == "Credit(-)"){
                $current_balance = $check_balance->supplier_transaction_balance-$amount;
                $disc = "Advance Return";
                $cash_ac = "Debit(+)";
                $bank_ac = "Debit(+)";
            }

        }else{
            if ($ac_type == "Debit(+)") {
                $current_balance = $amount;
                $disc = "Supplier Advance Deposite";
                $cash_ac = "Credit(-)";
                $bank_ac = "Credit(-)";
            }else if ($ac_type == "Credit(-)"){
                $current_balance = -$amount;
                $disc = "Advance Return";
                $cash_ac = "Debit(+)";
                $bank_ac = "Debit(+)";
            }
        }

        $transaction_info = array(
            'supplier_ledger_id' => $supplier_ledger_id,
            'client_id' => $client_id,
            'supplier_transaction_date' => $date,
            'supplier_id' => $supplier_id,
            'supplier_transaction_type' => $ac_type,
            'supplier_transaction_amount' => $amount,
            'supplier_transaction_balance' => $current_balance,
            'supplier_transaction_description' => $disc,
            'supplier_transaction_method' => $payment_method,
            'supplier_transaction_entry_by' => $this->session->userdata('user_id'),
            'supplier_transaction_entry_date' => date('Y-m-d'),
            'supplier_transaction_created_at' => date('Y-m-d H:i:s'),
            'supplier_transaction_status' => 1
        );

        $this->form_validation->set_rules('tdate', 'Date', 'required');
        $this->form_validation->set_rules('ac_type', 'Account Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount ', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            
            $this->supplier_advance_form();
        }else{
            $this->inventory_model->save_supplier_transaction($transaction_info);

            if($payment_method == "Cash"){
            $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' =>  $client_id,
                    'cash_transaction_date' => $date,
                    'cash_transaction_type' => $cash_ac,
                    'cash_transaction_amount' => $amount,
                    'cash_transaction_description' => $disc,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);

        }else if($payment_method == "Bank"){
            $transaction_info = array(
                'bank_transaction_id' => "BTI-".uniqid(),
                'client_id' => $client_id,
                'bank_id' => "Default",
                'bank_transaction_date' => $date,
                'bank_transaction_type' => $bank_ac,
                //'withdraw_deposit_id' => $purchase_info->purchase_invoice_no,
                'bank_transaction_amount' => $amount,
                'bank_transaction_description' => $disc,
                'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                'bank_transaction_entry_date' => date('Y-m-d'),
                'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                'bank_transaction_status' => 1
            );
            $this->inventory_model->save_bank_transaction($transaction_info);

        }

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("supplier-payment-receipt/".$supplier_ledger_id);
            }
    }

     //Sales detail
    public function supplier_payment_receipt($payment_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $payment_info = $this->inventory_model->get_supplier_advance_payment_info($payment_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($payment_info->supplier_transaction_amount);
        $data['payment_info'] = $payment_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //$data['payment_item'] = $this->inventory_model->get_supplier_item($payment_id);
        $data['main_content'] = $this->load->view('home/supplier_payment_receipt', $data,true);
        $this->load->view('home/client_home', $data);
    }



    public function get_supplier_balance()
    {
        $supplier = $this->input->post('supplier');
        $check_balance = $this->inventory_model->get_supplier_transaction($supplier);
         if ($check_balance) {
           echo $check_balance->supplier_transaction_balance;
         }else{echo "0";}
        
    }

     //customer ledger
    public function customer_advance_form()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/customer_advance_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // customer auto complete
    public function ledger_customer_list()
    {
    $postData = $this->input->post();
    $data = $this->inventory_model->ledger_customer_search($postData);
    echo json_encode($data);
    }


     // Save cash transaction
    public function customer_transaction_entry()
    {
        $customer_ledger_id = "CTI-".uniqid();
        $client_id = $this->session->userdata('client_code');
        $date = $this->input->post('tdate');
        $customer_id = $this->input->post('customer_id');
        $ac_type = $this->input->post('ac_type');
        $amount = $this->input->post('amount');
        $payment_method = $this->input->post('payment_method');
        $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
        if ($check_balance) {
            if ($ac_type == "Debit(+)") {
                $current_balance = $check_balance->customer_transaction_balance+$amount;
                $disc = "Customer Advance Deposite";
                $cash_ac = "Debit(+)";
                $bank_ac = "Debit(+)";
            }else if ($ac_type == "Credit(-)"){
                $current_balance = $check_balance->customer_transaction_balance-$amount;
                $disc = "Advance Return";
                $cash_ac = "Credit(-)";
                $bank_ac = "Credit(-)";
            }

        }else{
            if ($ac_type == "Debit(+)") {
                $current_balance = $amount;
                $disc = "Customer Advance Deposite";
                $cash_ac = "Debit(+)";
                $bank_ac = "Debit(+)";
            }else if ($ac_type == "Credit(-)"){
                $current_balance = -$amount;
                $disc = "Advance Return";
                $cash_ac = "Credit(-)";
                $bank_ac = "Credit(-)";
            }
        }

        $transaction_info = array(
            'customer_ledger_id' => $customer_ledger_id,
            'client_id' => $client_id,
            'customer_transaction_date' => $date,
            'customer_id' => $customer_id,
            'customer_transaction_type' => $ac_type,
            'customer_transaction_amount' => $amount,
            'customer_transaction_balance' => $current_balance,
            'customer_transaction_description' => $disc,
            'customer_transaction_method' => $payment_method,
            'customer_transaction_entry_by' => $this->session->userdata('user_id'),
            'customer_transaction_entry_date' => date('Y-m-d'),
            'customer_transaction_created_at' => date('Y-m-d H:i:s'),
            'customer_transaction_status' => 1
        );

        $this->form_validation->set_rules('tdate', 'Date', 'required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('ac_type', 'Account Type', 'required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        $this->form_validation->set_rules('amount', 'Amount ', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->customer_advance_form();
        }else{
            $this->inventory_model->save_customer_transaction($transaction_info);

            if($payment_method == "Cash"){
            $transaction_info = array(
                    'cash_transaction_id' => "CTI-".uniqid(),
                    'client_id' =>  $client_id,
                    'cash_transaction_date' => $date,
                    'cash_transaction_type' => $cash_ac,
                    'cash_transaction_amount' => $amount,
                    'cash_transaction_description' => $disc,
                    'cash_transaction_entry_by' => $this->session->userdata('user_id'),
                    'cash_transaction_entry_date' => date('Y-m-d'),
                    'cash_transaction_created_at' => date('Y-m-d H:i:s'),
                    'cash_transaction_status' => 1
                );
                $this->inventory_model->save_cash_transaction($transaction_info);

        }else if($payment_method == "Bank"){
            $transaction_info = array(
                'bank_transaction_id' => "BTI-".uniqid(),
                'client_id' => $client_id,
                'bank_id' => "Default",
                'bank_transaction_date' => $date,
                'bank_transaction_type' => $bank_ac,
                //'withdraw_deposit_id' => $purchase_info->purchase_invoice_no,
                'bank_transaction_amount' => $amount,
                'bank_transaction_description' => $disc,
                'bank_transaction_entry_by' => $this->session->userdata('user_id'),
                'bank_transaction_entry_date' => date('Y-m-d'),
                'bank_transaction_created_at' => date('Y-m-d H:i:s'),
                'bank_transaction_status' => 1
            );
            $this->inventory_model->save_bank_transaction($transaction_info);

        }

            $sdata = array();
            $sdata['success'] = "<div class='alert alert-success'>New Entry Created Successfully!</div>";
            $this->session->set_userdata($sdata);
            redirect("customer-payment-receipt/".$customer_ledger_id );
            }
    }

    //receipt detail
    public function customer_payment_receipt($payment_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $payment_info = $this->inventory_model->get_customer_advance_payment_info($payment_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($payment_info->customer_transaction_amount);
        $data['payment_info'] = $payment_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //$data['payment_item'] = $this->inventory_model->get_customer_item($payment_id);
        $data['main_content'] = $this->load->view('home/customer_payment_receipt', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //customer balance
    public function get_customer_balance()
    {
        $customer = $this->input->post('customer');
        $check_balance = $this->inventory_model->get_customer_transaction($customer);
         if ($check_balance) {
           echo $check_balance->customer_transaction_balance;
         }else{echo "0";}
        
    }

      //customer ledger
         public function sales_ledger()
        {
            $data = array();
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Sales Ledger";
            $data['customer_info'] = $this->inventory_model->get_customer();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['sales_info'] = $this->inventory_model->get_sales_list();
            $data['sales_info'] = $this->inventory_model->get_datwise_sales_list($from_date, $to_date);
            $data['return'] = $this->inventory_model->get_sales_return_list($from_date, $to_date);
            $data['due_collection'] = $this->inventory_model->get_datwise_sales_due($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_sales_ledger', $data,true);
            $this->load->view('home/client_home', $data);
        }

       
         //  public function customerwise_sales_ledger()
         // {
         //     $data = array();
         //     $data['main'] = true;
         //     $customer_id = $this->input->post('customer_id');
         //     $from_date = $this->input->post('from_date');
         //     $to_date = $this->input->post('to_date');
         //     $client_id = $this->session->userdata('client_code');
         //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
         //     if ($customer_id && $from_date =="" && $to_date =="") {
         //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
         //        $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
         //         if ($check_balance) {
         //           $data['customer_balance'] = $check_balance->customer_transaction_balance;
         //         }else{
         //            $data['customer_balance'] = 0;
         //         }
         //        $data['title'] = "Sales Ledger of ".$customer->customer_name." | ". $customer->customer_mobile;
         //         $data['sales_info'] = $this->inventory_model->get_sales_list_by_customer($customer_id);
         //         $data['main_content'] = $this->load->view('home/report_customerwise_seles_ledger', $data,true);
         //         $this->load->view('home/client_home', $data);
         //     }else if ($customer_id && $from_date && $to_date) {
         //        $customer =$this->inventory_model->get_customer_by_id($customer_id);
         //        $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
         //         if ($check_balance) {
         //           $data['customer_balance'] = $check_balance->customer_transaction_balance;
         //         }else{
         //            $data['customer_balance'] = 0;
         //         }
         //        $data['title'] = "Sales Ledger of ".$customer->customer_name." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
         //         $data['sales_info'] = $this->inventory_model->get_datwise_sales_list_by_customer($customer_id, $from_date, $to_date);
         //         $data['main_content'] = $this->load->view('home/report_customerwise_seles_ledger', $data,true);
         //         $this->load->view('home/client_home', $data);
         //     }else{
         //           $data['title'] = "Sales Ledger of From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
         //           $data['sales_info'] = $this->inventory_model->get_datwise_sales_list($from_date, $to_date);
         //            $data['main_content'] = $this->load->view('home/report_sales_ledger', $data,true);
         //         $this->load->view('home/client_home', $data);
         //         //redirect('sales-ledger');
         //     }
            
         // } 

         public function customerwise_sales_ledger()
         {
             $data = array();
             $data['main'] = true;
             $customer_id = $this->input->post('customer_id');
             $from_date = $this->input->post('from_date');
             $to_date = $this->input->post('to_date');
             $client_id = $this->session->userdata('client_code');
             $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
              if ($customer_id) {
                $customer =$this->inventory_model->get_customer_by_id($customer_id);
                $check_balance = $this->inventory_model->get_customer_transaction($customer_id);
                 if ($check_balance) {
                   $data['customer_balance'] = $check_balance->customer_transaction_balance;
                 }else{
                    $data['customer_balance'] = 0;
                 }
                $data['title'] = "Sales Ledger of ".$customer->customer_name." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                 $data['sales_info'] = $this->inventory_model->get_datwise_sales_list_by_customer($customer_id, $from_date, $to_date);
                  $data['return'] = $this->inventory_model->get_sales_return_list_customer($customer_id, $from_date, $to_date);
            $data['due_collection'] = $this->inventory_model->get_datwise_sales_due_customer($customer_id, $from_date, $to_date);
                 $data['main_content'] = $this->load->view('home/report_customerwise_seles_ledger', $data,true);
                 $this->load->view('home/client_home', $data);
             }else{
                   $data['title'] = "Sales Ledger of From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                   $data['sales_info'] = $this->inventory_model->get_datwise_sales_list($from_date, $to_date);
                    $data['return'] = $this->inventory_model->get_sales_return_list($from_date, $to_date);
            $data['due_collection'] = $this->inventory_model->get_datwise_sales_due($from_date, $to_date);
                    $data['main_content'] = $this->load->view('home/report_sales_ledger', $data,true);
                 $this->load->view('home/client_home', $data);
                 //redirect('sales-ledger');
             }
            
         } 

         //supplier ledger
         public function purchase_ledger()
        {
            $data = array();
            $data['main'] = true;
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $client_id = $this->session->userdata('client_code');
            $data['title'] = "Purchase Ledger";
            //$data['from_date'] = $from_date;
            //$data['to_date'] =  $to_date ;
            $data['supplier_info'] = $this->inventory_model->get_supplier();
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['purchase_info'] = $this->inventory_model->get_purchase_list();
            $data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list($from_date, $to_date);
            $data['return'] = $this->inventory_model->get_purchase_return_list($from_date, $to_date);
            $data['due_collection'] = $this->inventory_model->get_datwise_purchase_due($from_date, $to_date);

            $data['main_content'] = $this->load->view('home/report_purchase_ledger', $data,true);
            $this->load->view('home/client_home', $data);
        } 

        //supplier ledger
        //  public function supplierwise_purchase_ledger()
        // {
        //     $data = array();
        //     $data['main'] = true;
        //     $supplier_id = $this->input->post('supplier_id');
        //     $from_date = $this->input->post('from_date');
        //     $to_date = $this->input->post('to_date');
        //     $client_id = $this->session->userdata('client_code');
        //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //     //$data['from_date'] = $from_date;
        //     //$data['to_date'] =  $to_date ;
        //     if ($supplier_id && $from_date =="" && $to_date =="") {
        //        $supplier = $this->inventory_model->get_supplier_by_id($supplier_id);
        //        $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
        //         if ($check_balance) {
        //           $data['supplier_balance'] = $check_balance->supplier_transaction_balance;
        //          }else{
        //             $data['supplier_balance'] = 0;
        //          }
        //        $data['title'] = "Purchase Ledger of ".$supplier->supplier_name ." | ".$supplier->supplier_mobile;
        //         $data['purchase_info'] = $this->inventory_model->get_purchase_list_by_supplier($supplier_id);
        //         $data['main_content'] = $this->load->view('home/report_supplierwise_purchase_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else if ($supplier_id && $from_date && $to_date) {
        //        $supplier =$this->inventory_model->get_supplier_by_id($supplier_id);
        //        $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
        //         if ($check_balance) {
        //           $data['supplier_balance'] = $check_balance->supplier_transaction_balance;
        //          }else{
        //             $data['supplier_balance'] = 0;
        //          }
        //        $data['title'] = "Purchase Ledger of ".$supplier->supplier_name." | ".$supplier->supplier_mobile." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
        //         $data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list_by_supplier($supplier_id, $from_date, $to_date);

        //         $data['main_content'] = $this->load->view('home/report_supplierwise_purchase_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }else{
        //         //redirect('purchase-ledger');
        //         $data['title'] = "Purchase Ledger From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
        //         $data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list($from_date, $to_date);
        //         $data['main_content'] = $this->load->view('home/report_purchase_ledger', $data,true);
        //         $this->load->view('home/client_home', $data);
        //     }
            
        // }

        public function supplierwise_purchase_ledger()
        {
            $data = array();
            $data['main'] = true;
            $supplier_id = $this->input->post('supplier_id');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $client_id = $this->session->userdata('client_code');
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            //$data['from_date'] = $from_date;
            //$data['to_date'] =  $to_date ;
            if ($supplier_id) {
               $supplier =$this->inventory_model->get_supplier_by_id($supplier_id);
               $check_balance = $this->inventory_model->get_supplier_transaction($supplier_id);
                if ($check_balance) {
                  $data['supplier_balance'] = $check_balance->supplier_transaction_balance;
                 }else{
                    $data['supplier_balance'] = 0;
                 }
               $data['title'] = "Purchase Ledger of ".$supplier->supplier_name." | ".$supplier->supplier_mobile." From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list_by_supplier($supplier_id, $from_date, $to_date);
                $data['return'] = $this->inventory_model->get_purchase_return_list_supplier($supplier_id, $from_date, $to_date);
                $data['due_collection'] = $this->inventory_model->get_datwise_purchase_due_supplier($supplier_id, $from_date, $to_date);


                $data['main_content'] = $this->load->view('home/report_supplierwise_purchase_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }else{
                //redirect('purchase-ledger');
                $data['title'] = "Purchase Ledger From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)) ;
                $data['purchase_info'] = $this->inventory_model->get_datwise_purchase_list($from_date, $to_date);
                $data['return'] = $this->inventory_model->get_purchase_return_list($from_date, $to_date);
                $data['due_collection'] = $this->inventory_model->get_datwise_purchase_due($from_date, $to_date);

                $data['main_content'] = $this->load->view('home/report_purchase_ledger', $data,true);
                $this->load->view('home/client_home', $data);
            }
            
        }

        //receive payment ledger
        //  public function receive_payment_report()
        // {
        //     $data = array();
        //     $data['main'] = true;
        //     $to_date = date('Y-m-d');
        //      $from_date = date('Y-m-d');
        //      $data = $this->cash_flow_statement_report($from_date);
        //     //$from_date = date("Y-m-d", strtotime(' -1 day', strtotime($to_date)));
        //     $client_id = $this->session->userdata('client_code');
        //     $data['title'] = "Receive & Payment Statement Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));;
        //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //     $data['from_date'] = $from_date;
        //     $data['to_date'] = $to_date;
            
        //     $data['main_content'] = $this->load->view('home/report_receive_payment', $data,true);
        //     $this->load->view('home/client_home', $data);
        // }

        // //receive payment ledger
        //  public function datewise_receive_payment()
        // {
        //     $data = array();
        //     $data['main'] = true;
        //     $to_date = $this->input->post('to_date');
        //     $from_date = $this->input->post('from_date');
        //     $data = $this->cash_flow_statement_report($from_date);
        //     $client_id = $this->session->userdata('client_code');
        //     $data['title'] = "Receive & Payment Statement Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));;
        //     $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        //     $data['from_date'] = $from_date;
        //     $data['to_date'] = $to_date;
        //     $data['main_content'] = $this->load->view('home/report_receive_payment', $data,true);
        //     $this->load->view('home/client_home', $data);
        // }

        public function receive_payment_report()
        {
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $to_date = date('Y-m-d');
            $from_date = date('Y-m-d');
            $data = $this->cash_flow_statement_report($from_date);
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['heading'] = "Receive & Payment Statement From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            
            
            //$data['cash_ledger'] = $this->inventory_model->get_cash_ledger_by_date($from_date, $to_date);
            //$data['bank_ledger'] = $this->inventory_model->get_datewise_bank_ledger($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_receive_payment', $data,true);
            $this->load->view('home/client_home', $data);
        }

        public function datewise_receive_payment()
        {
            
            $data = array();
            $data['main'] = true;
            $client_id = $this->session->userdata('client_code');
            $to_date = $this->input->post('to_date');
            $from_date = $this->input->post('from_date');
            $data = $this->cash_flow_statement_report($from_date);
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['heading'] = "Receive & Payment Statement From ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date));
            $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
            
            //$data['cash_ledger'] = $this->inventory_model->get_cash_ledger_by_date($from_date, $to_date);
            //$data['bank_ledger'] = $this->inventory_model->get_datewise_bank_ledger($from_date, $to_date);
            $data['main_content'] = $this->load->view('home/report_receive_payment', $data,true);
            $this->load->view('home/client_home', $data);

        }

    //new rfq form
    public function quotation_form()
    {
        $data = array();
        $data['main'] = true;
        $data['main_content'] = $this->load->view('home/quotation_form', $data,true);
        $this->load->view('home/client_home', $data);
    }

    //rfq Entry save
    public function save_quotation()
        {
            $client_id = $this->session->userdata('client_code');
            $supplier_id = $this->input->post('supplier_id');
             $customer_id = $this->input->post('customer_id');
            $product_id = $this->input->post('product_id');

            if ($supplier_id || $customer_id) {

            $temp =count(array_filter($product_id));
            $last_quotation = $this->inventory_model->get_quotation_no();
            if($last_quotation){
                    $quotation_no = $last_quotation->quotation_no+1;
                }else{
                    $quotation_no = 100001;
                }

            if($temp != 0){
                $quotation_id = "RFQ-".uniqid();
                $quotation_type = $this->input->post('quotation_type');
                $quotation_title = $this->input->post('quotation_title');
                $quotation_date = $this->input->post('quotation_date');
                $quotation_details = $this->input->post('quotation_details');
                $quotation_qty = $this->input->post('quotation_qty');
                $mrp = $this->input->post('qmrp');
                $sum = 0;
                
                $qty =count($product_id);
                for($i=0; $i<$qty;$i++){

                  $sum += $mrp[$i]*$quotation_qty[$i];
                  $quotation_item = array(
                    'quotation_item_id' => "QUI-".uniqid(),
                    'client_id' => $client_id,
                    'quotation_id' => $quotation_id,
                    'quotation_no' => $quotation_no,
                    'product_id' => $product_id[$i],
                    'quotation_item_quantity' => $quotation_qty[$i],
                    'quotation_item_rate' => $mrp[$i],
                    'quotation_item_amount' => $mrp[$i]*$quotation_qty[$i],
                    'quotation_item_date' => $quotation_date,
                    'quotation_item_entry_by' => $this->session->userdata('user_id'),
                    'quotation_item_entry_date' => date('Y-m-d'),
                    'quotation_item_created_at' => date('Y-m-d H:i:s'),
                    'quotation_item_status' => 1
                );

                $this->inventory_model->add_quotation_item($quotation_item);
            }

                if ($supplier_id) {
                     $quotation_user_type = "Supplier";
                     $quotation_user = $supplier_id;
                    }else if ($customer_id){
                        $quotation_user_type = "Customer";
                        $quotation_user = $customer_id;
                    }   

                $quotation_info = array(
                    'quotation_id' => $quotation_id,
                    'quotation_no' => $quotation_no,
                    'client_id' => $client_id,
                    'quotation_user_type' => $quotation_user_type,
                    'quotation_user' => $quotation_user,
                    'quotation_date' => $quotation_date,
                    'quotation_type' => $quotation_type,
                    'quotation_title' => $quotation_title,
                    'quotation_total_amount' => $sum,
                    'quotation_detail' => $quotation_details,
                    'quotation_entry_by' => $this->session->userdata('user_id'),
                    'quotation_entry_date' => date('Y-m-d'),
                    'quotation_created_at' => date('Y-m-d H:i:s'),
                    'quotation_status' => 1
                );
                $this->inventory_model->add_quotation($quotation_info);

                                
                $sdata = array();
                $sdata['success'] = "<div class='alert alert-success'>Entry Successfull!</div>";
                $this->session->set_userdata($sdata);
                redirect("quotation-detail/".$quotation_id);
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Fill up at least one Product!</div>";
                $this->session->set_userdata($sdata);
               redirect("new-quotation"); 
            }
            }else{
                $sdata = array();
                $sdata['error'] = "<div class='alert alert-danger'>Select Supplier or Customer.</div>";
                $this->session->set_userdata($sdata);
               redirect("new-quotation");
            }
            
    }


    //rfq detail
    public function quotation_detail($quotation_id)
    {
        $data = array();
        $data['main'] = true;
        $client_id = $this->session->userdata('client_code');
        $quotation_info = $this->inventory_model->get_quotation($quotation_id);
        $data['in_word'] = $this->numbertowordconvertsconver->getBdCurrency($quotation_info->quotation_total_amount );
        if($quotation_info->quotation_user_type == "Supplier"){
            $data['supplier_info'] = $this->inventory_model->get_supplier_by_id($quotation_info->quotation_user);
            $data['customer_info'] = "";
        }else if($quotation_info->quotation_user_type == "Customer"){
            $data['customer_info'] = $this->inventory_model->get_customer_by_id($quotation_info->quotation_user);
            $data['supplier_info'] = "";
        }
        $data['quotation_info'] = $quotation_info;
        $data['client_info'] = $this->inventory_model->get_client_by_id($client_id);
        $data['quotation_item'] = $this->inventory_model->get_quotation_item($quotation_id);
        $data['main_content'] = $this->load->view('home/quotation_detail', $data,true);
        $this->load->view('home/client_home', $data);
    }

    // rfq list
    public function quotation_list()
    {
        $data = array();
        $data['main'] = true;
        $data['quotation_info'] = $this->inventory_model->get_quotation_list();
        $data['main_content'] = $this->load->view('home/quotation_list', $data,true);
        $this->load->view('home/client_home', $data);    
    }

      //sales search
    public function sales_product_code_data()
     {
      $output = "";
     $query = $this->input->post('txt');
     //echo $query;
     if ($query !== "") {

        $privilege = $this->inventory_model->get_user_privilege($this->session->userdata('user_id'));
          $privilege_set = array_column($privilege, 'menu_name');
        
      $data = $this->inventory_model->get_product_code_data($query);
        if ($data) {
              $output.= "
                          <td>
                            <input type='checkbox' name='record'>
                          </td>
                          <td>
                            <input class='form-control' name='product_code[]' value='" . $data->product_code . "' readonly>
                          </td>
                          <td>
                            <input class='form-control' name='product_name[]' value='" . $data->product_name . "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" . $data->product_id . "' readonly>
                          </td>
                          <td>
                            <input type='text' class='form-control' name='stock_qty[]' value='" . $data->product_stock . "' readonly>
                          </td>
                          <td>
                            <input type='number' class='form-control sales_cal stock_cal' name='sales_qty[]' value='0' min='1' required>
                          </td>";
                          if($this->session->userdata('user_type') == "Client" or in_array('Show Purchase Price', $privilege_set)){
                          $output.= "<td class='tp'>
                            <input type='text' class='form-control' name='tp[]' value='" . $data->unit_price . "' readonly>
                          </td>";
                      }
                          $output.= "<td>";
                          if($this->session->userdata('user_type') == "Client" or in_array('Sales MRP Editable', $privilege_set)){
                           $output.= "<input type='number' class='form-control sales_cal' name='mrp[]' value='" . $data->product_unit_mrp . "' step='0.01' required>";
                        }else{
                            $output.= "<input type='number' class='form-control sales_cal' name='mrp[]' value='" . $data->product_unit_mrp . "' step='0.01' required readonly>";
                        }
                         $output.= " </td>
                          <td>
                            <input type='text' class='form-control' name='unit[]' value='" . $data->unit_name . "' readonly>
                          </td>
                          <td>
                            <input type='text' class='form-control' name='sales_vat[]' value='" . $data->product_vat_per . "' readonly>
                          </td>
                          <td>
                            <input type='number' class='form-control sales_cal' name='sales_discount[]' value='0' step='0.01' onkeyup='snumber_to_persentage()'>
                          </td>
                          <td>
                          <input type='number' class='form-control sales_cal' name='sales_discount_percent[]' value='0' step='0.01' onkeyup='spersentage_to_number()' readonly></td>
                          <td colspan='2'>
                            <input type='text' class='form-control' name='total_amount[]' value='0' readonly>
                          </td>
                        
                      ";
      echo $output;
         } 
     }

     }

     public function purchase_product_code_data()
     {
      $output = "";
     $query = $this->input->post('txt');
     //echo $query;
     if ($query !== "") {
        
      $data = $this->inventory_model->get_product_code_data($query);
        if ($data) {
              $output.= "
                          <td><input type='checkbox' name='purchase_record'></td><td><input class='form-control' name='product_code[]' value='" . $data->product_code . "' readonly></td><td><input class='form-control' name='product_name[]' value='" . $data->product_name . "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" . $data->product_id . "' readonly></td><td><input type='number' class='form-control purchase_cal' name='purchase_qty[]' value='0' min='1' required></td><td><input type='number' class='form-control purchase_cal' name='unit_price[]' value='" . $data->unit_price . "'step='0.01' required></td><td><input type='text' class='form-control' name='unit[]' value='" . $data->unit_name . "' readonly></td><td><input type='number' class='form-control purchase_cal numtoper' name='purchase_discount[]' value='0' step='0.01'></td><td><input type='number' class='form-control pertonum' name='discount_per[]' value='0' step='0.01'></td><td colspan='2'><input type='text' class='form-control' name='total_amount[]' value='0' readonly></td>
                        
                      ";
      echo $output;
         } 
     }

     }


/////////////excel export///////////
    public function createExcel() {
    // create file name
        $fileName = 'Quotation-List-'.time().'.xlsx';  
        $empInfo = $this->inventory_model->get_quotation_list();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Quotation#');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'To');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Title');

        // set Row
        $rowCount = 2;
        foreach ($empInfo as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->quotation_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->quotation_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "custom");
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element->quotation_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element->quotation_title);
            
            $rowCount++;
        }
        //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save(ROOT_UPLOAD_IMPORT_PATH.$fileName);
    // download file
        header("Content-Type: application/vnd.ms-excel");
        //redirect(HTTP_UPLOAD_IMPORT_PATH.$fileName);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
    }

/////////////excel export///////////
        
}
