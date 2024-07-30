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
            <h1>All Package List</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Admin</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>

           <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th>Package Name</th>
                        <th>Package Price</th>
                        <th>Duration (Month)</th>
                        <!-- <th>Package Unit</th> -->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($edit_info){ ?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url() . "update-vendor-package/" . $edit_info->package_id; ?>" method="post" enctype="multipart/form-data"  role="form">
                    <td>0.</td>
                    <td>
                      <input type="text" class="form-control" name="package_name" id="package_name" placeholder="Package Name" value="<?php echo $edit_info->package_name; ?>" required ><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_name'); ?></span>
                    </td>
                    <td>
                      <input type="number" class="form-control numbersOnly" name="package_price" id="package_price" placeholder="Package Price" value="<?php echo $edit_info->package_price; ?>" required min="1" step="0.01"><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_price'); ?></span>
                    </td>
                    <td>
                      <input type="number" class="form-control numbersOnly" name="package_duration" id="package_duration" placeholder="Package Duration" required  step="0.01" value="<?php echo $edit_info->package_duration; ?>"><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_duration'); ?></span>
                    </td>
                    <!-- <td>
                        <select class="form-control select2" id="package_unit" name="package_unit" style="width: 100%;" required>
                          <option value="<?php echo $edit_info->package_unit; ?>"><?php echo $edit_info->package_unit; ?></option>
                          <option value="Monthly">Monthly</option>
                          <option value="Yearly">Yearly</option>
                          <option value="Bill">Bill</option>
                        </select>
                      <span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_unit'); ?></span>
                    </td> -->
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i></button>
                    </td>
                    </form>
                  </tr>
                  <?php }else{?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url()?>add-vendor-package" method="post" enctype="multipart/form-data"  role="form">
                    <td>0.</td>
                    <td>
                      <input type="text" class="form-control" name="package_name" id="package_name" placeholder="Package Name" required ><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_name'); ?></span>
                    </td>
                    <td>
                      <input type="number" class="form-control numbersOnly" name="package_price" id="package_price" placeholder="Package Price" required min="1" step="0.01"><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_price'); ?></span>
                    </td>
                    <td>
                      <input type="number" class="form-control numbersOnly" name="package_duration" id="package_duration" placeholder="Package Duration" required step="0.01"><span style="color:red;"> *</span>
                      <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_duration'); ?></span>
                    </td>
                    <!-- <td>
                        <select class="form-control select2" id="package_unit" name="package_unit" style="width: 100%;" required>
                          <option value="">Select Project</option>
                          <option value="Monthly">Monthly</option>
                          <option value="Yearly">Yearly</option>
                          <option value="Bill">Bill</option>
                        </select>
                        <span style="color:red;"> *</span>
                        <span style="color:red;font-size: 10px;float: left;"><?php echo form_error('package_unit'); ?></span>
                    </td> -->
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs"><i class="fas fa-save"></i></button>
                    </td>
                    </form>
                  </tr>
                  <?php } ?>

                    <?php
                    if ($package){ 
                    $x = 1;
                    foreach($package as $packages){
                        ?>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $packages->package_name;?></td>
                        <td><?php echo $packages->package_price;?></td>
                        <td><?php echo $packages->package_duration;?></td>
                        <!-- <td><?php echo $packages->package_unit;?></td> -->
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-package/" . $packages->package_id; ?>">
                                Edit
                            </a>
                        </td>
                        </tr>
                    <?php } }else{ echo "No data  found!";}?>
                    </tbody>
                </table>
          
        </div>
        
      </div> 
    </section>
    <!-- /.content -->

