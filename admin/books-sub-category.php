<?php
$active_tab = "Books Management";
$active_sub_tab = 'Books Sub category';
$prependScript ='<style>
  .img-thumbnail {
    max-height:150px;
    max-width:180px;
  }
</style>';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['addsubcategory'])) {
  if(isset($_FILES) && !empty($_FILES)) {
    $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/books_subcategory/');
    if($ret['status'] && isset($ret['image_name'])) {
      $arr = array();
      $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
      $arr['cat_id'] = strip_tags(trim($_REQUEST['cat_id']));
      $arr['name'] = strip_tags(trim($_REQUEST['name']));
      $arr['image_name'] = $ret['image_name'];
      
      if($QueryFire->insertData('books_sub_category',$arr)) {
        $msg = 'Sub category added successfully';
      } else {
        $msg = "Unable to add sub category";
      }
    } else {
      $msg = 'Unable to upload file. Please try later.';
    }
  }
}

if(isset($_POST['updatesubcategory'])) {
  $arr = array();
  $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
   $arr['cat_id'] = strip_tags(trim($_REQUEST['cat_id']));
  $arr['name'] = strip_tags(trim($_REQUEST['name']));
 
 
  $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/books_subcategory/');
  if($ret['status'] && isset($ret['image_name'])) {
    $arr['image_name'] = $ret['image_name'];
    $duplicate = $QueryFire->getAllData('books_sub_category',' id ='.$_REQUEST['id']);
    unlinkImage('../images/books_subcategory/'.$duplicate[0]['image_name']);
  } else {
    $msg = 'Unable to upload file. Please try later.';
  }
  if($QueryFire->upDateTable("books_sub_category",'id ='.$_REQUEST['id'],$arr)) {
    $msg = 'sub category successfully updated.';
  } else {
    $msg = 'Can not update sub category.';
  }
}

if(!empty($_POST['user_action'])) {
  switch($_POST['deletesubcat']) {
    case 'delete':
        $duplicate = $QueryFire->getAllData('books_sub_category',' id ='.$_REQUEST['id']);
        unlinkImage('../images/books_subcategory/'.$duplicate[0]['image_name']);
        $QueryFire->deleteDataFromTable("boks_sub_category",' id='.$_POST['id']);
        $msg = 'sub category deleted successfully.';
        break;
  }
}
$sub_category = $QueryFire->getAllData('books_sub_category',' is_show=1 ','SELECT sc.*,c.name as category FROM books_sub_category as sc LEFT JOIN books_category as c ON c.id=sc.cat_id WHERE sc.is_show=1');
//pr($sub_category);
$category= $QueryFire->getAllData('books_category',' is_deleted=0 order by name');

?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sub category <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add sub category</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Add sub category</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <?php echo !empty($msg)?'<h5 class="text-center text-success">'.$msg.'</h5>':''?>
            <table class="data-table table table-bordered table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Image</th>
                  <th>Category Name</th>
                   <th>Sub Category Name</th>
                  <th>Showing</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($sub_category)) { $cnt=1;
                  foreach($sub_category as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td class="cat">
                      <img src="../images/books_subcategory/<?php echo $row['image_name'];?>" class="img-responsive img-thumbnail">
                    </td>
                    <td class="name">
                      <?php echo $row['category'];?>
                    </td>
                    
                    <td class="subcategory">
                      <?php echo $row['name'];?>
                    </td>
                    <td>
                      <?php echo $row['is_show']?'Yes':'No';?>
                    </td>
                    <input type="hidden" class="yes_no_select" value="<?=$row['is_show']?>" />
                    <td>
                      <button class="btn btn-success btn-xs dev-edit mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <button class="btn btn-danger btn-xs dev-delete mt-1" data-id="<?php echo $row['id'];?>" name="deletsubcat">Delete</button>
                    </td>
                  </tr>
                <?php } } else {
                  echo '<td colspan="6" class="text-center">You have not added any sub category</td>';
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <form class="active_inactive-form" method="post">
    <input type="hidden" name="id" />
    <input type="hidden" name="user_action" />
  </form>
  <!-- Add Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <form id="addForm" method="post" action="" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add new sub category</h4>
          </div>
          <div class="modal-body">
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
            
            <div class="form-group">
              <label for="name">subcategory:</label>
              <input type="text" class="form-control" name="name" placeholder="Enter sub category"></text>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label for="is_show">Is Show:</label>
                      <select name="is_show" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                      </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label for="file_upload">Images:</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="clear"></div>
            <div id="preview">
              <span class="pre">IMAGE PREVIEW</span><br>
              <img id="previewimg" src="" style="max-width:200px;height: 100px">      
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="addsubcategory" >Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Edit Modal -->
  <div id="editsub category" class="modal fade" role="dialog">
    <form method="post" action="" id="editForm" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit sub category</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control nameT" name="name" placeholder="Enter name">
            </div>
            
            <div class="form-group">
              <label for="subcategory">subcategory:</label>
              <textarea class="form-control subcategoryT" name="subcategory" placeholder="Enter user subcategory"></textarea>
            </div>
            <div class="form-group" id="formdiv">
              <div class="row">
                <div class="col-xs-12 col-lg-5 col-md-5 col-sm-5">
                  <img src="" class="img_show img-thumbnail img-responsive" />
                </div>
                <div class="col-xs-12 col-md-7 col-lg-7 col-sm-7">
                  <div class="form-group">
                    <label>Change Picture:</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="name">Is Show:</label>
                      <select name="is_show" class="form-control select_y_s">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                      </select>
                    </div>
                </div>
              </div>
            </div>   
            <input type="hidden" name="id" class="idCls">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="updatesubcategory"  >Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      jQuery("#addForm").validate({
        rules: {
          file_upload: "required",
          name: "required",
          title: "required",
          subcategory: "required",
        },
        messages: {
          file_upload: "Upload an image ",
          name: "Enter name",
          subcategory: "Enter subcategory",
          title: "Enter title",
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
      jQuery("#editForm").validate({
        rules: {
          name: "required",
          subcategory: "required",
          title: "required",
        },
        messages: {
          name: "Enter name",
          subcategory: "Enter subcategory",
          title: "Enter title",
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
      $(document).on("click",".dev-edit",function(){
        $(".select_y_s").val($(this).parents("tr").find(".yes_no_select").val());
        $(".nameT").val($(this).parents("tr").find(".name").html().trim());
        $(".titleT").val($(this).parents("tr").find(".title").html().trim());
        $(".subcategoryT").val($(this).parents("tr").find(".subcategory").html().trim());
        $(".img_show").attr("src",$(this).parents("tr").find(".img-thumbnail").attr("src"));
        $(".idCls").val($(this).data("id"));
        $("#editsub category").modal("show");
      });
      jQuery(document).on("click",".dev-delete",function(e){
          if(jQuery(this).data("id") != "") {
              var id = jQuery(this).data("id");
              bootbox.confirm({
                  title: "Are you sure you want to delete this sub category?",
                  message: "<span class='."'text-danger'".'>Information will be deleted permanently.</span>",
                  buttons: {
                    confirm: {
                      label: "Yes",
                      className: "btn-success btn-sm"
                    },
                    cancel: {
                      label: "No",
                      className: "btn-danger btn-sm"
                    }
                  },
                  callback: function (result) {
                    if(result) {
                        jQuery(".active_inactive-form input:nth(0)").val(id);
                        jQuery(".active_inactive-form input:nth(1)").val("delete");
                      jQuery(".active_inactive-form").submit();
                    }
                  }
              });
          }
      });
      $(":file").change(function() {
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = imageIsLoaded;
          reader.readAsDataURL(this.files[0]);
        }
      });
      $("#preview").css("display", "none");
      function imageIsLoaded(e) {
        $("#message").css("display", "none");
        $("#preview").css("display", "block");
        $("#previewimg").attr("src", e.target.result);
        $(".img_show").attr("src", e.target.result);
      }
    });
  </script>';
require_once('templates/footer.php');?>