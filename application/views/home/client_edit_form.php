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
          <div class="col-sm-12">
            <h1>New Client</h1><small>Entry Form<b class="box-title" style="color:red;"> ( * ) Marked Fields are Required.</b></small>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <form class="form-horizontal" id="" action="<?php echo base_url() . "update-client/" . $clients_info->client_id; ?>" method="post" enctype="multipart/form-data"  role="form">
      <div class="card">
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <div class="row">
            <div class="form-group row col-sm-6">
            <label for="client_name" class="col-sm-4 col-form-label">Client Name<span 
              class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="client_name" id="client_name" value="<?php echo $clients_info->client_name; ?>" required>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('client_name'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="business_name" class="col-sm-4 col-form-label">Business Name<span 
              class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="business_name" id="business_name" value="<?php echo $clients_info->business_name; ?>" required>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('business_name'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="client_email" class="col-sm-4 col-form-label">Email Address<span 
              class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="client_email" id="client_email" value="<?php echo $clients_info->client_email; ?>" disabled>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('client_email'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="client_mobile" class="col-sm-4 col-form-label">Mobile No.<span 
              class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="client_mobile" id="client_mobile" value="<?php echo $clients_info->client_mobile; ?>" required>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('client_mobile'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="client_address" class="col-sm-4 col-form-label">Address</label>
            <div class="col-sm-6">
              <textarea class="form-control" name="client_address" id="client_address" placeholder=""><?php echo $clients_info->client_address; ?></textarea>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('client_address'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="package_id" class="col-sm-4 col-form-label">Package<span 
              class="text-red">*</span></label>
            <div class="col-sm-6">
              <select class="form-control select2" id="package_id" name="package_id" required>
                <option value="<?php echo $clients_info->package_id; ?>"><?php echo $clients_info->package_name; ?></option>
                <?php  if($package){ foreach($package as $info) { ?>
                  <option value="<?php echo $info->package_id; ?>"><?php echo $info->package_name; ?></option>
                <?php } }else{ ?>
                <option value="">No Package</option>
                <?php } ?>
              </select>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_id'); ?></span>
            </div>
          </div>
					<div class="form-group row col-sm-6">
            <label for="exp_date" class="col-sm-4 col-form-label">Package Price</label>
            <div class="col-sm-6">
              <input type="number" class="form-control  pull-right" id="package_price" name="package_price" value="<?php echo $clients_info->package_price;?>" required autocomplete="off">
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('exp_date'); ?></span>
            </div>
          </div>
					<div class="form-group row col-sm-6">
            <label for="reg_date" class="col-sm-4 col-form-label">Start Date<span class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control  pull-right datepicker" id="reg_date" name="reg_date" value="<?php echo $clients_info->registration_date; ?>" data-date-format='yyyy-mm-dd' placeholder="yyyy-mm-dd" required autocomplete="off" readonly>
							<span style="color:red;font-size: 10px;float: left;"><?php echo form_error('reg_date'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="exp_date" class="col-sm-4 col-form-label">Expire Date<span class="text-red">*</span></label>
            <div class="col-sm-6">
              <input type="text" class="form-control  pull-right" id="exp_date" name="exp_date" value="<?php echo $clients_info->expire_date; ?>" required autocomplete="off" readonly>
              <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('exp_date'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="package_id" class="col-sm-4 col-form-label">Logo</label>
            <div class="col-sm-6">
              <input type="file" class="form-control" name="logo" id="logo" value="<?php echo set_value('logo'); ?>">
              <input type="hidden" class="form-control" name="old_logo" id="old_logo" value="<?php echo $clients_info->header_image; ?>">
              <span style="color:red;font-size: 10px;float: left;">Please use a png, jpg or jpeg File. Max File size 2MB.<?php echo form_error('logo'); ?></span>
            </div>
          </div>
          <div class="form-group row col-sm-6">
            <label for="package_id" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-6">
              <img src="<?php echo base_url().$clients_info->header_image; ?>" onerror="this.onerror=null;this.src='<<?php echo base_url(); ?>assets/dist/img/boxed-bg.jpg';" width="100">
            </div>
          </div>
        </div>
          
        </div>
        <div class="card-footer">
          <center>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </center>
            
          
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->

