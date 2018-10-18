<?php session_start(); ?>
<a href="displayitems.php">Back to shop</a>
<?php
if(isset($_GET['submit'])){
  $itemid = $_GET['itemid'];
  $qty = (int)$_GET['qty'];
  $wasFound = false;
  $i = 0;
    if(empty($_SESSION['cart'])||count($_SESSION['cart'])<1){
      $_SESSION['cart'] = array(1=>array("itemid"=>$itemid,"quantity"=>$qty));
      print_r($_SESSION['cart']);
            header("location:displaycart.php");
      exit;
    }else{
      //cart has items
        foreach($_SESSION['cart'] as $each_item){
          $i++;
            while(list($key,$value)= each($each_item)){
            if($key == "itemid" && $value == $itemid){
              //item is in cart, increase qty
              array_splice($_SESSION['cart'],$i-1,1,array(array("itemid"=>$itemid,"quantity"=>$each_item['quantity']+$qty)));
              $wasFound = true;
              print_r($_SESSION['cart']);
            }
            }//close while
        }//close foreach
        if ($wasFound == false) {
        array_push($_SESSION['cart'], array("itemid" => $itemid, "quantity" => $qty));
        print_r($_SESSION['cart']);
        }
    }
    header("location:displaycart.php");
}

//$cartitems = explode(",",$items);
//$items .=",".$_GET['itemid'];
