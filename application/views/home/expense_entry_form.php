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
          <div class="col-md-6">
            <h1>Add Expense</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <?php echo $success_msg; ?>
        <?php echo $error_msg; ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-expense" method="post" enctype="multipart/form-data"  role="form" id="exp_form">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="payment_date" class="col-md-12 col-form-label">
                
                            Cash in Hand : <?php echo number_format($closing_cash, 2, '.', ',');?><br>
                            Cash at Bank : <?php echo number_format($closing_bank, 2, '.', ',');?><br>
                            Total Account Balance : <?php echo number_format($total_closing_balance, 2, '.', ',');?><br><br>
                             <input type="hidden" class="form-control" name="cash_balance" id="cash_balance" value="<?php echo $closing_cash;?>">
                            <input type="hidden" class="form-control" name="bank_balance" id="bank_balance" value="<?php echo $closing_bank;?>">
                            </label>
                            <label for="tdate " class="col-md-5 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control datepicker" name="tdate" id="tdate" value="<?php echo date('Y-m-d'); ?>" required placeholder="yyyy-mm-dd">
                                <span class="text-red"><?php echo form_error('tdate'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="description" class="col-md-5 col-form-label">Expense To <i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="description" id="description" required value="<?php echo set_value('description'); ?>">
                                <span class="text-red"><?php echo form_error('description'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="mobile" class="col-md-5 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                 <input type="text" class="form-control" name="mobile" id="mobile" required value="<?php echo set_value('mobile'); ?>">
                                <span class="text-red"><?php echo form_error('mobile'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="expense_type" class="col-md-5 col-form-label">Expense Type <i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                <select name="expense_type" class=" form-control select2" id="expense_type" required style="width: 100%;">
                                    <option value="">Select...</option>
                                    <?php if ($expense_head_info){
                                        foreach ($expense_head_info as $expense) {
                                    ?>
                                    <option value="<?php echo $expense->expense_head_id; ?>">
                                        <?php echo $expense->expense_head_name; ?>
                                    </option>
                                <?php }} ?>
                                </select>
                                <span class="text-red"><?php echo form_error('expense_type'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="amount" class="col-md-5 col-form-label">Amount <i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                <input type="number" class="form-control" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" required step="0.01" min="0">
                                <span class="text-red"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="payment_method" class="col-md-5 col-form-label">Payment Method<i class="text-danger">*</i></label>
                            <div class="col-md-7">
                                <select name="payment_method" class=" form-control" id="payment_method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                    
                                </select>
                                <span class="text-red"><?php echo form_error('payment_method'); ?></span>
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

