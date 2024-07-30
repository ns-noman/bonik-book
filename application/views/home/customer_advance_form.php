<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>
      <style type="text/css">
          .table-bordered td, .table-bordered th {
                border: 1px solid #000;
            }

            .table thead th {
                border: 1px solid #000;
            }
      </style>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Advance Payment / Receive to Customer</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        <div class="col-sm-6">
        <div class="card">
        <?php echo $success_msg; ?>
        <?php echo $error_msg; ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-customer-transaction" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="tdate" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="tdate" id="tdate" value="<?php echo date('Y-m-d'); ?>" required placeholder="yyyy-mm-dd">
                                <span class="text-red"><?php echo form_error('tdate'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">
                             <label for="supplier_name" class="col-sm-4 col-form-label">Customer <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                 <input type="text" name="customer_name" class=" form-control" placeholder="Customer Name" id="customer_namef"  autocomplete="off" >
                                <input type="hidden" name="customer_id" class=" form-control" id="customer_idf" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="ac_type " class="col-sm-4 col-form-label">Payment Type <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="ac_type" class=" form-control select2" id="ac_type" required style="width: 100%;">
                                    <option value="">Select ...</option>
                                    <option value="Debit(+)">Deposit</option>
                                    <option value="Credit(-)">Withdraw</option>
                                </select>
                                <span class="text-red"><?php echo form_error('ac_type'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="payment_method " class="col-sm-4 col-form-label">Payment Method <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="payment_method" class=" form-control select2" id="payment_method" required style="width: 100%;">
                                    <option value="">Select ...</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                                <span class="text-red"><?php echo form_error('payment_method'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label">Amount <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" required step="0.01" min="1">
                                <span class="text-red"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                    </div> 
                                                
            </div>
            <div class="card-footer">
              <center><button type="submit" class="btn btn-info">Save</button></center>
            </div>
        </form>
      </div>
  </div>

  <div class="col-sm-6">
       <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <label class="col-form-label" >Customer Blanace : </label> <span id="balance"></span>
                </div>
            </div>
        </div>
  </div>

    </div>
    </section>
    <!-- /.content -->

