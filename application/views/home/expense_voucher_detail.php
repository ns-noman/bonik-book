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
          <div class="col-sm-12">
            <h1>Expense Voucher</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
      <div class="card">
        <div class="card-header">
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          <style type="text/css">
              .table td, .table th {
                border: 1px solid #000;
               
            }

            .table thead th {
                border-bottom: 2px solid #000;
                border-top: 2px solid #000;
                background-color: #dfdfdf;
                text-align: center;
            }

            .btable  td:first-child {
                font-weight: bold;
              }
          </style>
          <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
            <center>
          <?php if ($client_info->header_image) { ?>
              <img src="<?php echo base_url().$client_info->header_image; ?>" height="100">
          <?php }else{ ?>
              <h3><?php echo $client_info->client_name; ?></h3>
          <?php } ?>
          </center>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <center><p style="font-size: 30px; font-weight: bold;">Expense Voucher</p></center><hr>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $client_info->client_name; ?></strong><br>
          <?php echo $client_info->client_address; ?><br>
          Contact: <?php echo $client_info->client_mobile; ?><br>
          Email: <?php echo $client_info->client_email; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $expense->expense_transaction_description; ?></strong><br>
           Contact: <?php echo $expense->expense_transaction_contact; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <br>
        <b>Voucher #<?php echo $expense->expense_voucher_no; ?></b>
        <br>
        <b>Date:</b> <?php echo date("d/m/Y", strtotime($expense->expense_transaction_date)); ?>
        <br>
        <b>Payment Method:</b> <?php echo $expense->expense_payment_method; ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="30">SL</th>
            <th >Particulars</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            <tr>
                <td><?php echo 1; ?>.</td>
                <td><?php echo $expense->expense_head_name; ?></td>
                <td align="right"><?php echo number_format($expense->expense_transaction_amount, 2, '.', ',');?></td>
            </tr>
        </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- detail column -->
      <div class="col-6">
        <p><b>In Word:</b> <?php echo $this->numbertowordconvertsconver->getBdCurrency($expense->expense_transaction_amount); ?> Only.</p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table btable">
            <tr>
              <td align="right" style="width:50%">Total Amount:</td>
              <td align="right"> <?php echo number_format($expense->expense_transaction_amount, 2, '.', ','); ?></td>
            </tr>
           
            
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>

    <div class="row">
      <div class="col-12">
        <br><br><br><br>
        <br>
        <span style="border-top: 2px solid #000;" class="text-center">Authorized Signature</span>
        <span style="border-top: 2px solid #000;" class="float-right text-center">Receiver Signature
        </span>
        <br><br>
        <p> <span class="pull-left">Entry By <?php echo $expense->user_name; ?></span> | 
                    <span class="pull-right">Entry Date-Time <?php echo date('d-m-Y h:i A',  strtotime($expense->expense_transaction_created_at)); ?></span>
                </p>
                <p> <span class="pull-left">Print By <?php echo $this->session->userdata('user_name'); ?></span>
                    <span class="pull-right">Print Date <?php echo date('d-m-Y'); ?></span>
                </p>
      </div>
    </div>
          
        </div>
      </div>
    </section>
    <!-- /.content -->

