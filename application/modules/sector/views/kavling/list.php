<!-- Full Width Column -->
<div class="content-wrapper" style="overflow: auto;">
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
                  <div id="clickable" class="bullseye-coordinate">
                    <img src="<?php echo ORIGINALS_PHOTO_PATH . "/". $detail_sector->sketch; ?>">
                  </div>

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
                              <?php if ($value->status_valid == 1): // Available ?>
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Booking?">Booking</a>&nbsp;&nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REQUEST_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Request Booking?">Request Booking</a>
                              <?php elseif ($value->status_valid == 2): // Booked ?>
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Unbooking?">Unbooking</a>&nbsp;&nbsp;~&nbsp;
                                <a href="#clickable">View In Map</a>
                              <?php elseif ($value->status_valid == 3): // Sold ?>
                                <a href="#clickable">View In Map</a>
                              <?php elseif ($value->status_valid == 4): // Available Requested ?>
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Booking?">Booking</a>&nbsp;&nbsp;~&nbsp;
                                <a href="<?php echo site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING); ?>" class="confirmation" data-confirm-message="Anda yakin ingin mengupdate status menjadi Unbooking?">Unbooking</a>
                              <?php endif; ?>
                              <?php /*
                              <a class="btn default btn-xs purple" href="<?php echo site_url('sector/kavling/edit/'. $detail_sector->id .'/'. $value->id); ?>"><i class="fa fa-edit"></i> Edit </a>
                              */ ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
                  <div align="center">
                    <?php // echo $pagination; ?>
                  </div>
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
                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                  <button type="submit" class="btn btn-primary pull-right" name="submit-coordinat" id="submit-coordinat">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </div>
        </div> 
        <?php echo form_close(); ?>
    </div> 
</div> 

<!-- <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary">Create Order</button>  -->

<script type="text/javascript">
    $(document).ready(function() {
        <?php 
        foreach ($all_data as $key => $value): 
          if ($value->offset_x > 0 and $value->offset_y > 0):
            $content = "";
            if ($value->status_valid == 1): // Available
              $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REQUEST_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Request Booking?'>Request Booking</a>";
            elseif ($value->status_valid == 2): // Booked
              $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
            elseif ($value->status_valid == 3): // Sold
              $content = "";
            elseif ($value->status_valid == 4): // Available Requested
              $content = "~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) ."' class='confirmation' data-confirm-message='Anda yakin ingin menghapus kordinat ini?'>Hapus dari Peta</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_BOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Booking?'>Booking</a><br>~&nbsp;&nbsp;<a href='". site_url("sector/kavling/update_status/". $detail_sector->id ."/". $value->id ."/". STATUS_BOOKING_KAVLING_UNBOOKING) ."' class='confirmation' data-confirm-message='Anda yakin ingin mengupdate status menjadi Unbooking?'>Unbooking</a>";
            endif;
        ?>
          $('.bullseye-coordinate').bullseye({
            top: <?php echo $value->offset_y; ?>, // Determines bullseye position from top.
            left: <?php echo $value->offset_x; ?>, // Determines bullseye position from left.
            // bottom: 0, // ̊Determines bullseye position from right.
            heading: "<?php echo $value->street_name .", ". $value->block_name .", ". $value->house_number; ?>", // Heading content
            content: "<?php echo $content; ?>", // Paragraph content
            orientation: "top", // <a href="https://www.jqueryscript.net/tooltip/">Tooltip</a> orientation
            color: "#fzff", // Dot and dot animation color. 
            // onHoverMarkAsRead: false
          });
        <?php 
          endif;
        endforeach; 
        ?>

        $('#clickable').bind('click', function (ev) {
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
    });
</script>