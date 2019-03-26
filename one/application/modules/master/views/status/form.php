<?php

if (isset($all_data)) {
  $page = "Edit";
  $name = $all_data->name;
  $statusOrder = $all_data->status_order;
} 
else {
  $page = "Add";
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $statusOrder = isset($_POST['status_order']) ? $_POST['status_order'] : '';
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Status
        <small><?php echo strtolower($page); ?> status </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("master/status/"); ?>">Status</a></li>
        <li class="active"><?php echo $page; ?> Status</li>
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
                      <label for="name" class="col-sm-2 control-label">Name</label>

                      <div class="col-sm-9">
                          <?php echo form_input("name", set_value("name", $name), "data-required='1' class='form-control' placeholder='Name'"); ?>
                      </div>
                  </div>  

                  <div class="form-group">
                      <label for="status_order" class="col-sm-2 control-label">Status Order</label>

                      <div class="col-sm-2">
                          <?php
                            $data = array(
                              'name'          => 'status_order',
                              'value'         => set_value("status_order", $statusOrder),
                              'class'         => "form-control mask-number",
                              'data-required' => "1",
                              'placeholder'   => "Status Order",
                              'type'          => 'number',
                            );

                            echo form_input($data);
                          ?>
                      </div> 
                  </div>     
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("master/status/") ?>" class="btn btn-danger">Batal</a>
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
          allowMinus: true
      });
  })

  $(document).on("keyup", "input[name=name]", function(e) {
    if(isAlphaNumeric(e.target.value) === false) {
      this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
    } else {
      return true;
    }
  });

</script>
