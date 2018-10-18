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
<?php
//if add to cart is clicked..
//first item is added
if(isset($_GET['submit'])){
  if(!isset($_SESSION['cart'])){
    if(isset($_GET['quantity'])){
      $quant = $_GET['quantity'];
    }else{
      $quant = (int)1;
    }
    $itemid = $_GET['itemid'];
    $_SESSION['cart'] = $itemid;
    $_SESSION['cart']['id'] = array("quantity"=>$quant);
    header("location:displaycart.php");
    exit;
    }
  else{
    $items = $_SESSION['cart'];
    $cartitems = explode(",",$items);
    $items .=",".$_GET['itemid'];
    $_SESSION['cart'] = $items;
    header("location:displaycart.php");
    exit;
  }}
?>
