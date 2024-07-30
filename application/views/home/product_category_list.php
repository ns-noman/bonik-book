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
        <h1>Product Category</h1>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <?php echo $success_msg; ?>
  <?php echo $error_msg; ?>
		<div class="card">
            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped table-hover" id="example1">
                <thead>
                <tr>
				          <th width="30">SL.</th>
                  <th>Product Category</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($edit_info){ ?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url() . "update-product-category/" . $edit_info->product_category_id; ?>" method="post" enctype="multipart/form-data"  role="form">
                    <td>Update</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="cat_name" id="cat_name" value="<?php echo $edit_info->product_category_name; ?>" required ><span style="color:red;"></span>
                      <span class="text-red"><?php echo form_error('cat_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i> Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php }else{?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url()?>add-product-category" method="post" enctype="multipart/form-data"  role="form">
                    <td>New</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="cat_name" id="cat_name" required style="width: 100%;"><span style="color:red;"></span>
                      <span class="text-red"><?php echo form_error('cat_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i> Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php } ?>

                <?php
                if ($product_cat_info){ 
                  $x = 1;
                  foreach($product_cat_info as $info){
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo $info->product_category_name;?>
                    </td>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-product-category/". $info->product_category_id; ?>">
                        <i class="fas fa-pen"></i> Edit
                      </a>
                    </td>
                  </tr>
    				      
                  <?php } } ?>
                  </tbody>
                <!--<tfoot>
                <tr>
                  <th>
                    footer
                  </th>
                </tr>
                </tfoot>-->
              </table>
            
            </div>
          </div>
		 
</section>