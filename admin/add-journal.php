<?php
$active_tab = 'journal Management';
$active_sub_tab = 'journals';
$prependScript='
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['submit'])) {
  pr($_POST);die;
  $where = 'name ="'.trim(strip_tags($_REQUEST['name'])).'"';
  $data = $QueryFire->getAllData('journals',$where);
  if(!empty($data)) {
    $error = 'journal already exist !';
  } else { 
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/journals/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr = array();
        
       
        $arr['name'] = trim(strip_tags($_REQUEST['name']));
        $_REQUEST['type_id'] = trim(strip_tags($_REQUEST['type_id']));
        if(!empty($_REQUEST['type_id'])){
          $arr['type_id'] = $_REQUEST['type_id'];
        }
        $_REQUEST['domain'] = trim(strip_tags($_REQUEST['domain']));
        if(!empty($_REQUEST['domain'])){
          $arr['domain'] = $_REQUEST['domain'];
        }
         $arr['author'] = trim(strip_tags($_REQUEST['author']));
        
        $arr['publish_date'] = trim(strip_tags($_REQUEST['pdate']));
      
        $arr['quantity'] = trim(strip_tags($_REQUEST['quantity']));
       
      
         
       // $arr['is_deleted'] = trim(strip_tags($_REQUEST['is_deleted']));
       
       $arr['image_name'] = $ret['image_name'];
        $arr['synopsis'] = htmlentities(addslashes($_POST['synopsis']));
        //pr($arr);die;
        if($QueryFire->insertData('journal',$arr)) {
          //get last id
          $last_id = $QueryFire->getLastInsertId();
          //now insert images into db
          if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
            $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/journals/');
            if($ret1['status'] && isset($ret1['image_name'][0])) {
              foreach($ret1['image_name'] as $img) {
                $QueryFire->insertData('',array('image_name'=>$img,'journal_id'=>$last_id));
             }
            }
          }
          $msg = 'journal added successfully.';
        } else {
          $msg = 'Unable to add journal.';
        }
      } else {
        $msg = "Unable to upload journal image";
      }
    }
  }
}
$types= $QueryFire->getAllData('journal_type',' is_deleted=0 order by name');
$domain= $QueryFire->getAllData('domain',' is_deleted=0 order by name');


?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New journal</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="journals">journal Management</a></li>
            <li class="breadcrumb-item active">Add journal</li>
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
                    <input type="text" name="name" class="form-control" placeholder="Enter journal Name">
                  </div>
                </div>
                <div class="col-sm-5 col-md-5 col-xs-12">
                  <div class="form-group">
                    <label for="type_id"> Type</label>
                    <select class="form-control category" name="type_id">
                      <option value=""> -- Select Type-- </option>
                      <?php if(!empty($types )) {
                        foreach($types as $type) {
                          echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="domain">Domain</label>
                    <select class="form-control category" name="domain">
                      <option value=""> -- Select Domain -- </option>
                      <?php if(!empty($domain )) {
                        foreach($domain as $d) {
                          echo '<option value="'.$d['id'].'">'.$d['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="author">Author:</label>
                  <input class="form-control" name="author" placeholder="Enter Author" >
                </div>
                 <div class="col-sm-4 col-md-4 col-xs-6">
                  <div class="form-group">
                    <label for="pdate">Publish Date</label>
                    <input type="date" name="pdate" class="form-control" placeholder="Enter journal Quantity">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" class="form-control" placeholder="Enter journal Quantity">
                  </div>
                </div>
               
                
               
               
                
               
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="file_upload">journal Image</label>
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
                    <label for="synopsis">Synopsis</label>
                    <textarea name="synopsis"  placeholder="Enter synopsis" rows="6" class="form-control summernote"></textarea>
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
            required: "Enter journal name",
            minlength: "Enter journal name more than 3 characters",
          },
          quantity: {
            required: "Enter journal quantity",
            min: "Enter valid journal quantity",
            number:"Enter valid journal quantity"
          },
          
          
          sub_category: {
            required: "Select Sub Category",
          },
          price: {
            required: "Enter journal price",
            min: "Enter valid journal price",
            number:"Enter valid journal price"
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
