<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url(); ?>">
      <img src="<?php echo base_url(); ?>assets/dist/img/bonikbook-logo.png" height="100"><br>
      <b>Business </b> Management</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Use Your Username to Sign In</p>
      <?php
        $success = $this->session->userdata('success_message');
        $error = $this->session->userdata('error_message');
        $this->session->unset_userdata('success_message');
        $this->session->unset_userdata('error_message');
        echo $success;
        echo $error; 
    ?>
      <form action="<?php echo base_url() . "admin-login"; ?>" method="post" enctype="multipart/form-data"  role="form" id="login_form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input type="hidden" name="numone" value="<?php echo $one; ?>">
        <input type="hidden" name="numtwo" value="<?php echo $two; ?>">
        <input type="hidden" name="numresult" value="<?php echo $result; ?>">
        <label class="text-red"> Answer sum in digits : <?php echo $word; ?> + <?php echo $two; ?> = ?</label>
        </div>
        <div class="row">
          <div class="col-8">
            <input type="number" name="cap" class="form-control" required autocomplete="off">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

<center>Contact<br>+8802 488 12159, +88 01672 996464<br>
sales@bonikbook.com</center>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->