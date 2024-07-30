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
            <h1>Sales Return List</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
       
        <div class="card-body table-responsive">
          <div class ="row">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
           <?php if ($sales_return_info){ ?>
            <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>All Sales Return List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Invoice#</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Payment</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  foreach($sales_return_info as $info){
                   
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->sales_return_date));?>
                    </td>
                    <td>
                      <?php echo $info->sales_invoice_no;?>
                    </td>
                    <td>
                      <?php echo $info->customer_name;?>
                    </td>
                     <td>
                      <?php echo number_format((float)$info->sales_return_total, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo number_format((float)$info->sales_return_amount, 2, '.', '');?>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "sales-return-detail/". $info->sales_return_id; ?>">
                         Detail
                      </a>
                    </td>
                  </tr>
                  
                  <?php } ?>
                  </tbody>
                <!--<tfoot>
                <tr>
                  <th>
                    footer
                  </th>
                </tr>
                </tfoot>-->
              </table>
            <?php }else{ echo "No data  found!";} ?>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

