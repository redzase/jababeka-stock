
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jababeka Control Center - Ticket
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ticket</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <?php echo get_validate_sess($ses_result_process); ?>

        <p class="pull-left col-xs-12">
            <a href="<?php echo site_url('/dashboard/') ?>" >
              <i class="fa fa-arrow-left"></i>&nbsp; Back to dashboard
            </a> 
        </p>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-android-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Master Data</h4></span>
              <span class="info-box-number">
                <a href="/master/" class="small-box-footer">
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
            <span class="info-box-icon bg-aqua"><i class="ion ion-settings"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Settings</h4></span>
              <span class="info-box-number">
                <a href="/settings/" class="small-box-footer">
                  <small>More info <i class="fa fa-arrow-circle-right"></i></small>
                </a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <?php 
          foreach ($list_type as $key => $value):
        ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-social-apple"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4><?php echo $value; ?></h4></span>
              <span class="info-box-number">
                <a href="list/<?php echo $key; ?>" class="small-box-footer">
                  <small>More info <i class="fa fa-arrow-circle-right"></i></small>
                </a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <?php 
          endforeach;
        ?>

      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

