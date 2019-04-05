<?php

$page = "Detail";
$filter_list_status = $all_data->status_order_name;
$title = $all_data->name;
$description = $all_data->description;

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Detail Ticket - <?php echo $name_type; ?>
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
                          <div class="col-sm-3">
                          <div class="box box-solid">
                            <div class="box-body padding-25">
                              <?php echo $title; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>     
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Description</label>

                      <div class="col-sm-9">
                          <div class="col-sm-3">
                          <div class="box box-solid">
                            <div class="box-body padding-25">
                              <?php echo $description; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>  

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Last Status</label>

                      <div class="col-sm-9">
                          <div class="col-sm-3">
                          <div class="box box-solid">
                            <div class="box-body padding-25">
                              <span class="btn btn-xs bg-purple" style="cursor: auto;"><?php echo $filter_list_status; ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>   
              </div>
                  
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url("/ticket/list/".$id_type) ?>" class="btn btn-danger">Batal</a>
                  <div class="pull-right">
                    <input type="hidden" name="status">
                    <?php if (count($all_data_rules) > 0): ?>
                      <label class="control-label">Action : </label>
                      <?php $color = ['red', 'blue', 'green', 'gray', 'primary', 'purple', 'yellow'];?>
                      <?php foreach ($all_data_rules as $key => $value): ?>
                        <button type="submit" class="btn bg-<?php echo $color[array_rand($color,1)]; ?>" data-status="<?php echo $value->id_status_detail; ?>" name="submit-sector" id="submit-sector" style="margin-right: 5px;"><?php echo $value->status_order_name_detail; ?></button>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
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

  $(document).on("click", "#submit-sector", function(e) {
    e.preventDefault();
    var _this = $(this), id_status = _this.data('status');
    $("input[name=status]").val(id_status);
    $("#form_sample_3 ").submit();
  });

</script>
