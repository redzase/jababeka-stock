<div class="modal-header">
  <button type="button" class="close" style="color: grey;" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="myModalLabel">Detail Rules <?php echo $name_type; ?></h4>
</div>
<div class="modal-body">
  <div class="col-md-12">
  <?php if(isset($all_data) && count($all_data) > 0 ): ?>
    <?php foreach($all_data as $key => $value): ?>
        <div class="box">
          <div class="box-body">
            From 
            <span class="text-bold" style="text-transform: uppercase;">
              <?php echo $key; ?>
            </span>
            <br>Can be change status to :
            <br>
            <br>
            <?php foreach ($value as $k => $v): ?>
              <div class="col-sm-12">
                <div class="box box-solid">
                  <div class="box-body bg-warning">
                    <b><?php echo $k; ?></b> assign to division <b><i><?php echo $v; ?></i></b>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <div class="box">
    <div class="box-body">
      <span class="text-bold" style="text-transform: uppercase;">Close</span>
    </div>
  </div>
  </div>
  <div style="clear: both;"></div>
</div>