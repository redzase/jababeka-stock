<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Rules <?php echo $name_type; ?>
        <small>Status per type ticket</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('/ticket/index/'.$id_type) ?>">Ticket <?php echo $name_type; ?></a></li>
        <li class="active">Rules <?php echo $name_type; ?></li>
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
                      <a href="<?php echo site_url('/ticket/index/'.$id_type) ?>">
                        <i class="fa fa-arrow-left"></i>&nbsp; Back to ticket <?php echo $name_type; ?>
                      </a> 
                  </p>

                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('/settings/rules/edit/'. $id_type) ?>" class="btn btn-primary">
                        <i class="fa fa-edit"></i>&nbsp; Edit Rules
                      </a> 
                  </p>
                  <div style="clear:both;"></div>
                  <div class="table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>Type Ticket</th>
                                <th>Sequence</th>
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
                                <?php echo $value->status_order_name; ?>
                              </td>
                              <?php
                                if (!$value->default):
                              ?>
                                <td>
                                  <?php echo $value->sort_number; ?>
                                </td>
                              <?php
                                else:
                              ?>
                                  <td>
                                  <?php 
                                    if ($value->status_order == '1'):
                                      echo '##';
                                    else:
                                      echo '##';
                                    endif
                                  ?>
                                </td>
                              <?php
                                endif
                              ?>
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