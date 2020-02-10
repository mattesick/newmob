<!DOCTYPE html>
<html lang="sv">
<?php require_once "../boot.php";
if (isset($_SESSION["uid"]) && $engine->getUserWithId($_SESSION["uid"]) != "Admin") {
	header("location:index.php");
	die();
}
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php include "js/scripts.php";
	include "css/style.php";
	?>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<?php
	$error = "";
	if (isset($_POST["email"]) && isset($_POST["psw"])) {
	//gets password from the username you enterd.
		$result = $engine->provider->fetchRow('SELECT password,email_verified FROM user WHERE email = ?', array($_POST["email"]));
		$password = $result["password"];
	//checks if the password matches with the bcrypted password.
		if (password_verify($_POST['psw'], $password)) {
			if ($result["email_verified"] == 1) {
				//Succeded login, will be sent to index. otherwise the error will be set and shown on the website.
				$logginUser = $engine->getUserWithEmail($_POST["email"]);

				$_SESSION['uid'] = $logginUser["id"];
				$engine->redirect("index.php"); 
			} else {
				$error = 'User is not verified';    
			}
		} else {
			$error = 'Fel email eller lösenord!';
		}
	}

	?>
	<form action="login.php" method="post">
		<div class="imgcontainer">
		</div>

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php show_messsage('success'); ?>
					<?php show_messsage('danger'); ?>
					<?php show_messsage('info'); ?>
				</div>
			</div>
			<p class="login-error"><?php if ($error != "") echo $error; ?></p>
			<label for="email"><b>Email</b></label>
			<input type="email" placeholder="Epost.." name="email" required>

			<label for="psw"><b>Lösenord</b></label>
			<input type="password" placeholder="Lösenord.." name="psw" required>
			<span class="psw"><a href="#">Glömt lösenord?</a></span>
			<button type="submit">Logga in</button>
		</div>

	</form>

</body>

</html>