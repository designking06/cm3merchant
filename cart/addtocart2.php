<?php session_start(); ?>
<a href="displayitems.php">Back to shop</a>
<?php
if(isset($_GET['submit'])){
  $itemid = $_GET['itemid'];
  $count = $_GET['count'];
  if(!isset($_SESSION['cart'])){
    $alert ="new array.";
    $_SESSION['cart'] = array("$itemid"=>(int)$count);
    $cart = $_SESSION['cart'];
    print_r($cart);
    echo $alert;
    exit;
  }
  elseif(count($_SESSION['cart']) > 0){
    //check if item id is in array, increase quantity
    if(in_array("$itemid",$_SESSION['cart'])){
      $alert = "array existing:";
      //access quantity of specific itemid and increment
      foreach($cart as $value){
        $alert.= "array increased.";
        $value['count'] = $value['count'] + $count;
      }
      print_r($cart);
      echo $alert;
      exit;
    }else{
      $alert = "array existing:";
      $cart = $_SESSION['cart'];
      //item not found in cart, push new item and quantity to array
      $newitem = array("$itemid"=>(int)$count);
      $cart[$itemid]= $count;
      $_SESSION['cart'] = $cart;
      $alert .= "new array merged:";
      print_r($_SESSION['cart']);
      echo $alert;
      exit;
    }
  }
}

//$cartitems = explode(",",$items);
//$items .=",".$_GET['itemid'];
