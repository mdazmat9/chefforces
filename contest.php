<?php
session_start(); 
include "includes/NAME.php";
include "functions.php";
$con=getDBconnection();
$id = $_GET['q'];
$sql="select code from contest where name='".$id."'";
$result = mysqli_query($con,$sql);
$contestcode;
while($rows = mysqli_fetch_array($result)){
    $contestcode = $rows['code'];
}
if($contestcode==""){
    header("Location: index.php");
}
$_SESSION['contestCode']=$contestcode;
$contest = json_decode(get_contest_details($_SESSION['config'], $_SESSION['outh'],$contestcode),true);
$problem = $contest['result']['data']['content']['problemsList'];

$recent=json_decode(get_submission_of_contest($_SESSION['config'], $_SESSION['outh'],$contestcode),true);
$recent=$recent['result']['data']['content'];
//$problemapi;
//$i=0;
//foreach($problem as $x){
//    $problemapi[$i] = json_decode(get_problem($_SESSION['config'],$_SESSION['outh'],$x['contestCode'],$x['problemCode']),true);
//    $i++;
//}
?>
<!DOCTYPE html>
<html>
<head>
    <title> contest </title>
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
      <div class="col span-1-of-2">Welcome,<b> <?php echo $_SESSION['user_name']; ?></b>
      </div>
      <div class="col span-1-of-2" style="text-align:right;">
    <!-- <a href=problem.php?data1=".$x['problemCode']."&data2=".$x['contestCode'].">".$x['problemCode']."</a> -->
        <a href="ranklist.php">Rank List</a><br>
        <a href="mysubmission.php?contestCode=<?php echo $contestcode; ?>">My submission</a><br>
        <a href="allsubmission.php?contestCode=<?php echo $contestcode; ?>">All submission</a><br>
        <a href="index.php">select contest</a>
       </div>
    </div>
    <div class="container">  
      <div class="row">
        <h2><?php
            echo $contest['result']['data']['content']['name']; ?>
        </h2>
      </div>
      
      <div class="row"  >
<!--       style="background-color:#e6e6e6;"-->
       <div class="col span-1-of-2"  >
               <br><br>
                <img src= "<?php echo $contest['result']['data']['content']['bannerFile']; ?>" width="850px" height="500px" style="text-align:left;" alt="Image Not found">
        </div>
        <div class="col span-1-of-2" >
            <div class="col span-1-of-2" ></div>
            <div class="recent col span-1-of-2" style ="text-align:center;" >
                <u><h3  style ="text-align:right;">Recent Submissions</h3></u>
            <table class="contest table table-bordered" style ="text-align:center;" style="overflow-x:auto;">
            <tr>
                <th style ="text-align:center;" >User</th>
                <th style ="text-align:center;">Code</th>
                <th style ="text-align:center;">Lang</th>
                <th style ="text-align:center;">res</th>
              </tr>

                 <?php 
                    foreach($recent as $x){
                        echo "<tr>
                            <td>".$x['username']."</td>
                            <td>".$x['problemCode']."</td>
                            <td>".$x['language']."</td>
                            <td>".$x['result']."</td>
                          </tr>" ;
                    }
                ?>
           
            </table>
            </div>
              
                
            
        </div>
        </div>
        <div class="row">
            <h2>Problems of This Contest</h2>
            <table class="contest table table-bordered" style ="text-align:center;">
            <tr>
                <th style ="text-align:center;">Problem Code</th>
                <th style ="text-align:center;">Successful Submission</th>
                <th style ="text-align:center;">Accuracy</th>
              </tr>
<!--
              <tr>
                <td>Jill</td>
                <td>Smith</td>
                <td>50</td>
              </tr>
-->
              <?php 
                    foreach($problem as $x){
                        echo "<tr>
                            <td><a href=problem.php?data1=".$x['problemCode']."&data2=".$x['contestCode'].">".$x['problemCode']."</a></td>
                            <td>".$x['successfulSubmissions']."</td>
                            <td>".round($x['accuracy'],2)."</td>
                          </tr>" ;
                    }
                ?>
            </table>
        </div>
  </div>
    <?php include "includes/footer.php ";?>