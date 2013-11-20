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
        if ( $this->checkIfFirstInstall() ) {
            $this->changeToFirstInstallValues(); }
        $this->setRevisionFolderName();
        $this->calculateVHostDocRoot();
        $this->setVHostTemplate();
    }

    /* Steps */
    private function setSteps() {
	    $this->steps =
	      array(
          array ( "Project" => array(
                    "projectContainerInitExecute" => true,
                    "projectContainerDirectory" => "/var/www/gcapplications/staging/bluevip/bluevip",
          ) , ) ,
          array ( "Git" => array(
                    "gitCheckoutExecute" => true,
                    "gitCheckoutProjectOriginRepo" => "https://phpengine:codeblue041291@bitbucket.org/phpengine/bluevip.git",
                    "gitCheckoutCustomCloneFolder" => "",
                    "gitCheckoutCustomBranch" => "staging",
                    "gitCheckoutWebServerUser" => "www-data",
          ) , ) ,
          array ( "Project" => array(
                    "projectInitializeExecute" => true,
          ) , ) ,
          array ( "VHostEditor" => array(
                    "virtualHostEditorAdditionExecute" => true,
                    "virtualHostEditorAdditionDocRoot" => "",
                    "virtualHostEditorAdditionURL" => "www.staging.bluevip.co.uk",
                    "virtualHostEditorAdditionIp" => "178.63.72.156",
                    "virtualHostEditorAdditionTemplateData" => "",
                    "virtualHostEditorAdditionDirectory" => "/etc/apache2/sites-available",
                    "virtualHostEditorAdditionFileSuffix" => "",
                    "virtualHostEditorAdditionVHostEnable" => true,
                    "virtualHostEditorAdditionSymLinkDirectory" => "/etc/apache2/sites-enabled",
                    "virtualHostEditorAdditionApacheCommand" => "apache2",
          ) , ) ,
          array ( "DBConfigure" => array(
                    "dbResetExecute" => true,
                    "dbResetPlatform" => "joomla30",
          ) , ) ,
          array ( "DBConfigure" => array(
                    "dbConfigureExecute" => true,
                    "dbConfigureDBHost" => "127.0.0.1",
                    "dbConfigureDBUser" => "bvip_st_user",
                    "dbConfigureDBPass" => "bvip_st_pass",
                    "dbConfigureDBName" => "bvip_st_db",
                    "dbConfigurePlatform" => "joomla30",
          ) , ) ,
          array ( "Version" => array(
                    "versionExecute" => true,
                    "versionAppRootDirectory" => "/var/www/gcapplications/staging/bluevip/bluevip",
                    "versionArrayPointToRollback" => "0",
                    "versionLimit" => "3",
          ) , ) ,
	      );
	  }


private function setRevisionFolderName() {
  $this->steps[1]["Git"]["gitCheckoutCustomCloneFolder"] = time() ;
}

// This function will check if this is the first install
// You need to call this from your constructor
private function checkIfFirstInstall() {
  if (file_exists($this->steps[0]["Project"]["projectContainerDirectory"])) { return false; }
  else { return true; }
}

// This function will set the vhost template for your Virtual Host
// You need to call this from your constructor
private function calculateVHostDocRoot() {
  $this->steps[3]["VHostEditor"]["virtualHostEditorAdditionDocRoot"] =
    $this->steps[0]["Project"]["projectContainerDirectory"].'/current';
}

private function changeToFirstInstallValues() {
  $stepsStart = array_slice($this->steps, 0, 6, true);
  $stepsMid =
    array ( "DBInstall" => array(
      "dbInstallExecute" => true,
      "dbInstallDBHost" => "127.0.0.1",
      "dbInstallDBUser" => "bvip_st_user",
      "dbInstallDBPass" => "bvip_st_pass",
      "dbInstallDBName" => "bvip_st_db",
      "dbInstallDBRootUser" => "gcStagingAdmin",
      "dbInstallDBRootPass" => "gcStaging548989263592",
    ) , ) ;
  $stepsStart[] = $stepsMid;
  $stepsEnd = array_slice($this->steps, 6, 1, true);
  $newSteps = array_merge($stepsStart, $stepsEnd) ;
  $this->steps = $newSteps;
}

 // This function will set the vhost template for your Virtual Host
 // You need to call this from your constructor
private function setVHostTemplate() {
   $serverAlias = str_replace("www", "*", $this->steps[3]["VHostEditor"]["virtualHostEditorAdditionURL"]);
   $this->steps[3]["VHostEditor"]["virtualHostEditorAdditionTemplateData"] =
  <<<"TEMPLATE"
  NameVirtualHost ****IP ADDRESS****:80
  <VirtualHost ****IP ADDRESS****:80>
    ServerAdmin webmaster@localhost
 	  ServerName ****SERVER NAME****
    ServerAlias $serverAlias
 	  DocumentRoot ****WEB ROOT****/src
 	  <Directory ****WEB ROOT****/src>
 		  Options Indexes FollowSymLinks MultiViews
 		  AllowOverride All
 		  Order allow,deny
 		  allow from all
      AuthUserFile /etc/apache2/gchtpass/staging.conf
      AuthName "Blue VIP Staging Site"
      AuthType basic
      require valid-user
 	  </Directory>
    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
  </VirtualHost>

  NameVirtualHost ****IP ADDRESS****:443
  <VirtualHost ****IP ADDRESS****:443>
 	  ServerAdmin webmaster@localhost
 	  ServerName ****SERVER NAME****
    ServerAlias $serverAlias
 	  DocumentRoot ****WEB ROOT****/src
    # SSLEngine on
 	  # SSLCertificateFile /etc/apache2/ssl/ssl.crt
    # SSLCertificateKeyFile /etc/apache2/ssl/ssl.key
    # SSLCertificateChainFile /etc/apache2/ssl/bundle.crt
 	  <Directory ****WEB ROOT****/src>
 		  Options Indexes FollowSymLinks MultiViews
  		AllowOverride All
		  Order allow,deny
	  	allow from all
      AuthUserFile /etc/apache2/gchtpass/staging.conf
      AuthName "Blue VIP Staging Site"
      AuthType basic
      require valid-user
  	</Directory>
    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
  </VirtualHost>
TEMPLATE;
}


}
