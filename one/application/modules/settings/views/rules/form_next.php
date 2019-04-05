<script type="text/javascript">
  var data_status_code = {};
  var data_divisi = {};
</script>
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
      Rules <?php echo $name_type; ?> Assign to Divisi
        <small>Status per type ticket</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('/settings/rules/index/'.$id_type) ?>">Ticket <?php echo $name_type; ?></a></li>
        <li class="active"><?php echo $page; ?> Rules <?php echo $name_type; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <?php echo get_validate_form(); ?>
          <?php echo get_validate_sess($this->session->flashdata(PREFIX_SESSION . "_FORM_NEXT_RESULT_PROCESS")); ?>
          
          <div class="col-md-12">
              <div class="box box-info">
              <div class="box-header ">
              <!-- <h3 class="box-title">Product Form</h3> -->
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "enctype" => "multipart/form-data")); ?>
              <div class="box-body">


                <?php if(isset($all_data) && count($all_data) > 0 ): ?>
                  <?php foreach($all_data as $status): ?>
                    <?php $id_status = $status->id; ?>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Status</label>

                       <div class="col-sm-3">
                          <div class="box box-solid">
                            <div class="box-body padding-25">
                              <?php echo $status->status_order_name; ?>
                            </div>
                          </div>
                        </div>
                    </div>  


                  <input type="hidden" name="status[]" id="status_<?php echo $id_status; ?>" value="<?php echo $id_status; ?>">

                    <?php if ($status->status_order != "0"): ?>
                      <!-- status -->
                      <div class="form-group">
                        <label class="col-sm-2 control-label "></label>
                        <div class="col-sm-9">
                          <div class="box box-solid">
                            <div class="box-body padding-25">
                              <ul class="list-group list_status" id="list_status_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>">
                                <li class="list-group-item add_status_container" id="add_status_container_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>">
                                  <a href="javascript:;" class="btn bg-blue add_status" id="add_status_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>">
                                    <i class="fa fa-plus-circle"></i> &nbsp; ADD ACTION
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.status -->

                      <!-- TEMPLATE status -->
                      <script id="tpl_status_<?php echo $id_status; ?>" type="text/template">
                        <li class="list-group-item tpl_status_container" id="tpl_status_container_<?php echo $id_status; ?>">
                          <div class="row">
                            <div class="col-xs-6">
                              <select required class="select2 form-control tpl_status_select" id="tpl_status_select_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>" style="width:100%">
                                <option></option>
                                <?php foreach($all_data as $k => $v): ?>
                                  <?php if ($v->id_status != $status->id_status):?>
                                    <option value="<?php echo $v->id_status; ?>"><?php echo $v->status_order_name; ?></option>
                                  <?php endif ?>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="col-xs-6 text-right">
                              <a href="javascript:;" class="btn btn-success tpl_status_add"  data-id="<?php echo $id_status; ?>" id="tpl_status_add_<?php echo $id_status; ?>" style="display:none;">Confirm</a>
                              <a href="javascript:;" class="btn btn-danger tpl_status_remove" id="tpl_status_remove_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>" ><i class="fa fa-remove"></i></a>
                            </div>
                          </div>
                        </li>
                      </script>
                      <!-- /.TEMPLATE status -->

                      <!-- TEMPLATE CONDITION -->
                      <script id="tpl_statuss_<?php echo $id_status; ?>" type="text/template">
                        <li class="list-group-item tpl_statuss_container" id="tpl_statuss_container_<?php echo $id_status; ?>">
                          <div class="row">
                            <div class="col-xs-2 tpl_statuss_label" id="tpl_statuss_label_<?php echo $id_status; ?>">
                            </div>
                            <div class="col-xs-4 tpl_statuss_fields" id="tpl_statuss_fields_<?php echo $id_status; ?>">
                            </div>
                            <div class="col-xs-1 pull-right">
                              <a href="javascript:;" class="btn btn-default tpl_statuss_remove" id="tpl_statuss_remove_<?php echo $id_status; ?>" data-id="<?php echo $id_status; ?>"><i class="fa fa-remove" ></i></a>
                            </div>
                            <div class="clearfix"></div>
                            <div id="custom_fields_container" class="col-xs-12"></div>
                          </div>
                        </li>
                      </script>
                      <!-- /.TEMPLATE CONDITION -->

                      <script type="text/javascript">
                        <?php if(!count($all_data_detail) > 0 ): ?>
                          data_status_code["<?php echo $id_status; ?>"] = [];
                        <?php endif; ?>
                      </script>

                    <?php endif; ?>

                  <?php endforeach; ?>
                <?php endif; ?>

                <script type="text/javascript">
                  <?php if(count($all_data_detail) > 0): ?>
                    <?php foreach($all_data_detail as $detail): ?>
                      if ("<?php echo $detail->id_type_status; ?>" in data_status_code){
                        data_status_code["<?php echo $detail->id_type_status; ?>"].push("<?php echo $detail->id_status; ?>");
                        data_divisi["<?php echo $detail->id_type_status; ?>"].push({"<?php echo $detail->id_status; ?>":"<?php echo $detail->id_divisi; ?>"});
                      }else{
                        data_status_code["<?php echo $detail->id_type_status; ?>"] = ["<?php echo $detail->id_status; ?>"];
                        data_divisi["<?php echo $detail->id_type_status; ?>"] = [{"<?php echo $detail->id_status; ?>":"<?php echo $detail->id_divisi; ?>"}];
                      }

                    <?php endforeach; ?>
                  <?php endif; ?>
                  // console.log(data_status_code);
                </script>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('/settings/rules/edit/'.$id_type) ?>" class="btn btn-warning">Kembali</a>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-sector" id="submit-sector">Simpan</button>
                  <a href="<?php echo site_url('/settings/rules/index/'.$id_type) ?>" class="btn btn-danger pull-right" style="margin-right: 5px;">Batal</a>
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

  var vStatus = {
    get_selected_status: function(dt_status, statusx) {
      if (statusx == undefined){
        return {
          "value": $("#tpl_status_select_"+dt_status+" option:selected").val(),
          "text":  $("#tpl_status_select_"+dt_status+" option:selected").text()
        };
      }else{
        return {
          "value": $("#tpl_status_select_"+dt_status+" option[value='" + statusx + "']").val(),
          "text":  $("#tpl_status_select_"+dt_status+" option[value='" + statusx + "']").text()
        };
      }
    },
    remove_data_status_code: function(dt_status, value) {
      var idx = data_status_code[dt_status].indexOf(value.toString());
      if (idx != -1) {
        data_status_code[dt_status].splice(idx, 1);
      }
    },
    toggle_status_button: function(dt_status) {
      // console.log($(document).find("#tpl_status_container_"+dt_status).html());
      $("#tpl_status_container_"+dt_status).remove();
      $("#add_status_container_"+dt_status).show();
    },
    get_selected_divisi_status: function(dt_status) {
      return {
        "value": $("#divisi_"+dt_status+" option:selected").val(),
        "text":  $("#divisi_"+dt_status+" option:selected").text()
      };
    },
    get_selected_status_per_divisi: function(dt_status) {
      return {
        "value": $("#status_per_divisi_"+dt_status+"").val()
      };
    },
    test: function(){
      // console.log(data_divisi);
      $.each(data_status_code, function(dt_status, v){
        var tplRaw = $("#tpl_status_" + dt_status).clone().html().trim(),
            tpl = $(tplRaw);

        // console.log(v);

        for (var z = 0; z < v.length; z++){
          $(tpl).find("option[value='" + v[z] + "']").attr("disabled", true);
        }
        $("#list_status_" + dt_status).append(tpl);

        $("#add_status_container_" + dt_status).hide();

        for (var z = 0; z < v.length; z++){
          vStatus.testedit(dt_status, v[z]);
        }

        vStatus.toggle_status_button(dt_status);

      });

      $.each(data_divisi, function(dt_status, v){
        for (var z = 0; z < v.length; z++){
          $.each(v[z], function(k, o){
            $("#divisi_" + dt_status + "_" + k).find("option[value='" + o + "']").prop("selected", true);
          })
        }
      })
    },
    testedit: function(dt_status, statusx){
      var status = vStatus.get_selected_status(dt_status, statusx);
      if (status.value != undefined) {
        var tplRaw = $("#tpl_statuss_" + dt_status).clone().html().trim(),
          tpl = $(tplRaw);

        $(tpl).find("#tpl_statuss_label_" + dt_status).html("<span class='status-text text-bold'>" + status.text + "</span><input type='hidden' name='status_per_divisi[]' id='status_per_divisi_" + dt_status + "' value='" + status.value + "'>");


        var input = '<span class="status-text text-bold">To divisi: </span><select required id="divisi_' + dt_status + '_' + status.value +'" class="select2 form-control divisi" data-id="'+ status.value +'" style="width:100%" name="divisi_' + dt_status + '_' + status.value +'[]"><option value=""></option>';
        <?php if(isset($list_divisi) && count($list_divisi) > 0 ): ?>
          <?php foreach($list_divisi as $divisi => $val): ?>
            var divisi_id = "<?php echo $divisi; ?>";
            var divisi_name = "<?php echo $val; ?>";
            input += "<option value='" + divisi_id + "'>" + divisi_name + "</option>";
          <?php endforeach; ?>
          <?php endif; ?>
        input += "</select>";
        

        $(tpl).find("#tpl_statuss_fields_" + dt_status).html(input);

        // set data-code attribute to .tpl_conditions_remove
        $(tpl).find("#tpl_statuss_remove_" + dt_status).attr("data-value", status.value);
        // append or prepend
        if (data_status_code[dt_status].length > 0) {
          $(tpl).insertBefore("#add_status_container_" + dt_status);
        } else {
          $("#list_status_" + dt_status).prepend(tpl);
        }

        // add to data
        if (!status.value in data_status_code[dt_status]){
          data_status_code[dt_status].push(status.value);
        }
      }
    }
  }

  $(function () {
    // S: process status
    <?php if(count($all_data_detail) > 0 ): ?>
    // S: loop statuss
    // console.log(data_status_code);
      vStatus.test();

    // E: process status
    <?php endif; ?>


  });

  $(document).on("click", ".add_status", function(e){
    var _this = $(this);
    var dt_status = _this.data('id');
    var tplRaw = $("#tpl_status_" + dt_status).clone().html().trim(),
        tpl = $(tplRaw);
    // detect selected condtions and set to disable
    // console.log("asd");
    if (data_status_code[dt_status].length > 0) {
      for(var i = 0; i < data_status_code[dt_status].length; i++) {
          $(tpl).find("option[value='" + data_status_code[dt_status][i] + "']").prop("disabled", true);
      }
    }

    $("#list_status_" + dt_status).append(tpl);

    $("#add_status_container_" + dt_status).hide();

  });

  $(document).on("change", ".tpl_status_select", function(e){
    var _this = $(this), dt_status = _this.data('id');
    // console.log(dt_status);
    $(".tpl_status_add").trigger("click", [dt_status]);
  });

  $(document).on("click", ".tpl_status_remove", function(e) {
    var _this = $(this), dt_status = _this.data('id');
    vStatus.toggle_status_button(dt_status);
  });

  // handle remove condition
  $(document).on("click", ".tpl_statuss_remove", function(e){
    var _this = $(this), dt_status = _this.data('id');
    _this.closest(".list-group-item").remove();
    // do another logic here
    vStatus.remove_data_status_code(dt_status, _this.data("value"));
    vStatus.toggle_status_button(dt_status);
  });

  $(document).on("click", ".tpl_status_add", function(e, dt_status){
    var status = vStatus.get_selected_status(dt_status);
    // console.log(status);
    if (status.value != undefined) {
      var tplRaw = $("#tpl_statuss_" + dt_status).clone().html().trim(),
        tpl = $(tplRaw);

      $(tpl).find("#tpl_statuss_label_" + dt_status).html("<span class='status-text text-bold'>" + status.text + "</span><input type='hidden' name='status_per_divisi[]' id='status_per_divisi_" + dt_status + "' value='" + status.value + "'>");


      var input = '<span class="status-text text-bold">To divisi: </span><select required id="divisi_'+ status.value + '" class="select2 form-control divisi" data-id="'+ status.value +'" style="width:100%" name="divisi_' + dt_status + '_' + status.value +'[]"><option value=""></option>';
      <?php if(isset($list_divisi) && count($list_divisi) > 0 ): ?>
        <?php foreach($list_divisi as $divisi => $val): ?>
          var divisi_id = "<?php echo $divisi; ?>";
          var divisi_name = "<?php echo $val; ?>";
          input += "<option value='" + divisi_id + "'>" + divisi_name + "</option>";
        <?php endforeach; ?>
        <?php endif; ?>
      input += "</select>";
      

      $(tpl).find("#tpl_statuss_fields_" + dt_status).html(input);

      // set data-code attribute to .tpl_conditions_remove
      $(tpl).find("#tpl_statuss_remove_" + dt_status).attr("data-value", status.value);
      // append or prepend
      if (data_status_code[dt_status].length > 0) {
        $(tpl).insertBefore("#add_status_container_" + dt_status);
      } else {
        $("#list_status_" + dt_status).prepend(tpl);
      }

      // add to data
      if (!status.value in data_status_code[dt_status]){
        data_status_code[dt_status].push(status.value);
      }
      // console.log(data_status_code);
      // remove current container and show the add status button
      vStatus.toggle_status_button(dt_status);
    }
  });


</script>
