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
            <h1>Sales Invoice List</h1>
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
            <?php if ($sales_info){ ?>
              <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>All Sales Invoice List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Invoice#</th>
                  <th style="min-width: 200px;">Customer</th>
                  <th>Total Amount</th>
                  <th>Discount Amount</th>
                  <th>Payable Amount</th>
                  <th>Paid Amount</th>
                  <th>Due</th>
                  <th style="min-width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  foreach($sales_info as $info){
                    $discount = $info->sales_invoice_discount+$info->sales_total_discount;
                    $total = $info->sales_total_amount-$discount+$info->sales_total_vat;
                    $paid_amount = $info->sales_amount_paid+$info->sales_advance_payment;
                    $due = $total-$paid_amount;
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->sales_invoice_date));?>
                    </td>
                    <td>
                      <?php echo $info->sales_invoice_no;?>
                    </td>
                    <td>
                      <?php echo $info->customer_name;?>
                    </td>
                     <td>
                      <?php echo number_format((float)$info->sales_total_amount+$info->sales_total_vat, 2, '.', '');?>
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
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "sales-detail/". $info->sales_invoice_id; ?>">
                         view
                      </a>
                      <!-- <a href="<?php //echo base_url() . "sales-return/" . $info->sales_invoice_id; ?>" i class="btn btn-danger btn-xs"> Return</a> -->
                      <!-- <a href="<?php //echo base_url() . "sales-edit/" . $info->sales_invoice_id; ?>"  class="btn btn-danger btn-xs"> Edit</a> -->
                      <a class="btn btn-success btn-xs" href="<?php echo base_url() . "print-sales-detail/". $info->sales_invoice_id; ?>">
                        <i class="fa fa-print"></i>
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
    </section>
    <!-- /.content -->

