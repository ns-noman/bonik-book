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
            <h1>Supplier Payment</h1>
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
          <form class="form-horizontal" action="<?php echo base_url();?>view-supplier-invoice-payment" method="post" enctype="multipart/form-data"  role="form">
            <div class="form-group row">
              <label for="supplier_name" class="col-sm-2 col-form-label">Supplier<i class="text-danger">*</i></label>
              <div class="col-sm-6">
                <select name="supplier_name" class=" form-control select2" id="supplier_name" required style="width: 100%;">
                    <option value="">Select Supplier</option>
                    <?php if ($supplier_info){
                        foreach ($supplier_info as $supplier) {
                    ?>
                    <option value="<?php echo $supplier->supplier_id; ?>">
                        <?php echo $supplier->supplier_name; ?> | 
                        <?php echo $supplier->supplier_mobile; ?> | 
                        <?php echo $supplier->supplier_org; ?>
                    </option>
                <?php }} ?>
                </select>
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">View</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

