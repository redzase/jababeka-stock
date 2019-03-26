<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Rules
        <small>Status per type ticket</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("/settings/"); ?>">Settings</a></li>
        <li class="active">Rules</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

          <?php echo get_validate_form(); ?>        
          <?php echo get_validate_sess($ses_result_process); ?>

          <div class="col-md-12">
              <div class="box box-info">

              <!-- form start -->
              <div class="box-body">

                  <p class="pull-left" style="margin-left:10px;">
                      <a href="<?php echo site_url('/settings/') ?>">
                        <i class="fa fa-arrow-left"></i>&nbsp; Back to settings
                      </a> 
                  </p>

                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('/settings/rules/add/') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp; Add Rules
                      </a> 
                  </p>
                  <div style="clear:both;"></div>
                  <div class="table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>Type Ticket</th>
                                <th>Status Order</th>
                                <th>Sequence</th>
                                <th width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                          foreach ($all_data as $key => $value): 
                          ?>
                            <tr class="<?php echo ($key % 2) == 0 ? "event" : "odd"; ?>">
                              <td>
                                <?php echo $start_no++; ?>
                              </td>
                              <td>
                                <?php echo $value->type_ticket_name; ?>
                              </td>
                              <td>
                                <?php echo $value->status_order_name; ?>
                              </td>
                              <td>
                                <?php echo $value->sort_number; ?>
                              </td>
                              <td>
                                <a class="btn default btn-xs purple" href="<?php echo site_url("/settings/rules/edit/". $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                                <a class="btn default btn-xs black" href="<?php echo site_url("/settings/rules/delete/". $value->id); ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash-o"></i> Delete </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
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

<!-- Modal -->
<div class="modal fade" id="myModalLogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        Loading...
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>