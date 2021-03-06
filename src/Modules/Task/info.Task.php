<?php

Namespace Info;

class TaskInfo extends PTConfigureBase {

  public $hidden = false;

  public $name = "Task Wrapper - easily repeatable tasks";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    $ray = array( "Task" =>  array_merge(
        $this->getModuleTasks(),
        $this->getTaskfileTasks(),
        array("list", "help")
    ) );
    return $ray ;
  }

  public function routeAliases() {
    return array("task"=>"Task");
  }

  public function helpDefinition() {
    $help = <<<"HELPDATA"
  This module provides a way to aggregate functionality into simple to access task commands.

  Task, task

        - list
        List available tasks
        example: ptconfigure task list --yes
        example: ptconfigure task list --yes --guess


HELPDATA;
    return $help ;
  }

    protected function getModuleTasks() {
        $extraActions = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        foreach ($infos as $info) {
            if (method_exists($info, "taskActions")) {
                $extraActions = array_merge($extraActions, $info->taskActions()); } }
        return $extraActions ;
    }

    protected static function getTaskfileTasks($taskFile = "Taskfile") {
        if (file_exists($taskFile)) {
            try {
                require_once ($taskFile) ; }
            catch (\Exception $e) {
                echo "Error loading Taskfile $taskFile, error $e\n" ; } }
        else {
            return array() ; }
        $taskObject = new \Model\Taskfile(array("silent"=>true)) ;
        $tftasks = array_keys($taskObject->getTasks()) ;
        return $tftasks ;
    }


}