<?php
try{
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
?>
<?php
if(isset($_POST['updateProductInfo'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    try{
    $stmt = "UPDATE products SET ProductName = ?, ProductPrice = ?, ProductDescription = ? WHERE ProductID = ?";
    $update = $pdo->prepare($stmt);
    if($update->execute([$name,$price,$description,$id])){
    $status = "Successfully Updated";
     header('location:../products.php?updatedproduct='.$name.'&status='.$status);
    }else{
    $status = "Uuccessfully Updated";
     header('location:../products.php?updatedproduct='.$name.'&status='.$status);
    }
    }catch(PDOException $e){
    echo $e->getMessage();
    }
    }
?>