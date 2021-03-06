<?php

Namespace Model;

class FirewallCentos extends FirewallUbuntu {

    // Compatibility
    public $os = array("Linux") ;
    public $linuxType = array("Redhat") ;
    public $distros = array("CentOS") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
        $this->actionsToMethods = $this->setActionsToMethods() ;
        $this->installCommands = array(
            array("method"=> array("object" => $this, "method" => "packageAdd", "params" => array("Yum", "firewalld")) ),
            array("method"=> array("object" => $this, "method" => "ensureRunning", "params" => array())),
        );
        $this->uninstallCommands = array(
            array("method"=> array("object" => $this, "method" => "packageRemove", "params" => array("Yum", "firewalld"))),
        );
        $this->programDataFolder = "";
        $this->programNameMachine = "firewall"; // command and app dir name
        $this->programNameFriendly = "! Firewall !"; // 12 chars
        $this->programNameInstaller = "Firewall";
        $this->statusCommand = "which firewalld" ;
        $this->initialize();
    }

    public function setDefaultPolicyParam() {
        $opts =  array("allow", "deny", "reject") ;
        if (isset($this->params["policy"]) && in_array($this->params["policy"], $opts)) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Policy param for set default must be allow, deny or reject") ;
            $defaultPolicy = $this->params["policy"]; }
        else {
            $defaultPolicy = self::askForArrayOption("Enter Policy:", $opts, true); }
        $policiesToZones = array("allow"=>"public", "deny"=>"drop", "reject"=>"");
        $this->defaultPolicy = $policiesToZones[$defaultPolicy] ;
    }

    public function enable() {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Attempting to Enable firewalld", $this->getModuleName()) ;
        $out = $this->executeAndGetReturnCode(SUDOPREFIX."systemctl enable firewalld");
        if ($out !== 0 ) {
            $logging->log("Firewall Enable command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function ensureRunning() {
        $serviceFactory = new \Model\Service();
        $service = $serviceFactory->getModel($this->params);
        $service->setService("firewalld");
        return $service->ensureRunning() ;
    }

    public function disable() {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Attempting to Disable firewalld", $this->getModuleName()) ;
        $out = $this->executeAndGetReturnCode(SUDOPREFIX."systemctl disable firewalld");
        if ($out !== 0 ) {
            $logging->log("Firewall Disable command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function reloadFirewall() {
        if ($this->disable()==false) {return false;}
        if ($this->enable()==false) {return false;}
        return true;
    }

    public function allow() {
        $out = $this->executeAndOutput( SUDOPREFIX."firewall-cmd --add-port={$this->firewallRule}");
        if (strpos($out, "Skipping adding existing rule") != false ||
            strpos($out, "Rule added") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Allow now command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        $out = $this->executeAndOutput(SUDOPREFIX."firewall-cmd --add-port={$this->firewallRule} --permanent");
        if (strpos($out, "Skipping adding existing rule") != false ||
            strpos($out, "Rule added") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Allow permanent command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function deny() {
        $out = $this->executeAndOutput(SUDOPREFIX."firewall-cmd --remove-port=$this->firewallRule");
        if (strpos($out, "Skipping adding existing rule") != false ||
            strpos($out, "Rule added") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Deny command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function reject() {
        $out = $this->executeAndOutput(SUDOPREFIX."firewall-cmd --remove-port=$this->firewallRule");
        if (strpos($out, "Skipping adding existing rule") != false ||
            strpos($out, "Rule added") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Reject command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function limit() {
        $out = $this->executeAndOutput(SUDOPREFIX."ufw limit $this->firewallRule");
        if (strpos($out, "Skipping adding existing rule") != false ||
            strpos($out, "Rule added") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Limit command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function deleteRule() {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("The Firewall Delete command does nothing on CentOS", $this->getModuleName()) ;
        return true ;
    }

    public function insert() {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("The Firewall Insert command does nothing on CentOS", $this->getModuleName()) ;
        return true ;
    }

    public function resetRule() {
        $out = $this->executeAndOutput("echo y | ".SUDOPREFIX."firewall-cmd reset --force $this->firewallRule");
        if (strpos($out, "Resetting all rules to installed defaults") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall Reset command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }

    public function setDefault() {
        $out = $this->executeAndOutput(SUDOPREFIX."firewall-cmd --set-default-zone=$this->defaultPolicy");
        if (strpos($out, "Default firewall zone changed to '{$this->defaultPolicy}'") != false ) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("Firewall set default policy command did not execute correctly", $this->getModuleName()) ;
            return false ; }
        return true ;
    }


}