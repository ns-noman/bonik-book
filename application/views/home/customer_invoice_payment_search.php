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
            <h1>Customer Payment</h1>
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
          <form class="form-horizontal" action="<?php echo base_url();?>view-customer-invoice-payment" method="post" enctype="multipart/form-data"  role="form">
            <div class="form-group row">
              <label for="customer_name" class="col-sm-2 col-form-label">Cutomer Name<i class="text-danger">*</i>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="customer_name" class=" form-control" placeholder="Customer Name" id="customer_name" value="" required autocomplete="off">
                    <input type="hidden" name="customer_id" class=" form-control" id="customer_id" required autocomplete="off">
                </div>
              <!--<label for="customer_name" class="col-sm-2 col-form-label">Customer<i class="text-danger">*</i></label>
              <div class="col-sm-6">
                <select name="customer_name" class=" form-control select2" id="customer_name" required style="width: 100%;">
                    <option value="">Select Customer</option>
                    <?php if ($customer_info){
                        foreach ($customer_info as $customer) {
                    ?>
                    <option value="<?php echo $customer->customer_id; ?>">
                        <?php echo $customer->customer_name; ?> | 
                        <?php echo $customer->customer_mobile; ?>
                    </option>
                <?php }} ?>
                </select>
              </div>-->
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">View</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

