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
          <form class="form-horizontal" action="<?php echo base_url() . "datewise-receive-payment"; ?>" method="post" enctype="multipart/form-data"  role="form" >

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
                    <center><h4><?php echo $title; ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="100">Date</th>
                                    <th width="400">Particulars</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>

                                <?php 
                                $pre_date = date("Y-m-d", strtotime(' -1 day', strtotime($from_date)));
                                $opening_cash_debit = $this->inventory_model->opening_debit_cash_by_date($pre_date);
                                $opening_cash_credit = $this->inventory_model->opening_credit_cash_by_date($pre_date);
                                $opening_cash_balance = $opening_cash_debit->cash_transaction_amount-$opening_cash_credit->cash_transaction_amount;
                                 $opening_bank_debit = $this->inventory_model->opening_debit_bank_by_date($pre_date);
                                $opening_bank_credit = $this->inventory_model->opening_credit_bank_by_date($pre_date);
                                $opening_bank_balance = $opening_bank_debit->bank_transaction_amount-$opening_bank_credit->bank_transaction_amount;
                                $total_opening_balance = $opening_cash_balance+$opening_bank_balance;
                                if ($total_opening_balance > 0) { ?>
                                <tr>
                                    <td><?php echo date("d-m-Y", strtotime($from_date)); ;?></td>  
                                    <td>Opening Balance (Cash & Bank)</td>
                                    <td>0.00</td>
                                    <td><?php echo $this->engtobnconverts->taka_format($total_opening_balance);?></td>
                                </tr>
                            <?php } ?>
                                <?php 
                                $debit_total = 0;
                                $credit_total = 0;

                                // $period = new DatePeriod(
                                //      new DateTime($from_date),
                                //      new DateInterval('P1D'),
                                //      new DateTime($to_date)
                                // );

                                $period = new DatePeriod(new DateTime($from_date), new DateInterval('P1D'), new DateTime($to_date.' +1 day'));



                                foreach ($period as $day) {
                                $date = $day->format('Y-m-d');
                                $purchase = $this->inventory_model->get_purchase_total($date);
                                $sales = $this->inventory_model->get_sales_total($date);

                                $purchase_payment = $this->inventory_model->get_purchase_payment_total($date);
                                $sales_collection = $this->inventory_model->get_sales_collection_total($date);
                                  $purchase_payment = $purchase_payment->purchase_payment_amount-$purchase->purchase_invoice_return_amount;
                                  $sales_collection = $sales_collection->sales_payment_amount-$sales->sales_invoice_return_amount;
                                   $expense = $this->inventory_model->get_expense_total($date);
                                   $total_expense = $expense->expense_transaction_amount;
                                   $expense_ledger= $this->inventory_model->get_expense_ledger_by_day($date);
                                   $debit_total += $purchase_payment+$total_expense;
                                   $credit_total += $sales_collection;                                   
                                ?>
                               
                            <?php if ($purchase_payment > 0) { ?>
                                <tr>
                                    <td><?php echo $day->format('d-m-Y') ;?></td>  
                                    <td>Purchase Payment</td>
                                    <td><?php echo $this->engtobnconverts->taka_format($purchase_payment);?></td>
                                    <td>0.00</td>
                                </tr>
                            <?php } ?>
                             <?php if ($sales_collection > 0) { ?>
                                <tr>
                                    <td><?php echo $day->format('d-m-Y') ;?></td>  
                                    <td>Sales Collection</td>
                                    <td>0.00</td>
                                    <td><?php echo $this->engtobnconverts->taka_format($sales_collection);?></td>
                                </tr>
                                <?php } ?>
                             <?php if ($total_expense > 0) {
                                foreach ($expense_ledger as $expense) {
                              ?>

                                <tr>
                                    <td><?php echo $day->format('d-m-Y') ;?></td>  
                                    <td><?php echo $expense->expense_head_name; ?></td>
                                    <td><?php echo $this->engtobnconverts->taka_format($expense->expense_transaction_amount);?></td>
                                    <td>0.00</td>
                                </tr>
                                 <?php } }?>
                              
                            <?php } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="2">Total:</td>  
                                    <td align="right"><?php echo $this->engtobnconverts->taka_format($debit_total);?></td>  
                                    <td align="right"><?php echo $this->engtobnconverts->taka_format($credit_total);?></td>  
                                </tr>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="2">Balance:</td>   
                                    <td align="center" colspan="2"><?php echo $this->engtobnconverts->taka_format($total_opening_balance+$credit_total-$debit_total);?></td>  
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

