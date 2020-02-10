<?php
require_once "../boot.php";
include "storage.php";
if (isset($_GET["token"]) && $_GET["token"] != "") {
    $token = mysqli_real_escape_string($conn, $_GET["token"]);

         //gets password from the username you enterd.
    $result = $engine->provider->fetchRow('SELECT * FROM verify inner join user on user.id=verify.uid WHERE hash = ?', array($token));
    if (!empty($result)) {
        $user_id = $result['uid'];
        if ($result['email_verified'] == 0) {
            $result = $engine->provider->fetchRow('UPDATE user set email_verified=1 WHERE id= ?', array($user_id));
            set_message('success',"User activated successfully.");                    
        } else {
            set_message('danger',"Errro! User already activated");   
        }
    } else {
        set_message('danger',"Errro! User not exists");   
    }
    redirect_page("login.php");
} else {
    redirect_page("login.php");
}

?>
