<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Role
        <small>add role </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Role</a></li>
        <li class="active">Add Role</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div id="alert"></div>
          <div class="col-md-12">
              <div class="box box-info">
              <div class="box-header ">
              <!-- <h3 class="box-title">Product Form</h3> -->
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" id="form-role" action="<?php echo site_url("role/action_add"); ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Role Name</label>

                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Role Name" >
                          <span class="help-inline" style="color:red;" id="err-name"></span>

                      </div>
                  </div>     
                
                  <h3 style="font-weight:bold;text-decoration:underline;">Function</h3>
                  <table id="role" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                          <tr role="row">
                              <th width="5%">Pilih</th>
                              <th>Function</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr class="odd">
                          <td>
                            <input type="checkbox" name="chk_role" />
                          </td>
                          <td>
                            Stock - Sector - View
                          </td>
                        </tr>
                        <tr class="event">
                          <td>
                            <input type="checkbox" name="chk_role" />
                          </td>
                          <td>
                            Stock - Sector - Tambah 
                          </td>
                        </tr>
                        <tr class="odd">
                          <td>
                            <input type="checkbox" name="chk_role" />
                          </td>
                          <td>
                            Stock - Sector - Booking
                          </td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <a href="<?php echo site_url('role') ?>" class="btn btn-danger">Batal</a>
                  <button type="button" class="btn btn-primary pull-right" name="submit-role" id="submit-role">Simpan</button>
              </div>
              <!-- /.box-footer -->
              </form>
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

