<?php
require_once "../../boot.php";
if (isset($_GET["req"])) {
    switch (strtolower($_GET["req"])) {
        case "forfr":
            echo include "../partials/order/request.php";
            break;
        case "offer":
            echo include "../partials/order/offer.php";
            break;
        case "ordra":
            echo include "../partials/order/order-table.php";
            break;
        case "avslu":
            echo include "../partials/order/finished-order.php";
            break;
        case "rekla":
            echo include "../partials/order/complaints.php";
            break;
        default:
            echo include "../partials/order/request.php";
    }
}
