<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>

      <style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    }
</style>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Supplier Receive Detail</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <div class="row">
                        <div class="col-md-12">
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
                                <tr>
                                    <td colspan="2" align="center">
                                        <h4>Payment Receipt</h4>
                                    </td>
                                </tr>
                            </table>
                            </center>
                            <hr>
                        </div>
                    </div>
                    <div class="row">

                            <div class="col-3 col-sm-3">
                                    <label class="form-label">Supplier : <?php echo $payment_info->supplier_name; ?></label>
                            </div>

                            <div class="col-3 col-sm-3">
                                    <label class="form-label">Contact : <?php echo $payment_info->supplier_mobile; ?></label>
                            </div>

                             <div class="col-3 col-sm-3">
                                    <label class="form-label">Organization : <?php echo $payment_info->supplier_org; ?></label>
                            </div>

                            <div class="col-3 col-sm-3">
                                    <label class="form-label">Payment Date: <?php echo date("d/m/Y", strtotime($payment_info->supplier_transaction_date)); ?></label></label>
                            </div>

                        </div>
                <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Detail</th>
                            <th width="200">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                        <tr>
                            <td><?php echo $payment_info->supplier_transaction_description; ?></td>
                            <td align="right"><?php echo number_format((float)$payment_info->supplier_transaction_amount, 2, '.', '');?></td>
                        </tr>
                    
                    
                    </tbody>
                    <tfoot>
                        
                        <tr>
                            <td colspan="2">
                                <b>In Word: <?php echo $in_word; ?> Only.</b>
                            </td>
                        </tr>
                       
                    </tfoot>
                </table>
            </div>
                <p> <span class="pull-left">Print By <?php echo $this->session->userdata('user_name'); ?></span>
                    <span class="pull-right">Print Date <?php echo date('d-m-Y'); ?></span>
                </p>
        </div>
      </div>
    </section>
    <!-- /.content -->

