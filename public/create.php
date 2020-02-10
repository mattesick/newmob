<?php
require_once "../boot.php";
include "storage.php";
if (isset($_SESSION["uid"]) && getRole($_SESSION["uid"]) != "Admin") {
    header("location:index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="sv">

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
    if (isset($_POST["email"]) && isset($_POST["psw"]) && isset($_POST["cpsw"]) && isset($_POST["fname"]) && isset($_POST["lname"])) {
        if (!isset($_POST["role"])) {
            $role = "Customer";
        } else {
            $role = mysqli_real_escape_string($conn, $_POST['role']);
        }
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['psw']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['cpsw']);
        $firstName = mysqli_real_escape_string($conn, $_POST['fname']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lname']);
        //checks if the passwrod is shorter or equal than 7 and if so an error will be saved.
        if (strlen($password) <= 7) {
            $error = "Password must be longer than 7 characters";
            //this confirms that we typed in the same password.
        } elseif ($password != $confirmPassword) {
            $error = "Your password doesn't match!";
            //checks if username already exists.
        } elseif (verifyUser($email)) {
            $error = "User exists";
        } else {
            //if nothing went wrong we add the user to our database and send the admin to  allUsers.php.
            addUser($email, $password, $firstName, $lastName, $role);
            
        }
    }

    ?>
    <form action="create.php" method="post">
        <div class="imgcontainer">
        </div>

        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Epost.." name="email" required>

            <label for="psw"><b>Lösenord</b></label>
            <input type="password" placeholder="Lösenord.." name="psw" required>
            <label for="cpsw"><b>Kontrollera lösenord</b></label>
            <input type="password" placeholder="Kontrollera lösenord.." name="cpsw" required>
            <label for="fname"><b>Förnamn</b></label>
            <input type="text" placeholder="Förnamn.." name="fname" required>
            <label for="lname"><b>Efternamn</b></label>
            <input type="text" placeholder="Efternamn.." name="lname" required>
            <?php if (isset($_SESSION["uid"]) && getRole($_SESSION["uid"]) == "Admin") : ?>
                <label for="role"><b>Roll</b></label>
                <select id="inputState" name="role" class="form-control">
                    <option selected>Customer</option>
                    <option>Employee</option>
                    <option>Admin</option>
                </select>
            <?php endif ?>
            <button type="submit">Registrera</button>
        </div>

    </form>

</body>

</html>