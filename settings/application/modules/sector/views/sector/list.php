
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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
              <?php echo $value->name; ?> 
              [ 
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
              ]
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
            <div class="col-sm-10">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>Total</th>
                      <th>Terjual</th>
                      <?php /*
                      <th>Available Requested</th>
                      */ ?>
                      <th>Available</th>
                      <th>Booked</th>
                    </tr>
                  </thead>
                  <tbody style="font-size:36px;font-weight:bold;">
                    <tr>
                      <td><?php echo $value->total; ?></td>
                      <td><?php echo $value->sold; ?></td>
                      <?php /*
                      <td><?php echo $value->available_requested; ?></td>
                      */ ?>
                      <td><?php echo $value->available; ?></td>
                      <td><?php echo $value->booked; ?></td>
                    </tr>
                  </tbody>
                </table>
                <div align="center">
                  <?php // echo $pagination; ?>
                </div>
              </div>
              <!-- /.table-responsive -->
            </div>
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

