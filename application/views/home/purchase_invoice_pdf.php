<!-- Main content -->
    <div class="col-md-12">

    <section class ="invoice">
      
      <table cellspacing="0" cellpadding="0" width="350" style="font-size:14px">
          
          <tr>
            <td colspan="4" align="center">
            <?php if($client_info->header_image){ ?>
            <img src="<?php echo base_url().$client_info->header_image; ?>" class="user-image" alt="Logo" width="50">
            <?php }else{ ?>
              <h3><?php echo $client_info->business_name; ?></h3>
            <?php } ?>
              <br><?php echo $client_info->client_address.", ☎ ".$client_info->client_mobile; ?><br>
              <p style="border-bottom: 0.5px solid #000;">Purchase Invoice</p>
            </td>
          </tr>
          <tr>
          <td align="left"><b>Invoice No</b></td>
          <td align="left"><b>: <?php echo $purchase_info->purchase_invoice_no; ?></b></td>
          <td align="right"><b>Date</b></td>
          <td align="left"><b>: <?php echo date("d/m/Y", strtotime($purchase_info->purchase_invoice_date)); ?></b>
          </td>
          </tr>
           <tr>
            <td align="left"><b>Name</b></td>
            <td colspan="3" ><b>: <?php echo $purchase_info->supplier_name; ?></b></td>
          </tr>
          <tr>
            <td align="left"><b>Contact</b></td>
            <td align="left" colspan="3"><b>: <?php echo $purchase_info->supplier_mobile; ?></b></td>
          </tr>
      </table>
     

          <table  cellspacing="0" cellpadding="2" width="350" style="font-size:14px">

           <tr>
              <th  style="border-bottom:solid 0.5px #000; text-align:center;">SL</th>
              <th  style="border-bottom:solid 0.5px #000; text-align:center;">Particulars</th>
              <th  style="border-bottom:solid 0.5px #000; text-align:center;">Rate</th>
              <th  style="border-bottom:solid 0.5px #000; text-align:center;">QTY</th>
              <th  style="border-bottom:solid 0.5px #000; text-align:center;">Amount</th>
            </tr>

            <?php if ($purchase_item){ 
                    $x = 1;
                    foreach($purchase_item as $item){
                        ?>
            <tr>
              <td><?php echo $x++; ?>.</td>
              <td>
                <?php echo $item->product_name; ?>
                  
              </td>
              <td align="right"><?php echo number_format($item->purchase_item_amount/$item->purchase_item_quantity, 2, '.', ',');?></td>
              <td align="right"><?php echo $item->purchase_item_quantity;?></td>
              <td align="right"><?php echo number_format($item->purchase_item_amount, 2, '.', ',');?></td>
            </tr>
            <?php }}else{ echo "No data  found!";} ?>
            <tr>
                <td colspan="4" align="right" style="border-top:solid 0.5px #000;"><b>Total Amount:</b></td>
                <td align="right" style="border-top:solid 0.5px #000;"><b><?php echo number_format($purchase_info->purchase_total_amount, 2, '.', ','); ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="right" style="border-bottom:solid 0.5px #000;"><b>Discount Amount:</b></td>
                <td align="right" style="border-bottom:solid 0.5px #000;"><b><?php echo number_format($discount, 2, '.', ','); ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="right" style="border-bottom:solid 0.5px #000;"><b>Payable Amount:</b></td>
                <td align="right" style="border-bottom:solid 0.5px #000;"><b><?php echo number_format($total, 2, '.', ','); ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="right"><b>Paid Amount:</b></td>
                <td align="right"><b><?php echo  number_format($paid_amount, 2, '.', ','); ?></b>
                </td>
            </tr>
           
            <tr>
                <td colspan="4" align="right"><b>Balance Due</b></td>
                <td align="right"><b><?php echo  number_format($due, 2, '.', ','); ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="border-top:solid 0.5px #000;"><b>In Word: <?php echo $in_word; ?> Only.</b>
                </td>
            </tr>

          </table>

      
     
      
      
      <table width="350" style="font-size:14px">
              <tr>
                    <td>
                    
                    </td>
                    
                    <td>
                    
                    </td>

              </tr>
              <tr>
              <td>
                Prepared By <?php echo $this->session->userdata('user_name'); ?>
              </td>
              
              <td align="right">
               Print Date : <?php echo date("d/m/Y"); ?>
              </td>
              </tr>
              <tr>
                  <td colspan="3" align="right">Powered By: A & A</td>
              </tr>
              <tr>
                  <td colspan="3" align="center"><b>*** Have a Nice Day ***</b></td>
              </tr>
              
          </table>
            
         </section>
    </div>
    <!-- /.content -->
   
 <script type="text/javascript">
window.onload = function() { window.print(); }

window.onafterprint = function(event) {
    window.history.back();
};
</script>


