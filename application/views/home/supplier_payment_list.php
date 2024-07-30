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
            <h1>Supplier Payment List</h1>
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
           <?php if ($payment_info){ ?>
            <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>All Supplier Payment List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Supplier</th>
                  <th>Organization</th>
                  <th>Payment Amount</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  $total = 0;
                  foreach($payment_info as $info){
                    $total += $info->supplier_payment_amount;
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->supplier_payment_date));?>
                    </td>
                    <td>
                      <?php echo $info->supplier_name;?>
                    </td>
                    <td>
                      <?php echo $info->supplier_org;?>
                    </td>
                     <td align="right">
                      <?php echo number_format((float)$info->supplier_payment_amount, 2, '.', '');?>
                    </td>
                    
                    <td>
                      
                     <a class="btn btn-success btn-xs" href="<?php echo base_url() . "supplier-payment-detail/". $info->supplier_payment_id; ?>">
                        Detail</a>
                        
                      </a> 
                    </td>
                  </tr>
                  
                  <?php } ?>
                  <tr style="font-weight:bold; background-color: #dfdfdf;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td  align="right">Total</td>
                    <td  align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                    <td></td>
                  </tr>
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

