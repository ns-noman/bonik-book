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
          <div class="col-sm-12">
            <h1>Client List Expire In Next One Month</h1>
						<br>
						<?php if ($expire_client){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>Client List Expire In Next One Month</caption>
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="min-width:150px">Client Name</th>
                        <th>Business Name</th>
                        <th>Mobile No.</th>
                        <th>Start Date</th>
                        <th>Expire Date</th>
                        <th>Address</th>
                        <th>Package</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($expire_client as $client){
                        ?>
                        <tr>
                        <td><?php echo $x++; ?>.</td>
                        <td><?php echo $client->client_name;?></td>
                        <td><?php echo $client->business_name;?></td>
                        <td><?php echo $client->client_mobile;?></td>
                        <td><?php echo $client->client_email;?></td>
                        <td><?php echo $client->registration_date;?></td>
                        <td><?php echo $client->expire_date;?></td>
                        <td><?php echo $client->package_name;?></td>
                        <td>
                          <a class="btn btn-info btn-xs" href="<?php echo base_url() . "reniew-client/" . $client->client_id; ?>">
                              <i class="glyphicon glyphicon-eye-open"> Reniew</i>
                          </a>
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
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- <div class="card">
        <div class="card-header">
          <h3 class="card-title">Admin</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          Start creating your amazing application!
        </div>
        <div class="card-footer">
          Footer
        </div>
      </div> -->
    </section>
    <!-- /.content -->

