<?php

/*************************************
*      Generated Autopilot file      *
*     ---------------------------    *
*Autopilot Generated By Dapperstrano *
*     ---------------------------    *
*************************************/

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    public $steps ;

    public function __construct() {
	      $this->setSteps();
        $this->setSSHData();
    }

    /* Steps */
    private function setSteps() {

	    $this->steps =
	      array(
          array ( "InvokeSSH" => array(
                    "sshInvokeSSHDataExecute" => true,
                    "sshInvokeSSHDataData" => "",
                                "sshInvokeServers" => array(
                      array("target" => "178.63.72.156", "user" => "gcdeployman", "pword" => "turbulentDeploy1995",  ),
 ),
          ) , ) ,
	      );

	  }


//
// This function will set the sshInvokeSSHDataData variable with the data that
// you need in it. Call this in your constructor
//
  private function setSSHData() {
    $step = "0";
    $this->steps[$step]["InvokeSSH"]["sshInvokeSSHDataData"] = <<<"SSHDATA"
cd /tmp
git clone -b production https://phpengine:codeblue041291@bitbucket.org/phpengine/bluevip.git
cd bluevip
git show HEAD:build/config/dapperstrano/autopilots/auto-prod-revision-install.php > /tmp/autopilot-bvip-production-install.php
rm -rf /tmp/bluevip
cd /tmp
sudo dapperstrano autopilot execute autopilot-bvip-production-install.php
sudo jrush jfeature feature-install --config-file=/var/www/gcapplications/live/bluevip/bluevip/current/src/configuration.php --feature-file=/var/www/gcapplications/live/bluevip/bluevip/current/src/administrator/components/com_gcworkflowdeploy/feature_store/ZJHIR59P6OL196AF_1369950600.zip
sudo jrush jfeature feature-pull --config-file=/var/www/gcapplications/live/bluevip/bluevip/current/src/configuration.php --pull-unique-time=ZJHIR59P6OL196AF_1369950600
sudo jrush cache site-clear --config-file=/var/www/gcapplications/live/bluevip/bluevip/current/src/configuration.php
sudo jrush jfeature folder-defaults --config-file=/var/www/gcapplications/live/bluevip/bluevip/current/src/configuration.php
sudo chown -R www-data /var/www/gcapplications/live/bluevip/bluevip/current/src
sudo rm autopilot-bvip-production-install.php
SSHDATA;
  }

}
