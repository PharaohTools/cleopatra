<?php

Namespace Info;

class RubyBDDInfo extends PTConfigureBase {

  public $hidden = false;

  public $name = "Ruby BDD Suite - Install Common Gems for Cucumber, Calabash, Capybara and Saucelabs";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    return array( "RubyBDD" =>  array_merge(parent::routesAvailable(), array("install") ) );
  }

  public function routeAliases() {
    return array("rubybdd"=>"RubyBDD", "ruby-bdd"=>"RubyBDD");
  }

  public function helpDefinition() {
    $help = <<<"HELPDATA"
  This module allows you to install Ruby RVM.

  RubyBDD, rubybdd, ruby-bdd

        - install
        Installs Ruby BDD Gems
        example: ptconfigure ruby-bdd install

HELPDATA;
    return $help ;
  }

}