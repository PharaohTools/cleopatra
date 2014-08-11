<?php

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    public $steps ;
    protected $myUser ;

    public function __construct() {
        $this->setSteps();
    }

    /* Steps */
    private function setSteps() {

        $this->steps =
            array(
                array ( "Logging" => array( "log" => array( "log-message" => "Lets begin Configuration of a Phlagrant Box"),),),

                // All Pharoes
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Cleopatra" ),),),
                array ( "Cleopatra" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Dapperstrano" ),),),
                array ( "Dapperstrano" => array( "ensure" => array(),),),

                // Standard Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some standard tools are installed" ),),),
                array ( "StandardTools" => array( "ensure" => array(),),),

                // Git Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some git tools are installed" ),),),
                array ( "GitTools" => array( "ensure" => array(),),),

                // Git Key Safe
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Git SSH Key Safe version is are installed" ),),),
                array ( "GitKeySafe" => array( "ensure" => array(),),),

                // PHP Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common PHP Modules are installed" ),),),
                array ( "PHPModules" => array( "ensure" => array(),),),

                // Apache
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Apache Server is installed" ),),),
                array ( "ApacheServer" => array( "ensure" =>  array("version" => "2.2"), ), ),

                // Apache Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common Apache Modules are installed" ),),),
                array ( "ApacheModules" => array( "ensure" => array(),),),

                // Restart Apache for new modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets restart Apache for our PHP and Apache Modules" ),),),
                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "dapperstrano ApacheCtl restart --yes",
                ) ) ),

                //Mysql
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Mysql Server is installed" ),),),
                array ( "MysqlServer" => array( "ensure" =>  array(
                    "version" => "5",
                    "version-operator" => "+"
                ), ), ),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure a Mysql Admin User is installed"),),),
                array ( "MysqlAdmins" => array( "install" => array(
                    "root-user" => "root",
                    "root-pass" => "cleopatra",
                    "new-user" => "root",
                    "new-pass" => "root",
                    "mysql-host" => "127.0.0.1"
                ) ) ),

                array ( "Logging" => array( "log" => array(
                    "log-message" => "Configuring your Phlagrant VM complete"
                ),),),

            );

    }

}