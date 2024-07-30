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
        <div class="card-header">
          <form class="form-horizontal" action="<?php echo base_url() . "supplierwise-ledger"; ?>" method="post" enctype="multipart/form-data"  role="form">

            <div class="form-group row">
              
              <label for="supplier_name" class="col-sm-1 col-form-label">Supplier</label>
              <div class="col-sm-4">
                 <input type="text" name="supplier_name" class=" form-control" placeholder="Supplier Name" id="supplier_name"  autocomplete="off" required>
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
                    <?php if($client_info->header_image){ ?>
                    <img src="<?php echo base_url().$client_info->header_image; ?>" class="user-image" alt="Logo" width="100">
                    <?php }else{ ?>
                      <h3><?php echo $client_info->business_name; ?></h3>
                    <?php } ?>
                    <h4><i class="fa fa-map-marker-alt"></i> <?php echo $client_info->client_address.", ☎ ".$client_info->client_mobile; ?></h4>
                    <h5> Print Date: <?php echo date("d/m/Y"); ?> </h5>
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
                                $discount = (int)$ledger->purchase_invoice_discount+(int)$ledger->purchase_total_discount;
                                $total = (int)$ledger->purchase_total_amount-$discount;
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

