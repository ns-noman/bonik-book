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
            <h1>Purchase Invoice Detail Invoice#: <?php echo $purchase_info->purchase_invoice_no; ?></h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
      <div class="card">
        <div class="card-header">
          <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "new-purchase"; ?>">New Purchase</a>
         <!-- <a href="<?php //echo base_url() . "purchase-edit/" . $purchase_info->purchase_invoice_id; ?>" class="btn btn-danger btn-xs">Edit</a> -->
          <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-purchase-detail/". $purchase_info->purchase_invoice_id; ?>">
            <i class="fa fa-print"></i> POS
        </a>
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-purchase-challan/". $purchase_info->purchase_invoice_id; ?>">
            <i class="fa fa-print"></i> Challan
        </a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          
          <div class="row">
                        <div class="col-md-12">
                            <!-- <center>
                                <?php if ($client_info->header_image) { ?>
                                    <img src="<?php echo base_url().$client_info->header_image; ?>" height="50">
                                <?php }else{ ?>
                                    <h3><?php echo $client_info->client_name; ?></h3>
                                <?php } ?>
                                <p><?php echo $client_info->client_address; ?>, Contact: <?php echo $client_info->client_mobile; ?></p>
                                <div><h4>Purchase Invoice</h4></div>
                            </center> -->
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
                                        <h4>Purchase Invoice</h4>
                                    </td>
                                </tr>
                            </table>
                            </center>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Invoice# : <?php echo $purchase_info->purchase_invoice_no; ?></label><br>
                                    <label class="form-label">Challan# : <?php echo $purchase_info->purchase_challan_no; ?></label>
                                
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Supplier : <?php echo $purchase_info->supplier_name; ?> <br>
                                        Contact : <?php echo $purchase_info->supplier_mobile; ?><br>
                                        Address : <?php echo $purchase_info->supplier_address; ?></label>
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Purchase Date: <?php echo date("d/m/Y", strtotime($purchase_info->purchase_invoice_date)); ?></label><br>
                                    <label class="form-label">Payment Type: <?php echo $purchase_info->purchase_payment_type; ?></label>
                            </div>

                        </div>
                <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th width="500">Detail</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <!-- <th>Return Qty</th> -->
                            <th>Discount Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if ($purchase_item){ 
                    $x = 1;
                    foreach($purchase_item as $item){
                        ?>
                        <tr>
                            <td><?php echo $x++; ?>.</td>
                            <td><?php echo $item->product_name; ?></td>
                            <td align="center"><?php echo $item->purchase_item_quantity." ".$item->unit_name;?></td>
                            <td align="right"><?php echo number_format((float)$item->purchase_item_amount/$item->purchase_item_quantity, 2, '.', '');?></td>
                            <!-- <td align="right"><?php echo $item->purchase_return_item_quantity;?></td> -->
                            <td align="right"><?php echo number_format((float)$item->purchase_item_discount, 2, '.', '');?></td>
                            <td align="right"><?php echo number_format((float)$item->purchase_item_amount-$item->purchase_item_discount, 2, '.', '');?></td>
                        </tr>
                    <?php }}else{ echo "No data  found!";} ?>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" rowspan="6">
                                <center><label style="text-align:center;" for="details" class="col-form-label">Purchase Details</label></center>
                               <?php echo $purchase_info->purchase_invoice_detail;
                               if ($purchase_info->purchase_payment_info) {
                                         echo "<br>Payment Type: ".$purchase_info->purchase_payment_type."<br>Payment Info: ".$purchase_info->purchase_payment_info;
                                     }

                                ?>
                            </td>
                            <td colspan="3" align="right">Total Amount :</td>
                            <td align="right">
                                 <?php echo number_format((float)$purchase_info->purchase_total_amount, 2, '.', ''); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="3" align="right">Total Discount :</td>
                            <td align="right">
                                 <?php echo number_format((float)$purchase_info->purchase_total_discount, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right" style="border-bottom: 1px solid #000;">Special Discount :</td>
                            <td align="right" style="border-bottom: 1px solid #000;">
                                 <?php echo number_format((float)$purchase_info->purchase_invoice_discount, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Net Payable :</td>
                            <td align="right">
                                 <?php echo number_format((float)$total, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Paid Amount :</td>
                            <td align="right">
                                 <?php  echo  number_format((float)$paid_amount, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <?php if ($purchase_info->purchase_amount_paid > $total){ ?>
                        <tr>
                            <td colspan="3" align="right" style="border-bottom: 1px solid #000;">Advance Amount :</td>
                            <td align="right" style="border-bottom: 1px solid #000;">
                                 <?php echo  number_format((float)$purchase_info->purchase_amount_paid-$total, 2, '.', ''); ?>
                            </td>
                        </tr>
                      <?php }else{ ?>
                        <tr>
                            <td colspan="3" align="right" style="border-bottom: 1px solid #000;">Due Amount :</td>
                            <td align="right" style="border-bottom: 1px solid #000;">
                                <?php echo  number_format((float)$due, 2, '.', ''); ?>
                            </td>
                        </tr>
                    <?php } ?>
                        
                        <tr>
                            <td colspan="6">
                                <b>In Word: <?php echo $in_word; ?> Only.</b>
                            </td>
                        </tr>
                       
                    </tfoot>
                </table>
            </div>
                 <p> <span class="pull-left">Entry By <?php echo $purchase_info->user_name; ?></span> | 
                    <span class="pull-right">Entry Date-Time <?php echo date('d-m-Y h:i A',  strtotime($purchase_info->purchase_invoice_created_at)); ?></span>
                </p>
                <p> <span class="pull-left">Print By <?php echo $this->session->userdata('user_name'); ?></span>
                    <span class="pull-right">Print Date <?php echo date('d-m-Y'); ?></span>
                </p>
        </div>
      </div>
    </section>
    <!-- /.content -->

