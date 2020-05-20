<?php 
session_start(); 
$_SESSION['config']="";
include "functions.php"; 
if (isset($_POST['login'])) {

	$email = $_POST['email'];

    header("Location: index.php");
	
}
?>
<?php include "includes/header.php" ?>
<br><br>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="login.php" method="post" name="loginform">
				<fieldset>
					<legend>Welcome to ChefForces</legend>

					<div class="form-group">
						<label for="name">Please Enter Your Name</label><h1></h1>
						<input type="text" name="email" placeholder="Your Name" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name"></label>
						<!-- <p>Nothing</p> -->
						<!-- <input type="password" name="password" placeholder="Your Password" required class="form-control" /> -->
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Enter" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
	</div>

</div><br><br><br>
<?php include "includes/footer.php" ?>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
