<?php

Namespace Info;

class GitBucketInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Git Bucket - The Git SCM Management Web Application";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "GitBucket" =>  array_merge(parent::routesAvailable(), array("install") ) );
    }

    public function routeAliases() {
      return array("gitbucket"=>"GitBucket", "git-bucket"=>"GitBucket");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module allows you to install a full Git Bucket installation on to a server
  The dependencies for GitBucket are also installed.

  GitBucket, gitbucket, git-bucket

        - install
        Installs the latest version of GitBucket on a system
        example: ptconfigure gitbucket install

HELPDATA;
      return $help ;
    }

}