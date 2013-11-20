<?php

Namespace Controller ;

class PapyrusEditor extends Base {

    public function execute($pageVars) {

        $this->content["route"] = $pageVars["route"];
        $this->content["messages"] = $pageVars["messages"];
        $action = $pageVars["route"]["action"];

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Editor") ;
        // if we don't have an object, its an array of errors
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        if ($action=="help") {
            $helpModel = new \Model\Help();
            $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
            return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

        echo "\n\ndaveyo\n\n" ;

        return null ;
    }

}