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
                padding: 5px;
            }

            .table thead th {
                border: 1px solid #000;
            }
      </style>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Ledger</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "productwise-ledger"; ?>" method="post" enctype="multipart/form-data"  role="form">

            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From<span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd" required="">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To<span class="text-red">*</span></label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd" required="">
              </div>
              <label for="sales_product_name" class="col-sm-1 col-form-label">Product<span class="text-red">*</span></label>
              <div class="col-sm-3">
                  <input type="text" class="form-control" name="product_name_temp" id="sales_product_name" autocomplete="off" placeholder="Product" required="">
                  <input type="hidden" class="form-control" name="product_id" id="product_id" autocomplete="off">
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
                <?php if($stock_info){ ?>
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
                    <?php if ($product_info){ ?>
                    <center><h4><?php echo $title; ?></h4></center>
                        <table class="pledger table-bordered" style="font-size:12px;">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th rowspan="2" style="vertical-align: middle;">SL</th>
                                    <th width="200" rowspan="2" style="vertical-align: middle;">Product</th>
                                    <th colspan="3">Opening</th>
                                    <th colspan="3">Inward</th>
                                    <th colspan="3">Outward</th>
                                    <th colspan="3">Closing</th>
                                </tr>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th>QTY</th>
                                    <th>Rate</th>
                                    <th>Value</th>
                                    <th>QTY</th>
                                    <th>Rate</th>
                                    <th>Value</th>
                                    <th>QTY</th>
                                    <th>Rate</th>
                                    <th>Value</th>
                                    <th>QTY</th>
                                    <th>Rate</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $x = 1;
                                $total_opening_qty = 0;
                                $total_closing_qty = 0;
                                foreach($product_info as $product){
                                    $opening_purchase = $this->inventory_model->get_opening_purchase($product->product_id, $to_date);
                                    $opening_sales = $this->inventory_model->get_opening_sales($product->product_id, $to_date);
                                    $opening_stock = $opening_purchase->purchase_item_quantity-$opening_sales->sales_item_quantity;
                                    $purchase_qty = $this->inventory_model->purchase_qty($product->product_id, $from_date, $to_date);
                                    $sales_qty = $this->inventory_model->sales_qty($product->product_id, $from_date, $to_date);
                                    $closing_stock = $opening_stock+$purchase_qty->purchase_item_quantity-$sales_qty->sales_item_quantity;



                                 ?>
                                <tr>
                                     <td><?php echo $x++; ?>.</td>
                                    <td><?php echo $product->product_name;?></td>
                                    <td><?php echo $opening_stock." ".$product->unit_name;?></td>
                                    <td><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$opening_stock*$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo $purchase_qty->purchase_item_quantity." ".$product->unit_name;?></td>
                                    <td><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$purchase_qty->purchase_item_quantity*$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo $sales_qty->sales_item_quantity." ".$product->unit_name;?></td>
                                    <td><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$sales_qty->sales_item_quantity*$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo $closing_stock." ".$product->unit_name;?></td>
                                    <td><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$closing_stock*$product->product_unit_price, 2, '.', '');?></td>
                                </tr>
                            <?php } ?>
                                <!-- <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="3">Grand Total:</td>  
                                    <td align="right"><?php echo number_format((float)0, 2, '.', '');?></td>  
                                    
                                </tr> -->
                                 
                            </tbody>
                        </table>
                    <?php } ?>
                            
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

