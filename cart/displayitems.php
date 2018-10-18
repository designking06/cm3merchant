<?php
session_start();
//session_destroy();
//connect
try{
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
?>
<?php require_once('../inc/merchant.get.php'); ?>
<?php $alert = '';?>

<?php getHead(); ?>
  <?php getHeader(); ?>
 <br>
 <div class="row w3-border-bottom">
   <div class="col-sm-6"><h1> Available Products</h1></div>
   <div class="col-sm-4"><br><br><a href="displaycart.php">View Cart</a></div>
  </div>
<div class="row text-center">
    <?php
    //display all products from database with add to cart button
    $stmt = "SELECT * FROM products";
    $display = $pdo->prepare($stmt);
    $display->execute();
    foreach($display as $product){?>
      <div class="col-sm-3 w3-padding">
          <img src="../../media/images/<?php echo $product['ProductImage'];?>" class="w3-image" style="height:30px;"><br>
          <?php echo $product['ProductName'];?><br>
          <b>$<?php echo $product['ProductPrice'];?></b><br>
          <form action="addtocart.php" method="get">
            <input type="hidden" name="itemid" value="<?php echo $product['ProductID'];?>">
            <input type="number" name="qty" max="50" min="1" value="1">
            <input type="submit" name="submit" value="Add To Cart" class="btn btn-primary">
          </form>
        </div>
    <?php
    } ?>
</div>
