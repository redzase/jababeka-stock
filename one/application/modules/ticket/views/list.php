<?php
  $activeTab = $this->uri->segment(4);
?>
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Ticket - <?php echo $name_type; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("ticket/index/".$id_type); ?>">Ticket</a></li>
        <li class="active"><?php echo $name_type; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

          <?php echo get_validate_form(); ?>        
          <?php echo get_validate_sess($ses_result_process); ?>

          <div class="col-md-12">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="<?php echo !$activeTab ? 'active' : ''; ?>" aria-expanded="true"><a href="/ticket/list/<?php echo $id_type; ?>/">ALL
                <?php 
                foreach ($all_data_rules as $key => $value): 
                ?>
                  <li class="<?php echo $activeTab == $value->id_status ? 'active' : ''; ?>" aria-expanded="true"><a href="/ticket/list/<?php echo $id_type . "/" . $value->id_status; ?>/"><?php echo strtoupper($value->status_order_name); ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>

              <div class="box box-info">

              <!-- form start -->
              <div class="box-body">

                  <p class="pull-left" style="margin-left:10px;">
                      <a href="<?php echo site_url('/ticket/index/'.$id_type) ?>">
                        <i class="fa fa-arrow-left"></i>&nbsp; Back to Ticket
                      </a> 
                  </p>

                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('/ticket/add/' . $id_type) ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp; Add Ticket
                      </a> 
                  </p>
                  <div style="clear:both;"></div>
                  <div class="table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status Order</th>
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
                                <?php echo $value->name; ?>
                              </td>
                              <td>
                                <?php echo $value->description; ?>
                              </td>
                              <td>
                                <span class="btn-xs bg-purple"><?php echo $value->status_order_name; ?></span>
                              </td>
                              <td>
                                <a class="btn default btn-xs purple" href="<?php echo site_url("/ticket/detail/" . $id_type . "/" . $value->id_status . "/" . $value->id); ?>"><i class="fa fa-book"></i> Detail </a>
                                <?php if ($value->id_status == $data_status_first->id) : ?>
                                  <a class="btn default btn-xs purple" href="<?php echo site_url("/ticket/edit/" . $id_type . "/" . $value->sort_number . "/" . $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                                  <a class="btn default btn-xs black" href="<?php echo site_url("/ticket/delete/". $id_type . "/" . $value->id); ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash-o"></i> Delete </a>
                                <?php endif; ?>

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