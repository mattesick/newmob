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
        case 'getUser':
            if(isset($_POST["userId"])){
                echo json_encode($engine->provider->fetchRow('SELECT * FROM user WHERE id = ?', array($_POST["userId"])));
            }
            break;
        case 'newResults':
            if(isset($_POST["state"]) && isset($_POST["currentLimit"])){
                $newResults = array();
                $users = array();
                $newLimit = $_POST["currentLimit"] + 15;
                if($_POST["state"] == "FÖRFRÅGAN") $result = $engine->provider->fetchResultSet('SELECT * FROM Request WHERE state = ? OR state = ? ORDER BY lastUpdated DESC LIMIT ' . (int)$_POST["currentLimit"] . "," . $newLimit , array($_POST["state"], "INCOMPLETE"));
                else $result = $engine->provider->fetchResultSet('SELECT * FROM Request WHERE state = ? ORDER BY lastUpdated DESC LIMIT ' . (int)$_POST["currentLimit"] . "," . $newLimit , array($_POST["state"]));
                if($result->rowCount() !== 0){
                    while($result->next()){
                        $user = $engine->provider->fetchRow("SELECT * FROM user LEFT JOIN RequestConn ON user.id=RequestConn.uid LEFT JOIN Request ON RequestConn.rid=Request.id WHERE Request.id = ?", array($result->row["id"]));
                        array_push($users, $user);
                        array_push($newResults, $result->row);
                    }
                }
                echo json_encode([$newResults, $users]);

            }
            break;
        default:
            # code...
            break;
    }
}
