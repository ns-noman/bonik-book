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
            <h1>Bank Transaction</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php echo $success_msg; ?>
        <?php echo $error_msg; ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-bank-transaction" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="tdate " class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control datepicker" name="tdate" id="tdate" value="<?php echo date('Y-m-d'); ?>" required placeholder="yyyy-mm-dd">
                                <span class="text-red"><?php echo form_error('tdate'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="ac_type " class="col-sm-5 col-form-label">Account Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="ac_type" class=" form-control select2" id="ac_type" required style="width: 100%;">
                                    <option value="">Select ...</option>
                                    <option value="Debit(+)">Debit(+)</option>
                                    <option value="Credit(-)">Credit(-)</option>
                                </select>
                                <span class="text-red"><?php echo form_error('ac_type'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="bank_ac" class="col-sm-5 col-form-label">Bank A/C <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="bank_ac" class=" form-control select2" id="bank_ac" required style="width: 100%;">
                                    <option value="">Select...</option>
                                    <option value="Default" selected>Default</option>
                                    <?php if ($bank_info){
                                        foreach ($bank_info as $bank) {
                                    ?>
                                    <option value="<?php echo $bank->bank_id; ?>">
                                        <?php echo $bank->bank_name; ?> | 
                                        <?php echo $bank->bank_ac_number; ?>
                                    </option>
                                <?php }} ?>
                                </select>
                                <span class="text-red"><?php echo form_error('bank_ac'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="withdraw_deposit_id " class="col-sm-5 col-form-label">Withdraw / Deposite ID <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="withdraw_deposit_id" id="withdraw_deposit_id" value="<?php echo set_value('withdraw_deposit_id'); ?>" required>
                                <span class="text-red"><?php echo form_error('withdraw_deposit_id'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="amount" class="col-sm-5 col-form-label">Amount <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" required step="0.01" min="0">
                                <span class="text-red"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="description" class="col-sm-5 col-form-label">Description</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" name="description" id="description"><?php echo set_value('description'); ?></textarea>
                                <span class="text-red"><?php echo form_error('description'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="card-footer">
              <center><button type="submit" class="btn btn-info">Save</button></center>
            </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

