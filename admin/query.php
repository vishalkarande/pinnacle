<?php
set_time_limit(0);
require_once('constant.php');
$connection = new mysqli(dbserver,dbuser, dbpass,dbname);
class QueryFire {
	public function getAllData($table_name,$where,$cust=null) {	
		if($cust!=null)
			$sql= $cust;
		else	
			$sql = "SELECT * FROM ".$table_name." WHERE ".$where;
		//echo $sql;
		$p = mysqli_query($GLOBALS['connection'],$sql);
		while($data = mysqli_fetch_array($p,MYSQLI_ASSOC))  
		{
			$q[] = $data;
		}
		if(!empty($q))
			return $q;
		else
			return array();
	}




	//this is for uploding files
	function fileUpload($data,$path='../assets/images/',$cstm=false,$ff=0) {
		//check path exists or not
		if(!is_dir($path))
		{
			mkdir($path);
		}
		$ret = false;
		$arr = array();
		//set actual path for image
		$target_dir = '';
		$image_type = strtolower(pathinfo($data['name'],PATHINFO_EXTENSION));
		$image_name = rand(99,10).date('Ymdhis').'.'.$image_type;
		if($image_type =='jpg'|| $image_type =='jpeg' || $image_type =='png' || $image_type =='gif' || $image_type =='bmp')
		  $ret =true;

		if($cstm)
			if(in_array($image_type, $ff))
				$ret = true;
		/*if($data['size']> 2000000)
		  $ret = false;*/
		if($ret)
		  if(move_uploaded_file($data['tmp_name'],$path.$image_name))
		  {
		    $arr['image_name'] = $image_name;
		    $success = " New record added successfully.";
		  }
		  else
		    $success = "Can not upload file.";
		else
		  $success = "Unable to add record.";
		$arr['status'] = $ret;
		$arr['message'] = $success;
		return $arr;
	}

	function multipleFileUpload($data,$path='../assets/images/') {
		if(!is_dir($path))
		{
			mkdir($path);
		}
		$ret = false;
		$arr = array();
		//set actual path for image
		$target_dir = '';
		for($i=0;$i<count($data['name']);$i++)
		{
			$image_type = strtolower(pathinfo($data['name'][$i],PATHINFO_EXTENSION));
			$image_name = rand(99,10).date('Ymdhis').'.'.$image_type;
			if($image_type =='jpg'|| $image_type =='jpeg' || $image_type =='png' || $image_type =='gif' || $image_type =='bmp')
			  $ret =true;
			/*if($data['size']> 2000000)
			  $ret = false;*/
			  if(!file_exists($path))
			  	mkdir($path);
			if($ret)
			  if(move_uploaded_file($data['tmp_name'][$i],$path.$image_name))
			  {
			    $arr['image_name'][$i] = $image_name;
			    $success = " New record added successfully.";
			   /* if($BaseClassObject->insertData('galleries',$data,$fields))
			      $success = " New record added successfully.";
			    else
			      $success = " System error while adding record.";*/
			  }
			  else
			    $success[$i] = "Can not upload file.";
			else
			  $success[$i] = "Unable to add record.";
		}
		$arr['status'] = $ret;
		$arr['message'] = $success;
		return $arr;
	}

	public function insertData($table_name,$data) {
		//using InserArray function
		/*$da = $this->insertArray($data);
		$sql = 'INSERT INTO '.$table_name.'('.$da['fields'].') VALUES ('.$da['values'].')';*/
		$da = $this->changeArrayToString($data);
		$sql = 'INSERT INTO '.$table_name.'('.implode(",",array_keys($data)).') VALUES ('.$da.')';
		return mysqli_query($GLOBALS['connection'],$sql);
	}

	public function upDateTable($table_name,$where,$data) {
		$da = $this->changeArrayToKeyValue($data);
		$sql = 'UPDATE '.$table_name.' SET '.$da.' WHERE '.$where;
		return mysqli_query($GLOBALS['connection'],$sql);
	}

	function updateTableAsIt($sql) {
		return mysqli_query($GLOBALS['connection'],$sql);
	}

	public function deleteDataFromTable($table_name,$where) {
		$sql = 'DELETE FROM '.$table_name.' WHERE '.$where;
		return mysqli_query($GLOBALS['connection'],$sql);
	}

	function changeArrayToKeyValue($data) {
		$str ='';
		foreach($data as $key=>$value)
		{
			if(empty($str))
				$str = $key.' ="'.strip_tags(trim($value)).'"';
			else
				$str .= ' ,'.$key.' ="'.strip_tags(trim($value)).'"';
		}
		return $str;
	}

	function getLastInsertId() {
		return mysqli_insert_id($GLOBALS['connection']);
	}

	//this is unused now but can be used when need to make string from array
	function changeArrayToString($data) {
		$str = '';
		foreach($data as $value)
		{
			if(empty($str))
				$str = '"'.strip_tags(trim($value)).'"';
			else
				$str .=' ,"'.strip_tags(trim($value)).'"';
		}
		return $str;
	}

	//makes cols n different just like list ** not using implode function as implode do not give prover result 
	function insertArray($data) {
		$ar  = array();
		$str = '';
		$str1 = '';
		foreach($data as $key=>$value)
		{
			if(empty($str))
			{
				$str1 = $key;
				$str = '"'.strip_tags(trim($value)).'"';
			}
			else
			{
				$str1 = ','.$key;
				$str .=' ,"'.strip_tags(trim($value)).'"';
			}
		}
		$ar['fields'] = $str1;
		$ar['values'] = $str;
		return $ar;
	}

	function getAllCount($tablename) {
		$sql = 'SELECT * FROM '.$tablename;
		return mysqli_num_rows(mysqli_query($GLOBALS['connection'],$sql));
	}

	function tableFields($sql) {
		return mysqli_query($GLOBALS['connection'],$sql);
		//return mysqli_num_fields(mysqli_query($GLOBALS['connection'],$sql));
	}
}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//from here custom functions starts
function pr(&$data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function sendEmail($data) {
	$headers = "From:" . $data['from'];
	return mail($data['to'],$data['subject'],$data['message'],$headers);
}

//generating random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//major function to get different size images using following function(Nilesh Lathe)
function makeThumbnails($updir, $img, $imgName,$thumbnail_width,$thumbnail_height) {
	//check path exists or not
	if(!is_dir($updir))
	{
		mkdir($updir);
	}
    $arr_image_details = getimagesize($img); // pass id to thumb name
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if($original_width > $original_height)
    {
      $new_width = $thumbnail_width;
      $new_height = intval($original_height * $new_width / $original_width);
    }
    else
    {
      $new_height = $thumbnail_height;
      $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if($arr_image_details[2] == IMAGETYPE_GIF)
    {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if($arr_image_details[2] == IMAGETYPE_JPEG)
    {
      $imgt = "ImageJPEG";
      $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if($arr_image_details[2] == IMAGETYPE_PNG)
    {
      $imgt = "ImagePNG";
      $imgcreatefrom = "ImageCreateFromPNG";
    }
    if($imgt)
    {
      $old_image = $imgcreatefrom($img);
      $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
      //$black = imagecolorallocate($new_image, 0, 0, 0);
      //imagecolortransparent($new_image, $black);
      $image = imagecreatetruecolor(100, 100);

      // Transparent Background
      imagealphablending($new_image, false);
      $transparency = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagefill($new_image, 0, 0, $transparency);
      imagesavealpha($new_image, true);

      // Drawing over
      $black = imagecolorallocate($new_image, 0, 0, 0);
      imagefilledrectangle($new_image, 25, 25, 75, 75, $black);

      imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
      $imgt($new_image, $updir.$imgName);
      imagedestroy($old_image);
    }
}

function makeShortString($string, $length=15, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function to_prety_url($str) {
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
}

function validateyoutubelink($id) {
	$valid = file_get_contents('https://img.youtube.com/vi/'.$id.'/mqdefault.jpg');
	if(!empty($valid)) {
		return 1;
	}
	return 0;
}

//unlkinking/deleting images
function unlinkImage($file) {
	if(file_exists($file))
		return unlink($file);
	else
		return true;
}

$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
//creat quey object
$QueryFire = new QueryFire();
if(isset($_REQUEST)&& !empty($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 'delete-product':
			$where = 'id ='.$_REQUEST['id'];
			$QueryFire->upDateTable("products",$where,array('is_deleted'=>1));
			echo "success";
			break;
		case 'getsubcat':
			$res = '';
			$categories = $QueryFire->getAllData('categories',' is_deleted=0 and is_show=1 and level=2 and parent_id ='.$_REQUEST['id']);
			if(!empty($categories)) {
				$res = '<option value=""> -- Select Sub Category -- </option>';
				foreach($categories as $cat) {
					$res.='<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
				}
			}
			echo $res;
			break;
		case 'getparamvalues':
			$data = array();
			$states = $QueryFire->getAllData('product_params_values',' is_deleted=0 and param_id ='.$_REQUEST['id']);
			$selected = !empty($_REQUEST['selected'])?explode(',', $_REQUEST['selected']):array();
			if(!empty($states)) {
				foreach($states as $state) {
					if(in_array($state['id'], $selected))
						array_push($data, array('id'=> $state['id'],'text'=>$state['param_value'],"selected" => true));
					else
						array_push($data, array('id'=> $state['id'],'text'=>$state['param_value']));
				}
			}
			echo json_encode($data);
			break;
		case 'useraddress':
			$where = ' id ='.$_REQUEST['id'];
			$data = $QueryFire->getAllData('user_addresses',$where);
			$ar = array();
			if(!empty($data[0]))
			{
				$ar['status'] = true;
				$ar['data'] = $data;
			}
			else
			{
				$ar['status'] = false;
				$ar['error'] = "Data not found";
			}
			echo json_encode($ar);
			break;
		case 'del_user_add':
			$where = 'id ='.$_REQUEST['id'];
			$QueryFire->upDateTable("user_addresses",$where,array('is_deleted'=>1));
			//$QueryFire->deleteDataFromTable('user_addresses',$where);
			header('Location:'.$_SERVER['HTTP_REFERER']);
			break;
		default:
			echo "No action Found";
			break;
	}
}