<?php

Namespace Model;

class ApacheFastCGIModulesUbuntu extends BaseLinuxApp {

    // Compatibility
    public $os = array("Linux") ;
    public $linuxType = array("Debian") ;
    public $distros = array("Ubuntu") ;
    public $versions = array(array("13.99", "-")) ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
        $this->installCommands = array(
            array("method"=> array("object" => $this, "method" => "addSources", "params" => array()) ),
            // @todo we should probably use the packagemanager for this
            array("command" => array( "apt-get update -y", ) ),
            array("method"=> array("object" => $this, "method" => "packageAdd", "params" => array("Apt", "libapache2-mod-fastcgi")) ),
            array("command" => array(
                "a2enmod actions",
                "a2enmod fastcgi",
                "a2enmod alias",
//                "a2enconf php5-fpm",
            ) ),
            array("method"=> array("object" => $this, "method" => "apacheReload", "params" => array())) );
        $this->uninstallCommands = array(
            array("method"=> array("object" => $this, "method" => "packageRemove", "params" => array("Apt", "libapache2-mod-fastcgi")) ),
            array("method"=> array("object" => $this, "method" => "apacheReload", "params" => array()))
        );
        $this->programDataFolder = "/opt/ApacheFastCGIModules"; // command and app dir name
        $this->programNameMachine = "apachefastcgimodules"; // command and app dir name
        $this->programNameFriendly = "Apache Fast CGI Mods!"; // 12 chars
        $this->programNameInstaller = "Apache Fast CGI Modules";
        $this->initialize();
    }

    public function addSources() {
        $sys = new \Model\SystemDetectionAllOS() ;
        $sv = $sys->version ;
        $devCode = $this->getDevCode($sv) ;
        $fp = $this->params ;
        $fileFactory = new \Model\File();
        $fp["file"] = "/etc/apt/sources.list" ;
        $fp["search"] = "deb http://us.archive.ubuntu.com/ubuntu/ {$devCode} multiverse" ;
        $file = $fileFactory->getModel($fp) ;
        $res[] = $file->performShouldHaveLine();
        $fp["search"] = "deb-src http://us.archive.ubuntu.com/ubuntu/ {$devCode} multiverse" ;
        $file = $fileFactory->getModel($fp) ;
        $res[] = $file->performShouldHaveLine();
        $fp["search"] = "deb http://us.archive.ubuntu.com/ubuntu/ {$devCode}-updates multiverse" ;
        $file = $fileFactory->getModel($fp) ;
        $res[] = $file->performShouldHaveLine();
        $fp["search"] = "deb-src http://us.archive.ubuntu.com/ubuntu/ {$devCode}-updates multiverse" ;
        $file = $fileFactory->getModel($fp) ;
        $res[] = $file->performShouldHaveLine();
        return (!in_array(false, $res)) ;
    }

    public function getDevCode($code) {
        $ubuntuDevCodeNames = array(
            "11.04" => "natty" ,
            "11.10" => "oneiric" ,
            "12.04" => "precise",
            "12.10" => "quantal",
            "13.04" => "raring",
            "13.10" => "saucy",
            "14.04" => "trusty",
            "14.10" => "utopic",
            "15.04" => "vivid",
            "15.10" => "wily",
            "16.04" => "xenial",
            "16.10" => "kylin",
        ) ;
        return $ubuntuDevCodeNames[$code] ;
    }

    public function apacheReload() {
        $serviceFactory = new \Model\Service();
        $serviceManager = $serviceFactory->getModel($this->params) ;
        $serviceManager->setService("apache2");
        $serviceManager->reload();
    }


}
