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
        $this->setVHostTemplate();
    }

    /* Steps */
    private function setSteps() {

	    $this->steps =
        array(
              array ( "Project" => array(
                    "projectInitializeExecute" => true,
              ) , ) ,
              array ( "HostEditor" => array(
                    "hostEditorAdditionExecute" => true,
                    "hostEditorAdditionIP" => "178.63.72.156",
                    "hostEditorAdditionURI" => "www.staging.alca-enterprise.co.uk.local",
              ) , ) ,
              array ( "VHostEditor" => array(
                    "virtualHostEditorAdditionExecute" => true,
                    "virtualHostEditorAdditionDocRoot" => "/var/www/gcapplications/staging/alca-enterprise/alca-enterprise/",
                    "virtualHostEditorAdditionURL" => "www.staging.alca-enterprise.co.uk.local",
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
                        "dbConfigureDBUser" => "alca_st_user",
                        "dbConfigureDBPass" => "alca_st_pass",
                        "dbConfigureDBName" => "alca_st_db",
                        "dbConfigurePlatform" => "joomla30",
              ) , ) ,
            array ( "ApacheControl" => array(
                "apacheCtlRestartExecute" => true,
            ) , ) ,
	      );

	  }


 // This function will set the vhost template for your Virtual Host
 // You need to call this from your constructor
 private function setVHostTemplate() {
   $this->steps[2]["VHostEditor"]["virtualHostEditorAdditionTemplateData"] =
  <<<'TEMPLATE'
 NameVirtualHost ****IP ADDRESS****:80
 <VirtualHost ****IP ADDRESS****:80>
   ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
 	DocumentRoot ****WEB ROOT****src
 	<Directory ****WEB ROOT****src>
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
 	 DocumentRoot ****WEB ROOT****src
     SSLEngine on
     SSLCertificateFile /etc/ssl/certs/snakeoil.crt
     SSLCertificateKeyFile /etc/ssl/private/snakeoil.key
   # SSLCertificateChainFile /etc/apache2/ssl/bundle.crt
 	 <Directory ****WEB ROOT****src>
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
