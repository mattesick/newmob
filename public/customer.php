<?php require_once "../boot.php";
include "rights/auth.php"; 
if(!isset($_GET["uid"]) || !$engine->getUserWithId($_GET["uid"]) || $engine->getRole($_SESSION["uid"]) != "Admin"){
    $engine->redirect("/");
}

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "js/scripts.php";
    include "css/style.php";
    ?>
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/customer.css">
</head>

<body>
    <?php
    include "partials/nav.php";
    ?>
    <main>
        <div class="dashboard">
            <div id="button-navigation">
                <button class="active">INFO</button>
                <button>KONTAKTPERSONER</button>
                <button>AVTAL</button>
                <button>DOKUMENT</button>
                <button>STATISTIK</button>
                <button>INSTÄLLNINGAR</button>
            </div>
            <div class="content">
                <div class="user-table">
                    <div id="button-navigation">
                        <button class="active">ORDRAR</button>
                        <button>OFFERTER</button>
                        <button>MAGASIN</button>
                        <button>FAKTUROR</button>

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
                        $result = $engine->provider->fetchResultSet('SELECT * FROM Request lastUpdated DESC');
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
                                                <button class="addOffer">AVREG. EPOST</button>
                                                <i class="fas fa-arrow-alt-to-bottom"></i>

                                            </div>
                                        <?php endif ?>
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
                    <p><span class="box green"></span> Aktiv</p>
                    <p><span class="box white"></span> Avslutad</p>
                    <p><span class="box notis"></span> Reklamation</p>
                </div>
                <?php 
    
                    $user = $engine->provider->fetchRow("SELECT * FROM user WHERE id = ?", array($_GET["uid"]));
           
                ?>
                <div class="user-info">
                    <div class="head-info">
                        <div><b>NAMN:</b> <?php echo $engine->getName($user["id"]);?></div>
                        <div><b>PERSONNUMMER:</b> <?php echo $user["personalcode"];?></div>
                    </div>
                    <div class="left-over">
                        <div><b>Faktueringsadress:</b> <?php echo $user["billingadress"] . " " . $user["billingadressnr"];?></div>
                        <div><b>Postnummer:</b> <?php echo $user["zipcode"];?></div>
                        <div><b>Ort:</b> <?php echo $user["city"];?></div>
                        <div><b>Tel:</b> <?php echo $user["phone"];?></div>
                        <div><b>Epost:</b> <?php echo $user["email"]; ?></div>
                    </div>
                    <div class="risk">
                        <b>Risk:</b>
                        <span></span>
                    </div>
                    <div class="user-log">
                        <h4>Kundlogg</h4>
                        <div class="log">
                            <p>
                                <b> 2020-01-02 - </b> Skickades till Inkasso
                            </p>
                            <p>
                                <b> 2020-01-01 - </b> Godkänd från Inkasso
                            </p>

                        </div>
                    </div>

                </div>
                <div class="notes">
                    <div class="all-notes">
                        <p><b>13/12 - 2019 - </b> Skrev påminnelse ang. Faktura. <b>- MIKEAL, MK</b></p>
                        <p><b>16/12 - 2019 - </b> Är god man till Karl Karlsson. <b>- PATRIK, MK</b></p>
                    </div>
                    <textarea name="" placeholder="Skriv anteckningar...    " id="" cols="30" rows="10"></textarea>
                </div>
                <div class="remove-customer"><button>TA BORT KUND</button></div>
                <div class="send-email"><button>SKRIV EPOST</button></div>
            </div>

            <!-- ends dashboard div!! -->
        </div>
    </main>
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