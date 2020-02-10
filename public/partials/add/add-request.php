<?php
function showDropdownItems($title)
{

    $items = $GLOBALS["engine"]->getDropDownItems($title);
    if ($items->rowCount() !== 0) {
        while ($items->next()) {
            $itemTitle = $items->row["itemTitle"];
            // <!-- Shows all users and will be giving the option to delete the user since there is only admins allowed here.-->
            ?>

            <option value="<?php echo $itemTitle ?>"><?php echo $itemTitle ?></option>
            <?php
        }
    }
}
function showInput($type, $name, $placeholder, $id = "", $label = true, $data = false, $readonly = false)
{

    if (isset($id) || $id == "") {
        $id = $GLOBALS["engine"]->makeId();
    }
    if ($label && $data && !$readonly) {
        $options = ``;
        $users = $GLOBALS["engine"]->provider->fetchResultSet('SELECT id FROM user');
        if ($users->rowCount() !== 0) {
            while ($users->next()) {
                $userId = $users->row["id"];
                $userName = $GLOBALS["engine"]->getName($userId);
                $options .= "<option value='$userName - $userId'>";
            }
        }
        echo "
        <div>
        <input type='$type' list='New$id'id='$id' placeholder=' ' name='" . $name . "'>
        <label for='$id'>$placeholder</label>
        <datalist class='userChoice'id='New$id'>
        $options
        </datalist>
        </div>
        ";
    } else if ($label && !$readonly) {
        echo "
        <div>
        <input type='$type' id='$id' placeholder=' ' name='" . $name . "'>
        <label for='$id'>$placeholder</label>
        </div>
        ";
    } else if (!$readonly) {
        echo "
        <input type='$type' id='$id' placeholder='$placeholder'name='" . $name . "'>
        ";
    } else if ($label && $readonly) {
        echo "
        <div>
        <input type='$type' id='$id' placeholder=' ' name='" . $name . "' readonly>
        <label for='$id'>$placeholder</label>
        </div>
        ";
    } else {
        echo "
        <input type='$type' id='$id' placeholder='$placeholder name='" . $name . "' readonly>
        ";
    }
}
?>
<div>

    <form action="partials/add/add-post.php" class="dashboard" name="request" id="requestForm" method="post">
        <div class="order-info">
            <?php
            //Make sure this one checks if the order exists! NOT DONE!!
            if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) : ?>
                <div>
                    <input type="text" placeholder=" " name="orderNumber" id="ordernr" value="" readonly>
                    <label for="ordernr">Order nummer...</label>
                </div>

            <?php endif;
            ?>
            <div>
                <input type="date" id="postedDate" name="postedDate" value="<?php echo date("Y-m-d"); ?>" readonly>
                <label for="postedDate">Skapad:</label>
            </div>

            <?php
            showInput("date", "dueDate", "När...");
            showInput("time", "dueTime", "Vilken tid...");
            ?>
            <div class="custom-select select-half">
                <select name="source">
                    <option value="0">Källa...</option>
                    <?php showDropdownItems("Källa") ?>
                </select>
            </div>
            <?php
            showInput("text", "reference", "Vår referens...");
            showInput("text", "mark", "Märkning...");

            ?>

            <div class="checkbox">
                <input type="checkbox" name="eBilling">
                <p>Efaktura</p>
            </div>
        </div>
        <div class="customer-info">
            <?php
            showInput("text", "name", "Företagsnamn/Förnamn...", "", true, true);
            showInput("text", "lname", "Efternamn...");
            showInput("tel", "phone", "Tel...");
            showInput("email", "email", "Epost...");
            showInput("text", "org", "Org./Personnummer...");
            ?>

            <div class="add-person-button">
                <p class="shared-RUT"><i class="fas fa-plus-circle"></i>Delad RUT</p>
            </div>
            <div class="add-person-button">
                <p class="add-person"><i class="fas fa-plus-circle"></i> Lägg till ny person</p>
            </div>
            <div></div>
            <div>
                <div>
                    <input style="width:75%;" type="text" placeholder=" " name="badress" id="badress">
                    <label for="badress">Faktueringsadress...</label>
                </div>
                <input style="width:25%;" type="number" placeholder="Nr..." name="badressNr" id="badressNr">
            </div>
            <?php
            showInput("number", "zipcode", "Postnummer...");
            showInput("text", "city", "Ort...");
            showInput("email", "fepost", "Faktuerings-Epost...");
            ?>

            <div class="custom-select select-half">
                <select name="billingReference">
                    <option value="0">Referens...</option>
                    <?php showDropdownItems("Referens") ?>
                </select>
            </div>

        </div>

        <div class="move-from">
            <div>
                <h2>Flytt FRÅN:</h2>
            </div>
            <div>
                <button class="btn sameAsBillingAdress">SAMMA SOM FAKTUERINGSADRESS</button>
                <button class="btn"><i class="fas fa-map"></i> VÄGBESKRIVNING</button>
            </div>
            <div id="boende-example" class="custom-select">
                <select name="typeoflivingmove-from">
                    <option value="0">Typ av boende...</option>
                    <?php showDropdownItems("Typ av boende") ?>
                </select>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="bigElevatormove-from">
                <p>Stor hiss</p>
                <input type="checkbox" name="smallElevatormove-from">
                <p>Liten hiss</p>
            </div>
            <div>
                <div>
                    <input style="width:75%;" class="address-list-move-from" type="text" placeholder=" " name="adressmove-from" id="txtfromautocomplete">
                    <label for="dsad2aasd2a">Adress...</label>
                </div>
                <input style="width:25%;" type="number" placeholder="Nr..." name="adressNrmove-from">
            </div>
            <?php
            showInput("text", "zipcodemove-from", "Postnummer...");
            showInput("text", "citymove-from", "Ort...");
            showInput("text", "livingmove-from", "Bostadsyta...");
            showInput("text", "contactmove-from", "Kontaktperson...");
            showInput("tel", "phonemove-from", "Telnummer...");
            ?>

            <div class="removeable">
                <a style="text-decoration:none;" href="JavaScript:void(0)">
                    <p class="add-adress"><i class="fas fa-plus-circle"></i>Lägg till adress</p>
                </a>
            </div>
            <div class="arrows insertAftermove-from">
                <i class="fas fa-exchange"></i>
            </div>
            <?php
            showInput("text", "floormove-from", "Vån...");
            showInput("text", "cellarmove-from", "Vind/Källare/Garage...");
            showInput("text", "bigthingsmove-from", "Kristallkrona/Piano/Extrema...");
            showInput("text", "kindofpackingmove-from", "Packning/Delpackning/Uppackning...");
            showInput("tel", "mountingmove-from", "Montering/Demontoering...");
            showInput("tel", "volumemove-from", "Kartonger/Volym/Besiktning...");
            ?>
        </div>
        <div class="move-to">
            <div>
                <h2>Flytt TILL:</h2>
            </div>
            <div>
                <button class="btn sameAsBillingAdress">SAMMA SOM FAKTUERINGSADRESS</button>
                <button class="btn"><i class="fas fa-map"></i> VÄGBESKRIVNING</button>
            </div>
            <div class="custom-select">
                <select name="typeoflivingmove-to">
                    <option value="0">Typ av boende...</option>
                    <?php showDropdownItems("Typ av boende") ?>
                </select>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="bigElevatormove-to">
                <p>Stor hiss</p>
                <input type="checkbox" name="smallElevatormove-to">
                <p>Liten hiss</p>
            </div>

            <div>
                <div>
                    <input style="width:75%;" type="text" placeholder=" " name="adressmove-to" class="address-list-move-to" id="txttoautocomplete">
                    <label for="dsad2aasd2af">Adress...</label>
                </div>
                <input style="width:25%;" type="number" placeholder="Nr..." name="adressNrmove-to">
            </div>
            <?php
            showInput("text", "zipcodemove-to", "Postnummer...");
            showInput("text", "citymove-to", "Ort...");
            showInput("text", "livingmove-to", "Bostadsyta...");
            showInput("text", "contactmove-to", "Kontaktperson...");
            showInput("tel", "phonemove-to", "Telnummer...");
            ?>
            <div class="removeable">
                <a style="text-decoration:none;" href="JavaScript:void(0)">
                    <p class="add-adress"><i class="fas fa-plus-circle"></i>Lägg till adress</p>
                </a>
            </div>

            <div class="arrows insertAftermove-to">
                <i class="fas fa-exchange"></i>
            </div>
            <?php
            showInput("text", "floormove-to", "Vån...");
            showInput("text", "cellarmove-to", "Vind/Källare/Garage...");
            showInput("text", "bigthingsmove-to", "Kristallkrona/Piano/Extrema...");
            showInput("text", "kindofpackingmove-to", "Packning/Delpackning/Uppackning...");
            showInput("tel", "mountingmove-to", "Montering/Demontoering...");
            showInput("tel", "volumemove-to", "Kartonger/Volym/Besiktning...");
            ?>
        </div>
        <div class="text">
            <div>
                <div id="change-move">
                    <i id="exchange" class="fas fa-exchange fa-4x"></i>
                </div>
                <div>
                    <textarea name="freeText" id="free-text" rows="5" cols="25" placeholder=" "></textarea>
                    <label for="free-text">Fritext...</label>
                </div>
                <div id="note" class="custom-select">
                    <select name="notes">
                        <option value="0">Anteckningar...</option>
                        <?php showDropdownItems("Anteckning") ?>
                    </select>
                </div>
            </div>

        </div>
    </form>
</div>
<div id="map" style="height: 500px;width: 100%;border:1px #000 solid"></div>
<div id="directions-panel" style="background-color: white;padding: 10px;margin-bottom: 20px;">

</div>

