<?php
class Engine extends ModelBase
{
    function __construct()
    {
        parent::__construct();
    }
    public function getUserWithId($id)
    {
        return $result = $this->provider->fetchRow('SELECT * FROM user WHERE ID = ?', array($id));
    }
    public function getUserWithEmail($email)
    {
        return $this->provider->fetchRow('SELECT * FROM user WHERE email = ? AND role != "passive"', array($email));
    }
    public function getName($id)
    {
        $result = $this->provider->fetchRow('SELECT firstName, lastName FROM user WHERE ID = ?', array($id));
        return strtoupper($result["firstName"] . " " . $result["lastName"]);
    }
    public function getRole($id)
    {
        return $this->provider->fetchRow('SELECT role FROM user WHERE ID = ?', array($id))["role"];
    }
    public function addDropDownItem($title, $itemTitle)
    {
        $this->provider->executeQuery('INSERT INTO dropdownItem (title, itemTitle) VALUES(?, ?)', array($title, $itemTitle));
    }
    public function getDropDownItems($title)
    {
        return $this->provider->fetchResultSet('SELECT itemTitle FROM dropdownItem WHERE title = ?', array($title));
    }
    public function logout($secure = true)
    {
        unset($_SESSION['uid']);
        if ($secure) {
            $this->redirect($this->generateUrl("login.php"));
        }
    }
    public function addRequest($state, $post)
    {
        ChromePhp::log($post);
        $dueDate = $post["dueDate"] != "" ? $post["dueDate"] : NULL;
        $dueTime = $post["dueTime"] != "" ? $post["dueTime"] : NULL;
        $source = $post["source"] ? $post["source"] : "Ingen";
        $mark = $post["mark"];
        $reference = $post["reference"];
        if (isset($post["eBilling"])) $eBilling = 1;
        else $eBilling = 0;
        $billingStreetname = $post["badress"];
        $billingStreetNumber = $post["badressNr"];
        $billingZipcode = (int) $post["zipcode"];
        $billingCity = $post["city"];
        $billingEmail = $post["fepost"];
        $billingReference = $post["billingReference"] ? $post["billingReference"] : "Ingen";
        $freeText = $post["freeText"];
        $notes = $post["notes"] ? $post["notes"] : "Ingen";
        $internalNotes = $post["internalNotes"];
        $generatedId = $post["generatedId"];
        $this->provider->executeQuery('INSERT INTO Request (dueDate, dueTime, source, marking, reference, eInvoice, billingStreetname, billingStreetNumber, billingZipcode, billingCity, billingEmail, billingReference, notes, freeText, internalNotes, state, generatedId) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($dueDate, $dueTime, $source, $mark, $reference, $eBilling, $billingStreetname, $billingStreetNumber, $billingZipcode, $billingCity, $billingEmail, $billingReference, $notes, $freeText, $internalNotes, $state, $generatedId));
        // ChromePhp::log($result, $dueDate, $dueTime, $source, $mark, $reference, $eBilling, $billingStreetname, $billingStreetNumber, $billingZipcode, $billingCity, $billingEmail, $billingReference, $freeText, $internalNotes, $notes, $state);
        $rid = $this->provider->lastInsertId();
        $this->loopAdresses($post, $rid, "move-from");
        $this->loopAdresses($post, $rid, "move-to");
        $this->loopPersons($post, $rid);
        $state = "move-from";
        for ($i = 0; $i < 2; $i++) {
            $level = (int) $post["floor" . $state];
            $cellar = $post["cellar" . $state];
            $bigThings = $post["bigthings" . $state];
            $kindOfpacking = $post["kindofpacking" . $state];
            $mounting = $post["mounting" . $state];
            $volume = $post["volume" . $state];
            $this->addMoveInfo($state, $level, $cellar, $bigThings, $kindOfpacking, $mounting, $volume, $rid);
            $state = "move-to";
        }
    }
    private function loopAdresses($post, $rid, $side){
        $i = 0;
        
        if(!isset($post["adress$side"])) {
            while (isset($post["adress$side" . $i])) {
                ChromePhp::log("adress$side" . $i);
                if (isset($post["bigElevator$side" . $i])) $post["bigElevator$side" . $i] = 1;
                else $post["bigElevator$side" . $i] = 0;
                if (isset($post["smallElevator$side" . $i])) $post["smallElevator$side" . $i] = 1;
                else $post["smallElevator$side" . $i] = 0;
                $post["typeofliving$side" . $i] = $post["typeofliving$side" . $i] ? $post["typeofliving$side" . $i] : "Typ av boende...";
                $this->addAdress($post["adress$side" . $i], $post["adressNr$side" . $i], $post["zipcode$side" . $i], $post["city$side" . $i], $post["living$side" . $i], $post["contact$side" . $i], $post["phone$side" . $i], $i, $post["bigElevator$side" . $i], $post["smallElevator$side" . $i], "$side", $post["typeofliving$side" . $i], $rid);
                $i++;
            }
        } else{
            if (isset($post["bigElevator$side"])) $post["bigElevator$side"] = 1;
            else $post["bigElevator$side"] = 0;
            if (isset($post["smallElevator$side"])) $post["smallElevator$side"] = 1;
            else $post["smallElevator$side"] = 0;
            $post["typeofliving$side"] = $post["typeofliving$side"] ? $post["typeofliving$side"] : "Typ av boende...";
            $this->addAdress($post["adress$side"], $post["adressNr$side"], $post["zipcode$side"], $post["city$side"], $post["living$side"], $post["contact$side"], $post["phone$side"], $i, $post["bigElevator$side"], $post["smallElevator$side"], "$side", $post["typeofliving$side"], $rid);
        }

    }
    private function loopPersons($post, $rid, $update = false)
    {
        $i = 0;
        if ($update) {
            $allUserConns = $this->provider->fetchResultSet("SELECT * FROM RequestConn WHERE rid = ?", array($rid));
            $conns = array();
            if ($allUserConns->rowCount() !== 0) {
                while ($allUserConns->next()) {
                    array_push($conns, $allUserConns->row);
                }
            }
            ChromePhp::log($conns, $post, $rid);
        }

        while (isset($post["person" . $i])) {
            if($update && $conns[$i]["uid"] && $conns[$i]["uid"] != $post["person" . $i] ){
                $this->provider->executeQuery("UPDATE RequestConn SET uid = ? WHERE rid = ? AND id = ?", array($post["person" . $i], $rid, $conns[$i]["id"]));
            }else{
                $userConn = $this->provider->fetchRow("SELECT id FROM RequestConn WHERE uid = ? AND rid = ?", array($post["person" . $i], $rid));
                if (!$update || !$userConn) {
                    $this->provider->executeQuery("INSERT INTO RequestConn (rid, uid) VALUES (?, ?)", array($rid, $post["person" . $i]));
                }
            }

            $i++;
        }
        while(isset($conns[$i])){
            $this->provider->executeQuery("DELETE FROM RequestConn WHERE id = ?", array($conns[$i]["id"]));
            $i++;
        }
    }
    public function addAdress($streetName, $streetNumber, $zipcode, $city, $living, $contactPerson, $contactPhone, $position, $bigElevator, $smallElevator, $state, $typeOfBuilding, $id)
    {
        $this->provider->executeQuery('INSERT INTO adress (streetName, streetNumber, zipcode, city, living, contactPerson, contactPhone, position, bigElevator, smallElevator, state, typeOfBuilding) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($streetName, $streetNumber, (int) $zipcode, $city, $living, $contactPerson, $contactPhone, $position, $bigElevator, $smallElevator, $state, $typeOfBuilding));
        $rid = $this->provider->lastInsertId();
        $this->provider->executeQuery('INSERT INTO adressConn (adid, rid) VALUES (?, ?)', array($rid, $id));
    }
    private function updateAdress($streetName, $streetNumber, $zipcode, $city, $living, $contactPerson, $contactPhone, $position, $bigElevator, $smallElevator, $state, $typeOfBuilding, $id)
    {
        $this->provider->executeQuery("UPDATE adress SET streetName =?,  streetNumber = ?,  zipcode = ?,  city = ?,  living = ?,  contactPerson = ?,  contactPhone = ?,  position = ?,  bigElevator = ?,  smallElevator = ?,  state = ?,  typeOfBuilding = ? WHERE id = ?", array($streetName, $streetNumber, $zipcode, $city, $living, $contactPerson, $contactPhone, $position, $bigElevator, $smallElevator, $state, $typeOfBuilding, $id));
    }
    private function loopUpdateAdresses($post, $side){
        $i = 0;
        $adresses = array();
        $allAdresses = $this->provider->fetchResultSet("SELECT * FROM adress LEFT JOIN adressConn on adress.id=adressConn.adid WHERE adressConn.rid = ? AND adress.state = ?", array($post["orderNumber"], $side));
        if ($allAdresses->rowCount() !== 0) {
            while ($allAdresses->next()) {
                array_push($adresses, $allAdresses->row);
            }
        }

        if (!isset($post["adress$side"])) {

            while (isset($post["adress$side" . $i])) {
                if (isset($post["bigElevator$side" . $i])) $post["bigElevator$side" . $i] = 1;
                else $post["bigElevator$side" . $i] = 0;
                if (isset($post["smallElevator$side" . $i])) $post["smallElevator$side" . $i] = 1;
                else $post["smallElevator$side" . $i] = 0;
                $post["typeofliving$side" . $i] = $post["typeofliving$side" . $i] ? $post["typeofliving$side" . $i] : "Typ av boende...";
                if($post["adressid$side" . $i] != "undefined"){
                    $this->updateAdress($post["adress$side" . $i], $post["adressNr$side" . $i], $post["zipcode$side" . $i], $post["city$side" . $i], $post["living$side" . $i], $post["contact$side" . $i], $post["phone$side" . $i], $i, $post["bigElevator$side" . $i], $post["smallElevator$side" . $i], $side, $post["typeofliving$side" . $i], $post["adressid$side" . $i]);

                } else{
                    $this->addAdress($post["adress$side" . $i], $post["adressNr$side" . $i], $post["zipcode$side" . $i], $post["city$side" . $i], $post["living$side" . $i], $post["contact$side" . $i], $post["phone$side" . $i], $i, $post["bigElevator$side" . $i], $post["smallElevator$side" . $i], "$side", $post["typeofliving$side" . $i], $post["orderNumber"]);
                }
                $i++;

            }
        } else {
            if (isset($post["bigElevator$side"])) $post["bigElevator$side"] = 1;
            else $post["bigElevator$side"] = 0;
            if (isset($post["smallElevator$side"])) $post["smallElevator$side"] = 1;
            else $post["smallElevator$side"] = 0;
            $post["typeofliving$side"] = $post["typeofliving$side"] ? $post["typeofliving$side"] : "Typ av boende...";
            $this->updateAdress($post["adress$side"], $post["adressNr$side"], $post["zipcode$side"], $post["city$side"], $post["living$side"], $post["contact$side"], $post["phone$side"], $i, $post["bigElevator$side"], $post["smallElevator$side"], $side, $post["typeofliving$side"], $post["adressid$side" . $i]);
        }
        for ($i=1; $i < count($adresses); $i++) { 
            if(!isset($post["adressid$side" . $i])){
                $this->provider->executeQuery("DELETE FROM adress WHERE id = ?", array($adresses[$i]["adid"]));
                $this->provider->executeQuery("DELETE FROM adressConn WHERE id = ?", array($adresses[$i]["id"]));
            }
        }
    }
    public function addMoveInfo($state, $level, $cellar, $bigThings, $kindOfpacking, $mounting, $volume, $rid)
    {
        $this->provider->executeQuery('INSERT INTO MoveInfo (state, level, cellar, bigThings, kindOfPacking, mounting, volume, rid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array($state, $level, $cellar, $bigThings, $kindOfpacking, $mounting, $volume, $rid));
    }
    public function getGeneratedId($id){
        return $this->provider->fetchRow('SELECT generatedId FROM Request WHERE id = ?', array($id))["generatedId"];
    }

    public function getRequestId($id)
    {
        return $this->provider->fetchRow('SELECT id FROM Request WHERE id = ?', array($id))["id"];
    }

    public function addLog($rid, $html)
    {
        if (strlen($rid) < 32) {
            $rid = $this->getGeneratedId($rid);
        }
        $this->provider->executeQuery('INSERT INTO logger (rgid, html) VALUES (?, ?)', array($rid, $html));
    }
    public function updateRequest($post, $state)
    {
        $id = (int)$post["orderNumber"];
        $dueDate = $post["dueDate"] != "" ? $post["dueDate"] : NULL;
        $dueTime = $post["dueTime"] != "" ? $post["dueTime"] : NULL;
        $source = $post["source"] ? $post["source"] : "Ingen";
        $mark = $post["mark"];
        $reference = $post["reference"];
        if (isset($post["eBilling"])) $eBilling = 1;
        else $eBilling = NULL;
        $billingStreetname = $post["badress"];
        $billingStreetNumber = $post["badressNr"];
        $billingZipcode = (int) $post["zipcode"];
        $billingCity = $post["city"];
        $billingEmail = $post["fepost"];
        $billingReference = $post["billingReference"] ? $post["billingReference"] : "Ingen";
        $freeText = $post["freeText"];
        $notes = $post["notes"] ? $post["notes"] : "Ingen";
        $internalNotes = $post["internalNotes"];
        $generatedId = $post["generatedId"];
        ChromePhp::log("post:", $post);
        ChromePhp::log("vars:", array($dueDate, $dueTime, $source, $mark, $reference, $eBilling, $billingStreetname, $billingStreetNumber, $billingZipcode, $billingCity, $billingEmail, $billingReference, $notes, $freeText, $internalNotes, $state, $generatedId));
        $this->provider->executeQuery("UPDATE Request SET dueDate = ?,  dueTime = ?,  source = ?,  marking = ?,  reference = ?,  eInvoice = ?,  billingStreetname = ?,  billingStreetNumber = ?,  billingZipcode = ?,  billingCity = ?,  billingEmail = ?,  billingReference = ?,  notes = ?,  freeText = ?,  internalNotes = ?,  state = ?,  generatedId = ? WHERE id = ?", array($dueDate, $dueTime, $source, $mark, $reference, $eBilling, $billingStreetname, $billingStreetNumber, $billingZipcode, $billingCity, $billingEmail, $billingReference, $notes, $freeText, $internalNotes, $state, $generatedId, $id));
        $this->loopUpdateAdresses($post, "move-to");
        $this->loopUpdateAdresses($post, "move-from");
        $this->loopPersons($post, $id, true);
        ChromePhp::log("error:", $this->provider->conn->errorInfo());
    }
}
