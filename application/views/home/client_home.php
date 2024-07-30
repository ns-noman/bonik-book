<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bonik Book</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom.css">
  <style type="text/css">
    .dropdown-menu-xl .dropdown-item {
    padding: 4px 5px;
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-blue navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <?php
        $privilege = $this->inventory_model->get_user_privilege($this->session->userdata('user_id'));
          $privilege_set = array_column($privilege, 'menu_name');
         
         ?>

       <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Sales
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Sales', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-sales'; ?>" class="dropdown-item">
          New Sales
          </a>
          <div class="dropdown-divider"></div>
        <?php } ?> 
        <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Invoice', $privilege_set)){ ?>
          <a href="<?php echo base_url().'manage-sales'; ?>" class="dropdown-item">
            Sales Invoice
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
        <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Return', $privilege_set)){ ?>
          <a href="<?php echo base_url().'sales-return'; ?>" class="dropdown-item">
           Sales Return
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Return List', $privilege_set)){ ?>
          <a href="<?php echo base_url().'sales-return-list'; ?>" class="dropdown-item">
           Sales Return List
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>  
        <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'daily-sales-report'; ?>" class="dropdown-item">
           Sales Report
          </a>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'sales-ledger'; ?>" class="dropdown-item">
           Sales Ledger
          </a>
          <?php } ?> 
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Requisition', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Requisition
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Requisition', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-sales-requisition'; ?>" class="dropdown-item">
          New Requisition
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Pending Requisition', $privilege_set)){ ?>
          <a href="<?php echo base_url().'pending-sales-requisition'; ?>" class="dropdown-item">
            Pending Requisition
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Approved Requisition', $privilege_set)){ ?>
          <a href="<?php echo base_url().'approved-sales-requisition'; ?>" class="dropdown-item">
           Approved Requisition
          </a>
           <?php } ?>
          
        </div>
      </li>
       <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Purchase
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Purchase', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-purchase'; ?>" class="dropdown-item">
          New Purchase
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Invoice', $privilege_set)){ ?> 
          <a href="<?php echo base_url().'manage-purchase'; ?>" class="dropdown-item">
            Purchase Invoice
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Return', $privilege_set)){ ?> 
          <a href="<?php echo base_url().'purchase-return'; ?>" class="dropdown-item">
           Purchase Return
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Return List', $privilege_set)){ ?> 
          <a href="<?php echo base_url().'purchase-return-list'; ?>" class="dropdown-item">
           Purchase Return List
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="dropdown-item">
           Purchase Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'purchase-ledger'; ?>" class="dropdown-item">
           Purchase Ledger
          </a>
          <?php } ?>
        </div>
      </li>
      <?php } ?> 


      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Quotation', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Quotation
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Quotation', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-quotation'; ?>" class="dropdown-item">
          New Quotation
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Quotation List', $privilege_set)){ ?>
          <a href="<?php echo base_url().'manage-quotation'; ?>" class="dropdown-item">
            Quotation List
          </a>
          <?php } ?>
          
        </div>
      </li>
      <?php } ?>

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Report', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Report
        </a>
        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="dropdown-item">
          Purchase Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'purchase-ledger'; ?>" class="dropdown-item">
           Purchase Ledger
          </a>
          <div class="dropdown-divider"></div>
          
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'daily-sales-report'; ?>" class="dropdown-item">
            Sales Report
          </a>
          <div class="dropdown-divider"></div>
          
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'sales-ledger'; ?>" class="dropdown-item">
           Sales Ledger
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'stock-report'; ?>" class="dropdown-item">
           Stock Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Low Stock Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'low-stock-report'; ?>" class="dropdown-item">
           Low Stock Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock History Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'stock-history-report'; ?>" class="dropdown-item">
           Stock History Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Profit & Loss Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'profit-loss-report'; ?>" class="dropdown-item">
           Profit & Loss Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Advance Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'supplier-ledger'; ?>" class="dropdown-item">
           Supplier Advance Ledger
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Due Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'supplier-due-report'; ?>" class="dropdown-item">
          Supplier Due Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Advance Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'customer-ledger'; ?>" class="dropdown-item">
           Customer Advance Ledger
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Due Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'customer-due-report'; ?>" class="dropdown-item">
          Customer Due Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'bank-ledger'; ?>" class="dropdown-item">
           Bank Ledger
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'cash-ledger'; ?>" class="dropdown-item">
           Cash Ledger
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Statement', $privilege_set)){ ?>
         <a href="<?php echo base_url().'expense-ledger'; ?>" class="dropdown-item">
           Expense Statement
          </a>
          <div class="dropdown-divider"></div>
           <?php } ?>

            <?php  if($this->session->userdata('user_type') == "Client" or in_array('User Collection & Payment', $privilege_set)){ ?>
         <a href="<?php echo base_url().'user-collection-payment'; ?>" class="dropdown-item">
           User Collection & Payment
          </a>
           <?php } ?>
        </div>

      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Product', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Product
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Product', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-product'; ?>" class="dropdown-item">
          New Product
          </a>
          <div class="dropdown-divider"></div>
           <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Product', $privilege_set)){ ?>

          <a href="<?php echo base_url().'product-list'; ?>" class="dropdown-item">
          Manage Product
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Barcode Print', $privilege_set)){ ?>
          <a href="<?php echo base_url().'barcode-generate'; ?>" class="dropdown-item">
            Barcode Print
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
         <!--  <?php  //if($this->session->userdata('user_type') == "Client" or in_array('Inventory Adjustment', $privilege_set)){ ?>
          <a href="<?php //echo base_url().'inventory-adjustment'; ?>" class="dropdown-item">
          Inventory Adjustment
          </a>
          <div class="dropdown-divider"></div>
          <?php //} ?>  -->
           <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'stock-report'; ?>" class="dropdown-item">
           Stock Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Low Stock Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'low-stock-report'; ?>" class="dropdown-item">
           Low Stock Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock History Report', $privilege_set)){ ?>
          <a href="<?php echo base_url().'stock-history-report'; ?>" class="dropdown-item">
           Stock History Report
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Category', $privilege_set)){ ?>
         <a href="<?php echo base_url().'product-category'; ?>" class="dropdown-item">
           Category
          </a>
           <div class="dropdown-divider"></div>
           <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Units', $privilege_set)){ ?>
         <a href="<?php echo base_url().'unit-list'; ?>" class="dropdown-item">
           Units
          </a>
          <div class="dropdown-divider"></div>
           <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manufacturer/Brand', $privilege_set)){ ?>
         <a href="<?php echo base_url().'manufacturer-list'; ?>" class="dropdown-item">
           Manufacturer/Brand
          </a>
          <?php } ?> 
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Customer
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Customer', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-customer'; ?>" class="dropdown-item">
          New Customer
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Customer', $privilege_set)){ ?>
          <a href="<?php echo base_url().'customer-list'; ?>" class="dropdown-item">
          Manage Customer
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>  
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Walking Customer List', $privilege_set)){ ?>
          <a href="<?php echo base_url().'walking-customer-list'; ?>" class="dropdown-item">
          Walking Customer List
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Due Collection', $privilege_set)){ ?>
          <a href="<?php echo base_url().'customer-invoice-payment'; ?>" class="dropdown-item">
            Due Collection
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Receive List', $privilege_set)){ ?>
          <a href="<?php echo base_url().'customer-payment-list'; ?>" class="dropdown-item">
           Customer Receive List
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Advance Payment Receive', $privilege_set)){ ?>
         <a href="<?php echo base_url().'customer-advance'; ?>" class="dropdown-item">
           Advance Payment Receive
          </a>
           <div class="dropdown-divider"></div>
           <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Advance Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'customer-ledger'; ?>" class="dropdown-item">
           Customer Advance Ledger
          </a>
           <div class="dropdown-divider"></div>
           <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Due Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'customer-due-report'; ?>" class="dropdown-item">
           Customer Due Report
          </a>
          <?php } ?> 
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Supplier
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Supplier', $privilege_set)){ ?>
          <a href="<?php echo base_url().'new-supplier'; ?>" class="dropdown-item">
          New Supplier
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
           <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Supplier', $privilege_set)){ ?>
          <a href="<?php echo base_url().'supplier-list'; ?>" class="dropdown-item">
          Manage Supplier
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Due Payment', $privilege_set)){ ?>
          <a href="<?php echo base_url().'supplier-invoice-payment'; ?>" class="dropdown-item">
            Due Payment
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array(' Supplier Payment List', $privilege_set)){ ?>
          <a href="<?php echo base_url().'supplier-payment-list'; ?>" class="dropdown-item">
           Supplier Payment List
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Advance Payment Pay', $privilege_set)){ ?>
         <a href="<?php echo base_url().'supplier-advance'; ?>" class="dropdown-item">
            Advance Payment Pay
          </a>
           <div class="dropdown-divider"></div>
           <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Advance Ledger', $privilege_set)){ ?>
         <a href="<?php echo base_url().'supplier-ledger'; ?>" class="dropdown-item">
           Supplier Advance Ledger
          </a>
           <div class="dropdown-divider"></div>
           <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Due Report', $privilege_set)){ ?>
         <a href="<?php echo base_url().'supplier-due-report'; ?>" class="dropdown-item">
           Supplier Due Report
          </a>
          <?php } ?>
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Expense
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Head', $privilege_set)){ ?>
          <a href="<?php echo base_url().'expense-head-list'; ?>" class="dropdown-item">
          Expense Head
          </a>
          <div class="dropdown-divider"></div>
        <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Add Expense', $privilege_set)){ ?>
          <a href="<?php echo base_url().'add-expense'; ?>" class="dropdown-item">
            Add Expense
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Statement', $privilege_set)){ ?>
          <a href="<?php echo base_url().'expense-ledger'; ?>" class="dropdown-item">
           Expense Statement
          </a>
          <?php } ?>
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Cash
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Transaction', $privilege_set)){ ?>
          <a href="<?php echo base_url().'cash-transaction'; ?>" class="dropdown-item">
          Cash Transaction
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Ledger', $privilege_set)){ ?>
          <a href="<?php echo base_url().'cash-ledger'; ?>" class="dropdown-item">
            Cash Ledger
          </a>
          <?php } ?> 
        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank', $privilege_set)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Bank
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Bank', $privilege_set)){ ?>
          <a href="<?php echo base_url().'bank-list'; ?>" class="dropdown-item">
          Manage Bank
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Transaction', $privilege_set)){ ?>
          <a href="<?php echo base_url().'bank-transaction'; ?>" class="dropdown-item">
            Bank Transaction
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Ledger', $privilege_set)){ ?>
          <a href="<?php echo base_url().'bank-ledger'; ?>" class="dropdown-item">
           Bank Ledger
          </a>
          <?php } ?>

        </div>
      </li>
      <?php } ?> 

      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Accounts', $privilege_set)){ ?>
       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Accounts
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Current Financial Statement', $privilege_set)){ ?>
          <a href="<?php echo base_url().'financial-statement'; ?>" class="dropdown-item">
          Current Financial Statement 
          </a>
          <div class="dropdown-divider"></div>
      <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Flow Statement', $privilege_set)){ ?>
          <a href="<?php echo base_url().'cash-flow-statement'; ?>" class="dropdown-item">
           Cash Flow Statement
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?> 
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Receive & Payment Statement', $privilege_set)){ ?>
          <a href="<?php echo base_url().'receive-payment-report'; ?>" class="dropdown-item">
           Receive & Payment Statement
          </a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>  
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><img src="<?php echo base_url(); ?>/assets/dist/img/avatar.jpg" class="img-circle elevation-2" alt="User Image"><br>
          <span><?php echo $this->session->userdata('user_name'); ?></span><br>
         
        </span> <a href="<?php echo base_url(); ?>log-out" class="btn btn-default btn-flat">Sign out</a>
          <div class="dropdown-divider"></div>
          <!-- <a href="#" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Profile Setting
          </a> -->
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link">
      <span class="brand-text font-weight-light">Bonik Book</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/dist/img/avatar.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('user_name'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
            <a href="<?php echo base_url(); ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Sales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Sales', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-sales'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Sales</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Invoice', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'manage-sales'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Invoice</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Return', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'sales-return'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Return</p>
                </a>
              </li>
              <?php } ?>
          
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Return List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'sales-return-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Return list</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'daily-sales-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Report</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'sales-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Ledger</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>

           <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Requisition', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Sales Requisition
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Requisition', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-sales-requisition'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Requisition</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Pending Requisition', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'pending-sales-requisition'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Pending Requisition</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Approved Requisition', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'approved-sales-requisition'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Approved Requisition</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Purchase
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Purchase', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-purchase'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Purchase</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Invoice', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'manage-purchase'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Invoice</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Return', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'purchase-return'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Return</p>
                </a>
              </li>
               <?php } ?>
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Return List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'purchase-return-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Return List</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Report</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'purchase-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Ledger</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
           <?php } ?>

           <?php  if($this->session->userdata('user_type') == "Client" or in_array('Quotation', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Quotation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Quotation', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-quotation'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Quotation</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Quotation List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'manage-quotation'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Quotation List</p>
                </a>
              </li>
               <?php } ?>
                           
            </ul>
          </li>
           <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Report', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <!-- 
              <li class="nav-item">
                <a href="<?php //echo base_url().'daily-purchase-sales-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Daily Purchase-Sales</p>
                </a>
              </li> -->
               
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Report</p>
                </a>
              </li>
               <?php } ?>
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Purchase Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'purchase-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Purchase Ledger</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'daily-sales-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Report</p>
                </a>
              </li>
               <?php } ?>
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'sales-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Sales Ledger</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'stock-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Stock Report</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Low Stock Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'low-stock-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Low Stock Report</p>
                </a>
              </li>
               <?php } ?>
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock History Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'stock-history-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Stock History Report</p>
                </a>
              </li>
               <?php } ?>
               <!-- <?php  if($this->session->userdata('user_type') == "Client" or in_array('Product Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'product-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Product Ledger</p>
                </a>
              </li>
               <?php } ?> -->
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Profit & Loss Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'profit-loss-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Profit & Loss Report</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Advance Ledger', $privilege_set)){ ?>
              <li class="nav-item">
              <a href="<?php echo base_url().'supplier-ledger'; ?>" class="nav-link">
                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                <p>Supplier Advance Ledger</p>
              </a>
            </li>
            <?php } ?>
            
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Due Report', $privilege_set)){ ?>
              <li class="nav-item">
              <a href="<?php echo base_url().'supplier-due-report'; ?>" class="nav-link">
                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                <p>Supplier Due Report</p>
              </a>
            </li>
             <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Advance Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Customer Advance Ledger</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Due Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-due-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Customer Due Report</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'bank-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Bank Ledger</p>
                </a>
              </li>
               <?php } ?>
                <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'cash-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Cash Ledger</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Statement', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'expense-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Expense Statement</p>
                </a>
              </li>
               <?php } ?>
            </ul>
          </li>
           <?php } ?>

          
          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Product', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Product', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-product'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Product</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Product', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'product-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Manage Product</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Barcode Print', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'barcode-generate'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Barcode Print</p>
                </a>
              </li>
              <?php } ?>
              <!-- <?php  //if($this->session->userdata('user_type') == "Client" or in_array('Inventory Adjustment', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php //echo base_url().'inventory-adjustment'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Inventory Adjustment</p>
                </a>
              </li>
              <?php //} ?> -->
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'stock-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Stock Report</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Low Stock Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'low-stock-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Low Stock Report</p>
                </a>
              </li>
               <?php } ?>
               <?php  if($this->session->userdata('user_type') == "Client" or in_array('Stock History Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'stock-history-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Stock History Report</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Category', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'product-category'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Units', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'unit-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Units</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manufacturer/Brand', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'manufacturer-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Manufacturer/Brand</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Customer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Customer', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-customer'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Customer</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Customer', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Manage Customer</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Walking Customer List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'walking-customer-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Walking Customer List</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Due Collection', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-invoice-payment'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Due Collection</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Receive List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-payment-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Customer Receive List</p>
                </a>
              </li>
             <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Advance Payment Receive', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Advance Payment Receive</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Advance Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Customer Advance Ledger</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Customer Due Report', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'customer-due-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Customer Due Report</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Supplier
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('New Supplier', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'new-supplier'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>New Supplier</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Supplier', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'supplier-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Manage Supplier</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Due Payment', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'supplier-invoice-payment'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Due Payment</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Payment List', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'supplier-payment-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Supplier Payment List</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Advance Payment Pay', $privilege_set)){ ?>
              <li class="nav-item">
              <a href="<?php echo base_url().'supplier-advance'; ?>" class="nav-link">
                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                <p>Advance Payment Pay</p>
              </a>
            </li>
            <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Advance Ledger', $privilege_set)){ ?>
              <li class="nav-item">
              <a href="<?php echo base_url().'supplier-ledger'; ?>" class="nav-link">
                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                <p>Supplier Advance Ledger</p>
              </a>
            </li>
            <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Supplier Due Report', $privilege_set)){ ?>
              <li class="nav-item">
              <a href="<?php echo base_url().'supplier-due-report'; ?>" class="nav-link">
                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                <p>Supplier Due Report</p>
              </a>
            </li>
            <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Cash
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Transaction', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'cash-transaction'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Cash Transaction</p>
                </a>
              </li>
               <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'cash-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Cash Ledger</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Bank
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Manage Bank', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'bank-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Manage Bank</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Transaction', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'bank-transaction'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Bank Transaction</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Bank Ledger', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'bank-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Bank Ledger</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-file-export"></i>
              <p>
                Expense
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Head', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'expense-head-list'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Expense Head</p>
                </a>
              </li>
            <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Add Expense', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'add-expense'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Add Expense</p>
                </a>
              </li>
              <?php } ?>
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Expense Statement', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'expense-ledger'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Expense Statement</p>
                </a>
              </li>
              <?php } ?>
              
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Accounts', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Accounts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Current Financial Statement', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'financial-statement'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Current Financial Statement</p>
                </a>
              </li>
              <?php } ?>

              <?php  if($this->session->userdata('user_type') == "Client" or in_array('Cash Flow Statement', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'cash-flow-statement'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Cash Flow Statement</p>
                </a>
              </li>
            <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Receive & Payment Statement', $privilege_set)){ ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'receive-payment-report'; ?>" class="nav-link">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Receive & Payment Statement</p>
                </a>
              </li>
            <?php } ?> 
            </ul>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Users', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="<?php echo base_url().'user-list'; ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <?php } ?>

          <?php  if($this->session->userdata('user_type') == "Client" or in_array('Profile', $privilege_set)){ ?>
              <li class="nav-item">
            <a href="<?php echo base_url().'profile-setup'; ?>" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <?php } ?>

              <li class="nav-item">
            <a href="<?php echo base_url().'client-password/'.$this->session->userdata('user_id'); ?>" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Re-Set Password
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url(); ?>log-out" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Sign out
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php if($main){echo $main_content;}?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
    <strong>Developed by <a href="https://www.aaconsulting.tech" target="_blank">A & A</a></strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url(); ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs-plugin-labels.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- page script -->
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false, 
      "ordering": false,
      "paging": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $(".dtable").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false, 
      "ordering": false,
      "paging": false
    });

    bsCustomFileInput.init();

    $('.datepicker').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      yearRange: "-100:+50",
      maxDate: new Date,
      //maxDate: 0,
      changeYear: true
      });

  });

  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

//text area limit

   $('.limited').keyup(function () {
  var max = 250;
  var len = $(this).val().length;
  if (len >= max) {
    $('#charNum').text(' you have reached the limit');
  } else {
    var char = max - len;
    $('#charNum').text(char + ' characters left');
  }
});


</script>
<script type="text/javascript">
  $(function () {
    var url = window.location;
    // for single sidebar menu
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    }).addClass('active');

    //for sidebar menu and treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open').prev('a')
        .addClass('active');
});
</script>

<!-- print div -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
  document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<!-- barcode -->
<script type="text/javascript">
        function genBarcode(){
            var barcode_qty = $('#barcode_qty').val();
            var col_qty = $('#col_qty').val();
            var product_no = $('#product_id').val();
            $.ajax({
                    type : 'POST',
                    data : {barcode_qty : barcode_qty,
                            col_qty : col_qty,
                            product_no : product_no
                            },
                    url : '<?php echo site_url('barcode-print'); ?>',
                    success : function(result){
                        $('#printableArea').html(result);
                    }

                });
            event.preventDefault();
        };
</script>

<!-- payment type -->
<script>
$(document).ready(function(){
$('#paytype').change(function() {
    $('.payment-info').hide();
    $('#' + $(this).val()).show();
}).change();

});
</script>

<!-- purchase product -->
<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   $( "#purchase_product_name" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('purchase-product');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      
      change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = ''; 
          event.currentTarget.focus();
        }
      },

      select: function (event, ui) {
        // Set selection
        $('#product_code').val(ui.item.code); // display the selected code
        $('#purchase_product_name').val(ui.item.label); // display the selected text
        $('#product_id').val(ui.item.value); // save selected id to input
        $('#unit_price').val(ui.item.price); // save selected id to input
        $('#unit').val(ui.item.unit); // save selected id to input
        return false;
      }

    });

  });
</script>

<!-- purchase row -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#purchase-row").click(function(){
            var product_name = $("#purchase_product_name").val();
            var product_code = $("#product_code").val();
            var unit_price = $("#unit_price").val();
            var unit = $("#unit").val();
            var purchase_qty = $("#purchase_qty").val();
            var purchase_discount = $("#purchase_discount").val();
            var purchase_discount_per = $("#discount_percent").val();
            var total_amount = $("#total_amount").val();
            var product_id = $("#product_id").val();
            if (product_name == "") {
              alert("Product must be Valid");
              return false;
            }

            if (purchase_qty == "") {
              alert("Please add QTY");
              return false;
            }

            var markup = "<tr><td><input type='checkbox' name='purchase_record'></td><td><input class='form-control' name='product_code[]' value='" + product_code + "' readonly></td><td><input class='form-control' name='product_name[]' value='" + product_name + "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" + product_id + "' readonly></td><td><input type='number' class='form-control purchase_cal' name='purchase_qty[]' value='" + purchase_qty + "' min='1' required></td><td><input type='number' class='form-control purchase_cal' name='unit_price[]' value='" + unit_price + "'step='0.01' required></td><td><input type='text' class='form-control' name='unit[]' value='" + unit + "' readonly></td><td><input type='number' class='form-control purchase_cal numtoper' name='purchase_discount[]' value='" + purchase_discount + "' step='0.01'></td><td><input type='number' class='form-control pertonum' name='discount_per[]' value='" + purchase_discount_per + "' step='0.01'></td><td colspan='2'><input type='text' class='form-control' name='total_amount[]' value='" + total_amount + "' readonly></td></tr>";
            $("#purchase_table").append(markup);
            //document.getElementById("purchase_form").reset();
            $('#purchase_product_name, #product_code, #unit_price, #unit, #purchase_qty, #total_amount, #product_id').val('');
            $('#purchase_discount, #discount_percent').val('0');
            purchasecalculation();
        });
        
        // Find and remove selected table rows
        $(".delete-purchase-row").click(function(){
            $("#purchase_table").find('input[name="purchase_record"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    purchasecalculation();
                }
            });
        });
    });    
</script>

<!-- purchase calculation -->
<script type="text/javascript">
  function purchasecalculation() {
  var sum = 0;
    var discounttotal = 0;
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("unit_price[]");
    var qty = document.getElementsByName("purchase_qty[]");
    var sdiscount = document.getElementsByName("purchase_discount[]");
    var indiscount = $('#invoice_discount').val();
    var paid_amount = $('#paid_amount').val();
    var advance_amount = $('#pbalance_payment').val();

    var qty_temp = $('#purchase_qty').val();
    var unit_price_temp = $('#unit_price').val();
    var discount_temp = $('#purchase_discount').val();
    var temp_total = (unit_price_temp * qty_temp)- discount_temp;
    document.getElementById("total_amount").value = temp_total.toFixed(2);
    

for ( var i = 0; i < product.length; i++ ){
        sales_value = (mrp[i].value * qty[i].value)-sdiscount[i].value;
        sum += mrp[i].value * qty[i].value;
        document.getElementsByName("total_amount[]")[i].value = sales_value.toFixed(2);
        discounttotal += parseFloat(sdiscount[i].value);
    }
   

   var total_discount = parseFloat(discounttotal)+parseFloat(indiscount);
   var grand_total = sum-total_discount;
   var net_total = grand_total;
   var sales_due = net_total-parseFloat(paid_amount)-parseFloat(advance_amount);
   var sales_change = parseFloat(paid_amount)-net_total;
   document.getElementById("gross_total").value = sum.toFixed(2);
   document.getElementById("total_discount").value = total_discount.toFixed(2);
   document.getElementById("grand_total").value = grand_total.toFixed(2);
   //document.getElementById("net_total").value = net_total.toFixed(2);
   document.getElementById("sales_due").value = sales_due.toFixed(2);
   document.getElementById("sales_change").value = sales_change.toFixed(2);
   document.getElementById("invoice_discount").value = indiscount;
}

$(document).ready(function(){

$('#purchase_table').on('keyup', '.purchase_cal', function(){
    purchasecalculation();

});
 });
</script>

<!-- purchase discount calculation -->
<script type="text/javascript">
  function number_to_persentage() {
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("unit_price[]");
    var discountper = document.getElementsByName("purchase_discount[]");
    var qty = document.getElementsByName("purchase_qty[]");
    var qty_temp = $('#purchase_qty').val();
    var unit_price_temp = $('#unit_price').val();
    var purchase_discount = $('#purchase_discount').val();
    var temp_total = unit_price_temp * qty_temp;
    var dicount = (purchase_discount / temp_total) * 100;
    document.getElementById("discount_percent").value = dicount.toFixed(2);

for ( var i = 0; i < product.length; i++ ){
       var total = mrp[i].value * qty[i].value;
       var amount = (discountper[i].value / total) *100;
        document.getElementsByName("discount_per[]")[i].value = amount.toFixed(2);
    }
   
}

$(document).ready(function(){

$('#purchase_table').on('keyup', '.numtoper', function(){
    number_to_persentage();

});
 });
</script>

<script type="text/javascript">
  function persentage_to_number() {
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("unit_price[]");
    var discountper = document.getElementsByName("discount_per[]");
    var qty = document.getElementsByName("purchase_qty[]");
    var qty_temp = $('#purchase_qty').val();
    var unit_price_temp = $('#unit_price').val();
    var temp_total = unit_price_temp * qty_temp;
    var discount_percent = $('#discount_percent').val();

    var percent = (discount_percent / 100) * temp_total;
    document.getElementById("purchase_discount").value = percent.toFixed(2);

for ( var i = 0; i < product.length; i++ ){
       var total = mrp[i].value * qty[i].value;
       
       var per = (discountper[i].value / 100) * total;
       //var total_net = total-per;
        document.getElementsByName("purchase_discount[]")[i].value = per.toFixed(2);
    }
     purchasecalculation();
   
}

$(document).ready(function(){

$('#purchase_table').on('keyup', '.pertonum', function(){
    persentage_to_number();

});
 });
</script>


<!-- purchase return calculation -->
<script type="text/javascript">
  function purchasereturncalculation() {
    var sum = 0;
    
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("purchase_return_rate[]");
    var qty = document.getElementsByName("return_qty[]");
    //var invoice_discount = $('#invoice_discount').val();
    var paid_amount = $('#paid_amount').val();
    var discount_percent = $('#discount_per').val();
    var purchase_due = $('#due').val();

    for ( var i = 0; i < product.length; i++ ){
        purchase_value = mrp[i].value * qty[i].value;
        sum += purchase_value;
        document.getElementsByName("total_amount[]")[i].value = purchase_value.toFixed(2);
    }
  
   var invoice_discount = (discount_percent / 100) * sum;
   var return_total = sum-invoice_discount-purchase_due;
   if (return_total <= paid_amount) {
      var return_amount = return_total;
      document.getElementById('return_payment').readOnly = false;
      document.getElementById("return_payment").value = "";

   }else{
     var return_amount = paid_amount;
     document.getElementById('return_payment').readOnly = true;
     document.getElementById("return_payment").value = return_amount;

   }
   document.getElementById("gross_total").value = sum.toFixed(2);
   document.getElementById("invoice_discount").value = invoice_discount.toFixed(2);
   document.getElementById("return_amount").value = return_amount.toFixed(2);
   
   
}

$(document).ready(function(){

$('#purchase_return_table').on('keyup', '.purchase_cal', function(){
    purchasereturncalculation();

});
 });
</script>
<!-- sales customer -->
<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   $( "#customer_name, #customer_mobile" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('sales-customer');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
       /*change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = ''; 
          event.currentTarget.focus();
        }
      },*/

      select: function (event, ui) {
        // Set selection
        //$('#sales_product_code').val(ui.item.code); // display the selected code
        $('#customer_name').val(ui.item.label); // display the selected text
        $('#customer_id').val(ui.item.value); // save selected id to input        
        $('#customer_mobile').val(ui.item.mobile); // save selected id to input
        $('#customer_org').val(ui.item.org); // save selected id to input
        $('#pprevious_balance').val(ui.item.balance); // save selected id to input
         if (ui.item.balance>0) {
         document.getElementById('pbalance_payment').readOnly = false;
       }else{
        document.getElementById('pbalance_payment').readOnly = true;
          }
        return false;
      }
    });

  });
</script>

<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   $( " #customer_namef" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('ledger-customer');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
       change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = ''; 
          $('#customer_namef').val('');
          $('#balance').html(''); 
          event.currentTarget.focus();
        }
      },
      select: function (event, ui) {
         
        // Set selection
        $('#customer_namef').val(ui.item.label); // display the selected text
        $('#customer_idf').val(ui.item.value); // save selected id to input
         $('#balance').html(ui.item.balance);
        return false;
      }
    });

  });
</script>

<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   $( "#supplier_name" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('purchase-supplier');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
       change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = ''; 
          event.currentTarget.focus();
        }
      },
      select: function (event, ui) {
        // Set selection
        //$('#sales_product_code').val(ui.item.code); // display the selected code
        $('#supplier_name').val(ui.item.label); // display the selected text
        $('#supplier_id').val(ui.item.value); // save selected id to input
        $('#supplier_mobile').val(ui.item.mobile); // save selected id to input
        return false;
      }
    });

  });
</script>

<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   $( "#supplier_namef" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('ledger-supplier');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
       change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = '';

        $('#supplier_idf').val('');
        $('#balance').html(''); 
          event.currentTarget.focus();
        }
      },
      select: function (event, ui) {
        $('#supplier_namef').val(ui.item.label);
        $('#supplier_idf').val(ui.item.value);
        $('#balance').html(ui.item.balance);
        return false;
      }
    });

  });
</script>

<!-- sales product -->
<script type="text/javascript">
      $(document).ready(function(){

   // Initialize 
   //$( "#sales_product_name, #sales_product_code" ).autocomplete({
   $( "#sales_product_name" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('sales-product');?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
       change: function(event, ui) {
        if (ui.item == null) {
          event.currentTarget.value = ''; 
          event.currentTarget.focus();
        }
      },
      select: function (event, ui) {
        // Set selection
        $('#sales_product_code').val(ui.item.code); // display the selected code
        $('#sales_product_name').val(ui.item.label); // display the selected text
        $('#product_id').val(ui.item.value); // save selected id to input
        $('#mrp').val(ui.item.mrp); // save selected id to input
        $('#qmrp').val(ui.item.mrp); // save selected id to input
        $('#unit').val(ui.item.unit); // save selected id to input
        $('#stock_qty').val(ui.item.stock); // save selected id to input
        $('#sales_vat').val(ui.item.vat); // save selected id to input
        $('#tp').val(ui.item.tp); // save selected id to input
        return false;
      }
    });

  });
</script>

<!-- sales row -->
<script type="text/javascript">
    $(document).ready(function(){
        //$(".sales-row").click(function(){
        $('#sales_table').on('click', '.sales-row', function(){
            var product_name = $("#sales_product_name").val();
            var product_code = $("#sales_product_code").val();
            var stock_qty = $("#stock_qty").val();
            var mrp = $("#mrp").val();
            var unit = $("#unit").val();
            var sales_qty = $("#sales_qty").val();
            var sales_discount = $("#sales_discount").val();
            var sales_discount_percent = $("#sales_discount_percent").val();
            var sales_vat = $("#sales_vat").val();
            var total_amount = $("#total_amount").val();
            var product_id = $("#product_id").val();
            var tp = $("#tp").val();
            var product = document.getElementsByName("product_name[]");
            if (product_name == "") {
              alert("Product must be Valid");
              return false;
            }

            
            if (sales_qty < 1) {
              alert("Invalid Product QTY");
              return false;
            }
          
          <?php  if($this->session->userdata('user_type') !== "Client" ){ ?>
            if (+stock_qty < +sales_qty) {
              alert("Product QTY Not Available");
              return false;
            }

            if(stock_qty < 1 ){
              alert ("Product QTY Not Available");
              return false;
            }
            <?php } ?>


            var markup = "<tr><td><input type='checkbox' name='record'></td><td><input class='form-control' name='product_code[]' value='" + product_code + "' readonly></td><td><input class='form-control' name='product_name[]' value='" + product_name + "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" + product_id + "' readonly></td><td><input type='text' class='form-control' name='stock_qty[]' value='" + stock_qty + "' readonly></td><td><input type='number' class='form-control sales_cal stock_cal' name='sales_qty[]' value='" + sales_qty + "' min='1' required></td><td class='tp'><input type='text' class='form-control' name='tp[]' value='" + tp + "' readonly></td><td><input type='number' class='form-control sales_cal' name='mrp[]' value='" + mrp + "' step='0.01' required readonly></td><td><input type='text' class='form-control' name='unit[]' value='" + unit + "' readonly></td><td><input type='text' class='form-control' name='sales_vat[]' value='" + sales_vat + "' readonly></td><td><input type='number' class='form-control sales_cal' name='sales_discount[]' value='" + sales_discount + "' step='0.01' readonly></td><td><input type='number' class='form-control sales_cal' name='sales_discount_percent[]' value='" + sales_discount_percent + "' step='0.01'></td><td colspan='2'><input type='text' class='form-control' name='total_amount[]' value='" + total_amount + "' readonly></td></tr>";
            $("#sales_table").append(markup);

            //document.getElementById("sales_form").reset();
             $('#sales_product_name, #sales_product_code, #stock_qty, #mrp, #unit, #sales_qty, #total_amount, #product_id, #product_serial, #tp').val('');
             $('#sales_discount').val('0');
             $('#sales_discount_percent').val('0');
             $('#sales_vat').val('0');

             <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales MRP Editable', $privilege_set)){ ?>
              document.getElementById("mrp").readOnly = false; 
              
              for ( var i = 0; i < product.length; i++ ){
                  document.getElementsByName("mrp[]")[i].readOnly = false;
                  
              }
            <?php } ?>
            <?php  if($this->session->userdata('user_type') == "Client" or in_array('Show Purchase Price', $privilege_set)){ ?>

              $('.tp').show();
              <?php }else{ ?>
                $('.tp').hide();
                <?php } ?>
                 

            salescalculation();
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("#sales_table").find('input[name="record"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    salescalculation();
                }
            });
        });
    });    
</script>

<!-- sales calculation -->
<script type="text/javascript">
function salescalculation() {
    var sum = 0;
    var discounttotal = 0;
    var vattotal = 0;
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("mrp[]");
    var qty = document.getElementsByName("sales_qty[]");
    var sdiscount = document.getElementsByName("sales_discount[]");
    var sdiscountper = document.getElementsByName("sales_discount_percent[]");
    var vatper = document.getElementsByName("sales_vat[]");
    var indiscount = $('#invoice_discount').val();
    var paid_amount = $('#paid_amount').val();
    var advance_amount = $('#pbalance_payment').val();

    var sales_qty_temp = $('#sales_qty').val();
    var mrp_temp = $('#mrp').val();
    var sales_discount_temp = $('#sales_discount').val();
    var sales_discount_percent_temp = $('#sales_discount_percent').val();
    var sales_vatper_temp = $('#sales_vat').val();
    var net_mrp_temp = (mrp_temp * sales_qty_temp)-sales_discount_temp;
    var sales_vat_temp = (sales_vatper_temp / 100) * net_mrp_temp;
    var sales_temp_total = net_mrp_temp+sales_vat_temp;
    //var sales_discount_amount = (sales_discount_percent_temp / 100) * (mrp_temp * sales_qty_temp);
    //var discount = (sales_discount_temp / (mrp_temp * sales_qty_temp)) * 100;
    
    document.getElementById("total_amount").value = sales_temp_total.toFixed(2);
   // document.getElementById("sales_discount").value = sales_discount_amount.toFixed(2);
   // document.getElementById("sales_discount_percent").value = discount.toFixed(2);
  
    

for ( var i = 0; i < product.length; i++ ){
        sda = (sdiscountper[i].value / 100) * (mrp[i].value * qty[i].value);
		document.getElementsByName("sales_discount[]")[i].value = sda.toFixed(2);  
		var sdiscount = document.getElementsByName("sales_discount[]");
        //var sales_discount_amount_row = (sdiscountper[i].value / 100) * (mrp[i].value * qty[i].value);
        //var discount_row = (sdiscount / (mrp[i].value * qty[i].value)) * 100;
        var net_price = (mrp[i].value * qty[i].value)-sdiscount[i].value;
        var sales_vat = (vatper[i].value / 100) * (net_price);
        sales_value = net_price+sales_vat;
        sum += mrp[i].value * qty[i].value;
        document.getElementsByName("total_amount[]")[i].value = sales_value.toFixed(2);
        discounttotal += parseFloat(sdiscount[i].value);
        vattotal += sales_vat;
        // if(qty[i].value > stock[i].value){
        //   alert ("You can Sale maximum "+ stock[i].value +" Items");
        // }
    }
   

   var total_discount = parseFloat(discounttotal)+parseFloat(indiscount);
   var grand_total = sum+vattotal-total_discount;
   var net_total = grand_total;
   var sales_due = net_total-parseFloat(paid_amount)-parseFloat(advance_amount);
   var sales_change = parseFloat(paid_amount)-net_total;
   document.getElementById("gross_total").value = sum.toFixed(2);
   document.getElementById("total_vat").value = vattotal.toFixed(2);
   document.getElementById("total_discount").value = total_discount.toFixed(2);
   document.getElementById("grand_total").value = grand_total.toFixed(2);
   //document.getElementById("net_total").value = net_total.toFixed(2);
   document.getElementById("sales_due").value = sales_due.toFixed(2);
   document.getElementById("sales_change").value = sales_change.toFixed(2);

}

$(document).ready(function(){

$('#sales_table').on('keyup', '.sales_cal', function(){
    salescalculation();

});
 });

$(document).ready(function(){

$("#paid_amount").on("change", function(e){
  //var paid_amount = $('#paid_amount').val();
  var maxValue = $('#grand_total').val();
   document.getElementById("paid_amount").setAttribute("max", maxValue); // set a new value;
   document.getElementById("paid_amount").setAttribute("min", 0); // set a new value;
   if ($(this).val() == "") {
            $(this).val(0);
             salescalculation();
             purchasecalculation();
        } 

});


 });

$(document).ready(function(){

$("#sales_form").submit(function(e) {
      var paid_amount = $('#paid_amount').val();
      var grand_total = $('#grand_total').val();
      var customer_id = $('#customer_id').val();
      var customer_org = $('#customer_org').val();
      var product = document.getElementsByName("product_name[]");
      
        if (customer_id == "" && parseFloat(grand_total) > parseFloat(paid_amount)) {
          alert ('Paid amount need to be equal to Payable Amount')
          
           e.preventDefault(); 
        }else if (customer_id !== "" && customer_org == "" && parseFloat(grand_total) > parseFloat(paid_amount)){
          alert ('Paid amount need to be equal to Payable Amount')
          
           e.preventDefault(); 
        }

        if (product.length == 0) {
          alert ('Add at least one Product.')
          
           e.preventDefault(); 
        }
});
 });


</script>

<!-- sales discount calculation -->
<script type="text/javascript">
  function snumber_to_persentage() {
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("unit_price[]");
    var discountper = document.getElementsByName("sales_discount[]");
    var qty = document.getElementsByName("sales_qty[]");
    var qty_temp =  document.getElementById("sales_qty").value;
    var unit_price_temp = document.getElementById("mrp").value;
    var sales_discount = document.getElementById("sales_discount").value;
    var temp_total = unit_price_temp * qty_temp;
    var dicount = (sales_discount / temp_total) * 100;
    document.getElementById("sales_discount_percent").value = dicount.toFixed(2);

for ( var i = 0; i < product.length; i++ ){
       var total = mrp[i].value * qty[i].value;
       var amount = (discountper[i].value / total) *100;
        document.getElementsByName("sales_discount_percent[]")[i].value = amount.toFixed(2);
    }
}       

</script>

<script type="text/javascript">
  function spersentage_to_number() {
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("unit_price[]");
    var discountper = document.getElementsByName("sales_discount_percent[]");
    var qty = document.getElementsByName("sales_qty[]");
    var qty_temp =  document.getElementById("sales_qty").value;
    var unit_price_temp = document.getElementById("mrp").value;
    var temp_total = unit_price_temp * qty_temp;
    var discount_percent = document.getElementById("sales_discount_percent").value;

    var percent = (discount_percent / 100) * temp_total;
    document.getElementById("sales_discount").value = percent.toFixed(2);

for ( var i = 0; i < product.length; i++ ){
       var total = mrp[i].value * qty[i].value;
       
       var per = (discountper[i].value / 100) * total;
       //var total_net = total-per;
        document.getElementsByName("sales_discount[]")[i].value = per.toFixed(2);
    }
     
   
}
</script>

<!-- sales req row -->
<script type="text/javascript">
    $(document).ready(function(){
        $(".req-row").click(function(){
            var product_name = $("#sales_product_name").val();
            var product_code = $("#sales_product_code").val();
            var stock_qty = $("#stock_qty").val();
            var mrp = $("#mrp").val();
            var unit = $("#unit").val();
            var sales_qty = $("#sales_qty").val();
            var sales_vat = $("#sales_vat").val();
            var total_amount = $("#total_amount").val();
            var product_id = $("#product_id").val();
            if (product_name == "") {
              alert("Product must be Valid");
              return false;
            }

            if (sales_qty < 1) {
              alert("Invalid Product QTY");
              return false;
            }

            // if (+stock_qty < +sales_qty) {
            //   alert("Product QTY Not Available");
            //   return false;
            // }

            // if(stock_qty < 1 ){
            //   alert ("Product QTY Not Available");
            //   return false;
            // }
            var markup = "<tr><td><input type='checkbox' name='record'></td><td><input class='form-control' name='product_code[]' value='" + product_code + "' readonly></td><td><input class='form-control' name='product_name[]' value='" + product_name + "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" + product_id + "' readonly></td><td><input type='text' class='form-control' name='stock_qty[]' value='" + stock_qty + "' readonly></td><td><input type='number' class='form-control sales_cal stock_cal' name='sales_qty[]' value='" + sales_qty + "' min='1' required></td><td><input type='number' class='form-control sales_cal' name='mrp[]' value='" + mrp + "' step='0.01' required readonly></td><td><input type='text' class='form-control' name='unit[]' value='" + unit + "' readonly></td><td><input type='text' class='form-control' name='sales_vat[]' value='" + sales_vat + "' readonly></td><td colspan='2'><input type='text' class='form-control' name='total_amount[]' value='" + total_amount + "' readonly></td></tr>";
            $("#sales_req_table").append(markup);
            //document.getElementById("sales_form").reset();
             $('#sales_product_name, #sales_product_code, #stock_qty, #mrp, #unit, #sales_qty, #total_amount, #product_id').val('');
             $('#sales_vat').val('0');
            reqcalculation();
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("#sales_req_table").find('input[name="record"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    reqcalculation();
                }
            });
        });
    });    
</script>

<!-- sales req calculation -->
<script type="text/javascript">
function reqcalculation() {
    var sum = 0;
    var vattotal = 0;
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("mrp[]");
    var qty = document.getElementsByName("sales_qty[]");
    var vatper = document.getElementsByName("sales_vat[]");
    
    var sales_qty_temp = $('#sales_qty').val();
    var mrp_temp = $('#mrp').val();
    var sales_vatper_temp = $('#sales_vat').val();
    var sales_vat_temp = (sales_vatper_temp / 100) * (mrp_temp * sales_qty_temp);
    var sales_temp_total = (mrp_temp * sales_qty_temp)+sales_vat_temp;
    document.getElementById("total_amount").value = sales_temp_total.toFixed(2);
    

for ( var i = 0; i < product.length; i++ ){
        var sales_vat = (vatper[i].value / 100) * (mrp[i].value * qty[i].value);
        sales_value = (mrp[i].value * qty[i].value)+sales_vat;
        sum += mrp[i].value * qty[i].value;
        document.getElementsByName("total_amount[]")[i].value = sales_value.toFixed(2);
        vattotal += sales_vat;

    }
   

   
   var grand_total = sum+vattotal;
  
   document.getElementById("gross_total").value = sum.toFixed(2);
   document.getElementById("total_vat").value = vattotal.toFixed(2);
   document.getElementById("grand_total").value = grand_total.toFixed(2);
   
   
  

}

$(document).ready(function(){

$('#sales_req_table').on('keyup', '.sales_req_cal', function(){
    reqcalculation();

});
 });
</script>

<!-- sales return calculation -->
<script type="text/javascript">
  function salesreturncalculation() {
    var sum = 0;
    
    var product = document.getElementsByName("product_name[]");
    var mrp = document.getElementsByName("sales_return_rate[]");
    var qty = document.getElementsByName("return_qty[]");
    //var invoice_discount = $('#invoice_discount').val();
    var paid_amount = $('#paid_amount').val();
    var discount_percent = $('#discount_per').val();
    //var vat_percent = $('#vat_per').val();
    var sales_due = $('#due').val();
    

    for ( var i = 0; i < product.length; i++ ){
        sales_value = mrp[i].value * qty[i].value;
        sum += sales_value;
        document.getElementsByName("total_amount[]")[i].value = sales_value.toFixed(2);
    }
   var invoice_discount = (discount_percent / 100) * sum;
   var return_total = sum-invoice_discount-sales_due;
   if (return_total <= paid_amount) {
      var return_amount = return_total;
      document.getElementById('return_payment').readOnly = false;
      document.getElementById("return_payment").value = "";
   }else{
     var return_amount = paid_amount;
     document.getElementById('return_payment').readOnly = true;
     document.getElementById("return_payment").value = return_amount;

   }
   document.getElementById("gross_total").value = sum.toFixed(2);
   document.getElementById("invoice_discount").value = invoice_discount.toFixed(2);
   document.getElementById("return_amount").value = return_amount.toFixed(2);
   
   
}

$(document).ready(function(){

$('#sales_return_table').on('keyup', '.sales_cal', function(){
    salesreturncalculation();

});
 });
</script>

<!--purchase return search -->
<script type="text/javascript">
$(document).ready(function(){

 function load_purchase_return_list(query)
 {
  $.ajax({
   url:"<?php echo base_url(); ?>purchase-return-search",
   method:"POST",
   data:{query:query},
   success:function(data){
    $('#invoice_list').html(data);
   }
  })
 }

 $("#purchase_return_search").on("change paste keyup", function() {
  var search = $(this).val();

  if(search != '')
  {
   load_purchase_return_list(search);
  }
  else
  {
   load_purchase_return_list();
  }
 });
});
</script>

<!--sales return search -->
<script type="text/javascript">
$(document).ready(function(){

 function load_sales_return_list(query)
 {
  $.ajax({
   url:"<?php echo base_url(); ?>sales-return-search",
   method:"POST",
   data:{query:query},
   success:function(data){
    $('#invoice_list').html(data);
   }
  })
 }

 $("#sales_return_search").on("change paste keyup", function() {
  var search = $(this).val();

  if(search != '')
  {
   load_sales_return_list(search);
  }
  else
  {
   load_sales_return_list();
  }
 });
});
</script>

<!-- due bill calculation -->
<script type="text/javascript">
function duebillcalculation() {
    var payment_sum = 0;
    var balance_sum = 0;
    var advance_sum = 0;
    var bill_no = document.getElementsByName("bill_id[]");
    var due_amount = document.getElementsByName("due_amount[]");
    var payment_amount = document.getElementsByName("payment_amount[]");
    var advance_amount = document.getElementsByName("advance_amount[]");
    

for ( var i = 0; i < bill_no.length; i++ ){
        balance = due_amount[i].value - payment_amount[i].value-advance_amount[i].value;
        document.getElementsByName("balance_due[]")[i].value = balance.toFixed(2);
        payment_sum += parseFloat(payment_amount[i].value);
        balance_sum += parseFloat(balance);
        advance_sum += parseFloat(advance_amount[i].value);
    }
   
   document.getElementById("payment_total").value = payment_sum.toFixed(2);
   document.getElementById("balance_total").value = balance_sum.toFixed(2);
   document.getElementById("advance_total").value = advance_sum.toFixed(2);

}

$(document).ready(function(){

$('#due_bill').on('keyup', '.bill_cal', function(){
    duebillcalculation();

});
 });
</script>

<script>
   var monthlyData = JSON.parse(`<?php echo $chart; ?>`);
    var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: monthlyData.monthly_sales_amount,
          //data: [1953543, 2453543, 3453543, 4453543, 5453543, 6453543],
          backgroundColor: ['rgb(70, 191, 189)',
                            'rgb(252, 180, 92)',
                            'rgb(247, 70, 74)',
                            'rgb(148, 159, 177)',
                            'rgb(51, 143, 82)',
                            'rgb(107, 178, 225)'],
          label: 'Monthly Data'
        }],
        labels: monthlyData.month_label
        //labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      options: {
        responsive: true,
        legend: {
          position: 'right',
        },
        title: {
          display: true,
          //text: 'Total Sales of Last 6 Month'
          text: monthlyData.statement_title_two
        },
        animation: {
          animateScale: true,
          animateRotate: true
        },
        plugins: {
            labels: {
            render: 'percent',
            fontColor: '#fff',
          }
        }

      }
    };

    var ctx = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctx, config);
  </script>

  <script type="text/javascript">
  //Collection two day
    var revData = JSON.parse(`<?php echo $chart; ?>`);
    var config = {
      type: 'bar',
      data: {
        labels: revData.visit_label,
        //labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        datasets: [{
          label: 'Sales',
          backgroundColor: '#636e72',
          borderColor: '#636e72',
          data: revData.sales_total,
          //data: [644524, 854529, 705242, 642544, 854529, 745220, 644524],
          fill: false,
        }, {
          label: 'Purchase',
          fill: false,
          backgroundColor: '#74b9ff',
          borderColor: '#74b9ff',
          data: revData.purchase_total,
          //data: [842250, 594520, 842500, 542540, 545290, 800452, 654533],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          //text: 'Sales & Purchase of Last Week'
          text: revData.statement_title_one
        },
        tooltips: {
          mode: 'index',
          intersect: true,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Date'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Count'
            },
            ticks: {
              precision:0,
              stepSize: 100000,
              beginAtZero:true
            }
          }]
        },
        plugins: {
            labels: {
            render: 'value',
            fontColor: '#000',
          }
        }
      }
    };

    var ctx = document.getElementById('reftchart').getContext('2d');
    new Chart(ctx, config); 
</script>

<script type="text/javascript">
  //Collection two day
    var callData = JSON.parse(`<?php echo $chart; ?>`);
    var config = {
      type: 'line',
      data: {
        labels: callData.visit_label,
        //labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        datasets: [{
          label: 'Collection',
          backgroundColor: '#8789e6',
          borderColor: '#8789e6',
          data: callData.customer_collection,
          //data: [65556, 59655, 843450, 645545, 59455, 844560, 64345],
          fill: false,
        }, {
          label: 'Payment',
          fill: false,
          backgroundColor: '#f59042',
          borderColor: '#f59042',
          data: callData.supplier_payment,
          //data: [644545, 855659, 707578, 62234, 84469, 70233, 61344, 89453, 7450, 645634, 84889, 748630],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          //text: 'Collection & Payment of Last Week'
          text: callData.statement_title_three
        },
        tooltips: {
          mode: 'index',
          intersect: true,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Date'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Count'
            },
            ticks: {
              precision:0,
              stepSize: 100000,
              beginAtZero:true
            }
          }]
        }
      }
    };

    var ctx = document.getElementById('collectionchart').getContext('2d');
    new Chart(ctx, config); 
</script>


<script>

// function checkAll(me){
//   var divid = $(me).parent().attr('id');
//   $("#" + divid).find("input").prop("checked", true); 
  
   
// }

$(document).on('click','.checkAll:checkbox',function(){
    $(this).siblings(':checkbox').prop('checked',this.checked);
});

</script>

<script>
$(document).ready(function(){
$('#supplier_namep').change(function() {
  var supplier = $('#supplier_namep').val();
  $.ajax({
          type : 'POST',
          data : {supplier : supplier},
          url : '<?php echo site_url('supplier-balance'); ?>',
          success : function(result){
              $('#pprevious_balance').val(result);
              if (result>0) {
         document.getElementById('pbalance_payment').readOnly = false;
       }else{
        document.getElementById('pbalance_payment').readOnly = true;
          }
       }

      });

})
});
</script>

<!-- <script>
$(document).ready(function(){
$('#customer_name').change(function() {
  var customer = $('#customer_id').val();
  $.ajax({
          type : 'POST',
          data : {customer : customer},
          url : '<?php echo site_url('customer-balance'); ?>',
          success : function(result){
              $('#pprevious_balance').val(result);
          }

      });

})
});
</script> -->


<script type="text/javascript">
  $(document).ready(function(){

  <?php  if($this->session->userdata('user_type') == "Client" or in_array('Sales MRP Editable', $privilege_set)){ ?>
  document.getElementById("mrp").readOnly = false;
  var product = document.getElementsByName("product_name[]"); 
    for ( var i = 0; i < product.length; i++ ){
                  document.getElementsByName("mrp[]")[i].readOnly = false;
                  
              }
      <?php } ?>
      <?php  if($this->session->userdata('user_type') == "Client" or in_array('Show Purchase Price', $privilege_set)){ ?>
  $('.tp').show();
  <?php }else{ ?>
    $('.tp').hide();
    <?php } ?>
     });
</script>

<!-- quotation row -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#quotation_table').on('click', '#quotation-row', function(){
            var product_name = $("#sales_product_name").val();
            var product_code = $("#sales_product_code").val();
            var stock_qty = $("#stock_qty").val();
            var unit = $("#unit").val();
            var quotation_qty = $("#quotation_qty").val();
            var product_id = $("#product_id").val();
            var qmrp = $("#qmrp").val();
            var total_amount = $("#total_amount").val();
            var product = document.getElementsByName("product_name[]");
            if (product_name == "") {
              alert("Product must be Valid");
              return false;
            }

              if (quotation_qty < 1) {
              alert("Invalid Product QTY");
              return false;
            }

            var markup = "<tr><td><input type='checkbox' name='record'></td><td><input class='form-control' name='product_code[]' value='" + product_code + "' readonly></td><td><input class='form-control' name='product_name[]' value='" + product_name + "' readonly><input type='hidden' class='form-control' name='product_id[]' value='" + product_id + "' readonly></td><td><input type='text' class='form-control' name='stock_qty[]' value='" + stock_qty + "' readonly></td><td><input type='number' class='form-control quot_cal' name='quotation_qty[]' value='" + quotation_qty + "' min='1' required></td><td><input type='number' class='form-control quot_cal' name='qmrp[]' value='" + qmrp + "' step='0.01'></td><td><input type='text' class='form-control' name='unit[]' value='" + unit + "' readonly><td colspan='2'><input type='text' class='form-control' name='total_amount[]' value='" + total_amount + "' readonly></td></td>";
            
            $("#quotation_table").append(markup);

            //document.getElementById("sales_form").reset();
             $('#sales_product_name, #sales_product_code, #stock_qty, #unit, #quotation_qty, #product_id, #qmrp, #total_amount').val('');
             quotationculation();
        });
        
        // Find and remove selected table rows
        $(".delete-quotation-row").click(function(){
            $("#quotation_table").find('input[name="record"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>

<!-- quot calculation -->
<script type="text/javascript">
function quotationculation() {
     var sum = 0;
    var product = document.getElementsByName("product_name[]");
     var mrp = document.getElementsByName("qmrp[]");
    var qty = document.getElementsByName("quotation_qty[]");

    var quotation_qty_temp = $('#quotation_qty').val();
    var mrp_temp = $('#qmrp').val();
    
    var sales_temp_total = mrp_temp * quotation_qty_temp;
    
    document.getElementById("total_amount").value = sales_temp_total.toFixed(2);
  
    

for ( var i = 0; i < product.length; i++){
      var  sales_value = mrp[i].value * qty[i].value;
        sum += mrp[i].value * qty[i].value;
        document.getElementsByName("total_amount[]")[i].value = sales_value.toFixed(2);
    }
   
   document.getElementById("gross_total").value = sum.toFixed(2);
   
}

$(document).ready(function(){

$('#quotation_table').on('keyup', '.quot_cal', function(){
    quotationculation();

});
 });



$(document).ready(function(){
$("#quotation_form").submit(function(e) {
      var supplier_name = $("#supplier_name").val();
       var customer_name = $("#customer_namef").val();

      if( supplier_name == "" && customer_name == "" ){ 
        alert ('Select Supplier or Customer')
           e.preventDefault(); 
    } 
     
});
 });

 </script>
 <script type="text/javascript">
   $(document).ready(function(){
$("#purchase_form").submit(function(e) {
      var paytype = $("#paytype").val();
       var paid_amount = $("#paid_amount").val();
       var pbalance_payment = $("#pbalance_payment").val();
       var closing_cash = $("#closing_cash").val();
       var closing_bank = $("#closing_bank").val();
       var payable = paid_amount-pbalance_payment;
       var product = document.getElementsByName("product_name[]");

      if(paytype == "Cash"){ 
        if (payable > closing_cash) {
        alert ('Not Enough Cash Balance');
           e.preventDefault(); 
    }
     }else if (paytype == "Bank") {
      if (payable > closing_bank) {
        alert ('Not Enough Bank Balance');
           e.preventDefault(); 
    }
     }

     if (product.length == 0) {
          alert ('Add at least one Product.')
          
           e.preventDefault(); 
        }
     
});
 });

 </script>
 
<script type="text/javascript">
   $(document).ready(function(){
$("#exp_form").submit(function(e) {
      var paytype = $("#payment_method").val();
       var paid_amount = $("#amount").val();
       var closing_cash = $("#cash_balance").val();
       var closing_bank = $("#bank_balance").val();
       // alert (paid_amount);
       // e.preventDefault(); 

      if(paytype == "Cash"){ 
        if (paid_amount > parseInt(closing_cash,10)) {
        alert ('Not Enough Cash Balance');
           e.preventDefault(); 
    }
     }else if (paytype == "Bank") {
      if (paid_amount > parseInt(closing_bank,10)) {
        alert ('Not Enough Bank Balance');
           e.preventDefault(); 
    }
     }
     
});
 });
 </script>

<script type="text/javascript">
   $(document).ready(function(){
$("#spadvance_form").submit(function(e) {
  
      var paytype = $("#payment_method").val();
      var paid_amount = $("#amount").val();
      var closing_cash = $("#cash_balance").val();
      var closing_bank = $("#bank_balance").val();
      var type = $("#ac_type").val();
    //alert (paytype);
  //e.preventDefault(); 
  if (type == "Debit(+)") {
    if(paytype == "Cash"){ 
        if (paid_amount > parseInt(closing_cash,10)) {
        alert ('Not Enough Cash Balance');
           e.preventDefault(); 
    }
     }else if (paytype == "Bank") {
      if (paid_amount > parseInt(closing_bank,10)) {
        alert ('Not Enough Bank Balance');
           e.preventDefault(); 
    }
     }
  }
      
     
});
 });
 </script>


 </script><script type="text/javascript">
   $(document).ready(function(){
$("#supplier_due_payment").submit(function(e) {
       var cash_balance = $("#cash_balance").val();
       var bank_balance = $("#bank_balance").val();
       var bill_id = document.getElementsByName("bill_id[]");
       var payment_amount = document.getElementsByName("payment_amount[]");
       var payment_method = document.getElementsByName("payment_method[]");
       var cash_sum = 0;
       var bank_sum = 0;

       for ( var i = 0; i < bill_id.length; i++){
      if(payment_method[i].value == "Cash"){
        cash_sum += payment_amount[i].value;
        bank_sum += 0;
      }else if (payment_method[i].value == "Bank"){
        cash_sum += 0;
        bank_sum += payment_amount[i].value;
      }
       
    }
     // alert  (cash_sum);
     //        e.preventDefault(); 

     if (cash_sum > cash_balance) {
          alert ('Not Enough Cash Balance');
           e.preventDefault(); 
        }

        if (bank_sum > bank_balance) {
          alert ('Not Enough Bank Balance');
           e.preventDefault(); 
        }
      
     
});
 });
 </script>

<!--  <script type="text/javascript">
  $('#sales_form, #purchase_form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
</script> -->


<script type="text/javascript">
  var txt = "";
function selectsalesBarcode() {
    if (txt != $("#sales_product_code").val()) {
        txt = $("#sales_product_code").val();
    }
    //$("#sales_product_code").select();
    //$('#customer_mobile').val(txt);
    
                 $.ajax({
                type : 'POST',
                data : {txt : txt},
                url : '<?php echo site_url('sales-product-code-data'); ?>',
                success : function(result){
                    var markup = '<tr>'+result+'</tr>';
                    $("#sales_table").append(markup);
                    $("#sales_product_code").val('');
                    salescalculation();
                     $("#sales_product_code").focus();
             }
            });
}

function selectpurchaseBarcode() {
    if (txt != $("#product_code").val()) {
        txt = $("#product_code").val();
    }
                 $.ajax({
                type : 'POST',
                data : {txt : txt},
                url : '<?php echo site_url('purchase-product-code-data'); ?>',
                success : function(result){
                    var markup = '<tr>'+result+'</tr>';
                    $("#purchase_table").append(markup);
                    $("#product_code").val('');
                    salescalculation();
                     $("#product_code").focus();
             }
            });
}

$(document).ready(function () {
  $("#sales_product_code").focus();
  $("#product_code").focus();
   });
</script>
<script type="text/javascript">
  document.body.addEventListener("keypress", function(e) {
    if (e.key === 'Enter') {
    selectsalesBarcode();
    selectpurchaseBarcode();
    e.preventDefault();
  }
})
</script>




</body>
</html>
