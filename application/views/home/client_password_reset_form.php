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
            <h1>Client Re-Set Password </h1>
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
           <form class="form-horizontal" action="<?php echo base_url(); ?>reset-client-password" method="post" enctype="multipart/form-data"  role="form">
        
         <div class="form-group">
        <label for="email" class="col-sm-4 control-label">Email Address <!--<span style="color:red;">*</span>--></label>
        <div class="col-sm-6">
        <input type="hidden" name="client_id" value="<?php echo $client_info->client_id;?>">
          <input type="text" class="form-control" name="email" id="email" value="<?php echo $client_info->client_email; ?>" readonly>
          <span class="text-red"><?php echo form_error('email'); ?></span>
        </div>
        </div>
        
         <div class="form-group">
        <label for="password" class="col-sm-4 control-label">Password <span style="color:red;">*</span></label>
        <div class="col-sm-6">
          <input type="password" class="form-control" name="password" id="password" required>
          <span class="text-red">Minimum 6 Character and Special Characters (e.g : #, $, @, _) required<?php echo form_error('password'); ?></span>
        </div>
        </div>
        
        <div class="form-group">
        <label for="repassword" class="col-sm-4 control-label">Retype password <span style="color:red;">*</span></label>
        <div class="col-sm-6">
          <input type="password" class="form-control" name="repassword" id="repassword" required>
          <span class="text-red"><?php echo form_error('repassword'); ?></span>
        </div>
        </div>
        <br>
        
        <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
          <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      
      </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

