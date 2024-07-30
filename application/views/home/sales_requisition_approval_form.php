<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>
      <style type="text/css">
    .table .form-control {
        height: 25px;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    }

     .table>thead>tr>th {
    text-align: center;
    }
</style>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Sales Requisition Approval</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="card">
        <div class="card-body  table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
          <form class="form-horizontal" action="<?php echo base_url() . "add-sales-requisition-approval/".$sales_info->sales_req_id ; ?>" method="post" enctype="multipart/form-data"  role="form" id="sales_form">
                   
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Name : <?php echo $sales_info->customer_name; ?> <br>
                                        Contact : <?php echo $sales_info->customer_mobile; ?></label>
                            </div>

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Organization : <?php echo $sales_info->customer_organization; ?>
                            </div>

                           

                            <div class="col-4 col-sm-4">
                                    <label class="form-label">Invoice# : <?php echo $sales_info->sales_req_no; ?><br>
                                    Issue Date: <?php echo date("d/m/Y", strtotime($sales_info->req_issue_date)); ?>
                                </label>
                            </div>

                        </div>

                        
                
                <table class="table table-bordered table-striped table-hover" id="sales_req_table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Code</th>
                            <th>Product<span class="text-red">*</span></th>
                            <th>Stock QTY</th>
                            <th>Qty<span class="text-red">*</span></th>
                            <th>MRP<span class="text-red">*</span></th>
                            <th>Unit</th>
                            <th>VAT%</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" class="delete-row btn btn-danger btn-xs">Delete</button></td>
                            <td>
                                <input type="text" class="form-control" name="product_code_temp" id="sales_product_code" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="product_name_temp" id="sales_product_name" autocomplete="off">
                                <input type="hidden" class="form-control" name="product_id_temp" id="product_id" autocomplete="off">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="stock_qty_temp" id="stock_qty" readonly min="1">
                            </td>
                            <td>
                                <input type="number" class="form-control sales_req_cal stock_cal" name="sales_qty_temp" id="sales_qty" autocomplete="off" min="1">
                            </td>
                            <td>
                                <input type="number" class="form-control sales_req_cal" name="mrp_temp" id="mrp" step="0.01" readonly>
                            </td>
                             <td>
                                <input type="text" class="form-control" name="unit_temp" id="unit"readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_req_cal" name="sales_vat_temp" id="sales_vat" step="0.01" value="0" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="total_amount_temp" id="total_amount" readonly>
                            </td>
                            <td>
                                <input type="button" class="req-row btn btn-primary btn-xs" value="Add">
                            </td>
                        </tr>
                        <?php if ($sales_item){ 
                            foreach($sales_item as $item){
                             $vat = ($item->req_item_vat_per / 100 )* $item->req_item_amount;
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="record">
                            </td>
                            <td>
                                <input class="form-control" name="product_code[]" value="<?php echo $item->product_code; ?>" readonly>
                            </td>
                            <td>
                                <input class="form-control" name="product_name[]" value="<?php echo $item->product_name; ?>" readonly>
                                <input type="hidden" class="form-control" name="product_id[]" value="<?php echo $item->product_id; ?>" readonly>
                            </td>
                            
                            <td>
                                <input type="text" class="form-control" name="stock_qty[]" value="<?php echo $item->product_stock;?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_req_cal stock_cal" name="sales_qty[]" value="<?php echo $item->req_item_quantity;?>" min="1" required>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_req_cal" name="mrp[]" value="<?php echo number_format((float)$item->req_item_amount/$item->req_item_quantity, 2, '.', '');?>" step="0.01" required readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="unit[]" value="<?php echo $item->unit_name; ?>" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sales_vat[]" value="<?php echo $item->req_item_vat_per; ?>" readonly>
                            </td>
                            <td colspan="2">
                                    <input type="text" class="form-control" name="total_amount[]" value="<?php echo $item->req_item_amount+$vat;?>" readonly>
                            </td>
                        </tr>
                        <?php }} ?>
                    
                    </tbody>
                    <tfoot style="text-align: right; font-size: 14px;">
                        <tr>
                            <td colspan="7" rowspan="3">
                            </td>
                            <td>Total Amount:</td>
                            <td colspan="2">
                                <input type="text" class="form-control" name="gross_total" id="gross_total" value="<?php echo number_format((float)$sales_info->req_total_amount, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Total VAT:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="total_vat" id="total_vat" value="<?php echo number_format((float)$sales_info->req_total_vat, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                       
                         <tr>
                            <td>Payable Amount:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="grand_total" id="grand_total" value="<?php echo number_format((float)$total, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        
                        

                        <tr>
                           <td colspan="11"><button type="submit" class="btn btn-primary">Approve</button></td>
                           <td></td> 
                        </tr>
                    </tfoot>
                </table>
                </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

