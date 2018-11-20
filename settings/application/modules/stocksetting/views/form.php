<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Setting
        <small>update setting </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Setting</a></li>
        <li class="active">Add Setting</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          
          <?php echo get_validate_sess($ses_result_process); ?>
          <?php echo get_validate_form(); ?>
          
          <div class="col-md-12">
              <div class="box box-info">
              <div class="box-header ">
              <!-- <h3 class="box-title">Product Form</h3> -->
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
              <div class="box-body">

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Set Automatic Unbooking</label>

                      <div class="col-sm-9">
                        <div class="col-sm-1">
                          <?php echo form_checkbox('chk_automatic_unbooking', True, set_checkbox('chk_automatic_unbooking', $all_data->code, (bool) $all_data->status)); ?>
                        </div>
                        <div class="col-sm-1">
                          dalam
                        </div>
                        <div class="col-sm-3">
                          <?php echo form_dropdown('select_day', $select_day, set_value("select_day", $all_data->value), 'class="form-control" '. ($all_data->status ? '' : 'disabled')); ?>
                        </div>
                        <div class="col-sm-1">
                          hari
                        </div>
                      </div>
                  </div>     

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('role') ?>" class="btn btn-danger">Batal</a>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-role" id="submit-role">Simpan</button>
              </div>
              <!-- /.box-footer -->
              <?php echo form_close(); ?>
          </div>
          </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function () {
    $('input[name=chk_automatic_unbooking]').change(function() {
       if ($(this).is(':checked')) {
         $("select[name=select_day]").removeAttr("disabled");
       } else {
         $("select[name=select_day]").attr("disabled", true);
       }
    });
  });
</script>