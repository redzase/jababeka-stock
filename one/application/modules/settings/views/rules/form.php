<?php

if (isset($all_data)) {
  $page = "Edit";
} 
else {
  $page = "Add";
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Rules <?php echo $name_type; ?>
        <small>Status per type ticket</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('/settings/rules/index/'.$id_type) ?>">Rules <?php echo $name_type; ?></a></li>
        <li class="active"><?php echo $page; ?> Rules <?php echo $name_type; ?></li>
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
                      <label for="name" class="col-sm-2 control-label">Start</label>

                     <div class="col-sm-3">
                        <div class="box box-solid">
                          <div class="box-body padding-25">
                            <?php 
                              if (isset($data_status_first)){
                                echo $data_status_first->name;
                                echo "<input type='hidden' name='status_first' value='".$data_status_first->id."'>";
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                  </div>  

                  <input type="hidden" name="status" id="status">

                  <!-- status -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label "></label>
                    <div class="col-sm-9">
                      <div class="box box-solid">
                        <div class="box-body padding-25">
                          <ul class="list-group" id="list_status">
                            <li class="list-group-item" id="add_status_container">
                              <a href="javascript:;" class="btn bg-blue" id="add_status">
                                <i class="fa fa-plus-circle"></i> &nbsp; ADD STATUS
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.status -->

                  <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">End</label>

                      <div class="col-sm-3">
                        <div class="box box-solid">
                          <div class="box-body padding-25">
                            <?php 
                              if (isset($data_status_last)){
                                echo $data_status_last->name;
                                echo "<input type='hidden' name='status_last' value='".$data_status_last->id."'>";
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                  </div>  
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('/settings/rules/index/'.$id_type) ?>" class="btn btn-danger">Batal</a>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-sector" id="submit-sector">Simpan & Lanjutkan</button>
                  <?php if (count($lihat_detail) > 0):?>
                    <a href="<?php echo site_url('/settings/rules/next/'.$id_type) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Lihat Detail</a>
                  <?php endif; ?>
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

<!-- TEMPLATE status -->
<script id="tpl_status" type="text/template">
  <li class="list-group-item" id="tpl_status_container">
    <div class="row">
      <div class="col-xs-6">
        <select class="select2 form-control" id="tpl_status_select" style="width:100%">
          <option></option>
          <?php foreach($list_status as $k => $v): ?>
            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-xs-6 text-right">
        <a href="javascript:;" class="btn btn-success" id="tpl_status_add" style="display:none;">Confirm</a>
        <a href="javascript:;" class="btn btn-danger" id="tpl_status_remove"><i class="fa fa-remove"></i></a>
      </div>
    </div>
  </li>
</script>
<!-- /.TEMPLATE status -->

<!-- TEMPLATE statuss -->
<script id="tpl_statuss" type="text/template">
  <li class="list-group-item" id="tpl_statuss_container">
    <div class="row">
      <div class="col-xs-11">
        <div class="box box-solid">
          <div class="box-body" id="tpl_statuss_label">
          </div>
        </div>
      </div>
      <div class="col-xs-1 pull-right">
        <a href="javascript:;" class="btn btn-default tpl_statuss_remove"><i class="fa fa-remove"></i></a>
      </div>
      <div class="clearfix"></div>
      <div id="custom_fields_container" class="col-xs-12"></div>
    </div>
  </li>
</script>
<!-- /.TEMPLATE statuss -->

<script type="text/javascript">

  var data_status_code = [];
  var vStatus = {
    get_selected_status: function() {
      return {
        "value": $("#tpl_status_select option:selected").val(),
        "text":  $("#tpl_status_select option:selected").text()
      };
    },
    remove_data_status_code: function(value) {
      var idx = data_status_code.indexOf(value.toString());
      if (idx != -1) {
        data_status_code.splice(idx, 1);
      }
    },
    toggle_status_button: function() {
      $("#tpl_status_container").remove();
      $("#add_status_container").show();
    },
    update_to_hidden_field: function(){
      $("#status").val(data_status_code);
    }
  }

  $(function () {
    // S: process status
    <?php if(count($all_data) > 0 ): ?>
    // S: loop statuss
    
    <?php foreach($all_data as $status): ?>
    $("#add_status").trigger("click");
    $("#tpl_status_select").find("option[value=<?php echo $status->id_status; ?>]").prop("selected", true);
    $("#tpl_status_add").trigger("click");

    // E: loop statuss
    <?php endforeach; ?>

    // E: process status
    <?php endif; ?>


  });

  $(document).on("click", "#add_status", function(e){
    var tplRaw = $("#tpl_status").clone().html().trim(),
        tpl = $(tplRaw);

    // detect selected condtions and set to disable
    if (data_status_code.length > 0) {
      for(var i = 0; i < data_status_code.length; i++) {
        $(tpl).find("option[value='" + data_status_code[i] + "']").prop("disabled", true);
      }
    }

    // append to list_status
    $("#list_status").append(tpl);

    // hide add status container after click
    $("#add_status_container").hide();
  });

  $(document).on("change", "#tpl_status_select", function(e){
    $("#tpl_status_add").trigger("click");
  });

  $(document).on("click", "#tpl_status_remove", function(e) {
    vStatus.toggle_status_button();
  });

  // handle remove condition
  $(document).on("click", ".tpl_statuss_remove", function(e){
    var _this = $(this);
    _this.closest(".list-group-item").remove();
    // do another logic here
    vStatus.remove_data_status_code(_this.data("value"));
    vStatus.toggle_status_button();
    vStatus.update_to_hidden_field();
  });

  $(document).on("click", "#tpl_status_add", function(e){
    var status = vStatus.get_selected_status();

    var tplRaw = $("#tpl_statuss").clone().html().trim(),
        tpl = $(tplRaw);

    $(tpl).find("#tpl_statuss_label").html("<span class='status-text'>" + status.text + "</span>");

    // set data-code attribute to .tpl_conditions_remove
    $(tpl).find(".tpl_statuss_remove").attr("data-value", status.value);

    // append or prepend
    if (data_status_code.length > 0) {
      $(tpl).insertBefore("#add_status_container");
    } else {
      $("#list_status").prepend(tpl);
    }

    // add to data
    data_status_code.push(status.value);

    // remove current container and show the add status button
    vStatus.toggle_status_button();

    vStatus.update_to_hidden_field();
  });

</script>
