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
            <h1>Approve Sales Requisition List</h1>
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
            <?php if ($sales_info){ ?>
              <table class="table table-bordered table-striped table-hover" id="example1">
              <caption>Approve Sales Requisition List</caption>
                <thead>
                <tr>
                  <th width="30">SL.</th>
                  <th>Issue Date</th>
                  <th>Invoice#</th>
                  <th style="min-width: 200px;">Customer</th>
                  <th style="min-width: 200px;">Organization</th>
                  <th>Total Amount</th>
                  <th>Req By</th>
                  <th style="min-width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $x = 1;
                  foreach($sales_info as $info){
                ?>
                  <tr>
                    <td><?php echo $x++; ?>.</td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($info->req_issue_date));?>
                    </td>
                    <td>
                      <?php echo $info->sales_req_no;?>
                    </td>
                    <td>
                      <?php echo $info->customer_name;?>
                    </td>
                     <td>
                      <?php echo $info->customer_organization;?>
                    </td>
                    <td>
                      <?php echo number_format((float)$info->req_total_amount+$info->req_total_vat, 2, '.', '');?>
                    </td>
                    <td>
                      <?php echo $info->user_name;?>
                    </td>
                    
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "sales-requisition-approve-detail/". $info->sales_req_id; ?>">
                         view
                      </a>
                      
                    </td>
                  </tr>
                  
                  <?php } ?>
                  </tbody>
              
              </table>
            <?php }else{ echo "No data  found!";} ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

