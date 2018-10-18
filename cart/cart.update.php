<?php //update cart
session_start();
if(isset($_GET['submit'])){
  $itemid = $_GET['itemid'];
  $qty = (int)$_GET['qty'];
  $wasFound = false;
  $i = 0;
    if(empty($_SESSION['cart'])||count($_SESSION['cart'])<1){
      //cart is empty, nothing to delete
      header("location:displaycart.php");
      echo "something going wrong";
      exit;
    }else{
      //cart has items
        foreach($_SESSION['cart'] as $each_item){
          $i++;
            while(list($key,$value)= each($each_item)){
            if($key == "itemid" && $value == $itemid){
              //item is in cart, increase qty
              array_splice($_SESSION['cart'],$i-1,1,array(array("itemid"=>$itemid,"quantity"=>$qty)));
              $wasFound = true;
              header("location:displaycart.php");
            }
            }//close while
        }//close foreach
    }
    header("location:displaycart.php");
}
?>
