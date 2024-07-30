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
            <h1>User Collection & Payment</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "user-collection-payment"; ?>" method="post" enctype="multipart/form-data"  role="form">
             <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="user" class="col-sm-1 col-form-label">User</label>
              <div class="col-sm-3">
                 <select name="user" class=" form-control select2" id="user" style="width: 100%;">
                        <option value="">Select User</option>
                        <?php if ($user_info){
                            foreach ($user_info as $info) {
                        ?>
                        <option value="<?php echo $info->user_id; ?>">
                            <?php echo $info->user_name; ?> | 
                            <?php echo $info->user_mobile; ?>
                        </option>
                    <?php }} ?>
                    </select>
                  <input type="hidden" name="user_id" class=" form-control" id="user_id" autocomplete="off">
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
                    <center><h4><?php echo $title; ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="20">SL.</th>
                                    <th style="min-width:200px">Name</th>
                                    <th>Mobile No.</th>
                                    <th>Cash Collection</th>
                                    <th>Cash Payment</th>
                                    <th>Balance</th>
                                </tr>
                                <?php if ($user_id) {
                                    $user = $this->inventory_model->get_user_by_id($user_id);
                                    $collection = $this->inventory_model->get_user_collection($user->user_id, $from_date, $to_date, 'Debit(+)');
                                    $payment = $this->inventory_model->get_user_collection($user->user_id, $from_date, $to_date, 'Credit(-)');
                                    $collection_total = $collection->cash_transaction_amount;
                                    $payment_total = $payment->cash_transaction_amount;
                                 ?>
                                 <tr>
                                    <td><?php echo 1;?></td>  
                                    <td><?php echo $user->user_name;?></td>
                                    <td><?php echo $user->user_mobile;?></td>
                                    <td align="right"><?php echo number_format($collection->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format($payment->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format($collection->cash_transaction_amount-$payment->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>     
                                </tr>
                                <?php }else{ 
                                $collection_total = 0;
                                $payment_total = 0;
                                $x = 1;
                                foreach ($user_info as $user) {
                                    $collection = $this->inventory_model->get_user_collection($user->user_id, $from_date, $to_date, 'Debit(+)');
                                    $payment = $this->inventory_model->get_user_collection($user->user_id, $from_date, $to_date, 'Credit(-)');
                                    $collection_total += $collection->cash_transaction_amount;
                                    $payment_total += $payment->cash_transaction_amount; 
                                ?>
                                <tr>
                                    <td><?php echo $x++;?></td>  
                                    <td><?php echo $user->user_name;?></td>
                                    <td><?php echo $user->user_mobile;?></td>
                                    <td align="right"><?php echo number_format($collection->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format($payment->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format($collection->cash_transaction_amount-$payment->cash_transaction_amount, 2, '.', ',');
                                        ;?>
                                    </td>     
                                </tr>
                            <?php } }  ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="3">Grand Total:</td>  
                                    <td align="right"><?php echo number_format($collection_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($payment_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($collection_total-$payment_total, 2, '.', ',');?></td>  
                                </tr>
                            </thead>
                            <tbody>
                                 
                            </tbody>
                        </table>
                            
                        <br>
                    Print By <?php echo $this->session->userdata('user_name'); ?> | 
                    Print Date <?php echo date("d/m/Y"); ?> 
                </div>
            
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

