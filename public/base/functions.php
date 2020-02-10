<?php
class Functions
{

    public function clientIp()
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        return null;
    }
    public function generateUrl($path = '', $home = 0)
    {
        $protocol = 'http';
        if($home == 1){
            return $protocol."://" . $_SERVER['HTTP_HOST'] . "/$path";
        }
        return $GLOBALS['systemConfig']['system']['base_url'] . $path;
    }
    public function redirect($url)
    {
        header("Location: " . $url);
        die();
    }
    public function makeId()
    {
        $id = "";
        $alf = "abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ123467890";
        for ($i = 0; $i < 16; $i++) {
            $id .= $alf[rand(0, strlen($alf) - 1)];
        }
        return $id;
    }

    
}

function redirect_page($url) {
    header("Location: " . $url);
    die();
}

function set_message($type='',$msg='') {
    if ($type !='' && $msg !='') {
        $type = strtolower($type);
        if ($type == "success" || $type == "danger" || $type == "info" || $type == "warning") {
            $_SESSION[$type]=$msg;
        }       
    }
}

function show_messsage($type = '',$flag = false){   
    if ($type == "success" || $type == "danger" || $type == "info" || $type == "warning") {
        if(isset($_SESSION[$type])) {
            if($flag == true) {
                echo $_SESSION[$type];  
            } else {
                echo "<div class='alert alert-".$type." cstm-msg-all'>".$_SESSION[$type]."</div>"; 
            }           
            unset($_SESSION[$type]);
        }
    }
}

function pr($content) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}

function po($data = '') {
    echo "<pre>";
    if ($data == '') {
        print_r($_POST);
    } else {
        print_r($data);
    }
    echo "</pre>";
    die();
}
