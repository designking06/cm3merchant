<?php require_once('inc/merchant.required.php'); ?>
<?php 
$alert = '';
getHead();
?>
<?php
if(isset($_POST['brandUpdate'])){
  $_SESSION['formalert'] = NULL;
  try{
    $stmt = $pdo->prepare('SELECT * FROM userbrand WHERE uid = ?');
    $stmt->execute([$uid]);
    $count = $stmt->rowCount();
    if($count > 0){
      $bio = $_POST['bio'];
      $stageName = $_POST['stageName'];
      $youtube = $_POST['youtube'];
      $soundcloud = $_POST['soundcloud'];
      $instagram = $_POST['instagram'];
      $snap = $_POST['snapchat'];
      $twitter = $_POST['twitter'];
      $uid = $_POST['uid'];
      //user has info inside table, update info
      $sql = "UPDATE userbrand SET stageName = ?, bio = ?,youtube = ?,soundcloud=?,instagram=?,snapchat=?,twitter=? WHERE uid = ?";
      $update = $pdo->prepare($sql)->execute([$stageName,$bio,$youtube, $soundcloud,$instagram,$snap,$twitter,(int)$uid]);
    if($update){
      $alert = 'successful updated entry';
    }else{
      echo 'something went wrong'. $e->getMessage();
    }}elseif($count == 0){
      $bio = $_POST['bio'];
      $stageName = $_POST['stageName'];
      $youtube = $_POST['youtube'];
      $soundcloud = $_POST['soundcloud'];
      $instagram = $_POST['instagram'];
      $snap = $_POST['snapchat'];
      $twitter = $_POST['twitter'];
      $uid = $_POST['uid'];
      //user has no info inside table, insert new info
      $sql = "INSERT INTO userbrand (stageName, bio,youtube,soundcloud,instagram,snapchat,twitter,uid) VALUES (?,?,?,?,?,?,?,?)";
      $insert = $pdo->prepare($sql)->execute([$stageName,$bio,$youtube,$soundcloud,$instagram,$snap,$twitter,(int)$uid]);
      if($insert){
      $alert = 'successful new entry';
      exit;
    }else{
      $alert = 'new entry didnt work';
    }
    }
  }catch(PDOException $e)
      {
      echo $e->getMessage();
      }
}
if(isset($_POST['contactUpdate'])){
  $_SESSION['formalert'] = NULL;
  try{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE uid = ?');
    $stmt->execute([$uid]);
    $count = $stmt->rowCount();
    if($count > 0){
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      //user has info inside table, update info
      $sql = "UPDATE users SET email = ?, phone = ?,address = ? WHERE uid = ?";
      $update = $pdo->prepare($sql)->execute([$email,$phone,$address,(int)$uid]);
    if($update){
      $alert = 'successful updated entry';
    }else{
      $alert = 'nope didnt do it'. $e->getMessage();
    }}elseif($count == 0){
      session_destroy();
      header("location:login.php");
    }
  }catch(PDOException $e)
      {
      echo $e->getMessage();
      }
}
if(isset($_POST['generalUpdate'])){
  $_SESSION['formalert'] = NULL;
  try{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE uid = ?');
    $stmt->execute([$uid]);
    $count = $stmt->rowCount();
    if($count > 0){
      $gender = $_POST['gender'];
      $city = $_POST['city'];
      //user has info inside table, update info
      $sql = "UPDATE users SET gender = ?, city = ? WHERE uid = ?";
      $update = $pdo->prepare($sql)->execute([$gender,$city,(int)$uid]);
    if($update){
      $alert = 'successful updated entry';
    }else{
      $alert = 'nope didnt do it'. $e->getMessage();
    }}elseif($count == 0){
      session_destroy();
      header("location:login.php");
    }
  }catch(PDOException $e)
      {
      echo $e->getMessage();
      }
}
if(isset($_POST['companyUpdate'])){
  $_SESSION['formalert'] = NULL;
  try{
    $stmt = $pdo->prepare('SELECT * FROM companies WHERE uid = ?');
    $stmt->execute([$uid]);
    $count = $stmt->rowCount();
    if($count > 0){
      $id = $_POST['id'];
      $address = $_POST['address'];
      $email = $_POST['email'];
      $tel = $_POST['tel'];
      $description = $_POST['description'];
      $website = $_POST['website'];
      $industry = $_POST['industry'];
      //user has info inside table, update info
      $sql = "UPDATE companies SET CompAddress = ?, CompEmail = ?,CompNum = ?,CompDesc=?,CompSite=?,CompInd=? WHERE uid = ?";
      $update = $pdo->prepare($sql)->execute([$address,$email,$tel, $description,$website,$industry,(int)$uid]);
    if($update){
      $alert = 'successful updated entry';
    }else{
      echo 'something went wrong'. $e->getMessage();
    }}elseif($count == 0){
      $id = $_POST['id'];
      $name = $_POST['name'];
      $address = $_POST['address'];
      $email = $_POST['email'];
      $tel = $_POST['tel'];
      $description = $_POST['description'];
      $website = $_POST['website'];
      $industry = $_POST['industry'];
      //user has no info inside table, insert new info
      $sql = "INSERT INTO companies (CompName,CompAddress, CompEmail,CompNum,CompDesc,CompSite,CompInd,uid) VALUES (?,?,?,?,?,?,?,?)";
      $insert = $pdo->prepare($sql)->execute([$name,$address,$email,$tel,$description,$website,$industry,(int)$uid]);
      if($insert){
      $alert = 'successful new entry';
      exit;
    }else{
      $alert = 'new entry didnt work';
    }
    }
  }catch(PDOException $e)
      {
      echo $e->getMessage();
      }
}
 ?>
<?php getDashHeader();?>
<div class="container">
<h2>SETTINGS</h2>
<p><?php echo $alert; ?>
<h3><b>My Brand</b><button class="w3-btn w3-small" onclick="document.getElementById('brandSettings').style.display='block'">show</button></h3>
<p class="w3-small">stage name, bio, social media pages, logo</p>
<div id="brandSettings" style="display:;">
    <button class="w3-btn w3-red w3-small" onclick="document.getElementById('brandSettings').style.display='none'">hide</button><br><br>
      <div id="logo" class="input-group">
        Logo: 
        <input type="file" name="logo" class="form-control" value="<?php //echo $logo;?>"><br><br>
        <input type="submit" name="updateLogo" class="form-control w3-green" value="Update Logo">
      </div>
    <hr>
<form id="brandForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" style="max-width:500px;">
<?php  brandForm($uid); ?>
</form>
</div>
<hr>
<h3><b>General Info</b> <button class="w3-btn w3-small" onclick="document.getElementById('generalSettings').style.display='block'">show</button></h3>
<p class="w3-small">username, name, gender, city of origin</p>
<div id="generalSettings" class="container" style="display:;">
  <button class="w3-btn w3-red w3-small" onclick="document.getElementById('generalSettings').style.display='none'">hide</button><br><br>
  <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>" style="max-width:500px;">
  <?php generalForm($uid);?>
  </form>
</div>
<hr>
<h3><b>Contact Info </b><button class="w3-btn w3-small" onclick="document.getElementById('contactSettings').style.display='block'">show</button></h3>
<p class="w3-small">email, phone number, address</p>
<div id="contactSettings" style="display:;">
    <button class="w3-btn w3-red w3-small" onclick="document.getElementById('contactSettings').style.display='none'">hide</button><br><br>
    <form id="contactForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" style="max-width:500px;">
    <?php contactForm($uid); ?>
    </form>
</div>
<hr>
<h3><b>Company Info </b><button class="w3-btn w3-small" onclick="document.getElementById('companySettings').style.display='block'">show</button></h3>
<p class="w3-small">name, address, email, phone number</p>
<div id="companySettings" style="display:;">
    <button class="w3-btn w3-red w3-small" onclick="document.getElementById('companySettings').style.display='none'">hide</button><br><br>
    <form id="companyForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="w3-form" style="max-width:500px;">
    <?php companyForm($uid); ?>
    </form>
</div>
</div>
<?php 
function brandForm($uid){
      global $uid;
      global $pdo;
      $sql = 'SELECT * FROM  userbrand WHERE uid = :uid';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':uid' => $uid
      ));
      $count = $stmt->rowCount();
      if($count > 0){
      $data = $stmt->fetchAll();
      foreach($data as $row){
        $bio = $row['bio'];
        $stageName = $row['stageName'];
        $youtube = $row['youtube'];
        $soundcloud = $row['soundcloud'];
        $instagram = $row['instagram'];
        $snap = $row['snapchat'];
        $twitter = $row['twitter'];
        echo '
          <div id="stageName" class="">
          Stage Name<br>
          <input class="form-control" type="text" name="stageName" value="'.$stageName.'">
          </div>
          <div id="bio" class="">
          Bio<br>
          <textarea class="form-control" type="text" name="bio">'.$bio.'</textarea><br>
          </div>
          <div id="youtube" class="">
          Youtube:<br>
          <input type="text" name="youtube" class="form-control" value="'.$youtube.'"><br>
          </div>
          <div id="soundcloud" class="">
            Soundcloud:<br>
            <input type="text" name="soundcloud" class="form-control" value="'.$soundcloud.'"><br>
          </div>
          <div id="instagram" class="">
            Instagram:<br>
            <input type="text" name="instagram" class="form-control" value="'.$instagram.'"><br>
          </div>
          <div id="snapchat" class="">
            snapchat:<br>
            <input type="text" name="snapchat" class="form-control" value="'.$snap.'"><br>
          </div>
          <div id="twitter" class="">
            Twitter:<br>
            <input type="text" name="twitter" class="form-control" value="'.$twitter.'"><br>
          </div>
          <div id="soundcloud" class="">
            <input type="hidden" name="uid" value="'.$uid.'">
            <input type="submit" name="brandUpdate" value="Update Brand" class="form-control w3-blue">
          </div>
          ';
      }}else{
        echo '
          <div id="stageName" class="">
          Stage Name<br>
          <input class="form-control" type="text" name="stageName" value="">
          </div>
          <div id="bio" class="">
          Bio<br>
          <textarea class="form-control" type="text" name="bio" placeholder=""></textarea><br>
          </div>
          <div id="youtube" class="">
          Youtube:<br>
          <input type="text" name="youtube" class="form-control" value=""><br>
          </div>
          <div id="soundcloud" class="">
            Soundcloud:<br>
            <input type="text" name="soundcloud" class="form-control" value=""><br>
          </div>
          <div id="instagram" class="">
            Instagram:<br>
            <input type="text" name="instagram" class="form-control" value=""><br>
          </div>
          <div id="snapchat" class="">
            snapchat:<br>
            <input type="text" name="snapchat" class="form-control" value=""><br>
          </div>
          <div id="twitter" class="">
            Twitter:<br>
            <input type="text" name="twitter" class="form-control" value=""><br>
          </div>
          <div id="soundcloud" class="">
            <input type="hidden" name="uid" value="'.$uid.'">
            <input type="submit" name="brandUpdate" value="Update Brand" class="form-control w3-blue">
          </div>
          ';
      }
}
function contactForm($uid){
  global $uid;
  global $pdo;
  $sql = 'SELECT email,phone FROM  users WHERE uid = :uid';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':uid' => $uid
  ));
  //only one row expected, use fetch, not fetchAll
  $data = $stmt->fetchALL();
  foreach($data as $row){
    $email = $row['email'];
    $phone = $row['phone'];
    echo '
    email<br>
    <input class="form-control" type="text" name="email" value="'.$email.'"><br>
    phone number<br>
    <input class="form-control" type="text" name="phone" value="'.$phone.'"><br>
    <div id="soundcloud" class="input-group">
    <input type="hidden" name="uid" value="'.$uid.'">
    <input class="form-control w3-blue" type="submit" name="contactUpdate" value="Update Contact">
    </div>
      ';
  }
}
function generalForm($uid){
        global $uid;
        global $pdo;
        $sql = 'SELECT fname, lname FROM  users WHERE uid = :uid';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':uid' => $uid
        ));
        //only one row expected, use fetch, not fetchAll
        $data = $stmt->fetchALL();
        foreach($data as $row){
          $name = $row['fname']. ' '.$row['lname'];
          echo '
          <form id="generalForm" class="w3-form" style="max-width:300px;">
          <b>UserName:</b><br>
          <input class="form-control" type="text" name="name" value="'.$_SESSION['uname'].'" disabled><br>
          <b>Name</b>:<br>
          <input class="form-control" type="text" name="name" value="'.$name.'" disabled><br>
          <br>
          <input class="form-control w3-blue" type="submit" name="generalUpdate" value="Update Info">
        </form>
            ';
        }
      }
function companyForm($uid){
              global $uid;
              global $pdo;
              $sql = 'SELECT * FROM companies WHERE uid = :uid';
              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ':uid' => $uid
              ));
              //only one row expected, use fetch, not fetchAll
              $data = $stmt->fetchALL();
              $count = $stmt->rowCount();
              if($count >0){
              foreach($data as $row){
                echo '
                <b>Name:</b><br>
                <input class="form-control" type="text" name="name" value="'.$row['CompName'].'" disabled><br>
                <b>Address</b>:<br>
                <input class="form-control" type="text" name="address" value="'.$row['CompAddress'].'"><br>
                <br>
                <b>Phone Number</b>:<br>
                <input class="form-control" type="tel" name="tel" value="'.$row['CompNum'].'"><br>
                <br>
                <b>Email</b>:<br>
                <input class="form-control" type="email" name="email" value="'.$row['CompEmail'].'"><br>
                <br>
                <b>Description</b>:<br>
                <input class="form-control" type="text" name="description" value="'.$row['CompDesc'].'"><br>
                <br>
                <b>Web Address</b>:<br>
                <input class="form-control" type="url" name="website" value="'.$row['CompSite'].'"><br>
                <br>
                <b>Industry</b>:<br>
                <input class="form-control" type="text" name="industry" value="'.$row['CompInd'].'"><br>
                <br>
                <input type="hidden" name="id" value="'.$row['CompID'].'">
                <input class="form-control w3-blue" type="submit" name="companyUpdate" value="Update Info">
                  ';
              }}else{
                echo '
                <b>Name:</b><br>
                <input class="form-control" type="text" name="name"><br>
                <b>Address</b>:<br>
                <input class="form-control" type="text" name="address"><br>
                <br>
                <b>Phone Number</b>:<br>
                <input class="form-control" type="tel" name="tel"><br>
                <br>
                <b>Email</b>:<br>
                <input class="form-control" type="email" name="email"><br>
                <br>
                <b>Description</b>:<br>
                <input class="form-control" type="text" name="description"><br>
                <br>
                <b>Web Address</b>:<br>
                <input class="form-control" type="url" name="website"><br>
                <br>
                <b>Industry</b>:<br>
                <input class="form-control" type="text" name="industry"><br>
                <br>
                <input type="hidden" name="id">
                <input class="form-control w3-blue" type="submit" name="companyUpdate" value="Update Info">
                  ';
              }
            }
?>
<?php getMtFooter();?>
