<?php
session_start(); 
include "functions.php"; 
include "includes/NAME.php";
$problemCode;
$contestCode;
if(isset($_GET['data1'])){
    $problemCode= $_GET['data1'];
}
if(isset($_GET['data2'])){
    $contestCode= $_GET['data2'];
}
$res=json_decode(get_problem($_SESSION['config'],$_SESSION['outh'],$contestCode,$problemCode),true);
$result=$res['result']['data']['content'];

$response = json_decode(get_all_submission_of_a_user_on_a_problem_with_pageno($_SESSION['config'],$_SESSION['outh'],$contestCode,$problemCode,1,$_SESSION['config']['user_name']),true);
$sub = $response['result']['data'];
?>

<!DOCTYPE html>
<html>
<head>
    <title> problem </title>
    <?php include "includes/sheet.php"; ?>
</head>
<body>
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
<div class="row">
    <div class="col span-1-of-2">Welcome,<b> <?php echo $_SESSION['user_name']; ?></b><br><br>
    </div>
    <div class="col span-1-of-2" style="text-align:right;">
      <a href="mysubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?>">My submission</a><br>
      <a href="allsubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?>">All submission</a><br>
      <a href="contest.php?q=<?php echo $contestCode; ?>">Back to contest</a>
    </div>
</div>
<div class="row question">
    <h2><?php echo $result['problemName'] ;
    $ac="NOT ATTEMPTED";
    $color="black";
    if (array_key_exists("content",$sub)==true ){
      $ac="ATTEMPTED";
      $color="red";
      foreach($sub['content'] as $x){
        if($x['result']=="AC"){
          $color="#00ff00";
          $ac="ACCEPTED";
        }
      }
    }
    ?>
    </h2>
    <h3 style="text-align:right;"> Status : <span style="color:<?php echo $color; ?>;"><?php echo $ac; ?></span>  </h3>
    <h3 style="text-align:right;"><a  href="ide.php">Try on IDE</a></h3>
    <br>
    <?php 
    $text = str_replace("<br>", "", $result['body']);
    echo $text ;?>
</div>
<br>
<?php include "includes/footer.php"; ?>
</body>
</html>