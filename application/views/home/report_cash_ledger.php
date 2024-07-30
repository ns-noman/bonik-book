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
            <h1>Cash Ledger</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "cash-ledger-report"; ?>" method="post" enctype="multipart/form-data"  role="form" >
            <div class="form-group row">
              
              <label for="from_date" class="col-sm-1 col-form-label">From<span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To<span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <div class="col-sm-1">
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
                <style type="text/css">
          .table-bordered td, .table-bordered th {
                border: 1px solid #000;
            }

            .table thead th {
                border: 1px solid #000;
            }
            .table td, .table th {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
      </style>
                <?php if($cash_ledger){ ?>
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
                    <center><h4>  <?php echo "Cash Ledger Form ".date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)); ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="100">Date</th>
                                    <th width="400">Description</th>
                                    <th>Debit (+)</th>
                                    <th>Credit (-)</th>
                                    <th>Balance</th>
                                </tr>
                                <?php 
                                $balance = 0;
                                $debit_total = 0;
                                $credit_total = 0;
                                //$balance_total = 0;
                                ?>
                                <tr>
                                    <td colspan="4">Opening Balance</td>
                                    <td align="right"><?php 
                                        $debit_amount = $opening_cash_balance;
                                        $credit_amount = 0;
                                        $balance += $debit_amount;
                                    echo number_format($opening_cash_balance, 2, '.', ',');?></td>
                                </tr>
                                <?php
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
                                    //$balance = $debit_amount - $credit_amount;
                                    $debit_total += $debit_amount;
                                    $credit_total += $credit_amount;
                                    //$balance_total += $balance;
                                ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($ledger->cash_transaction_date)); ?></td>  
                                    <td><?php echo $ledger->cash_transaction_description; ?></td>  
                                    <td align="right"><?php echo number_format($debit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($credit_amount, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($balance, 2, '.', ',');?></td>
                                </tr>
                            <?php } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="2">Grand Total:</td>  
                                    <td align="right"><?php echo number_format($opening_cash_balance+$debit_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($credit_total, 2, '.', ',');?></td>  
                                    <td align="right"><?php echo number_format($opening_cash_balance+$debit_total-$credit_total, 2, '.', ',');?></td>  
                                </tr>
                            </thead>
                            <tbody>
                                 
                            </tbody>
                        </table>
                            
                        <br>
                    Print By <?php echo $this->session->userdata('user_name'); ?> | 
                    Print Date <?php echo date("d/m/Y"); ?> 
                </div>
            <?php } ?>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

