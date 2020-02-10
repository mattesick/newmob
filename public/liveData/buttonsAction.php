<?php
require_once '../../boot.php';
if (isset($_POST["action"]) && isset($_POST["oid"])) {
    $id = $_POST["oid"];
    switch ($_POST["action"]) {
        case 'remove':
            $engine->provider->executeBatchQuery('UPDATE Request SET state="AVSLUTADE" WHERE id = ' . $id);
            break;
        case 'addOffer':
            $engine->provider->executeQuery('UPDATE Request SET state="OFFERTER" WHERE id = ' . $id);
            break;
        case 'addOrder':
            $engine->provider->executeBatchQuery('UPDATE Request SET state="ORDRAR" WHERE id = ' . $id);
            break;
        default:
            # code...
            break;
    }
}
