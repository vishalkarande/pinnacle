<?php
$active_tab = 'journals Managemnet';
$active_sub_tab = 'journals';
$prependScript="<style>
  .img-thumbnail {
    max-height:100px;
  }
  .bg-warn{
    background:#e9c7d0;
  }
</style>";
require_once('templates/header.php');
require_once('templates/sidebar.php');
$journals = $QueryFire->getAllData('journal','is_deleted=0 ','SELECT j.* , jt.name as type , d.name as domain , a.name as author FROM journal as j  LEFT JOIN journal_type as jt ON jt.id=j.type_id  LEFT JOIN domain as d on d.id=j.domain_id LEFT JOIN author as a ON a.id=j.author_id WHERE j.is_deleted=0');

?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage journals <a href="add-journal" class="btn btn-primary btn-sm">Add journal</a> <a href="export-data?alljournals=1" class="btn btn-secondary pull-right btn-sm">Export journals</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="#">journals Management</a></li>
            <li class="breadcrumb-item active">journals</li>
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
            <table class="data-table table table-bordered table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                   <th>category</th>
                    <th>Domain</th>
                    <th>Author</th>
                  <th>Synopsis</th>
                  <th>Publish Date</th>
                 
                  <th>Quantity</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($journals)) { $cnt=1;
                  foreach($journals as $journal) { ?>
                   <tr <?= $journal['quantity']<3?'class="bg-warn"':''?> >
                    <td><?php echo $cnt++;?></td>

                    <td><?php echo ucfirst($journal['name']);?></td>
                    <td><?php echo ucfirst($journal['type']);?></td>
                    <td><?php echo ucfirst($journal['domain']);?></td>
                    <td><?php echo $journal['author'];?></td>
                    <td><?php echo $journal['synopsis'];?></td>
                    <td><?php echo $journal['publish_date'];?></td>
                    <td><?php echo $journal['quantity'];?></td>

                    
                    <td><img src="../img/journals/<?= $journal['image_name']?>" class="img-thumbnail img-responsive" /></td>
                    <td>
                      <a href="edit-journal?journal_id=<?php echo $journal['id'];?>" class="btn btn-info btn-xs"> Edit</a> 
                      <a class="btn btn-danger btn-xs delete-journal" data-id="<?php echo $journal['id'];?>"> Delete</a> 
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
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      jQuery(document).on("click",".delete-journal",function(e){
        if(jQuery(this).data("id") != "") {
          var id = jQuery(this).data("id");
          var This = $(this);
          bootbox.confirm({
              message: "'."<span class='text-danger'>Are you sure you want to delete this journal?</span>".'",
              buttons: {
                confirm: {
                  label: "Yes",
                  className: "btn-success"
                },
                cancel: {
                  label: "No",
                  className: "btn-danger"
                }
              },
              callback: function (result) {
                if(result) {
                  $.ajax({
                    url:"query",
                    method:"post",
                    data:{"action":"delete-journal","id":id},
                    success:function(response) {
                      if(response=="success") {
                        bootbox.alert("journal Deleted");
                        //table.row( $(This).parents("tr") ).remove().draw();
                        window.location.reload();
                      }
                    }
                  });
                }
              }
          });
        }
      });
    });
  </script>';
require_once('templates/footer.php');?>