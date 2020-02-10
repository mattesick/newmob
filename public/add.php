<?php
require_once "../boot.php";
include "rights/auth.php"; ?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "js/scripts.php";
    include "css/style.php";
    ?>
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/add.css">
    <link rel="stylesheet" href="css/add/request.css">
</head>

<body <?php if (isset($_GET["oid"])) : ?> id=<?php echo $engine->getGeneratedId($_GET["oid"]) ?> <?php endif ?>>

    <?php
    include "partials/nav.php";
    ?>
    <main>
        <div class="add-welcome">
            <h2>NY FÖRFRÅGAN</h2>
            <?php
            if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) : ?>
                <div style="display:flex;float:right;align-items:center;">
                    <button class="copy">KOPIERA ORDER</button>
                    <?php if($engine->getRole($_SESSION["uid"]) !== "Admin") : ?>
                    <i class="fas fa-edit edit-add"></i>
                    <?php endif ?>
                </div>
            <?php endif ?>

        </div>
        <?php include "partials/add/add-request.php";
        include "partials/add/add-article.php";
        ?>
        <div class="chosen-article">
            <div class="remove-article"><i class="fad fa-times"></i></div>
            <div>
                <h3>Flyttpaket 2 - 1-69 kvm</h3>
            </div>
            <div class="inputs">
                <div>
                    <input type="text" placeholder=" " name="" id="ex">
                    <label for="ex">Faktueringsadress...</label>
                </div>
                <div>
                    <input type="text" placeholder=" " name="" id="ex2">
                    <label for="ex2">Faktueringsadress...</label>
                </div>
                <div>
                    <input type="text" placeholder=" " name="" id="e3x">
                    <label for="e3x">Faktueringsadress...</label>
                </div>
                <div>
                    <input type="text" placeholder=" " name="" id="e2x">
                    <label for="e2x">asd...</label>
                </div>
                <div>
                    <input type="text" placeholder=" " name="" id="e1x">
                    <label for="e1x">asd...</label>
                </div>
            </div>
        </div>
        <?php
        include "partials/add/rut-calc.php";
        include "partials/add/add-log-and-files.php";
        ?>


    </main>
    <?php if (!isset($_GET["oid"]) || !$engine->getRequestId($_GET["oid"])) : ?>
        <script>
            let id = "";
            let alf = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            for (let i = 0; i < 32; i++) {
                id += alf[Math.round(Math.random() * (alf.length - 1))];
            }
            $("body").attr("id", id)
        </script>
    <?php endif ?>
    <script src="js/select.js"></script>
    <script src="js/add/addLog.js"></script>
    <?php

    if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"]) && $engine->getRole($_SESSION["uid"]) !== "Admin") : ?>
        <script>
            $("main input").attr("readonly", true).css("background", "rgb(230,230,230)");
            $('main button').prop('disabled', true).css("background", "rgb(230,230,230)");
            $(".copy").prop("disabled", false).css("background", "");
            $('main input[type=submit]').prop('disabled', true).css("background", "rgb(230,230,230)");
            $("main input[type=checkbox]").prop("disabled", true).css("background", "rgb(230,230,230)");
            $(".custom-select").css("background", "rgb(230,230,230)");
            $("main textarea").attr("readonly", true).css("background", "rgb(230, 230, 230)");
            $("main i").off();
            $("main p").off();
            $(".edit-add").click(function() {
                $("main input").attr("readonly", false).css("background", "");
                $('main button').prop('disabled', false).css("background", "");
                $('main input[type=submit]').prop('disabled', false).css("background", "");
                $("main input[type=checkbox]").prop("disabled", false);
                $("main textarea").attr("readonly", false).css("background", "");
                $.getScript("js/add/article.js");
                $.getScript("js/add/sameAsBillingAdress.js");
                $.getScript("js/add/exchange.js");
                $.getScript("js/add/addName.js");
                $.getScript("js/add/post.js");
                $.getScript("js/add/addAdress.js");
                $.getScript("js/add/uploadFile.js");
                $(this).remove();
            })
        </script>
    <?php else : ?>
        <script src="js/add/article.js"></script>
        <script src="js/add/sameAsBillingAdress.js"></script>
        <script src="js/add/exchange.js"></script>
        <script src="js/add/addAdress.js"></script>
        <script src="js/add/addName.js"></script>
        <script src="js/add/post.js"></script>
        <script src="js/add/uploadFile.js"></script>
    <?php endif ?>
    <?php 
    if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) {
            require_once 'liveData/requestInfo.php';
        } 
        ?>

    <div class="alerts"></div>
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <form class="addNew">
                </form>
            </div>
        </div>
    </div>
    <div class="loading"><i class="fad fa-circle-notch fa-5x"></i><div>
</body>

</html>