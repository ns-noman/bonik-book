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
            <h1>Re-Set Password </h1>
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
          <form class="form-horizontal" action="<?php echo base_url() . "update-client-password/".$update_user->user_id; ?>" method="post" enctype="multipart/form-data"  role="form">
        
         <div class="form-group">
        <label for="email" class="col-sm-4 control-label">Login Username <!--<span style="color:red;">*</span>--></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="email" id="email" value="<?php echo $update_user->user_email; ?>"  readonly>
          <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('email'); ?></span>
        </div>
        </div>
        
         <div class="form-group">
        <label for="password" class="col-sm-4 control-label">Password <span style="color:red;">*</span></label>
        <div class="col-sm-6">
          <input type="password" class="form-control" name="password" id="password" required>
          <span style="color:red;font-size: 10px;float: left;">Minimum 6 Character and Special Characters (e.g : #, $, @, _) required<?php echo form_error('password'); ?></span>
        </div>
        </div>
        
        <div class="form-group">
        <label for="repassword" class="col-sm-4 control-label">Retype password <span style="color:red;">*</span></label>
        <div class="col-sm-6">
          <input type="password" class="form-control" name="repassword" id="repassword" required>
          <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('repassword'); ?></span>
        </div>
        </div>
        <br>
        
        <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="reset" class="btn btn-danger">Reset</button>
          
        </div>
        </div>
      
      </form>
        </div>
        
      </div> 
    </section>
    <!-- /.content -->

