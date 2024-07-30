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
            <h1>Manage User</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php if ($edit_info) { ?>
        <form class="form-horizontal" action="<?php echo base_url() . "update-user/" . $edit_info->user_id; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
              <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="user_name" id="user" value="<?php echo $edit_info->user_name; ?>" required>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_mobile" class="col-sm-4 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="user_mobile" id="user_mobile" value="<?php echo $edit_info->user_mobile; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_email" class="col-sm-4 col-form-label">Email <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $edit_info->user_email; ?>" required>
                                <span class="text-red"><?php echo form_error('user_email'); ?></span>
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
        <form class="form-horizontal" action="<?php echo base_url();?>save-user" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="user_name" id="user" value="<?php echo set_value('user_name'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_mobile" class="col-sm-4 col-form-label">Mobile No.<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="user_mobile" id="user_mobile" value="<?php echo set_value('user_mobile'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label for="user_email" class="col-sm-4 col-form-label">Email <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo set_value('user_email'); ?>" required>
                                <span class="text-red"><?php echo form_error('user_email'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="password" value="" required>
                                <span class="text-red">Minimum 6 Character and Special Characters (e.g : #, $, @, _) Required<?php echo form_error('password'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="repassword" class="col-sm-4 col-form-label">Re-Type Password <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="repassword" id="repassword" value="" required>
                                <span class="text-red"><?php echo form_error('repassword'); ?></span>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </form>
         <?php } ?>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All User List</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
                <?php echo $error_msg; ?>
                <?php if ($user_info){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>All User List</caption>
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th style="min-width:200px">Name</th>
                        <th>Mobile No.</th>
                        <th>Email Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($user_info as $info){
                        ?>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $info->user_name;?></td>
                        <td><?php echo $info->user_mobile;?></td>
                        <td><?php echo $info->user_email;?></td>
                        <td>
                             <?php if($info->user_status == 1){ ?>
                          <a class="btn btn-success btn-xs" href="<?php echo base_url() . "set-user-status/0/" . $info->user_id; ?>">
                              <i class="glyphicon glyphicon-eye-open"> Activated</i>
                          </a>
                          <?php } else if($info->user_status == 0){ ?>
                          <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "set-user-status/1/" . $info->user_id ?>">
                              <i class="glyphicon glyphicon-eye-close"> Deactivated</i>
                          </a>
                          <?php } ?>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-user/" . $info->user_id; ?>">
                                Edit
                            </a>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "set-user-privilege/" . $info->user_id; ?>">
                                Set Privilege
                            </a>

                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "client-password/" . $info->user_id; ?>">
                                Change Pasword
                            </a>
                           
                        </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php }else{ echo "No data  found!";} ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

