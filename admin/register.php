<?php
$active_tab = 'Register';
require_once('header.php');
require_once('menu.php');
if(isset($_SESSION['user'])) {
	if(isset($_REQUEST['url']))
    	echo "<script>window.location.href='".$_REQUEST['url']."';</script>";
    else
    	echo "<script>window.location.href='".base_url."';</script>";
}
if(isset($_POST['name'])) {
  if($_POST['pass'] == $_POST['repass']) {
      $dummy = $QueryFire->getAllData('users',' email= "'.trim($_POST['email']).'"');
      if(empty($dummy)) {
          $data = array();
          $data['name'] = $_POST['name'];
          $data['email'] = $_POST['email'];
          $data['address'] = $_POST['address'];
          $data['pincode'] = $_POST['pincode'];
          $data['mobile_no'] = $_POST['mobile_no'];
          $data['password'] = md5(trim($_POST['pass']));
          $data['access_token'] = generateRandomString(10);
          $data['is_verified'] = 0;
          $to = $data['email'];
          $subject = 'Welcome to Granostore. You have successfully created your profile.';
          // Set content-type header for sending HTML email
          $headers= "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          // Additional headers
          $headers .= 'From: Admin <donotreply.granostore@gmail.com>' . "\r\n";
          $template = file_get_contents('verify_template.php');
          $template = str_replace('%name%', $data['name'] , $template);
          $template = str_replace('%link2text%', 'Granostore' , $template);
          $template = str_replace('%link2%', base_url , $template);
          $template = str_replace('%link%', base_url.'verify/'.$data['access_token'] , $template);
          if(mail($to,$subject,$template ,$headers) && $QueryFire->insertData('users',$data)) {
              $success = 'You have successfully created your account. To activate your account check your mail/message.';
              $to = "donotreply.granostore@gmail.com";
              $subject = ' New registration Details';
              $htmlContent ="
              <html>
                  <head>
                      <title>Registration Details</title>
                      <style>
                          tr{
                          border:1px solid gray;
                          padding:5px;
                          }
                          th{
                          text-align:right;
                          }
                      </style>
                  </head>
                  <body>
                      <table>
                          <tr> <td colspan='2'> <h3> New Registration </h3></td></tr>
                          <tr>
                              <th>Name : </th>
                              <td>".$data['name']."</td>
                          </tr>
                          <tr>
                              <th>Email : </th>
                              <td>".$data['email']."</td>
                          </tr>
                          <tr>
                              <th>Mobile :</th>
                              <td>".$data['mobile_no']."</td>
                          </tr>
                          <tr>
                              <th>Address :</th>
                              <td>".$data['address']."</td>
                          </tr>
                          <tr>
                              <th>User Type :</th>
                              <td><b>".$data['user_type']."</b></td>
                          </tr>
                          <tr>
                              <th>Request From :</th>
                              <td><b>".base_url."</b></td>
                          </tr>
                      </table>
                  </body>
              </html>";
              // Set content-type header for sending HTML email
              $headers= "MIME-Version: 1.0" . "\r\n";
              $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
              // Additional headers
              $headers .= 'From: '.$data['name'].'<'.trim($data['email']).'>' . "\r\n";
              $headers .= 'Cc: nilesh@akshadainfosystem.com' . "\r\n";
              mail($to,$subject,$htmlContent ,$headers);
          }
          else
          {
              $error = 'Unable to register. Please try after sometime.';
          }
      }
      else
          $error = " Email already registered. If you forget your password <a href='".base_url."login#recover'> click here</a> .";
  }
  else
      $error = ' Password and Re-Enter password does not match.';
}
?>
<div class="breadcrumb-area gray-bg">
  <div class="container">
    <div class="breadcrumb-content">      
      <nav class="" role="navigation" aria-label="breadcrumbs">
        <ul>
          <li>
            <a href="<?= base_url?>" title="Back to the home page">Home</a>
          </li>
          <li>
            <span>Register</span>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
<?= isset($success)?'<h3 class="text-center text-primary">'.$success.'</h3>': (isset($error)?'<h3 class="text-center text-warning">'.$error.'</h3>':'')?>
<div class="customer-page theme-default-margin">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
        <div class="login">
          <div class="login-form-container">
            <div class="login-text">
              <h2>Create Account</h2>
              
              <p>Please Register using account detail bellow.</p>
              
            </div>
            <div class="register-form">
              <form method="post" action="" id="create_customer" accept-charset="UTF-8">             
              <label for="FirstName" class="hidden-label">First Name</label>
              <input type="text" name="name" required class="input-full" placeholder="Enter Name"  autocapitalize="words" autofocus>

              <label for="LastName" class="hidden-label">Mobile No</label>
              <input type="text" name="mobile_no" required class="input-full" placeholder="Enter mobile no"  autocapitalize="words">

              <label for="Email" class="hidden-label">Email</label>
              <input type="email" name="email" id="Email" required class="input-full" placeholder="Email"  autocorrect="off" autocapitalize="off">

              <label for="CreatePassword" class="hidden-label">Password</label>
              <input type="password" name="password" required id="CreatePassword" class="input-full" placeholder="Password">

              <label for="address" class="hidden-label">Address</label>
              <input type="text" name="address" id="address" class="input-full" placeholder="Address">

              <label for="pincode" class="hidden-label">Pincode</label>
              <input type="text" name="pincode" id="pincode" class="input-full" placeholder="Password">

              <div class="form-action-button">
                <button type="submit" class="theme-default-button">Create</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once('footer.php');?>