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
        <h1>Menus</h1>
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
                  <th>Menu Name<span class="text-red">*</span></th>
                  <th>Parent Menu</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($edit_info){ ?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url() . "update-menu/" . $edit_info->menu_id; ?>" method="post" enctype="multipart/form-data"  role="form">
                    <td>Update</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="menu_name" id="menu_name" value="<?php echo $edit_info->mname; ?>" required >
                      <span class="text-red"><?php echo form_error('menu_name'); ?></span>
                    </td>
                    <td>
                      <select name="parent_menue" class=" form-control select2" id="parent_menue" style="width: 100%;">
                          <option value="<?php echo $edit_info->parent_menu_id; ?>"><?php echo $edit_info->pname; ?></option>
                          <option value="">Parent</option>

                          <?php if ($menus) {
                            foreach ($menus as $item) {?>
                          <option value="<?php echo $item->menu_id; ?>"><?php echo $item->mname; ?></option>
                        <?php }} ?>
                        </select>
                      <span class="text-red"><?php echo form_error('menu_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs">Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php }else{?>
                  <tr>
                  <form class="form-horizontal" action="<?php echo base_url()?>save-menu" method="post" enctype="multipart/form-data"  role="form">
                    <td>New</td>
                    <td>
                      <input type="text" class="form-control form-control-sm" name="menu_name" id="menu_name" required style="width: 100%;">
                      <span class="text-red"><?php echo form_error('menu_name'); ?></span>
                    </td>
                    <td>
                      <select name="parent_menue" class=" form-control select2" id="parent_menue" style="width: 100%;">
                          <option value="">Parent</option>
                          <?php if ($menus) {
                            foreach ($menus as $item) {?>
                          <option value="<?php echo $item->menu_id; ?>"><?php echo $item->mname; ?></option>
                        <?php }} ?>
                        </select>
                      <span class="text-red"><?php echo form_error('menu_name'); ?></span>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-primary btn-xs">Save</button>
                    </td>
                    </form>
                  </tr>
                  <?php } ?>

                <?php
                if ($menus){ 
                  $x = 1;
                  foreach($menus as $info){
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo $info->mname;?>
                    </td>
                    <td>
                      <?php echo $info->pname;?>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-menu/". $info->menu_id; ?>">
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