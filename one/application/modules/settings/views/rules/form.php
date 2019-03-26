<?php

if (isset($all_data)) {
  $page = "Edit";
  $filter_list_type = $all_data->id_type;
  $filter_list_status = $all_data->id_status;
  $sequence = $all_data->sort_number;
} 
else {
  $page = "Add";
  $filter_list_type = FALSE;
  $filter_list_status = FALSE;
  $sequence = 1;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Rules
        <small><?php echo strtolower($page); ?> status per type ticket </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("/settings/"); ?>">Settings</a></li>
        <li class="active"><?php echo $page; ?> status per type</li>
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
                      <label for="name" class="col-sm-2 control-label">Type Ticket</label>

                      <div class="col-sm-4">
                          <?php echo form_dropdown('select_type', $list_type, set_value("select_type", $filter_list_type), 'class="form-control"'); ?>
                      </div>
                  </div>  

                  <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Status Order</label>

                      <div class="col-sm-2">
                          <?php echo form_dropdown('select_status', $list_status, set_value("select_status", $filter_list_status), 'class="form-control"'); ?>
                      </div>
                  </div>  

                  <div class="form-group">
                      <label for="status_order" class="col-sm-2 control-label">Sequence</label>

                      <div class="col-sm-1">
                          <?php
                            $data = array(
                              'name'          => 'sequence',
                              'value'         => set_value("sequence", $sequence),
                              'class'         => "form-control mask-number",
                              'data-required' => "1",
                              'placeholder'   => "Sequence",
                              'type'          => 'number',
                              'min'           => '1'
                            );

                            echo form_input($data);
                          ?>
                      </div> 
                  </div>   
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("/settings/rules/") ?>" class="btn btn-danger">Batal</a>
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
