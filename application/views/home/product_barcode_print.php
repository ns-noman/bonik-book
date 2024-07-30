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
            <h1>Product Barcode</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"  role="form"onsubmit="genBarcode()">
            <div class="card-body">
                <div class="form-group row">
                        <div class="col-sm-4">
                            No of Barcode 
                            <input type="number" name="barcode_qty" id="barcode_qty" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-sm-4">
                            Barcode Quantity Each Row <i class="far fa-question-circle" data-toggle="tooltip" title="Upto 4"></i>
                            <input type="number" name="col_qty"  id="col_qty" class="form-control" value="1" min="1" max="4" required>
                            <input type="hidden" name="product_id"  id="product_id" class="form-control" value="<?php echo $product->product_id ; ?>">
                        </div>
                        <div class="col-sm-2">
                            <br>
                            <input type="submit" name="submit" class="btn btn-success" value="Generate">
                        </div>
                </div>
            </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><a class="btn btn-info" href="javascript:void(0)" onclick="printDiv('printableArea')">Print</a></h3>
        </div>
        <div class="card-body table-responsive" id="printableArea">
            <?php echo $barcode ; ?>
        </div>
      </div>
    </section>
    <!-- /.content -->

