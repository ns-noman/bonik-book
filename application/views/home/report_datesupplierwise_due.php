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
            <h1>Supplier Due Report</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "supplierwise-due"; ?>" method="post" enctype="multipart/form-data"  role="form">
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
                <?php if($supplier_info){ ?>
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
                                    <th width="20">SL.</th>
                                    <th>Supplier</th>
                                    <th>Mobile#</th>
                                    <th>Bill Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                </tr>
                                <?php 
                                $balance_total = 0;
                                $bill_total = 0;
                                $paid_sum = 0;
                                $x = 1;
                                foreach ($supplier_info as $supplier) {
                                    $due = $this->inventory_model->get_datewise_supplier_due($supplier->supplier_id, $from_date, $to_date);
                                    $purchase_total = $due->purchase_total_amount-($due->purchase_invoice_discount+$due->purchase_total_discount)
                                                -$due->purchase_invoice_return_total;
                                      $paid_total = $due->purchase_amount_paid+$due->purchase_advance_payment-$due->purchase_invoice_return_amount;
                                      $due_total = $purchase_total- $paid_total;

                                        $balance_total += $due_total;
                                        $bill_total += $purchase_total;
                                        $paid_sum += $paid_total; 
                               if ($due_total!= 0) {
                                ?>
                                <tr>
                                    <td><?php echo $x++;?></td>  
                                    <td><?php echo $supplier->supplier_name;?></td>  
                                    <td><?php echo $supplier->supplier_mobile;?></td>
                                    <td align="right"><?php echo number_format((float)$purchase_total, 2, '.', '');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format((float)$paid_total, 2, '.', '');
                                        ;?>
                                    </td>
                                    <td align="right"><?php echo number_format((float)$due_total, 2, '.', '');
                                        ;?>
                                    </td>     
                                </tr>
                            <?php } } ?>
                                <tr style="font-weight:bold; background-color: #dfdfdf;">
                                    <td align="right" colspan="3">Grand Total:</td>  
                                    <td align="right"><?php echo number_format((float)$bill_total, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$paid_sum, 2, '.', '');?></td>  
                                    <td align="right"><?php echo number_format((float)$balance_total, 2, '.', '');?></td>  
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

