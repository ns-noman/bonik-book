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
            <h1>Manage Manufacturer/Brand</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php if ($edit_info) { ?>
        <form class="form-horizontal" action="<?php echo base_url() . "update-manufacturer/" . $edit_info->man_id; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="man_name" id="man_name" value="<?php echo $edit_info->man_name; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_mobile" class="col-sm-4 col-form-label">Mobile No.</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="man_mobile" id="man_mobile" value="<?php echo $edit_info->man_mobile; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="man_email" id="man_email" value="<?php echo $edit_info->man_email; ?>">
                                <span class="text-red"><?php echo form_error('man_email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="man_address" id="man_address" placeholder=""><?php echo $edit_info->man_address; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
              <center><button type="submit" class="btn btn-info">Update</button></center>
            </div>
        </form>
        <?php  }else{ ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-manufacturer" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_name" class="col-sm-4 col-form-label">Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="man_name" id="man_name" value="<?php echo set_value('man_name'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_mobile" class="col-sm-4 col-form-label">Mobile No.</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="man_mobile" id="man_mobile" value="<?php echo set_value('man_mobile'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="man_email" id="man_email" value="<?php echo set_value('man_email'); ?>">
                                <span class="text-red"><?php echo form_error('man_email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="man_address" class="col-sm-4 col-form-label">Present Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="man_address" id="man_address" placeholder=""><?php echo set_value('man_address'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
              <center><button type="submit" class="btn btn-info">Submit</button></center>
            </div>
        </form>
         <?php } ?>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Manufacturer/Brand List</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
                <?php echo $error_msg; ?>
                <?php if ($manufacturer_info){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>All Manufacturer List</caption>
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($manufacturer_info as $info){
                        ?>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $info->man_name;?></td>
                        <td><?php echo $info->man_mobile;?></td>
                        <td><?php echo $info->man_email;?></td>
                        <td><?php echo $info->man_address;?></td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-manufacturer/" . $info->man_id; ?>">
                                Edit
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

