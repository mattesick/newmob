<?php require_once "../boot.php"; include "rights/auth.php";?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "js/scripts.php";
        include "css/style.php";
    ?>
</head>
<body>
<?php
include "partials/nav.php";
?>
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