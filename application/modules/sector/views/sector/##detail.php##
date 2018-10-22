<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Sector
        <small>detail sector </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sector</a></li>
        <li class="active">Detail Sector</li>
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
                      <label for="inputPassword3" class="col-sm-2 control-label">Reference Sector</label>

                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="inputPassword3" value="5" disabled />
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div>     
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Name Sector</label>

                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="inputPassword3" value="Perumahan Jababeka Indah" disabled />
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div>     
                
                  <h3 style="font-weight:bold;text-decoration:underline;">File Denah</h3>
                  <img src="https://upload.wikimedia.org/wikipedia/commons/4/40/Denah_Lokasi_.png" width="100%">

                  <h3 style="font-weight:bold;text-decoration:underline;">List Kavling</h3>
                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('role/add') ?>" class="btn btn-primary">
                        Import
                      </a>
                      <a href="<?php echo site_url('role/add') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Kavling
                      </a> 
                  </p>
                  <table id="role" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                          <tr role="row">
                              <th width="8%">Kavling Ref</th>
                              <th>Nama Jalan</th>
                              <th>Blok</th>
                              <th>Nomor</th>
                              <th>Status</th>
                              <th width="20%">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr class="odd">
                          <td>1</td>
                          <td>Oscar Boulevard</td>
                          <td>A3</td>
                          <td>12</td>
                          <td>Terjual</td>
                          <td>
                            <a href="#">View In Map</a>
                          </td>
                        </tr>
                        <tr class="event">
                          <td>2</td>
                          <td>Tropica 7</td>
                          <td>B1</td>
                          <td>80</td>
                          <td>Available</td>
                          <td>
                            <a href="#">Booking</a>
                            | <a href="#">Request Booking</a>
                          </td>
                        </tr>
                        <tr class="odd">
                          <td>3</td>
                          <td>Tropica 7</td>
                          <td>B2</td>
                          <td>1</td>
                          <td>Booked</td>
                          <td>
                            <a href="#">Unbooking</a>
                            | <a href="#">View In Map</a>
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

