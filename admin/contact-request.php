<?php
$active_tab = 'contact request';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        $QueryFire->deleteDataFromTable("contact_enquiry",' id='.$_POST['id']);
        $msg = 'Request deleted successfully.';
        break;
  }
}
$data = $QueryFire->getAllData('contact_enquiry',' 1 order by id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Contact Requests <a href="export-data?allRequests=1" class="btn btn-secondary pull-right btn-sm">Export Requests</a> </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Contact Requests</li>
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
            <table class="data-table table table-bordered table-striped table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)) {
                  $cnt=1;
                  foreach($data as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['mobile_no'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['subject'];?></td>
                    <td><?php echo $row['message'];?></td>
                    <td>
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
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      jQuery(document).on("click",".dev-delete",function(e){
          if(jQuery(this).data("id") != "") {
              var id = jQuery(this).data("id");
              bootbox.confirm({
                  title: "Are you sure you want to delete this request?",
                  message: "<span class='."'text-danger'".'>Request will be deleted permanently.</span>",
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