<?php require_once '../../boot.php'; ?>
<div id="results" class="dashboard">
    <div id="button-navigation">
        <button class="active">FÖRFRÅGNINGAR</button>
        <button>OFFERTER</button>
        <button>ORDRAR</button>
        <button>AVSLUTADE ORDRAR</button>
        <button>REKLAMATIONER</button>
    </div>
    <table >
        <tr>
            <th>NR:</th>
            <th>SKAPAD</th>
            <th>KUND:</th>
            <th>UTFÖRAS:</th>
            <th>TID:</th>
            <th>ARTIKEL:</th>
            <th>FORDON:</th>
            <th>TIMMAR:</th>
            <th>LEVERANTÖR:</th>
            <th></th>
        </tr>
        <?php
        $result = $engine->provider->fetchResultSet('SELECT * FROM Request WHERE state = "FÖRFRÅGAN" OR state = "INCOMPLETE"  ORDER BY lastupdated DESC LIMIT 25');
        if ($result->rowCount() !== 0) {
            while ($result->next()) : ?>
            <?php $user = $engine->provider->fetchRow("SELECT * FROM user LEFT JOIN RequestConn ON user.id=RequestConn.uid LEFT JOIN Request ON RequestConn.rid=Request.id WHERE Request.id = ?", array($result->row["id"]));

            ?>
                <tr <?php if ($result->row["state"] == "INCOMPLETE") echo "class=incomplete" ?>>
                    <td><a href="add.php?oid=<?php echo $result->row["id"]?>"><?php echo $result->row["id"] ?></a></td>
                    <td><?php echo $result->row["created"] ?></td>
                    <td><a href="customer.php?uid=<?php echo $user["uid"]?>"><?php echo $user["firstname"] . " " . $user["lastname"];?></a></td>
                    <td><?php echo explode(" ", $result->row["dueDate"])[0] ?></td>
                    <td><?php echo $result->row["dueTime"] ?></td>
                    <td>Flyttpaket 2, Malmö - Arlöv</td>
                    <td>LB</td>
                    <td>4h</td>
                    <td>EKO</td>
                    <td>
                        <?php if ($result->row["state"] == "FÖRFRÅGAN") : ?>
                            <div class="order-table-buttons">
                                <i class="fas fa-arrow-alt-to-bottom"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        <?php else : ?>
                            <div class="order-table-buttons">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-arrow-alt-to-bottom"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
        <?php endwhile;
        }

        ?>
    </table>

    <!-- ends dashboard div!! -->
</div>
<div class="color-index">
    <h5>Färgindex:</h5>
    <p><span class="box red"></span> Ofullständing</p>
    <p><span class="box white"></span> Fullständing</p>
</div>
<script src="js/orders/newResults.js"></script>