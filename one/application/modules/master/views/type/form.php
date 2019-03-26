<?php

if (isset($all_data)) {
  $page = "Edit";
  $name = $all_data->name;
  $description = $all_data->description;
} 
else {
  $page = "Add";
  $name = isset($_POST['name']) ? $_POST['name'] : '';;
  $description = isset($_POST['description']) ? $_POST['description'] : '';
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Type
        <small><?php echo strtolower($page); ?> type </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("master/type/"); ?>">Type</a></li>
        <li class="active"><?php echo $page; ?> Type</li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Name</label>

                      <div class="col-sm-9">
                          <?php echo form_input("name", set_value("name", $name), "data-required='1' class='form-control' placeholder='Name'"); ?>
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
              
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("master/type/") ?>" class="btn btn-danger">Batal</a>
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
      
  })

  $(document).on("keyup", "input[name=name]", function(e) {
    if(isAlphaNumeric(e.target.value) === false) {
      this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
    } else {
      return true;
    }
  });
</script>
