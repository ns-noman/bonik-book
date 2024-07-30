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
            <h1>Manage User Privilege of <?php echo $user_info->user_name; ?></h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        
        <form class="form-horizontal" action="<?php echo base_url().'save-user-privilege/'.$user_info->user_id;?>" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
              <?php echo $success_msg; ?>
                  <?php echo $error_msg; ?>
                <div class="row">
                  
                    <?php 
                    $privilege_set = array_column($user_privilege, 'menu_name');
                    if($menus){ foreach ($menus as $menu) {?>
                    <div class="col-sm-3">
                    <div class="form-check">
                       <?php if(in_array($menu->menu_name, $privilege_set)){ ?>
                          <input class="form-check-input checkAll" type="checkbox" name="menu_id[]" value="<?php echo $menu->menu_id; ?>"  checked>
                        <?php }else{ ?>
                           <input class="form-check-input checkAll" type="checkbox" name="menu_id[]" value="<?php echo $menu->menu_id; ?>">
                         <?php } ?>
                          <label class="form-check-label"><b><?php echo $menu->menu_name; ?></b></label><br>
                       

                            <?php $submenu = $this->inventory_model->get_sub_menu($menu->menu_id); 
                             if($submenu){ foreach ($submenu as $sub) {
                            ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php if(in_array($sub->menu_name, $privilege_set)){ ?>
                                <input class="form-check-input" type="checkbox" name="menu_id[]" value="<?php echo $sub->menu_id; ?>" checked>
                                <?php }else{ ?>
                                   <input class="form-check-input" type="checkbox" name="menu_id[]" value="<?php echo $sub->menu_id; ?>">
                                   <?php } ?>
                                <label class="form-check-label"><?php echo $sub->menu_name; ?></label><br>
                              
                              <?php }} ?>
                          </div>
                          <br><br>  
                    </div>
                <?php }} ?>

                   

                </div> 
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-info">Save</button>
            </div>
        </form>
         
      </div>

     
    </section>
    <!-- /.content -->

