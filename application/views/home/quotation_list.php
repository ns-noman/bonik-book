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
          <div class="col-sm-6">
            <h1>Quotation List</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        
        <div class="card-body table-responsive">
          <?php echo $success_msg; ?>
          <?php echo $error_msg; ?>
            <?php if ($quotation_info){ ?>
              <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>All Quotation List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Date</th>
                  <th>Quotation#</th>
                  <th>To</th>
                  <th>Type</th>
                  <th>Title</th>
                  <th style="min-width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  foreach($quotation_info as $info){
                    
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->quotation_date));?>
                    </td>
                    <td>
                      <?php echo $info->quotation_no;?>
                    </td>
                    <td>
                      <?php if($info->quotation_user_type == "Supplier"){
                          $supplier_info = $this->inventory_model->get_supplier_by_id($info->quotation_user);
                          echo $supplier_info->supplier_name;
                      }else if($info->quotation_user_type == "Customer"){
                          $customer_info = $this->inventory_model->get_customer_by_id($info->quotation_user);
                          echo $customer_info->customer_name;
                      } ?>
                    </td>
                     <td>
                       <?php echo $info->quotation_type;?>
                    </td>
                     <td>
                       <?php echo $info->quotation_title;?>
                    </td>
                   
                   
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "quotation-detail/". $info->quotation_id; ?>">
                         view
                      </a>
                      
                      </a>
                    </td>
                  </tr>
                  
                  <?php } ?>
                  </tbody>
                <!--<tfoot>
                <tr>
                  <th>
                    footer
                  </th>
                </tr>
                </tfoot>-->
              </table>
            <?php }else{ echo "No data  found!";} ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

