<?php
  $email = FALSE;
?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>JABABEKA - ONE</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php echo get_validate_sess($ses_result_process); ?>

        <!-- form start -->
        <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
        <div class="box-body">

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-9">
                    <?php echo form_input("email", set_value("email", $email), "data-required='1' class='form-control' placeholder='Email'"); ?>
                </div>
            </div>     
            
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right" name="submit-sector" id="submit-sector">Login</button>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
