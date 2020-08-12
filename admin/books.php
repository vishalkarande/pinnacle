<?php
$active_tab = 'books Managemnet';
$active_sub_tab = 'books';
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
$books = $QueryFire->getAllData('books',' is_deleted=0 ','SELECT b.*,c.name as category FROM books as b LEFT JOIN books_category as c ON c.id=b.cat_id WHERE b.is_deleted=0');
//pr($books);
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage books <a href="add-book" class="btn btn-primary btn-sm">Add book</a> <a href="export-data?allbooks=1" class="btn btn-secondary pull-right btn-sm">Export books</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Books Management</a></li>
            <li class="breadcrumb-item active">books</li>
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
                  <th>Author</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($books)) { $cnt=1;
                  foreach($books as $book) { ?>
                   <tr <?= $book['quantity']<3?'class="bg-warn"':''?> >
                    <td><?php echo $cnt++;?></td>

                    <td><?php echo ucfirst($book['name']);?></td>
                    <td><?php echo ucfirst($book['category']);?></td>
                    <td><?php echo $book['author'];?></td>
                    <td><?php echo $book['price'];?></td>
                    <td><?php echo $book['discription'];?></td>
                    <td><?php echo $book['quantity'];?></td>

                    
                    <td><img src="../img/books/<?= $book['image_name']?>" class="img-thumbnail img-responsive" /></td>
                    <td>
                      <a href="edit-book?book_id=<?php echo $book['id'];?>" class="btn btn-info btn-xs"> Edit</a> 
                      <a class="btn btn-danger btn-xs delete-book" data-id="<?php echo $book['id'];?>"> Delete</a> 
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
      jQuery(document).on("click",".delete-book",function(e){
        if(jQuery(this).data("id") != "") {
          var id = jQuery(this).data("id");
          var This = $(this);
          bootbox.confirm({
              message: "'."<span class='text-danger'>Are you sure you want to delete this book?</span>".'",
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
                    data:{"action":"delete-book","id":id},
                    success:function(response) {
                      if(response=="success") {
                        bootbox.alert("book Deleted");
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