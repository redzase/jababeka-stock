<link rel="stylesheet" href="<?php echo base_url()?>static/css/timeline.css">

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
      Memo
        <small>detail memo </small>
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
                            <a href="<?php echo site_url("memo") ?>" class="btn btn-danger">Clear</a>
                            <button type="submit" class="btn btn-primary" name="submit-filter" id="submit-sector">Filter</button>
                          </div>
                      </div>
                      <!-- /.box-footer -->
                      <?php echo form_close(); ?>
                  </div>

                  <div class="col-md-12 table-responsive no-padding">
                      <div id="box-main" style="min-width:1024px;width:100%;">
                        <div id="box-left" style="float:left;width:20%;">
                          <div style="height:40px;text-align:right;padding-right:20px;line-height:40px;border-bottom: 2px solid;border-right:2px solid;">Year</div>
                          <div class="box-secmony">Sector / Month</div>
                          <?php foreach ($all_data_sector as $key => $value): ?>
                            <div class="box-title"><a href="<?php echo site_url("pricelist/list/". $value->id); ?>"><?php echo $value->name; ?></a></div>
                          <?php endforeach; ?>
                          <div class="box-secmony">Sector / Month</div>

                        </div>

                        <div id="box-right" style="float:left;width:79%;position:relative;">
                          <div class="year"><?php echo (empty($filter_year)) ? date("Y") : $filter_year; ?></div>
                          <div>
                            <div class="month">Jan</div>
                            <div class="month">Feb</div>
                            <div class="month">Mar</div>
                            <div class="month current-month">Apr</div>
                            <div class="month">May</div>
                            <div class="month">Jun</div>
                            <div class="month">Jul</div>
                            <div class="month">Aug</div>
                            <div class="month">Sep</div>
                            <div class="month">Oct</div>
                            <div class="month">Nov</div>
                            <div class="month">Des</div>
                            <div style="clear:both;"></div>
                          </div>

                          <?php foreach ($all_data_sector as $key => $value): ?>
                            <div class="box-bar">
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar current-month"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div class="month-bar"></div>
                              <div style="clear:both;"></div>

                              <?php 
                              if (isset($list_memo[$value->id])):
                                $bar_one_month = 8.3;
                                $item_colors = ["red", "maroon", "olive", "green", "teal", "blue"];

                                foreach ($list_memo[$value->id] as $key_memo => $value_memo): 
                                  $left  = ($value_memo["start_month"] - 1) * $bar_one_month;
                                  $width = ($value_memo["total_range_month"] + 1) * $bar_one_month;
                                  $random_keys = array_rand($item_colors,1);
                              ?>
                                <div class="bar" style="left:<?php echo $left; ?>%;width:<?php echo $width; ?>%;background-color:<?php echo $item_colors[$random_keys]; ?>;">
                                  <a href="<?php echo ORIGINALS_PDF_PATH . "/". $value_memo["filepath"]; ?>" target="_blank" style="color:white;"><?php echo $value_memo["title"]; ?></a>
                                </div>
                              <?php 
                                endforeach; 
                              endif;
                              ?>
                            </div>
                          <?php endforeach; ?>

                          <div>
                            <div class="month">Jan</div>
                            <div class="month">Feb</div>
                            <div class="month">Mar</div>
                            <div class="month current-month">Apr</div>
                            <div class="month">May</div>
                            <div class="month">Jun</div>
                            <div class="month">Jul</div>
                            <div class="month">Aug</div>
                            <div class="month">Sep</div>
                            <div class="month">Oct</div>
                            <div class="month">Nov</div>
                            <div class="month">Des</div>
                            <div style="clear:both;"></div>
                          </div>
                        </div>
                      </div>
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
  })
</script>
