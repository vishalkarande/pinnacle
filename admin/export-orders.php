<?php
$active_tab = "orders";
$active_sub_tab = 'export orders';
require_once('templates/header.php');
require_once('templates/sidebar.php');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Export Order Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="orders">Orders</a></li>
            <li class="breadcrumb-item active">Export</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="card card-info">
          <div class="card-header"> 
            <span><h1 class="card-title"><b> Export Orders Between Dates</b></h1></span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="export-data" method="post" class="toFrom">
                  <div class="form-group">
                    <label for="from"> Date From :</label>
                    <input type="text" name="from" class="form-control dateTime" placeholder="Enter date" />
                  </div>
                  <div class="form-group">
                    <label for="to"> Date To :</label>
                    <input type="text" name="to" class="form-control dateTime" placeholder="Enter date" />
                  </div>
                  <div class="form-group">
                    <input type="submit" name="eData" class="btn btn-info" value="Export" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="card card-success">
          <div class="card-header"> 
            <span><h1 class="card-title"><b> Export Monthly Orders</b></h1></span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="export-data" method="post" class="month">
                  <div class="form-group">
                    <label for="month"> Select Month:</label>
                    <select name="month" class="form-control">
                      <option value="">-- Select Month--</option>
                      <?php
                      for($m=1; $m<=12; $m++)
                      {
                        $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                        echo '<option value="'.$m.'">'.$month.'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="eMonth" class="btn btn-success" value="Export" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-12 pull-right">
        <div class="card card-warning">
          <div class="card-header"> 
            <span><h1 class="card-title"><b> Export Yearly Orders</b></h1></span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="export-data" method="post" class="year">
                  <div class="form-group">
                    <label for="month"> Select Year:</label>
                    <select name="year" class="form-control">
                      <option value="">-- Select Year--</option>
                      <?php
                      for($m=2020; $m<=date('Y'); $m++)
                      {
                        echo '<option value="'.$m.'">'.$m.'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="eYearly" class="btn btn-warning" value="Export" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-12 pull-left">
        <div class="card card-danger">
          <div class="card-header"> 
            <span><h1 class="card-title"><b> Export All Orders</b></h1></span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="export-data" method="post">
                  <div class="form-group">
                    Do you want to export all order report?
                  </div>
                  <div class="form-group">
                    <input type="submit" name="eAll" class="btn btn-danger" value="Export All Orders" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".dateTime").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        maxDate: new Date(),
        locale: {
          format: "YYYY-MM-DD"
        },
      });
      $(".dateTime").val("");
      jQuery(".month").validate({
        rules: {
          month: "required",
        },
        messages: {
          month: "Select Month",
        }
      });
      jQuery(".year").validate({
        rules: {
          year: "required",
        },
        messages: {
          year: "Select Year",
        }
      });
      jQuery(".toFrom").validate({
        rules: {
          to: "required",
          from: "required",
        },
        messages: {
          to: "Enter / select date from you want orders",
          from: "Enter / select date upto you want orders",
        }
      });
    });
  </script>';
require_once('templates/footer.php');?>