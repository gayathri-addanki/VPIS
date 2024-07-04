<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-map"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">State List</span>
                <span class="info-box-number">
                  <?php 
                    $state = $conn->query("SELECT * FROM state_list where delete_flag = 0 and `status` = 1")->num_rows;
                    echo format_num($state);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-map-marked-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">City List</span>
                <span class="info-box-number">
                  <?php 
                    $city = $conn->query("SELECT * FROM city_list where delete_flag = 0 and `status` = 1")->num_rows;
                    echo format_num($city);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-building"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Location List</span>
                <span class="info-box-number">
                  <?php 
                    $location = $conn->query("SELECT * FROM location_list where delete_flag = 0 and `status` = 1")->num_rows;
                    echo format_num($location);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-door-open"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Precincts List</span>
                <span class="info-box-number">
                  <?php 
                    $precinct = $conn->query("SELECT * FROM precinct_list where delete_flag = 0 and `status` = 1")->num_rows;
                    echo format_num($precinct);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Active Voter</span>
                <span class="info-box-number">
                  <?php 
                    $voter = $conn->query("SELECT * FROM voter_list where `status` = 1")->num_rows;
                    echo format_num($voter);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-daner elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Inactive Voter</span>
                <span class="info-box-number">
                  <?php 
                    $voter = $conn->query("SELECT * FROM voter_list where `status` = 0")->num_rows;
                    echo format_num($voter);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
