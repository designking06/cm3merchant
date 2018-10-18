<?php require_once('inc/merchant.required.php'); ?>

<?php
if(isset($_GET['updatedproduct'])){
    $name = $_GET['updatedproduct'];
    $status = $_GET['status'];
    $alert = '<div class="alert w3-yellow w3-opaque">Product: '.$name.' '.$status.'</div>';
}else{
    $alert = '';
}
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
<?php getDashHeader(); ?>
  <!-- Page Content -->
<div class="container text-center">
    <div id="addnew" class="w3-margin">
          <div class="row text-center">
                      <div class="col-sm-6">
            <a href="new.product.php?compID=<?php echo $_GET['compID'];?>"><h3 class="w3-btn w3-padding w3-text-blue">Add New Products</h3></a>
            </div>
              <div class="col-sm-6">
                  <a href="new.productline.php?compID=<?php echo $_GET['compID'];?>">
                      <h3 class="w3-btn w3-padding w3-text-blue">Add New Product Line</h3>
                  </a>
              </div>
        </div>
    </div>
            <div class="row w3-padding"><h2 class="">My Products</h2></div>
                <?php echo $alert;?>
          <!-- Count and list number of how many products user has -->
          <?php
          //select * from products where user id
          $stmtSPL = "SELECT * FROM productlines WHERE CompID = ?";
          $selectPL= $pdo->prepare($stmtSPL);
          $selectPL->execute([$_GET['compID']]);
          $countPL = $selectPL->rowCount();
          if($countPL>0){
            foreach($selectPL as $pL){
              $pLID = $pL['ProductLineID'];
              $pLN = $pL['ProductLineName'];
              $stmt = "SELECT * FROM products WHERE CompID = ? AND ProductLineID = ? LIMIT 6";
              $select = $pdo->prepare($stmt);
              $select->execute([$_GET['compID'],$pLID]);
              $count = $select->rowCount();
              if($count == 0){
                ?>
                <div class="row"><h3 class="text-left"><?php echo $pLN;?></h3></div>
                <div class="alert alert-warning"><strong>Wait!</strong>This product line has no products</div>
                <?php
              }else{
                ?>
                <div class="row"><h3 class="text-left"><?php echo $pLN;?></h3></div>
                <div class="row alert alert-success text-left">
                  <span class="">
                      <form action="productline.php" method="get">
                      <input type="hidden" name="plID" value="<?php echo $pLID;?>">
                      <input type="submit" name="viewAll" class="btn" value="View All">
                      </form>
                    </span>
                  <span class=""><input type="text" placeholder="Search <?php echo $pLN;?> Products..." class="form-control"></span>
                </div>
                <div class="row">
                <?php
                foreach($select as $row){
                  $id = $row['ProductID'];
                  $name = $row['ProductName'];
                  $price = $row['ProductPrice'];
                  $description = $row['ProductDescription'];
                  $image = $row['ProductImage']; ?>
                      <div class="col-sm-2 w3-margin w3-card" style="">
                          <!-- Display Product Name -->
                        <div class="row w3-padding">
                            <strong><?php echo $name;?></strong>
                            <div class="w3-text-blue w3-small btn" onclick="document.getElementById('editNum<?php echo $id;?>').style.display='block'">EDIT</div>
                        </div>
                           <!-- Display Product Image -->
                        <div class="row w3-dark-grey"><img src="../media/images/<?php echo $image;?>" class="w3-image w3-padding" style="height:50px;"></div>
                           <!-- Display Product Price -->
                          <div class="row w3-padding"><strong><span class="w3-text-green">$<?php echo $price;?></span></strong></div>
                      </div>
                         <!-- Display Product Modal Editor -->
                      <div id="editNum<?php echo $id;?>" class="w3-modal w3-grey" style="display:none;">
                        <div class="w3-modal-content w3-white">
                            <div class=" container">
                                <div class=" w3-padding">
                                  <div class="row w3-margin">
                                    <div class="col-sm-10"><h2>Edit Product Info</h2></div>
                                    <div class="col-sm-2">
                                        <div class="w3-text-red w3-padding" onclick="document.getElementById('editNum<?php echo $id;?>').style.display='none'" style="cursor:pointer;">CLOSE</div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <!-- Begin Edit Product Form -->
                                        <div class="col-sm-12">
                                          <form action="forms/productForm.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $id;?>">
                                            <h3>Update Product Name:</h3><br>
                                            <input type="text" class="form-control" name="name" value="<?php echo $name;?>"><br>
                                            <h3>Update Product Price:</h3><br>
                                            <input type="text" class="form-control" name="price" value="<?php echo $price;?>"><br>
                                            <h3>Update Product Description:</h3><br>
                                            <textarea class="form-control" name="description"><?php echo $description;?></textarea><br>
                                            <input class="w3-green w3-btn" type="submit" class="form-control" name="updateProductInfo" value="Update">
                                          </form>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                        </div>
                      </div>
              <?php }//end foreach, div ends product list row
                ?>
              </div>
              <?php
              }
            }
          }
          ?>
          <!-- Provide a form for users to add new products -->
  </div>
  <hr>
  <!-- Give user option to go to a page to view all products in a table format -->
  <!-- End Content -->
  <?php getMtFooter();?>
