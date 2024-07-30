<style>
    .table td, .table th {
    padding: -0.1rem;
    
}
</style>
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
            <h1>Cash Flow Statement</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "cash-flow-statement-search"; ?>" method="post" enctype="multipart/form-data"  role="form" >
             <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">Date <span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd" required>
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
                      
                          <center><h4><?php echo $title ?></h4></center>
                            <table class="table table-bordered">
                                
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     
                                    <tr>
                                        <td>Opening Cash in Hand</td>
                                        <td align="right"><?php echo number_format($opening_cash_balance, 2, '.', ',');?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Opening Cash at Bank</td>
                                        <td align="right"><?php echo number_format($opening_bank_balance, 2, '.', ',');?></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right"><b>Total Opening Balance</b></td>
                                        <td></td>
                                        <td align="right"><b><?php echo number_format($total_opening_balance, 2, '.', ',');?></b></td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Cash Receive</td>
                                        <td align="right"><?php echo number_format($current_cash_debit, 2, '.', ',');?></td>
                                        <td></td>
                                        
                                    </tr>

                                    <tr>
                                        <td>Bank Receive</td>
                                        <td align="right"><?php echo number_format($current_bank_debit, 2, '.', ',');?></td>
                                        <td></td>
                                        
                                    </tr>

                                    <tr>
                                        <td align="right"><b>Total Receive</b></td>
                                        <td></td>
                                        <td align="right"><b><?php echo number_format($total_receive, 2, '.', ',');?></b></td>
                                       
                                    </tr>

                                    <tr>
                                        <td>Cash Payment</td>
                                        <td align="right"><?php echo number_format($current_cash_credit, 2, '.', ',');?></td>
                                        <td></td>
                                       
                                    </tr>

                                    <tr>
                                        <td>Bank Payment</td>
                                        <td align="right"><?php echo number_format($current_bank_credit, 2, '.', ',');?></td>
                                        <td></td>
                                        
                                    </tr>

                                    <tr>
                                        <td align="right"><b>Total Payment</b></td>
                                        <td></td>
                                        <td align="right"><b><?php echo number_format($total_payment, 2, '.', ',');?></b></td>
                                        
                                    </tr>

                                    <tr>
                                        <td>Closing Cash at Hand</td>
                                        <td align="right"><?php echo number_format($closing_cash, 2, '.', ',');?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Closing Cash at Bank</td>
                                        <td align="right"><?php echo number_format($closing_bank, 2, '.', ',');?></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right"><b>Total Closing Balance</b></td>
                                        <td></td>
                                        <td align="right"><b><?php echo number_format($total_closing_balance, 2, '.', ',');?></b></td>
                                        
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

