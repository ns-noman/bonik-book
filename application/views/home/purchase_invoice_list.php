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
            <h1>Purchase Invoice List</h1>
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
           <?php if ($purchase_info){ ?>
            <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>All Purchase Invoice List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Invoice#</th>
                  <th>Supplier</th>
                  <th>Amount</th>
                  <th>Discount</th>
                  <th>Payable</th>
                  <th>Paid</th>
                  <th>Due</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  foreach($purchase_info as $info){
                    $discount = $info->purchase_invoice_discount+$info->purchase_total_discount;
                    $total = $info->purchase_total_amount-$discount;
                    $paid_amount = $info->purchase_amount_paid+$info->purchase_advance_payment;
                    $due = $total-$paid_amount;
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->purchase_invoice_date));?>
                    </td>
                    <td>
                      <?php echo $info->purchase_invoice_no;?>
                    </td>
                    <td>
                      <?php echo $info->supplier_name;?>
                    </td>
                     <td>
                      <?php echo number_format((float)$info->purchase_total_amount, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo number_format((float)$discount, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo number_format((float)$total, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo number_format((float)$paid_amount, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo number_format((float)$due, 2, '.', '');?>
                      
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "purchase-detail/". $info->purchase_invoice_id; ?>">
                         view
                      </a>
                      <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-purchase-detail/". $info->purchase_invoice_id; ?>">
                        <i class="fa fa-print"></i></a>
                       <!--  <a href="<?php //echo base_url() . 'purchase-edit/' . $info->purchase_invoice_id; ?>" class="btn btn-danger btn-xs">Edit</a> -->
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

