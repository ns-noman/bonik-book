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
            <h1>Sales Report</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "datewise-sales"; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="form-group row">
              <div class="col-sm-2">
                <label for="from_date" class="col-form-label">From</label>
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date" autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <div class="col-sm-2">
                <label for="to_date" class="col-form-label">To</label>
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <div class="col-sm-2">
                <label for="customer_name" class="col-form-label">Customer</label>
                 <input type="text" name="customer_name" class=" form-control" placeholder="Customer Name" id="customer_name"  autocomplete="off">
                  <input type="hidden" name="customer_id" class=" form-control" id="customer_id" autocomplete="off">
              </div>
              <div class="col-sm-3">
                <label for="supplier_name" class="col-form-label">or Product</label>
                 <input type="text" class="form-control" name="product_name" id="sales_product_name" autocomplete="off">
                <input type="hidden" class="form-control" name="product_id" id="product_id" autocomplete="off">
              </div>
              <div class="col-sm-2">
                <label class="col-form-label">&nbsp;</label><br>
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
                          <center><h4><?php echo $title ?></h4></center>
                            <table class="table table-bordered table-striped table-hover">
                                
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th width="50">Invoice#</th>
                                        <th width="200">Customer</th>
                                        <th width="200">Organization</th>
                                        <th>Sales Amount</th>
                                        <!-- <th>Discount Amount</th> -->
                                       <th>Return Amount</th>
                                        <th>Collection Amount</th>
                                        
                                        <th>Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php 
                                        $x = 1;
                                        $sale_total = 0;
                                        $discount_total = 0;
                                        $paid_total = 0;
                                        $return_total = 0;
                                        $due_total = 0;
                                        foreach($sales_info as $sinfo){
                                            $discount = $sinfo->sales_invoice_discount+$sinfo->sales_total_discount;
                                            $total = $sinfo->sales_total_amount-$discount+$sinfo->sales_total_vat;
                                           
                                              
                                            $paid_amount = $sinfo->sales_amount_paid+$sinfo->sales_advance_payment-$sinfo->sales_invoice_return_amount;
                                            $due = $total-$paid_amount-$sinfo->sales_invoice_return_total;

                                            $sale_total += $total;
                                            $discount_total += $discount;
                                            $paid_total += $paid_amount;
                                            $return_total += $sinfo->sales_invoice_return_total;
                                            $due_total += $due;
                                            //if ($total > 0) {
                                     ?>
                                        <tr>
                                            <td><?php echo $x++;?></td>
                                            <td>
                                                <?php echo date("d/m/Y", strtotime($sinfo->sales_invoice_date)); ?>
                                            </td>
                                            <td><a target="_blank" href="<?php echo base_url() . "sales-detail/". $sinfo->sales_invoice_id; ?>"><?php echo $sinfo->sales_invoice_no;?></a></td>
                                            <td><?php echo $sinfo->customer_name;?></td>
                                            <td><?php echo $sinfo->customer_organization;?></td>
                                            <td align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                                          <td align="right"><?php echo number_format((float)$sinfo->sales_invoice_return_total, 2, '.', '');?></td> 
                                           <!--  <td align="right"><?php //echo number_format((float)$discount, 2, '.', '');?></td> -->
                                            <td align="right"><?php echo number_format((float)$paid_amount, 2, '.', '');?></td>
                                            
                                            <td align="right"><?php echo number_format((float)$due, 2, '.', '');?></td>
                                        </tr>

                                     <?php //} 
                                 } ?>
                                     <tr>
                                        <td colspan="5" align="right"><b>Total:</b></td>
                                        <td align="right"><b><?php echo number_format((float)$sale_total, 2, '.', '');?></b></td>
                                       <!--  <td align="right"><b>৳ <?php //echo number_format((float)$discount_total, 2, '.', '');?></b></td> -->
                                       <td align="right"><b><?php echo number_format((float)$return_total, 2, '.', '');?></b></td>
                                        <td align="right"><b><?php echo number_format((float)$paid_total, 2, '.', '');?></b></td>
                                       
                                        <td align="right"><b><?php echo number_format((float)$due_total, 2, '.', '');?></b></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        <?php }else{ echo "No Sales Information Found!";} ?>

                        <br>
                        Print By <?php echo $this->session->userdata('user_name'); ?> | 
                        Print Date <?php echo date("d/m/Y"); ?> 
                        </div>
                    
                    </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

