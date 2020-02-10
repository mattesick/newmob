<?php
require_once '../../boot.php';
if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case 'getLastId':
            echo $engine->provider->lastInsertId();
            break;
        case 'removeFile':
            if (isset($_POST["path"])) {
                echo unlink(".." . DIRECTORY_SEPARATOR . $_POST["path"]);
            }
            break;
        case 'draggedRequestDate':
            if (isset($_POST["id"]) && isset($_POST["date"])) {
                $dueDate = explode("T",$_POST["date"])[0] . " " . "00:00:00";
                $engine->provider->executeQuery('UPDATE Request SET dueDate = ? WHERE id = ?', array($dueDate,  $_POST["id"]));
            }
            break;
        case 'draggedRequestTime':
            if (isset($_POST["id"]) && isset($_POST["date"])) {
                $dueTime = substr(explode("T",$_POST["date"])[1], 0, 5);
                $engine->provider->executeQuery('UPDATE Request SET dueTime = ? WHERE id = ?', array($dueTime, $_POST["id"]));
            }
            break;
        default:
            # code...
            break;
    }
}
