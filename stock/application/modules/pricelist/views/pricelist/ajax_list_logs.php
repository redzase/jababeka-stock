<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="myModalLabel">View Log</h4>
</div>
<div class="modal-body">
  <div style="clear: both;"></div>
  <table class="table table-hover table-bordered" style="margin-top: 20px;">
    <thead>
      <tr>
        <th><center>#</center></th>
        <th><center>Title</center></th>
        <th><center>Pricelist</center></th>
        <th><center>Start Date</center></th>
        <th><center>End Date</center></th>
        <th><center>Upload Time</center></th>
        <th><center>Upload User</center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($all_data as $key => $value): ?>
        <tr>
          <td><?php echo $start_no++; ?></td>
          <td><?php echo $value->title; ?></td>
          <td><a href="<?php echo ORIGINALS_PDF_PATH . "/". $value->filepath; ?>" target="_blank"><?php echo $value->filename; ?></a></td>
          <td><?php echo date_now(13, $value->start_date); ?></td>
          <td><?php echo date_now(13, $value->end_date); ?></td>
          <td><?php echo date_now(13, $value->created_date); ?></td>
          <td><?php echo $value->created_by_name; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div align="center">
    <?php echo $pagination; ?>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $(".paginate_button").click(function() {
      var url = $(this).children("a").attr("href");

      // JIKA HREF KOSONG ATAU '#'
      if (url == "" || url == "#")
        return false;

      $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(data) {
          $("#myModalLogs .modal-content").html(data);
        }
      });

      return false;
    });

  });
</script>