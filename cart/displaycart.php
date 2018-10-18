<?php
session_start();
try{
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
?>
<?php require_once('../inc/merchant.get.php'); ?>
<?php getHead(); ?>
<div class="container" style="width:100%;">
<a href="displayitems.php">Back to shop</a><br>
<div class="container" style="">
<?php
$total = (int)0;
    if(empty($_SESSION['cart'])||count($_SESSION['cart'])<1){?>
      <h2> Your cart is currently empty</h2>
      <?php
      exit;
      }else{
      $i=0;
      //cart has items
        foreach($_SESSION['cart'] as $each_item){
          $i++;
          ?>
          <div class="row w3-border-bottom">
          <div class="col-sm-12">
            <b>Item #<?php echo $i;?></b>
          </div>
          <?php
          //$cartOutput .= "<h2>Cart Item $i</h2>";
          //put data of id from db
          $itemid=$each_item['itemid'];
              $stmtSelect = "SELECT * FROM products WHERE ProductID = ? LIMIT 1";
              $select = $pdo->prepare($stmtSelect);
              $select->execute([$itemid]);
          $product = $select->fetch(PDO::FETCH_ASSOC);
          ?>
        <div class="col-sm-3"><img src="../../media/images/<?php echo $product['ProductImage'];?>" class="w3-image"></div>
        <div class="col-sm-9">
              <form action="cart.update.php" method="get">
              <div class="row"><div class="col-sm-12"><b>Product:</b> <?php echo $product['ProductName'];?></div></div>
              <div class="row">
                  <div class="col-sm-12"><b>Price:</b> $<?php echo $product['ProductPrice'];?></div>
                </div>
             <div class="row">
                     <div class="col-sm-3"><b>Quantity</b></div>
                     <div class="col-sm-3"><input type="number" min="0" name="qty" value="<?php echo $each_item['quantity'];?>" class="form-control"></div>
                    <div class="col-sm-3"><input type="hidden" name="itemid" value="<?php echo $each_item['itemid'];?>">
                        <input type="submit" name="submit" value="update">
                        </div>
                  </div>
            <div class="row">
                <div class="col-sm-6"><b>Total:</b> $<?php echo $product['ProductPrice'] * $each_item['quantity'];?></div>
            </div>
            </form>
        </div>
      </div>
          <?php
            //while(list($key,$value)= each($each_item)){
            //  $cartOutput .= "$key:$value<br>";
            //}//close while


            //total up products for purchase
            $total = $total + ($product['ProductPrice']*$each_item['quantity']);
        }//close foreach
    }
    ?>
    <div class="row text-right col-sm-10"><b>Subtotal: $<?php echo $total;?></b></div>
<div class="row text-right col-sm-10"><b>Tax: $
  <?php $tax = $total*.075;
    $tax = round($tax,2,PHP_ROUND_HALF_UP);
  echo $tax;
  ?>
    </b></div>
    <div class="row text-right col-sm-10"><b>Grand Total: $<?php echo $total+$tax;?></b></div>
</div>
