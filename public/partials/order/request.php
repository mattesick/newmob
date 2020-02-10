<?php require_once '../../boot.php'; ?>
<div class="dashboard">
    <div id="button-navigation">
        <button class="active">FÖRFRÅGNINGAR</button>
        <button>OFFERTER</button>
        <button>ORDRAR</button>
        <button>AVSLUTADE ORDRAR</button>
        <button>REKLAMATIONER</button>
    </div>
    <table>
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
        $result = $engine->provider->fetchResultSet('SELECT * FROM Request WHERE state = "FÖRFRÅGAN" OR state = "INCOMPLETE" ORDER BY lastUpdated DESC');
        if ($result->rowCount() !== 0) {
            while ($result->next()) : ?>
                <tr <?php if ($result->row["state"] == "INCOMPLETE") echo "class=incomplete" ?>>
                    <td><?php echo $result->row["id"] ?></td>
                    <td><?php echo explode(" ", $result->row["created"])[0] ?></td>
                    <td>Anna Andersson</td>
                    <td><?php echo explode(" ", $result->row["dueDate"])[0] ?></td>
                    <td><?php echo $result->row["dueTime"] ?></td>
                    <td>Flyttpaket 2, Malmö - Arlöv</td>
                    <td>LB</td>
                    <td>4h</td>
                    <td>EKO</td>
                    <td>
                        <?php if ($result->row["state"] == "FÖRFRÅGAN") : ?>
                            <div class="order-table-buttons">
                                <button class="addOffer">SKAPA OFFERT</button>
                                <button class="addOrder">SKAPA ORDER</button>
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