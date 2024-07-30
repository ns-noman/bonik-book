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
            <h1>Financial Statement</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
         <!-- <form class="form-horizontal" action="<?php echo base_url() . "financial-statement-search"; ?>" method="post" enctype="multipart/form-data"  role="form">
             <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">Date <span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd" required>
              </div>
             
              <div class="col-sm-2">
                 <button type="submit" class="btn btn-info">Search</button>
              </div>
            </div>
          </form> -->
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
                       
                          <center><h4><?php echo $title ?></h4></center>
                            <table class="table table-bordered">
                                
                                <thead>
                                    <tr style="background-color:#dfdfdf;">
                                        <th>Assets</th>
                                        <th>Amount</th>
                                        <th>Liabilities</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     
                                    <tr>
                                        <td>Cash in Hand</td>
                                        <td align="right"><?php echo number_format($cash_balance, 2, '.', ',');?></td>
                                        <td>Total Payable</td>
                                        <td align="right"><?php echo  number_format($payable, 2, '.', ',');?></td>
                                    </tr>
                                    <tr>
                                        <td>Cash at Bank</td>
                                        <td align="right"><?php echo number_format($bank_balance, 2, '.', ',');?></td>
                                            <td>Customer Advance</td>
                                            <td align="right"><?php echo number_format($customer_advance, 2, '.', ',');?></td>

                                    </tr>
                                    
                                    <tr>
                                        <td>Total Receivable</td>
                                        <td align="right"><?php echo number_format($receivable, 2, '.', ',');?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Total Stock Value</td>
                                        <td align="right"><?php echo number_format($stock, 2, '.', ',');?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Supplier Advance</td>
                                        <td align="right"><?php echo number_format($supplier_advance, 2, '.', ',');?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <td align="right"><b>Total</b></td>
                                        <td align="right"><b><?php echo number_format($cash_balance+$bank_balance+$receivable+$stock+$supplier_advance, 2, '.', ',');?></b></td>
                                        <td align="right"><b>Total</b></td>
                                        <td align="right"><b><?php echo number_format($payable+$customer_advance, 2, '.', ',');?></b></td>
                                    </tr>
                                    <tr style="background-color:#dfdfdf;">
                                        <td colspan="4" align="center"><b>Balance = <?php echo number_format($cash_balance+$bank_balance+$receivable+$stock+$supplier_advance-$payable-$customer_advance, 2, '.', ','); ?></b></td>
                                    </tr>
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

