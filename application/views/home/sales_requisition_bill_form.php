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
            <h1>Sales Requisition Invoice</h1>
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
          <form class="form-horizontal" action="<?php echo base_url() . "add-sales"; ?>" method="post" enctype="multipart/form-data"  role="form" id="sales_form">
                   
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="customer_name" class="col-sm-4 col-form-label">Cutomer Name<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6 col-10">
                                        <input type="text" name="customer_name" class=" form-control" placeholder="Customer Name" id="customer_name" value="<?php echo $sales_info->customer_name; ?>" required autocomplete="off">
                                        <input type="hidden" name="customer_id" class=" form-control" id="customer_id" required autocomplete="off" value="<?php echo $sales_info->customer_id; ?>">
                                        <input type="hidden" name="customer_org" class=" form-control" id="customer_org" value="<?php echo $sales_info->customer_organization; ?>">
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="sales_date" class="col-sm-4 col-form-label">Sales Date<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="sales_date"  id="sales_date" class=" form-control datepicker" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customer_mobile" class=" form-control" placeholder="Customer Mobile" id="customer_mobile" value="<?php echo $sales_info->customer_mobile; ?>" required autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="sales_details" class="col-sm-4 col-form-label">Details</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="sales_details" id="sales_details" placeholder=" Details" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                              <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label">Payment Type <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select name="paytype" id="paytype" class="form-control select2" required  autocomplete="off" style="width: 100%;">
                                            <option value="Cash">Cash Payment</option>
                                            <option value="Bank">Bank Payment</option> 
                                            <!-- <option value="Mobile">Mobile Banking</option> 
                                            <option value="Card">Card Payment</option> --> 
                                        </select>
                                    </div>
                                 
                                </div>
                             </div>
                            
                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Bank">
                            <div class="form-group row">
                                <label for="sales_bank" class="col-sm-4 col-form-label">Bank Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="sales_bank" name="sales_bank" autocomplete="off" placeholder="Bank Info"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Mobile">
                             <div class="form-group row">
                                <label for="sales_bkash" class="col-sm-4 col-form-label">Mobile Banking Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="sales_bkash" name="sales_bkash" autocomplete="off" placeholder="Mobile Banking Info"></textarea>
                                </div>
                             </div>
                        </div>

                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Card">
                            <div class="form-group row">
                                <label for="sales_card" class="col-sm-4 col-form-label">Card Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="sales_card" name="sales_card" autocomplete="off" placeholder="Card Info"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <table class="table table-bordered table-striped table-hover" id="sales_table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Code</th>
                            <th>Product<span class="text-red">*</span></th>
                            <th>Stock QTY</th>
                            <th>Qty<span class="text-red">*</span></th>
                            <th class="tp">Purchase Price</th>
                            <th>MRP<span class="text-red">*</span></th>
                            <th>Unit</th>
                            <th>VAT%</th>
                            <th>Discount Amount</th>
                            <th>Discount %</th> 
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
                                <input type="number" class="form-control sales_cal stock_cal" name="sales_qty_temp" id="sales_qty" autocomplete="off" min="1">
                            </td>
                            <td class="tp">
                                <input type="number" class="form-control sales_cal" name="tp_temp" id="tp" step="0.01" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="mrp_temp" id="mrp" step="0.01" readonly>
                            </td>
                             <td>
                                <input type="text" class="form-control" name="unit_temp" id="unit"readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="sales_vat_temp" id="sales_vat" step="0.01" value="0" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal snumtoper" name="sales_discount_temp" id="sales_discount" step="0.01" value="0"  onkeyup="snumber_to_persentage()">
                            </td>
                            <td>
                                <input type="number" class="form-control spertonum sales_cal" name="sales_discount_percent_temp" id="sales_discount_percent" step="0.01" value="0" onkeyup="spersentage_to_number()">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="total_amount_temp" id="total_amount" readonly>
                            </td>
                            <td>
                                <input type="button" class="sales-row btn btn-primary btn-xs" value="Add">
                            </td>
                        </tr>
                        <?php if ($sales_item){ 
                            foreach($sales_item as $item){
                            $vat = ($item->req_app_item_vat_per / 100) * $item->req_app_item_amount;
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
                                <input type="number" class="form-control sales_cal stock_cal" name="sales_qty[]" value="<?php echo $item->req_app_item_quantity;?>" min="1" required>
                            </td>
                            <td class="tp"><input type="text" class="form-control" name="tp[]" value="<?php echo $item->product_unit_price;?>" readonly></td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="mrp[]" value="<?php echo number_format((float)$item->req_app_item_amount/$item->req_app_item_quantity, 2, '.', '');?>" step="0.01" required readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="unit[]" value="<?php echo $item->unit_name; ?>" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sales_vat[]" value="<?php echo $item->req_app_item_vat_per; ?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="sales_discount[]" value="0" step="0.01" onkeyup="snumber_to_persentage()">
                            </td>
                            <td><input type="number" class="form-control sales_cal" name="sales_discount_percent[]" value="0" step="0.01" onkeyup="spersentage_to_number()" readonly></td>
                            <td colspan="2">
                                    <input type="text" class="form-control" name="total_amount[]" value="<?php echo number_format((float)$item->req_app_item_amount+$sales_info->req_total_vat, 2, '.', '');?>" readonly>
                            </td>
                        </tr>
                        <?php }} ?>
                    
                    </tbody>
                    <tfoot style="text-align: right; font-size: 14px;">
                        <tr>
                            <td colspan="10" rowspan="9">
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
                            <td>Special Discount:</td>
                            <td colspan="4">
                                <input type="number" class="form-control sales_cal" name="invoice_discount" id="invoice_discount" step="0.01" autocomplete="off" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Discount:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="total_discount" id="total_discount" value="0" readonly>
                            </td>
                        </tr>
                         <tr>
                            <td>Payable Amount:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="grand_total" id="grand_total" value="<?php echo number_format((float)$total, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Previous Due:</td>
                            <td colspan="4">
                                <input type="text" class="form-control sales_cal" name="previous_due" id="previous_due" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Net Payable:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="net_total" id="net_total" value="0" readonly>
                            </td>
                        </tr> -->
                        <tr>
                            <td>Paid Amount:</td>
                            <td colspan="4">
                                <input type="number" class="form-control sales_cal" name="paid_amount" id="paid_amount" step="0.01" value="0" autocomplete="off" min="0">
                            </td>
                        </tr>
                        <tr>
                            <td>Due:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="sales_due" id="sales_due"  value="<?php echo  number_format((float)$total, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                         <tr>
                            <td>Previous Balance:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="pprevious_balance" id="pprevious_balance"  value="<?php echo  number_format((float)$customer_balance, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Paid from Balance:</td>
                            <td colspan="4">
                                <input type="number" class="form-control" name="pbalance_payment" id="pbalance_payment" step="0.01" value="0" autocomplete="off" min="0">
                            </td>
                        </tr>

                        <tr>
                           <td colspan="13"><button type="submit" class="btn btn-primary">Submit</button></td>
                           <td></td> 
                        </tr>
                    </tfoot>
                </table>
                </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

