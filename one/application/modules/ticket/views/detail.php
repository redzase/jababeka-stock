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
                <div class="box-header with-border">
                  <h3 class="box-title">Basic Info</h3>
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
                                <span class="btn btn-sm bg-yellow" style="cursor: auto;"><?php echo $filter_list_status; ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>   
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url("/ticket/list/".$id_type) ?>" class="btn btn-danger">Batal</a>
                </div>
              </div>
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Log History</h3>
                </div>

                <label for="inputPassword3" class="col-sm-1 control-label"></label>
                <div class="col-sm-10">
                    <div class="table-responsive no-padding">
                      <table class="table table-hover">
                          <thead>
                              <tr role="row">
                                  <th style="width: 10px">#</th>
                                  <th>User</th>
                                  <th>Status</th>
                                  <th>Comment</th>
                                  <th>Comment At</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php 
                            $start_no = 1;
                            foreach ($all_data_comment as $key => $value): 
                            ?>
                              <tr class="<?php echo ($key % 2) == 0 ? "event" : "odd"; ?>">
                                <td>
                                  <?php echo $start_no++; ?>
                                </td>
                                <td>
                                  <?php echo $value->username; ?>
                                </td>
                                <td>
                                  <?php echo $value->status_order_name; ?>
                                </td>
                                <td>
                                  <?php echo $value->comment; ?>
                                </td>
                                <td>
                                  <?php 
                                    $t = strtotime($value->created_at);
                                    echo date('d-m-Y H:i:s',$t);
                                  ?>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                      </table>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-9">
                            <?php echo form_textarea("comment", set_value("comment", FALSE), "data-required='1' class='form-control' placeholder='Comment'"); ?>
                        </div>
                    </div>   
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                      <input type="hidden" name="status" value="<?php echo $id_status; ?>">
                      <label class="control-label">Change status to : &nbsp;</label>
                      <?php if (count($all_data_rules) > 0): ?>
                        <?php foreach ($all_data_rules as $key => $value): ?>
                          <button type="submit" class="btn bg-green" data-status="<?php echo $value->id_status_detail; ?>" name="submit-sector" id="submit-sector" style="margin-right: 5px;"><?php echo $value->status_order_name_detail; ?></button>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <i>No Action</i>
                      <?php endif; ?>
                    </div>
                    <div class="pull-left">
                      <button type="submit" class="btn bg-blue" name="submit-comment" style="margin-right: 5px;">Submit Comment</button>
                    </div>
                </div>

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
