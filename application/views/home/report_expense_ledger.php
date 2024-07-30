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
            <h1>Expense Statement</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "expense-ledger-report"; ?>" method="post" enctype="multipart/form-data"  role="form" >
            <div class="form-group row">
              
              <div class="col-sm-2">
                <label for="from_date" class=" col-form-label">From<span class="text-red">*</span></label>
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              
              <div class="col-sm-2">
                <label for="to_date" class="col-form-label">To<span class="text-red">*</span></label>
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date" required autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              
              <div class="col-sm-2">
                <label for="to_date" class="col-form-label">Expense </label>
                 <select class="form-control select2" name="expense" id="expense" style="width:100%">
                     <option value="">Select...</option>
                     <?php if($expense_head_info){
                        foreach ($expense_head_info as $expense) {
                      ?>
                     <option value="<?php echo $expense->expense_head_id; ?>"><?php echo $expense->expense_head_name; ?></option>
                 <?php } } ?>
                 </select>
              </div>

              
              <div class="col-sm-2">
                <label for="name_mobile" class="col-form-label">Name/Mobile</label>
                 <input type="text" class="form-control" name="name_mobile" id="name_mobile" autocomplete="off">
              </div>
              
              <div class="col-sm-2">
                 <label class="col-form-label col-sm-12">&nbsp</label>
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
                <?php if($expense_ledger){ ?>
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
                    <center><h4>Expense Statement Form <?php echo date("d/m/Y", strtotime($from_date))." To ".date("d/m/Y", strtotime($to_date)); ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="100">Date</th>
                                    <th width="100">Voucher#</th>
                                    <th>Expense To</th>
                                    <th>Detail</th>
                                    <th>Amount</th>
                                    <th class="no-print">Action</th>
                                </tr>
                                <?php 
                                $balance_total = 0;
                                foreach ($expense_ledger as $ledger) {
                                    $balance_total += $ledger->expense_transaction_amount;
                                ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($ledger->expense_transaction_date)); ?></td>
                                    <td><?php echo $ledger->expense_voucher_no; ?></td>  
                                    <td><?php echo $ledger->expense_transaction_description." | ".$ledger->expense_transaction_contact; ?></td>  
                                    
                                    <td><?php echo $ledger->expense_head_name; ?></td>  
                                    <td align="right"><?php echo number_format((float)$ledger->expense_transaction_amount, 2, '.', '');?></td>
                                    <td class="no-print">
                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "expense-voucher/". $ledger->expense_transaction_id; ?>">View</a>
                                    </td>
                                </tr>
                            <?php } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="4">Grand Total:</td>  
                                    <td align="right"><?php echo number_format((float)$balance_total, 2, '.', '');?></td>  
                                </tr>
                            </thead>
                            <tbody>
                                 
                            </tbody>
                        </table>
                            
                        <br>
                    Print By <?php echo $this->session->userdata('user_name'); ?> | 
                    print Date <?php echo date("d/m/Y"); ?> 
                </div>
            <?php } ?>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

