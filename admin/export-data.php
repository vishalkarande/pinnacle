<?php
session_start();
function downloadFile($data,$header,$name='Orders')
{
  if($name=='Orders')
    $filename = $name.'_'.date("Y-m-d");
  else
    $filename = $name;
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=".$filename.".xls");
  header("Pragma: no-cache");
  header("Expires: 1000");
  print "$header\n $data";
}
require_once('query.php');
if(isset($_POST['eData'])) {
 $result ='';
 $orders = $QueryFire->getAllData('','','SELECT o.*,op.grand_total,u.name,u.mobile_no,u.pincode  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  LEFT JOIN users as u ON u.id=o.user_id WHERE o.is_deleted = 0 and (o.date BETWEEN "'.$_POST['from'].'  00:00:00" and "'.$_POST['to'].'  23:59:59") ORDER BY o.id DESC');
 $users = $QueryFire->getAllData('users','1');
 $address = $QueryFire->getAllData('user_addresses','1');
 if(!empty($orders)) {
   foreach($orders as $value ) {
     $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
     $value1 .= str_replace( '"' , '""' , $users[array_search($value['user_id'], array_column($users, 'id'))]['name'] ). "\t";
     $value1 .= str_replace( '"' , '""' , $value['address_id']==0?$value['pincode']:$address[array_search($value['address_id'], array_column($address, 'id'))]['pincode'] ). "\t";
     $value1 .= str_replace( '"' , '""' , $value['grand_total'] ) . "\t";
     $value1 .= str_replace( '"' , '""' , $value['status'] ) . "\t";
     $value1 .= str_replace( '"' , '""' , $value['date'] ). "\t";
     $value1 .= str_replace( '"' , '""' , $value['delivery_date']==0?'-':$value['delivery_date'] ) . "\t";
     $result .= trim( $value1 ) . "\n";
   }
 }
 $result = str_replace( "\r" , "" , $result );
 if($result == "") {
    $result = "\nNo Record(s) Found!\n";                        
 }
 downloadFile($result,"Order ID \t Buyer \t  Pincode  \t Grand Total (RS)  \t  Status \t Order Date  \t Delievery Date",'Orders_between_'.$_POST['from'].'_and_'.$_POST['to']);
}
if(isset($_POST['eMonth'])) {
  $result ='';
  $orders = $QueryFire->getAllData('','','SELECT o.*,op.grand_total,u.name,u.mobile_no,u.pincode  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  LEFT JOIN users as u ON u.id=o.user_id WHERE o.is_deleted = 0 and (MONTH(o.date) ="'.$_POST['month'].'" and YEAR(o.date) ="'.date('Y').'" ) ORDER BY o.id DESC');
  $users = $QueryFire->getAllData('users','1');
  $address = $QueryFire->getAllData('user_addresses','1');
  if(!empty($orders)) {
    foreach($orders as $value ) {
      $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $users[array_search($value['user_id'], array_column($users, 'id'))]['name'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['address_id']==0?$value['pincode']:$address[array_search($value['address_id'], array_column($address, 'id'))]['pincode'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['grand_total'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['status'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['date'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['delivery_date']==0?'-':$value['delivery_date'] ) . "\t";
      $result .= trim( $value1 ) . "\n";
    }
  }
  $result = str_replace( "\r" , "" , $result );
  if($result == "") {
    $result = "\nNo Record(s) Found!\n";                        
  }
  downloadFile($result,"Order ID \t Buyer \t  Pincode  \t Grand Total (RS)  \t  Status \t Order Date  \t Delievery Date",'Orders_of_month_'.$_POST['month']);
}
if(isset($_POST['eYearly'])) {
  $result ='';
  $orders = $QueryFire->getAllData('','','SELECT o.*,op.grand_total,u.name,u.mobile_no,u.pincode  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  LEFT JOIN users as u ON u.id=o.user_id WHERE o.is_deleted = 0 and YEAR(o.date) ="'.$_POST['year'].'" ORDER BY o.id DESC');
  $users = $QueryFire->getAllData('users','1');
  $address = $QueryFire->getAllData('user_addresses','1');
  if(!empty($orders)) {
    foreach($orders as $value ) {
      $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $users[array_search($value['user_id'], array_column($users, 'id'))]['name'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['address_id']==0?$value['pincode']:$address[array_search($value['address_id'], array_column($address, 'id'))]['pincode'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['grand_total'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['status'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['date'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['delivery_date']==0?'-':$value['delivery_date'] ) . "\t";
      $result .= trim( $value1 ) . "\n";
    }
  }
  $result = str_replace( "\r" , "" , $result );
  if($result == "")
  {
    $result = "\nNo Record(s) Found!\n";                        
  }
  downloadFile($result,"Order ID \t Buyer \t  Pincode  \t Grand Total (RS)  \t  Status \t Order Date  \t Delievery Date",'Orders_of_Year_'.$_POST['year']);
}
if(isset($_POST['eAll'])) {
  $result ='';
  $orders = $QueryFire->getAllData('','','SELECT o.*,op.grand_total,u.name,u.mobile_no,u.pincode  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  LEFT JOIN users as u ON u.id=o.user_id WHERE o.is_deleted = 0 ORDER BY o.id DESC');
  $users = $QueryFire->getAllData('users','1');
  $address = $QueryFire->getAllData('user_addresses','1');
  if(!empty($orders)) {
    foreach($orders as $value ) {
      $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $users[array_search($value['user_id'], array_column($users, 'id'))]['name'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['address_id']==0?$value['pincode']:$address[array_search($value['address_id'], array_column($address, 'id'))]['pincode'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['grand_total'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['status'] ) . "\t";
      $value1 .= str_replace( '"' , '""' , $value['date'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['delivery_date']==0?'-':$value['delivery_date'] ) . "\t";
      $result .= trim( $value1 ) . "\n";
    }
  }
  $result = str_replace( "\r" , "" , $result );
  if($result == "") {
    $result = "\nNo Record(s) Found!\n";
  }
  downloadFile($result,"Order ID \t Buyer \t  Pincode  \t Grand Total (RS)  \t  Status \t Order Date  \t Delievery Date",'All_orders_upto_'.date('Y-m-d'));
}
if(isset($_REQUEST['allProducts'])) {
	$result ='';
	$orders = $QueryFire->getAllData('products','is_deleted=0 order by name asc');
	if(!empty($orders)) {
	  foreach($orders as $value ) {
	    $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
	    $value1 .= str_replace( '"' , '""' , $value['name'] ). "\t";
	    $value1 .= str_replace( '"' , '""' , makeShortString($value['details'],150)). "\t";
	    $value1 .= str_replace( '"' , '""' , $value['discount'] ). "\t";
	    $value1 .= str_replace( '"' , '""' , $value['qty'] ). "\t";
	    $value1 .= str_replace( '"' , '""' , $value['price'] ). "\t";
	    $result .= trim( $value1 ) . "\n";
	  }
	}
	$result = str_replace( "\r" , "" , $result );
	if($result == "") {
	  $result = "\nNo Record(s) Found!\n";                        
	}
	downloadFile($result,"Product ID \t  Product \t Details \t  Discount (%)  \t  Quantity \t  Price (RS) \t ",'Products_'.date('Y-m-d'));
  //echo "<script> window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
if(isset($_REQUEST['allUsers'])) {
  $result ='';
  $users = $QueryFire->getAllData('users','is_deleted=0 order by name asc');
  if(!empty($users)) {
    foreach($users as $value ) {
      $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['name'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['mobile_no']). "\t";
      $value1 .= str_replace( '"' , '""' , $value['email'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['address'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['pincode'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['is_verified']?"Yes":'No' ). "\t";
      $result .= trim( $value1 ) . "\n";
    }
  }
  $result = str_replace( "\r" , "" , $result );
  if($result == "") {
    $result = "\nNo Record(s) Found!\n";                        
  }
  downloadFile($result,"User ID \t  Name \t Mobile No \t  Email  \t  Address \t  Pincode \t Verified \t ",'Users_'.date('Y-m-d'));
  //echo "<script> window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
if(isset($_REQUEST['allRequests'])) {
  $result ='';
  $users = $QueryFire->getAllData('contact_enquiry','1 order by id desc');
  if(!empty($users)) {
    foreach($users as $value ) {
      $value1 = str_replace( '"' , '""' , $value['id'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['name'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['mobile_no']). "\t";
      $value1 .= str_replace( '"' , '""' , $value['email'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['subject'] ). "\t";
      $value1 .= str_replace( '"' , '""' , $value['message'] ). "\t";
      $result .= trim( $value1 ) . "\n";
    }
  }
  $result = str_replace( "\r" , "" , $result );
  if($result == "") {
    $result = "\nNo Record(s) Found!\n";                        
  }
  downloadFile($result,"User ID \t  Name \t Mobile No \t  Email  \t  Subject \t  Message \t ",'Requests_'.date('Y-m-d'));
  //echo "<script> window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
?>