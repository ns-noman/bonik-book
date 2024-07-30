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
            <h1>Purchase Edit</h1>
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
           <form class="form-horizontal" action="<?php echo base_url() . "add-purchase-edit/".$purchase_info->purchase_invoice_id; ?>" method="post" enctype="multipart/form-data"  role="form" id="purchase_form">
                   
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_name" class="col-sm-4 col-form-label">Supplier<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6 col-10">
                                        <select name="supplier_name" class=" form-control select2" id="supplier_name" required style="width: 100%;">
                                                <option value="<?php echo $purchase_info->supplier_id; ?>"><?php echo $purchase_info->supplier_name; ?>
                                                       | <?php echo $purchase_info->supplier_mobile; ?>
                                                </option>
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
                                    <!-- <div class="col-sm-2 col-2">
                                        <a class="btn btn-success" title="Add New Supplier" href="#"><i class="fa fa-plus"></i></a>
                                    </div> -->
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="purchase_date" class="col-sm-4 col-form-label">Purchase Date<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="purchase_date"  id="purchase_date" class=" form-control datepicker" placeholder="yyyy-mm-dd" value="<?php echo $purchase_info->purchase_invoice_date; ?>"  required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="challan_no" class="col-sm-4 col-form-label">Challan No<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="challan_no" placeholder="Invoice No" id="challan_no" value="<?php echo $purchase_info->purchase_challan_no; ?>"  required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="purchase_details" class="col-sm-4 col-form-label">Details</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="purchase_details" id="purchase_details" placeholder=" Details" rows="1"><?php echo $purchase_info->purchase_invoice_detail; ?></textarea>
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
                                            <option value="<?php echo $purchase_info->purchase_payment_type; ?>"><?php echo $purchase_info->purchase_payment_type; ?> Payment</option>
                                            <option value="Cash">Cash Payment</option>
                                            <option value="Bank">Bank Payment</option> 
                                           <!--  <option value="Mobile">Mobile Banking</option> 
                                            <option value="Card">Card Payment</option>  -->
                                        </select>
                                    </div>
                                 
                                </div>
                             </div>
                            
                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Bank">
                            <div class="form-group row">
                                <label for="purchase_bank" class="col-sm-4 col-form-label">Bank Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="purchase_bank" name="purchase_bank" autocomplete="off" placeholder="Bank Info"><?php echo $purchase_info->purchase_payment_info; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Mobile">
                             <div class="form-group row">
                                <label for="purchase_bkash" class="col-sm-4 col-form-label">Mobile Banking Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="purchase_bkash" name="purchase_bkash" autocomplete="off" placeholder="Mobile Banking Info"><?php echo $purchase_info->purchase_payment_info; ?></textarea>
                                </div>
                             </div>
                        </div>

                        <div class="form-group payment-info col-sm-6" style="display: none;" id="Card">
                            <div class="form-group row">
                                <label for="purchase_card" class="col-sm-4 col-form-label">Card Info</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="purchase_card" name="purchase_card" autocomplete="off" placeholder="Card Info"><?php echo $purchase_info->purchase_payment_info; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <table class="table table-bordered table-striped table-hover" id="purchase_table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Code</th>
                            <th>Product<span class="text-red">*</span></th>
                            <th>Qty<span class="text-red">*</span></th>
                            <th>Unit Price<span class="text-red">*</span></th>
                            <th>Unit</th>
                            <th>Discount Amount</th>
                            <th>Discount %</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" class="delete-purchase-row btn btn-danger btn-xs">Delete</button></td>
                            <td>
                                <input type="text" class="form-control" name="product_code_temp" id="product_code" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="product_name_temp" id="purchase_product_name" autocomplete="off">
                                <input type="hidden" class="form-control" name="product_id_temp" id="product_id" autocomplete="off">
                            </td>
                             <td>
                                <input type="number" class="form-control purchase_cal" name="purchase_qty_temp" id="purchase_qty" autocomplete="off" min="1">
                            </td>
                            <td>
                                <input type="number" class="form-control purchase_cal" name="unit_price_temp" id="unit_price" step="0.01">
                            </td>
                             <td>
                                <input type="text" class="form-control" name="unit_temp" id="unit"readonly>
                            </td>
                           
                            <td>
                                <input type="number" class="form-control purchase_cal numtoper" name="purchase_discount_temp" id="purchase_discount" step="0.01" value="0" >
                            </td>
                            <td>
                                <input type="number" class="form-control pertonum" name="discount_percent" id="discount_percent" step="0.01" value="0" >
                            </td>
                            <td>
                                <input type="text" class="form-control" name="total_amount_temp" id="total_amount" readonly>
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary btn-xs" id="purchase-row" value="Add">
                            </td>
                        </tr>

                        <?php if ($purchase_item){ 
                        foreach($purchase_item as $item){
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="purchase_record">
                            </td>
                            <td>
                                <input class="form-control" name="product_code[]" value="<?php echo $item->product_code; ?>" readonly>
                            </td>
                            <td>
                                <input class="form-control" name="product_name[]" value="<?php echo $item->product_name; ?>" readonly>
                                <input type="hidden" class="form-control" name="product_id[]" value="<?php echo $item->product_id; ?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control purchase_cal" name="purchase_qty[]" value="<?php echo $item->purchase_item_quantity;?>" min="1" required>
                            </td>
                            <td>
                                <input type="number" class="form-control purchase_cal" name="unit_price[]" value="<?php echo number_format((float)$item->purchase_item_amount/$item->purchase_item_quantity, 2, '.', '');?>" step="0.01" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="unit[]" value="<?php echo $item->unit_name;?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control purchase_cal numtoper" name="purchase_discount[]" value="<?php echo number_format((float)$item->purchase_item_discount, 2, '.', '');?>" step="0.01">
                            </td>
                            <td>
                                <input type="number" class="form-control pertonum" name="discount_per[]" value="<?php $percent = ($item->purchase_item_discount / $item->purchase_item_amount) * 100;
                                echo number_format((float)$percent, 2, '.', '');

                                 ?>" step="0.01">
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control" name="total_amount[]" value="<?php echo number_format((float)$item->purchase_item_amount-$item->purchase_item_discount, 2, '.', '');?>" readonly>
                            </td>
                        </tr>
                        <?php }} ?>
                        
                    
                    </tbody>
                    <tfoot style="text-align: right; font-size: 14px;">
                        <tr>
                            <td colspan="7" rowspan="7">
                            </td>
                            <td>Total Amount:</td>
                            <td colspan="2">
                                <input type="text" class="form-control" name="gross_total" id="gross_total"value="<?php echo number_format((float)$purchase_info->purchase_total_amount, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Special Discount:</td>
                            <td colspan="4">
                                <input type="number" class="form-control purchase_cal" name="invoice_discount" id="invoice_discount" step="0.01" autocomplete="off" value="<?php echo number_format((float)$purchase_info->purchase_invoice_discount, 2, '.', ''); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Discount:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="total_discount" id="total_discount" value="<?php echo number_format((float)$purchase_info->purchase_total_discount+$purchase_info->purchase_invoice_discount, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                         <tr>
                            <td>Payable Amount:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="grand_total" id="grand_total"value="<?php echo number_format((float)$total, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Previous Due:</td>
                            <td colspan="4">
                                <input type="text" class="form-control purchase_cal" name="previous_due" id="previous_due" value="0" readonly>
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
                                <input type="number" class="form-control purchase_cal" name="paid_amount" id="paid_amount" step="0.01" value="<?php  echo  number_format((float)$paid_amount, 2, '.', ''); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Due:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="sales_due" id="sales_due" value="<?php echo  number_format((float)$due, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Change:</td>
                            <td colspan="4">
                                <input type="text" class="form-control" name="sales_change" id="sales_change" value="0" readonly>
                            </td>
                        </tr>

                        <tr>
                           <td colspan="10"><button type="submit" class="btn btn-primary">Save</button></td>
                           <td></td> 
                        </tr>
                    </tfoot>
                </table>
                </form>
        </div>
      </div>
    </section>
    <!-- /.content -->

