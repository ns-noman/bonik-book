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
            <div class="row">
               <div class="col-sm-6">
                <label for="supplier_name" class="col-form-label">supplier<i class="text-danger">*</i></label>
                <select name="supplier_name" class=" form-control select2" id="supplier_name" required style="width: 100%;">
                    <option value="">Select Supplier</option>
                    <?php if ($supplier_info){
                        foreach ($supplier_info as $supplier) {
                    ?>
                    <option value="<?php echo $supplier->supplier_id; ?>">
                        <?php echo $supplier->supplier_name; ?> | 
                        <?php echo $supplier->supplier_mobile; ?>
                    </option>
                <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <label for="from_date" class="col-form-label">From<i class="text-danger">*</i></label>
                <input type="text" name="from_date" id="from_date" class="form-control datepicker" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>" required="" autocomplete="off">
              </div>
              <div class="col-sm-3">
                <label for="to_date" class="col-form-label">To<i class="text-danger">*</i></label>
                <input type="text" name="to_date" id="to_date" class="form-control datepicker" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>" required="" autocomplete="off">
              </div>
          </div>
          <div class="row">
             <div class="col-sm-12">
                <br>
                <center><button type="submit" class="btn btn-primary">View</button></center>
              </div>
          </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

