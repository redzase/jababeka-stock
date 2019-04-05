<?php

if (isset($all_data)) {
  $page = "Edit";
  $filter_list_status = $all_data->id_status;
  $title = $all_data->name;
  $description = $all_data->description;
} 
else {
  $page = "Add";
  $filter_list_status = FALSE;
  $title = FALSE;
  $description = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Ticket - <?php echo $name_type; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("/ticket/" . $id_type); ?>"><?php echo $name_type; ?></a></li>
        <li class="active">Add Ticket <?php echo $name_type; ?></li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Title</label>

                      <div class="col-sm-9">
                          <?php echo form_input("title", set_value("title", $title), "data-required='1' class='form-control' placeholder='Title'"); ?>
                      </div>
                  </div>     
                  
              </div>

              <div class="box-body">

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Description</label>

                      <div class="col-sm-9">
                          <?php echo form_textarea("description", set_value("description", $description), "data-required='1' class='form-control' placeholder='Description'"); ?>
                      </div>
                  </div>   
              </div>

              <?php /*
              <div class="box-body">

                  <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Rules</label>

                      <div class="col-sm-4">
                          <?php echo form_dropdown('select_status', $list_rules, set_value("select_status", $filter_list_status), 'class="form-control"'); ?>
                      </div>
                  </div>  
                
              </div>  
              */ ?>
                  
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("/ticket/list/".$id_type) ?>" class="btn btn-danger">Batal</a>
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
      $(".mask-number").inputmask("numeric", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          rightAlign: false,
          allowMinus: false
      });
  })

</script>
