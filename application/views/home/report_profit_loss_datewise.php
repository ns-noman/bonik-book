<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Total Profit & Loss Report</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "datewise-profit-loss-report"; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="form-group row">
              <div class="col-sm-2">
                <label for="from_date" class="col-form-label">From<span class="text-red">*</span></label>
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              
              <div class="col-sm-2">
                <label for="to_date" class="col-form-label">To<span class="text-red">*</span></label>
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>

              
              <div class="col-sm-4">
                <label for="product_name_temp" class="col-form-label">Product</label>
                  <input type="text" class="form-control" name="product_name_temp" id="sales_product_name" autocomplete="off" placeholder="Product">
                  <input type="hidden" class="form-control" name="product_id" id="product_id" autocomplete="off">
              </div>

              
              <div class="col-sm-4">
                <label for="to_date" class="col-form-label">or Customer</label>
                  <input type="text" name="customer_name" class=" form-control" placeholder="Customer Name" id="customer_name"  autocomplete="off">
                  <input type="hidden" name="customer_id" class=" form-control" id="customer_id" autocomplete="off">
              </div>

            </div>

            <div class="form-group"><center><button type="submit" class="btn btn-info">Search</button></center></div>
         
          </form>
          <a class="btn btn-warning btn-sm pull-right" href="#" onclick="printDiv('printableArea')" >Print</a>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <div id="printableArea" style="margin-left:2px;">
                        <div class="text-center">
                            
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
                            </center> <br>
                                Total Profit & Loss Report : <?php echo "Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)); if($product_info){echo " for ".$product_info->product_name;}else if($customer_info){echo " for ".$customer_info->customer_name;}?>
                            </h5>
                        </div>
                      
                        
                    <div class="">
                        <!-- Sales -->
                        <?php if ($sales_info){ ?>
                            <table class="table table-bordered table-striped table-hover">
                                
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th style="min-width: 300px;">Product</th>
                                        <th>QTY</th>
                                        <th>Sales Rate</th>
                                        <th>Purchase Rate</th>
                                        <th>Sales Total</th>
                                        <th>Discount</th>
                                        <th>Net Sales Price</th>
                                        <th>Total Purchase Price</th>
                                        <th>Profit / Loss</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php 
                                        $x = 1;
                                        $qty_total = 0;
                                        //$tp_rate = 0;
                                        //$mrp_total = 0;
                                        $grand_total = 0;
                                        $discount_total = 0;
                                        $net_total = 0;
                                        $tp_total = 0;
                                        $balance_total = 0;
                                        foreach($sales_info as $sinfo){
                                        $net_amount = $sinfo->sales_item_amount-$sinfo->sales_item_discount;
                                        $tp_amount = $sinfo->sales_item_tp*$sinfo->sales_item_quantity;
                                        $balance = $net_amount-$tp_amount;

                                        $qty_total += $sinfo->sales_item_quantity;
                                        //$tp_rate += $sinfo->sales_item_tp;
                                        //$mrp_total += $sinfo->sales_item_rate;
                                        $grand_total += $sinfo->sales_item_amount;
                                        $discount_total += $sinfo->sales_item_discount;
                                        $net_total += $net_amount;
                                        $tp_total += $tp_amount;
                                        $balance_total += $balance;

                                     ?>
                                        <tr>
                                            <td><?php echo $x++;?></td>
                                            <td>
                                                <?php echo date("d/m/Y", strtotime($sinfo->sales_item_date)); ?>
                                            </td>
                                            <td><?php echo $sinfo->product_name;?></td>
                                            <td align="center"><?php echo $sinfo->sales_item_quantity;?></td>
                                            <td align="right"><?php echo number_format((float)$sinfo->sales_item_rate, 2, '.', '');?></td>
                                            <td align="right"><?php echo number_format((float)$sinfo->sales_item_tp, 2, '.', '');?></td>
                                            <td align="right"><?php echo number_format((float)$sinfo->sales_item_amount, 2, '.', '');?></td>
                                            <td align="right"><?php echo number_format((float)$sinfo->sales_item_discount, 2, '.', ''); ?></td>
                                            <td align="right"><?php echo number_format((float)$net_amount, 2, '.', ''); ?></td>
                                            <td align="right"><?php echo number_format((float)$tp_amount, 2, '.', ''); ?></td>
                                            <td align="right"><?php echo number_format((float)$balance, 2, '.', ''); ?></td>
                                        </tr>

                                     <?php } ?>
                                     
                                     <?php if($product_info){ ?>
                                        <tr>
                                         <td colspan="3" align="right"><b>Total Quantity:</b></td>
                                         <td align="center"><b><?php echo $qty_total;?></b></td>
                                         <td colspan="7"></td>
                                     </tr>
                                     <?php }else{ ?>
                                        <tr>
                                         <td colspan="6" align="right"><b>Sales Invoice Discount:</b></td>
                                         <td colspan="2" align="right"><b><?php echo number_format((float)$invoice_discount, 2, '.', '');?></b></td>
                                         <td colspan="3"></td>
                                     </tr>

                                    <?php } ?>
                                     <tr>
                                        <td colspan="6" align="right"><b>Total:</b></td>
                                        <td align="right"><b><?php echo number_format((float)$grand_total, 2, '.', '');?></b></td>
                                        <td align="right"><b><?php echo number_format((float)$discount_total+$invoice_discount, 2, '.', '');?></b></td>
                                        <td align="right"><b><?php echo number_format((float)$net_total-$invoice_discount, 2, '.', '');?></b></td>
                                        <td align="right"><b><?php echo number_format((float)$tp_total, 2, '.', '');?></b></td>
                                        <td align="right"><b><?php 
                                        $balance_status = $balance_total-$invoice_discount;
                                        if($balance_status > 0){echo "(Profit)";}else if($balance_status < 0){echo "(Loss)";} ?>  <?php echo abs(number_format((float)$balance_status, 2, '.', ''));?></b></td>
                                    </tr>
                                     <?php if(!$product_info && !$customer_info){ ?>
                                    <tr>
                                        <td colspan="10" align="right"><b>Purchase Discount Profit (+):</b></td>
                                        <td align="right"><b><?php echo number_format((float)$purchase_discount, 2, '.', '');?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="right"><b>Gross Profit/Loss:</b></td>
                                        <td align="right"><b><?php 
                                        $balance = $balance_status+$purchase_discount;
                                        if($balance > 0){echo "(Profit)";}else if($balance < 0){echo "(Loss)";} ?> <?php echo abs(number_format((float)$balance, 2, '.', ''));?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="right"><b>Total Expense (-):</b></td>
                                        <td align="right"><b>
                                        <?php echo abs(number_format((float)$expense_ledger->expense_transaction_amount, 2, '.', ''));?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="right"><b>Net Profit/Loss:</b></td>
                                        <td align="right"><b><?php 
                                        $net_balance = $balance-$expense_ledger->expense_transaction_amount;
                                        if($net_balance > 0){echo "(Profit)";}else if($net_balance < 0){echo "(Loss)";} ?> <?php echo abs(number_format((float)$net_balance, 2, '.', ''));?></b></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                
                            </table>
                        <?php }else{ echo "No Sales Today!";} ?>

                        <br>
                        Print By <?php echo $this->session->userdata('user_name'); ?> | 
                        Print Date <?php echo date("d/m/Y"); ?> 


                        </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

