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
            <h1>Supplier Entry/Edit</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        
        <?php if ($edit_info) { ?>
        <form class="form-horizontal" action="<?php echo base_url() . "update-supplier/" . $edit_info->supplier_id; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_name" id="supplier" value="<?php echo $edit_info->supplier_name; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_org" class="col-sm-4 col-form-label">Organization <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_org" id="supplier_org" value="<?php echo $edit_info->supplier_org; ?>">
                                <span class="text-red"><?php echo form_error('supplier_org'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_mobile" class="col-sm-4 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_mobile" id="supplier_mobile" value="<?php echo $edit_info->supplier_mobile; ?>">
                                <span class="text-red"><?php echo form_error('supplier_mobile'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="supplier_email" id="supplier_email" value="<?php echo $edit_info->supplier_email; ?>">
                                <span class="text-red"><?php echo form_error('supplier_email'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="supplier_address" id="supplier_address" placeholder=""><?php echo $edit_info->supplier_address; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-info">Update</button>
            </div>
        </form>
        <?php  }else{ ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-supplier" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_name" id="supplier" value="<?php echo set_value('supplier_name'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_org" class="col-sm-4 col-form-label">Organization <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_org" id="supplier_org" value="<?php echo set_value('supplier_org'); ?>" required>
                                <span class="text-red"><?php echo form_error('supplier_org'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_mobile" class="col-sm-4 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="supplier_mobile" id="supplier_mobile" value="<?php echo set_value('supplier_mobile'); ?>" required>
                                <span class="text-red"><?php echo form_error('supplier_mobile'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="supplier_email" id="supplier_email" value="<?php echo set_value('supplier_email'); ?>">
                                <span class="text-red"><?php echo form_error('supplier_email'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="supplier_address" id="supplier_address" rows="1"><?php echo set_value('supplier_address'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-info">Save</button>
            </div>
        </form>
         <?php } ?>
      </div>
    </section>
    <!-- /.content -->

