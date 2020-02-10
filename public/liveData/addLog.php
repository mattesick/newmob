<?php
require_once '../../boot.php';
if(isset($_POST["string"]) && isset($_POST["rid"])){   
    $engine->addLog($_POST["rid"],$_POST["string"]);
}
