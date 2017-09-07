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
  public $DEFAULT_REST_BASE_PATH = "/v1";

  private function __construct() {
    $this->auth = [];

    $this->_rest = new RestClient([
      "user_agent"   => "graphmob-api-php/1.0.0",
      "base_url"     => $this->DEFAULT_REST_HOST.$this->DEFAULT_REST_BASE_PATH,
      "content_type" => "application/json",
      "format"       => "json",

      "headers"      => [
        "Content-Type" => "application/json"
      ]
    ]);

    $this->enrich = new GraphmobEnrich($this);
    $this->search = new GraphmobSearch($this);
    $this->verify = new GraphmobVerify($this);
  }

  protected function _get($resource, $query) {
    return $this->parent->_rest->get($resource, $query)->decode_response();
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
