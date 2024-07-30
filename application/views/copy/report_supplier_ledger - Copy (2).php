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
            <h1>Supplier Ledger</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            Supplier Ledger Entry<hr>

        <?php echo $success_msg; ?>
        <?php echo $error_msg; ?>
        <form class="form-horizontal" action="<?php echo base_url();?>save-supplier-transaction" method="post" enctype="multipart/form-data"  role="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="tdate" class="col-sm-2 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="tdate" id="tdate" value="<?php echo date('Y-m-d'); ?>" required placeholder="yyyy-mm-dd">
                                <span class="text-red"><?php echo form_error('tdate'); ?></span>
                            </div>
                             <label for="supplier_name" class="col-sm-2 col-form-label">Supplier <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                 <input type="text" name="supplier_name" class=" form-control" placeholder="Supplier Name" id="supplier_name"  autocomplete="off" >
                                <input type="hidden" name="supplier_id" class=" form-control" id="supplier_id" autocomplete="off">
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label for="ac_type " class="col-sm-2 col-form-label">Account Type <i class="text-danger">*</i></label>
                            <div class="col-sm-2">
                                <select name="ac_type" class=" form-control select2" id="ac_type" required style="width: 100%;">
                                    <option value="">Select ...</option>
                                    <option value="Debit(+)">Debit(+)</option>
                                    <option value="Credit(-)">Credit(-)</option>
                                </select>
                                <span class="text-red"><?php echo form_error('ac_type'); ?></span>
                            </div>
                            <label for="amount" class="col-sm-2 col-form-label">Amount <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" required step="0.01" min="0">
                                <span class="text-red"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                    </div> 
                </div>
                
            </div>
            <div class="card-footer">
              <center><button type="submit" class="btn btn-info">Submit</button></center>
            </div>
        </form>
      </div>
      <div class="card">
        Supplier Ledger Report<hr>
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "supplierwise-ledger"; ?>" method="post" enctype="multipart/form-data"  role="form" id="purchase_form">

            <div class="form-group row">
              <label for="from_date" class="col-sm-1 col-form-label">From</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="from_date" id="from_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="to_date" class="col-sm-1 col-form-label">To</label>
              <div class="col-sm-2">
                 <input type="text" class="form-control datepicker" name="to_date" id="to_date"  autocomplete="off" placeholder="yyyy-mm-dd">
              </div>
              <label for="supplier_name" class="col-sm-1 col-form-label">Supplier</label>
              <div class="col-sm-3">
                 <input type="text" name="supplier_name" class=" form-control" placeholder="Supplier Name" id="supplier_name"  autocomplete="off" >
                  <input type="hidden" name="supplier_id" class=" form-control" id="supplier_id" autocomplete="off">
              </div>
              <div class="col-sm-2">
                 <button type="submit" class="btn btn-info">Search</button>
              </div>
            </div>

           
          </form>
          <a class="btn btn-warning btn-sm pull-right" href="#" onclick="printDiv('printableArea')" >Print</a>
        </div>
        <div class="card-body table-responsive">
            <?php echo $success_msg; ?>
            <?php echo $error_msg; ?>
            <div id="printableArea" style="margin-left:2px;">
                <?php if($purchase_info){ ?>
                <div class="text-center">
                     <center>
                            <table width="70%" cellpadding="10">
                                <tr>
                                    <td align="right"> 
                                        <?php if ($client_info->header_image) { ?>
                                            <img src="<?php echo base_url().$client_info->header_image; ?>" height="100">
                                        <?php }else{ ?>
                                            <h3><?php echo $client_info->client_name; ?></h3>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <h3><?php echo $client_info->client_name; ?></h3>
                                        <p style="font-size:16px;"><?php echo $client_info->client_address; ?> <br>Contact: <?php echo $client_info->client_mobile; ?></p>
                                    </td>
                                </tr>
                            </table>
                            </center>
                </div>
                <div class="table-responsive">
                    <center><h4><?php echo $title; ?></h4></center>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #dfdfdf; text-align: center;">
                                    <th width="100">Date</th>
                                    <th width="200">Supplier</th>
                                    <th width="200">Invoice#</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                                <?php 
                                $balance = 0;
                                $debit_total = 0;
                                $credit_total = 0;
                                //$balance_total = 0;
                                foreach ($purchase_info as $ledger) {
                                $discount = $ledger->purchase_invoice_discount+$ledger->purchase_total_discount;
                                $total = $ledger->purchase_total_amount-$discount;
                                $paid = $ledger->purchase_amount_paid;
                                $debit_total += $paid;
                                $credit_total += $total;
                                    
                                ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($ledger->purchase_invoice_date));?></td>  
                                    <td><?php echo $ledger->supplier_name;?></td>  
                                    <td><a target="_blank" href="<?php echo base_url() . "purchase-detail/". $ledger->purchase_invoice_id; ?>"><?php echo $ledger->purchase_invoice_no;?></a></td>
                                    <td align="right">0</td>     
                                    <td align="right"><?php echo number_format((float)$total, 2, '.', '');?></td>
                                    <td align="right"><?php echo number_format((float)$balance -= $total, 2, '.', '');?></td>
                                </tr>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($ledger->purchase_invoice_date));?></td>  
                                    <td><?php echo $ledger->supplier_name;?></td>  
                                    <td><a target="_blank" href="<?php echo base_url() . "purchase-detail/". $ledger->purchase_invoice_id; ?>"><?php echo $ledger->purchase_invoice_no;?></a></td>
                                    <td align="right"><?php echo number_format((float)$paid, 2, '.', '');?></td>
                                    <td align="right">0</td>  
                                    <td align="right"><?php echo number_format((float)$balance += $paid, 2, '.', '');?></td>
                                </tr>
                            <?php } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="3">Grand Total:</td>  
                                    <td align="right"><?php echo number_format((float)$debit_total, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$credit_total, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$debit_total-$credit_total, 2, '.', '');?></td>  
                                </tr>
                            </thead>
                            <tbody>
                                 
                            </tbody>
                        </table>
                            
                        <br>
                    Print By <?php echo $this->session->userdata('user_name'); ?> | 
                    Print Date <?php echo date("d/m/Y"); ?> 
                </div>
            <?php } ?>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

