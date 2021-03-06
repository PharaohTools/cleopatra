<?php

Namespace Model;

class VultrAllBoxesDestroy extends BaseVultrAllOS {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("BoxDestroyAll") ;

    public function destroyAllBoxes() {
        if ($this->askForOverwriteExecute() != true) { return false; }
        $this->accessToken = $this->askForVultrAccessToken();
        $doFactory = new \Model\Vultr();
        $listParams = array("yes" => true, "guess" => true, "type" => "droplets") ;
        $doListing = $doFactory->getModel($listParams, "Listing") ;
        $allBoxes = $doListing->askWhetherToListData();

        foreach($allBoxes->droplets as $box) {
            $serverData["dropletID"] = $box->id ;
            $responses[] = $this->destroyServerFromVultr($serverData) ; }
        return true ;

    }

    private function askForOverwriteExecute() {
        if (isset($this->params["yes"]) && $this->params["yes"]==true) { return true ; }
        $question = 'Destroy All Vultr Cloud Server Boxes? (Careful!)';
        return self::askYesOrNo($question);
    }

    private function destroyServerFromVultr($serverData) {
        $callVars = array() ;
        $callVars["droplet_id"] = $serverData["dropletID"];
        $curlUrl = $this->_apiURL."droplets/{$callVars["droplet_id"]}" ;
        $callOut = $this->vultrCall($callVars, $curlUrl,'DELETE');
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Request for destroying Droplet {$callVars["droplet_id"]} complete", $this->getModuleName()) ;
        return $callOut ;
    }

}