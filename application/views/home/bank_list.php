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
            <h1>Manage Bank</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php if ($edit_info) { ?>
        <form class="form-horizontal" action="<?php echo base_url() . "update-bank/" . $edit_info->bank_id; ?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-4 col-form-label">Bank Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $edit_info->bank_name; ?>" required>
                                <span class="text-red"><?php echo form_error('bank_name'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="ac_name" class="col-sm-4 col-form-label">A/C Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ac_name" id="ac_name" value="<?php echo $edit_info->bank_ac_name; ?>" required>
                                <span class="text-red"><?php echo form_error('ac_name'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="ac_number" class="col-sm-4 col-form-label">A/C Number <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ac_number" id="ac_number" value="<?php echo $edit_info->bank_ac_number; ?>" required>
                                <span class="text-red"><?php echo form_error('ac_number'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="bank_branch" class="col-sm-4 col-form-label">Branch <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?php echo $edit_info->bank_branch; ?>" required>
                                <span class="text-red"><?php echo form_error('bank_branch'); ?></span>
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
        <form class="form-horizontal" action="<?php echo base_url();?>save-bank" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-4 col-form-label">Bank Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo set_value('bank_name'); ?>" required>
                                <span class="text-red"><?php echo form_error('bank_name'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="ac_name" class="col-sm-4 col-form-label">A/C Name <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ac_name" id="ac_name" value="<?php echo set_value('ac_name'); ?>" required>
                                <span class="text-red"><?php echo form_error('ac_name'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="ac_number" class="col-sm-4 col-form-label">A/C Number <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ac_number" id="ac_number" value="<?php echo set_value('ac_number'); ?>" required>
                                <span class="text-red"><?php echo form_error('ac_number'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="bank_branch" class="col-sm-4 col-form-label">Branch <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?php echo set_value('bank_branch'); ?>" required>
                                <span class="text-red"><?php echo form_error('bank_branch'); ?></span>
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
          <h3 class="card-title">All bank List</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
                <?php echo $error_msg; ?>
                <?php if ($bank_info){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th>Name</th>
                        <th>A/C Name</th>
                        <th>A/C Number</th>
                        <th>Branch</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($bank_info as $info){
                        ?>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $info->bank_name;?></td>
                        <td><?php echo $info->bank_ac_name;?></td>
                        <td><?php echo $info->bank_ac_number;?></td>
                        <td><?php echo $info->bank_branch;?></td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-bank/" . $info->bank_id; ?>">
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

