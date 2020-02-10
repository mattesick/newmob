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
    <link rel="stylesheet" href="css/order.css">
    <script src="js/orders/buttonPost.js" defer></script>
    <script src="js/orders/buttons.js" defer></script>
    
</head>

<body>
    <?php
    include "partials/nav.php";
    ?>
    <main>

    </main>
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <form class="addNew">
                </form>
            </div>
        </div>
    </div>
    <div class="loading"><i class="fad fa-circle-notch fa-5x"></i><div>
    

<div class="alerts"></div>
</body>

</html>