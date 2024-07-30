<section class ="invoice">
      
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
    <center><p style="font-size: 30px; font-weight: bold;">Purchase Challan</p></center><hr>
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
            <th align="center" width="50">SL</th>
            <th align="center">Detail</th>
            <th align="center">Qty</th>
          </tr>
          </thead>
          <tbody>
          <?php if ($purchase_item){ 
                    $x = 1;
                    foreach($purchase_item as $item){
                        ?>
                        <tr>
                            <td align="center"><?php echo $x++; ?>.</td>
                            <td><?php echo $item->product_name; ?></td>
                            <td align="center"><?php echo $item->purchase_item_quantity." ".$item->unit_name;?></td>
                        </tr>
                    <?php }}else{ echo "No data  found!";} ?>
          </tbody>
        </table>
        <table width="100%"style="font-size:14px;">
              
              <tr>
              <td>
                Prepared By <?php echo $this->session->userdata('user_name'); ?>
              </td>
              
              <td align="right">
               Print Date : <?php echo date("d/m/Y"); ?>
              </td>
              </tr>
              <tr>
                  <td colspan="3" align="right">Powered By: A & A</td>
              </tr>
              <tr>
                  <td colspan="3" align="center"><b>*** Have a Nice Day ***</b></td>
              </tr>
              
          </table>
      </div>
      <!-- /.col -->
    </div>
  </section>
    <!-- /.row -->
    <script type="text/javascript">
window.onload = function() { window.print(); }

window.onafterprint = function(event) {
    window.history.back();
};
</script>