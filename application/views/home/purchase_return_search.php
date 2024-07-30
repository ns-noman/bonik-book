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
            <h1>Purchase Return</h1>
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

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Search</span>
            </div>
            <input type="text" class="form-control" placeholder="Name or Invoice" id="purchase_return_search" name="purchase_return_search">
          </div>

          <div id="invoice_list"></div>
        </div>
      </div>
    </section>
    <!-- /.content -->

