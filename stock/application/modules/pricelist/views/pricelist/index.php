<?php

if (isset($all_data_pricelist)) {
  $filter_list_sector = $filter["list_sector"];
  $filter_year        = $filter["year"];
} 
else {
  $filter_list_sector = FALSE;
  $filter_year        = FALSE;
}

?>

<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Pricelist
        <small>detail pricelist </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url("pricelist"); ?>">Pricelist</a></li>
        <li class="active">Detail Pricelist</li>
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

                  <div class="col-md-12">
                      <?php echo form_open(uri_string(), array("id" => "form_sample_3", "class" => "form-horizontal", "method" => "GET")); ?>
                      <div class="box-body">

                          <div class="form-group">
                              <label for="inputPassword3" class="col-sm-2 control-label">Sector</label>

                              <div class="col-sm-9">
                                  <?php echo form_dropdown('select_sector[]', $list_sector, set_value("select_sector[]", $filter_list_sector), 'class="form-control" multiple="multiple"'); ?>
                              </div>
                          </div>     

                          <div class="form-group">
                              <label for="inputPassword3" class="col-sm-2 control-label">Tahun</label>

                              <div class="col-sm-9">
                                  <?php echo form_dropdown('select_year', $list_year, set_value("select_year", $filter_year), 'class="form-control"'); ?>
                              </div>
                          </div>     
                        
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                          <div class="pull-right">
                            <a href="<?php echo site_url("pricelist") ?>" class="btn btn-danger">Clear</a>
                            <button type="submit" class="btn btn-primary" name="submit-filter" id="submit-sector">Filter</button>
                          </div>
                      </div>
                      <!-- /.box-footer -->
                      <?php echo form_close(); ?>
                  </div>

                  <div id="timeline-visualization">
                    <?php if ($is_get and count($all_data_pricelist) == 0): ?>
                      <h3 align="center">No data found.</h3>
                    <?php endif; ?>
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

<script type="text/javascript">
  $(document).ready(function() {
    $('select[multiple]').multiselect({
      columns  : 3,
      search   : true,
      selectAll: true,
      texts    : {
          placeholder: 'Pilih Sector',
          search     : 'Cari Sector'
      }
    });

    // create groups
    var numberOfGroups = <?php echo count($all_data_sector); ?>; 
    var groups = new vis.DataSet()
    <?php foreach ($all_data_sector as $key => $value): ?>
     groups.add({
        id: <?php echo $value->id; ?>,
        content: '<a href="<?php echo site_url("pricelist/list/". $value->id); ?>"><?php echo addslashes($value->name); ?></a>'
      })   
    <?php endforeach; ?>

    var items = new vis.DataSet();
   
    <?php foreach ($all_data_pricelist as $key => $value): ?>
      items.add({
        id: <?php echo $value->id; ?>,
        group: <?php echo $value->sector_id; ?>,
        start: '<?php echo $value->start_date; ?>',
        end: '<?php echo $value->end_date; ?>',
        content: '<a href="<?php echo ORIGINALS_PDF_PATH . "/". $value->filepath; ?>" target="_blank"><?php echo $value->filename; ?></a>',
      });
    <?php endforeach; ?>

    // specify options
    var currentYear = <?php echo (empty($filter_year)) ? date("Y") : $filter_year; ?>;
    var options = {
      stack: true,
      horizontalScroll: false,
      zoomable: false,
      moveable: true,
      // zoomKey: 'ctrlKey',
      // maxHeight: 400,
      start: currentYear +'-01-01',
      end: currentYear +'-12-31',
      editable: false,
      margin: {
        item: 10, // minimal margin between items
        axis: 5   // minimal margin between items and the axis
      },
      orientation: 'top'
    };

    // create a Timeline
    var container = document.getElementById('timeline-visualization');
    timeline = new vis.Timeline(container, items, groups, options);
  })
</script>
