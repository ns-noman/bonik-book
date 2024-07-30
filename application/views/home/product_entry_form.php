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
        <h5>New Product Entry Form<b class="text-red"> ( * ) Marked Fields are Required.</b></h5>
        
        <?php echo $success_msg;
         echo $error_msg; ?>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <form class="form-horizontal" action="<?php echo base_url().'add-product';?>" method="post" enctype="multipart/form-data"  role="form">
      <div class="card card-info">
        <div class="card-body">
            <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                             <div class="form-group row">
                                <label for="product_name" class="col-sm-2 col-form-label">Product Name <i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="product_name" type="text" id="product_name1" placeholder="Product Name" value="<?php echo set_value('product_name'); ?>" required>
                                    <span class="text-red"><?php echo form_error('product_name'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="category_id" class="col-sm-4 col-form-label">Category <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="category_id" name="category_id" style="width: 100%;" required>
                                        <option value="">Select One</option>
                                            <?php  if($product_category_info){ foreach($product_category_info as $cat_info) { ?>
                                            <option value="<?php echo $cat_info->product_category_id; ?>"><?php echo $cat_info->product_category_name; ?></option>
                                            <?php }}?>
                                    </select>
                                    <span class="text-red"><?php echo form_error('category_id'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="measurement_unit" class="col-sm-4 col-form-label">Measurement Unit <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="measurement_unit" name="measurement_unit" style="width: 100%;" required>
                                    <option value="">Select One</option>
                                    <?php  if($unit_info){ foreach($unit_info as $unit) { ?>
                                            <option value="<?php echo $unit->unit_id; ?>"><?php echo $unit->unit_name; ?></option>
                                            <?php }}?>
                                </select>
                                <span class="text-red"><?php echo form_error('measurement_unit'); ?></span>
                            </div>
                        </div>
                    </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="unit_price" class="col-sm-4 col-form-label">Unit Purchase Price <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="unit_price" name="unit_price" placeholder="Unit Trade Price" value="<?php echo set_value('unit_price'); ?>" step="0.01" required>
                                    <span class="text-red"><?php echo form_error('unit_price'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="unit_mrp" class="col-sm-4 col-form-label">Unit Sales Price <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="unit_mrp" name="unit_mrp" placeholder="Unit Sales Price" value="<?php echo set_value('unit_mrp'); ?>" step="0.01"required>
                                    <span class="text-red"><?php echo form_error('unit_mrp'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>                        
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="vat" class="col-sm-4 col-form-label">VAT</label>
                            <div class="col-sm-7">
                                <input type="number" id="vat" name="vat"class="form-control" placeholder="VAT%" value="<?php echo set_value('vat'); ?>" step="0.01">
                            </div>
                            <div class="col-sm-1"> <i class="text-success">%</i></div>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="product_model" class="col-sm-4 col-form-label">Model</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="product_model" name="product_model" placeholder="Model" value="<?php echo set_value('product_model'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="barcode" class="col-sm-4 col-form-label">Barcode</label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="barcode" type="text" id="barcode" placeholder="Barcode" value="<?php echo set_value('barcode'); ?>" min="0">
                                    <span class="text-red"><?php echo form_error('barcode'); ?></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    
                <div class="row">
                    <div class="col-sm-6">
                                <div class="form-group row">
                                <label for="serial_no" class="col-sm-4 col-form-label">SKU </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="serial_no" name="serial_no" placeholder="111,abc,XYz" value="<?php echo set_value('serial_no'); ?>">
                                </div>
                            </div>
                        </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="manufacturer_id" class="col-sm-4 col-form-label">Manufacturer/Brand</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="manufacturer_id" name="manufacturer_id" style="width: 100%;">
                                    <option value="">Select One</option>
                                    <?php  if($manufacturer_info){ foreach($manufacturer_info as $manufacturer) { ?>
                                            <option value="<?php echo $manufacturer->man_id; ?>"><?php echo $manufacturer->man_name; ?></option>
                                            <?php }}?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="reorder_level" class="col-sm-4 col-form-label">Re-Order Level</label>
                            <div class="col-sm-8">
                                <input type="number" id="reorder_level" name="reorder_level"class="form-control" placeholder="Re-Order Level" value="<?php echo set_value('reorder_level'); ?>" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="product_image" class="col-sm-4 col-form-label">Image </label>
                            <div class="col-sm-8">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="product_image" name="product_image">
                                  <label class="custom-file-label" for="customFile">Choose file</label>
                                  <span class="text-red">Please use a png, jpg or jpeg File. Max File size 2MB.</span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-12">
                        <center><label for="product_description" class="col-form-label">Product Details</label></center>
                        <textarea class="form-control" name="product_description" id="product_description" rows="5" placeholder="Product Details"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
          <button type="submit" class="btn btn-info">Save</button>
        </div>
        </div>
    </form>
</section>

