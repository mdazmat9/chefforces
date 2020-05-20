<?php 
session_start(); 
include "functions.php"; 
include "includes/NAME.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title> <?php echo ($name); ?> Home </title>
    <?php include "includes/sheet.php"; ?>
<script> 
 jQuery(function(){ 
 $("#search").autocomplete("search.php");
 });
 </script>
</head>
<body>
<div class="row"> 
<?php
    $var;
    if($_SESSION['config']==""){
        $var=main(); 
        $_SESSION['config']=$var['config'];
        $_SESSION['outh']=$var['outh'];
        $me = about_me($_SESSION['config'],$_SESSION['outh']);
        $me = json_decode($me,true);
        $_SESSION['user_name']=$me['result']['data']['content']['username'];
        // fillDB();
        // fillcountry();
        //  fill_language();
    }
?>  
 </div>
<!-- Navbar -->
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="#"><b><?php echo ($name); ?></b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php"><b>Home</b></a></li>
        <li><a href="#"><b>Contact us</b></a></li>
        <li><a href="ide.php"><b>IDE</b></a></li>
        <li><a href="logout.php"><b>Logout</b></a></li>
      </ul>
    </div>
  </div>
</nav>
    <div class="row">Welcome,<b> <?php echo $_SESSION['user_name']; ?></b></div><br>
    <div class="container">  
      <div class="row">
       <form action="contest.php" class="contests">
            <div class="form-group">
                        <h2><label for="name">Contest</label></h2>
						<h3>
						<input type="text" name="q" id="search" placeholder="contest" required class="form-control" />
                        </h3>
            </div>
            <div class="form-group">
						<input type="submit" name="login" value="Submit" class="btn btn-primary" />
            </div>
       </form>
      </div>
  </div>
  <br><br><br><br><br><br><br><br>
  <div class="row"></div>
  <?php include "includes/footer.php"; ?>
</body>
</html>