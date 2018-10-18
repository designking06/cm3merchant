<?php require_once('inc/merchant.required.php'); ?>
<?php
if(!isset($_GET['alert'])){
    $alert = '';
    $status = '';
}elseif(isset($_GET['alert'])){
    $status = $_GET['status'];
    $alert = '<div class="alert alert-'.$status.'">';
    $alert .= $_GET['alert'];
    $alert .= '</div>';
}
?>
<?php getHead(); ?>
  <?php getHeader(); ?>
  <!-- Page Content -->
        <div class="w3-margin">
            <div class="container">
              <div style="min-width:60%;max-width:95%;margin:auto;">
                <div>
                <legend>Create Your New Product Line</legend>
                <?php echo $alert;?>
                <form action ="forms/productlineUpdate.php" class="form" method="post">
                Name of Product Line
                <input type="text" name="ProductLineName" class="form-control">
                Description
                <input type="text" name="ProductLineDescription" class="form-control">
                <input type="submit" name="newProductLine" value="Create" class="btn primary">
                </form>
                </div>
              </div>
            </div>
        </div>
  <?php getFooter();?>
