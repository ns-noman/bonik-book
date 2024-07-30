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
            <h1>Customer Entey/Edit</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php if ($edit_info) { ?>
        <form class="form-horizontal" action="<?php echo base_url() . "update-customer/" . $edit_info->customer_id; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">

              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_name" id="customer_name1" value="<?php echo $edit_info->customer_name; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_organization" class="col-sm-4 col-form-label">Organization <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_organization" id="customer_organization" value="<?php echo $edit_info->customer_organization; ?>" required>
                                <span class="text-red"><?php echo form_error('customer_organization'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_mobile" id="customer_mobile1" value="<?php echo $edit_info->customer_mobile; ?>" required>
                                <span class="text-red"><?php echo form_error('customer_mobile'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="customer_email" id="customer_email" value="<?php echo $edit_info->customer_email; ?>">
                                <span class="text-red"><?php echo form_error('customer_email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="customer_address" id="customer_address" placeholder=""><?php echo $edit_info->customer_address; ?></textarea>
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
        <form class="form-horizontal" action="<?php echo base_url();?>save-customer" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_name" id="customer_name1" value="<?php echo set_value('customer_name'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_organization" class="col-sm-4 col-form-label">Organization <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_organization" id="customer_organization" value="" required>
                                <span class="text-red"><?php echo form_error('customer_organization'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="customer_mobile" id="customer_mobile1" value="<?php echo set_value('customer_mobile'); ?>" required>
                                <span class="text-red"><?php echo form_error('customer_mobile'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="customer_email" id="customer_email" value="<?php echo set_value('customer_email'); ?>">
                                <span class="text-red"><?php echo form_error('customer_email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="customer_address" id="customer_address" placeholder=""><?php echo set_value('customer_address'); ?></textarea>
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

