<?php

if (isset($all_data)) {
  $page = "Edit";
  $reference_kavling_id = $all_data->reference_kavling_id;
  $street_name = $all_data->street_name;
  $block_name = $all_data->block_name;
  $house_number = $all_data->house_number;
} 
else {
  $page = "Add";
  $reference_kavling_id = FALSE;
  $street_name = FALSE;
  $block_name = FALSE;
  $house_number = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Kavling
        <small>import kavling </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Kavling</a></li>
        <li class="active">Import Kavling</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          
          <?php echo get_validate_form(); ?>
          
          <div class="col-md-12">
              <div class="box box-info">
              <div class="box-header ">
                
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
              <div class="box-body">

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label" style="margin-right: 15px;">File CSV</label>
                    <div class="col-sm-8 input-group">
                        <input type="file" class="form-control" name="massupload">
                    </div>
                    <label style="color:red;font-size:12px;margin-left: 202px;">
                      *) allowed-ext (csv)<br>
                      *) download sample csv file [ <a href="<?php echo site_url("static/file/import-csv.csv"); ?>">download</a> ]
                    </label>
                  </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("sector/kavling/index/". $sector_id) ?>" class="btn btn-danger">Batal</a>
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
