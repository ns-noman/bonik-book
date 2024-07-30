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
            <h1>Walking Customer List</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Walking Customer List</h3>
        </div>
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
                <?php echo $error_msg; ?>
                <?php if ($customer_info){ ?>
                <table class="table table-bordered table-striped table-hover" id="example1">
                <caption>Walking Customer List</caption>
                    <thead>
                    <tr>
                        <th style="width:12px;">SL.</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 1;
                    foreach($customer_info as $info){
                        ?>
                        <td style="width:12px;"><?php echo $x++; ?>.</td>
                        <td><?php echo $info->customer_name;?></td>
                        <td><?php echo $info->customer_mobile;?></td>
                        </tr>
                    <?php }  ?>
                    </tbody>
                </table>
                <?php }else{ echo "No data  found!";} ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

