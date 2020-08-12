<?php
$active_tab = "Books Management";
$active_sub_tab = 'events';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'add':
        $data = $QueryFire->getAllData('events',' id="'.trim(strip_tags($_POST['id'])).'"');
        if(empty($data)) {
          $QueryFire->insertData("events",array('name'=>trim(strip_tags($_POST['name'])),'event_date'=>trim(strip_tags($_POST['event_date'])),'discription'=>trim(strip_tags($_POST['discription']))));
          $msg = 'events added successfully.';
        } else {
          $msg = 'events already exists.';
        }
        unset($data);
        break;
       case 'update':
        $data = $QueryFire->getAllData('events',' name="'.trim(strip_tags($_POST['name'])).'" and id !='.$_POST['id']);
        if(empty($data)) {
          $QueryFire->upDateTable("events",' id='.$_POST['id'],array('name'=>trim(strip_tags ($_POST['name'])),'event_date'=>trim(strip_tags($_POST['event_date'])),'discription'=>trim(strip_tags($_POST['discription']))));
          $msg = 'events updated successfully.';
        } else {
          $msg = 'events already exists.';
        }
        unset($data);
        break;
    case 'delete':
        $QueryFire->upDateTable("events",' id='.$_POST['id'],array('is_deleted'=>1));
        //$QueryFire->deleteDataFromTable("journal_type",' id='.$_POST['id']);
        $msg = 'events deleted successfully.';
        break;
  }
}
$events = $QueryFire->getAllData('events',' is_deleted=0 order by id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage events  <button class="btn btn-primary dev-add">Add events </button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="products">Books Management</a></li>
            <li class="breadcrumb-item active">events</li>
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
                  <th> Event Name</th>
                   <th>Event Date</th>
                  <th>Discription</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($events)) { $cnt=1;
                  foreach($events as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td class="cat"><?php echo $row['name'];?></td>
                      <td class="cat"><?php echo $row['event_date'];?></td>
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
              <label for="name">events :</label>
              <input class="form-control events" name="name" required placeholder="Enter Event Date" type="text">
              <label for="event_date">Event Date :</label>
              <input class="form-control events" name="event_date" required placeholder="Enter events Name" type="date">
              <label for="discription">Event Discription :</label>
              <input class="form-control events" name="discription" required placeholder="Enter events discription" type="text">
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
          name: "Enter events Name",
        }
      });
      jQuery(document).on("click",".dev-add",function(e){
        validator.resetForm();
        jQuery("#add-edit-modal .user_action").val("add");
        jQuery("#add-edit-modal .modal-title").html("Add New events");
        jQuery("#add-edit-modal").modal("show");
      });
      jQuery(document).on("click",".dev-edit",function(e){
        validator.resetForm();
        jQuery("#add-edit-modal .modal-title").html("Update events");
        jQuery("#add-edit-modal .user_action").val("update");
        jQuery("#add-edit-modal .user_id").val(jQuery(this).data("id"));
        jQuery("#add-edit-modal .events").val(jQuery(this).parents("tr").find(".cat").text());
        jQuery("#add-edit-modal").modal("show");
      });
      jQuery(document).on("click",".dev-delete",function(e){
          if(jQuery(this).data("id") != "") {
              var id = jQuery(this).data("id");
              bootbox.confirm({
                  title: "Are you sure you want to delete this events?",
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