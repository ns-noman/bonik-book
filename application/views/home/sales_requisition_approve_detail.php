<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>

      <style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    }
</style>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Approved Sales Requisition#: <?php echo $sales_info->sales_req_no; ?></h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
        <?php $privilege = $this->inventory_model->get_user_privilege($this->session->userdata('user_id'));
        $privilege_set = array_column($privilege, 'menu_name');
        if($this->session->userdata('user_type') == "Client" or in_array('New Requisition', $privilege_set)){
         ?>
          <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "new-sales-requisition"; ?>">New Requisition</a>
      <?php } 
      if($this->session->userdata('user_type') == "Client" or in_array('Sales Requisition Bill', $privilege_set)){
      ?>
          <a class="btn btn-success btn-xs" href="<?php echo base_url() . "sales-requisition-bill/".$sales_info->sales_req_id; ?>">Create Bill </a>
      <?php } ?>
       
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <div class="row">
                        <div class="col-md-12">
                           
                            <center>
                            <table width="70%" cellpadding="10">
                                <tr>
                                    <td align="right"> 
                                        <?php if ($client_info->header_image) { ?>
                                            <img src="<?php echo base_url().$client_info->header_image; ?>" height="100">
                                        <?php }else{ ?>
                                            <h3><?php echo $client_info->client_name; ?></h3>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <h3><?php echo $client_info->client_name; ?></h3>
                                        <p style="font-size:16px;"><?php echo $client_info->client_address; ?> <br>Contact: <?php echo $client_info->client_mobile; ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <h4>Approved Sales Requisition</h4>
                                    </td>
                                </tr>
                            </table>
                            </center>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Name : <?php echo $sales_info->customer_name; ?> <br>
                                        Contact : <?php echo $sales_info->customer_mobile; ?></label>
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Organization : <?php echo $sales_info->customer_organization; ?><br>
                                        Issue Date: <?php echo date("d/m/Y", strtotime($sales_info->req_issue_date)); ?>
                            </div>

                           

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Requisition# : <?php echo $sales_info->sales_req_no; ?><br>
                                    Approve Date: <?php echo date("d/m/Y", strtotime($sales_info->req_approval_date)); ?>
                                </label>
                            </div>

                        </div>
                <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th width="500">Detail</th>
                            <th>Stock</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Vat%</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if ($sales_item){ 
                    $x = 1;
                    foreach($sales_item as $item){
                        $vat = ($item->req_app_item_vat_per / 100 )* $item->req_app_item_amount;
                        ?>
                        <tr>
                            <td><?php echo $x++; ?>.</td>
                            <td><?php echo $item->product_name; ?></td>
                            <td align="center"><?php echo $item->product_stock." ".$item->unit_name;?></td>
                            <td align="center"><?php echo $item->req_app_item_quantity." ".$item->unit_name;?></td>
                            <td align="right"><?php echo number_format((float)$item->req_app_item_amount/$item->req_app_item_quantity, 2, '.', '');?></td>
                            <td align="right"><?php echo $item->req_app_item_vat_per; ?></td>
                            <td align="right"><?php echo number_format((float)$item->req_app_item_amount+$vat, 2, '.', '');?></td>
                        </tr>
                    <?php }}else{ echo "No data  found!";} ?>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" rowspan="3">
                                <center><label style="text-align:center;" for="details" class="col-form-label">Details</label></center>
                               <?php echo $sales_info->sales_req_detail;?>
                            </td>
                            <td colspan="2" align="right">Total Amount :</td>
                            <td align="right">
                                 <?php echo number_format((float)$sales_info->req_total_amount, 2, '.', ''); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" align="right">Total Vat :</td>
                            <td align="right">
                                 <?php echo number_format((float)$sales_info->req_total_vat, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">Net Payable :</td>
                            <td align="right">
                                 <?php echo number_format((float)$total, 2, '.', ''); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="7">
                                <b>In Word: <?php echo $in_word; ?> Only.</b>
                            </td>
                        </tr>
                       
                    </tfoot>
                </table>
            </div>
                 <p> <span class="pull-left">Entry By <?php echo $sales_info->user_name; ?></span> | 
                    <span class="pull-right">Entry Date-Time <?php echo date('d-m-Y h:i A',  strtotime($sales_info->sales_req_created_at)); ?></span>
                </p>
                <p> <span class="pull-left">Print By <?php echo $this->session->userdata('user_name'); ?></span>
                    <span class="pull-right">Print Date <?php echo date('d-m-Y'); ?></span>
                </p>
        </div>
      </div>
    </section>
    <!-- /.content -->

