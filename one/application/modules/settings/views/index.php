
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jababeka Control Center  - Settings <?php echo $name_type; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('/dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('/ticket/index/' . $id_type) ?>">Ticket <?php echo $name_type; ?></a></li>
        <li class="active">Settings</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <p class="pull-left col-xs-12">
            <a href="<?php echo site_url('/ticket/index/' . $id_type) ?>" >
              <i class="fa fa-arrow-left"></i>&nbsp; Back to ticket
            </a> 
        </p>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-pin"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Rules</h4></span>
              <span class="info-box-number">
                <a href="/settings/rules/index/<?php echo $id_type;?>" class="small-box-footer">
                  <small>More info <i class="fa fa-arrow-circle-right"></i></small>
                </a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-email"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Notification</h4></span>
              <span class="info-box-number">
                <a href="/settings/notification/index/<?php echo $id_type;?>" class="small-box-footer">
                  <small>More info <i class="fa fa-arrow-circle-right"></i></small>
                </a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

