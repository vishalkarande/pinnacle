<?php
session_start();
if(!empty($_POST['order_id'])) {
  require_once("query.php");
  $products = $QueryFire->getAllData('order_has_products',' order_id="'.$_POST['order_id'].'" order by id','SELECT ohp.qty as quantity, ohp.discount,ohp.price,p.id,p.slug,p.name FROM order_has_products as ohp JOIN products as p ON p.id=ohp.product_id WHERE ohp.order_id='.$_POST['order_id']);
  $order = $QueryFire->getAllData('orders',' id= "'.$_POST['order_id'].'"')[0];
  $user = $QueryFire->getAllData('users',' id= "'.$order['user_id'].'"')[0];
  $address = array('address'=>$user['address'],'pincode'=>$user['pincode'],'name'=>$user['name'],'mobile_no'=>$user['mobile_no'],'street'=>'','city'=>'','state'=>'');
  if($order['address_id'] != 0) {
    $address = $QueryFire->getAllData('user_addresses',' id= "'.$order['address_id'].'"')[0];
  }
  ?>
  <style>
    #section-to-print .show-on-print {
        visibility: hidden;
    }
    @media print {
        body *{
            visibility: hidden;
        }
        /*.card {
            width:400px;
        }*/
        #section-to-print, #section-to-print * {
            visibility: visible;
        }
        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
        #section-to-print .hide {
            display:block;
            visibility: visible;
        }
        #section-to-print .dev-btn-back,#section-to-print .print-me  {
            visibility: hidden;
        }
        #section-to-print .hide-me-print {
            visibility: hidden;
        }
        @page { size: auto;  margin: 0mm;}
    }
  </style>
  <div class="card" id="section-to-print">
    <div class="card-header">
      <strong class="print-me">Order Details- #<?php echo $order['id'];?></strong>
      <button class="btn btn-info btn-sm print-me" onclick="window.print();">Print</button>
      <h2 class="hide show-on-print"> <strong>Order Details- #<?php echo sprintf('%06d', $order['id']).'  &nbsp;&nbsp; Order Date:'.date('d/m/Y',strtotime($order['date']));?>  </strong> </h2>
    </div>
    <div class="card-body card-block">
      <h4 class="text-center"><strong>Customer Details</strong></h4>
      <div class="row mt-3">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class="label">Customer Name</label>
            <input type="text" class="form-control" readonly name="name" value="<?php echo trim($address['name']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Customer Mobile</label>
            <input type="text"  class="form-control" readonly name="customer_mobile" value="<?php echo trim($address['mobile_no']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Customer Address</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['address']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">City</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['state']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Street</label>
            <input type="text"  class="form-control" readonly name="street" value="<?php echo trim($address['street']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">State</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['state']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Pincode</label>
            <input type="text"  class="form-control" readonly name="pincode" value="<?php echo trim($address['pincode']);?>">
          </div>
        </div>
      </div>
      <h4 class="text-center"><strong>Products</strong></h4><br>
      <div class="table-responsive">
        <table class="datatable-1 datatable  table table-hover table-condensed table-bordered table-product dt-responsive nowrap" style="overflow: auto;">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $grandTotal=0;
            foreach($products as $product) { ?>
                <tr>
                  <td>
                    <?php echo ucwords($product['name']) ?>
                  </td>
                  <td>
                    <?php echo $product['quantity'];?>
                  </td>
                  <td><?php echo $product['price'];?></td>
                  <td><?php echo $product['discount'];?></td>
                  <td><?php echo $subtotal = ($product['quantity'] * ( $product['price'] - ($product['price']*$product['discount']/100)) ) ;$grandTotal+= $subtotal;?> </td>
                </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right"><strong>Grand Total : </strong></td>
              <td><?php echo $grandTotal;?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="form-group">
        <button class="btn btn-primary dev-btn-back">Back</button>
      </div>
    </div>
  </div>
<?php } ?>