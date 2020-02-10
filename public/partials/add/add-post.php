<?php
include_once "../../../boot.php";
include_once "../../ChromePhp.php";
if(isset($_POST)){
    $action = "";
    if($_POST["action"] == "addRequest") $action = "FÖRFRÅGAN";
    elseif($_POST["action"] == "addOffer") $action = "OFFERTER";
    elseif($_POST["action"] == "addIncomplete") $action = "INCOMPLETE";
    elseif($_POST["action"] == "addOrder") $action = "ORDRAR";
    if(!isset($_POST["orderNumber"])) $engine->addRequest($action, $_POST);
    else $engine->updateRequest($_POST, $action);
}
