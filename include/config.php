<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'publisher');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection

/*if($con){
	

	
	
	
	
	
	
	
	
	
	
	
	$ret=mysqli_query($con,"select books.name as pname   from books left join books_category on books.cat_id=books_category.id where books_category.id= 2");
$num=mysqli_num_rows($ret);
	if($num>0)
	{
while ($row=mysqli_fetch_array($ret)) {
	
	
	
echo $row['pname'];

}

	
	
	
	
	
	
}
	
	
}*/
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>