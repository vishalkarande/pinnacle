<?php
$active_tab = 'Book Management';
$active_sub_tab = 'books';
$prependScript='
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['submit'])) {
  //pr($_POST);die;
  $where = 'name ="'.trim(strip_tags($_REQUEST['name'])).'"';
  $data = $QueryFire->getAllData('books',$where);
  if(!empty($data)) {
    $error = 'book already exist !';
  } else {
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/books/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr = array();

       
        $arr['name'] = trim(strip_tags($_REQUEST['name']));
        $_REQUEST['cat_id'] = trim(strip_tags($_REQUEST['cat_id']));
        if(!empty($_REQUEST['cat_id'])){
          $arr['cat_id'] = $_REQUEST['cat_id'];
        }
        $arr['price'] = trim(strip_tags($_REQUEST['price']));
        $arr['quantity'] = trim(strip_tags($_REQUEST['quantity']));
        $arr['discount'] = trim(strip_tags($_REQUEST['discount']));
        $arr['cat_id'] = trim(strip_tags($_REQUEST['cat_id']));
       
        $arr['author'] = trim(strip_tags($_REQUEST['author']));
         
       // $arr['is_deleted'] = trim(strip_tags($_REQUEST['is_deleted']));
       
       $arr['image_name'] = $ret['image_name'];
        $arr['discription'] = htmlentities(addslashes($_POST['discription']));
        //pr($arr);die;
        if($QueryFire->insertData('books',$arr)) {
          //get last id
          $last_id = $QueryFire->getLastInsertId();
          //now insert images into db
          if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
            $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/books/');
            if($ret1['status'] && isset($ret1['image_name'][0])) {
              foreach($ret1['image_name'] as $img) {
                $QueryFire->insertData('',array('image_name'=>$img,'book_id'=>$last_id));
              }
            }
          }
          $msg = 'book added successfully.';
        } else {
          $msg = 'Unable to add book.';
        }
      } else {
        $msg = "Unable to upload book image";
      }
    }
  }
}
$category= $QueryFire->getAllData('books_category',' is_deleted=0 order by name');

?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New book</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="books">book Management</a></li>
            <li class="breadcrumb-item active">Add book</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <?php echo !empty($msg)?'<h5 class="text-center text-success mt-3">'.$msg.'</h5>':''?>
          <form role="form" method="post" class="user-form" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter book Name">
                  </div>
                </div>
                <div class="col-sm-5 col-md-5 col-xs-12">
                  <div class="form-group">
                    <label for="cat_id"> Category</label>
                    <select class="form-control category" name="cat_id">
                      <option value=""> -- Select Category -- </option>
                      <?php if(!empty($category )) {
                        foreach($category as $cat) {
                          echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="price"> Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                      </div>
                      <input type="text" name="price" class="form-control" placeholder="Enter book Price">
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" class="form-control" placeholder="Enter book Quantity">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="discount"> Discount</label>
                    <div class="input-group">
                      <input type="text" name="discount" class="form-control" placeholder="Enter Discount" value="0">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                
               
               
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="author">Author:</label>
                  <input class="form-control" name="author" placeholder="Enter Author" >
                </div>
              
               
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="file_upload">Book Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="discription">Description</label>
                    <textarea name="discription"  placeholder="Enter book Description" rows="6" class="form-control summernote"></textarea>
                  </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php 
$appendScript = '
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="plugins/jquery-validation/additional-methods.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".select2bs4").select2({
        theme: "bootstrap4"
      });
      $(".select2bs4").val(null).trigger("change");
      $(".param").on("change",function(){
        $(".select2bs4").empty();
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getparamvalues",id:$(this).val()},
          success:function(response){
            response = $.parseJSON(response);
            response = $.makeArray( response );
            if(response !="") {
              $(".param_value_id").select2({
                theme: "bootstrap4",
                placeholder: "Select Parameter Unit",
                data: response
              });
              $(".param_value_id").val(null).trigger("change");
            }
          }
        });
      });
      $(".category").on("change",function(){
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getsubcat",id:$(this).val()},
          success:function(response){
            if(response !="") {
              $(".sub_category").removeClass("hide");
              $(".sub_category select").html(response);
            } else {
              $(".sub_category").addClass("hide");
            }
          }
        });
      });
      $(".summernote").summernote({
        height: 250,
        fontNames: ["Arial", "Arial Black", "Comic Sans MS", "Courier New","Times New Roman","Century","Verdana","Vrinda","Candara","Tahoma","Georgia","Impact","Helvetica","Neutra Text TF","Lucida Console"],
        fontSizes: ["8","9","10","11","12","14","16","18", "20", "24", "36","60","72"],
        toolbar:[
           ["style", ["bold", "italic", "underline", "clear"]],
           ["font", ["strikethrough","superscript", "subscript"]],
           ["fontsize", ["fontsize"]],
           ["fontname", ["fontname"]],
           ["color", ["color"]],
           ["para", ["ul", "ol", "paragraph"]],
           ["height", ["height"]],
           ["table", ["table"]],
           ["insert", ["link", "picture", "hr","video"]],
           ["view", ["fullscreen", "codeview"]],
           ["help", ["help"]],
        ],
      });
      $(".user-form").validate({
        rules: {
          name: {
            required: true,
            minlength: 3
          },
          quantity: {
            required: true,
            min: 1,
            number:true
          },
          
          sub_category: {
            required: true,
          },
          
          price: {
            required: true,
            min: 1,
            number:true
          },
          file_upload: {
            required: false
          }
        },
        messages: {
          name: {
            required: "Enter book name",
            minlength: "Enter book name more than 3 characters",
          },
          quantity: {
            required: "Enter book quantity",
            min: "Enter valid book quantity",
            number:"Enter valid book quantity"
          },
          
          
          sub_category: {
            required: "Select Sub Category",
          },
          price: {
            required: "Enter book price",
            min: "Enter valid book price",
            number:"Enter valid book price"
          },
         
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
