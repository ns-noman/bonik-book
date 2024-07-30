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
            <h1>Low Stock Report</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <!-- <form class="form-horizontal" action="<?php echo base_url() . "stock-search-report"; ?>" method="post" enctype="multipart/form-data"  role="form" >
            <div class="form-group row">
              <label for="category" class="col-sm-1 col-form-label">Category</label>
              <div class="col-sm-2">
                 <select name="category" class=" form-control select2" id="category" style="width: 100%;">
                    <option value="">Select...</option>
                    <?php if ($product_cat_info){
                        foreach ($product_cat_info as $category) {
                    ?>
                    <option value="<?php echo $category->product_category_id; ?>">
                        <?php echo $category->product_category_name; ?>
                    </option>
                <?php }} ?>
                </select>
              </div>

              <label for="brand" class="col-sm-1 col-form-label">Brand</label>
              <div class="col-sm-2">
                 <select name="brand" class=" form-control select2" id="brand" style="width: 100%;">
                    <option value="">Select...</option>
                    <?php if ($manufacturer_info){
                        foreach ($manufacturer_info as $brand) {
                    ?>
                    <option value="<?php echo $brand->man_id; ?>">
                        <?php echo $brand->man_name; ?>
                    </option>
                <?php }} ?>
                </select>
              </div>

              <label for="product_name" class="col-sm-1 col-form-label">Product</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="product_name_temp" id="sales_product_name" autocomplete="off" placeholder="Product">
                  <input type="hidden" class="form-control" name="product_id" id="product_id" autocomplete="off">
              </div>
              
              <div class="col-sm-1">
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
                <?php if($products){ ?>
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
                                    <th width="20">SL.</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Qty</th>
                                    <th>Purchase Rate</th>
                                    <th>Stock Value</th>
                                </tr>
                                <?php 
                                $x = 1;
                                $stock_value = 0;
                                foreach($products as $product){
                                    //if ($product->product_stock <= $product->product_reorder_level) {
                                        $stock_value += $product->product_stock*$product->product_unit_price;
                                ?>
                                <tr>
                                    <td><?php echo $x++;?></td>  
                                    <td><?php echo $product->product_name;?></td>
                                    <td><?php echo $product->product_category_name;?></td>
                                    <td><?php echo $product->product_stock." ".$product->unit_name;?></td>
                                    <td align="right"><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                                    <td align="right"><?php echo number_format((float)$product->product_stock*$product->product_unit_price, 2, '.', '');?></td>
                                </tr>
                            <?php //}
                        } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="5">Total:</td>  
                                    <td align="right"><?php echo number_format((float)$stock_value, 2, '.', '');?></td>  
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

