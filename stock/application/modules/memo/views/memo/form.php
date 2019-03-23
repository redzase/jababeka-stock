<?php

if (isset($all_data)) {
  $page = "Edit";
  $date_range = date_now(13, $all_data->start_date) ." - ". date_now(13, $all_data->end_date);
  $title = $all_data->title;
  $filename = $all_data->filename;
  $filepath = ORIGINALS_PDF_PATH . "/". $all_data->filepath;
} 
else {
  $page = "Add";
  $date_range = FALSE;
  $title = FALSE;
  $filename = FALSE;
  $filepath = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Memo
        <small><?php echo strtolower($page); ?> memo </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Memo</a></li>
        <li class="active"><?php echo $page; ?> Memo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Title</label>

                      <div class="col-sm-9">
                          <?php echo form_input("title", set_value("title", $title), "data-required='1' class='form-control' placeholder='Title'"); ?>
                      </div>
                  </div>     
                  
                  <!-- Date range -->
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>

                      <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <?php echo form_input("date_range", set_value("date_range", $date_range), "data-required='1' class='form-control pull-right' id='date-range' readonly style='cursor:pointer; background-color: #FFFFFF'"); ?>
                          </div>
                      </div>
                  </div>
                  <!-- /.form group -->

                  <?php /*
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">End Date</label>

                      <div class="col-sm-9">
                          <?php echo form_input("reference_sector_id", set_value("reference_sector_id", $reference_sector_id), "data-required='1' class='form-control' placeholder='Reference Sector'"); ?>
                      </div>
                  </div>  
                  */ ?>   

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label" style="margin-right: 15px;">Upload File</label>
                    <div class="col-sm-8 input-group">
                        <input type="file" class="form-control" name="pdf_field_name">
                    </div>
                    <label style="color:red;font-size:12px;margin-left: 202px;">
                      <?php if (!empty($filename)): ?>
                      *) uploaded file: <a href="<?php echo $filepath; ?>" target="_blank"><?php echo $filename; ?></a><br>
                      <?php endif; ?>
                      *) allowed-ext (pdf)<br>
                    </label>
                  </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("memo/list/". $sector_id) ?>" class="btn btn-danger">Batal</a>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-sector" id="submit-sector">Simpan</button>
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
  $(document).ready(function() {
      //Date range picker
      $('#date-range').daterangepicker({
        autoUpdateInput: false,
        locale: {
          cancelLabel: 'Clear',
          format: 'D MMMM YYYY'
        }
      });

      $('#date-range').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('D MMMM YYYY') + ' - ' + picker.endDate.format('D MMMM YYYY'));
      });

      $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
  })
</script>
