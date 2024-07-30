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
            <h1>Purchase Invoice Detail Invoice#: <?php echo $purchase_info->purchase_invoice_no; ?></h1>
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
          <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "new-purchase"; ?>">New Purchase</a>
         <!-- <a href="<?php //echo base_url() . "purchase-edit/" . $purchase_info->purchase_invoice_id; ?>" class="btn btn-danger btn-xs">Edit</a> -->
          <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-purchase-detail/". $purchase_info->purchase_invoice_id; ?>">
            <i class="fa fa-print"></i> POS
        </a>
        <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-purchase-challan/". $purchase_info->purchase_invoice_id; ?>">
            <i class="fa fa-print"></i> Challan
        </a>
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
              /*#printableArea{
                background-image: url(<?php echo $client_info->header_image; ?>);
              }*/
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
          <!-- <small class="float-right">Purchase Date: <?php echo date("d/m/Y", strtotime($purchase_info->purchase_invoice_date)); ?></small> -->
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <center><p style="font-size: 30px; font-weight: bold;">Purchase Invoice</p></center><hr>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $purchase_info->supplier_name; ?></strong><br>
          <?php if($purchase_info->supplier_org){echo $purchase_info->supplier_org."<br>";} ?>
          <?php echo $purchase_info->supplier_address; ?><br>
          
          Contact : <?php echo $purchase_info->supplier_mobile; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $client_info->client_name; ?></strong><br>
          <?php echo $client_info->client_address; ?><br>
          Contact: <?php echo $client_info->client_mobile; ?><br>
          Email: <?php echo $client_info->client_email; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <br>
        <b>Invoice #<?php echo $purchase_info->purchase_invoice_no; ?></b>
        <br>
        <b>Purchase Date:</b> <?php echo date("d/m/Y", strtotime($purchase_info->purchase_invoice_date)); ?>
        <br>
        <b>Challan#:</b> <?php echo $purchase_info->purchase_challan_no; ?><br>
        <b>Payment Type:</b> <?php echo $purchase_info->purchase_payment_type; ?>
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
            <th>Unit Price</th>
            <th style="border-right: solid 1px #000;">Discount Amount</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
          <?php if ($purchase_item){ 
                    $x = 1;
                    foreach($purchase_item as $item){
                        ?>
                        <tr>
                            <td><?php echo $x++; ?>.</td>
                            <td><?php echo $item->product_name; ?></td>
                            <td ><?php echo $item->purchase_item_quantity." ".$item->unit_name;?></td>
                            <td align="right"><?php echo number_format((float)$item->purchase_item_amount/$item->purchase_item_quantity, 2, '.', '');?></td>
                            <td align="right" style="border-right: solid 1px #000;"><?php echo number_format((float)$item->purchase_item_discount, 2, '.', '');?></td>
                            <td align="right"><?php echo number_format((float)$item->purchase_item_amount-$item->purchase_item_discount, 2, '.', '');?></td>
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
          <u>Purchase Details</u></label><br>
          <?php echo $purchase_info->purchase_invoice_detail;
           if ($purchase_info->purchase_payment_info) {
                     echo "<br>Payment Type: ".$purchase_info->purchase_payment_type."<br>Payment Info: ".$purchase_info->purchase_payment_info;
                 }

            ?>
        </p>
        <p><b>In Word:</b> <?php echo $in_word; ?> Only.</p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table btable">
            <tr>
              <td align="right" style="width:50%">Total Amount:</td>
              <td align="right"> <?php echo number_format((float)$purchase_info->purchase_total_amount, 2, '.', ''); ?></td>
            </tr>
             <?php if ($purchase_info->purchase_total_discount > 0){ ?>
            <tr>
              <td align="right">Total Discount:</td>
              <td align="right"><?php echo number_format((float)$purchase_info->purchase_total_discount, 2, '.', ''); ?></td>
            </tr>
          <?php } ?>
          <?php if ($purchase_info->purchase_invoice_discount > 0){ ?>
            <tr>
              <td align="right" style="border-bottom: 2px solid #000;">Special Discount:</td>
              <td align="right" style="border-bottom: 2px solid #000;"><?php echo number_format((float)$purchase_info->purchase_invoice_discount, 2, '.', ''); ?></td>
            </tr>
            <?php } ?>
            <tr>
              <td align="right">Net Payable:</td>
              <td align="right"><?php echo number_format((float)$total, 2, '.', ''); ?></td>
            </tr>

            <?php if ($purchase_info->purchase_advance_payment > 0){ ?>
              <tr>
              <td align="right">Paid from Account:</td>
              <td align="right"><?php  echo  number_format((float)$paid_amount, 2, '.', ''); ?></td>
            </tr>
            <tr>
                <td align="right" style="border-bottom: 2px solid #000;">Advance Adjustment:</td>
                <td align="right" style="border-bottom: 2px solid #000;">
                     <?php echo  number_format((float)$purchase_info->purchase_advance_payment, 2, '.', ''); ?>
                </td>
            </tr>
            <tr>
              <td align="right">Total Paid:</td>
              <td align="right"><?php  echo  number_format((float)$paid_amount+$purchase_info->purchase_advance_payment, 2, '.', ''); ?></td>
            </tr>
            <?php }else{ ?>
            <tr>
              <td align="right">Paid Amount:</td>
              <td align="right"><?php  echo  number_format((float)$paid_amount, 2, '.', ''); ?></td>
            </tr>
          <?php } ?>
          <?php if ($due > 0){ ?>
          <tr>
              <td align="right" style="border-bottom: 2px solid #000;">Due Amount :</td>
              <td align="right" style="border-bottom: 2px solid #000;">
                  <?php echo  number_format((float)$due, 2, '.', ''); ?>
              </td>
          </tr>
          <?php } ?>
            <!-- <?php if ($purchase_info->purchase_amount_paid > $total){ ?>
                <tr>
                    <td align="right" style="border-bottom: 2px solid #000;">Advance Amount :</td>
                    <td align="right" style="border-bottom: 2px solid #000;">
                         <?php echo  number_format((float)$purchase_info->purchase_amount_paid-$total, 2, '.', ''); ?>
                    </td>
                </tr>
              <?php }else{ ?>
                <tr>
                    <td align="right" style="border-bottom: 2px solid #000;">Due Amount :</td>
                    <td align="right" style="border-bottom: 2px solid #000;">
                        <?php echo  number_format((float)$due, 2, '.', ''); ?>
                    </td>
                </tr>
            <?php } ?> -->
            
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>

    <div class="row">
      <div class="col-12">
        <p> <span class="pull-left">Entry By <?php echo $purchase_info->user_name; ?></span> | 
                    <span class="pull-right">Entry Date-Time <?php echo date('d-m-Y h:i A',  strtotime($purchase_info->purchase_invoice_created_at)); ?></span>
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

