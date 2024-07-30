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
            <h1>Purchase & Sales Report</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "datewise-purchase-sales"; ?>" method="post" enctype="multipart/form-data"  role="form" >
            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From<span class="text-red">*</span></label>
              <div class="col-sm-3">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To<span class="text-red">*</span></label>
              <div class="col-sm-3">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <div class="col-sm-2">
                 <button type="submit" class="btn btn-info">Search</button>
              </div>
            </div>
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
                            </center>
                        </div>
                      
                        
                        <div class="table-responsive">
                        <!-- Sales -->
                        <?php if ($sales_info){ ?>
                          <center><h4>Sales Report : <?php echo "Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)); ?></h4></center>
                            <table class="table table-bordered table-striped table-hover">
                                
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th width="50">Invoice#</th>
                                        <th width="200">Customer</th>
                                        <th>Sales Amount</th>
                                        <!-- <th>Discount Amount</th> -->
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php 
                                        $x = 1;
                                        $sale_total = 0;
                                        $discount_total = 0;
                                        $paid_total = 0;
                                        $due_total = 0;
                                        foreach($sales_info as $sinfo){
                                             $discount = $sinfo->sales_invoice_discount+$sinfo->sales_total_discount;
                                            $total = $sinfo->sales_total_amount-$discount-$sinfo->sales_invoice_return_total+$sinfo->sales_total_vat;
                                            if ($sinfo->sales_amount_paid > $total) {
                                                $sales_amount_paid = $total;
                                            }else{
                                                $sales_amount_paid = $sinfo->sales_amount_paid;
                                            }
                                            $paid_amount = $sales_amount_paid;
                                            $balance = $total-$paid_amount;
                                            // if ($balance >= 0) {
                                            //   $due = $balance;
                                            // }else {$due = 0;}
                                            $due = $balance;
                                            

                                            $sale_total += $total;
                                            $discount_total += $discount;
                                            $paid_total += $paid_amount;
                                            $return_total += $sinfo->sales_invoice_return_amount;
                                            $due_total += $due;
                                            if ($total > 0) {
                                     ?>
                                        <tr>
                                            <td><?php echo $x++;?></td>
                                            <td>
                                                <?php echo date("d/m/Y", strtotime($sinfo->sales_invoice_date)); ?>
                                            </td>
                                            <td><?php echo $sinfo->sales_invoice_no;?></td>
                                            <td><?php echo $sinfo->customer_name;?></td>
                                            <td align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                                           <!--  <td align="right"><?php //echo number_format((float)$discount, 2, '.', '');?></td> -->
                                            <td align="right"><?php echo number_format((float)$paid_amount, 2, '.', '');?></td>
                                            <td align="right"><?php echo number_format((float)$due, 2, '.', '');?> <?php if($due > 0){echo "(Due)";}else if($due < 0){echo "(Advance)";} ?></td>
                                        </tr>

                                     <?php } } ?>
                                     <tr>
                                        <td colspan="4" align="right"><b>Total:</b></td>
                                        <td align="right"><b>৳ <?php echo number_format((float)$sale_total, 2, '.', '');?></b></td>
                                       <!--  <td align="right"><b>৳ <?php //echo number_format((float)$discount_total, 2, '.', '');?></b></td> -->
                                        <td align="right"><b>৳ <?php echo number_format((float)$paid_total, 2, '.', '');?></b></td>
                                        <td align="right"><b>৳ <?php echo number_format((float)$due_total, 2, '.', '');?> <?php if($due_total > 0){echo "(Due)";}else if($due_total < 0){echo "(Advance)";} ?></b></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        <?php }else{ echo "No Sales Today!";} ?>

                        <!-- Purchase -->
                        <?php if ($purchase_info){ ?>
                          <center><h4>Purchase Report : <?php echo "Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)); ?></h4></center>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th width="50">Invoice#</th>
                                        <th width="200">Supplier</th>
                                        <th>purchase Amount</th>
                                        <!-- <th>Discount Amount</th> -->
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php 
                                        $x = 1;
                                        $sale_total = 0;
                                        $discount_total = 0;
                                        $paid_total = 0;
                                        $due_total = 0;
                                        foreach($purchase_info as $sinfo){
                                            $discount = $sinfo->purchase_invoice_discount+$sinfo->purchase_total_discount;
                                            $total = $sinfo->purchase_total_amount-$discount-$sinfo->purchase_invoice_return_total;
                                            $balance = $total-$sinfo->purchase_amount_paid+$sinfo->purchase_invoice_return_amount;
                                            // if ($balance >= 0) {
                                            //   $due = $balance;
                                            // }else {$due = 0;}
                                            $due = $balance;
                                            $paid_amount = $total-$due;

                                            $sale_total += $total;
                                            $discount_total += $discount;
                                            $paid_total += $paid_amount;
                                            $due_total += $due; 
                                            if ($total !== 0) {
                                     ?>
                                        <tr>
                                            <td><?php echo $x++;?></td>
                                            <td>
                                                <?php echo date("d/m/Y", strtotime($sinfo->purchase_invoice_date)); ?>
                                            </td>
                                            <td><?php echo $sinfo->purchase_invoice_no;?></td>
                                            <td><?php echo $sinfo->supplier_name;?></td>
                                            <td align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                                            <!-- <td align="right"><?php //echo number_format((float)$discount, 2, '.', '');?></td> -->
                                            <td align="right"><?php echo number_format((float)$paid_amount, 2, '.', '');?></td>
                                            <td align="right"><?php echo number_format((float)$due, 2, '.', '');?> <?php if($due > 0){echo "(Due)";}else if($due < 0){echo "(Advance)";} ?></td>
                                        </tr>

                                     <?php }} ?>
                                     <tr>
                                        <td colspan="4" align="right"><b>Total:</b></td>
                                        <td align="right"><b>৳ <?php echo number_format((float)$sale_total, 2, '.', '');?></b></td>
                                        <!-- <td align="right"><b>৳ <?php //echo number_format((float)$discount_total, 2, '.', '');?></b></td> -->
                                        <td align="right"><b>৳ <?php echo number_format((float)$paid_total, 2, '.', '');?></b></td>
                                        <td align="right"><b>৳ <?php echo number_format((float)$due_total, 2, '.', '');?> <?php if($due_total > 0){echo "(Due)";}else if($due_total < 0){echo "(Advance)";} ?></b></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        <?php }else{ echo "No Purchase Today!";} ?><br>
                        Print By <?php echo $this->session->userdata('user_name'); ?> | 
                        Print Date <?php echo date("d/m/Y"); ?> 


                        </div>
                    
                    </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

