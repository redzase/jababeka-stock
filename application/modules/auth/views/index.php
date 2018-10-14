<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>JABABEKA - ONE</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <?php echo get_validate_sess($ses_result_process); ?>
    
    <a href="<?php echo $login_url; ?>" class="btn btn-block btn-social btn-google-plus">
        <i class="fa fa-google-plus"></i> Sign in with Google
    </a>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
