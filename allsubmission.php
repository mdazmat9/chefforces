<?php 
session_start(); 
include "functions.php";
include "includes/NAME.php";
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
	$page=1;
}
if($page<=0){
    $page=1;
}
$per_page=20;
$contestCode="";
$problemCode="";
if(isset($_GET['contestCode'])){
    $contestCode=$_GET['contestCode'];
}
if(isset($_GET['problemCode'])){
    $problemCode=$_GET['problemCode'];
}
if($problemCode=="" && $contestCode==""){
    header("Location: index.php");
}

$response = json_decode(get_all_submission_of_a_problem_with_pageno($_SESSION['config'],$_SESSION['outh'],$contestCode,$problemCode,$page),true);
if (array_key_exists("content",$response['result']['data'])==false){
    header("Location: allsubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?> ");
}
$res = $response['result']['data']['content'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>allsubmission</title>
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
        <a class="navbar-brand" href="index.php"><b><?php echo ($name); ?></b></a>
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
    <div class="col span-1-of-2">Welcome,<b> <?php echo $_SESSION['config']['user_name']; ?></b><br><br>
        <a href="contest.php?q=<?php echo $contestCode;  ?>"> Go back to contest</a>
    </div>

</div><br>

<div class="row allsubmission" style="text-align:center;">
    <h2>All submission</h2>
    <table  class="ranklist table table-bordered" style ="text-align:center;">
    <tr>
        <th style ="text-align:center;">date</th>
        <th style ="text-align:center;">user</th>
        <th style ="text-align:center;">problem</th>
        <th style ="text-align:center;">contest</th>
        <th style ="text-align:center;">Lang</th>
        <th style ="text-align:center;">result</th>
        <th style ="text-align:center;">time</th>
        <th style ="text-align:center;">memory</th>
    </tr>
    <?php 
        
    foreach($res as $x){
        echo "<tr>";
        echo "<td>".$x['date']."</td>";
        echo "<td>".$x['username']."</td>";
        echo "<td>".$x['problemCode']."</td>";
        echo "<td>".$x['contestCode']."</td>";
        echo "<td>".$x['language']."</td>";
        echo "<td>".$x['result']."</td>";
        echo "<td>".$x['time']."</td>";
        echo "<td>".$x['memory']."</td>";
    }
    ?>
      
    </table>
</div>
<div class="row" style="text-align:center;">
    <ul class="pagination">
        <li 
    <?php
        if($page==1)
        echo "class='disabled'";
    ?>
        ><a href="allsubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?>&page=<?php echo $page-1; ?>">
        <i class="material-icons"><'Prev</i></a></li>
    <?php
    
        ?>
        <li 
        <?php 

        if($page==$page)
        echo "class='active'";
        ?>
        
        ><a href="allsubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?>&page=<?php echo $page; ?>">
        <?php echo $page;?> </a></li>
        <?php
    
    ?>

        <li 
        ><a href="allsubmission.php?contestCode=<?php echo $contestCode; ?>&problemCode=<?php echo $problemCode; ?>&page=<?php echo $page+1; ?>">
        <i class="material-icons">Next'></i></a></li>
    </ul>

    </div>
    
</div>



 
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->
 <?php include "includes/footer.php"; ?>
 </body>
 </html>