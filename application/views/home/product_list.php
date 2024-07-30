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
            <h1>Manage Product <a href="<?php echo base_url().'new-product'; ?>" class="btn btn-primary btn-sm"> New Entry</a></h1>

          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <?php if ($products){ ?>
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <caption>All Product List</caption>
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="min-width: 200px;">Product Name</th>
                        <th style="min-width: 100px;">Model</th>
                        <th style="min-width: 100px;">Category</th>
                        <th style="min-width: 100px;">Stock</th>
                        <th style="min-width: 100px;">Purchase Price</th>
                        <th style="min-width: 100px;">MRP</th>
                        <th style="min-width: 100px;">Stock Value</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th style="min-width: 150px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    $stock_value = 0;
                    foreach($products as $product){
                        $stock_value += $product->product_stock*$product->product_unit_price;
                        ?>
            <tr>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $product->product_name;?></td>
                        <td><?php echo $product->product_model;?></td>
                        <td><?php echo $product->product_category_name;?></td>
                        <td><?php echo $product->product_stock." ".$product->unit_name;?></td>
                        <td align="right"><?php echo number_format((float)$product->product_unit_price, 2, '.', '');?></td>
                        <td align="right"><?php echo number_format((float)$product->product_unit_mrp, 2, '.', '');?></td>
                        <td align="right"><?php echo number_format((float)$product->product_stock*$product->product_unit_price, 2, '.', '');?></td>
                        <td>
                          <img alt="..." onerror="this.src='<?php echo base_url();?>assets/dist/img/qr.png'" src="<?php echo base_url().$product->product_image;?>" height="50" width="45" />
                        </td>
                        <td><?php if ($product->product_status == 1){ ?>
                        <a class="btn btn-success btn-xs" href="<?php echo base_url() . "deactivate-product/" . $product->product_id; ?>">
                          Active                                           
                        </a>
                        <?php }else{ ?>
                          <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "activate-product/" . $product->product_id; ?>">
                           Deactivated                                            
              </a>
              <?php } ?>
            </td>
                        <td>
              <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "view-product/" . $product->product_id; ?>">
                View                                            
              </a>
              <a class="btn btn-info btn-xs" href="<?php echo base_url() . "edit-product/" . $product->product_id; ?>">
                Edit                                            
              </a>
              <?php if ($product->product_code) {?>
              <a class="btn btn-warning btn-xs" href="<?php echo base_url() . "product-barcode/" . $product->product_id; ?>">
                Barcode                                            
              </a>
              <?php } ?>
            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td align="right"><b>Total Value :</b></td>
                        <td><b><?php echo number_format((float)$stock_value, 2, '.', '');?></b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
        <?php }else{ echo "No data  found!";} ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

