<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>
      <style type="text/css">
          .table-bordered td, .table-bordered th {
                border: 1px solid #000;
            }

            .table thead th {
                border: 1px solid #000;
            }
      </style>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier Ledger</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "supplierwise-ledger"; ?>" method="post" enctype="multipart/form-data"  role="form" id="purchase_form">

            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="supplier_name" class="col-sm-1 col-form-label">Supplier</label>
              <div class="col-sm-3">
                 <input type="text" name="supplier_name" class=" form-control" placeholder="Supplier Name" id="supplier_name"  autocomplete="off" >
                  <input type="hidden" name="supplier_id" class=" form-control" id="supplier_id" autocomplete="off">
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
                <?php if($purchase_info){ ?>
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
                    <center><h4><?php echo $title; ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                           <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Invoice#</th>
                  <th>Amount</th>
                  <th>Discount</th>
                  <th>Payable</th>
                  <th>Paid</th>
                  <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  $amount_total = 0;
                  $discount_total = 0;
                  $payable_total = 0;
                  $paid_total = 0;
                  $balance_total = 0;
                  foreach($purchase_info as $info){
                    $discount = $info->purchase_invoice_discount+$info->purchase_total_discount;
                    $total = $info->purchase_total_amount-$discount;
                    $balance = $total-$info->purchase_amount_paid;
                    if ($balance >= 0) {
                      $due = $balance;
                    }else {$due = 0;}
                    $paid_amount = $total-$due;

                    $amount_total += $info->purchase_total_amount;
                    $discount_total += $discount;
                    $payable_total += $total;
                    $paid_total += $paid_amount;
                    $balance_total += $balance;
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->purchase_invoice_date));?>
                    </td>
                    <td>
                      <a target="_blank" href="<?php echo base_url() . "purchase-detail/". $info->purchase_invoice_id; ?>"><?php echo $info->purchase_invoice_no;?></a>
                    </td>

                     <td align="right">
                      <?php echo number_format((float)$info->purchase_total_amount, 2, '.', '');?>
                    </td>
                    <td align="right">
                      <?php echo number_format((float)$discount, 2, '.', '');?>
                    </td>
                    <td align="right">
                      <?php echo number_format((float)$total, 2, '.', '');?>
                    </td>
                    <td align="right">
                      <?php echo number_format((float)$paid_amount, 2, '.', '');?>
                    </td>
                    <td align="right">
                      <?php if ($info->purchase_amount_paid > $total){ 
                        echo  number_format((float)$info->purchase_amount_paid-$total, 2, '.', '')."(Advance)"; 
                        
                      }else if($due > 0){echo number_format((float)$due, 2, '.', '')."(Due)";}else{echo 0;
                        
                      } ?>
                      
                    </td>
                    
                  </tr>
                  
                  <?php } ?>
                  <tr style="font-weight:bold; background-color: #dfdfdf;">
                    <td colspan="3" align="right"><b>Total</b></td>
                    <td align="right">
                      <b><?php echo number_format((float)$amount_total, 2, '.', '');?></b>
                    </td>
                    <td align="right">
                      <b><?php echo number_format((float)$discount_total, 2, '.', '');?></b>
                    </td>
                    <td align="right">
                      <b><?php echo number_format((float)$payable_total, 2, '.', '');?></b>
                    </td>
                    <td align="right">
                      <b><?php echo number_format((float)$paid_total, 2, '.', '');?></b>
                    </td>
                    <td align="right">
                      <b>
                      <?php  if ($paid_total > $payable_total){ 
                        echo  number_format((float)$paid_total-$payable_total, 2, '.', '')."(Advance)"; 
                        
                      }else {echo number_format((float)$balance_total, 2, '.', '')."(Due)";}?>
                    </b>
                    </td>
                  </tr>
                  </tbody>
                        </table>
                            
                        <br>
                    Print By <?php echo $this->session->userdata('user_name'); ?> | 
                    Print Date <?php echo date("d/m/Y"); ?> 
                </div>
            <?php }else{echo "No Data Found.";} ?>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

