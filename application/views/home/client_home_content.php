<!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
        $success_msg = $this->session->userdata('success');
        $error_msg = $this->session->userdata('error');
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
      ?>
      
    </section>
    <?php
        $privilege = $this->inventory_model->get_user_privilege($this->session->userdata('user_id'));
        $privilege_set = array_column($privilege, 'menu_name');
         ?>
 <?php  if($this->session->userdata('user_type') == "Client" or in_array('Dashboard', $privilege_set)){ ?>
    <!-- Main content -->
    <section class="content">
      <?php echo $success_msg; ?>
      <?php echo $error_msg; ?>
      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo number_format($sales_total, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Total Sales</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url().'daily-sales-report'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo number_format($purchase_total, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Total Purchase</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo number_format($sales_collection, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Sales Collection (Cash Sales + Due Invoice Receive)</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url().'sales-ledger'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo number_format($purchase_payment, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Payment to Supplier/Vendor (Cash Purchase + Due Invoice Payment)</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url().'purchase-ledger'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo number_format($purchase_due, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Purchase Due</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url().'daily-purchase-report'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo number_format($sales_due, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Sales (Invoice) Due</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url().'daily-sales-report'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo number_format($total_expense, 2, '.', ',');
                                        ;?></h3>

                <p>Today's Total Expense</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url().'expense-ledger'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo count($low_stock);
                                        ;?></h3>

                <p>Low Stock Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url().'low-stock-report'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-lightblue">
                <h3 class="widget-user-username"><b>Receipts</b></h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Sales Received <span class="float-right "><?php echo number_format($cash_sales, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Due Invoice Receive  <span class="float-right "><?php echo number_format($customer_payment, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li> 
                   <li class="nav-item  bg-lightblue">
                    <a href="javascript:void(0)" class="nav-link">
                      Total <span class="float-right "><?php echo number_format($cash_sales+$customer_payment, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  </ul>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-olive">
                <h3 class="widget-user-username"><b>Payments</b></h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Purchase Payment  <span class="float-right "><?php echo number_format($cash_purchase, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                 <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Due Invoice Payment <span class="float-right "><?php echo number_format($supplier_payment, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li> 
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Expense <span class="float-right"><?php echo number_format($total_expense, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  <li class="nav-item bg-olive">
                    <a href="javascript:void(0)" class="nav-link">
                      Total <span class="float-right "><?php echo number_format($cash_purchase+$total_expense+$supplier_payment, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  </ul>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-orange">
                <h3 class="widget-user-username"><b>Cash Flow</b></h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Opening Balance<span class="float-right "><?php echo number_format($opening_cash_balance, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Receipts  <span class="float-right "><?php echo number_format($cash_sales+$customer_payment, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                      Today's Payments  <span class="float-right "><?php echo number_format($cash_purchase+$supplier_payment+$total_expense, 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  <li class="nav-item bg-orange">
                    <a href="javascript:void(0)" class="nav-link">
                      Balance <span class="float-right"><?php echo number_format($opening_cash_balance+$cash_sales+$customer_payment-($cash_purchase+$supplier_payment+$total_expense), 2, '.', ',');
                                        ;?></span>
                    </a>
                  </li>
                  
                  </ul>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card card-success">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Weekly Sales & Purchase</h3>
                  
                </div>
              </div>
              <div class="card-body chart-responsive">
                <div class="chart">
                  <canvas id="reftchart" style="min-height: 300px; height: 300px; max-height: 700px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-info">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 6 Month Sales</h3>
                </div>
              </div>
              <div class="card-body chart-responsive">
                <div class="chart">
                  <canvas id="doughnutChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card card-warning">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Weekly Collection & Payment</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="collectionchart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-danger">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Expense of <?php echo date('M Y'); ?></h3>
                </div>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills flex-column">
                  <?php if ($expense_head_info) {
                    $first_day =  date('Y-m-1');
                    $last_day =  date('Y-m-t');
                    foreach ($expense_head_info as $expense) {
                      $expamount = $this->inventory_model->get_monthly_expense($first_day, $last_day, $expense->expense_head_id);
                    ?>
                    <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                     <?php echo $expense->expense_head_name; ?>
                      <span class="float-right text-success">
                          <?php echo number_format($expamount->expense_transaction_amount, 2, '.', ','); ?></span>
                    </a>
                  </li>
                  <?php }} ?>
                  <!-- <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Office Rent
                      <span class="float-right text-success">
                        12500</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Entertainment
                      <span class="float-right text-success">
                        10000
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Staff Salary
                      <span class="float-right text-success">
                        20000
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Repir
                      <span class="float-right text-success">
                        1000
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Office Supply
                      <span class="float-right text-success">
                        500
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Utility Bill
                      <span class="float-right text-success">
                        10000
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                      Transportation
                      <span class="float-right text-success">
                        5000
                      </span>
                    </a>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
    </section>
  <?php } ?>
    <!-- /.content -->

