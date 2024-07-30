<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>

     <!--  <style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    }
</style> -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1><?php echo $quotation_info->quotation_type." #".$quotation_info->quotation_no; ?></h1>
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
          <!-- <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "new-sales"; ?>">New Sales</a> -->
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive" id="printableArea">
          <style type="text/css">
              .table td, .table th {
                border-bottom: 1px solid #000;
                border-top: 1px solid #000;
            }

            .table thead th {
                border-bottom: 2px solid #000;
                border-top: 2px solid #000;
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
          <?php if ($client_info->header_image) { ?>
              <img src="<?php echo base_url().$client_info->header_image; ?>" height="100">
          <?php }else{ ?>
              <h3><?php echo $client_info->client_name; ?></h3>
          <?php } ?>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <center><p style="font-size: 30px; font-weight: bold;"><?php echo $quotation_info->quotation_type; ?></p>
      
    </center>
    <p style="font-size: 18px; font-weight: bold;"><?php echo $quotation_info->quotation_title; ?></p>
    <hr>
    <div class="row invoice-info">
      <div class="col-sm-5 invoice-col">
        From
        <address>
          <strong><?php echo $client_info->client_name; ?></strong><br>
          <?php echo $client_info->client_address; ?><br>
          Contact: <?php echo $client_info->client_mobile; ?><br>
          Email: <?php echo $client_info->client_email; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-5 invoice-col">
        To
        <address>
          <?php if ($supplier_info) { ?>
            <strong><?php echo $supplier_info->supplier_name; ?></strong><br>
          <?php if($supplier_info->supplier_org){echo $supplier_info->supplier_org."<br>";} ?>
          <?php echo $supplier_info->supplier_address; ?><br>
          Contact : <?php echo $supplier_info->supplier_mobile; ?>
          <?php }else if ($customer_info){ ?>
          <strong><?php echo $customer_info->customer_name; ?></strong><br>
          <?php if( $customer_info->customer_organization){echo $customer_info->customer_organization."<br>";} ?>
          <?php echo $customer_info->customer_address; ?><br>
          Contact : <?php echo $customer_info->customer_mobile; ?>
        <?php } ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-2 invoice-col">
        <br>
        <b>Quotation #<?php echo $quotation_info->quotation_no; ?></b>
        <br>
        <b>Date:</b> <?php echo date("d/m/Y", strtotime($quotation_info->quotation_date)); ?>
        
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
            <th>SL</th>
            <th >Detail</th>
            <th>Qty</th>
            <th style="border-right: solid 1px #000;">Unit Price</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
                        
            <?php if ($quotation_item){ 
        $x = 1;
        foreach($quotation_item as $item){
            ?>
            <tr>
                <td><?php echo $x++; ?>.</td>
                <td><?php echo $item->product_name; ?></td>
                <td align="center"><?php echo $item->quotation_item_quantity." ".$item->unit_name;?></td>
                <td align="right" style="border-right: solid 1px #000;"><?php if($item->quotation_item_rate>0){echo $this->engtobnconverts->taka_format($item->quotation_item_rate);}?></td>
                <td align="right"><?php if($item->quotation_item_amount>0){echo $this->engtobnconverts->taka_format($item->quotation_item_amount);}?></td>
            </tr>
        <?php }}else{ echo "No data  found!";} ?>
        
        </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- detail column -->
      <div class="col-6">
        <p class="well well-sm shadow-none" style="margin-top: 10px;">
          <label class="col-form-label">
          <u>Description</u></label><br>
          <?php echo $quotation_info->quotation_detail;
           
            ?>
        </p>
        <p><b>In Word:</b> <?php if($quotation_info->quotation_total_amount>0){echo $in_word; ?> Only. <?php } ?></p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table btable">
            <tr>
              <td align="right" style="width:50%">Total Amount:</td>
              <td align="right"> <?php if($quotation_info->quotation_total_amount>0){echo $this->engtobnconverts->taka_format($quotation_info->quotation_total_amount);} ?></td>
           
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
        
        <br><br>
        <p> <span class="pull-left">Entry By <?php echo $quotation_info->user_name; ?></span> | 
                    <span class="pull-right">Entry Date-Time <?php echo date('d-m-Y h:i A',  strtotime($quotation_info->quotation_created_at)); ?></span>
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

