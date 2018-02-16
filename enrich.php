<?php

/*
 * enrich-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

require __DIR__."/resources/Enrich.php";
require __DIR__."/resources/Verify.php";

class Enrich {
  private $DEFAULT_REST_HOST = "https://api.enrichdata.com";
  private $DEFAULT_REST_BASE = "/v1";
  private $DEFAULT_TIMEOUT = 40000;

  public function __construct() {
    $this->auth = [];

    $this->_rest = new RestClient([
      "user_agent"   => "enrich-api-php/1.2.0",
      "base_url"     => $this->DEFAULT_REST_HOST.$this->DEFAULT_REST_BASE,
      "content_type" => "application/json",

      "curl_options" => [
        CURLOPT_CONNECTTIMEOUT => $DEFAULT_TIMEOUT,
        CURLOPT_TIMEOUT => $DEFAULT_TIMEOUT,
        CURLOPT_SSL_VERIFYHOST => 2
      ],

      "headers"      => [
        "Content-Type" => "application/json"
      ]
    ]);

    $this->_rest->register_decoder("json", function($data) {
      return json_decode($data, TRUE);
    });

    $this->enrich = new EnrichResource($this);
    $this->verify = new VerifyResource($this);
  }

  public function setRestHost($host) {
    $this->_rest->set_option("base_url", $host);
  }

  public function authenticate($identifier, $key) {
    $this->_rest->set_option("username", $identifier);
    $this->_rest->set_option("password", $key);
  }

  public function _get($resource, $query) {
    return $this->_doGet($resource, $query);
  }

  private function _doGet($resource, $query) {
    return $this->_rest->get($resource, $query)->decode_response();
  }
}

?>
