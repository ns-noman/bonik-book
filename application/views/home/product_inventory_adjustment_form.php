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
            <h1>Inventory Adjustment</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <form class="form-horizontal" action="<?php echo base_url();?>save-inventory-adjustment-single" method="post" enctype="multipart/form-data"  role="form">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Individual Product Stock Adjustment</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <div class="row">
              <table class="table table-bordered table-striped table-hover" id="sales_table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Product<span class="text-red">*</span></th>
                            <th>Current Stock</th>
                            <th>New Stock<span class="text-red">*</span></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="product_code_temp" id="sales_product_code" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="product_name_temp" id="sales_product_name" autocomplete="off">
                                <input type="hidden" class="form-control" name="product_id" id="product_id" autocomplete="off">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="stock_qty_temp" id="stock_qty" readonly min="1">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="new_stock" id="new_qty" autocomplete="off" min="1">
                            </td>
                            <td>
                                <input type="submit" class="btn btn-primary btn-xs" value="Add">
                            </td>
                        </tr>
                        
                    
                    </tbody>
                </table>
          </div>
          
        </div>
       
      </div>
  </form>
       <form class="form-horizontal" action="<?php echo base_url();?>save-inventory-adjustment" method="post" enctype="multipart/form-data"  role="form">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Bulk Adjustment</h3>
          <h3 class="box-title" style="float:right;"><button type="submit" class="btn btn-primary">Save</button></h3>
        </div>
        <div class="card-body table-responsive">
        
          <div class="row">
              <?php if ($products){ ?>
                <table class="table table-bordered table-striped table-hover dtable">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>New Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($products as $product){
                        ?>
                        <tr>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td>
                            <?php echo $product->product_code;?>
                            <input type="hidden" class="form-control" name="product_id[]" value="<?php echo $product->product_id;?>">
                        </td>
                        <td><?php echo $product->product_name;?></td>
                        <td><?php echo $product->product_model;?></td>
                        <td><?php echo $product->product_category_name;?></td>
                        <td><?php echo $product->product_stock." ".$product->unit_name;?></td>
                        <td>
                            <input type="number" class="form-control" name="new_stock[]" value="<?php echo $product->product_stock;?>" autocomplete="off" min="0">
                        </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="center" colspan="7"><button type="submit" class="btn btn-primary">Save</button></td>
                    </tr>
                    </tbody>
                </table>
                <?php }else{ echo "No data  found!";} ?>
          </div>
          
        </div>
       
      </div>
  </form>
    </section>
    <!-- /.content -->

