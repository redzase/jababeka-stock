
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-checkmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Total Sector</h4></span>
              <span class="info-box-number">
                <?php echo number_format($total_sector); ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-checkmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Total Kavling</h4></span>
              <span class="info-box-number">
                <?php echo number_format($total_kavling); ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-checkmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Kavling Available</h4></span>
              <span class="info-box-number">
                <?php echo number_format($total_kavling_available); ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-checkmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Kavling Sold</h4></span>
              <span class="info-box-number">
                <?php echo number_format($total_kavling_sold); ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="ion ion-ios-checkmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4>Kavling Booked</h4></span>
              <span class="info-box-number">
                <?php echo number_format($total_kavling_booked); ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

