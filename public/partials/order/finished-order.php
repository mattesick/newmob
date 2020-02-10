<?php require_once '../../boot.php'; ?>
<div class="dashboard">
    <div id="button-navigation">
        <button>FÖRFRÅGNINGAR</button>
        <button>OFFERTER</button>
        <button>ORDRAR</button>
        <button class="active">AVSLUTADE ORDRAR</button>
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
        $result = $engine->provider->fetchResultSet('SELECT * FROM Request WHERE state = "AVSLUTADE" ORDER BY lastUpdated DESC');
        if ($result->rowCount() !== 0) {
            while ($result->next()) : ?>
                <tr>
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
                        <div class="order-table-buttons">
                            <button>HANTERA</button>
                            <i class="fas fa-trash"></i>
                        </div>
                    </td>
                </tr>
        <?php endwhile;
        }

        ?>
        <tr>
            <td>92012</td>
            <td>16/12 - 2019</td>
            <td>Anna Andersson</td>
            <td>16/12 - 2019</td>
            <td>08:00</td>
            <td>Flyttpaket 2, Malmö - Arlöv</td>
            <td>LB</td>
            <td>4h</td>
            <td>EKO</td>
            <td>
                <div class="order-table-buttons">
                    <button>HANTERA</button>
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td>92012</td>
            <td>16/12 - 2019</td>
            <td>Anna Andersson</td>
            <td>16/12 - 2019</td>
            <td>08:00</td>
            <td>Flyttpaket 2, Malmö - Arlöv</td>
            <td>LB</td>
            <td>4h</td>
            <td>EKO</td>
            <td>
                <div class="order-table-buttons">
                    <button>HANTERA</button>
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td>92012</td>
            <td>16/12 - 2019</td>
            <td>Anna Andersson</td>
            <td>16/12 - 2019</td>
            <td>08:00</td>
            <td>Flyttpaket 2, Malmö - Arlöv</td>
            <td>LB</td>
            <td>4h</td>
            <td>EKO</td>
            <td>
                <div class="order-table-buttons">
                    <button>HANTERA</button>
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td>92012</td>
            <td>16/12 - 2019</td>
            <td>Anna Andersson</td>
            <td>16/12 - 2019</td>
            <td>08:00</td>
            <td>Flyttpaket 2, Malmö - Arlöv</td>
            <td>LB</td>
            <td>4h</td>
            <td>EKO</td>
            <td>
                <div class="order-table-buttons">
                    <button>HANTERA</button>
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td>92012</td>
            <td>16/12 - 2019</td>
            <td>Anna Andersson</td>
            <td>16/12 - 2019</td>
            <td>08:00</td>
            <td>Flyttpaket 2, Malmö - Arlöv</td>
            <td>LB</td>
            <td>4h</td>
            <td>EKO</td>
            <td>
                <div class="order-table-buttons">
                    <button>HANTERA</button>
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        </tr>

    </table>
    <!-- ends dashboard div!! -->
</div>