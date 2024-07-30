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
        <h1>Units</h1>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <?php echo $success_msg; ?>
  <?php echo $error_msg; ?>
		<div class="card card">
            <div class="card-body table-responsive">
            
              <table class="table table-bordered table-striped table-hover" id="example1">
                <thead>
                <tr>
				          <th width="30">SL.</th>
                  <th>Unit</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($edit_info){ ?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url() . "update-unit/" . $edit_info->unit_id; ?>" method="post" enctype="multipart/form-data"  role="form">
                    <td>Update</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="unit_name" id="unit_name" value="<?php echo $edit_info->unit_name; ?>" required >
                      <span class="text-red"><?php echo form_error('unit_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs">Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php }else{?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url()?>save-unit" method="post" enctype="multipart/form-data"  role="form">
                    <td>New</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="unit_name" id="unit_name" required style="width: 100%;">
                      <span class="text-red"><?php echo form_error('unit_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs">Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php } ?>

                <?php
                if ($unit_info){ 
                  $x = 1;
                  foreach($unit_info as $info){
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo $info->unit_name;?>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-unit/". $info->unit_id; ?>">
                        <i class="fas fa-pen"></i> Edit
                      </a>
                    </td>
                  </tr>
    				      
                  <?php } } ?>
                  </tbody>
              </table>
            
            </div>
          </div>
		 
</section>