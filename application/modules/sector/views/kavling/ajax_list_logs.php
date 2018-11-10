<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="myModalLabel">View Log - <?php echo $sector_name; ?></h4>
</div>
<div class="modal-body">
  <div style="clear: both;"></div>
  <table class="table table-hover table-bordered" style="margin-top: 20px;">
    <thead>
      <tr>
        <th><center>#</center></th>
        <th><center>Date Time</center></th>
        <th><center>Kavling</center></th>
        <th><center>User</center></th>
        <th><center>Note</center></th>
        <th><center>Action</center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($all_data as $key => $value): ?>
        <tr>
          <td><?php echo $start_no++; ?></td>
          <td><?php echo date_now(12, $value->created_date); ?></td>
          <td><?php echo $value->foreign_id_name; ?></td>
          <td><?php echo $value->username; ?></td>
          <td><?php echo $value->note; ?></td>
          <td><?php echo unserialize(LOGS_ACTIVITY_LIST)[$value->activity]; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div align="center">
    <?php echo $pagination; ?>
  </div>
</div>