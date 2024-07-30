<!-- Main content -->
    <div class="col-md-12">

    <section class ="invoice">
      
      <table cellspacing="0" cellpadding="0" width="100%"style="font-size:14px;">
          
          <tr>
            <td colspan="8" align="center">
            <?php if($client_info->header_image){ ?>
            <img src="<?php echo base_url().$client_info->header_image; ?>" class="user-image" alt="Logo" width="50">
            <?php }else{ ?>
              <h3><?php echo $client_info->business_name; ?></h3>
            <?php } ?>
              <br><?php echo $client_info->client_address.", ☎ ".$client_info->client_mobile; ?><br>
              <p style="border-bottom: 0.5px solid #000;">Purchase Challan</p>
            </td>
          </tr>
          <tr>
          <td><b>Invoice No</b></td>
          <td>: <?php echo $purchase_info->purchase_invoice_no; ?></td>
          <td><b>Name</b></td>
          <td>: <?php echo $purchase_info->supplier_name; ?></td>
          <td><b>Contact</b></td>
          <td>: <?php echo $purchase_info->supplier_mobile; ?></td>
          <td><b>Date</b></td>
          <td>: <?php echo date("d/m/Y", strtotime($purchase_info->purchase_invoice_date)); ?></td>
          </tr>
        
      </table>
     

          <table  cellspacing="0" cellpadding="2" width="100%"style="font-size:14px;">

           <tr>
              <th  style="border-bottom:solid 0.5px #000; border-top:solid 0.5px #000; text-align:center;">SL</th>
              <th  style="border-bottom:solid 0.5px #000; border-top:solid 0.5px #000; text-align:center;">Particulars</th>
              <th  style="border-bottom:solid 0.5px #000; border-top:solid 0.5px #000; text-align:center;">QTY</th>
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
              <td align="right"><?php echo $item->purchase_item_quantity." ".$item->unit_name;?></td>
            </tr>
            <?php }}else{ echo "No data  found!";} ?>
       
          </table>

      
     
      
      
      <table width="100%"style="font-size:14px;">
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


