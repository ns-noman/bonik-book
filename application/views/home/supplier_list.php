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
            <h1>Manage Supplier</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Supplier List</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
                <?php echo $error_msg; ?>
                <?php if ($supplier_info){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>All supplier List</caption>
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th style="min-width:200px">Name</th>
                        <th style="min-width:200px">Organization</th>
                        <th>Mobile No.</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <!--<th>Balance</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($supplier_info as $info){
                        ?>
                        <tr>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $info->supplier_name;?></td>
                        <td><?php echo $info->supplier_org;?></td>
                        <td><?php echo $info->supplier_mobile;?></td>
                        <td><?php echo $info->supplier_email;?></td>
                        <td><?php echo $info->supplier_address;?></td>
                        <!--<td><?php //echo $info->supplier_balance;?></td>-->
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-supplier/" . $info->supplier_id; ?>">
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

