<?php

if (isset($all_data)) {
  $page = "Edit";
  $reference_sector_id = $all_data->reference_sector_id;
  $name = $all_data->name;
} 
else {
  $page = "Add";
  $reference_sector_id = FALSE;
  $name = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Sector
        <small>add sector </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sector</a></li>
        <li class="active">Add Sector</li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Reference Sector</label>

                      <div class="col-sm-9">
                          <?php echo form_input("reference_sector_id", set_value("reference_sector_id", $reference_sector_id), "data-required='1' class='form-control' placeholder='Reference Sector'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>     

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Nama Sector</label>

                      <div class="col-sm-9">
                          <?php echo form_input("name", set_value("name", $name), "data-required='1' class='form-control' placeholder='Nama Sector'"); ?>
                          <!-- <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->

                      </div>
                  </div>  

                  <?php /*
                  <div class="form-group">
                    <label class="col-sm-2 control-label">File Denah Perumahan</label>
                    <div class="col-md-9">
                      <div class="fileinput fileinput-<?php echo (isset($all_data->block)) ? "exists" : "new"; ?>" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                          <?php echo (isset($all_data->block)) ? "<img src='". PHOTO_PATH . "/". $all_data->block ."' />" : ""; ?>
                        </div>
                        <div>
                          <span class="btn yellow btn-file">
                            <span class="fileinput-new"> <i class="fa fa-photo"></i> Pilih Gambar </span>
                            <span class="fileinput-exists"> Ganti </span>
                            <input type="file" name="image_field_name">
                          </span>
                          <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput" id="delete_img"> Hapus </a>
                          <input type='hidden' name='hd_img_delete[]' value='0' />
                          <?php echo (isset($all_data->block)) ? "<input type='hidden' name='hd_id_img' value='". $all_data->block ."' />" : ""; ?>
                        </div>
                      </div>
                      <div class="clearfix margin-top-10">
                        <div class="note note-warning col-md-9">
                          <h4 class="block">NOTE!</h4>
                          <p>
                            * Minimum resolusi adalah <?php echo MIN_UPLOAD_WIDTH_PHOTO ."x". MIN_UPLOAD_HEIGHT_PHOTO ?> pixel<br>
                            * Preview gambar hanya bekerja di IE10 +, FF3.6 +, Safari6.0 +, Chrome6.0 + dan Opera11.1 +. Pada browser lama, nama file yang akan ditampilkan.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  */ ?>

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label" style="margin-right: 15px;">File Denah Perumahan</label>
                    <div class="col-sm-8 input-group">
                        <input type="file" class="form-control" name="image_field_name" onchange="readURL(this,'stp1');">
                    </div>
                    <label style="color:red;font-size:12px;margin-left: 202px;">*) allowed-ext (jpg, jpeg, png)</label>
                    
                    <div class="col-sm-9" id="div_prevstp1" style="margin-left:187px;border: 1px black;">
                      <img id="prev_imagestp1" style="width:100px;height:80px;" src="#" onerror="this.src='<?php echo base_url()?>static/images/no-image.png';" alt="your image"/>
                    </div>
                  </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('sector') ?>" class="btn btn-danger">Batal</a>
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
