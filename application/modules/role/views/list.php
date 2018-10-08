
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
          
          <div class="box">
          
          <!-- /.box-header -->
          <div class="box-body">
            <p class="pull-right" style="margin-left:10px;">
                <a href="<?php echo site_url('role/add') ?>" class="btn btn-block btn-primary" >
                  <i class="fa fa-plus"></i> Role
                </a> 
            </p>
            <table id="role" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row">
                        <th style="width: 10px">#</th>
                        <th>Role Name</th>
                        <th>Total User</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class="odd">
                    <td>
                      <input type="checkbox" name="chk_role" />
                    </td>
                    <td>
                      Admin Stock
                    </td>
                    <td>
                      4
                    </td>
                    <td>
                      08 Aug 2018
                    </td>
                  </tr>
                  <tr class="event">
                    <td>
                      <input type="checkbox" name="chk_role" />
                    </td>
                    <td>
                      Sales
                    </td>
                    <td>
                      2
                    </td>
                    <td>
                      09 Aug 2018
                    </td>
                  </tr>
                  <tr class="odd">
                    <td>
                      <input type="checkbox" name="chk_role" />
                    </td>
                    <td>
                      User Stock
                    </td>
                    <td>
                      1
                    </td>
                    <td>
                      08 Aug 2018
                    </td>
                  </tr>
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
