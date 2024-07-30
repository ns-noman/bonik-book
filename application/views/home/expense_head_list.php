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
            <h1>Expense Head</h1>
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
          <div class="row">
          <table id="example2" class="table table-bordered table-striped table-hover example2">
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Expense Head <span class="text-red">*</span></th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($edit_info){ ?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url() . "update-expense-head/" . $edit_info->expense_head_id; ?>" method="post" enchead="multipart/form-data"  role="form">
                    <td>Update</td>
                    <td>
                      <input head="text" class="form-control" name="expense_head_name" id="expense_head_name" value="<?php echo $edit_info->expense_head_name; ?>" required >
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('expense_head_name'); ?></span>
                    </td>
                    <td>
                    <button head="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i> Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php }else{?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url()?>save-expense-head" method="post" enchead="multipart/form-data"  role="form">
                    <td>New</td>
                    <td>
                      <input head="text" class="form-control" name="expense_head_name" id="expense_head_name" required style="width: 100%;">
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('expense_head_name'); ?></span>
                    </td>
                    <td>
                    <button head="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i> Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php } ?>

                <?php
                if ($expense_head_info){ 
                  $x = 1;
                  foreach($expense_head_info as $info){
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo $info->expense_head_name;?>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-expense-head/". $info->expense_head_id; ?>">
                        <i class="glyphicon glyphicon-pen"></i> Edit
                      </a>
                    </td>
                  </tr>
                  
                  <?php } } ?>
                  </tbody>
              </table>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

