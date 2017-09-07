<?php

/*
 * graphmob-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

require __DIR__."/ressources/Enrich.php";
require __DIR__."/ressources/Search.php";
require __DIR__."/ressources/Verify.php";

class Graphmob {
  public $DEFAULT_REST_HOST = "https://api.graphmob.com";
  public $DEFAULT_REST_BASE_PATH = "/v1/";

  public function __construct() {
    $this->auth = array();

    $this->_rest = new RestClient(array(
      "base_url"     => $this->DEFAULT_REST_HOST.$this->DEFAULT_REST_BASE_PATH,
      "headers"      => ["Content-Type" => "application/json"],
      "content_type" => "application/json"
    ));

    $this->_rest->register_decoder("json", function($data) {
      return json_decode($data, TRUE);
    });

    $this->enrich = new GraphmobEnrich($this);
    $this->search = new GraphmobSearch($this);
    $this->verify = new GraphmobVerify($this);
  }

  public function setRestHost($host) {
   $this->_rest->set_option("base_url", $host);
  }

  public function authenticate($identifier, $key) {
    $this->_rest->set_option("username", $identifier);
    $this->_rest->set_option("password", $key);
  }
}

?>
