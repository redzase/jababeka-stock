
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jababeka Control Center
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Dashboard</a></li>
        <li class="active">Jababeka Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <?php 
        if (isset($this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["menu"])):
          foreach ($this->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["menu"] as $key => $value):
        ?>
            <div class="col-lg-2 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $value["name"]; ?></h3>
                </div>
                <a href="<?php echo $value["url"]; ?>" target="_blank" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
        <?php 
          endforeach;
        endif;
        ?>

      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->

