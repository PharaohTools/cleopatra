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
    }

    /* Steps */
    private function setSteps() {

	    $this->steps =
	      array(
          array ( "Version" => array(
                    "versionExecute" => true,
                    "versionAppRootDirectory" => "/var/www/gcapplications/staging/alca-enterprise/alca-enterprise/",
                    "versionArrayPointToRollback" => "1",
                    "versionLimit" => "2",
          ) , ) ,
              array ( "ApacheControl" => array(
                  "apacheCtlRestartExecute" => true,
              ) , ) ,
	      );

	  }


}
