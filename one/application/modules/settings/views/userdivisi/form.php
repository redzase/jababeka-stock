<?php

if (isset($all_data)) {
  $page = "Edit";
  $filter_list_user = $all_data->id_user;
  $filter_list_divisi = $all_data->id_divisi;
} 
else {
  $page = "Add";
  $filter_list_user = FALSE;
  $filter_list_divisi = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      User Divisi
        <small>assign of user to division</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Divisi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          
          <?php echo get_validate_form(); ?>
          <?php echo get_validate_sess($this->session->flashdata(PREFIX_SESSION . "_FORM_RESULT_PROCESS")); ?>
          
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
                      <label for="name" class="col-sm-2 control-label">User</label>

                      <div class="col-sm-4">
                          <?php echo form_dropdown('select_user', $list_user, set_value("select_user", $filter_list_user), 'class="form-control"'); ?>
                      </div>
                  </div> 

                  <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Divisi</label>

                      <div class="col-sm-4">
                          <?php echo form_dropdown('select_divisi', $list_divisi, set_value("select_divisi", $filter_list_divisi), 'class="form-control"'); ?>
                      </div>
                  </div> 
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("/settings/userdivisi/") ?>" class="btn btn-danger">Batal</a>
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
</script>
