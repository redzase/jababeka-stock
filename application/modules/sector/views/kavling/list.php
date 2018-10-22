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
        
          <?php echo get_validate_sess($ses_result_process); ?>

          <div class="col-md-12">
              <div class="box box-info">

              <!-- form start -->
              <form class="form-horizontal" id="form-role">
              <div class="box-body">

                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Reference Sector</label>

                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="inputPassword3" value="<?php echo $detail_sector->reference_sector_id; ?>" disabled />
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div>     
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Name Sector</label>

                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="inputPassword3" value="<?php echo $detail_sector->name; ?>" disabled />
                          <span class="help-inline" style="color:red;" id="err-name"></span>
                      </div>
                  </div>     
                
                  <h3 style="font-weight:bold;text-decoration:underline;">File Denah Perumahan</h3>
                  <img src="<?php echo ORIGINALS_PHOTO_PATH . "/". $detail_sector->sketch; ?>" width="100%">

                  <h3 style="font-weight:bold;text-decoration:underline;">List Kavling</h3>
                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('sector/kavling/import/'. $detail_sector->id) ?>" class="btn btn-primary">
                        Import
                      </a>
                      <a href="<?php echo site_url('sector/kavling/add/'. $detail_sector->id) ?>" class="btn btn-primary">
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
                        <?php foreach ($all_data as $key => $value): ?>
                          <tr class="<?php echo ($key % 2) == 0 ? "event" : "odd"; ?>">
                            <td>
                              <?php echo $value->reference_kavling_id; ?>
                            </td>
                            <td>
                              <?php echo $value->street_name; ?>
                            </td>
                            <td>
                              <?php echo $value->block_name; ?>
                            </td>
                            <td>
                              <?php echo $value->house_number; ?>
                            </td>
                            <td>
                              <?php echo $list_status_kavling[$value->status]; ?>
                            </td>
                            <td>
                              <!-- <a href="#">View In Map</a> -->
                              <a class="btn default btn-xs purple" href="<?php echo site_url('sector/kavling/edit/'. $detail_sector->id .'/'. $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
              <!-- /.box-body -->
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

