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
            <h1>Receive & Payment Statement</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
       
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "datewise-receive-payment"; ?>" method="post" enctype="multipart/form-data"  role="form">

            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
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
                    <center><h4><?php echo $heading; ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="100">Date</th>
                                    <th width="400">Particulars</th>
                                    <th>Debit (+)</th>
                                    <th>Credit (-)</th>
                                    <th>Balance</th>
                                </tr>

                                <?php 
                                $debit_total = 0;
                                $credit_total = 0;
                                $balance = 0;
                                if ($total_opening_balance > 0) {
                                    $debit_amount = $total_opening_balance;
                                    $credit_amount = 0;
                                    $balance += $debit_amount;
                                    $debit_total += $debit_amount;
                                    $credit_total += $credit_amount;
                                 ?>
                                <tr>
                                    <td><?php echo date("d-m-Y", strtotime($from_date));?></td>  
                                    <td colspan="3">Opening Balance (Cash & Bank)</td>
                                    <!-- <td align="right"><?php echo number_format($total_opening_balance, 2, '.', ',');?></td>
                                    <td align="right">0.00</td> -->
                                    <td align="right"><?php echo number_format($balance, 2, '.', ',');?></td>
                                </tr>
                            <?php } ?>
                                <?php 
                                

                                $period = new DatePeriod(new DateTime($from_date), new DateInterval('P1D'), new DateTime($to_date.' +1 day'));

                                foreach ($period as $day) {
                                $date = $day->format('Y-m-d');
                                $cash_ledger = $this->inventory_model->get_cash_ledger($date);
                                $bank_ledger = $this->inventory_model->get_bank_ledger($date);
                                                                  
                                ?>
                               
                            <?php if ($cash_ledger) {
                            foreach ($cash_ledger as $ledger) {
                                    if ($ledger->cash_transaction_type == "Debit(+)") {
                                        $debit_amount = $ledger->cash_transaction_amount;
                                        $credit_amount = 0;
                                        $balance += $debit_amount;
                                    }else if ($ledger->cash_transaction_type == "Credit(-)"){
                                        $debit_amount = 0;
                                        $credit_amount = $ledger->cash_transaction_amount;
                                        $balance -= $credit_amount;
                                    }
                                    $debit_total += $debit_amount;
                                    $credit_total += $credit_amount;
                                ?>
                                <tr>
                                    <td><?php echo $day->format('d-m-Y') ;?></td>  
                                     <td><?php echo $ledger->cash_transaction_description." (Cash)"; ?></td>  
                                    <td align="right"><?php echo number_format($debit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($credit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($balance, 2, '.', ',');?></td>
                                </tr>
                            <?php }} ?>

                            <?php if ($bank_ledger) {
                                foreach ($bank_ledger as $ledger) {
                                    if ($ledger->bank_transaction_type == "Debit(+)") {
                                        $debit_amount = $ledger->bank_transaction_amount;
                                        $credit_amount = 0;
                                        $balance += $debit_amount;
                                    }else if ($ledger->bank_transaction_type == "Credit(-)"){
                                        $debit_amount = 0;
                                        $credit_amount = $ledger->bank_transaction_amount;
                                        $balance -= $credit_amount;
                                    }
                                    
                                    $debit_total += $debit_amount;
                                    $credit_total += $credit_amount; 
                                ?>
                                <tr>
                                    <td><?php echo $day->format('d-m-Y') ;?></td>  
                                     <td><?php echo $ledger->bank_transaction_description." (Bank)"; ?></td>  
                                    <td align="right"><?php echo number_format($debit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($credit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($balance, 2, '.', ',');?></td>
                                </tr>
                                 <?php }}} ?>

                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="2">Total:</td>  
                                    <td align="right"><?php echo number_format($debit_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($credit_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($debit_total-$credit_total, 2, '.', ',');?></td>  
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

