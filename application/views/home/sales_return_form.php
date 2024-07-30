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
            <h1>Sales Return</h1>
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
           <form class="form-horizontal" action="<?php echo base_url() . "add-sales-return/".$sales_info->sales_invoice_id; ?>" method="post" enctype="multipart/form-data"  role="form" id="sales_form">
                   
                        <div class="row">
                            <div class="col-sm-4">
                                    <label class="col-form-label">Customer : <?php echo $sales_info->customer_name; ?></label>
                            </div>

                             <div class="col-sm-4">
                                    <label class="col-form-label">sales Date : <?php echo $sales_info->sales_invoice_date; ?></label>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="return_date" class="col-sm-4 col-form-label">Return Date<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="return_date"  id="return_date" class=" form-control datepicker" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" required autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                    <label class="col-form-label">sales Invoice : <?php echo $sales_info->sales_invoice_no; ?></label>
                            </div>

                            <div class="col-sm-4">
                                    <label class="col-form-label">Details : <?php echo $sales_info->sales_invoice_detail; ?></label>
                            </div>

                            <div class="col-sm-4" id="payment_from_1">
                                    <label for="payment_type" class="col-form-label">Payment Info : <?php echo $sales_info->sales_payment_type; ?> Payment. <?php echo $sales_info->sales_payment_info; ?></label>
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

                
                <table class="table table-bordered table-striped table-hover" id="sales_return_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Sales Qty</th>
                            <th>Stock</th>
                            <th>Return Qty</th>
                            <th>Unit</th>
                            <th>Sales Price (Include Discount, VAT)</th>
                            <th>Return Price<span class="text-red">*</span></th>
                            <!-- <th>Discount Amount</th> -->
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if ($sales_item){ 
                            $x = 1;
                        foreach($sales_item as $item){
                            $unit_discount = $item->sales_item_discount / $item->sales_item_quantity;
                            
                            $return_rate = $item->sales_item_rate-$unit_discount;
                            $unit_vat = ($item->sales_item_vat_per / 100) * $return_rate;
                            $qty = $item->sales_item_quantity-$item->sales_return_item_quantity;
                            if($qty > 0){
                        ?>
                        <tr>
                            <td>
                                <?php echo $x++; ?>
                            </td>
                            <td>
                                <input class="form-control" name="product_code[]" value="<?php echo $item->product_code; ?>" readonly>
                            </td>
                            <td>
                                <input class="form-control" name="product_name[]" value="<?php echo $item->product_name; ?>" readonly>
                                <input type="hidden" class="form-control" name="product_id[]" value="<?php echo $item->product_id; ?>" readonly>
                                <input type="hidden" class="form-control" name="sales_item[]" value="<?php echo $item->sales_item_id; ?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="sales_qty[]" value="<?php echo $qty;?>" min="1" required readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control purchase_cal" name="stock_qty[]" value="<?php echo $item->product_stock;?>" min="1" required readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="return_qty[]" value="0" min="0" max="<?php echo $item->sales_item_quantity-$item->sales_return_item_quantity;?>">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="unit[]" value="<?php echo $item->unit_name;?>" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="unit_price[]" value="<?php echo number_format((float)$return_rate+$unit_vat, 2, '.', '');?>" step="0.01" required readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="sales_return_rate[]" value="<?php echo number_format((float)$return_rate+$unit_vat, 2, '.', '');?>" step="0.01" required max="<?php echo $return_rate+$unit_vat;?>">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control" name="total_amount[]" value="0" readonly>
                            </td>
                        </tr>
                        <?php }} } ?>
                        
                    
                    </tbody>
                    <tfoot style="text-align: right; font-size: 14px;">
                        <tr>
                            <td colspan="8" rowspan="7">
                            </td>
                            <td>Total Amount:</td>
                            <td>
                                <input type="text" class="form-control" name="gross_total" id="gross_total"value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Special Discount:
                                <?php 
                                echo "(".number_format((float)$discount_rate, 2, '.', '')."%)";
                                 ?>
                            </td>
                            <td colspan="4">
                                <input type="number" class="form-control sales_cal" name="invoice_discount" id="invoice_discount" step="0.01" value="0" readonly>
                                <input type="hidden" name="discount_per" id="discount_per" value="<?php echo $discount_rate; ?>" >
                               <!--  <input type="hidden" name="vat_per" id="vat_per" value="<?php //echo $item->sales_item_vat_per; ?>" > -->
                            </td>
                        </tr>
                        <tr>
                            <td>Paid Amount:</td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="paid_amount" id="paid_amount" step="0.01" value="<?php  echo  number_format((float)$paid_amount, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Current Due:</td>
                            <td>
                                <input type="number" class="form-control sales_cal" name="due" id="due" step="0.01" value="<?php  echo  number_format((float)$due, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Due Amount:</td>
                            <td>
                                <input type="text" class="form-control" name="sales_due" id="sales_due" value="<?php  echo  number_format((float)$due, 2, '.', ''); ?>" readonly>
                            </td>
                        </tr> -->
                        <tr>
                            <td>Return Amount:</td>
                            <td>
                                <input type="text" class="form-control" name="return_amount" id="return_amount" value="0" readonly>
                            </td>
                        </tr>

                        <tr>
                            <td>Return Payment<span class="text-red">*</span>:</td>
                            <td>
                                <input type="number" class="form-control" name="return_payment" id="return_payment" step="0.01" max="<?php  echo  $paid_amount; ?>" required autocomplete="off" readonly>
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

