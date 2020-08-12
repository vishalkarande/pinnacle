<?php
$active_tab = 'change password';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['updateHomeSlider'])) {
  $arr = array();
  //$arr['password'] = md5(strip_tags(trim($_POST['name'])));
  $arr['password'] = strip_tags(trim($_POST['name']));
  if($_POST['name'] != $_POST['re_passwd']) {
    $error = 'Password and Re-enter password does not match.';
  } else {
    $where = 'id ='.$_SESSION['admin']['id'];
    if($QueryFire->upDateTable("admin",$where,$arr)) {
      $success = 'Password changed successfully.';
    } else {
      $error = 'Unable to change password.';
    }
  }
}
?>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <?php echo !empty($msg)?'<h5 class="text-center text-success mt-3">'.$msg.'</h5>':''?>
          <form role="form" method="post" class="user-form" enctype="multipart/form-data">
            <div class="card-body">
              <?= isset($success)?'<h3 class="text-success ">'.$success.'</h3>': (isset($error)?'<h3 class="text-warning">'.$error.'</h3>':'');?>
              <form id="addGal" method="post" action="" >
                <div class="form-group col-md-6">
                  <label for="name">New Password:</label>
                  <input class="form-control" id="passwd" name="name" placeholder="New Password" type="password">
                </div>
                <div class="form-group col-md-6">
                  <label for="fees">Re-Enter Password:</label>
                  <input type="password"  name="re_passwd" class="form-control" placeholder="Re enter your Password">
                </div>
                <div id="clear"></div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" name="updateHomeSlider" >Update</button>
                </div>
              </form>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php 
$appendScript = '
  <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="plugins/jquery-validation/additional-methods.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".user-form").validate({
        rules: {
          name: {
            required:true,
            minlength:6,
          },
          re_passwd: {
            required:true,
            equalTo:"#passwd"
          }
        },
        messages: {
          name: {
            required:"Enter new password",
            minlength: "Password length should be greater than 6 characters"
          },
          re_passwd: {
            required:"Re-enter your Password",
            equalTo:"Password and Re-enter password does not match"
          }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
    });
  </script>';
require_once('templates/footer.php');?>
