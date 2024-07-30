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
            <h1>Supplier Payment Detail</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
            <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          
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
                            </table>
                           
                                <div><h4>Payment Receipt</h4></div>
                            </center>
                            <hr>
                        </div>
                    </div>
                    <div class="row">

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Supplier : <?php echo $payment_info->supplier_name; ?></label>
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Contact : <?php echo $payment_info->supplier_mobile; ?></label>
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Payment Date: <?php echo date("d/m/Y", strtotime($payment_info->supplier_payment_date)); ?></label></label>
                            </div>

                        </div>
                <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th width="200">Invoice#</th>
                            <th>Challan#</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if ($payment_item){ 
                    $x = 1;
                    $due_total = 0;
                    foreach($payment_item as $item){
                         $discount = $item->purchase_invoice_discount+$item->purchase_total_discount;
                        $net_payable = $item->purchase_total_amount-$discount-$item->purchase_invoice_return_total;
                        $net_paid = $item->purchase_amount_paid+$item->purchase_advance_payment-$item->purchase_invoice_return_amount;
                        $due = $net_payable-$net_paid;
                        $due_total += $due;
                        if ($item->purchase_payment_amount != 0) {
                        ?>
                        <tr>
                            <td><?php echo $x++; ?>.</td>
                            <td><?php echo $item->purchase_invoice_no; ?></td>
                            <td><?php echo $item->purchase_challan_no; ?></td>
                            <td align="right"><?php echo number_format($item->purchase_payment_amount, 2, '.', ',');?></td>
                        </tr>
                    <?php }}}else{ echo "No data  found!";} ?>
                    
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold; background-color: #dfdfdf;">
                            <td colspan="3" align="right">Total Amount :</td>
                            <td align="right">
                                 <?php echo number_format($payment_info->supplier_payment_amount, 2, '.', ','); ?>
                            </td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="3" align="right">Total Current Due :</td>
                            <td align="right">
                                 <?php 
                                 $due = $this->inventory_model->get_supplier_due($payment_info->supplier_id);
                                    $purchase_total = $due->purchase_total_amount-($due->purchase_invoice_discount+$due->purchase_total_discount)
                                                -$due->purchase_invoice_return_total;
                                      $paid_total = $due->purchase_amount_paid+$due->purchase_advance_payment-$due->purchase_invoice_return_amount;
                                      $due_tot = $purchase_total- $paid_total; 
                                      echo number_format($due_tot, 2, '.', ',');
                                 //echo number_format($due_total, 2, '.', ','); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
                                <b>In Word: <?php echo $in_word; ?> Only.</b>
                            </td>
                        </tr>
                       
                    </tfoot>
                </table>
            </div>
                <p> <span class="pull-left">Print By <?php echo $this->session->userdata('user_name'); ?></span>
                    <span class="pull-right">Print Date <?php echo date('d-m-Y'); ?></span>
                </p>
        </div>
      </div>
    </section>
    <!-- /.content -->

