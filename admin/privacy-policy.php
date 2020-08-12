<?php
$active_tab = 'privacy policy';
$prependScript="";
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['submit']) && !empty($_POST['text'])) {
  $arr = array();
  $arr['text'] = htmlentities(addslashes($_POST['text']));
  if($QueryFire->upDateTable('pageandcontents',' id=5',$arr)) {
    $msg = 'Record updated successfully.';
  } else {
    $msg = 'Unable to update record.';
  }
}
$data = $QueryFire->getAllData('pageandcontents','id=5')[0];
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= ucwords(strtolower($data['name']))?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active"><?= ucwords(strtolower($data['name']))?></li>
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
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="form-group">
                    <textarea name="text" rows="6" class="form-control summernote">
                      <?= html_entity_decode($data['text']) ?>
                    </textarea>
                  </div>
                </div>
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
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".summernote").summernote({
        height:250,
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
    });
  </script>';
require_once('templates/footer.php');?>
