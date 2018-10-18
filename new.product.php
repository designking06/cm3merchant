<?php require 'inc/merchant.required.php'; ?>
<?php $alert = '';?>
<?php
if(isset($_POST['newProduct'])){
    //set post variables
    $pn = $_POST['productName'];
    $pp = $_POST['productPrice'];
    $pi = $_FILES['productImage']['name'];
    $pd = $_POST['productDescription'];
    $compID = $_SESSION['compID'];
    //make sure no fields are empty
    if(empty($_POST['productLineName']) && empty($_POST['createdProductLineName'])){
      $alert = "<div class='alert alert-warning'>Please Create/Select The Product Line for Your New Product</div>";
    }elseif(!empty($_POST['productLineName']) && !empty($_POST['createdProductLineName'])){
      $alert = "<div class='alert alert-warning'>Please Select Only One Product Line for Your New Product</div>";
    }
    if(empty($_POST['productLineName']) && !empty($_POST['createdProductLineName'])){
      $pLN = $_POST['createdProductLineName'];
        $plstatus = "created";
    }elseif(!empty($_POST['productLineName']) && empty($_POST['createdProductLineName'])){
      $pLN = $_POST['productLineName'];
        $plstatus = "existing";
    }
    if(empty($pn) OR empty($pp) OR empty($pi)){//There are empty fields
      $alert = "<div class='alert alert-warning'>All Fields Must Be Complete</div>";
    }else{
    //all fields are filled
    //use switch statement for created/chosen product line name
    switch($plstatus){
        case "created":{
                newProductLine($pLN,$compID,$uid);
                if($GLOBALS['insert']){
                    //new product line made, grab new product line id, get last affected row
                    $pLID = $pdo->lastInsertId();
                    //unfinished, insert new id with form info
                        newProduct($pn,$pp,$pi,$pd,$pLID,$compID,$uid);
                  }else{
                    //product line not Inserted, alert then insert info into product table with product line name
                    $alert = "An error occurred. [442]";
                  }
            unset($GLOBALS['insert']);
            break;
        }
        case "existing":{
            getProductLineIdByName($pLN);
            if($GLOBALS['status']){
                $pLID = $GLOBALS['pLID'];
                newProduct($pn,$pp,$pi,$pd,$pLID,$compID,$uid);
                unset($GLOBALS['pLID']);
            }else{
               echo "An error occurred [455]"; 
            }
            unset($GLOBALS['status']);
            break;
        }
    }
    //send to function newProduct
}
}
?>
<?php getHead(); ?>
  <?php getDashHeader(); ?>
  <!-- Page Content -->
  <div class="container">
    <div class="col-sm-4"></div>
   <div id="form" class="col-sm-4">
     <h3 class="w3-text-orange text-center"><?php echo $alert;?></h3>
  <form action="new.product.php" method="POST" enctype="multipart/form-data">
    <h3>Choose A Product line</h3>
        <?php
        $stmt = "SELECT * FROM productlines WHERE uid = ?";
        $select = $pdo->prepare($stmt);
        $select->execute([$uid]);
        $count = $select->rowCount();
        //echo "<span class='w3-text-blue'>You have " .$count. " product lines.</span><br>";
        if($count == 0){
          ?>
          <h5 class="w3-text-red">Enter Your New Product Lines Name</h4>
            <!--none exist, give option to enter a new one, let user specify details later-->
          <input class="form-control" type="text" name="productLineName" placeholder="Product Line Name"><br>
          <?php
          echo "<h5 class='w3-text-red'>Each Product Must Have A Product Line.</h5><br>";
        }else{?>
          <fieldset>
            <legend>Product Line</legend>
          <?php
          foreach($select as $row){
            $plID = $row['ProductLineID'];
            $name = $row['ProductLineName']; ?>
            <input type="radio" name="productLineName" value="<?php echo $name;?>"><?php echo $name;?><br>
            <?php
          }?>
        </fieldset>
          <h5><b>OR Make A New One</b></h5>
          <input class="form-control" type="text" name="createdProductLineName" placeholder="Product Line Name"><br>
          <?php
        }
       ?>
   <h5 class="w3-text-blue lead">Name Your Product</h5>
   <input class="form-control" type="text" required name="productName"><br>
   <h5 class="w3-text-blue lead">Image For Product</h5>
   <input class="form-control" type="file" required name="productImage"><br>
   <h5 class="w3-text-blue">Description of Product</h5>
   <textarea class="form-control" name="productDescription" placeholder="This Field May be left blank for now."></textarea>
   <h5 class="w3-text-blue">Price of Product (USD)<h5>
    <input class="form-control" type="number" required name="productPrice" step=".01" value="1.00"><br>
    <input type="submit" name="newProduct" value="Add" class="form-control">
  </form>
 </div>
 <div class="col-sm-4"></div>
  </div>
  <!-- End Content -->
  <?php getMtFooter();?>
