
<script src="../js/add/addAdress.js"></script>
<script>
let data = <?php echo json_encode($engine->provider->fetchRow('SELECT * FROM Request WHERE id = ?', array($_GET["oid"]))); ?>;
let moveInfo = {
    From:<?php echo json_encode($engine->provider->fetchRow('SELECT * FROM MoveInfo WHERE rid = ? AND state = "move-from"', array($_GET["oid"]))); ?>,
    To: <?php echo json_encode($engine->provider->fetchRow('SELECT * FROM MoveInfo WHERE rid = ? AND state = "move-to"', array($_GET["oid"]))); ?>
}

let users = [];
<?php
    $usersData = $engine->provider->fetchResultSet('SELECT firstname,lastname,phone,user.id,personalcode,zipcode,billingadress,billingadressnr,city,billingreference,billingemail,email,RequestConn.uid, RequestConn.rid FROM user LEFT JOIN RequestConn ON user.id=RequestConn.uid WHERE RequestConn.rid = ?', array($_GET["oid"]));
    if ($usersData->rowCount() !== 0) {
        while($usersData->next()){ ?>
            users.push(<?php echo json_encode($usersData->row);?>);
        <?php }
    }
?>

let adressesFrom = [];
<?php
$adresses = $engine->provider->fetchResultSet('SELECT * FROM adress LEFT JOIN adressConn ON adress.id=adressConn.adid WHERE adressConn.rid = ? AND adress.state = "move-from"', array($_GET["oid"]));
if ($adresses->rowCount() !== 0) {
    while($adresses->next()){ ?>
        adressesFrom.push(<?php echo json_encode($adresses->row);?>);
        
    <?php }
}
?>
let adressesTo = [];
<?php
$adresses = $engine->provider->fetchResultSet('SELECT * FROM adress LEFT JOIN adressConn ON adress.id=adressConn.adid WHERE adressConn.rid = ? AND adress.state = "move-to"', array($_GET["oid"]));
if ($adresses->rowCount() !== 0) {
    while($adresses->next()){ ?>
        adressesTo.push(<?php echo json_encode($adresses->row);?>);
        
    <?php }
}
?>

let fromPos = 0;
let toPos = 0;
function showAdresses(adresses){    
    for(let i = 0; i < adresses.length; i++){
    
    if(i >= 1) newAdress(false, adresses[i].state);
    $($(`.${adresses[i].state} .custom-select .select-selected`)[i]).html(adresses[i].typeOfBuilding);
    $($("input[name=bigElevator" + adresses[i].state+"]")[i]).prop("checked", adresses[i].bigElevator == 1);
    $($("input[name=smallElevator" + adresses[i].state+"]")[i]).prop("checked", adresses[i].smallElevator == 1);
    $($("input[name=adress" + adresses[i].state+"]")[i]).val(adresses[i].streetname).parent().attr("id", adresses[i].adid);
    $($(`.${adresses[i].state} .arrows`)[i]).attr("id", adresses[i].id);
    $($("input[name=adressNr" + adresses[i].state+"]")[i]).val(adresses[i].streetNumber);
    $($("input[name=zipcode" + adresses[i].state+"]")[i]).val(adresses[i].zipcode);
    $($("input[name=city" + adresses[i].state+"]")[i]).val(adresses[i].city);
    $($("input[name=living" + adresses[i].state+"]")[i]).val(adresses[i].living);
    $($("input[name=contact" + adresses[i].state+"]")[i]).val(adresses[i].contactPerson);
    $($("input[name=phone" + adresses[i].state+"]")[i]).val(adresses[i].contactPhone);
}
}
showAdresses(adressesFrom)
showAdresses(adressesTo)
$(`[name=source]`).parent().children(".select-selected").html(data.source);
$(`[name=billingReference]`).parent().children(".select-selected").html(data.billingReference);
$(`[name=notes]`).parent().children(".select-selected").html(data.notes);
$("input[name=orderNumber]").val(data.id);
$("input[name=postedDate]").val(data.created.split(" ")[0]);
if($("input[name=dueDate]").val())$("input[name=dueDate]").val(data.dueDate.split(" ")[0]);
$("input[name=dueTime]").val(data.dueTime);
$("input[name=reference]").val(data.reference);
$("input[name=mark]").val(data.marking);
$("input[name=eBilling]").prop("checked", data.eInvoice == 1);
$("input[name=badress]").val(data.billingStreetname);
$("input[name=badressNr]").val(data.billingStreetNumber);
$("input[name=zipcode]").val(data.billingZipcode);
$("input[name=city]").val(data.billingCity);
$("input[name=fepost]").val(data.billingEmail);
$("#free-text").val(data.freeText);
$("#internalNotes").val(data.internalNotes);
let state = "move-from";
let info = "From"
for(let i = 0; i < 2; i++){
$("input[name=floor" + state + "]").val(moveInfo[info].level);
$("input[name=cellar" + state + "]").val(moveInfo[info].cellar);
$("input[name=bigthings" + state + "]").val(moveInfo[info].bigThings);
$("input[name=kindofpacking" + state + "]").val(moveInfo[info].kindOfPacking);
$("input[name=mounting" + state + "]").val(moveInfo[info].mounting);
$("input[name=volume" + state + "]").val(moveInfo[info].volume);
state = "move-to";
info = "To";
}

let logs =[];

<?php
$logs = $engine->provider->fetchResultSet('SELECT html FROM logger LEFT JOIN Request ON logger.rgid=Request.generatedId WHERE Request.id = ?', array($_GET["oid"]));
if ($logs->rowCount() !== 0) {
    while($logs->next()){ ?>
        logs.push(<?php echo json_encode($logs->row);?>);
        
    <?php }
}
?>
logs.forEach(log => {
    $("#all-logs").prepend("<span style=display:block>" + log.html + "</span>");
});

users.forEach((user, index) => {
    if(index > 0) $(".add-person").trigger("click", false);
    $($("input[name=name]")[index]).parent().attr("id", user.uid)
    $($("input[name=name]")[index]).val(user.firstname);
    $($("input[name=lname]")[index]).val(user.lastname);
    $($("input[name=phone]")[index]).val(user.phone);
    $($("input[name=email]")[index]).val(user.email);
    $($("input[name=org]")[index]).val(user.personalcode);
});

</script>   