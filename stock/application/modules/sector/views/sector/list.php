
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sector
        <small>Jababeka Sector</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sector</a></li>
        <li class="active">Jababeka Sector</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <?php echo get_validate_sess($ses_result_process); ?>
      
      <div class="row">
        <div class="col-md-12">
          <?php 
          if (check_access_module_permission($module, PERMISSION_CREATE)):
          ?>
          <p class="pull-right" style="margin-left:10px;">
              <a href="<?php echo site_url('sector/add') ?>" class="btn btn-primary">
                <i class="fa fa-plus"></i> Sector
              </a> 
          </p>
          <?php 
          endif;
          ?>
        </div>
      </div>

      <?php foreach ($all_data as $key => $value): ?>
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">
              <?php echo htmlspecialchars_decode($value->name, ENT_NOQUOTES); ?> 
              <?php 
              if (check_access_module_permission($module, PERMISSION_UPDATE) or check_access_module_permission($module, PERMISSION_DELETE)):
              ?>
              [ 
              <?php 
              endif;
              ?>
              <?php 
              if (check_access_module_permission($module, PERMISSION_UPDATE)):
              ?>
              <a href="<?php echo site_url('sector/edit/'. $value->id); ?>">edit</a> 
              <?php 
              endif;
              if (check_access_module_permission($module, PERMISSION_DELETE)):
              ?>
              |
              <a href="<?php echo site_url("sector/delete/". $value->id); ?>" class="confirmation" data-confirm-message="Anda yakin ingin menghapus data ini?">delete</a>
              <?php 
              if (check_access_module_permission($module, PERMISSION_UPDATE) or check_access_module_permission($module, PERMISSION_DELETE)):
              ?>
              ]
              <?php 
              endif;
              ?>
              <?php 
              endif;
              ?>
            </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <div class="col-sm-9">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>Total</th>
                      <th>Terjual</th>
                      <th>Available</th>
                      <th>Booked</th>
                      <th>Reserved</th>
                    </tr>
                  </thead>
                  <tbody style="font-size:36px;font-weight:bold;">
                    <tr>
                      <td><?php echo $value->total; ?></td>
                      <td><?php echo $value->sold; ?></td>
                      <td><?php echo $value->available; ?></td>
                      <td><?php echo $value->booked; ?></td>
                      <td><?php echo $value->reserved; ?></td>
                    </tr>
                  </tbody>
                </table>
                <div align="center">
                  <?php // echo $pagination; ?>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="ion ion-ios-checkmark"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"><h4 style="margin-top:1px;"><?php echo $value->total > 0 ? round((($value->sold / $value->total) * 100), 2) : 0; ?>%</h4></span>
                    <span class="info-box-number">
                      <hr style="margin:3px 0 0 0;">
                      <h3 style="margin-top:10px;">SOLD</h3>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

              <?php /*
              <div class="col-lg-2 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3 align="center"><?php echo $value->total > 0 ? round((($value->sold / $value->total) * 100), 2) : 0; ?>%</h3>
                    <hr style="margin:-5px 0 3px 0;">
                    <h3 align="center">SOLD</h3>
                  </div>
                </div>
              </div>
              */ ?>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-footer -->
          <div class="box-footer clearfix" align="center">
            <a href="<?php echo site_url("sector/kavling/index/". $value->id); ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        $(".confirmation").click(function() {
          var confirm_message = $(this).data("confirm-message");
          var answer = confirm(confirm_message);

          if (answer) {
            return true;
          }

          return false;
        });
    });
</script>

