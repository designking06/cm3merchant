<?php
require_once('../require.php');
if(isset($_POST['registerPendingSub'])){
      $fn = $_POST['fname'];
      $ln = $_POST['lname'];
      $em = $_POST['email'];
      $u = $_POST['uname'];
      $uspwd = $_POST['pwd'];
      $cuspwd = $_POST['cpwd'];
      if($u == NULL){
        echo 'Please enter a username';
      }
      if($uspwd == NULL){
        echo ' please enter a password';
      }
      if($cuspwd == NULL){
        echo 'please confirm your password';
      }
      if($uspwd != $cuspwd){
        echo 'please make sure the passwords match';
      }else{
        $pwd = password_hash($uspwd, PASSWORD_DEFAULT);
        $pm = "r";
        $dt = date("Y-m-d");
        try{
            registerPd($fn,$ln,$em,$u,$pwd,$pm);
          }catch(PDOException $e){
            $alert= $e->getMessage();
          }
      }
}
?>
<?php getHead(); ?>
<?php
?>
<header>
     <table class="container-fluid align-center"  style="width:100%;margin-top:20px;">
     <tr style="height: 110px;">
         <td class="col-sm-4"></td>
         <td class="col-sm-4  w3-center"></td>
         <td class="col-sm-4"></td>
     </tr>
     </table>
</header>
 <div id="body" class="container-fluid" style="width: 100%;padding-bottom: 20px;">
 <div class="row w3-text-white" style="text-align: center; padding-top: 30px;">
     <h2 class="w3-jumbo w3-text-blue">Welcome, CM3 Merchant</h2><h3 class="w3-text-grey">Please sign in.</h3>
 </div>
<!-- END HEADER -->
     <div class="row">
         <div class="container">
           <div style="max-width:80%; margin:auto;">
             <div class="w3-white w3-border w3-border-blue w3-opacity" style="min-height:175px;">
                 <h3 class="w3-padding text-left">
                     The revolutionary management app, created to help anyone faced with making decisions.<br>Take advantage of our statistics capabilities, storage space, customer service, client management and more.
                 </h3>
             </div>
           </div>
           </div>
     </div>
     <div class="row text-center"><h3 class="w3-text-red"><?php if(isset($_GET['alert'])){ echo $_GET['alert']; } ?></h3></div>
<div class="col-sm-4 w3-padding"></div>
<div id="form" class="col-sm-4">
  <a href="index.php"><div class="w3-btn w3-blue w3-padding">Back To Login</div></a><br>
  <h3 class="w3-text-blue">Register As A Merchant Here</h3>
  <p>ALL FIELDS ARE REQUIRED</p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="fname" type="text" class="form-control" name="fname" placeholder="first name">
        </div>
        <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="lname" type="text" class="form-control" name="lname" placeholder="last name">
        </div>
        <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="email" type="text" class="form-control" name="email" placeholder="email">
        </div>
        <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="uid" type="text" class="form-control" name="uname" placeholder="username">
        </div>
        <br><p class="w3-text-red">ATTENTION:<br> CM3 HAS NO ACCESS TO YOUR PASSWORD, IF YOU LOSE IT, YOU MUST RESET IT.<br> DONT LOSE IT.</p>
        <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input id="password" type="password" class="form-control" name="pwd" placeholder="Password">
        </div>
        <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input id="password" type="password" class="form-control" name="cpwd" placeholder=" Confirm Password">
        </div>
      <br>
        <div class="input-group">
                 <input id="loginSubmit" type="submit" class="form-control" name="registerPendingSub" value="REGISTER">
        </div>
</form>
</div>
<div class="col-sm-4"></div>
