
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>JABABEKA</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form  method="post" action="<?php echo site_url("auth/login"); ?>">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span style="color:red"><?php echo $err_fotos = isset($message_display['msg']['username']) ? $message_display['msg']['username'] : ''; ?></span>
        <span style="color:red"><?php echo $err_fotos = isset($message_display['msg']['password']) ? $message_display['msg']['password'] : ''; ?></span>

      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4" style="float:right">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
