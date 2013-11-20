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
                    "projectContainerDirectory" => "/var/www/gcapplications/staging/alca-enterprise/alca-enterprise/",
          ) , ) ,
          array ( "Git" => array(
                    "gitCheckoutExecute" => true,
                    "gitCheckoutProjectOriginRepo" => "https://goldencontact:turbulentDeploy1995@bitbucket.org/goldencontact",
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
                    "virtualHostEditorAdditionURL" => "www.staging.alca-enterprise.co.uk",
                    "virtualHostEditorAdditionIp" => "178.63.72.156",
                    "virtualHostEditorAdditionTemplateData" => "",
                    "virtualHostEditorAdditionDirectory" => "/etc/apache2/sites-available",
                    "virtualHostEditorAdditionFileSuffix" => "",
                    "virtualHostEditorAdditionVHostEnable" => true,
                    "virtualHostEditorAdditionSymLinkDirectory" => "/etc/apache2/sites-enabled",
                    "virtualHostEditorAdditionApacheCommand" => "apache2",
          ) , ) ,
          array ( "Version" => array(
                    "versionExecute" => true,
                    "versionAppRootDirectory" => "/var/www/gcapplications/staging/alca-enterprise/alca-enterprise/",
                    "versionArrayPointToRollback" => "0",
                    "versionLimit" => "2",
          ) , ) ,
              array ( "ApacheControl" => array(
                  "apacheCtlRestartExecute" => true,
              ) , ) ,
	      );

	  }


 private function setRevisionFolderName() {
   $this->steps[1]["Git"]["gitCheckoutCustomCloneFolder"] = time() ;
 }


 // This function will set the vhost template for your Virtual Host
 // You need to call this from your constructor
 private function calculateVHostDocRoot() {
   $this->steps[3]["VHostEditor"]["virtualHostEditorAdditionDocRoot"]
       = "/var/www/gcapplications/staging/alca-enterprise/alca-enterprise/".$this->steps[1]["Git"]["gitCheckoutCustomCloneFolder"];
 }

 // This function will set the vhost template for your Virtual Host
 // You need to call this from your constructor
 private function setVHostTemplate() {
   $this->steps[3]["VHostEditor"]["virtualHostEditorAdditionTemplateData"] =
  <<<'TEMPLATE'
 NameVirtualHost ****IP ADDRESS****:80
 <VirtualHost ****IP ADDRESS****:80>
   ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
 	DocumentRoot ****WEB ROOT****/src
 	<Directory ****WEB ROOT****/src>
 		Options Indexes FollowSymLinks MultiViews
 		AllowOverride All
 		Order allow,deny
 		allow from all
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined
 </VirtualHost>

 NameVirtualHost ****IP ADDRESS****:443
 <VirtualHost ****IP ADDRESS****:443>
 	 ServerAdmin webmaster@localhost
 	 ServerName ****SERVER NAME****
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
	</Directory>
  ErrorLog /var/log/apache2/error.log
  CustomLog /var/log/apache2/access.log combined
  </VirtualHost>
TEMPLATE;
}


}
