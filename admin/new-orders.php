<?php
$active_tab = 'orders';
$active_sub_tab = 'new orders';
$prependScript="";
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['order_id'])) {
    if($QueryFire->upDateTable("orders","id=".$_POST['order_id'],array('status'=>'pending'))) {
      $msg = 'Order has been accepted.';
    } else {
      $msg = 'Unable to accept order.';
    }
}
$orders = $QueryFire->getAllData('','','SELECT o.id,o.is_paid,o.date,o.delivery_charge, o.delivery_date,o.status,op.grand_total,u.name,u.mobile_no  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  LEFT JOIN users as u ON u.id=o.user_id WHERE o.is_deleted=0 and o.status="in-process" ORDER BY o.id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>New Orders</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Order Management</a></li>
            <li class="breadcrumb-item active">New Orders</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card dev-primary">
          <div class="card-body">
            <?php echo !empty($msg)?'<h5 class="text-center text-success">'.$msg.'</h5>':''?>
            <div class='row'>
              <div class="col-md-3 col-xs-12 col-sm-3">
                  <div class="form-group">
                      <label class="label" for="dev-min-date">Minimum date</label>
                      <input type="text" class="dev-min-date datepicker form-control" />
                  </div>
              </div>
              <div class="col-md-3 col-xs-12 col-sm-3">
                  <div class="form-group">
                      <label class="label" for="dev-max-date">Maximum date</label>
                      <input type="text" class="dev-max-date datepicker form-control" />
                  </div>
              </div>
            </div>
            <table class="data-table table table-bordered table-striped table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Grand Total</th>
                  <th>Order Date</th>
                  <th>Paid</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($orders)) { $cnt=1;
                  foreach($orders as $order) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td><?php echo ucwords($order['name']);?></td>
                    <td><?php echo strip_tags($order['mobile_no']);?></td>
                    <td><?php echo $order['grand_total'];?></td>
                    <td><?php echo date('d-m-Y',strtotime($order['date']));?></td>
                    <td><?php echo $order['is_paid']?'Yes':'No'?></td>
                    <td>
                      <button class="btn btn-info btn-xs view-order-details mt-1" data-id="<?php echo $order['id'];?>"> View Details</button> 
                      <button class="btn btn-success btn-xs pending-order mt-1" data-id="<?php echo $order['id'];?>">Confirm Order?</button>
                    </td>
                  </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="dev-secondary hide"></div>
      </div>
    </div>
  </section>
  <form class="deliver-form" method="post">
      <input type="hidden" name="order_id" />
  </form>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".datepicker").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        maxDate: new Date(),
        locale: {
          format: "DD-MM-YYYY"
        },
      });
      $(".datepicker").val("");
      jQuery(document).on("click",".dev-btn-back",function(e){
        jQuery(".dev-primary").removeClass("hide");
        jQuery(".dev-secondary").addClass("hide").html("");
      });
      jQuery(document).on("click",".view-order-details",function(e){
          if(jQuery(this).data("id") != "") {
            jQuery.ajax({
              url : "order-details",
              type : "POST",
              data: {order_id:jQuery(this).data("id")},
              success : function(response) {
                if(response.trim() !="") {
                  jQuery(".dev-primary").addClass("hide");
                  jQuery(".dev-secondary").removeClass("hide").html(response);
                }
              }
            });
          }
      });
      jQuery(document).on("click",".pending-order",function(e){
          if(jQuery(this).data("id") != "") {
              var order_id = jQuery(this).data("id");
              bootbox.confirm({
                  message: "<h6>Are you sure you want to Confirm this order?</h6>",
                  buttons: {
                    confirm: {
                      label: "Yes",
                      className: "btn-success"
                    },
                    cancel: {
                      label: "No",
                      className: "btn-danger"
                    }
                  },
                  callback: function (result) {
                    if(result) {
                        jQuery(".deliver-form input").val(order_id);
                      jQuery(".deliver-form").submit();
                    }
                  }
              });
          }
      });
      var table = jQuery(".data-table").DataTable();
      jQuery(".dev-min-date, .dev-max-date").change(function () {
        table.draw();
      });
      jQuery.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var min = jQuery(".dev-min-date").val();
          var max = jQuery(".dev-max-date").val();
          var dte = data[4].split("-");
          var startDate = new Date(dte[2],dte[1]-1,dte[0]);
          if(min !=="") {
              dte = min.split("-");
              min = new Date(dte[2],dte[1]-1,dte[0]);
          }
          if(max !=="") {
              dte = max.split("-");
              max = new Date(dte[2],dte[1]-1,dte[0]);
          }
          if (min == "" && max == "") return true;
          if (min == "" && startDate <= max) return true;
          if (max == "" && startDate >= min) return true;
          if (startDate <= max && startDate >= min) return true;
          return false;
        }
      );
    });
  </script>';
require_once('templates/footer.php');?>
