<?php 
session_start(); 
$_SESSION['config']="";
include "functions.php"; 
if (isset($_POST['login'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if ($email=="mdazmat9@gmail.com") {
        header("Location: index.php");
	} else {
		$errormsg = "Incorrect Email or Password!!!";
	}
}
?>
<?php include "includes/header.php" ?>
<br><br>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="login.php" method="post" name="loginform">
				<fieldset>
					<legend>Login</legend>

					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Your Email" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
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
