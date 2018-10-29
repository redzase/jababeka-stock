<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Role
        <small>List Role</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Role</a></li>
        <li class="active">List Role</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-12">
          
          <?php echo get_validate_sess($ses_result_process); ?>
          
          <div class="box">
          
          <!-- /.box-header -->
          <div class="box-body">
            <?php 
            if (check_access_module_permission($module, PERMISSION_CREATE)):
            ?>
            <p class="pull-right" style="margin-left:10px;">
                <a href="<?php echo site_url('role/add') ?>" class="btn btn-block btn-primary" >
                  <i class="fa fa-plus"></i> Role
                </a> 
            </p>
            <?php 
            endif;
            ?>
            <table id="role" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row">
                        <th style="width: 10px">#</th>
                        <th>Role Name</th>
                        <th>Total User</th>
                        <th>Created Date</th>
                        <th width="12%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($all_data as $key => $value): ?>
                    <tr class="<?php echo ($key % 2) == 0 ? "event" : "odd"; ?>">
                      <td>
                        <?php echo $start_no++; ?>
                      </td>
                      <td>
                        <?php echo $value->name; ?>
                      </td>
                      <td>
                        <?php echo $value->total_user; ?>
                      </td>
                      <td>
                        <?php echo date_now(12, $value->created_date); ?>
                      </td>
                      <td>
                        <?php 
                        if (check_access_module_permission($module, PERMISSION_UPDATE)):
                        ?>
                          <a class="btn default btn-xs purple" href="<?php echo site_url("role/edit/". $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                        <?php 
                        endif;
                        ?>
                        <?php 
                        if (check_access_module_permission($module, PERMISSION_DELETE)):
                          if ($value->total_user == 0): 
                        ?>
                          <a class="btn default btn-xs black" href="<?php echo site_url("role/delete/". $value->id); ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash-o"></i> Delete </a>
                        <?php 
                          endif; 
                        endif;
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  </tr>
                </tbody>
            </table>
            <div align="center">
              <?php echo $pagination; ?>
            </div>
          </div>
          <!-- /.box-body -->
          
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
