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
            <h1>Client List</h1>
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
          <?php if ($clients){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>All Client List</caption>
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="min-width:150px">Client Name</th>
                        <th>Business Name</th>
                        <th>Mobile No.</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Package</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($clients as $client){
                        ?>
                        <tr>
                        <td><?php echo $x++; ?>.</td>
                        <td><?php echo $client->client_name;?></td>
                        <td><?php echo $client->business_name;?></td>
                        <td><?php echo $client->client_mobile;?></td>
                        <td><?php echo $client->client_email;?></td>
                        <td><?php echo $client->client_address;?></td>
                        <td><?php echo $client->package_name;?></td>
                        <td>
                          <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "edit-client/" . $client->client_id; ?>">
                              <i class="glyphicon glyphicon-pencil"></i>
                              Edit
                          </a>
                          <?php if($client->client_status == 1){ ?>
                          <a class="btn btn-success btn-xs" href="<?php echo base_url() . "deactivate-client/" . $client->client_id; ?>">
                              <i class="glyphicon glyphicon-eye-open"> Activated</i>
                          </a>
                          <?php } else if($client->client_status == 0){ ?>
                          <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "activate-client/" . $client->client_id; ?>">
                              <i class="glyphicon glyphicon-eye-close"> Deactivated</i>
                          </a>
                          <?php } ?>

                          <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "reset-client-password/" . $client->client_id; ?>">
                              <i class="glyphicon glyphicon-lock"></i>  
                              Reset Password                                         
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

