<?php

Namespace Info;

class ApacheModulesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Apache Modules - Commonly used modules for Apache";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ApacheModules" =>  array_merge(parent::routesAvailable(), array("version") ) );
    }

    public function routeAliases() {
      return array(
          "apache-modules"=>"ApacheModules",
          "apachemods"=>"ApacheModules",
          "apachemodules"=>"ApacheModules" );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module is part of the Default Distribution and provides you  with a method by which you can configure Application Settings.
  You can configure default application settings

  ApacheModules, apachemods, apache-modules, apachemodules

        - install
        Installs common apache Modules
        example: ptconfigure apache-modules install

HELPDATA;
      return $help ;
    }

}