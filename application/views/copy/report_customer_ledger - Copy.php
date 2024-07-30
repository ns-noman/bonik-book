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
            <h1>Customer Ledger</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "customerwise-ledger"; ?>" method="post" enctype="multipart/form-data"  role="form" >

            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="customer_name" class="col-sm-2 col-form-label">Customer</label>
              <div class="col-sm-2">
                 <input type="text" name="customer_name" class=" form-control" placeholder="customer Name" id="customer_name"  autocomplete="off" required>
                  <input type="hidden" name="customer_id" class=" form-control" id="customer_id" autocomplete="off">
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
                <?php if($sales_info){ ?>
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
                                    <th width="200">customer</th>
                                    <th width="200">Invoice#</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                                <?php 
                                $balance = 0;
                                $debit_total = 0;
                                $credit_total = 0;
                                //$balance_total = 0;
                                foreach ($sales_info as $ledger) {
                                $discount = $ledger->sales_invoice_discount+$ledger->sales_total_discount;
                                $total = $ledger->sales_total_amount-$discount-$ledger->sales_invoice_return_total+$ledger->sales_total_vat;
                                 if ($ledger->sales_amount_paid > $total) {
                                                $sales_amount_paid = $total;
                                            }else{
                                                $sales_amount_paid = $ledger->sales_amount_paid;
                                            }
                                $paid = $sales_amount_paid;
                                $debit_total += $paid;
                                $credit_total += $total;
                                    
                                ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($ledger->sales_invoice_date));?></td>  
                                    <td><?php echo $ledger->customer_name;?></td>  
                                    <td><a target="_blank" href="<?php echo base_url() . "sales-detail/". $ledger->sales_invoice_id; ?>"><?php echo $ledger->sales_invoice_no;?></a></td>
                                    <td align="right"></td>     
                                    <td align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                                    <td align="right"><?php echo number_format((float)$balance -= $total, 2, '.', '');?></td>
                                </tr>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($ledger->sales_invoice_date));?></td>  
                                    <td><?php echo $ledger->customer_name;?></td>  
                                    <td><a target="_blank" href="<?php echo base_url() . "sales-detail/". $ledger->sales_invoice_id; ?>"><?php echo $ledger->sales_invoice_no;?></a></td>
                                    <td align="right"><?php echo number_format((float)$paid, 2, '.', '');?></td>
                                    <td align="right"></td>  
                                    <td align="right"><?php echo number_format((float)$balance += $paid, 2, '.', '');?></td>
                                </tr>
                            <?php } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="3">Grand Total:</td>  
                                    <td align="right"><?php echo number_format((float)$debit_total, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$credit_total, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$debit_total-$credit_total, 2, '.', '');?></td>  
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
