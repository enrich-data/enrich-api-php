<?php

/*
 * graphmob-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

require __DIR__."/resources/Enrich.php";
require __DIR__."/resources/Search.php";
require __DIR__."/resources/Verify.php";

class Graphmob {
  private $DEFAULT_REST_HOST = "https://api.graphmob.com";
  private $DEFAULT_REST_BASE = "/v1";
  private $DEFAULT_TIMEOUT = 5000;

  private $CREATED_STATUS_CODE = 201;
  private $NOT_FOUND_STATUS_CODE = 404;
  private $CREATED_RETRY_COUNT_MAX = 2;

  public function __construct() {
    $this->auth = [];

    $this->_rest = new RestClient([
      "user_agent"   => "graphmob-api-php/1.0.0",
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

  public function _get($resource, $query) {
    return $this->_doGet($resource, $query, 0, 0);
  }

  private function _doGet($resource, $query, $retryCount, $holdForSeconds) {
    // Abort?
    if ($retryCount > $this->CREATED_RETRY_COUNT_MAX) {
      return [
        "error" => [
          "reason" => "not_found",
          "message" => (
            "The requested item was not found, after attempted discovery."
          )
        ]
      ];
    } else {
      // Hold.
      sleep($holdForSeconds);

      $response = $this->_rest->get($resource, $query);

      // Re-schedule request? (created)
      if ($response->info->http_code === $this->CREATED_STATUS_CODE ||
          ($retryCount > 0 && $response->info->http_code ===
            $this->NOT_FOUND_STATUS_CODE)) {
        if ($response->headers->retry_after) {
          $holdForSeconds = intval($response->headers->retry_after);
        }

        return $this->_doGet(
          $resource, $query, $retryCount + 1, $holdForSeconds
        );
      }

      return $response->decode_response();
    }
  }
}

?>
