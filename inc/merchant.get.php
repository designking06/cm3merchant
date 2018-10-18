<?php
/* function getHead(){
  ?>
  <head>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/new_w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
  <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
<?php
} */ 
?>
<?php
function getDashHeader(){
  ?>
  <div class="container-fluid">
  <div id="header">
      <div class="w3-black"><div class="text-center">
          <?php 
        if(isset($_SESSION['compID']))
          { ?>
          <a class="" href="dash.php?compID=<?php echo $_SESSION['compID'];?>">
              <?php }else{ ?>
          <a href="dash.php">  
        <?php } ?>
        <h2>
          <span class="">C</span>
          <span class="">M</span>
          <span class="">3</span>
        </h2>
      </a></div>
        <ul class="nav justify-content-center w3-black w3-padding">
          <li class="nav-item">
            <a class="nav-link active" onclick="document.getElementById('userMenu').style.display='block'">
                <h6 class="w3-text-blue">Account<span class="w3-hide-small"> :<span class="w3-text-green"><?php echo $_SESSION['uname'];?></span></span></h6>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" onclick="document.getElementById('siteMenu').style.display='block'"><h6 class="w3-text-blue">Menu</h6></a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#"><h6>Messages</h6></a>
          </li>
        </ul>
      </div>
  </div>
  <div class="" style="min-height:80%;">
<?php }
//Sticky Navigation
?>
