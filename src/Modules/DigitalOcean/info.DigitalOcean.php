<?php

Namespace Info;

class DigitalOceanInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Digital Ocean Server Management Functions";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "DigitalOcean" => array_merge(parent::routesAvailable(), array("save-ssh-key",
          "box-add", "box-remove", "box-destroy", "box-destroy-all", "list") ) );
    }

    public function routeAliases() {
      return array("digitaloceanv1"=>"DigitalOcean", "digital-ocean-v1"=>"DigitalOcean");
    }

    public function boxProviderName() {
        return "DigitalOcean";
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This is an extension provided for Handling Servers on Digital Ocean.

    DigitalOcean, digitaloceanv1, digital-ocean-v1

        - box-add
        Lets you add boxes to Digital Ocean, and adds them to your papyrusfile
        example: ptconfigure digital-ocean box-add
                    --yes
                    --server-prefix=webservers # common prefix to use for these instances, none is fine
                    --environment-name=demodave # papyrusfile environment to add instances to - must already exist
                    --box-amount=1 # number of instances to create
                    --size-id=512mb # size of instances
                    --image-id=7111343 # image id to create instances with
                    --region-id=lon1 # region to create instance in
                    --wait-until-active # wait until box has an ip address active before moving to the next one (You
                        usually want this, unless you are asynchronously populating the connection details)
                    --key-path # location of private key path. Keystore values accepted

        - box-destroy
        Will destroy box/es in an environment for you, and remove them from the papyrus file
        example: ptconfigure digital-ocean-v2 box-destroy
                    --yes
                    --guess
                    --env=testenv # name of the environment to destroy boxes in
                    --destroy-box-id=3 # ID of single box in environment to destroy. This or below param must be set
                    --destroy-all-boxes # Destroy all boxes in environment. This or above param must be set

        - box-destroy-all
        Will destroy all boxes in your digital ocean account - Careful - its irreversible
        example: ptconfigure digital-ocean box-destroy-all --yes --guess

        - save-ssh-key
        Will let you save a local ssh key to your Digital Ocean account, so you can ssh in to your nodes
        securely and without a password
        example: ptconfigure digital-ocean save-ssh-key
                    --yes
                    --path="/home/dave/.ssh/bastion.pub"
                    --name="bastion"

        - list
        Will display data about your digital ocean account
        example: ptconfigure digital-ocean list
        example: ptconfigure digital-ocean list --yes
                    --guess # use project saved connection details if possible
                    --type=sizes # droplets, sizes, images, domains, regions, ssh_keys

HELPDATA;
      return $help ;
    }

}