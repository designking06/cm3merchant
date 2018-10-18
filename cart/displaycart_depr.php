<?php
session_start();
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
<?php print_r($_SESSION['cart']);?>
<?php
  $items = $_SESSION['cart'];
  $cartitems = explode(",", $items);
?>
<div class="container" style="width:100%;text-align:center;">
<a href="displayitems.php">Back to shop</a><br>
<div style="width:50%;margin:auto;text-align:left;">
<h1>Your Cart</h1>
<div class="row text-right">
<?php
$subtotal = '';
$i=1;
  foreach($cartitems as $key=>$id){
      $stmt = "SELECT * FROM products WHERE ProductID = ?";
      $show = $pdo->prepare($stmt);
      $show->execute([$id]);
      $r = $show->fetch(PDO::FETCH_ASSOC);?>
      <div class="row w3-margin">
      <div class="col-sm-4"><img src="../../media/images/<?php echo $r['ProductImage'];?>" class="w3-image" style="height:30px;"></div>
      <div class="col-sm-4"><?php echo $r['ProductName'];?></div>
      <div class="col-sm-4">$<?php echo $r['ProductPrice'];?></div>
    </div>
      <?php
        $subtotal = $subtotal + $r['ProductPrice'];
        $i++;
  }//end foreach
    ?>
</div>
<?php
    //convert total into cents
    $stripeSubtotal = $subtotal * 100;
    //calculate shipping and tax
    $stripeTax = $stripeSubtotal * .0725;
    $tax = $subtotal * .075;
    //convert total into cents
    $stripeAmt = $stripeSubtotal + $stripeTax;
    $total = $subtotal + $tax;
    ?>
    <hr class='w3-clear'>
    <div style="text-align:right;">
    <h5>Subtotal: $<?php echo $subtotal;?></h5>
    <h5>Tax: $<?php echo $tax;?></h5>
    <h3>Total: $<?php echo $total;?></h3>
  </div>
    <form action="payment.process.stripe.php" method="POST">
      <input type="hidden" name="amount" value="<?php echo $stripeAmt;?>">
      <input type="hidden" name="description" value="<?php echo $_SESSION['cart'];?>">
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_qUgFXuTWbRNMy9wX7V8qIitR"
        data-amount="<?php echo $stripeAmt;?>"
        data-name="Crawley Creative "
        data-description="<?php echo $_SESSION['cart'];?>"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto">
      </script>
    </form>

    <?php if(isset($_SESSION['cart'])){
      var_dump($_SESSION['cart']);
}else{
  echo 'no cart exists<br><br>';
}
?>
</div>
</div>
