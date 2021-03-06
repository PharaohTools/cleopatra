<?php

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
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Lets begin Preparation of PHP on environment <%tpl.php%>env_name</%tpl.php%>",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "About to send php-zip-ensure.sh to ensure PHP and Zip",
                ), ), ),
                array ( "SFTP" => array( "put" => array(
                    "source" => "{$this->appHomeDir}/src/Modules/PHPPrep/Scripts/php-zip-ensure.sh",
                    "remote" => "/tmp/php-zip-ensure.sh",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "PHP Ensure script transferred, lets execute it",
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => "sh /tmp/php-zip-ensure.sh",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>"
                ), ) , ) ,
                array ( "Logging" => array( "log" => array(
                    "log-message" => "PHP Ensure script executed, lets prepare a PTConfigure Zip file",
                ), ) , ) ,
                array ( "CleoZip" => array( "ensure-exists" => array(), ) , ) ,
                array ( "Logging" => array( "log" =>array(
                    "log-message" => "PTConfigure Zip file exists, lets transfer it",
                ), ), ),
                array ( "SFTP" => array( "put" => array(
                    "source" => "{$this->appHomeDir}/src/Modules/CleoZip/Files/Cleo.zip",
                    "remote" => "/tmp/Cleo.zip",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                     "log-message" => "File transferred, lets unzip it",
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => "unzip /tmp/ptconfigure.zip",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "File unzipped, lets install PTConfigure",
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => "php /tmp/ptconfigure/ptconfigure/install-silent",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "PTConfigure installed, lets send our preparation Autopilot",
                ), ), ),
                array ( "SFTP" => array( "put" => array(
                    "source" => "{$this->appHomeDir}/src/Modules/BasePHPEnsure/Autopilots/php-git-ensure.sh",
                    "remote" => "/tmp/php-git-ensure.php",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Autopilot script transferred, lets execute it",
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => "sudo ptconfigure autopilot execute /tmp/php-git-ensure.php",
                    "environment-name" => "<%tpl.php%>env_name</%tpl.php%>",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "PHP and Git Ensures are complete",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Preparation of PHP on environment <%tpl.php%>env_name</%tpl.php%> complete",
                ), ), ),
        );

    }

}
