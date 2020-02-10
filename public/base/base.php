<?php
class ModelBase extends Functions
{
    public $systemConfig;
    public $provider;
    function __construct()
    {
        $this->appConfig            = $GLOBALS['systemConfig'];
        $this->provider             = new DatabaseProvider();
        $this->provider->properties = $this->appConfig['db'];
    }
}


?>