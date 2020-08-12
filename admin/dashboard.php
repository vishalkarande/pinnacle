<?php
$active_tab = 'dashboard';
require_once('templates/header.php');
require_once('templates/sidebar.php');
$new_orders = $QueryFire->getAllData('orders',' status="in-process"');
$users = $QueryFire->getAllData('users',' is_deleted=0');
$requests = $QueryFire->getAllData('contact_enquiry',' 1');
$books = $QueryFire->getAllData('books',' is_deleted=0');
$journals = $QueryFire->getAllData('journal',' is_deleted=0');
$chapters = $QueryFire->getAllData('chapter','is_deleted=0');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= count($new_orders)?></h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="new-orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= count($users)?></h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= count($requests)?></h3>

              <p>Contact Requests</p>
            </div>
            <div class="icon">
              <i class="fas fa-phone-volume"></i>
            </div>
            <a href="contact-request" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= count($books)?></h3>

              <p>Total Books</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="books" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= count($journals)?></h3>

              <p>Total Journals</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="journal" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= count($chapters)?></h3>

              <p>Total Chapters</p>
            </div>
            <div class="icon">
              <i class="fas fa-phone-volume"></i>
            </div>
            <a href="chapter" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
<?php require_once('templates/footer.php');?>
