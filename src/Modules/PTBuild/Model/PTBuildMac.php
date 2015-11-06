<?php

Namespace Model;

class PTBuildMac extends PTBuildLinux {

    // Compatibility
    public $os = array("Darwin") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
    }

    public function setpostinstallCommands() {
        $ray = array( ) ;
        if (isset($this->params["with-webfaces"]) && $this->params["with-webfaces"]==true) {
            $vhestring = '';
            $vheipport = '';
            if (isset($this->params["vhe-url"])) { $vhestring = '--vhe-url='.$this->params["vhe-url"] ; }
            if (isset($this->params["vhe-ip-port"])) { $vheipport = '--vhe-ip-port='.$this->params["vhe-ip-port"] ; }
            $ray[]["command"][] = SUDOPREFIX.PTBCOMM." assetpublisher publish --yes --guess" ;
            $ray[]["command"][] = SUDOPREFIX."sh ".$this->getMacUserShellAutoPath() ;
            $ray[]["command"][] = SUDOPREFIX.PTCCOMM." auto x --af=".$this->getMacPortsAutoPath() ;
            $ray[]["command"][] = SUDOPREFIX.PTCCOMM." auto x --af=".$this->getConfigureAutoPath() ;
            $ray[]["command"][] = SUDOPREFIX.PTDCOMM." auto x --af=".$this->getDeployAutoPath(). " $vhestring $vheipport" ; }
        $this->postinstallCommands = $ray ;
    }

    public function getMacUserShellAutoPath() {
        $path = dirname(dirname(__FILE__)).DS.'Scripts'.DS.'create-mac-user.sh' ;
        $this->executeAsShell("sh $path");
        return $path ;
    }

    public function getMacPortsAutoPath() {
        $path = dirname(dirname(__FILE__)).DS.'Autopilots'.DS.'PTConfigure'.DS.'macports.php' ;
        return $path ;
    }

}