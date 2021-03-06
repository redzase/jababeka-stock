<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Memo
        <small>list memo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("memo"); ?>">Memo</a></li>
        <li class="active">Detail Memo</li>
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

                  <h3 class="pull-left" style="margin-top:5px;"><?php echo $detail_sector->name; ?></h3>
                  <p class="pull-right" style="margin-left:10px;">
                      <a class="btn btn-primary view-log" data-toggle="modal" data-target="#myModalLogs" data-url="<?php echo site_url('memo/ajax_list_logs/'. $detail_sector->id); ?>">
                        View Log
                      </a>
                      <?php 
                      if (check_access_module_permission($module, PERMISSION_CREATE)):
                      ?>
                      <a href="<?php echo site_url('memo/add/'. $detail_sector->id) ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Memo
                      </a> 
                      <?php 
                      endif;
                      ?>
                  </p>
                  <div style="clear:both;"></div>
                  <div class="table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Memo</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Upload Time</th>
                                <th>Upload User</th>
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
                                <?php echo $value->title; ?>
                              </td>
                              <td>
                                <a href="<?php echo ORIGINALS_PDF_PATH . "/". $value->filepath; ?>" target="_blank"><?php echo $value->filename; ?></a>
                              </td>
                              <td>
                                <?php echo date_now(13, $value->start_date); ?>
                              </td>
                              <td>
                                <?php echo date_now(13, $value->end_date); ?>
                              </td>
                              <td>
                                <?php echo date_now(12, $value->created_date); ?>
                              </td>
                              <td>
                                <?php echo $value->created_by_name; ?>
                              </td>
                              <td>
                                <?php 
                                if (check_access_module_permission($module, PERMISSION_UPDATE)):
                                ?>
                                <a class="btn default btn-xs purple" href="<?php echo site_url("memo/edit/". $detail_sector->id ."/". $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                                <?php 
                                endif;
                                if (check_access_module_permission($module, PERMISSION_DELETE)):
                                ?>
                                <a class="btn default btn-xs black" href="<?php echo site_url("memo/delete/". $detail_sector->id ."/". $value->id); ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash-o"></i> Delete </a>
                                <?php
                                endif;
                                ?>
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
        $(".view-log").click(function() {
          var url = $(this).data("url");
          
          $("#myModalLogs").find(".modal-dialog").css("width", "800px");
          
          $.ajax({
            type: "POST",
            url: url,
            cache: false,
            success: function(data) {
              $("#myModalLogs .modal-content").html(data);
            }
          });

          return true;
        });
    });
</script>