<?php
if(isset($_POST['updateDescription'])){
$description = $_POST['ProductLineDescription'];
$id = $_POST['ProductLineID'];
try{
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
try{
$stmt = "UPDATE productlines SET ProductLineDescription = ? WHERE ProductLineID = ?";
$update = $pdo->prepare($stmt);
if($update->execute([$description,$id])){
$alert = "Updated Description Successfully!";
$status = "success";
header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
}else{
$status = "Danger";
$alert = "Something went wrong while updating your description!<br> Please Copy below and try again:<br>";
$alert .= $description;
header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
}
}catch(PDOException $e){
    echo $e->getMessage;
}
}
if(isset($_POST['updateImage'])){
    $id = $_POST['ProductLineID'];
    //set images variables
    $image = $_FILES['ProductLineImage']['name'];
    $image_tmp = $_FILES['ProductLineImage']['tmp_name'];
    $target_dir = "../../media/images/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(empty($image)){
    $status = 'warning';
    $alert = 'You didnt specify a file type!<br>Err:ProductlineImageUpdate:40';
    header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
    }else{
        //make sure image variable is an actual image
        $check = getimagesize($image_tmp);
        if($check !== false) {
        //check image file type
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $status = 'danger';
            $alert = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image uploads.";
            header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
        }else{
            //set pdo connection
            try{
              $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                ///
                ///begin inser
                $stmt = "UPDATE productlines SET ProductLineImage = ? WHERE ProductLineID = ?";
                $update = $pdo->prepare($stmt);
                    //move uploaded file
                if($update->execute([$image,$id])){
                    if (move_uploaded_file($image_tmp, $target_file)) {
                        $alert = "The file ". basename($image). " has been uploaded.";
                        $status = "success";
                        header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
                    } else {
                        $alert = "Sorry, there was an error saving your file.";
                        $status = "warning";
                        header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
                    }
                }else{
                    $status = "danger";
                    //echo the issue with the image
                    $alert = "Something went wrong while updating your image!<br> Please try again, then report line the below to QCC Concerns page:<br>";
                    $alert .= "<span class='w3-text-yellow'>Err:ProductLineUpdate:75</span>";
                    header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
                }
            }catch(PDOException $e){
              echo $e->getMessage();
              die();
            }
        }//end else of image type
        }else{
            $status = 'danger';
            $alert = "File is not an image.";
            header('location: ../productline.php?plID='.$id.'&alert='.$alert.'&status='.$status.'&viewAll=View+All');
        }
    }//end else of empty image
}
if(isset($_POST['newProductLine'])){
    $name = $_POST['ProductLineName'];
    $description =  $_POST['ProductLineDescription'];
    $uid = $_SESSION['uid'];
    $CompID = $_SESSION['CompID'];
    if(empty($name)){
                    $alert = "You must specify a name";
                    $status = "danger";
                    header('location:../new.productline.php?alert='.$alert.'&status='.$status);
    }
        try{
          $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = "INSERT INTO productlines (ProductLineName,ProductLineDescription,CompID,uid) VALUES(?,?,?,?)";
                $insert = $pdo->prepare($stmt);
                if($insert->execute([$name,$description,$CompID,$uid])){
                    $alert = "Product Line ".$name." Successfully Created!";
                    $status = "success";
                    header('location:../new.productline.php?alert='.$alert.'&status='.$status);
                }else{
                    $alert = "Product Line ".$name." incurred an error while being created!";
                    $status = "warning";
                    header('location:../new.productline.php?alert='.$alert.'&status='.$status);
                }
        }catch(PDOException $e){
          echo $e->getMessage();
          die();
        }
}
if(isset($_POST['deleteProductLine'])){
    $ProductLineID = $_POST['ProductLineID'];
    /* First, check if ProductLineID is associated with any existing products, foreach product, remove product line id from record and leave blank */
    $stmt = "SELECT * FROM products where ProductLineID = ?";
    $select= $pdo->prepare($stmt);
    $select->execute([$ProductLineID]);
    $count = $select->rowCount();
    if($count >0){
        foreach($select as $product){
            //change ProductLineID field to blank
            $ProductID = $product['ProductID'];
            $stmt = "UPDATE products SET ProductLineID = ? WHERE ProductID = ? ";
            $update = $pdo->prepare($stmt);
            if($update->execute([NULL,$ProductID])){
                $status = "success";
                $alert = "Producct Line Successfully Deleted";
                header('location:products.php?alert='.$alert.'&status='.$status);
            }else{}
        }
    }
    /* Next, drop row from productlines where ProductLineID = POST ProductLineID */
}
?>
