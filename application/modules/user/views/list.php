
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      User
        <small>List User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">List User</li>
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
          <p class="pull-right" style="margin-left:10px;">
              <a href="<?php echo site_url('user/add') ?>" class="btn btn-block btn-primary" >
                <i class="fa fa-plus"></i> User
              </a> 
          </p>
            <table id="role" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row">
                        <th style="width: 10px">#</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($all_data as $key => $value): ?>
                    <tr class="<?php echo ($key % 2) == 0 ? "event" : "odd"; ?>">
                      <td>
                        <?php echo $start_no++; ?>
                      </td>
                      <td>
                        <a href="<?php echo site_url("user/edit/". $value->id); ?>">
                          <?php echo $value->username; ?>
                        </a>
                      </td>
                      <td>
                        <?php echo $value->role_name; ?>
                      </td>
                      <td>
                        <td><?php echo date_now(12, $value->created_date); ?></td>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
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
