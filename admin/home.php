<style>
  /* General Styles */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    /* Light gray background */
  }

  h1 {
    font-size: 2.5rem;
    color: #800000;
    /* Maroon color */
    text-align: center;
    margin: 20px 0;
  }

  hr {
    border: 0;
    height: 1px;
    background: #ddd;
    /* Light gray color */
    margin: 20px 0;
  }

  .container {
    padding: 0 15px;
    margin: 0 auto;
    max-width: 1200px;
    /* Maximum width of the container */
  }

  /* Row and Columns */
  .row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* Spacing between columns */
    margin: 0 auto;
  }

  .col-12 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .col-sm-6 {
    flex: 0 0 50%;
    max-width: 50%;
  }

  .col-md-3 {
    flex: 0 0 25%;
    max-width: 25%;
  }

  /* Info Boxes */
  .info-box {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    padding: 15px;
    margin-bottom: 20px;
    transition: box-shadow 0.3s ease;
  }

  .info-box:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .info-box-icon {
    font-size: 2rem;
    color: #fff;
    background-color: #800000;
    /* Maroon color */
    border-radius: 50%;
    padding: 15px;
    margin-right: 15px;
  }

  .info-box-content {
    flex: 1;
  }

  .info-box-text {
    font-size: 1rem;
    color: #666;
    /* Dark gray text */
    margin-bottom: 5px;
  }

  .info-box-number {
    font-size: 1.5rem;
    color: #333;
    /* Darker gray text */
  }

  /* Info Box Colors */
  .bg-maroon {
    background-color: #800000;
  }

  .bg-purple {
    background-color: #6f42c1;
    /* Purple color */
  }

  .bg-success {
    background-color: #28a745;
    /* Success green color */
  }

  .elevation-1 {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }


  /* Responsive Adjustments */
  @media (max-width: 768px) {

    .col-sm-6,
    .col-md-3 {
      flex: 0 0 100%;
      max-width: 100%;
    }
  }

  /* Clearfix for floating issues */
  .clearfix::after {
    content: "";
    display: table;
    clear: both;
  }
</style>

<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-maroon elevation-1"><i class="fas fa-mobile-alt"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Stocks</span>
        <span class="info-box-number">
          <?php
          $inv = $conn->query("SELECT sum(quantity) as total FROM inventory ")->fetch_assoc()['total'];
          $sales = $conn->query("SELECT sum(quantity) as total FROM order_list where order_id in (SELECT order_id FROM sales) ")->fetch_assoc()['total'];
          echo number_format($inv - $sales);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-th-list"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pending Orders</span>
        <span class="info-box-number">
          <?php
          $pending = $conn->query("SELECT sum(id) as total FROM `orders` where status = '0' ")->fetch_assoc()['total'];
          echo number_format($pending);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Sales Today</span>
        <span class="info-box-number">
          <?php
          $sales = $conn->query("SELECT sum(amount) as total FROM `orders` where date(date_created) = '" . date('Y-m-d') . "' ")->fetch_assoc()['total'];
          echo number_format($sales);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
<div class="container">
  <?php
  $files = array();
  $fopen = scandir(base_app . 'uploads/banner');
  foreach ($fopen as $fname) {
    if (in_array($fname, array('.', '..')))
      continue;
    $files[] = validate_image('uploads/banner/' . $fname);
  }
  ?>
  <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner h-100">
      <?php foreach ($files as $k => $img) : ?>
        <div class="carousel-item  h-100 <?php echo $k == 0 ? 'active' : '' ?>">
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