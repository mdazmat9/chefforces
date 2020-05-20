<!-- C++14 , sourceCode , language ,input -->
<?php
session_start(); 
include "functions.php"; 
include "includes/NAME.php";
$sourceCode="";
$language="";
$input="";
$output="";
$con=getDBconnection();
if(!$con){
die('Could not connect');
}
$sql = "select name from language" ;
$result = mysqli_query($con,$sql);
$result= mysqli_fetch_all($result, MYSQLI_ASSOC);
$res;
$type=0;
if(isset($_POST['sourceCode'])){
    $sourceCode=$_POST['sourceCode'];
}
if(isset($_POST['input'])){
    $input=$_POST['input'];
}
if(isset($_POST['language'])){
    $language=$_POST['language'];
}
if(isset($_POST['run'])){
    $type=0;
    $output=$_POST['submissionId'];
    $res=json_decode(getstatusofcode($_SESSION['config'],$_SESSION['outh'],$output),true);
}
else if($sourceCode!="" && $language!=""){
    $type=1;
    $output=json_decode(runCode($_SESSION['config'],$_SESSION['outh'],$sourceCode,$language,$input),true);
    $output=$output['result']['data']['link'];
    // print_r($output);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title> IDE </title>
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
      <a href="contest.php?q=<?php echo $_SESSION['contestCode']; ?>">Back to contest</a>
    </div>
</div>
<form action="ide.php" method="post">
    <div class="row ">
    <h2>Source Code</h2>
    <textarea name="sourceCode" style="width=auto; height:350px;"> 
        <?php echo $sourceCode; ?>   
    </textarea>
    </div>
    <div class="row">
        <div class="col span-1-of-2">
            <h2>Input</h2>
            <textarea name="input" style="width=auto; height:100px;">
                <?php echo $input; ?> 
            </textarea>
            <?php if($type==0){ ?>
            <h3>Select Language</h3>
                <select id="search" name="language">
                    <?php
                        foreach($result as $row){
                            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                        }
                    ?>
                </select>
                    <?php } ?> 
        </div>
        <div class="col span-1-of-2">
            <h2>Output</h2>
            <textarea name="output" style="width=auto; height:100px;">
            <?php 
                if(isset($_POST['run'])){
                    if ($res['result']['data']['cmpinfo']==""){ //cmpinfo
                        echo($res['result']['data']['output']);
                    }
                    else{
                       echo $res['result']['data']['cmpinfo'];
                    }
                }
            ?> 
            </textarea>
            <h3>
                <h3>Compilation ID :</h3><input type="text" name="submissionId" value="<?php
                    if($type==1) 
                        echo $output; 
                ?>">
            </h3>
            <h3></h3>
            <?php 
                if($type==1){
            ?>
            <input type="submit" name="run" value="Run code" class="btn btn-primary" />
                <?php }else{ ?>
            <input type="submit" name="submission" value="Compile" class="btn btn-primary" />
                <?php } ?>
        </div>
    </div>
    
</form>
<!-- <div class="row" style="text-align:right">
    <form action="ide.php" method="post">
    <input type="hidden" name="sourceCode" value="<?php echo $sourceCode; ?>" >
    <input type="hidden" name="input" value="<?php echo $input; ?>" >
    <input type="hidden" name="submissionId" value="<?php echo $output; ?>" >
    <input type="submit" name="run" value="Get Output" class="btn btn-primary" />
    </form>
</div> -->
<br>
<?php include "includes/footer.php"; ?>
</body>
</html>


