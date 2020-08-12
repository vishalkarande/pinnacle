<?php
$active_tab = "Books Management";
$active_sub_tab = 'books Sub category';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'add':
        $data = $QueryFire->getAllData('books_sub_category',' id="'.trim(strip_tags($_POST['id'])).'"');
        if(empty($data)) {
          $QueryFire->insertData("books_sub_category",array('name'=>trim(strip_tags($_POST['name']))));
          $msg = 'Books  Sub Category added successfully.';
        } else {
          $msg = 'Books Sub Category already exists.';
        }
        unset($data);
        break;
       case 'update':
        $data = $QueryFire->getAllData('books_sub_category',' name="'.trim(strip_tags($_POST['name'])).'" and id !='.$_POST['id']);
        if(empty($data)) {
          $QueryFire->upDateTable("books_sub_category",' id='.$_POST['id'],array('name'=>trim(strip_tags($_POST['name']))));
          $msg = 'Books  Sub Category  updated successfully.';
        } else {
          $msg = 'Books Sub Category  already exists.';
        }
        unset($data);
        break;
    case 'delete':
        $QueryFire->upDateTable("books_sub_category",' id='.$_POST['id'],array('is_deleted'=>1));
        //$QueryFire->deleteDataFromTable("journal_type",' id='.$_POST['id']);
        $msg = 'Books  SubCategory deleted successfully.';
        break;
  }
}
require_once('templates/sidebar.php');
//$products = $QueryFire->getAllData('products',' is_deleted=0 ','SELECT p.*,c.name as category FROM products as p LEFT JOIN categories as c ON c.id=p.cat_id WHERE p.is_deleted=0');

$categories = $QueryFire->getAllData('books_sub_category',' is_deleted=0 ','SELECT sc.*,c.name as category FROM books_sub_category as sc LEFT JOIN books_category as c ON c.id=sc.cat_id WHERE sc.is_deleted=0');
//$categories = $QueryFire->getAllData('books_sub_category',' is_deleted=0 order by id desc','select sc.*');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage  Sub Books Category  <button class="btn btn-primary dev-add">Add Books  Sub Category </button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="products">Books Management</a></li>
            <li class="breadcrumb-item active">Books Sub Category</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
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
                  <th>#</th>
              <th>Book Category </th>
                  <th>Book  Sub Category </th>
                  <th>Image</th>
                  <th>Discription</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($categories)) { $cnt=1;
                  foreach($categories as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td class="cat"><?php echo $row['category'];?></td>
                    <td class="cat"><?php echo $row['name'];?></td>
                        <td class="cat"><?php echo $row['image_name'];?></td>
                      <td class="cat"><?php echo $row['discription'];?></td>
                    <td>

                      <button class="btn btn-success btn-xs dev-edit mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <button class="btn btn-danger btn-xs dev-delete mt-1" data-id="<?php echo $row['id'];?>">Delete</button>
                    </td>
                  </tr>
                <?php } } ?>
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
  <div id="add-edit-modal" class="modal fade" role="dialog"  data-backdrop="static">
    <div class="modal-dialog">
      <form method="post" action="" class="add-edit-form" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Books Sub Category :</label>
              <label for="name">Books Sub Category :</label>
              <input class="form-control category" name="name" required placeholder="Enter Books Category Name" type="text">
            </div> 
              <input class="form-control category" name="name" required placeholder="Enter Books Category Name" type="text">

            </div>     
            <input type="hidden" name="user_action" class="user_action">
            <input type="hidden" name="id" class="user_id">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="add" >Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      var validator = jQuery(".add-edit-form").validate({
        rules: {
          name: "required",
        },
        messages: {
          name: "Enter Books Sub Category Name",
        }
      });
      jQuery(document).on("click",".dev-add",function(e){
        validator.resetForm();
        jQuery("#add-edit-modal .user_action").val("add");
        jQuery("#add-edit-modal .modal-title").html("Add  Books  Sub Category");
        jQuery("#add-edit-modal").modal("show");
      });
      jQuery(document).on("click",".dev-edit",function(e){
        validator.resetForm();
        jQuery("#add-edit-modal .modal-title").html("Update Books Sub Category");
        jQuery("#add-edit-modal .user_action").val("update");
        jQuery("#add-edit-modal .user_id").val(jQuery(this).data("id"));
        jQuery("#add-edit-modal .category").val(jQuery(this).parents("tr").find(".cat").text());
        jQuery("#add-edit-modal").modal("show");
      });
      jQuery(document).on("click",".dev-delete",function(e){
          if(jQuery(this).data("id") != "") {
              var id = jQuery(this).data("id");
              bootbox.confirm({
                  title: "Are you sure you want to delete this Books Category?",
                  message: "<span class='."'text-danger'".'>All related information will be deleted.</span>",
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
    });
  </script>';
require_once('templates/footer.php');?>