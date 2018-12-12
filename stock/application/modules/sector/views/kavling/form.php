<?php

if (isset($all_data)) {
  $page = "Edit";
  $reference_kavling_id = $all_data->reference_kavling_id;
  $street_name = $all_data->street_name;
  $block_name = $all_data->block_name;
  $house_number = $all_data->house_number;
  $lb = $all_data->lb;
  $lt = $all_data->lt;
} 
else {
  $page = "Add";
  $reference_kavling_id = FALSE;
  $street_name = FALSE;
  $block_name = FALSE;
  $house_number = FALSE;
  $lb = FALSE;
  $lt = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Kavling
        <small>add kavling </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("sector"); ?>">Sector</a></li>
        <li><a href="<?php echo site_url("sector/kavling/index/". $sector_id) ?>">Detail Sector</a></li>
        <li class="active">Add Kavling</li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Reference Kavling</label>

                      <div class="col-sm-9">
                          <?php echo form_input("reference_kavling_id", set_value("reference_kavling_id", $reference_kavling_id), "data-required='1' class='form-control' placeholder='Reference Kavling'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>     

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Nama Jalan</label>

                      <div class="col-sm-9">
                          <?php echo form_input("street_name", set_value("street_name", $street_name), "data-required='1' class='form-control' placeholder='Nama Jalan'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Nama Blok</label>

                      <div class="col-sm-9">
                          <?php echo form_input("block_name", set_value("block_name", $block_name), "data-required='1' class='form-control' placeholder='Nama Blok'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Nomor Rumah</label>

                      <div class="col-sm-9">
                          <?php echo form_input("house_number", set_value("house_number", $house_number), "data-required='1' class='form-control' placeholder='Nomor Rumah'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Luas Bangunan</label>

                      <div class="col-sm-9">
                          <?php echo form_input("lb", set_value("lb", $lb), "data-required='1' class='form-control' placeholder='Luas Bangunan'"); ?>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Luas Tanah</label>

                      <div class="col-sm-9">
                          <?php echo form_input("lt", set_value("lt", $lt), "data-required='1' class='form-control' placeholder='Luas Tanah'"); ?>
                      </div>
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

<?php /*
<script>
$(document).ready(function (e) {
    $("#submit-role").click(function (event) {
        event.preventDefault();
        $('#loading').show();
        $("#submit-role").prop("disabled", true);
        // Get form
        var form = $('#form-role')[0];

		// Create an FormData object 
        var data = new FormData(form);
        
            $.ajax({
            type:'POST',
            enctype: 'multipart/form-data',
            url: '<?php echo site_url("role/action_add"); ?>',
            data:data,
            processData: false,
            contentType: false,
            cache: false,
            success:function(res){
                if (res.msg.hasOwnProperty('name')){
                    $('#err-name').html(res.msg.name);
                }else{  
                    $('#err-name').html(''); 
                }
                
                if (res.status == false){
                    $('#loading').hide();
                    $("#submit-role").prop("disabled", false);

                    $('#alert').html('<div class="col-md-12 alert alert-block alert-danger fade in">'
                                    +'<button data-dismiss="alert" class="close" type="button">×</button>'
                                    +'<h4 class="alert-heading">'+res.error_title+'</h4>'
                                    +'<p>'+res.error_content+'</p></div>');
                }else{
                    
                    document.location.href='<?php echo site_url("role"); ?>';

                }
            },
            error:function(){
                $("#submit-role").attr("disabled", false);
                $('#loading').hide();
                $("#submit-role").prop("disabled", false);

            }
        });
    });
});

</script>
*/ ?>
