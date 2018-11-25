
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Jababeka Stock</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo base_url()?>static/css/dataTables.bootstrap.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/AdminLTE.min.css">
    <!-- all skin -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- date picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>static/css/show_image.css">
  <link rel="stylesheet" href="<?php echo base_url()?>static/plugins/bullseye/styles/jquery.bullseye.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>static/plugins/jquery-confirm/dist/jquery-confirm.min.css"/>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>static/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

  <!-- jQuery 3 -->
<script src="<?php echo base_url()?>static/js/jquery.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav" id="body" data-baseurl="<?php echo base_url() ?>">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo site_url('dashboard') ?>" class="navbar-brand"><b>JABABEKA</b>&nbsp Stock</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

            <?php 
            if (isset($this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["menu"]["SETTINGS"]) and !strpos(uri_string(), "ector")):
            ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-th"></i> &nbsp; <?php echo $this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["menu"]["SETTINGS"]["name"]; ?>  &nbsp; <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php 
                  if (isset($this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["module"]["SETTINGS"])):
                    foreach ($this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["module"]["SETTINGS"] as $key => $value):
                  ?>
                      <li><a href="<?php echo site_url($value["url"]) ?>"><?php echo $value["name"]; ?></a></li>
                  <?php 
                    endforeach;
                  endif;
                  ?>
                </ul>
              </li>
            <?php 
            endif;
            ?>

          </ul>
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

          <ul class="nav navbar-nav">
        
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $this->session->userdata(PREFIX_SESSION . "_USER_USERNAME"); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header" style="height:100%;">
                  <p>
                  
                    <?php echo $this->session->userdata(PREFIX_SESSION . "_USER_USERNAME"); ?>
                  </p>
                </li>
                
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-right">
                    <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  

