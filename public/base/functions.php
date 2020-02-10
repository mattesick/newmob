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
