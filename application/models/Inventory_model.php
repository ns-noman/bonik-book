<?php 
class Inventory_model extends CI_Model {

//////////////////start user//////////////////////
	//User access
	public function check_user_exist($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_email', $email);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

	//Check User
	public function check_user_login($email, $password)
    {
        $arr_where = array
        (
            'user_email' => $email,
            'user_password' => $password
        );
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($arr_where);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    //user registration
    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }
        
    //Update Selected User Record
    public function update_user_id($user_data, $id){
        $this->db->where('user_id', $id);
        $this->db->update('users', $user_data);
    }
    
    //Get Selected User Record
    public function show_user_by_id($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }


//////////////////end user//////////////////////

   // Get package Information
    public function get_package()
    {
        $this->db->select('*');
        $this->db->order_by("package_name", "asc");
        $this->db->from('vendor_package');
        $query = $this->db->get();      
        return $query->result();            
    }

    //package entry
    public function save_package($package)
    {
        return $this->db->insert('vendor_package', $package);
    }

    // Get package Information
    public function get_package_by_id($package_id)
    {
        $this->db->select('*');
        $this->db->from('vendor_package');
        $this->db->where('package_id', $package_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update package
    public function update_package($package, $package_id)
    {
        $this->db->where('package_id', $package_id);
        $this->db->update('vendor_package', $package);
    }

    //Client registration
    public function save_client($client)
    {
        return $this->db->insert('clients', $client);
    }

    // Get Client Information
    public function get_active_clients(){
		$date = date('Y-m-d');
        $this->db->select('*');
        $this->db->order_by("client_name", "asc");
        $this->db->from('clients');
		$this->db->where('expire_date >=', $date);
        $this->db->join('vendor_package', 'clients.package_id = vendor_package.package_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

	public function get_expired_clients(){
		$date = date('Y-m-d');
        $this->db->select('*');
        $this->db->order_by("client_name", "asc");
        $this->db->from('clients');
		$this->db->where('expire_date <', $date);
        $this->db->join('vendor_package', 'clients.package_id = vendor_package.package_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

	// Get Client Information
    public function get_expired_client_in_one_month($date){
		$one_month_later = date('Y-m-d', strtotime('+1 month', strtotime($date)));
        $this->db->select('*');
        $this->db->order_by("client_name", "asc");
        $this->db->from('clients');
		$this->db->where('expire_date >=', $date); // Clients whose expire_date is greater than the given date
		$this->db->where('expire_date <=', $one_month_later); // Clients whose expire_date is less than or equal to one month later
        $this->db->join('vendor_package', 'clients.package_id = vendor_package.package_id', 'left');
		$query = $this->db->get();      
        return $query->result();            
    }

    //get client by id    
    public function get_user_client($client_code)
    {
        $this->db->select('*');
        $this->db->from('clients');
        $this->db->where('client_code', $client_code);
        $query = $this->db->get();
        return $query->row();
    }

    //get client by id    
    public function get_client_by_id($client_id)
    {
        $this->db->select('*');
        $this->db->from('clients');
        $this->db->where('client_code', $client_id);
        $this->db->join('vendor_package', 'clients.package_id = vendor_package.package_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    //get client by id    
    public function get_client_id($client_id)
    {
        $this->db->select('*');
        $this->db->from('clients');
        $this->db->where('client_id', $client_id);
        $this->db->join('vendor_package', 'clients.package_id = vendor_package.package_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    //Update client
    public function update_client($client, $client_id)
    {
        $this->db->where('client_id', $client_id);
        $this->db->update('clients', $client);
    }

    //save  manufacturar
    public function save_manufacturer($manufacturer_info)
    {
        return $this->db->insert('setup_manufacturer', $manufacturer_info);
    }

    //get manufacturar
    public function get_manufacturer()
    {
        $this->db->select('*');
        $this->db->from('setup_manufacturer');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get manufacturar by id    
    public function get_manufacturer_by_id($man_id)
    {
        $this->db->select('*');
        $this->db->from('setup_manufacturer');
        $this->db->where('man_id', $man_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update manufacturer
    public function update_manufacturer($manufacturer_info, $man_id)
    {
        $this->db->where('man_id', $man_id);
        $this->db->update('setup_manufacturer', $manufacturer_info);
    }

    //save  supplier
    public function save_supplier($supplier_info)
    {
        return $this->db->insert('setup_supplier', $supplier_info);
    }

    //get supplier
    public function get_supplier()
    {
        $this->db->select('*');
        $this->db->from('setup_supplier');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get supplier by id    
    public function get_supplier_by_id($supplier_id)
    {
        $this->db->select('*');
        $this->db->from('setup_supplier');
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update supplier
    public function update_supplier($supplier_info, $supplier_id)
    {
        $this->db->where('supplier_id', $supplier_id);
        $this->db->update('setup_supplier', $supplier_info);
    }

     //save  customer
    public function save_customer($customer_info)
    {
        return $this->db->insert('setup_customers', $customer_info);
    }

    //get customer
    public function get_customer()
    {
        $this->db->select('*');
        $this->db->from('setup_customers');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_organization !=', "");
        $query = $this->db->get();      
        return $query->result();
    }

    //get customer
    public function get_walking_customer()
    {
        $this->db->select('*');
        $this->db->from('setup_customers');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_organization =', "");
        $query = $this->db->get();      
        return $query->result();
    }

    //get customer by id    
    public function get_customer_by_id($customer_id)
    {
        $this->db->select('*');
        $this->db->from('setup_customers');
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update customer
    public function update_customer($customer_info, $customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('setup_customers', $customer_info);
    }

    //product category list
    public function get_product_category()
    {
        $this->db->select('*');
        $this->db->order_by("product_category_name", "asc");
        $this->db->from('setup_category');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }

//save  location
    public function save_location($location_info)
    {
        return $this->db->insert('setup_locations', $location_info);
    }

    //get location
    public function get_location()
    {
        $this->db->select('*');
        $this->db->from('setup_locations');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get location by id    
    public function get_location_by_id($location_id)
    {
        $this->db->select('*');
        $this->db->from('setup_locations');
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update location
    public function update_location($location_info, $location_id)
    {
        $this->db->where('location_id', $location_id);
        $this->db->update('setup_locations', $location_info);
    }

    //save  expense type
    public function save_expense_type($expense_type_info)
    {
        return $this->db->insert('setup_expense_types', $expense_type_info);
    }

    //get expense type
    public function get_expense_type()
    {
        $this->db->select('*');
        $this->db->from('setup_expense_types');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get expense type by id    
    public function get_expense_type_by_id($expense_type_id)
    {
        $this->db->select('*');
        $this->db->from('setup_expense_types');
        $this->db->where('expense_type_id', $expense_type_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update expense type
    public function update_expense_type($expense_type_info, $expense_type_id)
    {
        $this->db->where('expense_type_id', $expense_type_id);
        $this->db->update('setup_expense_types', $expense_type_info);
    }

    //save  expense head
    public function save_expense_head($expense_head_info)
    {
        return $this->db->insert('setup_expense_heads', $expense_head_info);
    }

    //get expense head
    public function get_expense_head()
    {
        $this->db->select('*');
        $this->db->from('setup_expense_heads');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get expense head by id    
    public function get_expense_head_by_id($expense_head_id)
    {
        $this->db->select('*');
        $this->db->from('setup_expense_heads');
        $this->db->where('expense_head_id', $expense_head_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update expense head
    public function update_expense_head($expense_head_info, $expense_head_id)
    {
        $this->db->where('expense_head_id', $expense_head_id);
        $this->db->update('setup_expense_heads', $expense_head_info);
    }

    //save  product category
    public function save_product_category($category_info)
    {
        return $this->db->insert('setup_category', $category_info);
    }



    //get product category by id    
    public function get_product_category_by_id($product_category_id)
    {
        $this->db->select('*');
        $this->db->from('setup_category');
        $this->db->where('product_category_id', $product_category_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update product category
    public function update_product_category($category_info, $product_category_id)
    {
        $this->db->where('product_category_id', $product_category_id);
        $this->db->update('setup_category', $category_info);
    }


    //Add product Information
    public function add_product($product){
        $this->db->insert('products', $product);
    }
    
    //Add stock Information
    public function add_stock($stock){
        $this->db->insert('inventory_stock', $stock);
    }
    
    //save  unit
    public function save_unit($unit_info)
    {
        return $this->db->insert('setup_units', $unit_info);
    }

    //get unit
    public function get_unit()
    {
        $this->db->select('*');
        $this->db->order_by('unit_name','asc');
        $this->db->from('setup_units');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get unit by id    
    public function get_unit_by_id($unit_id)
    {
        $this->db->select('*');
        $this->db->from('setup_units');
        $this->db->where('unit_id', $unit_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update unit
    public function update_unit($unit_info, $unit_id)
    {
        $this->db->where('unit_id', $unit_id);
        $this->db->update('setup_units', $unit_info);
    }
    
    // Get product Information
    public function get_product()
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        //$this->db->where('product_status', 1);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get product Information
    public function get_low_stock()
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        //$this->db->where('product_status', 1);
        $this->db->where('inventory_stock.product_stock  <= product_reorder_level');
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get product Information
    public function check_barcode($code)
    {
        $this->db->select('product_code');
        $this->db->from('products');
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->where('product_code', $code);
        $query = $this->db->get();
        $result = $query->row();
        return $result;            
    }

 
// Get product hitory
    public function  get_stock_history($product_id, $date)
    {
        $this->db->select('*');
        $this->db->from(' inventory_stock_history');
        //$this->db->where('inventory_stock_history.client_id', $this->session->userdata('client_code'));
        $this->db->where('inventory_stock_history.product_id', $product_id);
        $this->db->where('inventory_stock_history.stock_history_date', $date);
         $query = $this->db->get();
        $result = $query->row();
        return $result;           
    }

    // Get product Information
    public function get_product_by_category($category_id)
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        //$this->db->where('product_status', 1);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->where('products.category_id', $category_id);
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get product Information
    public function get_product_by_manufacturer($man_id)
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        //$this->db->where('product_status', 1);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->where('products.manufacturer_id', $man_id);
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }


    // Get product Information
    public function get_product_by_priduct($product_id)
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        //$this->db->where('product_status', 1);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->where('products.product_id', $product_id);
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get product Information
    public function get_active_product()
    {
        $this->db->select('*');
        $this->db->order_by("products.product_name", "asc");
        $this->db->from('products');
        $this->db->where('product_status', 1);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }



    //Get Selected product Record
    public function get_product_by_id($product_id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('products.product_id', $product_id);
        $this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        $this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    //Get Selected product Record
    public function get_product_code_data($code)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('products.product_code', $code);
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        //$this->db->join('setup_category', 'products.category_id = setup_category.product_category_id', 'left');
        //$this->db->join('setup_manufacturer', 'products.manufacturer_id = setup_manufacturer.man_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id = inventory_stock.product_id');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    //Update Selected product
    public function update_product_id($product_data, $id)
    {
        $this->db->where('product_id', $id);
        $this->db->update('products', $product_data);
    }

    

//purchase//
    //purchase product search
    public function purchase_product_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
          
        $this->db->where('products.client_id', $this->session->userdata('client_code'));
        $this->db->where("product_status =", 1);
        $this->db->group_start();
        $this->db->or_like('product_name', $postData['search'], 'both');
        $this->db->or_like('product_code', $postData['search'], 'both');
        $this->db->or_like('product_sn', $postData['search'], 'both');
        $this->db->or_like('product_model', $postData['search'], 'both');
        $this->db->group_end();
       $this->db->limit(100);
           
       $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
       $this->db->join('inventory_stock', 'products.product_id =  inventory_stock.product_id');

           $records = $this->db->get('products')->result();

           foreach($records as $row ){
              $response[] = array("value"=>$row->product_id,
                                  "code"=>$row->product_code,
                                  "label"=>$row->product_name,
                                  "price"=>$row->product_unit_price,
                                  "unit"=>$row->unit_name
                                  //"stock"=>$row->product_stock
                              );
           }

         }

         return $response;
      }
    //get stock product
    public function get_stock_product($product_id)
    {
        $this->db->select('*');
        $this->db->from('inventory_stock');
        $this->db->where('inventory_stock.product_id', $product_id);
        $this->db->join('products', 'inventory_stock.product_id = products.product_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

     //Update product stock
    public function update_product_stock($stock_item, $product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->update('inventory_stock', $stock_item);
    }

    // Get Last purchase invoice no
    public function get_purchase_invoice_no()
    {
        $this->db->select('*');
        $this->db->from('purchase_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }


    //add purchase item
    public function add_purchase_item($purchase_item)
    {
        return $this->db->insert('purchase_items', $purchase_item);
    }

    //delete purchase item
    public function delete_purchase_item($purchase_invoice_id)
    {
        $this->db->where('purchase_invoice_id', $purchase_invoice_id);
        $this->db->delete('purchase_items');
    }

    //add purchase invoice
    public function add_purchase_invoice($invoice_info)
    {
        return $this->db->insert('purchase_invoice', $invoice_info);
    }

    //add purchase invoice
    public function add_purchase_payment($payment_info)
    {
        return $this->db->insert('purchase_payment', $payment_info);
    }

    //add purchase invoice
    public function add_supplyer_payment($supplyer_payment)
    {
        return $this->db->insert('supplier_payment', $supplyer_payment);
    }

    // Get Last purchase invoice no
    public function get_purchase_payment($purchase_invoice_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_payment');
        $this->db->where('purchase_invoice_id', $purchase_invoice_id);
        $this->db->order_by('id','asc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //Update Selected purchase invoice
    public function update_purchase_invoice($invoice_info, $purchase_invoice_id)
    {
        $this->db->where('purchase_invoice_id', $purchase_invoice_id);
        $this->db->update('purchase_invoice', $invoice_info);
    }

    public function update_purchase_payment($payment_info, $purchase_payment_id)
    {
        $this->db->where('purchase_payment_id', $purchase_payment_id);
        $this->db->update('purchase_payment', $payment_info);
    }

    //get purchase invoice
    public function get_purchase_invoice($purchase_invoice_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_id', $purchase_invoice_id);
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $this->db->join('users', 'purchase_invoice.purchase_invoice_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get purchase item list
    public function get_purchase_item($purchase_invoice_id)
    {
        $this->db->select('*');
        $this->db->select_sum('purchase_item_quantity');
        $this->db->select_sum('purchase_item_amount');
        $this->db->select_sum('purchase_item_discount');
        $this->db->group_by('purchase_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('purchase_invoice_id', $purchase_invoice_id);
        $this->db->from('purchase_items');
        $this->db->join('products', 'purchase_items.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $this->db->join('inventory_stock', 'products.product_id =  inventory_stock.product_id');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list
    public function get_purchase_list()
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice.id", "desc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get purchase list
    public function get_purchase_list_by_supplier($supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice.id", "desc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list
    public function get_datwise_purchase_list_by_supplier($supplier_id, $from_date='', $to_date='')
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice.id", "desc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.supplier_id', $supplier_id);
        if(!empty($from_date && $to_date)){
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
    }
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list
    public function get_datwise_purchase_list($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice.id", "asc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list
    public function get_datwise_purchase_return($date)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_return_invoice.id", "asc");
        $this->db->from('purchase_return_invoice');
        $this->db->where('purchase_return_date', $date);
        $this->db->where('purchase_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }


    // Get purchase list
    public function get_purchase_return_list($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_return_invoice.id", "asc");
        $this->db->from('purchase_return_invoice');
        //$this->db->where('purchase_return_date', $date);
        $this->db->where('purchase_return_date >=', $from_date);
        $this->db->where('purchase_return_date <=', $to_date);
        $this->db->where('purchase_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list
    public function get_purchase_return_list_supplier($supplier_id, $from_date='', $to_date='')
    {
        $this->db->select('*');
        $this->db->order_by("purchase_return_invoice.id", "asc");
        $this->db->from('purchase_return_invoice');
        //$this->db->where('purchase_return_date', $date);
         if(!empty($from_date && $to_date)){
        $this->db->where('purchase_return_date >=', $from_date);
        $this->db->where('purchase_return_date <=', $to_date);
        }
        $this->db->where('purchase_return_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }


    // Get purchase list
    public function get_datwise_purchase_return_supplier($date, $supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_return_invoice.id", "asc");
        $this->db->from('purchase_return_invoice');
        $this->db->where('purchase_return_date', $date);
        $this->db->where('purchase_return_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

   //purchase item
   public function get_purchase_item_id($purchase_item_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_items');
        $this->db->where('purchase_item_id', $purchase_item_id);
        $query = $this->db->get();
        return $query->row();   
    }

    //Update Selected purchase item
    public function update_purchase_item($purchase_item, $purchase_item_id)
    {
        $this->db->where('purchase_item_id', $purchase_item_id);
        $this->db->update('purchase_items', $purchase_item);
    }

    //save purchase return
    public function add_purchase_return_item($return_item)
    {
        return $this->db->insert('purchase_return_item', $return_item);
    }

     //save purchase return
    public function add_purchase_return_invoice($return_invoice_info)
    {
        return $this->db->insert('purchase_return_invoice', $return_invoice_info);
    }

    //delete purchase item
    public function delete_purchase_return_item()
    {
        $this->db->where('purchase_return_quantity', 0);
        $this->db->delete('purchase_return_item');
    }

   // Get purchase return list
    public function get_purchase_return()
    {
        $this->db->select('*');
        $this->db->order_by("purchase_return_invoice.id", "desc");
        $this->db->from('purchase_return_invoice');
        $this->db->where('purchase_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     //get purchase return invoice
    public function get_purchase_return_invoice($purchase_return_id)
    {
        $this->db->select('*');
        $this->db->select('purchase_return_invoice.purchase_invoice_created_at as created_at');
        $this->db->from('purchase_return_invoice');
        $this->db->where('purchase_return_id', $purchase_return_id);
        $this->db->join('setup_supplier', 'purchase_return_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $this->db->join('purchase_invoice', 'purchase_return_invoice.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
        $this->db->join('users', 'purchase_return_invoice.purchase_invoice_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get purchase item list
    public function get_purchase_return_item($purchase_return_id)
    {
        $this->db->select('*');
        //$this->db->select_sum('purchase_item_quantity');
        //$this->db->select_sum('purchase_item_amount');
        //$this->db->select_sum('purchase_item_discount');
        //$this->db->group_by('purchase_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('purchase_return_id', $purchase_return_id);
        $this->db->from('purchase_return_item');
        $this->db->join('products', 'purchase_return_item.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }


//sales supplier search
    public function sales_supplier_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
           $this->db->where('setup_supplier.client_id', $this->session->userdata('client_code'));
           $this->db->limit(20);
           //$this->db->where("supplier_status =", 1);
           //$this->db->where("supplier_name like '%".$postData['search']."%' ");
           $this->db->group_start();
            $this->db->or_like('supplier_name', $postData['search'],  'both');
            $this->db->or_like('supplier_mobile', $postData['search'],  'both');
            $this->db->or_like('supplier_org', $postData['search'],  'both');
            $this->db->group_end();

           $records = $this->db->get('setup_supplier')->result();

           foreach($records as $row ){
              $response[] = array("value"=>$row->supplier_id,
                                  "label"=>$row->supplier_name." | Mobile:".$row->supplier_mobile." | Organization:".$row->supplier_org,
                                  "mobile"=>$row->supplier_mobile
                              );
           }

         }

         return $response;
      }

      //sales supplier search
    public function ledger_supplier_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
           $this->db->where('setup_supplier.client_id', $this->session->userdata('client_code'));
           $this->db->limit(20);
           
           $this->db->group_start();
            $this->db->or_like('supplier_name', $postData['search'],  'both');
            $this->db->or_like('supplier_mobile', $postData['search'],  'both');
            $this->db->or_like('supplier_org', $postData['search'],  'both');
            $this->db->group_end();

           $records = $this->db->get('setup_supplier')->result();

           foreach($records as $row ){
            $balance = $this->get_supplier_transaction($row->supplier_id);
            if ($balance){
                $last_balance = $balance->supplier_transaction_balance;
            }else{
                $last_balance = 0;
            }
            
              $response[] = array("value"=>$row->supplier_id,
                                  "label"=>$row->supplier_name." | Mobile:".$row->supplier_mobile." | Organization:".$row->supplier_org,
                                  "mobile"=>$row->supplier_mobile,
                                  "balance"=> $last_balance
                                  
                              );
           }

         }

         return $response;
      }

    
//purchase//

//sales//
    //sales customer search
    public function sales_customer_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
           $this->db->where('setup_customers.client_id', $this->session->userdata('client_code'));
           $this->db->limit(20);
           $this->db->where("customer_status =", 1);
           //$this->db->where("customer_name !==", "Walking Customer");
           //$this->db->where("customer_name like '%".$postData['search']."%' ");
            //$this->db->or_where("customer_mobile like '%".$postData['search']."%' ");
            //$this->db->or_where("customer_organization like '%".$postData['search']."%' ");
           $this->db->group_start();
            $this->db->or_like('customer_name', $postData['search'], 'both');
            $this->db->or_like('customer_mobile', $postData['search'], 'both');
            $this->db->or_like('customer_organization', $postData['search'],  'both');
            $this->db->group_end();

           $records = $this->db->get('setup_customers')->result();

           foreach($records as $row ){
            $balance = $this->get_customer_transaction($row->customer_id);
            if ($balance){
                $last_balance = $balance->customer_transaction_balance;
            }else{
                $last_balance = 0;
            }
              $response[] = array("value"=>$row->customer_id,
                                  "label"=>$row->customer_name." | Mobile:".$row->customer_mobile." | Organization :".$row->customer_organization,
                                  "mobile"=>$row->customer_mobile,
                                  "org"=>$row->customer_organization,
                                  "balance"=>$last_balance
                              );
           }

         }

         return $response;
      }

    //sales product search
    public function sales_product_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
           $this->db->where('products.client_id', $this->session->userdata('client_code'));
           $this->db->where("product_status =", 1);
           //$this->db->where("product_stock >", 0);
           // $this->db->where("product_name like '%".$postData['search']."%' ");
           // $this->db->or_where("product_code like '%".$postData['search']."%' ");
           $this->db->group_start();
            $this->db->or_like('product_name', $postData['search'], 'both');
            $this->db->or_like('product_code', $postData['search'], 'both');
            $this->db->or_like('product_sn', $postData['search'], 'both');
            $this->db->or_like('product_model', $postData['search'], 'both');
            $this->db->group_end();
           $this->db->join('inventory_stock', 'products.product_id =  inventory_stock.product_id');
           $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');

           $records = $this->db->get('products')->result();

           foreach($records as $row ){
              $response[] = array("value"=>$row->product_id,
                                  "code"=>$row->product_code,
                                  "label"=>$row->product_name,
                                  "mrp"=>$row->product_unit_mrp,
                                  "unit"=>$row->unit_name,
                                  "stock"=>$row->product_stock,
                                  "tp"=>$row->product_unit_price,
                                  "vat"=>number_format((float)$row->product_vat_per, 2, '.', '')
                              );
           }

         }

         return $response;
      }

   // Get Last sales invoice no
    public function get_sales_invoice_no()
    {
        $this->db->select('*');
        $this->db->from('sales_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    // Get Last purchase
    public function get_last_purchase($product_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_items');
        $this->db->where("product_id", $product_id);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //add sales item
    public function add_sales_item($sales_item)
    {
        return $this->db->insert('sales_items', $sales_item);
    }

    // delete sales item
    public function delete_sales_item($sales_invoice_id)
    {
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->delete('sales_items');
    }

    //add sales invoice
    public function add_sales_invoice($invoice_info)
    {
        return $this->db->insert('sales_invoice', $invoice_info);
    }

    //add sales invoice payment
    public function add_sales_payment($payment_info)
    {
        return $this->db->insert('sales_payment', $payment_info);
    }

    //add sales invoice payment
    public function add_customer_payment($customer_payment)
    {
        return $this->db->insert('customer_payment', $customer_payment);
    }



    //Update Selected sales invoice
    public function update_sales_invoice($invoice_info, $sales_invoice_id)
    {
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->update('sales_invoice', $invoice_info);
    }

    //Update Selected sales invoice payment
    public function update_sales_payment($payment_info, $sales_payment_id)
    {
        $this->db->where('sales_payment_id', $sales_payment_id);
        $this->db->update('sales_payment', $payment_info);
    }

     // Get Last purchase payment no
    public function get_sales_payment($sales_invoice_id)
    {
        $this->db->select('*');
        $this->db->from('sales_payment');
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->order_by('id','asc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }



    //get sales invoice
    public function get_sales_invoice($sales_invoice_id)
    {
        $this->db->select('*');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('users', 'sales_invoice.sales_invoice_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    //get sales return invoice
    public function get_sales_return_invoice($sales_invoice_id)
    {
        $this->db->select('*');
        $this->db->select_sum('sr_total_amount');
        $this->db->select_sum('sr_amount_paid');
        $this->db->select_sum('sr_total_discount');
        $this->db->from('sales_return_invoice');
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->group_by('sales_invoice_id');
        $query = $this->db->get();
        return $query->row();
    }

    // Get sales item list
    public function get_sales_item($sales_invoice_id)
    {
        $this->db->select('*');
        $this->db->select_sum('sales_item_quantity');
        $this->db->select_sum('sales_item_amount');
        $this->db->select_sum('sales_item_discount');
        $this->db->group_by('sales_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('sales_invoice_id', $sales_invoice_id);
        $this->db->from('sales_items');
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $this->db->join('inventory_stock', 'sales_items.product_id =  inventory_stock.product_id');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list
    public function get_sales_list()
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "desc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_status', 1);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get sales list
    public function get_sales_list_by_customer($customer_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "desc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice.customer_id', $customer_id);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list
    public function get_datwise_sales_list_by_customer($customer_id, $from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "desc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice.customer_id', $customer_id);
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get sales list
    public function get_datwise_sales_list($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "desc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //Get Last sales return invoice no
    public function get_sr_invoice_no()
    {
        $this->db->select('*');
        $this->db->from('sales_return_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //get sales invoice
    public function get_sales_item_id($sales_item_id)
    {
        $this->db->select('*');
        $this->db->from('sales_items');
        $this->db->where('sales_item_id', $sales_item_id);
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    //add sales return item
    public function add_sales_return_item($return_item)
    {
        return $this->db->insert('sales_return_items', $return_item);
    }

    // delete sales return item
    public function delete_sales_return_item()
    {
        $this->db->where('sales_return_quantity', 0);
        $this->db->delete('sales_return_items');
    }

    //Update Selected sales item
    public function update_sales_item($sales_item, $sales_item_id)
    {
        $this->db->where('sales_item_id', $sales_item_id);
        $this->db->update('sales_items', $sales_item);
    }

    //add sales return invoice
    public function add_sales_return_invoice($return_invoice_info)
    {
        return $this->db->insert('sales_return_invoice', $return_invoice_info);
    }

    // Get sales return list
    public function get_sales_return()
    {
        $this->db->select('*');
        $this->db->order_by("sales_return_invoice.id", "desc");
        $this->db->from('sales_return_invoice');
        $this->db->where('sales_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     //get sales return invoice
    public function get_sales_return_detail($sales_return_id)
    {
        $this->db->select('*');
        //$this->db->select('sales_return_invoice.sales_invoice_created_at as created_at');
        $this->db->from('sales_return_invoice');
        $this->db->where('sales_return_id', $sales_return_id);
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('sales_invoice', 'sales_return_invoice.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
        $this->db->join('users', 'sales_return_invoice.sales_return_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get sales item list
    public function get_sales_return_item($sales_return_id)
    {
        $this->db->select('*');
        //$this->db->select_sum('sales_item_quantity');
        //$this->db->select_sum('sales_item_amount');
        //$this->db->select_sum('sales_item_discount');
        //$this->db->group_by('sales_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('sales_return_id', $sales_return_id);
        $this->db->from('sales_return_items');
        $this->db->join('products', 'sales_return_items.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

 // Get sales list
    public function get_datwise_sales_return($date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_return_invoice.id", "asc");
        $this->db->from('sales_return_invoice');
        $this->db->where('sales_return_date', $date);
        $this->db->where('sales_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list
    public function get_datwise_sales_return_customer($date, $customer_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_return_invoice.id", "asc");
        $this->db->from('sales_return_invoice');
        $this->db->where('sales_return_date', $date);
        $this->db->where('sales_return_invoice.customer_id', $customer_id);
        $this->db->where('sales_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

//sales//

//report//
    // Get sales list by date
    public function get_sales_invoice_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "asc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list by date
    public function get_purchase_invoice_by_customer($from_date='', $to_date='', $customer_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "asc");
        $this->db->from('sales_invoice');
        if(!empty($from_date && $to_date)){
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
    }
        $this->db->where('sales_invoice.customer_id', $customer_id);
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by date
    public function get_purchase_invoice_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice_no", "asc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by date
    public function get_purchase_invoice_by_supplier($from_date ='', $to_date ='', $supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice_no", "asc");
        $this->db->from('purchase_invoice');
        if(!empty($from_date && $to_date)){
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
    }
        $this->db->where('purchase_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by date
    public function get_purchase_product_by_id($from_date = '', $to_date = '', $product_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_items.purchase_invoice_no", "asc");
        $this->db->from('purchase_items');
        if(!empty($from_date && $to_date)){
        $this->db->where('purchase_item_date >=', $from_date);
        $this->db->where('purchase_item_date <=', $to_date);
    }
        $this->db->where('purchase_items.product_id', $product_id);
        //$this->db->where('purchase_items.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_items.supplier_id = setup_supplier.supplier_id', 'left');
        $this->db->join('purchase_invoice', 'purchase_items.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
        $this->db->join('products', 'purchase_items.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by date
    public function get_purchase_product($product_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_items.purchase_invoice_no", "asc");
        $this->db->from('purchase_items');
        $this->db->where('purchase_items.product_id', $product_id);
        //$this->db->where('purchase_items.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'purchase_items.supplier_id = setup_supplier.supplier_id', 'left');
        $this->db->join('purchase_invoice', 'purchase_items.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
        $this->db->join('products', 'purchase_items.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        
        $query = $this->db->get();      
        return $query->result();            
    }

      // Get sales list by date
    public function get_sales_product_by_id($from_date='', $to_date='', $product_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_items.sales_invoice_no", "asc");
        $this->db->from('sales_items');
        if(!empty($from_date && $to_date)){
        $this->db->where('sales_item_date >=', $from_date);
        $this->db->where('sales_item_date <=', $to_date);
    }
        $this->db->where('sales_items.product_id', $product_id);
        //$this->db->where('sales_items.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_items.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('sales_invoice', 'sales_items.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        
        $query = $this->db->get();      
        return $query->result();            
    }



    // Get sales list by date
    public function get_sales_item_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "asc");
        $this->db->from('sales_items');
        $this->db->where('sales_item_date >=', $from_date);
        $this->db->where('sales_item_date <=', $to_date);
        $this->db->where('sales_items.client_id', $this->session->userdata('client_code'));
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list by product
    public function get_sales_item_by_product($from_date, $to_date, $product_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "asc");
        $this->db->from('sales_items');
        $this->db->where('sales_item_date >=', $from_date);
        $this->db->where('sales_item_date <=', $to_date);
        $this->db->where('sales_items.product_id', $product_id);
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list by product
    public function get_sales_item_by_customer($from_date, $to_date, $customer_id)
    {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "asc");
        $this->db->from('sales_items');
        $this->db->where('sales_item_date >=', $from_date);
        $this->db->where('sales_item_date <=', $to_date);
        $this->db->where('sales_items.customer_id', $customer_id);
        $this->db->join('products', 'sales_items.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }


    // Get sales list by date
    public function get_sales_sum_by_date($from_date, $to_date)
    {
        $this->db->select_sum('sales_invoice_discount');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    // Get sales list by date
    public function get_sales_sum_by_customer($from_date, $to_date, $customer_id)
    {
        $this->db->select_sum('sales_invoice_discount');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('sales_invoice_status', 1);
        $query = $this->db->get();
        return $query->row();            
    }

    // Get purchase discount
    public function get_purchase_discount_by_date($from_date, $to_date)
    {
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    // Get purchase list by date
    public function get_purchase_item_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice_no", "asc");
        $this->db->from('purchase_items');
        $this->db->where('purchase_item_date >=', $from_date);
        $this->db->where('purchase_item_date <=', $to_date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->join('products', 'purchase_items.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by product
    public function get_purchase_item_by_product($from_date, $to_date, $product_id)
    {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice_no", "asc");
        $this->db->from('purchase_items');
        $this->db->where('purchase_item_date >=', $from_date);
        $this->db->where('purchase_item_date <=', $to_date);
        $this->db->where('purchase_items.product_id', $product_id);
        $this->db->join('products', 'purchase_items.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get purchase list by date
    public function get_purchase_sum_by_date($from_date, $to_date)
    {
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('purchase_invoice_status', 1);
        $query = $this->db->get();
        return $query->row();            
    }
//report//

    // Get stock
    public function get_all_stock_info()
    {
        $this->db->select('*');
        $this->db->order_by("inventory_stock.id", "asc");
        $this->db->from('inventory_stock');
        $this->db->join('products', 'inventory_stock.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get stock
    public function get_stock_info()
    {
        $this->db->select('*');
        $this->db->order_by("inventory_stock.id", "asc");
        $this->db->from('inventory_stock');
        $this->db->where('inventory_stock.client_id', $this->session->userdata('client_code'));
        $this->db->join('products', 'inventory_stock.product_id = products.product_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //add stock history
    public function add_stock_histoy($stock_info)
    {
        return $this->db->insert('inventory_stock_history', $stock_info);
    }

    //add stock history
    public function add_stock_adjustment($stock_info)
    {
        return $this->db->insert('inventory_stock_adjustment', $stock_info);
    }

    //purchase search
    public function fetch_purchase_return_search_list($query)
     {
        $this->db->select('*');
        $this->db->order_by("purchase_invoice_no", "desc");
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->group_start();
        $this->db->or_like('purchase_challan_no', $query, 'both');
        $this->db->or_like('purchase_invoice_no', $query, 'both');
        $this->db->or_like('supplier_name', $query,  'both');
        $this->db->or_like('supplier_mobile', $query,  'both');
        $this->db->group_end();
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
       $this->db->limit(100);
       return $this->db->get();
      
      
     }

     //sales search
    public function fetch_sales_return_search_list($query)
     {
        $this->db->select('*');
        $this->db->order_by("sales_invoice_no", "desc");
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->group_start();
        $this->db->or_like('sales_invoice_no', $query, 'both');
        $this->db->or_like('customer_name', $query, 'both');
       $this->db->or_like('customer_mobile', $query);
        $this->db->group_end();
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
       
       $this->db->limit(100);
       return $this->db->get();
      
      
     }

     //Get due bill list
    public function suppilerwise_service_bill($from_date, $to_date, $supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by('purchase_invoice_no', 'asc');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();
    }

    //Get due bill list
    public function suppilerwise_due_payment($supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by('purchase_invoice_no', 'asc');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice.supplier_id', $supplier_id);
        $this->db->where('purchase_invoice_bill_status', 0);
        $this->db->join('setup_supplier', 'purchase_invoice.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();
    }

    //Get due bill list
    public function customerwise_due_payment($customer_id)
    {
        $this->db->select('*');
        $this->db->order_by('sales_invoice_no', 'asc');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice.customer_id', $customer_id);
        $this->db->where('sales_invoice_bill_status', 0);
        $this->db->join('setup_customers', 'sales_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();
    }

////bank////
    //save  bank
    public function save_bank($bank_info)
    {
        return $this->db->insert('setup_banks', $bank_info);
    }

    //get bank
    public function get_bank()
    {
        $this->db->select('*');
        $this->db->order_by('bank_name','asc');
        $this->db->from('setup_banks');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();
    }

    //get bank by id    
    public function get_bank_by_id($bank_id)
    {
        $this->db->select('*');
        $this->db->from('setup_banks');
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->get();
        return $query->row();
    }

    //Update bank
    public function update_bank($bank_info, $bank_id)
    {
        $this->db->where('bank_id', $bank_id);
        $this->db->update('setup_banks', $bank_info);
    }

    //save bank transaction
    public function save_bank_transaction($transaction_info)
    {
        return $this->db->insert('bank_ledger', $transaction_info);
    }

    // Get bank ledger by date
    public function get_bank_ledger_by_date($from_date, $to_date, $bank_id)
    {
        $this->db->select('*');
        $this->db->order_by("bank_ledger.bank_transaction_date", "asc");
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_date >=', $from_date);
        $this->db->where('bank_transaction_date <=', $to_date);
        $this->db->where('bank_ledger.bank_id', $bank_id);
        $this->db->where('bank_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_banks', 'bank_ledger.bank_id = setup_banks.bank_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get bank ledger by date
    public function get_datewise_bank_ledger($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("bank_ledger.bank_transaction_date", "asc");
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_date >=', $from_date);
        $this->db->where('bank_transaction_date <=', $to_date);
        $this->db->where('bank_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_banks', 'bank_ledger.bank_id = setup_banks.bank_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get bank ledger by date
    public function get_bank_ledger($date)
    {
        $this->db->select('*');
        $this->db->order_by("bank_ledger.bank_transaction_date", "asc");
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_date', $date);
        $this->db->where('bank_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_banks', 'bank_ledger.bank_id = setup_banks.bank_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }
////bank////

////expense////
    
    // Get Last voucher no
    public function get_voucher_no()
    {
        $this->db->select('*');
        $this->db->from('expense_ledger');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //save  expense
    public function save_expense($expense_info)
    {
        return $this->db->insert('expense_ledger', $expense_info);
    }

    // Get expense
    public function get_expense_detail($expense_id)
    {
        $this->db->select('*');
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_id', $expense_id);
        //$this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_expense_heads', 'expense_ledger.expense_head_id = setup_expense_heads.expense_head_id', 'left');
        $this->db->join('users', 'expense_ledger.expense_transaction_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();            
    }

    // Get expense ledger by date
    public function get_expense_ledger_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("expense_ledger.id", "asc");
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_date >=', $from_date);
        $this->db->where('expense_transaction_date <=', $to_date);
        $this->db->where('expense_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_expense_heads', 'expense_ledger.expense_head_id = setup_expense_heads.expense_head_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get expense ledger by date
    public function get_expense_ledger_by_day($date)
    {
        $this->db->select('*');
        $this->db->order_by("expense_ledger.id", "asc");
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_date', $date);
        $this->db->where('expense_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_expense_heads', 'expense_ledger.expense_head_id = setup_expense_heads.expense_head_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get expense ledger by date
    public function get_expense_ledger_by_head($from_date, $to_date, $expense)
    {
        $this->db->select('*');
        $this->db->order_by("expense_ledger.id", "asc");
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_date >=', $from_date);
        $this->db->where('expense_transaction_date <=', $to_date);
        $this->db->where('expense_ledger.expense_head_id', $expense);
        $this->db->join('setup_expense_heads', 'expense_ledger.expense_head_id = setup_expense_heads.expense_head_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get expense ledger by date
    public function get_expense_ledger_by_name($from_date, $to_date, $name)
    {
        $this->db->select('*');
        $this->db->order_by("expense_ledger.id", "asc");
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_date >=', $from_date);
        $this->db->where('expense_transaction_date <=', $to_date);
        $this->db->where('expense_ledger.expense_transaction_description', $name);
        $this->db->or_where('expense_ledger.expense_transaction_contact', $name);
        $this->db->join('setup_expense_heads', 'expense_ledger.expense_head_id = setup_expense_heads.expense_head_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

 
////expense////
  
   // Get purchase item list
    public function get_supplier_due($supplier_id)
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_advance_payment');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->from('purchase_invoice');
        $query = $this->db->get();
        return $query->row();       
    }

    // Get purchase item list
    public function get_datewise_supplier_due($supplier_id, $from_date, $to_date)
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_advance_payment');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('purchase_invoice_date >=', $from_date);
        $this->db->where('purchase_invoice_date <=', $to_date);
        $this->db->from('purchase_invoice');
        $query = $this->db->get();
        return $query->row();       
    }

     public function get_customer_due($customer_id)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_advance_payment');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->where('customer_id', $customer_id);
        $this->db->from('sales_invoice');
        $query = $this->db->get();
        return $query->row();       
    }

    // Get sales item list
    public function get_datewise_customer_due($customer_id, $from_date, $to_date)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_advance_payment');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('sales_invoice_date >=', $from_date);
        $this->db->where('sales_invoice_date <=', $to_date);
        $this->db->from('sales_invoice');
        $query = $this->db->get();
        return $query->row();       
    }

    public function get_purchase_qty($product_id)
    {
        $this->db->select_sum('purchase_item_quantity');
        $this->db->select_sum('purchase_return_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->from('purchase_items');
        $query = $this->db->get();
        return $query->row();       
    }

    public function get_sales_qty($product_id)
    {
        $this->db->select_sum('sales_item_quantity');
        $this->db->select_sum('sales_return_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->from('sales_items');
        $query = $this->db->get();
        return $query->row();       
    }

    // Get package Information
    public function get_supplier_payment()
    {
        $this->db->select('*');
        $this->db->order_by("supplier_payment.id", "desc");
        $this->db->from('supplier_payment');
        $this->db->where('supplier_payment_amount >', 0);
        $this->db->where('supplier_payment.client_id', $this->session->userdata('client_code'));
        $this->db->limit(100);
        $this->db->join('setup_supplier', 'supplier_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //get supplier payment
    public function get_supplier_payment_info($payment_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_payment');
        $this->db->where('supplier_payment_id', $payment_id);
        $this->db->join('setup_supplier', 'supplier_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get supplier payment
    public function get_supplier_item($payment_id)
    {
        $this->db->select('*');
        $this->db->where('supplier_payment_id', $payment_id);
        $this->db->from('purchase_payment');
        //$this->db->where('purchase_payment_amount >', 0);
        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get supplier payment
    public function get_datwise_purchase_due_collection($date)
    {
        $this->db->select('*');
        $this->db->from('purchase_payment');
        $this->db->where('purchase_payment_date', $date);
        //$this->db->where('purchase_payment_amount >', 0);
        $this->db->where('purchase_payment.client_id', $this->session->userdata('client_code'));

        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
         $this->db->join('setup_supplier', 'purchase_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get supplier payment
    public function get_datwise_purchase_due($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->from('purchase_payment');
        //$this->db->where('purchase_payment_date', $date);
         $this->db->where('purchase_payment_date >=', $from_date);
        $this->db->where('purchase_payment_date <=', $to_date);
        //$this->db->where('purchase_payment_amount >', 0);
        $this->db->where('purchase_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
         $this->db->join('setup_supplier', 'purchase_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get supplier payment
    public function get_datwise_purchase_due_supplier($supplier_id, $from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->from('purchase_payment');
        //$this->db->where('purchase_payment_date', $date);
         if(!empty($from_date && $to_date)){
         $this->db->where('purchase_payment_date >=', $from_date);
        $this->db->where('purchase_payment_date <=', $to_date);
    }
        //$this->db->where('purchase_payment_amount >', 0);
        $this->db->where('purchase_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
         $this->db->join('setup_supplier', 'purchase_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get supplier payment
    public function get_datwise_purchase_due_collection_supplier($date, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_payment');
        $this->db->where('purchase_payment_date', $date);
        $this->db->where('purchase_payment.supplier_id', $supplier_id);
        //$this->db->where('purchase_payment_amount >', 0);
        $this->db->where('purchase_payment.client_id', $this->session->userdata('client_code'));
        
        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
         $this->db->join('setup_supplier', 'purchase_payment.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get package Information
    public function get_customer_payment()
    {
        $this->db->select('*');
        $this->db->order_by("customer_payment.id", "desc");
        $this->db->from('customer_payment');
        //$this->db->where('customer_payment_amount >', 0);
        $this->db->where('customer_payment.client_id', $this->session->userdata('client_code'));
        $this->db->limit(100);
        $this->db->join('setup_customers', 'customer_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //get customer payment
    public function get_customer_payment_info($payment_id)
    {
        $this->db->select('*');
        $this->db->from('customer_payment');
        $this->db->where('customer_payment_id', $payment_id);
        $this->db->join('setup_customers', 'customer_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get customer payment
    public function get_customer_item($payment_id)
    {
        $this->db->select('*');
        $this->db->where('customer_payment_id', $payment_id);
        $this->db->from('sales_payment');
        $this->db->where('sales_payment_amount >', 0);
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }


    public function get_purchase_total($date)
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_advance_payment');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_date', $date);
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_cash_purchase_total($date)
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_advance_payment');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->from('purchase_invoice');
        $this->db->where('purchase_invoice_date', $date);
        $this->db->where('purchase_invoice_status', 1);
        $this->db->where('purchase_payment_type', "Cash");
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

 
    public function get_sales_total($date)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_advance_payment');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_date', $date);
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_cash_sales_total($date)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_advance_payment');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->from('sales_invoice');
        $this->db->where('sales_invoice_date', $date);
        $this->db->where('sales_invoice_status', 1);
        $this->db->where('sales_payment_type', "Cash");
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_purchase_payment_total($date)
    {
        $this->db->select_sum('purchase_payment_amount');
        $this->db->from('purchase_payment');
        $this->db->where('purchase_payment_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }


    public function get_expense_total($date)
    {
        $this->db->select_sum('expense_transaction_amount');
        $this->db->from('expense_ledger');
        $this->db->where('expense_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_expense_total_cash($date)
    {
        $this->db->select_sum('expense_transaction_amount');
        $this->db->from('expense_ledger');
        $this->db->where('expense_payment_method', "Cash");
        $this->db->where('expense_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }
    
     public function get_expense_total_by_date($from_date, $to_date)
    {
        $this->db->select_sum('expense_transaction_amount');
        $this->db->from('expense_ledger');
        //$this->db->where('expense_transaction_date', $date);
         $this->db->where('expense_transaction_date >=', $from_date);
        $this->db->where('expense_transaction_date <=', $to_date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_sales_collection_total($date)
    {
        $this->db->select_sum('sales_payment_amount');
        $this->db->from('sales_payment');
        $this->db->where('sales_payment_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_customer_collection_total($date)
    {
        $this->db->select_sum('customer_payment_amount');
        $this->db->from('customer_payment');
        $this->db->where('customer_payment_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function get_supplier_payment_total($date)
    {
        $this->db->select_sum('supplier_payment_amount');
        $this->db->from('supplier_payment');
        $this->db->where('supplier_payment_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }



    //save cash transaction
    public function save_cash_transaction($transaction_info)
    {
        return $this->db->insert('cash_ledger', $transaction_info);
    }

    // Get cash ledger by date
    public function get_cash_ledger_by_date($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("cash_ledger.cash_transaction_date", "asc");
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_date >=', $from_date);
        $this->db->where('cash_transaction_date <=', $to_date);
        $this->db->where('cash_ledger.client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get cash ledger by date
    public function get_cash_ledger($date)
    {
        $this->db->select('*');
        $this->db->order_by("cash_ledger.cash_transaction_date", "asc");
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_date', $date);
        $this->db->where('cash_ledger.client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }

     public function get_debit_cash()
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Debit(+)');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

     public function get_credit_cash()
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Credit(-)');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

     public function get_debit_bank()
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Debit(+)');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

     public function get_credit_bank()
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Credit(-)');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

     public function opening_debit_cash_by_date($date)
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Debit(+)');
        $this->db->where('cash_transaction_date <=', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function opening_credit_cash_by_date($date)
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Credit(-)');
        $this->db->where('cash_transaction_date <=', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function current_debit_cash_by_date($date)
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Debit(+)');
        $this->db->where('cash_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function current_credit_cash_by_date($date)
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', 'Credit(-)');
        $this->db->where('cash_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

       public function opening_debit_bank_by_date($date)
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Debit(+)');
        $this->db->where('bank_transaction_date <=', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function opening_credit_bank_by_date($date)
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Credit(-)');
        $this->db->where('bank_transaction_date <=', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function current_debit_bank_by_date($date)
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Debit(+)');
        $this->db->where('bank_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }

    public function current_credit_bank_by_date($date)
    {
        $this->db->select_sum('bank_transaction_amount');
        $this->db->from('bank_ledger');
        $this->db->where('bank_transaction_type', 'Credit(-)');
        $this->db->where('bank_transaction_date', $date);
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();
        return $query->row();            
    }


    public function get_sales_due()
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->from('sales_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        //$this->db->where('sales_invoice_bill_status', 0);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function get_purchase_due()
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->from('purchase_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        //$this->db->where('purchase_invoice_bill_status', 0);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function datewise_sales($date)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->from('sales_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_date', $date);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function datewise_purchase($date)
    {
        $this->db->select_sum('purchase_total_amount');
        $this->db->select_sum('purchase_invoice_discount');
        $this->db->select_sum('purchase_total_discount');
        $this->db->select_sum('purchase_amount_paid');
        $this->db->select_sum('purchase_invoice_return_total');
        $this->db->select_sum('purchase_invoice_return_amount');
        $this->db->from('purchase_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('purchase_invoice_date', $date);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function sales_by_daterange($first_day, $last_day)
    {
        $this->db->select_sum('sales_total_amount');
        $this->db->select_sum('sales_total_vat');
        $this->db->select_sum('sales_invoice_discount');
        $this->db->select_sum('sales_total_discount');
        $this->db->select_sum('sales_amount_paid');
        $this->db->select_sum('sales_invoice_return_total');
        $this->db->select_sum('sales_invoice_return_amount');
        $this->db->from('sales_invoice');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_invoice_date >=', $first_day);
        $this->db->where('sales_invoice_date <=', $last_day);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function datewise_collection($date)
    {
        $this->db->select_sum('customer_payment_amount');
        $this->db->from('customer_payment');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_payment_date', $date);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function datewise_payment($date)
    {
        $this->db->select_sum('supplier_payment_amount');
        $this->db->from('supplier_payment');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('supplier_payment_date', $date);
        $query = $this->db->get();
        return $query->row(); 
    }

    public function get_monthly_expense($first_day, $last_day, $expense_head_id)
    {
        $this->db->select_sum('expense_transaction_amount');
        $this->db->from('expense_ledger');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('expense_transaction_date >=', $first_day);
        $this->db->where('expense_transaction_date <=', $last_day);
        $this->db->where('expense_head_id', $expense_head_id);
        $query = $this->db->get();
        return $query->row(); 
    }

    // Get Last sales invoice no
    public function get_sales_req_no()
    {
        $this->db->select('*');
        $this->db->from('sales_requisition');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //add req item
    public function add_req_item($sales_item)
    {
        return $this->db->insert('sales_requisition_items', $sales_item);
    }

    // // delete sales item
    // public function delete_sales_req_item($sales_req_id)
    // {
    //     $this->db->where('sales_req_id', $sales_req_id);
    //     $this->db->delete('sales_requisition_items');
    // }

    //add sales req
    public function add_sales_req($invoice_info)
    {
        return $this->db->insert('sales_requisition', $invoice_info);
    }

    //get sales req
    public function get_sales_req($sales_req_id)
    {
        $this->db->select('*');
        $this->db->from('sales_requisition');
        $this->db->where('sales_req_id', $sales_req_id);
        $this->db->join('setup_customers', 'sales_requisition.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('users', 'sales_requisition.sales_req_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get sales req item list
    public function get_req_item($sales_req_id)
    {
        $this->db->select('*');
        $this->db->select_sum('req_item_quantity');
        $this->db->select_sum('req_item_amount');
        $this->db->group_by('sales_requisition_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('sales_req_id', $sales_req_id);
        $this->db->from('sales_requisition_items');
        $this->db->join('products', 'sales_requisition_items.product_id = products.product_id', 'left');
        $this->db->join('inventory_stock', 'sales_requisition_items.product_id =  inventory_stock.product_id');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list
    public function pending_sales_req_list()
    {
        $this->db->select('*');
        $this->db->order_by("sales_req_no", "desc");
        $this->db->from('sales_requisition');
        $this->db->where('sales_requisition.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_req_status', 1);
        $this->db->join('setup_customers', 'sales_requisition.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('users', 'sales_requisition.sales_req_entry_by = users.user_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //add sales req
    public function add_req_approve_item($sales_item)
    {
        return $this->db->insert('sales_requisition_approve_items', $sales_item);
    }

     //Update Selected req
    public function update_sales_req($invoice_info, $sales_req_id)
    {
        $this->db->where('sales_req_id', $sales_req_id);
        $this->db->update('sales_requisition', $invoice_info);
    }

    // Get sales req item list
    public function get_app_req_item($sales_req_id)
    {
        $this->db->select('*');
        $this->db->select_sum('req_app_item_quantity');
        $this->db->select_sum('req_app_item_amount');
        $this->db->group_by('sales_requisition_approve_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('sales_req_id', $sales_req_id);
        $this->db->from('sales_requisition_approve_items');
        $this->db->join('products', 'sales_requisition_approve_items.product_id = products.product_id', 'left');
        $this->db->join('inventory_stock', 'sales_requisition_approve_items.product_id =  inventory_stock.product_id');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get req list
    public function approve_sales_req_list()
    {
        $this->db->select('*');
        $this->db->order_by("sales_req_no", "desc");
        $this->db->from('sales_requisition');
        $this->db->where('sales_requisition.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_req_status', 2);
        $this->db->join('setup_customers', 'sales_requisition.customer_id = setup_customers.customer_id', 'left');
        $this->db->join('users', 'sales_requisition.sales_req_entry_by = users.user_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }
    

     // Get menu list
    public function get_menu()
    {
        //$this->db->select('*');
        $this->db->select('m.menu_id, m.parent_menu_id, m.menu_name as mname, p.menu_name as pname');
        $this->db->order_by("m.id", "asc");
        $this->db->from('setup_menus m');
        $this->db->join('setup_menus p', 'm.parent_menu_id = p.menu_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     //add menu
    public function save_menu($menu)
    {
        return $this->db->insert('setup_menus', $menu);
    }

    //get menue
    public function get_menu_by_id($menu_id)
    {
        $this->db->select('m.menu_id, m.parent_menu_id, m.menu_name as mname, p.menu_name as pname');
        $this->db->from('setup_menus m');
        $this->db->where('m.menu_id', $menu_id);
        $this->db->join('setup_menus p', 'm.parent_menu_id = p.menu_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

     //Update menu
    public function update_menu($menu, $menu_id)
    {
        $this->db->where('menu_id', $menu_id);
        $this->db->update('setup_menus', $menu);
    }

     // Get menu list
    public function get_parent_menu()
    {
        $this->db->select('*');
        $this->db->order_by("menu_order", "asc");
        $this->db->from('setup_menus');
        $this->db->where('parent_menu_id', "");
        $query = $this->db->get();      
        return $query->result();            
    }

    public function get_sub_menu($menu_id)
    {
        $this->db->select('*');
        $this->db->order_by("menu_order", "asc");
        $this->db->from('setup_menus');
        $this->db->where('parent_menu_id', $menu_id);
        $query = $this->db->get();      
        return $query->result();            
    }

///user///
    // Get user Information
    public function get_user()
    {
        $this->db->select('*');
        $this->db->order_by('user_name', 'asc');
        $this->db->from('users');
        $this->db->where('user_type', 'User');
        $this->db->where('client_code', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get user Information
    public function get_all_user()
    {
        $this->db->select('*');
        $this->db->order_by('user_name', 'asc');
        $this->db->from('users');
        //$this->db->where('user_type', 'User');
        $this->db->where('client_code', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }

     //add user
    public function save_user($user_info)
    {
        return $this->db->insert('users', $user_info);
    }

    //get menue
    public function get_user_by_id($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get user Information
    public function get_user_privilege($user_id)
    {
        $this->db->select('*');
        $this->db->from('setup_user_menu_privilege');
        $this->db->where('user_id', $user_id);
        $this->db->join('setup_menus', 'setup_user_menu_privilege.menu_id = setup_menus.menu_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //add privilege
    public function save_user_privilege($privilege)
    {
        return $this->db->insert('setup_user_menu_privilege', $privilege);
    }

    //delete privilege
    public function delete_user_privilege($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('setup_user_menu_privilege');
    }

    
///user///

    public function get_opening_purchase($product_id, $date)
    {
        $this->db->select_sum('purchase_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where('purchase_item_date <', $date);
        $this->db->from('purchase_items');
        $query = $this->db->get();
        return $query->row();       
    }

    public function get_opening_sales($product_id, $date)
    {
        $this->db->select_sum('sales_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where('sales_item_date <', $date);
        $this->db->from('sales_items');
        $query = $this->db->get();
        return $query->row();       
    }

    public function purchase_qty($product_id, $from_date, $to_date)
    {
        $this->db->select_sum('purchase_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where('purchase_item_date >=', $from_date);
        $this->db->where('purchase_item_date <=', $to_date);
        $this->db->from('purchase_items');
        $query = $this->db->get();
        return $query->row();       
    }

     public function sales_qty($product_id, $from_date, $to_date)
    {
        $this->db->select_sum('sales_item_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where('sales_item_date >=', $from_date);
        $this->db->where('sales_item_date <=', $to_date);
        $this->db->from('sales_items');
        $query = $this->db->get();
        return $query->row();       
    }

    //save supplier transaction
    public function save_supplier_transaction($transaction_info)
    {
        return $this->db->insert('supplier_ledger', $transaction_info);
    }

    // Get Last  supplier transaction
    public function get_supplier_transaction($supplier_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('supplier_id', $supplier_id);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

      // Get purchase list
    public function get_supplier_ledger()
    {
        $this->db->select('*');
        $this->db->order_by("supplier_ledger.id", "asc");
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_supplier', 'supplier_ledger.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

      // Get purchase list
    public function get_supplier_ledger_by_supplier($supplier_id)
    {
        $this->db->select('*');
        $this->db->order_by("supplier_ledger.id", "asc");
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('supplier_ledger.supplier_id', $supplier_id);
        $this->db->join('setup_supplier', 'supplier_ledger.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get supplier_ledger
    public function get_supplier_ledger_by_date($supplier_id, $from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("supplier_ledger.id", "asc");
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('supplier_ledger.supplier_id', $supplier_id);
        $this->db->where('supplier_transaction_date >=', $from_date);
        $this->db->where('supplier_transaction_date <=', $to_date);
        $this->db->join('setup_supplier', 'supplier_ledger.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }
    
    // Get supplier_ledger
    public function get_supplier_ledger_datewise($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("supplier_ledger.id", "asc");
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('supplier_transaction_date >=', $from_date);
        $this->db->where('supplier_transaction_date <=', $to_date);
        $this->db->join('setup_supplier', 'supplier_ledger.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }



     //save customer transaction
    public function save_customer_transaction($transaction_info)
    {
        return $this->db->insert('customer_ledger', $transaction_info);
    }

    // Get Last  customer transaction
    public function get_customer_transaction($customer_id)
    {
        $this->db->select('*');
        $this->db->from('customer_ledger');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_id', $customer_id);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }
    
    // Get purchase list
    public function get_customer_ledger()
    {
        $this->db->select('*');
        $this->db->order_by("customer_ledger.id", "asc");
        $this->db->from('customer_ledger');
        $this->db->where('customer_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'customer_ledger.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

      // Get purchase list
    public function get_customer_ledger_by_customer($customer_id)
    {
        $this->db->select('*');
        $this->db->order_by("customer_ledger.id", "asc");
        $this->db->from('customer_ledger');
        $this->db->where('customer_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_ledger.customer_id', $customer_id);
        $this->db->join('setup_customers', 'customer_ledger.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get customer ledger
    public function get_customer_ledger_by_date($customer_id, $from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("customer_ledger.id", "asc");
        $this->db->from('customer_ledger');
        $this->db->where('customer_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_ledger.customer_id', $customer_id);
        $this->db->where('customer_transaction_date >=', $from_date);
        $this->db->where('customer_transaction_date <=', $to_date);
        $this->db->join('setup_customers', 'customer_ledger.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }
    
     // Get customer ledger
    public function get_customer_ledger_datewise($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("customer_ledger.id", "asc");
        $this->db->from('customer_ledger');
        $this->db->where('customer_ledger.client_id', $this->session->userdata('client_code'));
        $this->db->where('customer_transaction_date >=', $from_date);
        $this->db->where('customer_transaction_date <=', $to_date);
        $this->db->join('setup_customers', 'customer_ledger.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     //sales customer search
    public function ledger_customer_search($postData)
      {
         $response = array();
         if(isset($postData['search']) ){
           // Select record
           $this->db->select('*');
           $this->db->where('setup_customers.client_id', $this->session->userdata('client_code'));
           $this->db->where('setup_customers.customer_organization !=','');
           $this->db->limit(20);
           
           $this->db->group_start();
            $this->db->or_like('customer_name', $postData['search'],  'both');
            $this->db->or_like('customer_mobile', $postData['search'],  'both');
            $this->db->or_like('customer_organization', $postData['search'],  'both');
            $this->db->group_end();

           $records = $this->db->get('setup_customers')->result();

           foreach($records as $row ){
            $balance = $this->get_customer_transaction($row->customer_id);
            if ($balance){
                $last_balance = $balance->customer_transaction_balance;
            }else{
                $last_balance = 0;
            }
            
              $response[] = array("value"=>$row->customer_id,
                                  "label"=>$row->customer_name." | Mobile:".$row->customer_mobile." | Organization:".$row->customer_organization,
                                  "mobile"=>$row->customer_mobile,
                                  "balance"=> $last_balance
                                  
                              );
           }

         }

         return $response;
      }
//get customer payment
    public function get_customer_advance_payment_info($payment_id)
    {
        $this->db->select('*');
        $this->db->from('customer_ledger');
        $this->db->where('customer_ledger_id', $payment_id);
        $this->db->join('setup_customers', 'customer_ledger.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

       //get supplier payment
    public function get_supplier_advance_payment_info($payment_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_ledger_id', $payment_id);
        $this->db->join('setup_supplier', 'supplier_ledger.supplier_id = setup_supplier.supplier_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get Last quotation no
    public function get_quotation_no()
    {
        $this->db->select('*');
        $this->db->from('quotation_master');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

    //quotation item entry
    public function add_quotation_item($quotation_item)
    {
        return $this->db->insert('quotation_items', $quotation_item);
    }

    //quotation item entry
    public function add_quotation($quotation_info)
    {
        return $this->db->insert('quotation_master', $quotation_info);
    }

    //get customer payment
    public function get_quotation($quotation_id)
    {
        $this->db->select('*');
        $this->db->from('quotation_master');
        $this->db->where('quotation_id', $quotation_id);
        $this->db->join('users', 'quotation_master.quotation_entry_by = users.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    // Get sales item list
    public function get_quotation_item($quotation_id)
    {
        $this->db->select('*');
        //$this->db->select_sum('quotation_item_quantity');
        //$this->db->select_sum('quotation_item_amount');
        //$this->db->group_by('quotation_items.product_id');
        $this->db->order_by("product_name", "asc");
        $this->db->where('quotation_id', $quotation_id);
        $this->db->from('quotation_items');
        $this->db->join('products', 'quotation_items.product_id = products.product_id', 'left');
        //$this->db->join('inventory_stock', 'sales_items.product_id =  inventory_stock.product_id');
        $this->db->join('setup_units', 'products.measurement_unit = setup_units.unit_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    //product category list
    public function get_quotation_list()
    {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('quotation_master');
        $this->db->where('client_id', $this->session->userdata('client_code'));
        $query = $this->db->get();      
        return $query->result();            
    }


  // Get customer payment
    public function get_datwise_sales_due_collection($date)
    {
        $this->db->select('*');
        $this->db->from('sales_payment');
        $this->db->where('sales_payment_date', $date);
        $this->db->where('sales_payment.client_id', $this->session->userdata('client_code'));
        //$this->db->where('sales_payment_amount >', 0);
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
         $this->db->join('setup_customers', 'sales_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get customer payment
    public function get_datwise_sales_due_collection_customer($date, $customer_id)
    {
        $this->db->select('*');
        $this->db->from('sales_payment');
        $this->db->where('sales_payment_date', $date);
        $this->db->where('sales_payment.client_id', $this->session->userdata('client_code'));
        $this->db->where('sales_payment.customer_id', $customer_id);
        //$this->db->where('sales_payment_amount >', 0);
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
         $this->db->join('setup_customers', 'sales_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     public function supplier_due_payment($date)
    {
        $this->db->select_sum('purchase_payment_amount');
        $this->db->from('purchase_payment');
        $this->db->where('purchase_payment_date', $date);
        $this->db->where('purchase_invoice_date !=', $date);
        $this->db->where('purchase_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('purchase_invoice', 'purchase_payment.purchase_invoice_id = purchase_invoice.purchase_invoice_id', 'left');
        $query = $this->db->get();
        return $query->row();            
    }

    public function customer_due_payment($date)
    {
        $this->db->select_sum('sales_payment_amount');
        $this->db->from('sales_payment');
        $this->db->where('sales_payment_date', $date);
        $this->db->where('sales_invoice_date !=', $date);
        $this->db->where('sales_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
        $query = $this->db->get();
        return $query->row();            
    }

     // Get sales list
    public function get_sales_return_list($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->order_by("sales_return_invoice.id", "asc");
        $this->db->from('sales_return_invoice');
        //$this->db->where('sales_return_date', $date);
        $this->db->where('sales_return_date >=', $from_date);
        $this->db->where('sales_return_date <=', $to_date);
        $this->db->where('sales_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get sales list
    public function get_sales_return_list_customer($customer_id, $from_date='', $to_date='')
    {
        $this->db->select('*');
        $this->db->order_by("sales_return_invoice.id", "asc");
        $this->db->from('sales_return_invoice');
        //$this->db->where('sales_return_date', $date);
         if(!empty($from_date && $to_date)){
        $this->db->where('sales_return_date >=', $from_date);
        $this->db->where('sales_return_date <=', $to_date);
        }
        $this->db->where('sales_return_invoice.customer_id', $customer_id);
        $this->db->where('sales_return_invoice.client_id', $this->session->userdata('client_code'));
        $this->db->join('setup_customers', 'sales_return_invoice.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    // Get customer payment
    public function get_datwise_sales_due($from_date, $to_date)
    {
        $this->db->select('*');
        $this->db->from('sales_payment');
        //$this->db->where('sales_payment_date', $date);
         $this->db->where('sales_payment_date >=', $from_date);
        $this->db->where('sales_payment_date <=', $to_date);
        //$this->db->where('sales_payment_amount >', 0);
        $this->db->where('sales_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
         $this->db->join('setup_customers', 'sales_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

     // Get customer payment
    public function get_datwise_sales_due_customer($customer_id, $from_date='', $to_date='')
    {
        $this->db->select('*');
        $this->db->from('sales_payment');
        //$this->db->where('sales_payment_date', $date);
        if(!empty($from_date && $to_date)){
         $this->db->where('sales_payment_date >=', $from_date);
        $this->db->where('sales_payment_date <=', $to_date);
        }
        $this->db->where('sales_payment.customer_id', $customer_id);
        //$this->db->where('sales_payment_amount >', 0);
        $this->db->where('sales_payment.client_id', $this->session->userdata('client_code'));
        $this->db->join('sales_invoice', 'sales_payment.sales_invoice_id = sales_invoice.sales_invoice_id', 'left');
         $this->db->join('setup_customers', 'sales_payment.customer_id = setup_customers.customer_id', 'left');
        $query = $this->db->get();      
        return $query->result();            
    }

    
    public function get_user_collection($user_id, $from_date='', $to_date='', $type)
    {
        $this->db->select_sum('cash_transaction_amount');
        $this->db->from('cash_ledger');
        $this->db->where('cash_transaction_type', $type);
        if(!empty($from_date && $to_date)){
        $this->db->where('cash_transaction_date >=', $from_date);
        $this->db->where('cash_transaction_date <=', $to_date);
        }else{
        $this->db->where('cash_transaction_date', date('Y-m-d'));
        }
        $this->db->where('cash_transaction_entry_by', $user_id);
        $query = $this->db->get();
        return $query->row();            
    }



    

}
?>
