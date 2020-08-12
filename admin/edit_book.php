<?php
$active_tab = 'books Management';
$active_sub_tab = 'books';
$prependScript='
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['act']))
{
  if($_POST['act']=='remove') {
    if($QueryFire->deleteDataFromTable('books','image_name="'.$_POST['image_name'].'"'))
    {
      unlinkImage('../images/books/'.$_POST['image_name']);
      $msg = "Image deleted";
    }
    else
      $msg = 'Sorry! unable to delete image';
  }
}
if(isset($_POST['submit'])) {
  $where = 'name ="'.trim(strip_tags($_REQUEST['name'])).'" and id !='.$_REQUEST['book_id'];
  $data = $QueryFire->getAllData('books',$where);
  if(!empty($data)) {
    $error = 'book already exist !';
  } else {
    $arr = array();
  
    $arr['name'] = trim(strip_tags($_REQUEST['name']));
   
    $arr['cat_id'] = trim(strip_tags($_REQUEST['category']));
     $arr['price'] = trim(strip_tags($_REQUEST['price']));
    $arr['qauntity'] = trim(strip_tags($_REQUEST['quantity']));
    
   
    $arr['discount'] = trim(strip_tags($_REQUEST['discount']));
    $arr['author'] = trim(strip_tags($_REQUEST['author']));
   
   
    $arr['discription'] = htmlentities(addslashes($_POST['discription']));
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/books/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr['image_name'] = $ret['image_name'];
        $data = $QueryFire->getAllData('books','id ='.$_REQUEST['book_id']);
        unlinkImage('../images/books/'.$data[0]['image_name']);
        unset($data);
      } else {
        $msg = "Unable to upload book image";
      }
    }
    if($QueryFire->upDateTable('books',' id='.$_REQUEST['book_id'],$arr)) {
      if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
        $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/books/');
        if($ret1['status'] && isset($ret1['image_name'][0])) {
          foreach($ret1['image_name'] as $img) {
            $QueryFire->insertData('books',array('image_name'=>$img,'book_id'=>$_REQUEST['book_id']));
          }
        }
      }
      $msg = 'book updated successfully.';
    } else {
      $msg = 'Unable to update book.';
    }
  }
}
$categories = $QueryFire->getAllData('categories',' is_show=1 and level=1 and is_deleted=0 order by name');
$images = $QueryFire->getAllData('books',' book_id='.$_REQUEST['book_id']);

$book = $QueryFire->getAllData('books','id='.$_REQUEST['book_id'])[0];
$book_cat = $categories[array_search($book['cat_id'], array_column($categories, 'id'))];
$main_cat = $book_cat['cat_id']==0?$book['cat_id']:$book_cat['cat_id'];
//$sub_cat = $book_cat['parent_id']==0?'':$book_cat['id'];
unset($book_cat);
$
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit book</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="books">book Management</a></li>
            <li class="breadcrumb-item active">Edit book</li>
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
                    <input type="text" name="name" value="<?= $book['name']?>" class="form-control" placeholder="Enter book Name">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="price"> Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                      </div>
                      <input type="text" name="price" value="<?= $book['price']?>" class="form-control" placeholder="Enter book Price">
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="text" name="qty" value="<?= $book['qty']?>" class="form-control" placeholder="Enter book Quantity">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="discount"> Discount</label>
                    <div class="input-group">
                      <input type="text" name="discount" value="<?= $book['discount']?>" class="form-control" placeholder="Enter Discount" value="0">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-5 col-md-5 col-xs-12">
                  <div class="form-group">
                    <label for="cat_id"> Category</label>
                    <select class="form-control category" name="cat_id">
                      <option value=""> -- Select Category -- </option>
                      <?php if(!empty($categories)) {
                        foreach($categories as $cat) {
                          echo '<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-5 col-md-5 col-xs-12 sub_category hide">
                  <div class="form-group">
                    <label for="sub_category">Sub Category</label>
                    <select name="sub_category" class="form-control">
                      <option value=""> -- Select Sub Category -- </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-12">
                  <div class="form-group">
                    <label for="param_id"> Parameter</label>
                    <select class="form-control param" name="param_id">
                      <option value=""> -- Select Parameter -- </option>
                      <?php if(!empty($params)) {
                        foreach($params as $param) {
                          echo '<option value="'.$param['id'].'">'.$param['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3 col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="param_id"> Select Parameter Unit</label>
                    <select class="form-control select2bs4 param_value_id" data-placeholder="Select Parameter Unit" style="width: 100%;" multiple name="param_value_id[]">
                      <option value=""> -- Select Parameter Unit-- </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-12">
                  <div class="form-group">
                    <label for="param_value"> Parameter Value</label>
                    <input type="text" name="param_value"  value="<?= $book['param_value']?>" placeholder="Enter param value" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="is_show">Is Show</label>
                    <select class="form-control" name="is_show">
                      <option value="1" <?= $book['is_show']==1?'selected':''?>>Yes</option>
                      <option value="0" <?= $book['is_show']==0?'selected':''?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="name">SEO - Meta Title:</label>
                    <input class="form-control" value="<?= $book['meta_title']?>" name="meta_title" placeholder="Enter Meta Title" >
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="name">SEO - Meta Description:</label>
                  <input class="form-control" name="meta_description"  value="<?= $book['meta_description']?>" placeholder="Enter Meta Description" >
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="file_upload">Change Featured Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="images">book Images:</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" accept="image/*" name="images[]" class="custom-file-input" multiple id="exampleInputFile1">
                        <label class="custom-file-label" for="exampleInputFile1">Choose files</label>
                      </div>
                    </div>
                    <small class="text-danger">You can upload multiple Images by pressing 'CTRL' button & selecting the desired images</small>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="details"  placeholder="Enter book Description" rows="6" class="form-control summernote"><?= html_entity_decode($book['details'])?></textarea>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <?php  if(!empty($images)){?>
                  <label>book Images:</label><br>
                  <div class="row">
                    <?php
                    foreach($images as $img){?>
                      <div class="col-md-2 col-xs-3">
                        <img src="../images/books/<?= $img['image_name']?>" class="img-responsive img-thumbnail" style="margin-bottom: 10px;">
                        <button class="btn btn-danger btn-xs  remove" type="button" data-id="<?= $img['image_name']?>">Delete </button>
                      </div>
                    <?php } ?>
                  </div>
                  <br>
                  <?php } ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Change/Remove Image Modal -->
  <div id="editHomeSlider" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title m_name">Delete book Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this image?</p>
      <form method="post" action="" class="imgs" enctype="multipart/form-data">
        <input type="hidden" name="image_name" class="img_nm">
        <input type="hidden" name="act" class="act">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="updateHomeSlider" >Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>
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
      $(".remove").on("click",function(){
        $(".img_nm").val($(this).data("id"));
        $(".act").val("remove");
        $("#editHomeSlider").modal("show");
      });
      $(".select2bs4").val(null).trigger("change");
      var v1 = "1";
      $(".param").on("change",function(){
        $(".select2bs4").empty();
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getparamvalues",id:$(this).val(),selected:"'.$book['param_value_id'].'"},
          success:function(response){
            response = $.parseJSON(response);
            response = $.makeArray( response );
            if(response !="") {
              $(".param_value_id").select2({
                theme: "bootstrap4",
                placeholder: "Select Parameter Unit",
                data: response
              });
              if(v1=="")
                $(".param_value_id").val(null).trigger("change");
            }
          }
        });
      });
      $(".param").val('.$param_values[0]['param_id'].').trigger("change");
      var sub_category="'.$sub_cat.'";
      $(".category").on("change",function(){
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getsubcat",id:$(this).val()},
          success:function(response){
            if(response !="") {
              $(".sub_category").removeClass("hide");
              $(".sub_category select").html(response);
              if(sub_category!="") {
                $(".sub_category select").val('.$sub_cat.');
                sub_category="";
              }
            } else {
              $(".sub_category").addClass("hide");
            }
          }
        });
      });
      $(".category").val('.$main_cat.').trigger("change");
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
          qty: {
            required: true,
            min: 1,
            number:true
          },
          cat_id: {
            required: true,
          },
          param_id: {
            required: true,
          },
          param_value_id: {
            required: true,
          },
          sub_category: {
            required: true,
          },
          price: {
            required: true,
            min: 1,
            number:true
          },
        },
        messages: {
          name: {
            required: "Enter book name",
            minlength: "Enter book name more than 3 characters",
          },
          qty: {
            required: "Enter book quantity",
            min: "Enter valid book quantity",
            number:"Enter valid book quantity"
          },
          param_id: {
            required: "Select Parameter",
          },
          param_value_id: {
            required: "Select Parameter Value",
          },
          cat_id: {
            required: "Select Category",
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