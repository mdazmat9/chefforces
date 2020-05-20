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
$per_page=50;
$contestCode = $_SESSION['contestCode'];
$country="";
$institution="";
if(isset($_GET['q'])){
    $country=$_GET['q'];
}
if(isset($_GET['institution'])){
    $institution=$_GET['institution'];
}
$response = json_decode(get_ranklist_of_contest_with_pageno($_SESSION['config'],
             $_SESSION['outh'],$contestCode,"",""),true);
$res = $response['result']['data']['content'];
$check=false;
foreach ($res as $x){
    if($x['country']==$country){
        $check=true;
    }
}
if($check==false){
    $country="";
}
if($check==true){
    $response = json_decode(get_ranklist_of_contest_with_pageno($_SESSION['config'],
        $_SESSION['outh'],$contestCode,$country,$institution),true);
    $res = $response['result']['data']['content'];
}
$length=sizeof($res);
$no_of_page=ceil($length/$per_page);
$rem=$length-($page-1)*$per_page;
$len=min($rem,$per_page);
$start=($page-1)*$per_page;
$contest = json_decode(get_contest_details($_SESSION['config'], $_SESSION['outh'],$contestCode),true);
$problem = $contest['result']['data']['content']['problemsList'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ranklist</title>
    <?php include "includes/sheet.php"; ?>

<script> 
 jQuery(function(){ 
 $("#search").autocomplete("ranksearch.php");
 });
 </script>
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
    <div class="col span-1-of-2">Welcome,<b> <?php echo $_SESSION['user_name']; ?></b><br><br>
        
        <!-- <input onclick="goBack()" type="submit" name="goBack()" value="Go back"  /> -->
        <a href="contest.php?q=<?php echo $contestCode;  ?>"> Go back to contest</a>
    </div>
    <div class=" col span-1-of-2" >
    <h2>Filter</h2>
    <form action="ranklist.php" >
        <div class="form-group">
            <input type="text" name="q" id="search" placeholder=
                <?php 
                if($country ==""){
                    echo "country";
                }else{
                    echo $country;
                }
                ?>
            />
        </div>
        <div class="form-group">
                    <input type="submit" name="submit" value="Filter" class="btn btn-primary" />
        </div>
    </form>

</div><br>
<?php
if($len>0)
{
?>
<div class="row rank"  style="text-align:center;">
    <h2>Rank List <?php echo $contest['result']['data']['content']['name'];  ?></h2>
    <table  class="ranklist table table-bordered" >
    <tr>
        <th style ="text-align:center;">Rank</th>
        <th style ="text-align:center;">user</th>
        <th style ="text-align:center;">score</th>
        <th style ="text-align:center;">penalty</th>
         <?php 
            foreach($problem as $x){
                echo '<th style ="text-align:center;">'.$x['problemCode'].'</th>';
            }
        ?>
    </tr>
    <?php 
        
        for($t=0;$t<$len;$t++){
        echo "<tr>";
        echo "<td>".(($page-1)*($per_page)+$t+1)."(".$res[$start]['rank'].")</td>";
        echo "<td>".$res[$start]['username']."</td>";
        echo "<td>".$res[$start]['totalScore']."</td>";
        echo "<td>".$res[$start]['totalTime']."</td>";
        $temp;
        foreach($problem as $x){
            $temp[$x['problemCode']]='0';
        }
        foreach($res[$start]['problemScore'] as $x){
            $temp[$x['problemCode']]="1 <span style='color:red;'>(".$x['penalty'].")</span>";
        }
        foreach($problem as $x){
            echo "<td>".$temp[$x['problemCode']]."</td>"; 
        }
        echo "</tr>";
        $start++;
    }
    ?>
<!--
        <tr>
        <td>Jill</td>
        <td>Smith</td>
        <td>50</td>
        </tr>
-->
      
    </table>
</div>

<div class="row " style="text-align:center;">
 <ul class="pagination">
    <li 
<?php
    if($page==1)
    echo "class='disabled'";
?>
    ><a href="ranklist.php?page=<?php
echo $page-1;
    ?>&q=<?php echo $country ?>
    "
    
    
    
    ><i class="material-icons"><</i></a></li>
   <?php
   for($i=1;$i<=$no_of_page;$i++)
   {
       ?>
       <li 
       <?php 

       if($page==$i)
       echo "class='active'";
       ?>
       
       ><a href="ranklist.php?page=<?php echo $i;?>&q=<?php echo $country ?>"><?php echo $i;?></a></li>
       <?php
   }
   ?>

    <li 
    <?php
    if($page==$no_of_page)
    echo "class='disabled'";
?>
    
    ><a href="ranklist.php?page=<?php
echo $page+1;
    ?>&q=<?php echo $country ?>"><i class="material-icons">></i></a></li>
  </ul>

</div>
<?php
}
else
{
  header("Location: ranklist.php?page=1&q=<?php echo $country ?>");
}
?>
</div>

 
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->
 <?php include "includes/footer.php"; ?>
 </body>
 </html>