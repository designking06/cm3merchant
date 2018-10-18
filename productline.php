<?php require_once('inc/merchant.required.php'); ?>
<?php getHead();?>
<?php getHeader();?>
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
<div id="body" class="container">
    <h1>Your Product Line</h1>
<?php
if(isset($_GET['viewAll'])){
    $plID = $_GET['plID'];
    $stmt = "SELECT * FROM productlines WHERE ProductLineID = ?";
    $select = $pdo->prepare($stmt);
    if($select->execute([$plID])){
        $productLine = $select->fetchAll();
        foreach($productLine as $pl){
            $name =$pl['ProductLineName'];
            $image = $pl['ProductLineImage'];
            $description = $pl['ProductLineDescription'];
            //display current product line banner followed by name and description
            ?>
            <div class=""><h1 class="display-4 text-center" style="margin:;"><?php echo $name;?></h1></div>
            <?php echo $alert;?>
            <hr>
            <div class="w3-margin" style="margin:auto;">
                <?php if(empty($image)){
                ?>
                <div class="alert alert-danger w3-center">
                    <p class="lead">This Product Line Has No Image!</p><br>
                    <form action="forms/productlineUpdate.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="plID" value="<?php echo $plID;?>">
                    <input type="button" id="loadFileXml" value="Choose Image" class="btn" onclick="document.getElementById('file1').click();" />
                    <input type="file" style="display:none;" id="file1" name="ProductLineImage"/><br>
                    <hr>
                    <input type="hidden" name="ProductLineID" value="<?php echo $plID;?>">
                    <input type="submit" name="updateImage" value="Upload Image" class="btn w3-green">
                    </form>
                </div>
                <?php }else{ ?>
                    <div class="row"><div class="col-sm-12" style="height:200px;background-image:url('../media/images/<?php echo $image;?>');background-position:center;"><!--img src="../media/images/<?php echo $image;?>" class="w3-image"--></div></div>
                    <form action="forms/productlineUpdate.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="plID" value="<?php echo $plID;?>">
                    <input type="button" id="loadFileXml" value="Change Your Image" class="btn" onclick="document.getElementById('file2').click();" />
                    <input type="file" style="display:none;" id="file2" name="ProductLineImage"/><br>
                    <hr>
                    <input type="hidden" name="ProductLineID" value="<?php echo $plID;?>">
                    <input type="submit" name="updateImage" value="Upload Image" class="btn w3-green">
                    </form>
            <?php }?>
            </div>
            <div class="w3-margin text-center">
                <p class="lead">Product Line Description:</p>
                <form action="forms/productlineUpdate.php" method="post">
                    <textarea name="ProductLineDescription" class="form-control"><?php echo $description;?></textarea>
                    <input type="hidden" name="ProductLineID" value="<?php echo $plID;?>">
                    <input type="submit" name="updateDescription" value="Update" class="btn w3-margin">
                </form>
            </div>
            <?php echo $alert;?>
    <hr>
        <?php
        }//end foreach
    }//end product line info
    ?>
    <div class="w3-margin"><p class="lead">Products in this line</p></div>
    <div class="container">
        <div class="row">
    <?php
    //display add new product button with hidden modal
    //grab products with product line id and display them, editable
    $plID = $_GET['plID'];
    $stmt = "SELECT * FROM products WHERE ProductLineID = ?";
    $select = $pdo->prepare($stmt);
    if($select->execute([$plID])){
        $productLine = $select->fetchAll();
        foreach($productLine as $pl){
                  $id = $pl['ProductID'];
                  $name = $pl['ProductName'];
                  $price = $pl['ProductPrice'];
                  $description = $pl['ProductDescription'];
                  $image = $pl['ProductImage']; ?>
                      <div class="col-sm-3 w3-margin w3-card" style="">
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
                      <div id="editNum<?php echo $id;?>" class="w3-modal w3-light-grey" style="display:none;">
                        <div class="w3-modal-content container w3-white">
                         <div class="row text-center">
                            <div class="col-sm-12 w3-padding">
                                <p class="w3-xlarge">
                                    <span class="w3-red w3-padding w3-small" onclick="document.getElementById('editNum<?php echo $id;?>').style.display='none'">CLOSE</span>
                                    Edit Product Info
                                </p>
                              </div>
                            </div>
                            <div class="row w3-padding">
                             <!-- Begin Edit Product Form -->
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
<?php
        }
    }//end if select
?>
</div></div>
    <?php } ?>
</div>
<?php getFooter();?>