<?php require_once "../boot.php"; include "rights/auth.php"; ?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "js/scripts.php";
    include "css/style.php";
    ?>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/select.js" defer></script>
    <script src="js/article.js" defer></script>
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/settings.css">
</head>

<body>
    <?php
    include "partials/nav.php";
    ?>
    <div class="welcome">
        <h2>VÄLKOMMEN, <?php echo $engine->getName($_SESSION["uid"]); ?>!</h2>
        <p><?php
            $datum = utf8_encode(strftime("%A"));
            setlocale(LC_TIME, "Swedish");
            $date = getdate();
            echo $datum . " " .  $date["mday"] . "/" . $date["mon"] . " - " .  $date["year"];
            ?></p>
    </div>
    <div>

        <a href="logout.php">Logga ut</a>
        <?php if ($engine->getRole($_SESSION["uid"]) == "Admin") : ?>
            <a href="create.php">Skapa nytt konto</a>

            <!-- Lägg till dropdown item  -->
            <?php 
                if(isset($_POST["itemTitle"]) && isset($_POST["title"])){
                    $engine->addDropdownItem($_POST["title"], $_POST["itemTitle"]);
                }
            ?>
            <form class="make-dropdown"action="settings.php" method="post">
            <div class="custom-select">
                        <select name="title">
                            <option value="0">Förhandsval meny titel...</option>
                            <option value="Märkning">Märkning</option>
                            <option value="Referens">Referens</option>
                            <option value="Källa">Källa</option>
                            <option value="Typ av boende">Typ av boende</option>
                            <option value="Anteckning">Anteckning</option>
                        </select>
                    </div>
                <input type="text" placeholder="Titel på förhandsval.."name="itemTitle" id="">
                <input type="submit" value="Lägg till">
            </form>



        <?php endif ?>
        <?php
        $engineInfo = $engine->getUserWithId($_SESSION["uid"]);
        $email = $engineInfo["email"];
        $role = $engineInfo["role"];
        ?>
        <h2>Användare:</h2>
        <p>Email: <?php echo $email; ?></p>
        <p>Roll: <?php echo $role; ?></p>
    </div>
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <form class="addNew">
                </form>
            </div>
        </div>
    </div>
</body>

</html>