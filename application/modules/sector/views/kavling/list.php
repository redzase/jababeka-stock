<?php

if (isset($all_data)) {
  $reference_kavling_id = $filter["reference_kavling_id"];
  $street_name = $filter["street_name"];
  $filter_status = $filter["filter_status"];
} 
else {
  $reference_kavling_id = FALSE;
  $street_name = FALSE;
  $filter_status = FALSE;
}

?>

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

          <?php echo get_validate_form(); ?>        
          <?php echo get_validate_sess($ses_result_process); ?>

          <div class="col-md-12">
              <div class="box box-info">

              <!-- form start -->
              <div class="box-body" style="overflow: auto;">

                  <form class="form-horizontal" id="form-role">
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
                  </form>

                  <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="col-sm-10">
                        <div class="table-responsive">
                          <table class="table no-margin">
                            <thead>
                              <tr>
                                <th>Total</th>
                                <th>Terjual</th>
                                <?php /*
                                <th>Available Requested</th>
                                */ ?>
                                <th>Available</th>
                                <th>Booked</th>
                              </tr>
                            </thead>
                            <tbody style="font-size:36px;font-weight:bold;">
                              <tr>
                                <td><?php echo $detail_sector->total; ?></td>
                                <td><?php echo $detail_sector->sold; ?></td>
                                <?php /*
                                <td><?php echo $detail_sector->available_requested; ?></td>
                                */ ?>
                                <td><?php echo $detail_sector->available; ?></td>
                                <td><?php echo $detail_sector->booked; ?></td>
                              </tr>
                            </tbody>
                          </table>
                          <div align="center">
                            <?php // echo $pagination; ?>
                          </div>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                      <div class="col-lg-2 col-xs-4">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                          <div class="inner">
                            <h3 align="center"><?php echo $detail_sector->total > 0 ? round((($detail_sector->sold / $detail_sector->total) * 100), 2) : 0; ?>%</h3>
                            <hr style="margin:-5px 0 3px 0;">
                            <h3 align="center">SOLD</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.box-footer -->
                  </div>

                  <h3 style="font-weight:bold;text-decoration:underline;">File Denah Perumahan</h3>
                  <div <?php echo check_access_module_permission($module, PERMISSION_MAPPING) ? "id='clickable'" : ""; ?>  class="bullseye-coordinate">
                    <img src="<?php echo ORIGINALS_PHOTO_PATH . "/". $detail_sector->sketch; ?>">
                  </div>

                  <h3 style="font-weight:bold;text-decoration:underline;">List Kavling</h3>
                  <div class="col-md-12">
                      <div class="box box-info">
                      <div class="box-header ">
                      <!-- <h3 class="box-title">Product Form</h3> -->
                      </div>
                      <!-- /.box-header -->
                      <!-- form start -->
                      <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "method" => "GET")); ?>
                      <div class="box-body">

                          <div class="form-group">
                              <label for="inputPassword3" class="col-sm-2 control-label">Kavling Ref</label>

                              <div class="col-sm-9">
                                  <?php echo form_input("reference_kavling_id", set_value("reference_kavling_id", $reference_kavling_id), "data-required='1' class='form-control' placeholder='Kavling Ref'"); ?>
                              </div>
                          </div>     

                          <div class="form-group">
                              <label for="inputPassword3" class="col-sm-2 control-label">Nama Jalan</label>

                              <div class="col-sm-9">
                                  <?php echo form_input("street_name", set_value("street_name", $street_name), "data-required='1' class='form-control' placeholder='Nama Jalan'"); ?>
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputPassword3" class="col-sm-2 control-label">Status</label>

                              <div class="col-sm-9">
                                <div class="checkbox">
                                  <label>
                                    <?php echo form_checkbox('chk_filter_status[]', '3', set_checkbox('chk_filter_status[]', '3', (in_array('3', $filter_status)) ? TRUE : FALSE)); ?> Sold
                                  </label>
                                  <label style="margin-left:15px;">
                                    <?php echo form_checkbox('chk_filter_status[]', '1', set_checkbox('chk_filter_status[]', '1', (in_array('1', $filter_status)) ? TRUE : FALSE)); ?> Available
                                  </label>
                                  <label style="margin-left:15px;">
                                    <?php echo form_checkbox('chk_filter_status[]', '2', set_checkbox('chk_filter_status[]', '2', (in_array('2', $filter_status)) ? TRUE : FALSE)); ?> Booked
                                  </label>
                                </div>
                              </div>
                          </div>
                        
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                          <div class="pull-right">
                            <a href="<?php echo site_url("sector/kavling/index/". $detail_sector->id) ?>" class="btn btn-danger">Clear</a>
                            <button type="submit" class="btn btn-primary" name="submit-filter" id="submit-sector">Filter</button>
                          </div>
                      </div>
                      <!-- /.box-footer -->
                      <?php echo form_close(); ?>
                  </div>
                  </div>

                  <p class="pull-left" style="margin-left:10px;">
                      <a class="btn btn-primary view-log" data-toggle="modal" data-target="#myModalLogs" data-url="<?php echo site_url('sector/kavling/ajax_list_logs/'. $detail_sector->id); ?>">
                        View Log
                      </a>
                  </p>

                  <p class="pull-left" style="margin-left:10px;">
                      <?php echo form_dropdown('select_pagination', $arr_pagination, set_value("select_pagination", $per_page), 'class="form-control"'); ?>
                  </p>

                  <p class="pull-right" style="margin-left:10px;">
                      <a href="<?php echo site_url('sector/kavling/import/'. $detail_sector->id) ?>" class="btn btn-primary">
                        Import
                      </a>
                      <?php 
                      if (check_access_module_permission($module, PERMISSION_CREATE)):
                      ?>
                      <a href="<?php echo site_url('sector/kavling/add/'. $detail_sector->id) ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Kavling
                      </a> 
                      <?php 
                      endif;
                      ?>
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
                              <a href="<?php echo site_url('sector/kavling/edit/'. $detail_sector->id .'/'. $value->id); ?>">
                                <?php echo $value->reference_kavling_id; ?>
                              </a>
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
                              <?php echo $list_status_kavling[$value->status_valid]; ?>
                            </td>
                            <td>
                              <?php 
                              if (check_access_module_permission($module, PERMISSION_DELETE)):
                              ?>
                              <a href="<?php echo site_url("sector/kavling/delete/". $detail_sector->id ."/". $value->id); ?>" class="confirmation" data-confirm-message="Anda yakin ingin menghapus data ini?">Delete</a>
                              <?php 
                              endif;
                              ?>
                              <?php if ($value->status_valid == 1): // Available ?>
                                <?php 
                                if (check_access_module_permission($module, PERMISSION_BOOKING)):
                                ?>
                                &nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Booking?">Booking</a>
                                <?php /*
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REQUEST_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Request Booking?">Request Booking</a>
                                */ ?>
                                <?php 
                                endif;
                                ?>
                              <?php elseif ($value->status_valid == 2): // Booked ?>
                                <?php 
                                if (check_access_module_permission($module, PERMISSION_UNBOOKING)):
                                ?>
                                &nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Unbooking?">Unbooking</a>
                                <?php 
                                endif;
                                ?>
                              <?php /* elseif ($value->status_valid == 3): // Sold ?>
                                &nbsp;~&nbsp;<a href="#clickable">View In Map</a>
                              <?php */ elseif ($value->status_valid == 4): // Available Requested ?>
                                <?php 
                                if (check_access_module_permission($module, PERMISSION_BOOKING)):
                                ?>
                                &nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Booking?">Booking</a>
                                <?php 
                                endif;
                                if (check_access_module_permission($module, PERMISSION_UNBOOKING)):
                                ?>
                                &nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Unbooking?">Unbooking</a>
                                <?php 
                                endif;
                                ?>
                              <?php endif; ?>
                              <?php if ($value->offset_x > 0 or $value->offset_y > 0): // Available Requested ?>
                                <?php if (in_array($value->status_valid, [1, 2, 3, 4])): ?>
                                  &nbsp;~&nbsp;
                                <?php endif; ?>
                                <a href="#clickable" class="view-in-map" data-uniqueid="<?php echo $value->id; ?>">View In Map</a>
                              <?php endif; ?>
                              &nbsp;~&nbsp;
                              <a href="#" class="view-log" data-toggle="modal" data-target="#myModalLogs" data-url="<?php echo site_url('sector/kavling/ajax_list_logs/'. $detail_sector->id ."/". $value->id); ?>">View Log</a>
                              <?php /*
                              <a class="btn default btn-xs purple" href="<?php echo site_url('sector/kavling/edit/'. $detail_sector->id .'/'. $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                              */ ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
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

<?php 
if (check_access_module_permission($module, PERMISSION_MAPPING)):
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal")); ?>
        <div class="modal-content">
            <div class="modal-header">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
              <h4 class="modal-title" id="myModalLabel">Pilih Kavling</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Kordinat<br><span id="selected-coordinate">(x: 0, y: 0)</span></label>
                  <div class="col-sm-9">
                    <?php echo form_dropdown('select_kavling', $all_kavling, set_value("select_kavling", ""), 'class="form-control"'); ?>
                    <input type='hidden' name='offset_x' value='' />
                    <input type='hidden' name='offset_y' value='' />
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <button type="button" class="btn btn-primary pull-right" name="submit-coordinat" id="submit-coordinat">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </div>
        </div> 
        <?php echo form_close(); ?>
    </div> 
</div> 
<?php 
endif;
?>

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

<!-- <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary">Create Order</button>  -->

<script type="text/javascript">
    $(document).ready(function() {
        <?php 
        foreach ($all_data as $key => $value): 
          if ($value->offset_x > 0 and $value->offset_y > 0):
            $content = "";
            $coordinate_color = "#0011a1";
            $coordinate_size = $value->icon_size;
            $uniqueid = $value->id;
            if ($value->status_valid == 1): // Available
              // $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a>";
              if (check_access_module_permission($module, PERMISSION_DELETE)):
                $content .= "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>";
              endif;
              if (check_access_module_permission($module, PERMISSION_BOOKING)):
                $content .= "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a>";
              endif;
              $coordinate_color = $value->color_available;
            elseif ($value->status_valid == 2): // Booked
              // $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
              if (check_access_module_permission($module, PERMISSION_DELETE)):
                $content .= "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>";
              endif;
              if (check_access_module_permission($module, PERMISSION_UNBOOKING)):
                $content .= "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
              endif;
              $coordinate_color = $value->color_booked;
            elseif ($value->status_valid == 3): // Sold
              if (check_access_module_permission($module, PERMISSION_DELETE)):
                $content .= "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a>";
              endif;
              $coordinate_color = $value->color_sold;
            elseif ($value->status_valid == 4): // Available Requested
              // $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
              if (check_access_module_permission($module, PERMISSION_DELETE)):
                $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>";
              endif;
              if (check_access_module_permission($module, PERMISSION_BOOKING)):
                $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a><br>";
              endif;
              if (check_access_module_permission($module, PERMISSION_UNBOOKING)):
                $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
              endif;
              $coordinate_color = $value->color_requested;
            endif;
        ?>
          $('.bullseye-coordinate').bullseye({
            top: <?php echo $value->offset_y; ?>, // Determines bullseye position from top.
            left: <?php echo $value->offset_x; ?>, // Determines bullseye position from left.
            // bottom: 0, // ̊Determines bullseye position from right.
            heading: "<?php echo $value->street_name .", ". $value->block_name .", ". $value->house_number; ?>", // Heading content
            content: "<?php echo $content; ?>", // Paragraph content
            orientation: "top", // <a href="https://www.jqueryscript.net/tooltip/">Tooltip</a> orientation
            color: "<?php echo $coordinate_color; ?>", // Dot and dot animation color. 
            size: <?php echo $coordinate_size; ?>, // Coordinate size
            uniqueid: <?php echo $uniqueid; ?>, // Unique ID
            // onHoverMarkAsRead: false
          });
        <?php 
          endif;
        endforeach; 
        ?>

        $(document).on("click",function(ev){
            $('.jqBullseye').find('.bullseyeTooltip').fadeOut();
        }); 
        
        <?php 
        if (check_access_module_permission($module, PERMISSION_MAPPING)):
        ?>
        $("#clickable").on("contextmenu",function(ev){
            // var $div = $(ev.target);
            // // var $display = $div.find('.display');

            // var offset = $div.offset();
            var offset = $(this).offset();
            var x = ev.pageX - offset.left - 10;
            var y = ev.pageY - offset.top - 10;

            // $display.text('x: ' + x + ', y: ' + y);
            $('#myModal').find("#selected-coordinate").text('(x: ' + x + ', y: ' + y +')');
            $('#myModal').find("input[name=offset_x]").val(x);
            $('#myModal').find("input[name=offset_y]").val(y);
            $('#myModal').modal('show');
          return false;
        }); 
        <?php 
        endif;
        ?>

        $(".view-in-map").click(function(e) {
          var uniqueid = $(this).data("uniqueid");

          $('.jqBullseye').on('click.bullseye', $('.uniqueid-'+ uniqueid).find('.bullseyeTooltip').fadeIn());
          e.stopPropagation();
          return true;
        });

        $(".confirmation").click(function() {
          var confirm_message = $(this).data("confirm-message");
          var answer = confirm(confirm_message);

          if (answer) {
            $('#clickable').unbind('click');
            return true;
          }

          return false;
        });

        $("select[name=select_pagination]").change(function() {
          var per_page = $(this).val();

          $(location).attr('href', "<?php echo $site_url; ?>/?perpage=" + per_page);
        });

        $(".view-log").click(function() {
          var url = $(this).data("url");
          
          // $("#notification").empty();
          // $("#myModal").find(".modal-dialog").css("width", "800px");
          
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