<?php

if (isset($all_data)) {
  $page = "Edit";
  $username = $all_data->username;
  $role_id = $all_data->role_id;
} 
else {
  $page = "Add";
  $username = "";
  $role_id = 0;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      User
        <small>add user </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("user"); ?>">User</a></li>
        <li class="active">Add User</li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">User Name</label>

                      <div class="col-sm-9">
                          <?php echo form_input("username", set_value("username", $username), "data-required='1' class='form-control' placeholder='User Name'"); ?>
                          <!-- <input type="text" name="username" class="form-control" id="inputPassword3" placeholder="User Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span> -->
                      </div>
                  </div>   

                  <?php /* 
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                      <div class="col-sm-9">
                          <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="****" >
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div> 
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

                      <div class="col-sm-9">
                          <input type="password" name="confirm_password" class="form-control" id="inputPassword3" placeholder="****" >
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div>    
                  */ ?>
                 
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Role</label>

                      <div class="col-sm-8">
                          <?php echo form_dropdown('select_role', $all_role, set_value("select_role", $role_id), 'class="form-control"'); ?>

                          <?php /*
                          <select class="form-control" name="select_role">
                            <option value="">Select Role</option> 
                            <?php foreach ($all_data as $key => $value): ?>
                              <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option> 
                            <?php endforeach; ?>
                          </select>
                          <!-- <button type="button" class="btn btn-info pull-right" name="detail-role" id="detail-role">Detail</button> -->
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                          */ ?>
                      </div>
                      <?php /*
                      <div class="col-sm-2">
                          <button type="button" class="btn btn-info" name="detail-role" id="detail-role">Detail</button>
                      </div>
                      */ ?>
                  </div> 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('user') ?>" class="btn btn-danger">Cancel</a>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-role" id="submit-role">Simpan</button>
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